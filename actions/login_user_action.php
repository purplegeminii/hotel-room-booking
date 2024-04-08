<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

session_start();
include "../settings/connection.php";
global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = json_decode( file_get_contents('php://input'), true );

    $email = $user['username'];
    $password = $user['password'];

    $query = "SELECT COUNT(*) AS email_count FROM Users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $emailCount = $row['email_count'];

    mysqli_stmt_free_result($stmt);

    if ($emailCount > 0) {

        $response = array();

        $query = "SELECT User_ID, rid, passwd FROM Users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $hashedPasswordFromDatabase = $row['passwd'];

        // Verify the entered password against the stored hash
        if (password_verify($password, $hashedPasswordFromDatabase)) {
            // Passwords match, login successful, set user_id & role_id
            $_SESSION['user_id'] = $row['User_ID'];
            $_SESSION['role_id'] = $row['rid'];
            if ($row['rid']==2) {
                $response = ["status" => 1, "message" => "login successful", "redirect" => "/admin/dashboard"];
            } else if ($row['rid']==3) {
                $response = ["status" => 1, "message" => "login successful", "redirect" => "/view/dashboard"];
            }
        } else {
            // Passwords do not match, login failed
            $response = ["status" => 0, "message" => "login failed, passwords do not match", "redirect" => "/login/login"];
        }
        echo json_encode($response);
        exit();
    } else {
        // Email does not exist, login failed
        $response = ["status" => 0, "message" => "login failed, email does not exist", "redirect" => "/login/login"];
    }

    mysqli_stmt_free_result($stmt);
    $conn->close();
    echo json_encode($response);
    exit();

}
