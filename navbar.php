<?php
include 'connection.php';
if (isset($_SESSION['uemail'])) {
$email = $_SESSION['uemail'];
$sql = "SELECT * FROM login WHERE email='$email'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$image = base64_encode($row['profile_image']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="navbar.css">
  <style>
    :root {
      --navcolor: #344E41;
      /* Updated to a darker green */
      --navfont: #F5F5DC;
      /* Beige for font */
      --green: #588157;
      --light-green: #8FCB9B;
      --dark-green: #344E41;
      --brown: #6F4E37;
      --beige: #F5F5DC;
      --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
      --font-family: 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, Helvetica, sans-serif;
    }

    /* Header */
    header {
      position: fixed;
      top: 0;
      z-index: 1;
      height: 80px;
      background-color: var(--navcolor);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      width: 100%;
      box-shadow: var(--box-shadow);
    }

    .logo {
      padding-right: 20px;
    }

    .logo p {
      margin: 0;
      font-size: 24px;
      /* Increased font size for better visibility */
      color: var(--navfont);
    }

    .logo b {
      color: var(--light-green);
    }

    #search {
      display: flex;
      align-items: center;
    }

    #search input {
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 20px;
      margin-right: 10px;
      font-size: 16px;
    }

    #search button {
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      background-color: var(--green);
      color: var(--navfont);
      cursor: pointer;
      transition: background-color 0.3s;
    }

    #search button:hover {
      background-color: var(--dark-green);
    }

    .hamburger {
      display: none;
      flex-direction: column;
      cursor: pointer;
    }

    .hamburger .line {
      width: 25px;
      height: 3px;
      background-color: var(--navfont);
      margin: 5px 0;
    }

    .nav-bar {
      display: flex;
      align-items: center;
    }

    .nav-bar ul {
      list-style: none;
      margin: 0;
      display: flex;
      align-items: center;
    }

    .nav-bar ul li {
      margin: 0 10px;
    }

    .nav-bar ul li a {
      text-decoration: none;
      color: var(--navfont);
      padding: 10px;
      border-radius: 5px;
      transition: color 0.3s, background-color 0.3s;
    }

    .nav-bar ul li a:hover,
    .nav-bar ul li a.active {
      color: var(--navcolor);
      background-color: var(--light-green);
    }

    #profile {
      width: 40px;
      height: 40px;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      padding: 5px;
      border: 1px solid #ccc;
      background-color: #fff;
      border-radius: 50%;
      cursor: pointer;
      overflow: hidden;
    }

    #profile img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    select#profile {
      background-image: url("data:image/jpeg;base64,<?php echo $image; ?>");
      background-repeat: no-repeat;
      background-size: cover;
    }

    /* Hide the default arrow */
    select {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      padding: 10px;
      font-family: var(--font-family);
      font-size: 16px;
      width: 200px;
      height: 40px;
      cursor: pointer;
    }

    select:hover {
      border-color: #aaa;
    }

    select:focus {
      outline: none;
      border-color: var(--light-green);
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .select-arrow {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-top: 5px solid #555;
      pointer-events: none;
    }

    select:hover~.select-arrow {
      border-top-color: #333;
    }

    /* Responsive */
    @media only screen and (max-width: 775px) {
      .hamburger {
        display: flex;
      }

      .nav-bar {
        display: none;
        flex-direction: column;
        align-items: center;
        position: absolute;
        top: 80px;
        left: 0;
        right: 0;
        background-color: var(--navcolor);
      }

      .nav-bar.active {
        display: flex;
      }

      .nav-bar ul {
        flex-direction: column;
        align-items: center;
      }

      .nav-bar ul li {
        margin: 10px 0;
      }

      #profile {
        width: 30px;
        height: 30px;
      }
    }

    @media only screen and (max-width: 575px) {
      .logo p {
        font-size: 20px;
      }

      .logo b {
        font-size: 22px;
      }

      #search input {
        padding: 8px;
        font-size: 14px;
      }

      #search button {
        padding: 8px 15px;
        font-size: 14px;
      }

      .nav-bar ul li a {
        font-size: 14px;
      }
    }

    @media only screen and (max-width: 453px) {
      .logo p {
        font-size: 18px;
      }

      .logo b {
        font-size: 20px;
      }

      #search input {
        padding: 6px;
        font-size: 12px;
      }

      #search button {
        padding: 6px 12px;
        font-size: 12px;
      }

      .nav-bar ul li a {
        font-size: 12px;
      }

      #profile {
        padding: 3px;
        font-size: 12px;
      }
    }
  </style>
</head>

<body>
  <header>
    <div class="logo" id="left">
      <p>Easy <b>Food</b></p>
      <p>Network</p>
    </div>
    <div class="hamburger">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
    </div>
    <nav class="nav-bar">
      <ul>
        <li id='home'><a href="index.php">Home</a></li>
        <li id='about'><a href="about.php">About</a></li>
        <li id='ngo'><a href="ngodetail.php">NGO</a></li>
        <li id='contact'><a href="contact.php">Contact</a></li>
        <li id='donate'><a href="fooddonateform.php">Donate Food</a></li>
        <?php if (isset($_SESSION['uname'])) { ?>
          <!-- User is logged in -->
        <?php } else { ?>
          <li id="login"><a href="page.php">Login/Registration</a></li>
        <?php } ?>
      </ul>
      <?php if (isset($_SESSION['uname'])) { ?>
        <select name="profile" id="profile" onchange="navigateProfile()">
          <option value=""></option>
          <option value="logout">Sign out</option>
          <option value="profile">Profile</option>
        </select>
        <span class="select-arrow"></span>
      <?php } ?>
    </nav>
  </header>

  <script>
    function navigateProfile() {
      var selectElement = document.getElementById("profile");
      var selectedValue = selectElement.value;

      if (selectedValue === "logout") {
        window.location.href = "logout.php";
      } else if (selectedValue === "profile") {
        window.location.href = "profile.php";
      }
    }

    document.querySelector(".hamburger").onclick = function () {
      document.querySelector(".nav-bar").classList.toggle("active");
    }
  </script>
</body>

</html>