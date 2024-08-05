<?php
session_start();

function checkSession() {
    if (!isset($_SESSION['uemail'])) {
        header("location: logout.php");
        exit;
    }


    // $current_ip = $_SERVER['REMOTE_ADDR'];
    // $current_user_agent = $_SERVER['HTTP_USER_AGENT'];
    // // print($current_ip);

    // if ($_SESSION['ip_address'] !== $current_ip || $_SESSION['user_agent'] !== $current_user_agent) {
    //     header("location: logout.php");
    //     exit;
    // }
}
checkSession();
?>