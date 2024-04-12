<?php

include "../settings/connection.php";
global $conn;

$data = json_decode( file_get_contents('php://input'), true );
$roomId = $data['roomID'];

$query = "DELETE FROM Rooms WHERE Room_ID = '$roomId'";
$create_record = $conn->prepare($query);
if ($create_record->execute()) {
    $response = ["status" => 1, "message" => "Deleted successfully"];
} else {
    $response = ["status" => 0, "message" => "Deletion failed"];
}

mysqli_close($conn);
echo json_encode($response);
exit();

?>
