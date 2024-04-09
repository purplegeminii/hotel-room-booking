function handleFormSubmit(event) {
    event.preventDefault();
    var form = document.getElementById("sign-up-form");
    var inputs = {
        "first-name-input": form.elements["first-name-input"].value,
        "last-name-input": form.elements["last-name-input"].value,
        "gender": form.elements["gender"].value,
        "date-of-birth": form.elements["date-of-birth"].value,
        "address": form.elements["address"].value,
        "phone-number": form.elements["phone-number"].value,
        "email-input": form.elements["email-input"].value,
        "password1": form.elements["password1"].value,
        "password2": form.elements["password2"].value
    };

    // You can perform validation here

    fetch('../actions/register_user_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(inputs)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status === 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000 // Close after 2 seconds
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}