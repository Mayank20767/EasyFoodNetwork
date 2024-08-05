<?php session_start()?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <!-- <link rel="stylesheet" href="about2.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

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
    font-family: var(--font-family);
    background: linear-gradient(to right, #f7f7f7, #ffffff);
    color: var(--dark-green);
    line-height: 1.2;
  }

  /* Links */
  #about a {
    background-color: var(--light-green);
  }

  /* Main Section */
  main {
    padding: 100px 20px 0px 20px;
  }

  /* Heading Class Style */
  .heading {
    font-size: 28px;
    font-weight: bold;
    text-align: center;
    background-color: #f0f0f0;
    padding: 20px;
    transition: letter-spacing 0.3s ease;
    text-transform: uppercase;
    animation: fadeIn 3s ease-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  /* About Us Section */
  #about-us {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
    background-color: rgba(151, 243, 199, 0.5);
    text-align: center;
    animation: slideIn 1s ease-out;
  }

  @keyframes slideIn {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }

      to {
        transform: translateX(0);
        opacity: 1;
      }
    }


  .about-us-content {
    max-width: 600px;
    margin: 0 auto;
  }

  .about-us-content ul {
    list-style: none;
    color: var(--dark-green);
    display: flex;
    justify-content: space-between;
  }

  .about-us-content ul a {
    color: var(--dark-green);
    text-decoration: none;
    padding: 5px;
    border-radius: 10px;
  }

  .about-us-content ul a:hover {
    transform: scale(1.1);
    background-color: var(--green);
  }

  /* WELCOME TITLE */
  .title {
    text-align: center;
    font-size: 40px;
    text-transform: uppercase;
    font-weight: bold;
    animation: fadeInUp 1s ease-out;
  }

  @keyframes fadeInUp {
      from {
        transform: translateY(50%);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

  /* NGO WITH DISCRIPTION Styles */
  .d-flex {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
  }

  .card {
    width: 300px;
    border: 1px solid var(--brown);
    border-radius: 10px;
    box-shadow: var(--box-shadow);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background-color: white;
  }

  .card-img-top {
    width: 100%;
    height: 300px;
    object-fit: contain;
    padding:20px;
  }

  .card-body {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .card-text {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .card-text.collapsed {
    max-height: 50px;
  }

  .read-more-btn {
    align-self: start;
    padding: 5px 10px;
    background-color: var(--green);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
  }

  .read-more-btn:hover {
    background-color: var(--dark-green);
  }


  /* Carousel Section */

  .carousel-section {
    animation: fadeInLeft 1s ease-out
  }

  .carousel-content {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 30px;
  }

  @keyframes fadeInLeft {
    from {
      transform: translateX(-100%);
      opacity: 0;
    }

    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  .carousel-content .carousel-image-container {
    width: 40%;
    border-top-left-radius: 100px;
    position: relative;
  }

  .carousel-content .carousel-image-container::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.2);
    border-top-left-radius: 100px;
  }

  .carousel-pera-container {
    width: 60%;
    font-size: 18px;
    font-weight: bold;
    line-height: 1.6;
    color: var(--dark-green);
  }

  /* Map Section */
  .map {
    text-align: center;
    padding-bottom: 10px;
  }

  iframe {
    width: 100%;
    height: 600px;
    border: 0;
  }

  /* Media Queries */
  @media screen and (max-width: 481px) {
    .carousel-pera-container {
      font-size: 14px;
    }
  }

  /* Responsive Styling */
  @media only screen and (max-width: 768px) {
    .card-img-top {
      max-width: 100%;
      padding: 50px;
      height: auto;
    }

    .card-body {
      max-height: 100px;
      overflow-y: auto;
    }

    .read-more-btn {
      display: block;
    }

    .card-text.collapsed {
      max-height: 50px;
      overflow: hidden;
    }
  }

  @media only screen and (min-width: 769px) {
    .card-body {
      max-height: none;
      overflow-y: visible;
    }

    .read-more-btn {
      display: none;
    }
  }
</style>

<body>

  <!-- Navbar section -->
  <?php include 'navbar.php' ?>

  <!-- Main content -->
  <main>

    <!-- About Us section -->
    <section id="about-us">
      <div class="about-us-content">
        <h2>About Us</h2>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li>About Us</li>
        </ul>
      </div>
    </section>

    <br><br><br>

    <h1 class="title">"Welcome to Easy Food Network"</h1>

    <br><br><br>

    <!-- NGO section -->
    <section>
      <h2 class="heading">We Are Covering So Many NGOs</h2>
      <div class="d-flex" id="ngoCards">
        <?php
        function fetchNGOData()
        {
          $connection = mysqli_connect("localhost", "root", "");
          $db = mysqli_select_db($connection, 'demo');
          $query = "SELECT * FROM ngo WHERE confirm=1 ORDER BY RAND() LIMIT 3";
          $result = mysqli_query($connection, $query);
          if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              $image = base64_encode($row['photo']);
              echo '<div class="card">
                  <img class="card-img-top" src="data:image/jpeg;base64,' . $image . '" alt="Card image cap">
                  <div class="card-body">
                    <p class="card-text collapsed">' . $row["description"] . '</p>
                    <button class="read-more-btn">Read More</button>
                  </div>
                </div>';
            }
          }
        }
        fetchNGOData();
        ?>
      </div>
    </section>

    <br><br><br>

    <!-- Goal section -->
    <section class="carousel-section">
      <h2 class="heading">Our Goal</h2>
      <div id="carouselExample" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-content">
              <div class="carousel-image-container"
                style="background-image: url(img/p1.jpeg); background-size: cover; height: 400px;"></div>
              <div class="carousel-pera-container">
                We are a team of passionate individuals committed to addressing the issue of food waste in India. Our
                goal is to create a system that connects food donors with charities and NGOs, while also reducing the
                environmental impact of food waste.
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-content">
              <div class="carousel-image-container"
                style="background-image: url(img/2nd.jpg); background-size: cover; height: 400px;"></div>
              <div class="carousel-pera-container">
                We are a team of passionate individuals committed to addressing the issue of food waste in India. Our
                goal is to create a system that connects food donors with charities and NGOs, while also reducing the
                environmental impact of food waste.
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="carousel-content">
              <div class="carousel-image-container"
                style="background-image: url(img/1.jpeg); background-size: cover; height: 400px;"></div>
              <div class="carousel-pera-container">
                We are a team of passionate individuals committed to addressing the issue of food waste in India. Our
                goal is to create a system that connects food donors with charities and NGOs, while also reducing the
                environmental impact of food waste.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <br><br><br>

    <!-- Map section -->
    <section>
      <div class="map">
        <h2 class="heading">Location</h2>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.6679004504456!2d73.75846831489015!3d18.644028587320982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2b9c02954e8cb%3A0x525d708de1d526f2!2sAkurdi%2C%20Pimpri-Chinchwad%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1677633156837!5m2!1sen!2sin"
          width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include 'footer.php' ?>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // JavaScript to toggle the "Read More" functionality
    document.addEventListener('DOMContentLoaded', function () {
      const buttons = document.querySelectorAll('.read-more-btn');
      buttons.forEach(button => {
        button.addEventListener('click', function () {
          const cardBody = this.parentElement;
          const cardText = cardBody.querySelector('.card-text');
          if (cardText.classList.contains('collapsed')) {
            cardText.classList.remove('collapsed');
            this.textContent = 'Read Less';
          } else {
            cardText.classList.add('collapsed');
            this.textContent = 'Read More';
          }
        });
      });
    });
  </script>

</body>

</html>