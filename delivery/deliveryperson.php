<?php
session_start();

// Connect to your database
include "../connection.php";

// Fetch data for the table
$deliveries = "0"; // Default to a condition that is always false

if (isset($_SESSION['Did'])) {
    $did = $_SESSION['Did'];
    $deliveries = "delivery_boy LIKE ?";
}

$query = "SELECT * FROM food_donations WHERE ($deliveries) OR delivery_boy='0'";
$stmt = mysqli_prepare($connection, $query);

if (isset($_SESSION['Did'])) {
    $did_param = "%" . $_SESSION['Did'] . "%";
    mysqli_stmt_bind_param($stmt, "s", $did_param);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

$current_time = new DateTime();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['phone'])) {
    $_SESSION['dphone'] = $_POST['phone'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2,
        h4 {
            text-align: center;
            color: #333;
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

        .logout-btn button {
            background-color: #f44336;
        }

        .logout-btn button:hover {
            background-color: #d32f2f;
        }

        .itm {
            text-align: center;
        }

        .table-container {
            overflow-x: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        @media screen and (max-width: 600px) {
            table {
                font-size: 14px;
            }

            button {
                font-size: 14px;
            }
        }

        .confirmation-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            z-index: 9999;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .confirmation-message p {
            margin-bottom: 20px;
        }

        .confirmation-message button {
            margin-right: 10px;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }

        #confirmbutton {
            background-color: #28a745;
            color: white;
            border: none;
        }

        #confirmbutton:hover {
            background-color: #218838;
        }

        #rejectButton {
            background-color: #ff9800;
            color: white;
            border: none;
        }

        #rejectButton:hover {
            background-color: #e68900;
        }

        #cancelButton {
            background-color: #f44336;
            color: white;
            border: none;
        }

        #cancelButton:hover {
            background-color: #d32f2f;
        }

        #phone {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 10px;
        }

        .But {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="button-container">
        <div class="logout-btn">
            <button onclick="logout()">Logout</button>
        </div>
        <div class="history">
            <button><a href="delivery_history.php">Delivery History</a></button>
        </div>
        <div class="home">
            <button><a href="deliveryperson.php">Home</a></button>
        </div>
    </div>

    <h2>Welcome <?php echo htmlspecialchars($_SESSION['dname']); ?></h2>
    <h4>Your City: <?php echo htmlspecialchars($_SESSION['dcity']); ?></h4>
    <div class="itm">
        <img src="../img/delivery.gif" alt="Delivery Image" width="400" height="400">
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NGO Name</th>
                    <th>NGO Address</th>
                    <th>NGO Phone</th>
                    <th>Donor Name</th>
                    <th>Food</th>
                    <th>Category</th>
                    <th>Donor Phone</th>
                    <th>Date/Time</th>
                    <th>Donor Address</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $assigned_time = new DateTime($row['assignment_timestamp']);
                    $interval = $current_time->diff($assigned_time);
                    $minutes_passed = $interval->i;

                    if ($_SESSION['dcity'] == $row['location'] && !empty($row['assigned_to']) && empty($row['delivery_by'])) {
                        $fid = $row['Fid'];
                        $assigned_to = $row['assigned_to'];
                        $donor_name = htmlspecialchars($row['name']);
                        $food = htmlspecialchars($row['food']);
                        $category = htmlspecialchars($row['category']);
                        $phoneno = htmlspecialchars($row['phoneno']);
                        $date = htmlspecialchars($row['date']);
                        $address = htmlspecialchars($row['address']);
                        $quantity = htmlspecialchars($row['quantity']);

                        $query = "SELECT * FROM ngo WHERE id = ?";
                        $stmt = mysqli_prepare($connection, $query);
                        mysqli_stmt_bind_param($stmt, "i", $assigned_to);
                        mysqli_stmt_execute($stmt);
                        $result_ngo = mysqli_stmt_get_result($stmt);
                        $ngo_row = mysqli_fetch_assoc($result_ngo);
                        $NGO_name = htmlspecialchars($ngo_row['name']);
                        $NGO_address = htmlspecialchars($ngo_row['address']);
                        $NGO_phone = htmlspecialchars($ngo_row['phone']);

                        $delivery_boy = htmlspecialchars($row['delivery_boy']);

                        echo "<tr>";
                        echo "<td data-label=\"NGO Name\">" . $NGO_name . "</td>";
                        echo "<td data-label=\"NGO Address\">" . $NGO_address . "</td>";
                        echo "<td data-label=\"NGO Phone\">" . $NGO_phone . "</td>";
                        echo "<td data-label=\"Donor Name\">" . $donor_name . "</td>";
                        echo "<td data-label=\"Food\">" . $food . "</td>";
                        echo "<td data-label=\"Category\">" . $category . "</td>";
                        echo "<td data-label=\"Donor Phone\">" . $phoneno . "</td>";
                        echo "<td data-label=\"Date/Time\">" . $date . "</td>";
                        echo "<td data-label=\"Donor Address\">" . $address . "</td>";
                        echo "<td data-label=\"Quantity\">" . $quantity . "</td>";
                        echo "<td data-label=\"Action\"><button onclick=\"showConfirmation(" . $fid . ", '" . $delivery_boy . "')\">Take Order</button></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="confirmation-message" id="confirmationMessage">
        <form action="" method="post">
            <p>Enter your phone number</p>
            <input type="tel" name="phone" id="phone" required>
            <p>Are You Sure You Want to Take This Order?</p>
            <div class="But">
                <button type="button" id="confirmbutton" onclick="confirmOrder()">Confirm</button><br><br>
                <button type="button" id="rejectButton" onclick="fixcancelOrder()" style="display:none;">Reject</button><br>
                <button type="button" id="cancelButton" onclick="cancelOrder()">Cancel</button><br><br>
            </div>
        </form>
    </div>

    <script>
        let currentFid = null;

        function showConfirmation(fid, deliveryBoy) {
            currentFid = fid;
            var confirmationMessage = document.getElementById("confirmationMessage");
            var rejectButton = document.getElementById("rejectButton");

            // Show or hide the reject button based on the deliveryBoy value
            if (deliveryBoy !== '0' && deliveryBoy !== '' && deliveryBoy.includes("<?php echo $_SESSION['Did']; ?>")) {
                rejectButton.style.display = "block";
            } else {
                rejectButton.style.display = "none";
            }

            confirmationMessage.style.display = "block";
        }

        function confirmOrder() {
            var confirmationMessage = document.getElementById("confirmationMessage");
            var phoneNumberInput = document.getElementById("phone");

            if (phoneNumberInput.value.trim() === "") {
                alert("Please enter your phone number.");
                return;
            }
            var phone = phoneNumberInput.value.trim();
            confirmationMessage.style.display = "none";
            updateFoodDonationTable(currentFid, phone);
        }

        function cancelOrder() {
            var confirmationMessage = document.getElementById("confirmationMessage");
            confirmationMessage.style.display = "none";
        }

        function fixcancelOrder() {
            var confirmationMessage = document.getElementById("confirmationMessage");
            confirmationMessage.style.display = "none";
            removeFoodDonationTable(currentFid);
        }

        function removeFoodDonationTable(fid) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cancel_special_delivery.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    if (xhr.responseText.includes("successfully")) {
                        location.reload();
                    }
                }
            };
            var data = "fid=" + encodeURIComponent(fid);
            xhr.send(data);
        }

        function updateFoodDonationTable(fid, phone) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_delivery.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    if (xhr.responseText.includes("successfully")) {
                        location.reload();
                    }
                }
            };
            var data = "fid=" + encodeURIComponent(fid) + "&phone=" + encodeURIComponent(phone);
            xhr.send(data);
        }

        function logout() {
            window.location.href = "../logout2.php";
        }
    </script>

    <?php mysqli_close($connection); ?>
</body>

</html>
