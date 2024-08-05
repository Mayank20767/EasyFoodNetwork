<?php include 'session_check.php' ?>
<?php
// session_start();
include 'connection.php';
$msg = 0;

// Redirect to signup.php if user is not logged in
if (empty($_SESSION['uname'])) {
    header("location: signup.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $name = $_SESSION['uname'];
    $phone = $_SESSION['uphone'];
    $email = $_SESSION['uemail'];

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $_SESSION['uname'] = $name;
    }

    if (isset($_POST['phone'])) {
        $phone = mysqli_real_escape_string($connection, $_POST['phone']);
        $_SESSION['uphone'] = $phone;
    }

    $istrue_password = false;

    // Check old password
    $old_password = mysqli_real_escape_string($connection, $_POST['old_password']);

    // Fetch the hashed password from the database
    $sql = "SELECT password FROM login WHERE email='$email'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row && password_verify($old_password, $row['password'])) {
            $istrue_password = true;
            // Update password
            if (!empty($_POST['new_password'])) {
                $new_password = $_POST['new_password'];
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_sql = "UPDATE login SET password='$hashed_password' WHERE email='$email'";
                if (mysqli_query($connection, $update_password_sql)) {
                    echo "<script>alert('Profile updated successfully.');</script>";
                    header("Location: logout.php");
                    exit();
                } else {
                    echo "Error updating password: " . mysqli_error($connection);
                }
            }
        } else {
            $msg = 1;
            // header('location:profile_update.php');
            // exit();
        }
    } else {
        echo "Error fetching old password: " . mysqli_error($connection);
    }

    if ($istrue_password) {
        // Handle file upload
        if (!empty($_FILES['profile_image']['name'])) {
            $image = $_FILES['profile_image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            $sql = "UPDATE login SET name='$name', phone='$phone', profile_image='$imgContent' WHERE email='$email'";
        } else {
            $sql = "UPDATE login SET name='$name', phone='$phone' WHERE email='$email'";
        }

        if (mysqli_query($connection, $sql)) {
            header("Location: profile.php");
            exit();
        } else {
            echo "Error updating profile: " . mysqli_error($connection);
        }
    }

}

$email = $_SESSION['uemail'];
$sql = "SELECT * FROM login WHERE email='$email'";
$result = mysqli_query($connection, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching user data: " . mysqli_error($connection);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <!-- <link rel="stylesheet" href="navbar.css"> -->
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
    <div class="center">
        <h1>Update Profile</h1>
        <img class="circular-image" id="profileImagePreview"
            src="data:image/jpeg;base64,<?php echo base64_encode($row['profile_image']) ?: 'default.png'; ?>"
            alt="Profile Image">
        <form action="profile_update.php" method="post" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="file" id="profile_image" name="profile_image" accept="image/*"
                    onchange="previewImage(event)">
                <span></span>
                <label for="profile_image">Profile Image</label>
            </div>
            <div class="txt_field">
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                <span></span>
                <label for="name">Name</label>
            </div>
            <div class="txt_field">
                <input type="text" id="phone" name="phone" maxlength="10">
                <span></span>
                <label for="phone">Phone Number</label>
            </div>
            <div class="txt_field">
                <input type="password" id="old_password" name="old_password" minlength="8" maxlength="15" required>
                <span></span>
                <label for="old_password">Enter Password</label>
            </div>
            <?php
            if ($msg == 1 && isset($_POST['update_profile'])) {
                echo '<i class="bx bx-error-circle error-icon"></i>';
                echo '<p class="error">Password does not match.</p>';
                $msg = 0;
            }
            ?>
            <input type="submit" name="update_profile" value="Update Profile">
        </form>
        <h1>Change Password</h1>
        <form action="profile_update.php" method="post" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="password" id="old_password" name="old_password" minlength="8" maxlength="15" required>
                <span></span>
                <label for="old_password">Old Password</label>
            </div>
            <div class="txt_field">
                <input type="password" id="new_password" name="new_password" minlength="8" maxlength="15" required>
                <span></span>
                <label for="new_password">New Password</label>
            </div>
            <?php
            if ($msg == 1 && isset($_POST['change_password'])) {
                echo '<i class="bx bx-error-circle error-icon"></i>';
                echo '<p class="error">Old Password is incorrect.</p>';
                $msg = 0;
            }
            ?>
            <input type="submit" name="change_password" value="Change Password">
        </form>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('profileImagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>