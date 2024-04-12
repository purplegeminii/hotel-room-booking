
<h1>Remove Room</h1>

<?php
// Include your database connection file
include "../settings/connection.php";
global $conn;

// Query to fetch room details
$sql = "SELECT Rooms.Room_ID, RoomTypes.Room_Type, RoomTypes.Occupancy, RoomTypes.Price_Per_Night, RoomTypes.Img_Src, Rooms.Availability
        FROM Rooms
        INNER JOIN RoomTypes ON Rooms.RoomType_ID = RoomTypes.RoomType_ID";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    ?>
    <table>
        <thead>
        <tr>
            <th>Room Type</th>
            <th>Occupancy</th>
            <th>Price Per Night</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Loop through each row of the result set
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['Room_Type']; ?></td>
                <td><?php echo $row['Occupancy']; ?></td>
                <td><?php echo $row['Price_Per_Night']; ?></td>
                <td><?php echo $row['Availability']; ?></td>
                <td>
                    <button onclick="confirmDelete(<?php echo $row['Room_ID']; ?>)">Delete</button>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
} else {
    echo "No rooms found.";
}

// Close the database connection
mysqli_close($conn);
?>

