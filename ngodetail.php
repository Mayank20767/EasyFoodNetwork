<?php session_start()?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    --box-shadow: 0 .5rem 1rem rgba(0, 0, 0.1);
    --font-family: 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, Helvetica, sans-serif;;
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
}

/* Main Section */
main {
    padding: 100px 20px 0px 20px;
}

/* About Us Section */
#ngo-section {
    display: flex;
    flex-direction: column;
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

.ngo-section-content {
    max-width: 600px;
    margin: 0 auto;
}

.ngo-section-content ul {
    list-style: none;
    color: var(--dark-green);
    display: flex;
    justify-content: space-between;
}

.ngo-section-content ul a {
    color: var(--dark-green);
    text-decoration: none;
    padding: 5px;
    border-radius: 10px;
}

.ngo-section-content ul a:hover {
    transform: scale(1.1);
    background-color: var(--green);
    color: white;
}

/* Carousel search styles */
.carousel-search form {
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-search input[type="text"] {
    padding: 12px;
    border: none;
    border-radius: 4px;
    margin-right: 10px;
    width: 200px;
    margin-top: 20px;
    outline: none;
}

.carousel-search button {
    background-color: #06C167;
    color: white;
    border: none;
    padding: 12px 12px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}

.carousel-search button:hover {
    background-color: #059e4d;
}

/* NGO container styles */
.ngo-container {
    display: flex;
    margin-bottom: 30px;
    padding: 20px;
    margin-top: 30px;
    background-color: #f2f2f2;
    border-radius: 10px;
    box-shadow: var(--box-shadow);
    transition: transform 0.3s, box-shadow 0.3s;
    opacity: 0; /* Ensure elements are initially invisible */
}

.ngo-container.animate {
    animation: fadeInUp 1s ease-in-out 1;
    opacity: 1; /* Make visible when animation is applied */
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

.ngo-container:hover {
    transform: translateY(-10px);
    box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, 0.2);
}

/* NGO image styles */
.ngo-image {
    flex: 0 0 200px;
    margin-right: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ngo-image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

/* Label and detail styles */
.ngo-label {
    font-weight: bold;
    margin-bottom: 5px;
}

.ngo-detail {
    margin-bottom: 15px;
}

/* NGO detail row styles */
.ngo-detail-row {
    display: none;
    flex-direction: row;
    justify-content: space-between;
    padding: 10px 0;
    border-top: 1px solid var(--green);
    margin-top: 10px;
}

.ngo-detail-row div {
    flex: 1;
    margin: 5px;
}

.readmore {
    color: var(--green);
    cursor: pointer;
    font-weight: bold;
    text-decoration: underline;
}

.readmore:hover {
    color: var(--dark-green);
}

h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-bottom: .5rem;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 0;
    font-size: 2rem;
}

#ngo a {
    background-color: var(--light-green);
  }

    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <main>
        <!-- NGO section -->
        <section id="ngo-section">
            <div class="ngo-section-content">
                <h2>NGO's</h2>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li>NGO's</li>
                </ul>
            </div>
            <div class="carousel-search">
                <form id="search_form" action="" method="post">
                    <input type="text" name="search_query">
                    <button type="submit" name="search">Search</button>
                </form>
            </div>
        </section>

        <section>
            <?php
            $connection = mysqli_connect("localhost", "root", "");
            $db = mysqli_select_db($connection, 'demo');
            if (isset($_POST['search'])) {
                $search_query = $_POST['search_query'];
                if ($search_query) {
                    $query = "SELECT * FROM ngo WHERE confirm=1 AND name LIKE '%$search_query%' OR city LIKE '%$search_query%' ";
                } else {
                    $query = "SELECT * FROM ngo WHERE confirm=1";
                }
            } else {
                $query = "SELECT * FROM ngo WHERE confirm=1";
            }
            $result = mysqli_query($connection, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $image = base64_encode($row['photo']);
                    ?>
                    <div class="ngo-container">
                        <div class="ngo-image">
                            <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="">
                        </div>
                        <div>
                            <h1 style="color:var(--green); text-transform: uppercase;"><?php echo $row["name"]; ?></h1><br>
                            <label class="ngo-label">Description:</label>
                            <p class="ngo-detail"><?php echo $row["description"]; ?></p>
                            <a href="#" class="readmore">Read More</a><br>

                            <div class="ngo-detail-row">
                                <div>
                                    <label class="ngo-label">NO. OF Persons:</label>
                                    <p class="ngo-detail"><?php echo $row["persons"]; ?></p>
                                </div>
                                <div>
                                    <label class="ngo-label">Location:</label>
                                    <p class="ngo-detail"><?php echo $row["city"]; ?></p>
                                </div>
                                <div>
                                    <label class="ngo-label">Type OF Persons:</label>
                                    <p class="ngo-detail"><?php echo $row["category"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr><br>
                    <?php
                }
            }
            ?>
        </section>
    </main>
    <footer><?php include 'footer.php' ?></footer>
    <script>
        document.querySelectorAll('.readmore').forEach(function (readmoreLink) {
            readmoreLink.addEventListener('click', function (event) {
                event.preventDefault();
                var detailRow = this.parentElement.querySelector('.ngo-detail-row');
                if (detailRow.style.display === 'flex') {
                    detailRow.style.display = 'none';
                    this.textContent = 'Read More';
                } else {
                    detailRow.style.display = 'flex';
                    this.textContent = 'Read Less';
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target); // Stop observing once animated
            }
        });
    }, observerOptions);

    const containers = document.querySelectorAll('.ngo-container');
    containers.forEach(container => {
        observer.observe(container);
    });
});

    </script>
</body>

</html>
