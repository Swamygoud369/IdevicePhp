<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Delete the cookie
setcookie('user_email', '', time() - 3600, '/'); // Expire in past

// Redirect to login page
header("Location: index.php");
exit();
?>
