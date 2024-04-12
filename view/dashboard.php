<?php
include "../settings/core.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../css/leftMenu.css">
    <link rel="stylesheet" href="../css/dashboardGlobal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/bookAroom.css">
    <link rel="stylesheet" href="../css/booking_page.css">
</head>
<body>
    <div class="app-container">
        <div class="left-menu">
            <h1 class="app-name">Nav Bar</h1>
            <div class="left-menu-items">
                <a><p onclick="loadContent('../view/YourRoom.php')">Your Room</p></a>
                <a><p onclick="loadContent('../view/BookARoom.php')">Book a room</p></a>
                <a><p onclick="confirmLogout()">Logout</p></a>
            </div>
            <p class="user-name"><?= $_SESSION['fname'] ?></p>
        </div>
        <div id="content">

               <h1>CONTENT</h1>
        </div>
    </div>

    <script src="../js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../js/logout.js"></script>
    <script src="../js/book_a_room.js"></script>

</body>
</html>
