<?php
session_start();

// Session timeout: 10 minutes
$timeout = 600;

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: login.html");
    exit;
}

$_SESSION['last_activity'] = time(); // reset timer

echo "<h2>Welcome, " . htmlspecialchars($_SESSION['user']) . "!</h2>";
echo "<a href='logout.php'>Logout</a>";
?>