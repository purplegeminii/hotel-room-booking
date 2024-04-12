var msg = document.getElementById("message");

function setMessage(newMsg, isError) {
    // Set background color and text color based on conditions
    msg.style.backgroundColor = newMsg !== "" ? (isError === "no" ? "#69c056" : "#d26e6e") : "";
    msg.style.color = newMsg !== "" && isError !== "no" ? "white" : "black";

    // Set the message content
    msg.innerText = newMsg;
}

function handleInputChange(event, type) {
    var usernameInput = document.getElementById("username");
    var passwordInput = document.getElementById("password");
    var error = "";

    switch (type) {
        case "user":
            usernameInput.classList.remove("error");
            error = event.target.value === "" ? "Please enter an email" : "";
            break;
        case "pass":
            passwordInput.classList.remove("error");
            error = event.target.value === "" ? "Please enter a password" : "";
            break;
        default:
    }

    // Update error message and style based on the input type
    if (type === "user") {
        // If it's the username field
        usernameInput.classList.toggle("error", error !== ""); // Add error class if error exists
    } else if (type === "pass") {
        // If it's the password field
        passwordInput.classList.toggle("error", error !== ""); // Add error class if error exists
    }

    // error !== "" ? msg.style.backgroundColor = "#d26e6e" : msg.style.backgroundColor = "";
    // msg.innerText = error;

    let isError = "";
    isError = error === "" ? "no" : "yes";

    setMessage(error, isError);
}

function loginSubmit(event) {
    event.preventDefault(); // Prevent form submission
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var url = "../actions/login_user_action.php";
    var headers = {
        "Accept": "application/json",
        "Content-type": "application/json"
    };
    var Data = {
        username: username,
        password: password
    };
    fetch(url, {
        method: "POST",
        headers: headers,
        body: JSON.stringify(Data)
    })
        .then((response) => response.json())
        .then((response) => {
            console.log(response);
            if (response.status === 1) {
                // Display success message with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 3000, // Close after 3 seconds
                    timerProgressBar: true
                }).then(() => {
                    window.location.href = response.redirect;
                });
            } else {
                // Display error message with SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message
                });
            }
        })
        .catch((err) => {
            console.log(err);
        })
}