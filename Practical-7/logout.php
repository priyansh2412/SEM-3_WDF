<?php
session_start();
session_unset();
session_destroy();

// Remove cookie
setcookie("remember_user", "", time() - 3600, "/");

header("Location: login.html");
exit;
?>