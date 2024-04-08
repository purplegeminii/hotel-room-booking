<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include "../settings/connection.php";
global $conn;

$user = json_decode( file_get_contents('php://input'), true );

$fname = $user['first-name-input'];
$lname = $user['last-name-input'];
$gender = $user['gender'];
$dob = $user['date-of-birth'];
$address = $user['address'];
$phone_num = $user['phone-number'];
$email = $user['email-input'];
$password1 = $user['password1'];
$password2 = $user['password2'];

if ($password1 != $password2) {
    $response = ["status" => 0, "message" => "passwords don't match", "redirect" => "/login/register"];
    echo json_encode($response);
    exit();
}

$hashedPassword = password_hash($password1, PASSWORD_DEFAULT);


$query = "INSERT INTO Users (fname, lname, gender, dob,  email, passwd, tel, address, rid) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$create_record = $conn->prepare($query);
$rid = 3;
$create_record->bind_param('ssssssssi', $fname, $lname, $gender, $dob, $email, $hashedPassword, $phone_num, $address, $rid);
if ($create_record->execute()) {
    $response = ["status" => 1, "message" => "Registered successfully", "redirect" => "/login/login"];
} else {
    $response = ["status" => 0, "message" => "Registration failed", "redirect" => "/login/register"];
}
echo json_encode($response);
exit();
