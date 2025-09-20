<?php
session_start();
require 'users.php';

$username = $_POST['username'];
$password = $_POST['password'];

if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['user'] = $username;
    $_SESSION['last_activity'] = time(); // for timeout
    header("Location: dashboard.php");
    exit;
} else {
    echo "<h3>Invalid credentials</h3>";
}
?>