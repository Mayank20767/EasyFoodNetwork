<?php
session_start();
include ("../connection.php");
// Check if user is logged in
if (empty($_SESSION['ngo_name'])) {
    header("location:ngosignin.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ngo.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>NGO History</title>
    <style>
        section.dashboard {
            padding: 20px;
        }

        section.dashboard .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        section.dashboard .top .logo {
            font-size: 24px;
            font-weight: bold;
        }

        section.dashboard .activity .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        section.dashboard .activity .table-container .table-wrapper {
            overflow-x: auto;
        }

        section.dashboard .activity .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        section.dashboard .activity .table-container th,
        section.dashboard .activity .table-container td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            word-wrap: break-word;
            /* Ensures long text wraps within the cell */
        }

        section.dashboard .activity .table-container th {
            background-color: #4CAF50;
            color: white;
        }

        section.dashboard .activity .table-container tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        section.dashboard .activity .table-container tr:hover {
            background-color: #f1f1f1;
        }

        /* section.dashboard .activity {
            background-color: #06C167;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
        } */

        .table-container button {
            width: 100%;
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 6px;
        }

        section.dashboard .activity button:hover {
            background-color: #059e54;
        }

        /* Feedback and Complain Form Styles */
        #feedbackPopup,
        #complainPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 400px;
        }

        #feedbackPopup label,
        #complainPopup label {
            font-weight: bold;
        }

        #feedbackPopup input[type="text"],
        #feedbackPopup input[type="email"],
        #feedbackPopup select,
        #feedbackPopup textarea,
        #complainPopup input[type="text"],
        #complainPopup input[type="email"],
        #complainPopup select,
        #complainPopup textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #feedbackPopup textarea,
        #complainPopup textarea {
            resize: vertical;
        }

        #feedbackPopup input[type="submit"],
        #complainPopup input[type="submit"] {
            background-color: #06C167;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #feedbackPopup input[type="submit"]:hover,
        #complainPopup input[type="submit"]:hover {
            background-color: #059e54;
        }

        #closeButton,
        #closeComplainButton {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Darken background when feedback form is open */
        .feedbackBackground,
        .complainBackground {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        Responsive Styles
        @media (max-width: 768px) {
            nav .menu-items ul li {
                margin-right: 10px;
            }

            section.dashboard .top {
                flex-direction: column;
                align-items: flex-start;
            }

            section.dashboard .top .logo {
                font-size: 20px;
            }

            section.dashboard .activity .table-container table,
            section.dashboard .activity .table-container th,
            section.dashboard .activity .table-container td {
                display: block;
                width: 100%;
            }

            section.dashboard .activity .table-container th,
            section.dashboard .activity .table-container td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            section.dashboard .activity .table-container th::before,
            section.dashboard .activity .table-container td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: calc(50% - 20px);
                padding-right: 10px;
                text-align: left;
                font-weight: bold;
            }

            section.dashboard .activity .table-container th::before {
                display: none;
                /* Hide header label in th */
            }

            #feedbackPopup,
            #complainPopup {
                width: 90%;
                max-width: 90%;
            }
        }
    </style>
</head>

<body>
    <?php include 'ngo_nav.php'?>
    <section class="dashboard">

        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Your <b style="color: #06C167;">History</b></p>
            <p class="user"></p>
        </div>
        <br>
        <br>
        <br>
        <div class="activity">
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Donor Name</th>
                                <th>Food Name</th>
                                <th>Food Category</th>
                                <th>Donor Phone Number</th>
                                <th>Date/Time</th>
                                <th>Donor City</th>
                                <th>Donor Address</th>
                                <th>Food Quantity</th>
                                <th>Status</th>
                                <th>Raise Complain</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch the NGO's name from the session
                            $ngo_name = $_SESSION['ngo_name'];

                            // Fetch donation history for the logged-in NGO
                            $sql = "SELECT * FROM donation_history WHERE ngo_name = '$ngo_name'";
                            $result = mysqli_query($connection, $sql);
                            if (!$result) {
                                die("Error executing query: " . mysqli_error($connection));
                            }

                            // Display donation history in tabular form
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td data-label='Donor Name'>{$row['name']}</td>";
                                echo "<td data-label='Food Name'>{$row['food']}</td>";
                                echo "<td data-label='Food Category'>{$row['category']}</td>";
                                echo "<td data-label='Donor Phone Number'>{$row['phoneno']}</td>";
                                echo "<td data-label='Date/Time'>{$row['date']}</td>";
                                echo "<td data-label='Donor City'>{$row['city']}</td>";
                                echo "<td data-label='Donor Address'>{$row['address']}</td>";
                                echo "<td data-label='Food Quantity'>{$row['quantity']}</td>";
                                echo "<td data-label='Status'>{$row['status']}</td>";
                                echo "<td data-label='Raise Complain'> <button onclick=\"openComplainForm(" . $row['Fid'] . ")\">Raise Complain</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div id="feedbackPopup">
        <span id="closeButton">&times;</span>
        <form id="feedbackForm" action="../feedback.php" method="post">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['ngo_name']); ?>"
                readonly><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['ngo_email']); ?>"
                readonly><br><br>

            <label for="orderID">orderID:</label>
            <input type="text" id="orderID" name="orderID" value="" readonly><br><br>

            <label for="rating"> Service Rating:</label>
            <select id="rating" name="rating" required>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select><br><br>

            <label for="comments">Comments:</label><br>
            <textarea id="comments" name="comments" rows="4" cols="50"></textarea><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>

    <div id="complainPopup">
        <span id="closeComplainButton">&times;</span>
        <form id="complainForm" action="../complain.php" method="post">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="service">Service Issue</option>
                <option value="delivery">Delivery Issue</option>
            </select><br><br>

            <label for="name">Name:</label>
            <input type="text" id="complainName" name="name" value="<?php echo htmlspecialchars($_SESSION['ngo_name']); ?>"
                readonly><br><br>

            <label for="email">Email:</label>
            <input type="email" id="complainEmail" name="email"
                value="<?php echo htmlspecialchars($_SESSION['ngo_email']); ?>" readonly><br><br>

            <label for="orderID">Order ID:</label>
            <input type="text" id="complainOrderID" name="orderID" value="" readonly><br><br>

            <label for="complain">Message:</label><br>
            <textarea id="complain" name="complain" rows="4" cols="50" required></textarea><br><br>

            <input type="submit" name="complain" value="Submit">
        </form>
    </div>

    <!-- Your JavaScript files or scripts here -->
    <script src="ngo.js"></script>

    <script>
        window.onload = function () {
            var urlParams = new URLSearchParams(window.location.search);
            var showFeedback = urlParams.get('showFeedback');
            var orderID = urlParams.get('orderID');
            var feedbackPopup = document.getElementById('feedbackPopup');
            var closeButton = document.getElementById('closeButton');
            var orderIDInput = document.getElementById('orderID');

            if (showFeedback === 'true') {
                feedbackPopup.style.display = 'block';
                orderIDInput.value = orderID;
            }

            closeButton.onclick = function () {
                feedbackPopup.style.display = 'none';
            }
        };

        function openComplainForm(fid) {
            var complainPopup = document.getElementById('complainPopup');
            var closeComplainButton = document.getElementById('closeComplainButton');
            var complainOrderIDInput = document.getElementById('complainOrderID');

            complainPopup.style.display = 'block';
            complainOrderIDInput.value = fid;

            closeComplainButton.onclick = function () {
                complainPopup.style.display = 'none';
            }
        }
    </script>
</body>

</html>