<?php

unset($_SESSION['user_id']);
unset($_SESSION['role_id']);
unset($_SESSION['fname']);

$response = [
    "status" => 1,
    "message" => "Successfully logged out",
    "redirect" => "../login/login.php"
];
echo json_encode($response);
exit();
