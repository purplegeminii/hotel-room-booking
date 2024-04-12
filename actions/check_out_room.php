<?php

session_start();
include "../settings/connection.php";
global $conn;

$user_id = $_SESSION['user_id'];

$data = json_decode( file_get_contents('php://input'), true );
$roomType = $data['roomType'];
$totalBookings = $data['totalBookings'];
$response = [];


// Start the transaction
mysqli_begin_transaction($conn);

// Update the availability of rooms to '1'
$updateAvailabilityQuery = "
        UPDATE Rooms
        SET Availability = '1'
        WHERE RoomType_ID = (
            SELECT RoomType_ID
            FROM RoomTypes
            WHERE Room_Type = '$roomType'
        )
        AND Room_ID IN (
            SELECT Room_ID
            FROM (
                SELECT Room_ID
                FROM Rooms
                WHERE RoomType_ID = (
                    SELECT RoomType_ID
                    FROM RoomTypes
                    WHERE Room_Type = '$roomType'
                )
                AND Availability = '0'
                LIMIT $totalBookings
            ) AS unavailable_rooms
        )
    ";

$updateAvailabilityResult = mysqli_query($conn, $updateAvailabilityQuery);

// Check if the update was successful
//if (!$updateAvailabilityResult) {
//    $response = ["status"=>0,"message"=>"Failed to checked out."];
//}

// Update the check-out date in the bookings table
$updateCheckOutQuery = "
        UPDATE Bookings
        SET Check_Out_Date = NOW()
        WHERE RoomType_ID = (
            SELECT RoomType_ID
            FROM RoomTypes
            WHERE Room_Type = '$roomType'
        )
        AND User_ID = '$user_id'
        AND Check_Out_Date IS NULL
    ";

$updateCheckOutResult = mysqli_query($conn, $updateCheckOutQuery);

// Check if the update was successful
//if (!$updateCheckOutResult) {
//    $response = ["status"=>0,"message"=>"Failed to checked out."];
//}

// Commit the transaction
$result = mysqli_commit($conn);


if ($result) {
    $response = ["status"=>1,"message"=>"Successfully checked out $roomType rooms."];
} else {
    $response = ["status"=>0,"message"=>"Failed to checked out."];
}

echo json_encode($response);
exit();
