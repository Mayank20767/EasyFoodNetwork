<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
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

    .footer {
      background-color: var(--dark-green);
      color: var(--beige);
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      font-family: var(--font-family);
    }

    .footer-left,
    .footer-center,
    .footer-right {
      flex: 1;
      padding: 10px;
    }

    .footer-left p,
    .footer-center p,
    .footer-right p {
      margin: 5px 0;
    }

    .footer-left span,
    .footer-center span {
      font-weight: bold;
    }

    .footer a {
      color: var(--light-green);
      text-decoration: none;
      transition: color 0.3s;
    }

    .footer a:hover {
      color: var(--beige);
    }

    .sociallist {
      margin-top: 10px;
    }

    .sociallist .social {
      margin: 0;
      list-style: none;
      padding: 0;
      display: flex;
    }

    .sociallist .social li {
      margin-right: 10px;
    }

    .sociallist .social li:last-child {
      margin-right: 0;
    }

    .sociallist .social li a {
      display: inline-block;
      transform: scale(1);
      transition: transform 0.5s, filter 0.5s;
    }

    .sociallist .social li a:hover {
      transform: scale(1.2);
      filter: brightness(1.2);
    }

    .footer-right h2 {
      margin-bottom: 10px;
    }

    .footer-right span {
      color: var(--light-green);
    }

    .menu {
      font-size: 14px;
    }

    .name {
      font-weight: bold;
      margin-top: 10px;
    }

    @media screen and (max-width: 768px) {

      .footer-left,
      .footer-center,
      .footer-right {
        flex-basis: 100%;
        margin-bottom: 20px;
        text-align: center;
      }

      .sociallist .social {
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <!-- Footer Section -->
  <footer class="footer">
    <div class="footer-left">
      <span> About us</span>
      <p>
        The basic concept of this project Food Waste Management is to collect the excess/leftover
        food from donors such as hotels, restaurants, marriage halls, etc., and distribute it to the needy people.
      </p>
    </div>
    <div class="footer-center">
      <span> Contact</span>
      <p>(+00) 0000 000 000</p>
      <p><a href="mailto:Fooddonate@gmail.com">Fooddonate@gmail.com</a></p>
      <div class="sociallist">
        <ul class="social">
          <li><a href="https://www.facebook.com/TheAkshayaPatraFoundation/"><img
                src="https://i.ibb.co/x7P24fL/facebook.png" alt="Facebook"></a></li>
          <li><a href="https://twitter.com/globalgiving"><img src="https://i.ibb.co/Wnxq2Nq/twitter.png"
                alt="Twitter"></a></li>
          <li><a href="https://www.instagram.com/charitism/"><img src="https://i.ibb.co/ySwtH4B/instagram.png"
                alt="Instagram"></a></li>
          <li><a href="https://web.whatsapp.com/"><i class="fa fa-whatsapp"
                style="font-size:50px;color: black;"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="footer-right">
      <h2>Easy <span>Food</span> Network</h2>
      <p class="menu">
        <a href="#">Home</a> |
        <a href="about.html">About</a> |
        <a href="profile.php">Profile</a> |
        <a href="contact.html">Contact</a>
      </p>
      <p class="name">Easy Food Network &copy; 2023</p>
    </div>
  </footer>
</body>

</html>