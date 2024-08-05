<?php
session_start();
$msg = 0;

// It's better to store sensitive information like admin email and password in environment variables
$admin_email = 'mayanksharma@gmail.com';
$admin_pass = 'mayank@123sharma';

if (isset($_POST['edit'])) {
    $admin_email = $_POST['email'];
    $admin_pass = $_POST['password'];
}

if (isset($_POST['sign'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($admin_email == $email) {
        if ($admin_pass == $password) {
            $_SESSION['aemail'] = $email;
            header("location:admin.php");
            exit;
        } else {
            $msg = 1;
        }
    } else {
        $msg = 2;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="formstyle.css"> -->
    <script src="signin.js" defer></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Login</title>
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

        .center {
            width: 300px;
            padding: 40px;
            background: white;
            border-radius:10px;
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
    <div class="center">
        <h1>Login</h1>
        <form action="" id="form" method="post">
            <div class="txt_field">
                <input type="text" id="email" name="email" required>
                <span></span>
                <label>Email</label>
                <?php if ($msg == 2): ?>
                    <p class="error">Email doesn't exist</p>
                <?php endif; ?>
            </div>
            <div class="txt_field">
                <input type="password" name="password" id="password" required>
                <span></span>
                <label>Password</label>
                <?php if ($msg == 1): ?>
                    <p class="error">Password doesn't match.</p>
                <?php endif; ?>
            </div>
            <input type="submit" name="sign" value="Login">
        </form>
        <div class="signup_link">
            <a href="#">Forgot Password?</a>
        </div>
    </div>
</body>

</html>