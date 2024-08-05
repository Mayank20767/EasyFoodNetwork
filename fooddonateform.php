<?php
session_start();
if (empty($_SESSION['uname'])) {
    header("location: signin.php");
    exit();
}

$emailid = $_SESSION['uemail'];
$connection = mysqli_connect("localhost", "root", "", "demo");

if (isset($_POST['submit'])) {
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = mysqli_real_escape_string($connection, $_POST['image-choice']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $quantity_unit = mysqli_real_escape_string($connection, $_POST['quantity-unit']);
    $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $ngos = $_POST['ngos']; // Array of selected NGOs

    // Prepare the NGOs for insertion into the database
    $ngos_list = implode(',', array_map(function ($ngo) use ($connection) {
        return mysqli_real_escape_string($connection, $ngo);
    }, $ngos));

    $query = "INSERT INTO food_donations (email, food, type, category, phoneno, location, address, name, quantity, ngos) VALUES ('$emailid', '$foodname', '$meal', '$category', '$phoneno', '$district', '$address', '$name', '$quantity $quantity_unit', '$ngos_list')";

    $query_run = mysqli_query($connection, $query);
    if ($query_run) {
        echo '<script type="text/javascript">alert("Data saved")</script>';
        header("location: delivery.html");
        exit();
    } else {
        echo '<script type="text/javascript">alert("Data not saved")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donate</title>
    <link rel="stylesheet" href="fooddonateform.css">
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
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            /* Adjust based on navbar height */
        }

        .regformf {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
            max-width: 600px;
            width: 100%;
            margin: 20px auto;
            /* Center the form vertically */
        }

        .regformf form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
        }

        .food_donate_logo {
            font-size: 32px;
            color: var(--green);
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .radio {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .radio label {
            display: inline;
            margin-right: 10px;
        }

        .radio input[type="radio"]:checked {
            background-color: #007bff;
            /* Change this to desired color */
            border-color: #007bff;
        }

        .input,
        .radio,
        .dropdown {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--dark-green);
        }

        input[type="text"],
        input[type="number"],
        select,
        .dropdown-content {
            width: calc(100% - 10px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
            width: 100%;
            padding: 10px;
            border: 1px solid var(--dark-green);
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: var(--green);
            outline: none;
        }

        input[type="radio"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #ccc;
            outline: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .quantity {
            margin-right: 20px;
        }

        .image-radio-group {
            display: flex;
            justify-content: center;
        }


        .image-radio-group input[type="radio"] {
            display: none;
        }

        .image-radio-group label {
            cursor: pointer;
        }

        .image-radio-group input[type="radio"]:checked+label {
            border: 4px solid var(--green);
        }

        .image-radio-group label img {
            display: block;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .b {
            font-weight: bold;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .dropdown {
            position: relative;
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

        .btn {
            text-align: center;
            margin-top: 20px;
        }

        button[type="submit"] {
            background-color: var(--green);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: var(--light-green);
        }

        /* Navbar styling */
        .navbar {
            background-color: var(--navcolor);
            overflow: hidden;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        #donate {
            background-color: var(--light-green);
        }

        #quantity-unit {
            margin-left: 10px;
            padding: 10px;
            border: 1px solid var(--dark-green);
            border-radius: 4px;
            box-sizing: border-box;
            width: auto;
            display: inline-block;
            vertical-align: middle;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .image-radio-group {
                flex-direction: column;
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .image-radio-group label {
                margin-bottom: 10px;
            }

            .dropbtn {
                text-align: center;
            }

            .dropdown-content {
                min-width: 100%;
            }
        }

        #donate a {
            background-color: var(--light-green);
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="regformf">
            <form action="" method="post">
                <p class="food_donate_logo">Food <b style="color: #06C167;">Donate</b></p>
                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required />
                </div>
                <div class="radio">
                    <label for="meal">Meal type:</label>
                    <input type="radio" name="meal" id="veg" value="veg" required />
                    <label for="veg">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                    <label for="Non-veg">Non-veg</label>
                </div>
                <br>
                <div class="input">
                    <label for="food">Select the Category:</label>
                    <br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <img src="img/raw-food.png" style="width:150px; height:100px; border:2px solid black;"
                                alt="raw-food">
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <img src="img/cooked-food.png" style="width:150px; height:100px; border:2px solid black;"
                                alt="cooked-food">
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                            <img src="img/packed-food.png" style="width:150px; height:100px; border:2px solid black;"
                                alt="packed-food">
                        </label>
                    </div>
                </div>
                <br>
                <div class="input">
                    <label for="quantity" class='quantity'>Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required />
                    <select id="quantity-unit" name="quantity-unit" required>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="lbs">Pounds (lbs)</option>
                        <option value="L">Liters (L)</option>
                        <option value="gal">Gallons (gal)</option>
                        <option value="portions">Portions</option>
                        <option value="pieces">Pieces</option>
                    </select>
                </div>
                <b>
                    <p style="text-align: center;">Contact Details</p>
                </b>
                <br>
                <div class="input">
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name"
                            value="<?php echo htmlspecialchars($_SESSION['uname']); ?>" required />
                    </div>
                    <br>
                    <div>
                        <label for="phoneno">PhoneNo:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />
                    </div>
                </div>
                <div>
                    <label for="district" id="dislab">District:</label>
                    <select id="district" name="district" style="padding:10px; padding-left: 20px;" required>
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
                    </select>
                    <br><br>

                    <div>
                        <div class="input">
                            <div>
                                <label for="NGO">NGOs:</label>
                                <div class="dropdown">
                                    <button class="dropbtn" required>Select Options</button>
                                    <div class="dropdown-content" id="ngo-dropdown">
                                        <label class="dropdown-item"><input type="checkbox" id="select-all"> All</label>
                                        <?php
                                        // NGO Name SELECT
                                        $query = "SELECT * FROM ngo WHERE confirm=1";
                                        $result = mysqli_query($connection, $query);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                        <label class="dropdown-item ngo-item"
                                            data-city="<?php echo htmlspecialchars($row['city']); ?>">
                                            <input type="checkbox" name="ngos[]"
                                                value="<?php echo htmlspecialchars($row['name']); ?>">
                                            <?php echo htmlspecialchars($row['name']);?>(
                                            <?php echo htmlspecialchars($row['city']); ?>")
                                        </label>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div>
                                <label for="address" style="padding-left: 10px;">Address:</label>
                                <input type="text" id="address" name="address" required /><br>
                            </div>
                        </div>
                        <div class="btn">
                            <button type="submit" name="submit">Submit</button>
                        </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            var checkboxes = document.querySelectorAll('.ngo-item input[type="checkbox"]');
            var district = document.getElementById('district').value.toLowerCase();
            var checked = this.checked;

            // Check if there are NGOs available for the selected district
            var ngosAvailable = false;
            checkboxes.forEach(function (checkbox) {
                var item = checkbox.closest('.ngo-item');
                if (item.getAttribute('data-city').toLowerCase() === district) {
                    ngosAvailable = true;
                    checkbox.checked = checked;
                }
            });

            // If no NGOs available, show a pop-up message
            if (!ngosAvailable) {
                alert('No NGOs available for the selected district. Please choose a different location.');
                this.checked = false;
            }
        });

        document.getElementById('district').addEventListener('change', function () {
            var selectedDistrict = this.value.toLowerCase();
            var ngoItems = document.querySelectorAll('.ngo-item');
            ngoItems.forEach(function (item) {
                if (item.getAttribute('data-city').toLowerCase() === selectedDistrict) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });

            // Uncheck "All" checkbox when district changes
            document.getElementById('select-all').checked = false;
        });

        // Trigger change event on page load to filter NGOs based on the default selected district
        document.getElementById('district').dispatchEvent(new Event('change'));
    </script>
</body>

</html>