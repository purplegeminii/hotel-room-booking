<?php
// Include your database connection file
include "../settings/connection.php";
global $conn;

// Query to fetch sales data from your database
$sql = "SELECT Check_In_Date, Total_Price FROM Bookings";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Array to store the fetched data
    $data = array();

    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add each row to the data array
        $data[] = array(
            'x' => $row['Check_In_Date'],
            'y' => $row['Total_Price']
        );
    }

    // Close the database connection
    mysqli_close($conn);

    // Return the data in JSON format
    echo json_encode($data);
} else {
    // If query fails, return an empty JSON array or handle the error accordingly
    echo json_encode(array());
}

