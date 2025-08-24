<?php
session_start();

// Check if the user is logged in, has the "user" type, and has an email session
if (
    !isset($_SESSION['loggedin']) || 
    $_SESSION['loggedin'] !== true || 
    $_SESSION['type'] !== 'user' || 
    !isset($_SESSION['email'])
) {
    // Redirect to login page if any condition is not met
    header("Location: login.php");
    exit();
}
?>
