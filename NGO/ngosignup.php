<?php
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Retrieve form data
    $ngo_name = $_POST['ngo_name'];
    $ngo_email = $_POST['ngo_email'];
    $ngo_phone = $_POST['ngo_phone'];
    $ngo_city = $_POST['ngo_city'];
    $ngo_address = $_POST['ngo_address'];
    $ngo_password = $_POST['ngo_password'];

    // Hash the password
    $ngo_password_hashed = password_hash($ngo_password, PASSWORD_DEFAULT);

    // Process uploaded photo
    if (isset($_FILES['ngo_photo']['tmp_name']) && $_FILES['ngo_photo']['tmp_name'] != "") {
        $photo_tmp = $_FILES['ngo_photo']['tmp_name'];
        $photo_data = addslashes(file_get_contents($photo_tmp)); // Convert image to binary data
    } else {
        $photo_data = "";
    }

    // Check if the NGO email already exists
    $check_query = "SELECT email FROM login WHERE email = '$ngo_email' UNION SELECT email FROM ngo WHERE email = '$ngo_email'";
    $result = mysqli_query($connection, $check_query);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo "<h1 id='message' style='position:absolute; z-index:1; top:0px; width:100%; text-align:center; color:red; display:none;'>Account already exists</h1>";
        echo "<script>
        document.getElementById('message').style.display = 'block';
        setTimeout(function() {
            window.location.href = 'ngosignup.php';
        }, 3000); // Redirect after 3 seconds
        </script>";
    } else {
        $sql = "INSERT INTO ngo (name, email, phone, city, address, password, photo) VALUES ('$ngo_name', '$ngo_email', '$ngo_phone', '$ngo_city', '$ngo_address', '$ngo_password_hashed', '$photo_data')";

        if (mysqli_query($connection, $sql)) {
            echo "<script>alert('NGO registered successfully.'); window.location.href = 'ngosignin.php';</script>";
            exit(); // Prevent further execution
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
}
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO Registration</title>
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
    <div class="center">
        <h2>NGO Registration Form</h2>
        <div class="circular-image" id="previewImage" style="background-image: url('../default.png');"></div>

        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="txt_field">
                <input type="file" id="ngo_photo" name="ngo_photo" accept="image/*" onchange="previewPhoto()" required>
                <br><br>
                <span></span>
            </div>
            <div class="txt_field">
                <input type="text" id="ngo_name" name="ngo_name" required oninput="checkForm()">
                <input type="hidden" id="hiddenName" name="ngo_name" />
                <span></span>
                <label class="hide">NGO Name</label>
            </div>

            <div class="txt_field">
                <input type="email" id="ngo_email" name="ngo_email" required oninput="checkForm()">
                <input type="hidden" id="hiddenEmail" name="ngo_email" />
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


            <div class="txt_field" style="display:none;">
                <input type="tel" id="ngo_phone" name="ngo_phone"  required>
                <span></span>
                <label>Phone Number</label>
            </div>

            <div class="txt_field" style="display:none;">
            <select id="ngo_city" name="ngo_city" style="padding:10px; padding-left: 20px;" required>
                <option value="mumbai">Mumbai</option>
                <option value="pune">Pune</option>
                <option value="nagpur">Nagpur</option>
                <option value="nashik">Nashik</option>
                <option value="thane">Thane</option>
                <option value="aurangabad">Aurangabad</option>
                <option value="solapur">Solapur</option>
                <option value="ratnagiri">Ratnagiri</option>
                <option value="kolhapur">Kolhapur</option>
                <option value="satara">Satara</option>
                <option value="sangli">Sangli</option>
                <option value="nanded">Nanded</option>
                <option value="amravati">Amravati</option>
                <option value="akola">Akola</option>
                <option value="jalgaon">Jalgaon</option>
                <option value="dhule">Dhule</option>
                <option value="beed">Beed</option>
                <option value="latur">Latur</option>
                <option value="parbhani">Parbhani</option>
                <option value="jalna">Jalna</option>
                <option value="osmanabad">Osmanabad</option>
                <option value="chandrapur">Chandrapur</option>
                <option value="buldhana">Buldhana</option>
                <option value="yavatmal">Yavatmal</option>
                <option value="wardha">Wardha</option>
                <option value="washim">Washim</option>
                <option value="gondia">Gondia</option>
                <option value="gadchiroli">Gadchiroli</option>
                <option value="raigad">Raigad</option>
                <option value="sindhudurg">Sindhudurg</option>
                <option value="palghar">Palghar</option>
                <option value="hingoli">Hingoli</option>
            </select><br><br>
        </div>
            <div class="txt_field" style="display:none;">
                <input type="text" id="address" name="ngo_address" required>
                <span></span>
                <label for="address">Address</label>
            </div>

            <div class="txt_field" style="display:none;">
                <input type="password" id="ngo_password" name="ngo_password" minlength="8" maxlength="15" required>
                <span></span>
                <label for="ngo_password">Password</label>
            </div>

            <input type="submit" name="signup" id="signupBtn" value="Signup">

            <div class="signup_link">Already a member? <a href="ngosignin.php">Sign in</a></div>
        </form>
    </div>

    <script>
        function previewPhoto() {
            const preview = document.getElementById('previewImage');
            const fileInput = document.getElementById('ngo_photo');
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.style.backgroundImage = `url(${reader.result})`;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.backgroundImage = "url('../default.png')";
            }
        }

        function validateForm() {
            var email = document.getElementById('ngo_email').value;
            var password = document.getElementById('ngo_password').value;
            var username = document.getElementById('ngo_name').value;

            if (password.length < 8 || password.length > 15) {
                alert("Password must be between 8 and 15 characters long.");
                return false;
            }
            return true;
        }

        function checkForm() {
            const email = document.getElementById('ngo_email').value.trim();
            const username = document.getElementById('ngo_name').value.trim();
            const sendBtn = document.getElementById('sendBtn');

            sendBtn.disabled = !(email && username);
        }

        function hideLabels() {
            const labels = document.querySelectorAll('label.hide');
            labels.forEach(label => {
                const input = label.previousElementSibling;
                if (input && input.type === 'hidden') {
                    label.style.display = 'none';
                }
            });
        }

        document.getElementById('sendBtn').addEventListener('click', function () {
            const email = document.getElementById('ngo_email').value.trim();
            const username = document.getElementById('ngo_name').value.trim();

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

            document.getElementById('hiddenEmail').value = email;
            document.getElementById('hiddenName').value = username;

            fetch('otp_handler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=send_otp&email=${email}&name=${username}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('verifyBtn').style.display = 'block';
                        document.getElementById('sendBtn').style.display = 'none';
                        document.getElementById('ngo_email').disabled = true;
                        document.getElementById('ngo_name').disabled = true;
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .then(hideLabels); // Call hideLabels after the fetch completes
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
                        document.querySelectorAll('.txt_field, .radio').forEach(div => {
                            div.style.display = 'block';
                        });
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                });
        });

        document.addEventListener("DOMContentLoaded", hideLabels); // Initial call to hideLabels when the page loads


    </script>
</body>

</html>