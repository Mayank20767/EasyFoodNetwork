<?php
session_start();
ob_start();
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');
if (empty($_SESSION['aemail'])) {
    header("location:signin.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    /* Resetting default margin and padding */
    body,
    html {
        margin: 0;
        padding: 0;
    }

    /* Centering the form */
    form {
        margin: 50px auto;
        width: 80%;
        max-width: 600px;
    }

    /* Styling form label */
    label {
        display: block;
        margin-bottom: 5px;
    }

    /* Styling select dropdown */
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    /* Styling submit button */
    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Styling table */
    table {
        width: 90%;
        border-collapse: collapse;
        margin: 20px auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        /* Ensures rounded corners are visible */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Adding shadow effect */
        background: linear-gradient(to bottom, #ffffff, #f2f2f2);
        /* Gradient background */

    }

    /* Styling table header */
    th {
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    /* Styling table data cells */
    td {
        border: 1px solid #ddd;
        padding: 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Alternating row colors */
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Hover effect on rows */
    tr:hover {
        background-color: #f0f0f0;
    }

    @media screen and (max-width: 768px) {
        .table thead {
            display: none;
        }

        .table,
        .table tbody,
        .table tr,
        .table td {
            display: block;
            width: 100%;
            white-space: normal;
            /* Allow line breaks */
        }

        .table tr {
            margin-bottom: 15px;
        }

        .table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

        .table td:before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: calc(50% - 30px);
            padding-right: 10px;
            white-space: nowrap;
            text-align: left;
            font-weight: bold;
        }
    }
</style>

<body>
    <nav>
        <div class="logo-name">
            <span class="logo_name">Admin</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php"><i class="uil uil-estate"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="participant.php"><i class="uil uil-heart"></i><span
                            class="link-name">Participant</span></a></li>
                <li><a href="view_feedback.php"><i class="uil uil-comments"></i><span
                            class="link-name">Feedbacks</span></a></li>
                <li><a href="view_complaince.php"><i class="uil uil-user"></i><span
                            class="link-name">Complaince</span></a></li>
            </ul>
            <ul class="logout-mode">
                <li><a href="../logout2.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a>
                </li>
                <li class="mode">
                    <a href="#"><i class="uil uil-moon"></i><span class="link-name">Dark Mode</span></a>
                    <div class="mode-toggle"><span class="switch"></span></div>
                </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Food <b style="color: #06C167;">Donate</b></p>
        </div>
        <form action="" method="post">
            <label for="filter">Filter:</label>
            <select name="filter" id="filter">
                <option value="donor">Donor</option>
                <option value="ngo">NGOs</option>
                <option value="dilvery">Delivery</option>
            </select>
            <input type="submit" name="submit">
        </form>
        <?php
        if (isset($_POST['submit'])) {

            if ($_POST['filter'] == 'dilvery') {
                echo "<table>";
                echo "<tr>";
                echo "<th>S.no</th>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>City</th>";
                echo "</tr>";

                $query = "SELECT * FROM delivery_persons";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    $serialNumber = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td data-label='S.no'>" . $serialNumber . "</td>";
                        echo "<td data-label='Name'>" . $row['name'] . "</td>";
                        echo "<td data-label='Email'>" . $row['email'] . "</td>";
                        echo "<td data-label='City'>" . $row['city'] . "</td>";
                        echo "</tr>";
                        $serialNumber++;
                    }
                }
                echo "</table>";
            } elseif ($_POST['filter'] == 'ngo') {
                echo "<table>";
                echo "<tr>";
                echo "<th>S.no</th>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>City</th>";
                echo "</tr>";

                $query = "SELECT * FROM ngo";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    $serialNumber = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td data-label='S.no'>" . $serialNumber . "</td>";
                        echo "<td data-label='Name'>" . $row['name'] . "</td>";
                        echo "<td data-label='Email'>" . $row['email'] . "</td>";
                        echo "<td data-label='City'>" . $row['city'] . "</td>";
                        echo "</tr>";
                        $serialNumber++;
                    }
                }
                echo "</table>";
            } elseif ($_POST['filter'] == 'donor') {
                echo "<table>";
                echo "<tr>";
                echo "<th>S.no</th>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Gender</th>";
                echo "<th>Successful Donations</th>";
                echo "</tr>";

                $query = "SELECT * FROM login";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    $serialNumber = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $phoneno = $row['phone'];
                        $donationQuery = "SELECT COUNT(*) AS total FROM donation_history WHERE phoneno = '$phoneno' AND status = 'successful'";
                        $donationResult = mysqli_query($connection, $donationQuery);
                        $donationCount = 0;
                        if ($donationResult) {
                            $donationRow = mysqli_fetch_assoc($donationResult);
                            $donationCount = $donationRow['total'];
                        }

                        echo "<tr>";
                        echo "<td data-label='S.no'>" . $serialNumber . "</td>";
                        echo "<td data-label='Name'>" . $row['name'] . "</td>";
                        echo "<td data-label='Email'>" . $row['email'] . "</td>";
                        echo "<td data-label='Gender'>" . $row['gender'] . "</td>";
                        echo "<td data-label='Successful Donations'>" . $donationCount . "</td>";
                        echo "</tr>";
                        $serialNumber++;
                    }
                }
                echo "</table>";
            }
            mysqli_close($connection);
        }
        ?>

    </section>
    <script src="admin.js"></script>
</body>

</html>