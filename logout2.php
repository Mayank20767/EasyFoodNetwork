<?php
session_start();

// Check if delivery person session variables are set
if (isset($_SESSION['demail']) && isset($_SESSION['dname']) && isset($_SESSION['Did']) && isset($_SESSION['dcity'])) {
    // Unset delivery person session variables
    unset($_SESSION['demail']);
    unset($_SESSION['dname']);
    unset($_SESSION['Did']);
    unset($_SESSION['dcity']);
    
    // // Destroy the session
    // session_destroy();
}

// Redirect to login page or any other desired page
header("location: page.php");
exit;
?>