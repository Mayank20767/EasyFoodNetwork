<?php session_start()?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Easy Food Network</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
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

    /* html {
      scroll-behavior: smooth;
    } */

    * {
      margin: 0;
      padding: 0;
      list-style: none;
      text-decoration: none;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-family);
      background: linear-gradient(to right, #f7f7f7, #ffffff);
      color: var(--dark-green);
      line-height: 1.2;
    }

    /* in which u have  */
    #home a {
      background-color: var(--light-green);
    }

    /* Main Start */
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


    .heading:hover {
      letter-spacing: 3px;
    }

    /* Carousel Section Styles */
    .carousel-section {
      position: relative;
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

    .carousel-content img {
      min-height: 400px;
      height: 520px;
      width: 100%;
      object-fit: cover;
    }

    .carousel-caption {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 10px;
      color: #fff;
      text-align: center;
    }

    /* Our Works Section Styles */
    .our-works-extraordinary {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 40px;
    }

    .short-about,
    .carousel-container {
      flex: 1;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-left: 20px;
    }

    .carousel-container {
      max-width: 400px;
      padding: 10px;
      background-color: #ffffff;
    }

    /* ****************Gallery Section Styles********************** */
    .gallery {
      margin: 20px;
    }

    .images {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 10px;
      margin-top: 20px;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .image {
      background-color: #ddd;
      height: 200px;
      position: relative;
      overflow: hidden;
    }

    .image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(rgba(255, 255, 255, 0.175), rgba(255, 255, 255, 0));
      transition: all 0.3s ease;
    }

    .image:hover::before {
      background: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.7));
      transform: translateY(100%);
    }

    .image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: all 0.3s ease;
    }

    .image:hover img {
      transform: scale(1.1);
    }



    /* Steps Section Styles */
    .main-div {
      text-align: center;
      margin-top: 50px;
    }

    .steps {
      display: flex;
      justify-content: space-around;
      align-items: center;
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

    .step {
      width: 300px;
      height: 300px;
      display: flex;
      flex-direction: column;
      align-items: center;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .step:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .step img {
      width: 200px;
      height: 200px;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }

    .step:hover img {
      transform: scale(1.1);
    }

    .arrow {
      width: 50px;
      height: 150px;
      background-image: url('wave_arrow.png');
      background-size: contain;
      background-repeat: no-repeat;
    }


    /* About Section Styles */
    .about-section-extraordinary {
      margin-top: 40px;
    }

    /* about section start */
    .about {
      margin-top: 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      border-radius: 20px;
      background-color: #ffffff;
      box-shadow: var(--box-shadow);
      border: none;
      background-image: linear-gradient(to right, transparent 0%, var(--green) 100%);
      background-size: 100% 2px;
      background-repeat: no-repeat;
      background-position: bottom;
      transition: background-size 0.3s ease;
      animation: fadeInLeft 1s ease-out;
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

    .about-image {
      width: 40%;
      border-right: 2px solid var(--green);
      padding: 10px;
    }

    .about-image video {
      max-width: 100%;
      height: auto;
      transition: opacity 0.3s ease;
    }

    .about-text {
      width: 60%;
      padding: 10px;
    }

    .about-text p {
      font-size: 19px;
      color: #344E41;
    }

    .about-text a {
      display: inline-block;
      margin-top: 10px;
      color: var(--green);
      text-decoration: none;
      transition: color 0.3s ease;
      position: relative;
    }

    .about-text a:hover {
      text-decoration: underline;
      color: #476b4b;
    }

    .about-text a::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -2px;
      width: 100%;
      height: 2px;
      background-color: var(--green);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .about-text a:hover::after {
      transform: scaleX(1);
    }

    .about:hover {
      background-size: 0% 2px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: var(--green);
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #476b4b;
    }


    /* Map Section Style */

    .deli {
      display: grid;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }

    .para {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .deli img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: var(--box-shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      /* Added transition for box-shadow */
    }

    .deli img:hover {
      transform: scale(1.05);
    }

    /* Feedback Section */
    .feedbacks {
      padding: 20px;
    }

    .feedbacks-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .feedback {
      border: 1px solid var(--dark-green);
      border-radius: 10px;
      padding: 10px;
      box-shadow: var(--box-shadow);
    }

    .feedback-svg {
      display: block;
      /* margin: 0 auto; */
    }

    /* Media query for larger screens */
    @media (min-width: 768px) {
      .feedbacks-container {
        flex-direction: row;
        flex-wrap: wrap;
      }

      .feedback {
        width: calc(33.33% - 40px);
        /* Adjust width for 3 columns with some spacing */
      }
    }

    /* Media query for medium screens */
    @media (max-width: 768px) {
      .feedbacks-container {
        flex-direction: column;
        align-items: center;
      }

      .feedback {
        max-width: 90%;
      }

      .about {
        flex-direction: column;
      }

      .about-image,
      .about-text {
        width: 100%;
        padding: 10px;
      }

      .steps {
        flex-direction: column;
      }
    }

    /* Media query for smaller screens */
    @media (max-width: 884px) {
      .short-about {
        overflow-y: scroll;
        float: left;
        width: 50%;
        max-height: 200px;
      }
    }

    /* Media query for even smaller screens */
    @media (max-width: 700px) {
      .short-about {
        width: 100%;
        max-height: 150px;
        text-align: center;
        overflow-x: scroll;
      }
    }

    /* Media query for smallest screens */
    @media (max-width: 400px) {
      .our-works-extraordinary {
        flex-direction: column;
        gap: 20px;
      }

      .short-about {
        width: 100%;
        max-height: 150px;
        text-align: center;
        overflow-x: scroll;
        overflow-y: scroll;
        float: left;
      }

      .carousel-container {
        width: 100%;
      }
    }
  </style>

</head>

<body>
  <?php include "navbar.php" ?>
  <!-- Main Section -->
  <main>
    <!-- Carousel Section -->
    <section class="carousel-section animate">
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-content">
              <img class="d-block w-100" src="img/slide1.jpg" alt="First slide">
            </div>
            <div class="carousel-caption d-none d-md-block">
              <p>“Cutting food waste is a delicious way of saving money, helping to feed the world and protect the
                planet.”</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-content">
              <img class="d-block w-100" src="img/slide2.jpg" alt="Second slide">
            </div>
            <div class="carousel-caption d-none d-md-block">
              <p>“Cutting food waste is a delicious way of saving money, helping to feed the world and protect the
                planet.”</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-content">
              <img class="d-block w-100" src="img/4.jpeg" alt="Third slide">
            </div>
            <div class="carousel-caption d-none d-md-block">
              <p>“Cutting food waste is a delicious way of saving money, helping to feed the world and protect the
                planet.”</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </section>


    <!-- Our Works Section -->
    <section class="our-works-extraordinary">

      <div class="short-about animate">
        <h2 class="heading animate">About</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima voluptas, eaque nemo quod
          perferendis consectetur voluptate quae reprehenderit quasi quidem, aut impedit a sunt, vitae expedita enim.
          Itaque at tempora quis aliquid. Repellat rem incidunt deserunt cumque illum. Iusto ea quibusdam
          saepe ipsa quia natus impedit a repudiandae itaque. Assumenda hic dignissimos iure commodi aliquid
        </p>
      </div>

      <div class="carousel-container animate">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/p1.jpeg" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
              <img src="img/p4.jpeg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
              <img src="img/p3.jpeg" class="d-block w-100" alt="Image 3">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </section>


    <div class="gallery animate">
      <h2 class="heading">This Is Our Gallery</h2>
      <div class="images">
        <div class="image">
          <img src="img/2nd.jpg" alt="">
        </div>
        <div class="image">
          <img src="img/4.jpeg" alt="">
        </div>
        <div class="image">
          <img src="img/5th.jpg" alt="">
        </div>
        <!-- Add more images as needed -->
      </div>
    </div>

    <div class="main-div">
      <h2 class="heading">How We Work</h2>
      <div class="steps">
        <div class="step">
          <img src="img\user_steps\Rigster.png" alt="Step 1">
          <p>Register on our platform to get started.</p>
        </div>
        <div class="arrow"></div>
        <div class="step">
          <img src="img\user_steps\login.png" alt="Step 2">
          <p>Log in to access your account and explore features.</p>
        </div>
        <div class="arrow"></div>
        <div class="step">
          <img src="img\user_steps\donate.png" alt="Step 3">
          <p>Make a donation to support our cause.</p>
        </div>
        <div class="arrow"></div>
        <div class="step">
          <img src="img\user_steps\food.png" alt="Step 4">
          <p>See how your contributions are used to provide food.</p>
        </div>
        <div class="arrow"></div>
        <div class="step">
          <img src="img\user_steps\review.png" alt="Step 5">
          <p>Review the impact of your donations and provide feedback.</p>
        </div>
      </div>
    </div>

    <!-- About Section -->
    <section class="about-section-extraordinary">
      <div class="about">
        <div class="about-image">
          <video src="img/vid.mp4" loop controls autoplay></video>
        </div>
        <div class="about-text">
          <p>The basic concept of this project Food Waste Management is to collect the excess/leftover food from
            donors such as hotels, restaurants, marriage halls, etc and distribute to the needy people.</p>
          <a href="/about.html">Read more</a>
        </div>
      </div>
    </section>


    <br><br>
    <!-- Door Pickup Section -->
    <section class="door-pickup">
      <h2 class="heading">Door Pickup</h2>
      <div class="deli" style="display: grid;">
        <br>
        <p class="para">"Your donate will be immediately collected and sent to needy people "</p>
        <img src="img/delivery.gif" alt="" style="margin-left:auto; margin-right: auto;">
      </div>
      <div class="ser"></div>
    </section>



    <!-- Feedbacks Section -->
    <?php
    include "connection.php";
    $array_feedback = [];

    $query = "SELECT * FROM feedback";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $rating = $row['rating'];
        $comments = $row['comment'];
        $array_feedback[] = ['name' => $name, 'rating' => $rating, 'comment' => $comments];
      }
    }

    // Shuffle the feedback array
    shuffle($array_feedback);

    // Close the database connection
    mysqli_close($connection);
    ?>


    <section class="feedbacks">
      <div>
        <h1 class="heading">Feedbacks</h1>
        <div class="feedbacks-container" id="feedbacks-container">
          <!-- Initial 3 feedbacks will be dynamically loaded here -->
          <?php for ($i = 0; $i < min(3, count($array_feedback)); $i++): ?>
            <div class="feedback">
              <svg class="feedback-svg">
                <!-- Circle -->
                <circle cx="50" cy="50" r="30" fill="<?= ($array_feedback[$i]['rating'] > 3) ? 'green' : 'red'; ?>"
                  stroke="var(--dark-green)" stroke-width="2" />

                <!-- Text inside circle -->
                <text x="50" y="52" text-anchor="middle" alignment-baseline="middle" font-family="Arial" font-size="20"
                  font-weight="bold" fill="white"><?= $array_feedback[$i]['rating']; ?></text>

                <!-- Text Rating -->
                <text x="20" y="100" font-family="Poppins" font-size="12" font-weight="bold"
                  style="text-transform:uppercase;" fill="var(--dark-green)">Rating</text>

                <!-- Heading Box -->
                <text x="100" y="50" font-family="Poppins" font-size="18" font-weight="bold"
                  style="text-transform:uppercase;" fill="var(--dark-green)"><?= $array_feedback[$i]['name']; ?></text>

                <!-- Text Box -->
                <text x="110" y="80" font-family="Poppins" font-size="14" font-weight="light"
                  style="text-transform:capitalize;"
                  fill="var(--dark-green)"><?= $array_feedback[$i]['comment']; ?></text>
              </svg>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </section>
  </main>

  <?php include "footer.php" ?>


  <!-- Scripts -->
  <script>

    document.addEventListener("DOMContentLoaded", function () {
      var cards = document.querySelectorAll('.card');
      cards.forEach(function (card) {
        var content = card.querySelector('.card-text');
        var readMoreBtn = card.querySelector('.read-more-btn');

        readMoreBtn.addEventListener('click', function () {
          content.classList.toggle('collapsed');
          if (content.classList.contains('collapsed')) {
            readMoreBtn.innerText = 'Read More';
          } else {
            readMoreBtn.innerText = 'Read Less';
          }
        });
      });
    });

    document.addEventListener("DOMContentLoaded", () => {
      const options = {
        root: null, // relative to the viewport
        rootMargin: "0px",
        threshold: 0.1 // element must be 10% visible
      };

      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("animate");
            observer.unobserve(entry.target); // Remove if you only want to animate once
          }
        });
      }, options);

      const elementsToAnimate = document.querySelectorAll(".heading, .carousel-section");
      elementsToAnimate.forEach(element => {
        observer.observe(element);
      });
    });



  </script>


  </script>
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>


</body>

</html>