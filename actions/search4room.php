<?php

include "../settings/connection.php";
global $conn;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the search query
    $search = $_GET["search"];

    // SQL query to search for room type
    $sql = "SELECT 
                Room_Type, 
                Price_Per_Night, 
                COUNT(Room_ID) AS Available_Rooms, 
                Img_Src,
                Occupancy
            FROM RoomTypes
            LEFT JOIN Rooms ON RoomTypes.RoomType_ID = Rooms.RoomType_ID
            WHERE Room_Type LIKE '%$search%'
            GROUP BY Room_Type";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if any result is found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Start building the HTML content
        $htmlContent = "<div class='room-container' id='" . $row['Room_Type'] . "' onclick='bookThisRoom(this)'>";
        $htmlContent .= "<img src='" . $row['Img_Src'] . "' alt='" . $row['Room_Type'] . " room preview' id='" . $row['Room_Type'] . "'/>";
        $htmlContent .= "<div id='details'>";
        $htmlContent .= "<p>Room Type: " . $row['Room_Type'] . "</p><br>";
        $htmlContent .= "<p>Price ($): " . $row['Price_Per_Night'] . "</p><br>";
        $htmlContent .= "<p>Occupancy: " . $row['Occupancy'] . "</p><br>";
        $htmlContent .= "<p>Available Rooms: " . $row['Available_Rooms'] . "</p><br>";
        $htmlContent .= "</div>";
        $htmlContent .= "</div>";

        // Output the HTML content
        $response = [
            "status" => 1,
            "message" => "result found",
            "result" => $htmlContent
        ];
        echo json_encode($response);

    } else {
        $htmlContent = "<h3>No result found</h3>";
        $response = [
            "status" => 0,
            "message" => "No results found.",
            "result" => $htmlContent
        ];
        echo json_encode($response);
    }

    // Close database connection
    mysqli_close($conn);
    exit();
}
?>