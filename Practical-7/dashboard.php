<?php
session_start();

// Auto-login from cookie
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])) {
    $_SESSION['user'] = $_COOKIE['remember_user'];
}

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

echo "<h2>Welcome, " . htmlspecialchars($_SESSION['user']) . "!</h2>";
echo "<a href='logout.php'>Logout</a>";
?>