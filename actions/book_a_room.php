<?php

session_start();
include "../settings/connection.php";
global $conn;

$response = [
    'status'=>0,
    'message'=>''
];
$user_id = $_SESSION['user_id'];

$booking = array();
$booking = json_decode( file_get_contents('php://input'), true );
$roomType = $booking['roomType'];
$roomPrice = $booking['roomPrice'];
$roomQuantity = $booking['roomQuantity'];

$total_price = $roomPrice * $roomQuantity;

$sql1 = "
        SELECT Room_Type, COUNT(*) AS available_rooms
        FROM Rooms
        INNER JOIN RoomTypes ON Rooms.RoomType_ID = RoomTypes.RoomType_ID
        WHERE RoomTypes.Room_Type = '$roomType' AND Rooms.Availability = '1'
        GROUP BY RoomTypes.Room_Type
        HAVING available_rooms >= '$roomQuantity'";
$result1 = mysqli_query($conn, $sql1);

if ($result1) {

    // Start the transaction
    mysqli_begin_transaction($conn);

    // Update the availability of rooms
    $sqlUpdate = "
    UPDATE Rooms
    SET Availability = '0'
    WHERE RoomType_ID IN (
        SELECT RoomType_ID
        FROM RoomTypes
        WHERE Room_Type = '$roomType'
    )
      AND Room_ID IN (
        SELECT Room_ID
        FROM (
          SELECT Room_ID
          FROM Rooms
          WHERE RoomType_ID IN (
              SELECT RoomType_ID
              FROM RoomTypes
              WHERE Room_Type = '$roomType'
          )
            AND Availability = '1'
          LIMIT $roomQuantity
        ) AS available_rooms
      )";

    $resultUpdate = mysqli_query($conn, $sqlUpdate);

    // Insert booking details
    $sqlInsert = "
    INSERT INTO Bookings (User_ID, RoomType_ID, Check_In_Date, Check_Out_Date, Qty, Total_Price)
    VALUES ('$user_id', (
        SELECT RoomType_ID
        FROM RoomTypes
        WHERE Room_Type = '$roomType'
    ), NOW(), NULL, '$roomQuantity', '$total_price')";

    $resultInsert = mysqli_query($conn, $sqlInsert);

    // Commit the transaction
    $result2 = mysqli_commit($conn);

    if ($result2) {
        $response['status'] = 1;
        $response['message'] = "Successfully booked";
    } else {
        $response['status'] = 0;
        $response['message'] = "Failed to book room";
    }

} else {
    $response['status'] = 0;
    $response['message'] = "number of rooms not enough to satisfy requested";
}

echo json_encode($response);
exit();

?>
