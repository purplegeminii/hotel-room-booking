<?php
include "../settings/connection.php";
include "../settings/core.php";
global $conn;
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
<!--    <link rel="stylesheet" href="../css/your_room.css">-->
    <link rel="stylesheet" href="../css/hotel_stats.css">
<!--    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>-->
<!--    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">-->
<!--    <script defer src="../js/chart.js"></script>-->
<!--    <script src="../node_modules/chart.js/dist/chart.js"></script>-->
</head>
<body>

    <?php if ($_SESSION['role_id'] === 3): ?>
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
                <h1>CUSTOMER CONTENT</h1>
            </div>
        </div>
    <?php else: ?>
        <div class="app-container">
            <div class="left-menu">
                <h1 class="app-name">Nav Bar</h1>
                <div class="left-menu-items">
                    <a href="../view/dashboard.php"><p>Hotel Statistics</p></a>
                    <a><p onclick="loadContent('../admin/add_remove_room_page.php')">Remove Room</p></a>
                    <a><p onclick="confirmLogout()">Logout</p></a>
                </div>
                <p class="user-name"><?= $_SESSION['fname'] ?></p>
            </div>
            <div id="content">
                <div id="content4">

                    <div id="heading">
                        <h3>Dashboard</h3>
                        <p> Sales Update</p>
                    </div>


                    <section class="data-summary">
                        <?php
                            $statsQuery = "
                                SELECT 
                                    SUM(CASE WHEN DATE(Check_In_Date) = CURDATE() THEN 1 ELSE 0 END) AS CheckInsToday,
                                    SUM(CASE WHEN YEARWEEK(Check_In_Date) = YEARWEEK(NOW()) THEN 1 ELSE 0 END) AS CheckInsThisWeek,
                                    SUM(CASE WHEN YEAR(Check_In_Date) = YEAR(NOW()) AND MONTH(Check_In_Date) = MONTH(NOW()) THEN 1 ELSE 0 END) AS CheckInsThisMonth
                                FROM Bookings";

                            // Execute the query
                            $result = mysqli_query($conn, $statsQuery);

                            $checkInsToday = 0;
                            $checkInsThisWeek = 0;
                            $checkInsThisMonth = 0;

                            // Check if the query executed successfully
                            if ($result) {
                                // Fetch the row containing the counts
                                $row = mysqli_fetch_assoc($result);

                                // Store the counts in PHP variables
                                $checkInsToday = $row['CheckInsToday'];
                                $checkInsThisWeek = $row['CheckInsThisWeek'];
                                $checkInsThisMonth = $row['CheckInsThisMonth'];

                                // Free the result set
                                mysqli_free_result($result);
                            } else {
                                // Handle the case where the query fails
                                echo "Error executing the query: " . mysqli_error($conn);
                            }

                            // Close the database connection
                            mysqli_close($conn);
                        ?>
                        <div class="stat-box">
                            <div class="day">
                                <h5>Check Ins Today</h5>
                                <p><?= $checkInsToday ?></p>
                            </div>

                            <div class="week">
                                <h5>Check Ins This Week</h5>
                                <p><?= $checkInsThisWeek ?></p>
                            </div>

                            <div class="month">
                                <h5>Check Ins This Month</h5>
                                <p><?= $checkInsThisMonth ?></p>
                            </div>
                        </div>

                    </section>

                    <section class="chart-summary">
                        <div class="header">
                            <h3>Summary</h3>
                        </div>
                        <div class="chartCard">
                            <div class="chartBox">
                                <canvas id="myChart"></canvas>
                                <div class="filter-buttons">
                                    <button id="filter-btn" onclick="dateFilter('hour')">Hour</button>
                                    <button id="filter-btn" onclick="dateFilter('day')">Day</button>
                                    <button id="filter-btn" onclick="dateFilter('week')">Week</button>
                                    <button id="filter-btn" onclick="dateFilter('month')">Month</button>
                                    <button id="filter-btn" onclick="dateFilter('year')">Year</button>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="../js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../js/logout.js"></script>
    <script src="../js/book_a_room.js"></script>
    <script src="../js/your_room.js"></script>

    <?php if ($_SESSION['role_id'] === 2): ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script defer src="../js/chart.js"></script>
    <script src="../js/add_remove_rooms.js"></script>
    <?php endif; ?>

</body>
</html>
