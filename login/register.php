<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>
<body>
    <div class="content">
        <h1>Register User</h1>
        <form name="sign-up-form" id="sign-up-form" onsubmit="handleFormSubmit(event)">
            <label for="fname">FIRST NAME:</label><br />
            <input placeholder='First Name' type='text' name='first-name-input' id='fname' required />
            <br />

            <label for="lname">LAST NAME:</label><br />
            <input placeholder='Last Name' type='text' name='last-name-input' id='lname' required />

            <label for='male'>MALE</label><input type='radio' name='gender' id='male' value='Male' /><br />
            <label for='female'>FEMALE</label><input type='radio' name='gender' id='female' value='Female' /><br /><br />

            <label for='dob'>Date Of Birth:</label>
            <input type='date' name='date-of-birth' id='dob' required/>

            <label for='address'>ADDRESS:</label>
            <input placeholder='1 University Avenue' type='text' name='address' id='address' required/>

            <label for='tel'>TELEPHONE:</label>
            <input placeholder='+233-XXX-XXX-XXX' type='tel' name='phone-number' id='tel' required/>

            <label for='email'>EMAIL:</label>
            <input placeholder='EMAIL' type='email' name='email-input' id='email' required />

            <label for='pwd1'>PASSWORD:</label>
            <input placeholder='PASSWORD' type='password' name='password1' id='pwd1' required />

            <label for='pwd2'>CONFIRM PASSWORD:</label>
            <input placeholder='CONFIRM PASSWORD' type='password' name='password2' id='pwd2' required />

            <button type='submit' name='sign-up-button' id='sign-up-btn'>SIGN UP</button><br />
            <a href="../login/login.php">Login here</a>
        </form>
    </div>

    <script src="../js/register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>
