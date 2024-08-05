<?php
session_start();

// Check if user session variables are set
if (isset($_SESSION['uemail']) && isset($_SESSION['uname']) && isset($_SESSION['ugender']) && isset($_SESSION['profile_image'])) {
    // Unset user session variables
    unset($_SESSION['uemail']);
    unset($_SESSION['uname']);
    unset($_SESSION['ugender']);
    unset($_SESSION['profile_image']);
    unset($_SESSION['ip_address']);
    unset($_SESSION['user_agent']);
    
    // Destroy the session
    // session_destroy();
}

// Redirect to login page or any other desired page
header("location: signin.php");
exit;
?>
