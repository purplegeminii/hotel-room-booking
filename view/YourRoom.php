<?php

session_start();
include "../settings/connection.php";
global $conn;

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            Bookings.User_ID,
            Users.fname,
            Users.lname,
            Bookings.RoomType_ID,
            RoomTypes.Room_Type,
            RoomTypes.Img_Src,
            Bookings.Check_In_Date,
            SUM(Bookings.Qty) AS Total_Bookings,
            SUM(Bookings.Total_Price) AS Total_Price,
            SUM(Bookings.Total_Price) OVER () AS Grand_Total
        FROM 
            Bookings
        INNER JOIN 
            Users ON Bookings.User_ID = Users.User_ID
        INNER JOIN
            RoomTypes ON Bookings.RoomType_ID = RoomTypes.RoomType_ID
        WHERE 
            Users.User_ID = '$user_id'
            AND Bookings.Check_Out_Date IS NULL
        GROUP BY
            Bookings.RoomType_ID, Bookings.Check_In_Date";

$result = mysqli_query($conn, $sql);

$grandTotal = 0;
?>


<h1>Your Booked Room(s)</h1>

<?php if (mysqli_num_rows($result) > 0): ?>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>

        <div id="content3">

            <div class="room-container" id="<?php echo $row['Room_Type'] ?>">

                <img src="<?php echo $row['Img_Src'];?>" alt="<?= $row['Room_Type'] ?> room preview"
                     id="<?php echo $row['Room_Type'] ?>"/>
                <div id = "details">
                    <p>Room Type: <?php echo $row['Room_Type']; ?></p><br>
                    <p id="total-bookings">Total Bookings: <?php echo $row['Total_Bookings']; ?></p><br>
                    <p>Total Price per night: <?php echo $row['Total_Price']; ?></p><br>

                    <button name="<?php echo $row['Room_Type'] ?>" id="check-out" type="button"
                            onclick="handleCheckOut()">
                        CHECK OUT
                    </button>
                </div>

            </div>

        </div>

    <?php endwhile; ?>

<?php else: ?>
    <p>You have no rooms booked</p>
<?php endif; ?>