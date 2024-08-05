<?php
session_start(); // Start session to access session variables

include '../connection.php';

// Check if NGO is logged in
if (!isset($_SESSION['ngo_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve NGO details from session
$ngo_id = $_SESSION['ngo_id'];

// Prepare the statement to prevent SQL injection
$query = $connection->prepare("SELECT * FROM ngo WHERE id = ?");
$query->bind_param("i", $ngo_id);
$query->execute();
$result = $query->get_result();

if (!$result) {
    die("Database query failed: " . $connection->error); // Handle query error
}
$ngo_info = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="ngo.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>NGO Dashboard Panel</title>
    <style>
        .confirmation-message,
        .rejection-message {
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

        .confirmation-message p,
        .rejection-message p {
            margin-bottom: 20px;
        }

        .confirmation-message button,
        .rejection-message button {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php include 'ngo_nav.php'; ?>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <p class="logo">Easy <b style="color: #06C167; ">Food</b> Network</p>
            <p class="user"></p>
        </div>
        <br><br><br>
        <div class="activity">
            <div class="profile">
                <div class="profilebox">
                    <div class="profileupdate">
                        <?php
                        $image = base64_encode($ngo_info['photo']);
                        ?>
                        <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="">
                    </div>
                    <p class="headingline" style="text-align: center; font-size: 30px;">
                        <?php echo htmlspecialchars($ngo_info['name']); ?>
                    </p>
                    <div class="info" style="padding-left: 10px;">
                        <p>Email: <?php echo htmlspecialchars($ngo_info['email']); ?></p>
                        <?php
                        if (isset($_GET['status']) && $_GET['status'] === 'success') {
                            echo '<p>Data successfully updated!</p>';
                        }
                        ?>
                        <p>Phone: <?php echo htmlspecialchars($ngo_info['phone']); ?></p>
                        <p>City: <?php echo htmlspecialchars($ngo_info['city']); ?></p>
                        <?php if (is_null($ngo_info['confirm']) || $ngo_info['confirm'] == 0) { ?>
                            <a href="moredetails.php">Add More Details</a>
                        <?php } else { ?>
                            <a href="moredetails.php">Update Details</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <br><br>
            <h1 style="color: var(--text-color);">Recent Orders</h1>
            <?php
            $sql = $connection->prepare("SELECT * FROM food_donations WHERE (assigned_to = '' OR assigned_to IS NULL) AND FIND_IN_SET(?, ngos)");
            $sql->bind_param("s", $ngo_info['name']);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows > 0) {
                echo "<div class=\"table-container\">";
                echo "<div class=\"table-wrapper\">";
                echo "<table class=\"table\">";
                echo "<thead><tr>
                            <th>Donor Name</th>
                            <th>Food Name</th>
                            <th>Food Category</th>
                            <th>Donor Phone No</th>
                            <th>Date/Time</th>
                            <th>Donor City</th>
                            <th>Donor Address</th>
                            <th>Food Quantity</th>
                            <th>Action</th>
                        </tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td data-label=\"name\">" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td data-label=\"food\">" . htmlspecialchars($row['food']) . "</td>";
                    echo "<td data-label=\"category\">" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td data-label=\"phoneno\">" . htmlspecialchars($row['phoneno']) . "</td>";
                    echo "<td data-label=\"date\">" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td data-label=\"city\">" . htmlspecialchars($row['location']) . "</td>";
                    echo "<td data-label=\"address\">" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td data-label=\"quantity\">" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td data-label=\"action\"><button onclick=\"showConfirmation(" . htmlspecialchars($row['Fid']) . ")\">Accept</button></td>";
                    echo "<td data-label=\"action\"><button onclick=\"Rejection(" . htmlspecialchars($row['Fid']) . ")\">Reject</button></td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div>";
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>
    </section>
    <section>
        <div class="confirmation-message" id="confirmationMessage">
            <p>Are You Sure You Want to Assign a Delivery Boy?</p>
            <!-- <input type="checkbox" id="set" name="ngo_set_delivery_boy" onclick="toggleInputFields()">
            <label for="set">Yes</label> -->
            <form id="confirmationForm" action="accept_with_delivery.php" method="post">
                <input type="hidden" name="fid" id="fid">
                <div>
                    <input type="checkbox" id="set" name="set" onchange="toggleInputFields()">
                    <label for="set">Set Delivery Person</label>
                </div>
                <div id="inputFields" style="display: none;">
                    <?php
                    $select_query = "SELECT * FROM delivery_persons";
                    $select_result = mysqli_query($connection, $select_query);
                    if ($select_result) {
                        echo '<label for="dname">Name:</label>';
                        echo '<select id="dname" name="dname">';
                        echo '<option value="">Select Delivery Person</option>';
                        while ($row = mysqli_fetch_assoc($select_result)) {
                            if (strpos($row['choose_ngo'], $_SESSION['ngo_id']) !== false) {
                                echo "<option value='" . htmlspecialchars($row['Did']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                            }
                        }
                        echo '</select>';
                    } else {
                        echo 'Error fetching delivery persons';
                    }
                    ?>
                </div>
                <button type="button" name="confirm" onclick="confirmOrder()">Confirm</button>
                <button type="button" onclick="cancelOrder()">Cancel</button>
            </form>

        </div>

        <div class="rejection-message" id="rejectionMessage">
            <p>Are You Sure You Want to Reject This Order?</p>
            <button onclick="NO()">NO</button>
            <button onclick="Yes()">Yes</button>
        </div>
    </section>
    <script>
        let currentFid = null;

        function showConfirmation(fid) {
            currentFid = fid;
            var confirmationMessage = document.getElementById("confirmationMessage");
            confirmationMessage.style.display = "block";
            document.getElementById("fid").value = fid;
        }

        function toggleInputFields() {
            var isChecked = document.getElementById('set').checked;
            var inputFields = document.getElementById('inputFields');
            inputFields.style.display = isChecked ? 'block' : 'none';
        }

        function confirmOrder() {
            var isChecked = document.getElementById('set').checked;
            if (isChecked) {
                var name = document.getElementById('dname').value;
                if (name === "") {
                    alert('Please select a delivery person');
                    return;
                }
            }
            document.getElementById('confirmationForm').submit();
        }

        function cancelOrder() {
            var confirmationMessage = document.getElementById("confirmationMessage");
            confirmationMessage.style.display = "none";
        }


        function Rejection(fid) {
            currentFid = fid;
            var rejectionMessage = document.getElementById("rejectionMessage");
            rejectionMessage.style.display = "block";
        }

        function NO() {
            var rejectionMessage = document.getElementById("rejectionMessage");
            rejectionMessage.style.display = "none";
        }

        function Yes() {
            var rejectionMessage = document.getElementById("rejectionMessage");
            rejectionMessage.style.display = "none";
            rejectUpdateFoodDonationTable(currentFid);
        }

        function rejectUpdateFoodDonationTable(fid) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "rejection.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    if (xhr.responseText.includes("reject successfully")) {
                        location.reload();
                    }
                }
            };
            var data = "fid=" + encodeURIComponent(fid);
            xhr.send(data);
        }
    </script>

    <script src="ngo.js"></script>
</body>

</html>

<?php
// Close database connection here
mysqli_close($connection);
?>