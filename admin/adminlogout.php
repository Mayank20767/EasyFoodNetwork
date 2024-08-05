<?php
session_start();
// Check if admin session variables are set
if (isset($_SESSION['aemail']) && isset($_SESSION['aname']) && isset($_SESSION['alocation']) && isset($_SESSION['Aid'])) {
    // Unset admin session variables
    unset($_SESSION['aemail']);
    unset($_SESSION['aname']);
    unset($_SESSION['alocation']);
    unset($_SESSION['Aid']);
}
// Redirect to login page or any other desired page
header("location: page.php");
exit;
?>
