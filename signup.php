<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $phone = $_POST['phoneno'];
    $file = $_FILES['image']['tmp_name'];


    $check_query = "SELECT email FROM login WHERE email = '$email' UNION SELECT email FROM ngo WHERE email = '$email'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo '<script type="text/javascript">alert("Account with this email already exists")</script>';
    } else {
        $image = mysqli_real_escape_string($connection, file_get_contents($file));

        $hashed_password = mysqli_real_escape_string($connection, password_hash($password, PASSWORD_DEFAULT));

        $query_insert = "INSERT INTO login (name, email, password, gender, phone, profile_image) VALUES ('$username', '$email', '$hashed_password', '$gender', '$phone', '$image')";

        if (mysqli_query($connection, $query_insert)) {
            header("location: signin.php");
            exit;
        } else {
            echo '<script type="text/javascript">alert("Data not saved")</script>';
        }
    }

    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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

        body {
            margin: 0;
            padding: 0;
            font-family: var(--font-family);
            background: linear-gradient(to right, var(--green), var(--light-green));
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            width: 100%;
            max-width: 800px;
            height: 90vh;
        }

        .image {
            width: 100%;
            max-width: 365px;
            padding: 0 20px;
            background-image: url(img/2nd.jpg);
            background-size: cover;
            border-radius: 10px 0 0 10px;
            box-shadow: var(--box-shadow);
        }

        .container {
            width: 100%;
            max-width: 365px;
            background-color: var(--beige);
            border-radius: 0 10px 10px 0;
            box-shadow: var(--box-shadow);
        }

        .logo {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #heading {
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bolder;
        }

        .center {
            width: 300px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            text-align: center;
            max-height: 70vh;
            overflow-y: auto;
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

        input[type="submit"],
        button {
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

        input[type="submit"]:hover,
        button:hover {
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

        .circular-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        #verifyBtn,
        #signupBtn {
            display: none;
        }

        .icon {
            position: absolute;
            top: 60%;
            right: 30px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .flex-container {
                flex-direction: column;
                align-items: center;
                height: auto;
            }

            .image,
            .center {
                max-width: 90%;
                width: 100%;
                padding: 10px;
                border-radius: 10px;
                box-shadow: var(--box-shadow);
            }

            .image {
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .container {
                border-radius: 10px;
            }

            .center {
                max-height: none;
                overflow-y: visible;
                padding: 20px;
            }

            .txt_field input,
            select,
            input[type="submit"],
            button {
                font-size: 14px;
                padding: 8px;
            }

            .center h1 {
                font-size: 18px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {

            .txt_field input,
            select,
            input[type="submit"],
            button {
                font-size: 12px;
                padding: 6px;
            }

            .center h1 {
                font-size: 16px;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="flex-container">
        <div class="image"></div>
        <div class="container">
            <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
            <div class="center">
                <h1>User Registration Form</h1>
                <div class="circular-image" id="previewImage" style="background-image: url('default.png');"></div>

                <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="txt_field">
                        <input type="file" id="user_photo" name="image" accept="image/*" onchange="previewPhoto()"
                            required>
                        <br><br>
                        <span></span>
                    </div>

                    <div class="txt_field">
                        <input type="text" id="user_name" name="name" required oninput="checkForm()">
                        <input type="hidden" id="hiddenName" name="name" />
                        <span></span>
                        <label class="hide">User Name</label>
                    </div>

                    <div class="txt_field">
                        <input type="email" id="user_email" name="email" required oninput="checkForm()">
                        <input type="hidden" id="hiddenEmail" name="email" />
                        <span></span>
                        <label class="hide">Email</label>
                    </div>

                    <div class="txt_field">
                        <input type="text" id="otp" name="otp" required>
                        <span></span>
                        <label class="hide">OTP</label>
                    </div>

                    <button type="button" id="sendBtn">Send OTP</button><br>
                    <button type="button" id="verifyBtn">Verify</button><br>

                    <div class="txt_field" style="display: none;">
                        <input type="number" id="user_phone" name="phoneno" maxlength="10" required>
                        <span></span>
                        <label>Phone Number</label>
                    </div>

                    <div class="txt_field" style="display: none;">
                        <input type="password" id="user_password" name="password" minlength="8" maxlength="15" required>
                        <span></span>
                        <label for="user_password">Password</label>
                        <div class="icon">
                            <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>
                        </div>
                    </div>

                    <div class="radio" style="display: none;">
                        <input type="radio" name="gender" id="male" value="male" required />
                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="female" value="female">
                        <label for="female">Female</label>
                    </div><br><br>

                    <input type="submit" name="signup" id="signupBtn" value="Signup">

                    <div class="signup_link">Already a member? <a href="signin.php">Sign in</a></div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewPhoto() {
            const preview = document.getElementById('previewImage');
            const fileInput = document.getElementById('user_photo');
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.style.backgroundImage = `url(${reader.result})`;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.backgroundImage = "url('default.png')";
            }
        }

        function validateForm() {
            var email = document.getElementById('user_email').value;
            var password = document.getElementById('user_password').value;
            var username = document.getElementById('user_name').value;

            // Validate password length and other conditions
            if (password.length < 8 || password.length > 15) {
                alert("Password must be between 8 and 15 characters long.");
                return false;
            }
            return true;
        }

        function checkForm() {
            const email = document.getElementById('user_email').value.trim();
            const username = document.getElementById('user_name').value.trim();
            const sendBtn = document.getElementById('sendBtn');

            sendBtn.disabled = !(email && username);
        }

        document.getElementById('sendBtn').addEventListener('click', function () {
            const email = document.getElementById('user_email').value.trim();
            const username = document.getElementById('user_name').value.trim();

            // Check if email, username, are entered
            if (!email || !username) {
                alert('Please enter your email and username.');
                return;
            }

            // Validate username format
            const usernameRegex = /^[a-zA-Z\s]*$/; // Allow only alphabets and spaces
            if (!usernameRegex.test(username)) {
                alert("Username should not contain special characters or numbers.");
                return;
            }

            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            // Store email and username in hidden fields
            document.getElementById('hiddenEmail').value = email;
            document.getElementById('hiddenName').value = username;

            // Make the fetch request to send OTP
            fetch('otp_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=send_otp&email=${encodeURIComponent(email)}&name=${encodeURIComponent(username)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('verifyBtn').style.display = 'block';
                        document.getElementById('sendBtn').style.display = 'none';
                        document.getElementById('user_email').disabled = true;
                        document.getElementById('user_name').disabled = true;
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                });
        });

        document.getElementById('verifyBtn').addEventListener('click', function () {
            const otp = document.getElementById('otp').value.trim();

            if (!otp) {
                alert('Please enter the OTP.');
                return;
            }

            fetch('otp_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=verify_otp&otp=${otp}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('verifyBtn').style.display = 'none';
                        document.getElementById('signupBtn').style.display = 'block';
                        document.getElementById('otp').disabled = true;
                        alert(data.message);
                        // Display the hidden divs
                        document.querySelectorAll('.txt_field, .radio').forEach(div => {
                            div.style.display = 'block';
                        });
                    } else {
                        alert(data.message);
                    }
                });
        });

        document.getElementById('showpassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('user_password');
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
</body>

</html>