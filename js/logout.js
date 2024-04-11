
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are logging out!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!'
    }).then((result) => {
        if (result.isConfirmed) {
            logout();
        }
    });
}

function logout(event) {
    fetch('../login/logout.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(res => {
            console.log(res);
            if (res.status === 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.message,
                    showConfirmButton: false,
                    timer: 2000 // Close after 2 seconds
                }).then(() => {
                    window.location.href = res.redirect;
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
            console.error('Error:', error);
        });
}
