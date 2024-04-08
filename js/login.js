var msg = document.getElementById("message");

function handleInputChange(event, type) {
    var usernameInput = document.getElementById("username");
    var passwordInput = document.getElementById("password");
    var error = "";

    switch (type) {
        case "user":
            usernameInput.classList.remove("error");
            error = event.target.value === "" ? "Please enter a username" : "";
            break;
        case "pass":
            passwordInput.classList.remove("error");
            error = event.target.value === "" ? "Please enter a password" : "";
            break;
        default:
    }

    msg.innerText = error;
}

function loginSubmit(event) {
    event.preventDefault(); // Prevent form submission
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var url = "http://localhost/hotel-room-booking/actions/login_user_action.php";
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
            console.log(response.data);
            if (response.status === 1) {
                window.location.href = response.redirect
            }
        })
        .catch((err) => {
            console.log(err);
        })
}