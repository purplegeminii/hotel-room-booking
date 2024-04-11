
<h1>Book A Room</h1>

<form class="search-bar-container" id="search-bar" name="search-bar" onsubmit="search4room(event)">
    <label for="search">Search by Room Type:</label>
    <input type="text" id="search" name="search" placeholder="Enter room type">
    <button type="submit" name="search-button" id="search-button">
        <img src="../assets/images/search_icon.png" alt="SearchIcon" id="search-icon"/>
    </button>
</form><br/><br />

<div id="content2">

    <?php include "../functions/get_all_available_rooms.php"; ?>

</div>
