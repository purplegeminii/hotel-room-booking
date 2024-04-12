
function handleCheckOut() {
    event.preventDefault();

    // get the room type from the button's name attribute
    const roomType = event.target.name;

    const totalBookings = document.getElementById('total-bookings').textContent.trim().replace('Total Bookings: ', '');

    const url = "../actions/check_out_room.php";
    const Data = {
        "roomType": roomType,
        "totalBookings": totalBookings
    };

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(Data)
    })
        .then(response => response.json())
        .then(response => {
            if (response.status === 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    loadContent('../view/YourRoom.php');
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.message
                });
            }
        })
        .catch(error => {
            // Handle network errors or other issues
            console.error("Error:", error);
        });
}
