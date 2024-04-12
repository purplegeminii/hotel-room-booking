
function search4room(event) {
    event.preventDefault(); // Prevent form submission

    const search = document.getElementById("search").value.trim();

    if (search === "") return;

    const url = "../actions/search4room.php?search=" + search;

    const headers = {
        "Accept": "application/json",
        "Content-type": "application/json"
    };

    fetch(url, {
        method: "GET",
        headers: headers
    })
        .then((response) => response.json())
        .then((response) => {
            console.log(response);
            if (response.status === 1) {
                document.getElementById('content2').innerHTML = response.result;
            } else {
                document.getElementById('content2').innerHTML = response.result;
                setTimeout(function() {
                    loadContent('../view/BookARoom.php');
                }, 3000); // 3 sec
            }
        })
        .catch((err) => {
            console.log(err);
        })
}

function bookThisRoom(element) {
    // const room_type = element.id;
    // const room_image = element.querySelector('img').src;

    const room_details = {
        roomType: element.querySelector('#details p:nth-of-type(1)').textContent.trim().replace('Room Type: ', ''),
        price: element.querySelector('#details p:nth-of-type(2)').textContent.trim().replace('Price ($): ', ''),
        occupancy: element.querySelector('#details p:nth-of-type(3)').textContent.trim().replace('Occupancy: ', ''),
        availableRooms: element.querySelector('#details p:nth-of-type(4)').textContent.trim().replace('Available Rooms: ', '')
    };

    const url = "../functions/get_booking_page.php";

    const Data = {
        "room_details": room_details
    }

    fetch(url, {
        method: "POST",
        body: JSON.stringify(Data)
    })
        .then((response) => response.text())
        .then((data) => {
            document.getElementById('content2').innerHTML = data;
        })
        .catch((err) => {
            console.log(err);
        })
}

function changeQty(element, limit) {
    event.preventDefault();

    const choice = element.textContent;
    const currentQty = document.getElementById('room-quantity');

    if (choice === "+") {
        if (parseInt(currentQty.value) < limit) {
            currentQty.value = parseInt(currentQty.value) + 1;
        }
    } else if (choice === "-") {
        // Ensure the quantity doesn't go below 1
        if (parseInt(currentQty.value) > 1) {
            currentQty.value = parseInt(currentQty.value) - 1;
        }
    }
}

function handleBooking(event) {
    event.preventDefault();

    const roomType = document.getElementById('room-type').value;
    const roomPrice = document.getElementById('room-price').value;
    // const roomOccupancy = document.getElementById('room-occupancy').value;
    // const numAvailRooms = document.getElementById('num-avail-rooms').value;
    const roomQuantity = document.getElementById('room-quantity').value;

    const bookingData = {
        "roomType": roomType,
        "roomPrice": roomPrice,
        // "roomOccupancy": roomOccupancy,
        // "numAvailRooms": numAvailRooms,
        "roomQuantity": roomQuantity
    };

    const bookingUrl = "../actions/book_a_room.php";

    fetch(bookingUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(bookingData)
    })
        .then(response => response.json())
        .then(data => {
            // Handle the response data
            console.log(data);
            // Optionally, perform additional actions based on the response
        })
        .catch(error => {
            console.error('Error:', error);
            // Optionally, handle errors
        });
}
