
function confirmDelete(roomID) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are permanently removing a room!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteRoom(roomID);
        }
    });
}

function deleteRoom(roomID) {
    // Make an AJAX request to delete the room
    fetch('../actions/delete_room.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ "roomID": roomID })
    })
        .then(response => response.json())
        .then(res => {
            if (res.status === 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.message,
                    showConfirmButton: false,
                    timer: 2000 // Close after 2 seconds
                }).then(() => {
                    loadContent('../admin/add_remove_room_page.php');
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: res.message
                });
            }
        })
        .catch(error => {
            console.error('Error deleting room:', error);
        });
}
