<?php
session_start();

// Hardcoded credentials (replace with DB later)
$valid_users = [
    "priyansh" => "secure123",
    "admin" => "adminpass"
];

$username = $_POST['username'];
$password = $_POST['password'];

// Authentication check
if (isset($valid_users[$username]) && $valid_users[$username] === $password) {
    $_SESSION['user'] = $username;

    // Handle "Remember Me"
    if (isset($_POST['remember'])) {
        setcookie("remember_user", $username, time() + (86400 * 7), "/"); // 7 days
    }

    header("Location: dashboard.php");
    exit;
} else {
    echo "<h3>Invalid credentials</h3>";
}
?>