<?php

session_start();
include "../settings/connection.php";
global $conn;

$response = [];
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
        WHERE Room_Type = '$roomType' AND Availability = '1'
        GROUP BY Room_Type
        HAVING available_rooms >= '$roomQuantity'";
$result1 = mysqli_query($conn, $sql1);

if ($result1) {
    $sql2 = "
    START TRANSACTION;

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
      );
    
    INSERT INTO Bookings (User_ID, Room_ID, Check_In_Date, Check_Out_Date, Total_Price)
    VALUES ('$user_id', (
        SELECT RoomType_ID
        FROM RoomTypes
        WHERE Room_Type = '$roomType'
    ), NOW(), :checkOutDate, '$roomQuantity', '$total_price');
    
    COMMIT;
";
    $result2 = mysqli_query($conn, $sql2);

} else {
    $response = ["status"=>1, "message"=>"number of rooms not enough to satisfy requested"];
}

echo json_encode($response);
exit();

?>
