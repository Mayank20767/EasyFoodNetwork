<?php
include '../connection.php';
$msg = 0;

if (isset($_POST['sign'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $location = $_POST['district'];
  $chosen_ngos = isset($_POST['chosen_ngos']) ? implode(",", $_POST['chosen_ngos']) : '';

  $pass = password_hash($password, PASSWORD_DEFAULT);
  $sql = "SELECT * FROM delivery_persons WHERE email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    echo "<h1><center>Account already exists</center></h1>";
  } else {
    $query = "INSERT INTO delivery_persons (name, email, password, city, choose_ngo) VALUES ('$username', '$email', '$pass', '$location', '$chosen_ngos')";
    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
      header("location:deliverylogin.php");
    } else {
      echo '<script type="text/javascript">alert("Data not saved")</script>';
    }
  }
}

// Fetching NGOs
$query = "SELECT id, name, city FROM ngo WHERE confirm=1";
$ngos = [];
$result = mysqli_query($connection, $query);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $ngos[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Persons Signup</title>
  <style>
    /* Include the updated CSS styles here */
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
      --font-family: 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, Helvetica, sans-serif;
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
      font-family: var(--font-family);
      background: linear-gradient(to right, #f7f7f7, #ffffff);
      color: var(--dark-green);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .center {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: var(--box-shadow);
      max-width: 400px;
      width: 100%;
    }

    .center h1 {
      margin-bottom: 20px;
      font-size: 24px;
      color: var(--green);
      text-align: center;
    }

    .txt_field {
      position: relative;
      margin-bottom: 30px;
    }

    .txt_field input {
      width: 100%;
      padding: 10px;
      border: none;
      border-bottom: 2px solid var(--dark-green);
      outline: none;
      background: none;
      font-size: 16px;
      color: var(--dark-green);
    }

    .txt_field label {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      color: var(--brown);
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
      margin-bottom: 20px;
      border: 1px solid var(--dark-green);
      font-size: 16px;
      border-radius: 4px;
    }

    .dropdown {
      position: relative;
      margin-bottom: 20px;
    }

    .dropbtn {
      background-color: var(--green);
      color: white;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
      text-align: left;
    }

    .dropbtn:hover,
    .dropbtn:focus {
      background-color: var(--light-green);
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 100%;
      box-shadow: var(--box-shadow);
      border-radius: 4px;
      z-index: 1;
    }

    .dropdown-content label {
      display: flex;
      align-items: center;
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .dropdown-content label:hover {
      background-color: #f1f1f1;
    }

    .dropdown-content input[type="checkbox"] {
      margin-right: 10px;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      background: var(--green);
      color: white;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: var(--light-green);
    }

    .signup_link {
      margin-top: 20px;
      text-align: center;
    }

    .signup_link a {
      color: var(--green);
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="center">
    <h1>Register</h1>
    <form method="post" action="" onsubmit="return validateForm()">
      <div class="txt_field">
        <input type="text" id="username" name="username" required />
        <span></span>
        <label>Username</label>
      </div>
      <div class="txt_field">
        <input type="email" id="email" name="email" required />
        <span></span>
        <label>Email</label>
      </div>
      <div class="txt_field">
        <input type="password" id="password" name="password" required />
        <span></span>
        <label>Password</label>
      </div>
      <div>
        <select id="district" name="district" onchange="filterNGOs()" required>
          <option value="mumbai">Mumbai</option>
          <option value="pune">Pune</option>
          <!-- Add other options as needed -->
        </select>
      </div>
      <div>
        <label for="NGO">NGOs:</label>
        <div class="dropdown">
          <button class="dropbtn" type="button">Select Options</button>
          <div class="dropdown-content" id="ngo-dropdown">
            <label class="dropdown-item"><input type="checkbox" id="select-all"> All</label>
            <?php foreach ($ngos as $ngo) { ?>
              <label class="dropdown-item ngo-item" data-city="<?php echo htmlspecialchars($ngo['city']); ?>">
                <input type="checkbox" name="chosen_ngos[]" value="<?php echo htmlspecialchars($ngo['id']); ?>">
                <?php echo htmlspecialchars($ngo['name']); ?> (<?php echo htmlspecialchars($ngo['city']); ?>)
              </label>
            <?php } ?>
          </div>
        </div>
      </div>
      <input type="submit" name="sign" value="Register">
      <div class="signup_link">
        Already a member? <a href="deliverylogin.php">Sign in</a>
      </div>
    </form>
  </div>

  <script>
    function validateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      var usernameRegex = /^[a-zA-Z0-9_]+$/;
      if (!usernameRegex.test(username)) {
        alert("Username should not contain special characters.");
        return false;
      }

      if (password.length < 6) {
        alert("Password should be at least 6 characters long.");
        return false;
      }

      return true;
    }

    function filterNGOs() {
      var district = document.getElementById("district").value;
      var ngos = document.querySelectorAll(".ngo-item");

      ngos.forEach(function (ngo) {
        if (ngo.getAttribute("data-city") === district) {
          ngo.style.display = "block";
        } else {
          ngo.style.display = "none";
        }
      });
    }

    document.getElementById("select-all").addEventListener("change", function () {
      var checkboxes = document.querySelectorAll(".ngo-item input[type='checkbox']");
      if (this.checked) {
        checkboxes.forEach(function (checkbox) {
          checkbox.checked = false;
          checkbox.disabled = true;
        });
      } else {
        checkboxes.forEach(function (checkbox) {
          checkbox.disabled = false;
        });
      }
    });
  </script>
</body>

</html>