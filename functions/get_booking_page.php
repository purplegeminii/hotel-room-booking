<?php

include "../settings/connection.php";
global $conn;

$room_details = array();

$room_details = json_decode( file_get_contents('php://input'), true );
$room_details = $room_details['room_details'];

$chosen_rt = $room_details['roomType'];
$room_price = $room_details['price'];
$room_occupancy = $room_details['occupancy'];
$num_avail_rooms = $room_details['availableRooms'];

?>

<div class="booking-page-container">
    <h3>Booking Page</h3>
    <form class="booking-form" onsubmit="handleBooking()">
        <div class="row">
            <label for="room-type">Room Type:</label>
            <input id="room-type" value="<?= $chosen_rt ?>" readonly />
        </div>
        <br /><br />

        <div class="row">
            <label for="room-price">Price:</label>
            <input id="room-price" value="<?= $room_price ?>" readonly />
        </div>
        <br /><br />

        <div class="row">
            <label for="room-occupancy">Occupancy:</label>
            <input id="room-occupancy" value="<?= $room_occupancy ?>" readonly />
        </div>
        <br /><br />

        <div class="row">
            <label for="num-avail-rooms">Available Rooms:</label>
            <input id="num-avail-rooms" value="<?= $num_avail_rooms ?>" readonly />
        </div>
        <br /><br />

        <div class="row">
            <label for="room-quantity">Number of rooms to book:</label>
<!--            <div class="action">-->
                <button id="change-qty" onclick="changeQty(this, <?= $num_avail_rooms ?>)">+</button>
                <input id="room-quantity" value="1" readonly />
                <button id="change-qty" onclick="changeQty(this, <?= $num_avail_rooms ?>)">-</button>
<!--            </div>-->
        </div><br /><br />

        <button type="submit">BOOK</button><br>
    </form>
</div>
