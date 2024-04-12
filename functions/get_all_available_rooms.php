<?php

include "../settings/connection.php";
global $conn;

$sql = "SELECT 
            rt.RoomType_ID,
            rt.Room_Type,
            rt.Occupancy,
            rt.Price_Per_Night,
            COUNT(r.Room_ID) AS Available_Rooms,
            rt.Img_Src
        FROM 
            RoomTypes rt
        LEFT JOIN 
            Rooms r ON rt.RoomType_ID = r.RoomType_ID AND r.Availability = '1'
        GROUP BY 
            rt.RoomType_ID, rt.Room_Type, rt.Occupancy, rt.Price_Per_Night";

$result = mysqli_query($conn, $sql);
?>

<?php if (mysqli_num_rows($result) > 0): ?>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <div class="room-container" id="<?php echo $row['Room_Type'] ?>"
                 onclick="bookThisRoom(this)">

                <img src="<?php echo $row['Img_Src'];?>" alt="<?= $row['Room_Type'] ?> room preview"
                    id="<?php echo $row['Room_Type'] ?>"/>
                <div id = "details">
                    <p>Room Type: <?php echo $row['Room_Type']; ?></p><br>
                    <p>Price ($): <?php echo $row['Price_Per_Night']; ?></p><br>
                    <p>Occupancy: <?php echo $row['Occupancy']; ?></p><br>
                    <p>Available Rooms: <?php echo $row['Available_Rooms']; ?></p><br>
                </div>

            </div>

        <?php endwhile; ?>

<?php else: ?>
    <p>All Rooms have been booked.</p>
<?php endif; ?>
