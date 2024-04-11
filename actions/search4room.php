<?php

include "../settings/connection.php";
global $conn;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the search query
    $search = $_GET["search"];

    // Include database connection
    include "../settings/connection.php";

    // SQL query to search for room type
    $sql = "SELECT Room_Type, Price_Per_Night, COUNT(Room_ID) AS Available_Rooms, Img_Src
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
        $htmlContent = "<div class='room-container'>";
        $htmlContent .= "<img src='" . $row['Img_Src'] . "' alt='" . $row['Room_Type'] . " room preview' id='room-image'/>";
        $htmlContent .= "<div id='details'>";
        $htmlContent .= "<p>Room Type: " . $row['Room_Type'] . "</p>";
        $htmlContent .= "<p>Price ($): " . $row['Price_Per_Night'] . "</p>";
        $htmlContent .= "<p>Available Rooms: " . $row['Available_Rooms'] . "</p>";
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
        $response = [
            "status" => 0,
            "message" => "No results found."
        ];
        echo json_encode($response);
    }

    // Close database connection
    mysqli_close($conn);
    exit();
}
?>