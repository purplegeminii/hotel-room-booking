<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>

<body>

    <div class="form">
        <p>
            <span id="message"></span>
        </p>
        <br/><br/>
        <form id="loginForm" name="loginForm" onsubmit="loginSubmit(event)">
            <label for="username">Email or Username:</label><br/>
            <input type="text" class="text-input" id="username" name="username" placeholder="delali@example.com"
                   onchange="handleInputChange(event, 'user')" required/>
            <br/><br/>

            <label for="password">Password:</label><br/>
            <input type="password" class="text-input" id="password" name="password" placeholder="********"
                   onchange="handleInputChange(event, 'pass')" required/>

            <br/> <br/>

            <button type="submit" name="login-button" id="login-btn">LOGIN</button>
        </form>
        <br/>
        <p class="sign-up">Don't have an account? <a href="../login/register.php">Sign up</a></p>
    </div>

    <script src="../js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>
</html>