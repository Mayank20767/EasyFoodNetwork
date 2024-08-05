<?php
include 'connection.php';
$msg = 0;
session_start();
if (isset($_POST['sign'])) {
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $password = mysqli_real_escape_string($connection, $_POST['password']);

  $sql = "SELECT * FROM login WHERE email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      $_SESSION['uemail'] = $email;
      $_SESSION['uname'] = $row['name'];
      $_SESSION['ugender'] = $row['gender'];
      $_SESSION['profile_image'] = $row['profile_image'];

      // Store the IP address and user-agent in the session
      $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

      header("location:index.php");
      exit; // Exiting after redirect
    } else {
      $msg = 1;
    }
  } else {
    echo "<h1><center>Account does not exist </center></h1>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <style>
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,500;0,700;0,800;1,400;1,600&display=swap');

    /* Global Styles */
    :root {
      --navcolor: #dad7cd;
      --navfont: black;
      --green: #588157;
      --light-green: #8FCB9B;
      --dark-green: #344E41;
      --brown: #6F4E37;
      --beige: #F5F5DC;
      --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
      --font-family: 'Roboto', 'Poppins', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, Helvetica, sans-serif;
    }

    * {
      margin: 0;
      padding: 0;
      list-style: none;
      text-decoration: none;
      box-sizing: border-box;
    }

    /* Body Styles */
    body {
      margin: 0;
      padding: 0;
      font-family: var(--font-family);
      background: linear-gradient(to right, var(--beige), var(--light-green));
      color: var(--dark-green);
      line-height: 1.2;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .flex-container {
      display: flex;
      width: 100%;
      max-width: 600px;
      height: 500px;
    }

    .image {
      width: 100%;
      max-width: 300px;
      padding: 0 40px;
      background-image: url(img/2nd.jpg);
      background-size: cover;
      border-radius: 10px 0 0 10px;
      box-shadow: var(--box-shadow);
    }

    .center {
      width: 300px;
      padding: 40px;
      background: white;
      border-radius: 0 10px 10px 0;
      box-shadow: var(--box-shadow);
      text-align: center;
    }

    .center h1 {
      margin-bottom: 30px;
      color: var(--dark-green);
    }

    .txt_field {
      position: relative;
      margin-bottom: 30px;
    }

    .txt_field input {
      width: 100%;
      padding: 10px 0;
      background: none;
      border: none;
      border-bottom: 1px solid var(--dark-green);
      outline: none;
      color: var(--dark-green);
      font-size: 16px;
    }

    .txt_field label {
      position: absolute;
      top: 50%;
      left: 0;
      color: var(--dark-green);
      transform: translateY(-50%);
      font-size: 16px;
      pointer-events: none;
      transition: .5s;
    }

    .txt_field input:focus~label,
    .txt_field input:valid~label {
      top: -5px;
      color: var(--green);
      font-size: 12px;
    }

    .txt_field span::before {
      content: '';
      position: absolute;
      top: 40px;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--green);
      transition: .5s;
    }

    .txt_field input:focus~span::before,
    .txt_field input:valid~span::before {
      width: 100%;
    }

    select {
      width: 100%;
      padding: 10px;
      background: none;
      border: 1px solid var(--dark-green);
      outline: none;
      color: var(--dark-green);
      font-size: 16px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      background: var(--green);
      color: white;
      font-size: 18px;
      cursor: pointer;
      border-radius: 5px;
      transition: background .3s;
    }

    input[type="submit"]:hover {
      background: var(--dark-green);
    }

    .signup_link {
      margin-top: 20px;
    }

    .signup_link a {
      color: var(--green);
      text-decoration: none;
    }

    .signup_link a:hover {
      text-decoration: underline;
    }

    .icon {
      position: absolute;
      top: 60%;
      right: 30px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="flex-container">
    <div class="image"></div>
    <div class="center">
      <h1>User Login</h1>
      <form action="" method="post">
        <div class="txt_field">
          <input type="email" name="email" required />
          <span></span>
          <label>Email</label>
        </div>
        <div class="txt_field">
          <input type="password" id="password" name="password" minlength="8" maxlength="15" required>
          <span></span>
          <label for="password">Password</label>
          <div class="icon">
            <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>
          </div>
        </div>
        <?php
        if ($msg == 1) {
          echo '<i class="bx bx-error-circle error-icon"></i>';
          echo '<p class="error">Password does not match.</p>';
        }
        ?>
        <br>
        <input type="submit" value="Login" name="sign">
        <div class="signup_link">Don't have an account? <a href="signup.php">Signup</a></div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('showpassword').addEventListener('click', function () {
      const passwordInput = document.getElementById('password');
      const showHideIcon = document.getElementById('showpassword');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showHideIcon.classList.remove('uil-eye-slash');
        showHideIcon.classList.add('uil-eye');
      } else {
        passwordInput.type = 'password';
        showHideIcon.classList.remove('uil-eye');
        showHideIcon.classList.add('uil-eye-slash');
      }
    });
  </script>
  <script src="admin/login.js"></script>
</body>

</html>