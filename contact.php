<?php session_start()?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link rel="stylesheet" href="chatbot.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,500;0,700;0,800;1,400;1,600&display=swap');

    /* Your CSS styles go here */

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
      line-height: 1.2;
    }



    #contact a {
      background-color: var(--light-green);
    }


    main {
      padding: 100px 20px 0px 20px;
    }

    .heading {
      font-size: 28px;
      font-weight: bold;
      text-align: center;
      background-color: #f0f0f0;
      padding: 20px;
      transition: letter-spacing 0.3s ease;
      text-transform: uppercase;
    }

    /* Style for the form container */
    form {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f2f2f2;
      border-radius: 8px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .text,
    input[type="email"],
    textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="file"] {
      margin-bottom: 10px;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .error-message {
      color: red;
      font-size: 14px;
    }


    /* GMAIL,PHONE,ADDRESS */
    .contact-info {
      text-align: center;
      padding: 20px;
    }



    /* Chatboot */
    .chat {
      height: 300px;
      width: 50vw;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    ::-webkit-input-placeholder {
      color: .711
    }

    #input {
      border: 0;
      padding: 15px;
      margin-left: auto;
      border-radius: 10px;
    }

    .messages {
      display: flex;
      flex-direction: column;
      overflow: scroll;
      height: 90%;
      width: 100%;
      background-color: white;
      padding: 15px;
      margin: 15px;
      border-radius: 10px;
    }

    #bot {
      margin-left: auto;
    }

    .bot {
      font-family: Consolas, 'Courier New', Menlo, source-code-pro, Monaco, monospace;
    }

    .avatar {
      height: 25px;
    }

    .response {
      display: flex;
      align-items: center;
      margin: 1%;
    }

    .img {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 30px;
    }

    .cover {
      width: 100%;
      height: 400px;
      background: url("img/image.jpg") no-repeat;
      background-size: cover;
      display: grid;
      place-items: center;
      padding-top: 8rem;
    }

    /* Mobile */
    @media only screen and (max-width: 800px) {
      .container {
        flex-direction: column;
        justify-content: flex-start;
      }

      .chat {
        width: 75vw;
        margin: 10vw;
      }

      .img img {
        width: 600px;
        height: 500px;
      }
    }

    /* togglelist */
    .accordion {
      background-color: rgba(255, 255, 255, 0.856);
      color: #444;
      cursor: pointer;
      padding: 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px;
      transition: 0.4s;
    }

    .accordion:hover {
      background-color: #ccc;
    }

    .accordion:after {
      content: '\002B';
      color: #777;
      font-weight: bold;
      float: right;
      margin-left: 5px;
    }

    .active:after {
      /* content: "\2212"; */
    }

    .panel {
      padding: 0 18px;
      background-color: white;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.2s ease-out;
    }

    /* Your additional CSS styles go here */

    /* Mobile */
    @media only screen and (max-width: 800px) {

      /* Adjust chat width and margins */
      .chat {
        width: 90vw;
        margin: 5vw;
      }

      /* Adjust image size */
      .img img {
        width: 90%;
        height: auto;
      }

      /* Adjust cover height */
      .cover {
        height: 300px;
        /* Adjust height as needed */
        padding-top: 5rem;
      }
    }

    /* Tablet */
    @media only screen and (min-width: 801px) and (max-width: 1024px) {

      /* Adjust chat width and margins */
      .chat {
        width: 70vw;
        margin: 5vw;
      }

      /* Adjust image size */
      .img img {
        width: 80%;
        height: auto;
      }

      /* Adjust cover height */
      .cover {
        height: 350px;
        /* Adjust height as needed */
        padding-top: 6rem;
      }
    }

    /* Desktop */
    @media only screen and (min-width: 1025px) {

      /* Adjust chat width and margins */
      .chat {
        width: 50vw;
        margin: 5vw;
      }

      /* Adjust image size */
      .img img {
        width: 70%;
        height: auto;
      }

      /* Adjust cover height */
      .cover {
        height: 400px;
        /* Adjust height as needed */
        padding-top: 7rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar Section -->
  <?php include 'navbar.php' ?>

  <main>
    <section class="cover">

    </section>
    <p class="heading" style=" margin: 20px;">contact us </p>

    <div class="contact-form">
      <form action="insert_contact_details.php" method="post" enctype="multipart/form-data">
        <br><br><label for="name">Name:</label>
        <input type="text" id="name" name="name" class="text" required>
        <br> <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br> <label for="message">Message:</label> <textarea id="message" name="complain"></textarea>
        <br>
        <input type="submit" value="Send" name="send">
      </form>
    </div>

    <div class="contact-info" style="padding: 10px;">
      <p>Email: easyfoodnetwork@gmail.com</p>
      <p>Phone: 555-555-5555</p>
      <p>Address: D.Y Patil College Pune Maharashta</p>
    </div>


    <div class="chatbot" style="padding: 30px; background-color: rgba(151, 243, 199, 0.5);">
      <p class="heading">chat bot support <img src="bot-mini.png" alt="" height="20"></p>

      <div id="container" class="container">


        <div id="chat" class="chat">
          <div id="messages" class="messages"></div>
          <input id="input" type="text" placeholder="Say something..." autocomplete="off" class="text" />
        </div>

      </div>
      <div class="help">
        <p class="heading">Help & FAQs?</p>

        <button class="accordion">how to donate food ?</button>
        <div class="panel">
          <p>1)click on <a href="fooddonate.html">donate</a> in home page </p>
          <p>2)fill the details </p>
          <p>3)click on submit</p>
          <img src="img/mobile.jpg" alt="" width="100%">
        </div>

        <button class="accordion">How will my donation be used?</button>
        <div class="panel">
          <p style="padding: 10px;"> Your donation will be used to support our mission and the various programs and
            initiatives that we have in place. Your donation will help us to continue providing assistance and support
            to
            those in need. You can find more information about our programs and initiatives on our website. If you have
            any specific questions or concerns, please feel free to contact us</p>
        </div>

        <button class="accordion">What should I do if my food donation is near or past its expiration date?</button>
        <div class="panel">
          <p style="padding: 10px;">We appreciate your willingness to donate, but to ensure the safety of our clients we
            can't accept food that is near or past its expiration date. We recommend checking expiration dates before
            making a donation or contact us for further guidance</p>

        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'footer.php' ?>

</body>
<script type="text/javascript" src="chatbot/chatbot.js"></script>
<script type="text/javascript" src="chatbot/constants.js"></script>
<script type="text/javascript" src="chatbot/speech.js"></script>
<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }

  function previewPhoto() {
    var preview = document.getElementById('previewImage');
    var file = document.getElementById('photo').files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
      preview.src = reader.result;
    }

    if (file) {
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
    }
  }
</script>

</html>