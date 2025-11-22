<?php
session_start();

// Destroy all session data to log out the user
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect the user to the login page
header("Location: login.php");
exit();
?>
