<?php
session_start();
include '../connection.php';
$msg = 0;
if (isset($_POST['sign'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sanitized_emailid = mysqli_real_escape_string($connection, $email);
  $sanitized_password = mysqli_real_escape_string($connection, $password);

  $sql = "select * from delivery_persons where email='$sanitized_emailid'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($sanitized_password, $row['password'])) {
        $_SESSION['demail'] = $email;
        $_SESSION['dname'] = $row['name'];
        $_SESSION['Did'] = $row['Did'];
        $_SESSION['dcity'] = $row['city'];
        header("location:deliveryperson.php");
      } else {
        $msg = 1;
      }
    }
  } else {
    echo "<h1><center>Account does not exists </center></h1>";
  }
}
?>



<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login Form</title>
  <link rel="stylesheet" href="delivery.css">
</head>

<body>
  <div class="center">
    <h1>Delivery Login</h1>

    <form method="post">
      <div class="txt_field">
        <input type="email" name="email" required />
        <span></span>
        <label>Email</label>
      </div>
      <div class="txt_field">
        <input type="password" name="password" required />
        <span></span>
        <label>Password</label>
      </div>


      <?php
      if ($msg == 1) {
        echo ' <i class="bx bx-error-circle error-icon"></i>';
        echo '<p class="error">Password not match.</p>';
      }
      ?>

      <br>
      <!-- <div class="pass">Forgot Password?</div> -->
      <input type="submit" value="Login" name="sign">
      <div class="signup_link">Not a member? <a href="deliverysignup.php">Signup</a></div>

    </form>

  </div>

</body>

</html>