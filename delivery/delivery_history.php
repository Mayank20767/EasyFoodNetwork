<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "demo");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

$query = "SELECT * FROM food_donations WHERE delivery_by = " . intval($_SESSION['Did']);
if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND date BETWEEN '" . mysqli_real_escape_string($connection, $start_date) . "' AND '" . mysqli_real_escape_string($connection, $end_date) . "'";
}

$result = mysqli_query($connection, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donation_id = intval($_POST['donation_id']);

    if (isset($_POST['ngo_verify_otps']) || isset($_POST['donor_verify_otps'])) {
        $entered_ngo_otp = isset($_POST['ngo_otp']) ? mysqli_real_escape_string($connection, $_POST['ngo_otp']) : null;
        $entered_donor_otp = isset($_POST['donor_otp']) ? mysqli_real_escape_string($connection, $_POST['donor_otp']) : null;

        $otp_query = "SELECT ngo_otp, donor_otp FROM varification WHERE Fid = $donation_id";
        $otp_result = mysqli_query($connection, $otp_query);

        if ($otp_result && mysqli_num_rows($otp_result) > 0) {
            $otp_row = mysqli_fetch_assoc($otp_result);
            $ngo_otp_correct = $otp_row['ngo_otp'] === $entered_ngo_otp;
            $donor_otp_correct = $otp_row['donor_otp'] === $entered_donor_otp;

            if ($ngo_otp_correct) {
                header("Location: send_mail.php?action=ngo_verified&donation_id=$donation_id");
                echo "<p style='color: green;'>Valid NGO OTP entered for donation ID $donation_id.</p>";
                // mysqli_query($connection, $delete_query);
            } else if (isset($_POST['ngo_verify_otps'])) {
                echo "<p style='color: red;'>Invalid NGO OTP entered for donation ID $donation_id.</p>";
            }

            if ($donor_otp_correct) {
                header("Location: send_mail.php?action=donor_verified&donation_id=$donation_id");
                echo "<p style='color: green;'>Valid Donor OTP entered for donation ID $donation_id. Donation marked as completed.</p>";
            } else if (isset($_POST['donor_verify_otps'])) {
                echo "<p style='color: red;'>Invalid Donor OTP entered for donation ID $donation_id.</p>";
            }
        }
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .button-container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .button-container button a {
            color: white;
            text-decoration: none;
        }

        .button-container button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        h2 {
            margin: 20px 20px 10px 20px;
            color: #333;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 0 20px 20px 20px;
        }

        label {
            margin-right: 10px;
            color: #333;
        }

        input[type="date"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            padding: 8px 16px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: calc(100% - 40px);
            margin: 20px;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #f8f9fa;
            color: #333;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        .otp-input {
            width: 150px;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .verify-button {
            padding: 8px 16px;
            margin: 5px 0;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .verify-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div>
        <div class="button-container">
            <div class="logout-btn">
                <button onclick="logout()" style="background-color:red;">Logout</button>
            </div>
            <div class="history">
                <button><a href="delivery_history.php">Delivery History</a></button>
            </div>
            <div class="home">
                <button><a href="deliveryperson.php">Home</a></button>
            </div>
        </div>

        <h2>Delivery History</h2>
        <form method="post" action="">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">

            <button type="submit">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>NGO Name</th>
                    <th>NGO Address</th>
                    <th>NGO City</th>
                    <th>Donor Name</th>
                    <th>Food</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Phone No</th>
                    <th>Date/Time</th>
                    <th>Donor Address</th>
                    <th>Donor OTP</th>
                    <th>NGO OTP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Fetching the admin details
                        $assigned_to = intval($row['assigned_to']);
                        $admin_query = "SELECT * FROM ngo WHERE id = $assigned_to";
                        $admin_result = mysqli_query($connection, $admin_query);

                        if ($admin_result && mysqli_num_rows($admin_result) > 0) {
                            $admin_row = mysqli_fetch_assoc($admin_result);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($admin_row['name']); ?></td>
                                <td><?php echo htmlspecialchars($admin_row['address']); ?></td>
                                <td><?php echo htmlspecialchars($admin_row['city']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['food']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo htmlspecialchars($row['phoneno']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td>
                                    <?php
                                    $Fid = htmlspecialchars($row['Fid']);
                                    $otp_query = "SELECT * FROM varification WHERE Fid = $Fid";
                                    $otp_result = mysqli_query($connection, $otp_query);
                                    $otp_row = mysqli_fetch_assoc($otp_result);
                                    if (!empty($otp_row['donor_otp'])) { ?>
                                        <form method="post" action="">
                                            <input type="hidden" name="donation_id"
                                                value="<?php echo htmlspecialchars($row['Fid']); ?>">
                                            <input type="text" class="otp-input" name="donor_otp" placeholder="Donor OTP">
                                            <button type="submit" class="verify-button" name="donor_verify_otps">Verify</button>
                                        </form>
                                    <?php } else { ?>
                                        <button>Verified</button>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php
                                    $Fid = htmlspecialchars($row['Fid']);
                                    $otp_query = "SELECT * FROM varification WHERE Fid = $Fid";
                                    $otp_result = mysqli_query($connection, $otp_query);
                                    $otp_row = mysqli_fetch_assoc($otp_result);
                                    if (!empty($otp_row['ngo_otp'])) { ?>
                                        <form method="post" action="">
                                            <input type="hidden" name="donation_id"
                                                value="<?php echo htmlspecialchars($row['Fid']); ?>">
                                            <input type="text" class="otp-input" name="ngo_otp" placeholder="NGO OTP">
                                            <button type="submit" class="verify-button" name="ngo_verify_otps">Verify</button>
                                        </form>
                                    <?php } else { ?>
                                        <button>Verified</button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        } else {
                            echo "<tr><td colspan='13'>No NGO data found for donation ID " . htmlspecialchars($row['Fid']) . "</td></tr>";
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function logout() {
            window.location.href = "../logout2.php";
        }
    </script>
</body>

<?php if ($action != '') { ?>
    <h1 class="message"><?php echo $action ?></h1>
    <?php
}
$action = '';
?>

</html>

<?php
mysqli_close($connection);
?>