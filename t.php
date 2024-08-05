<?php 
$pass="mayank@12sharma";
// $pass='smith@123';
// $pass='mimoma@6397';
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);
echo $hashed_password;
?>
