<?php
include 'session_check.php';
include 'connection.php';

if (empty($_SESSION['uname'])) {
    header("Location: signup.php");
    exit();
}

$email = $_SESSION['uemail'];
$sql = "SELECT * FROM login WHERE email=?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (isset($_SESSION['complain_success'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['complain_success']) . "');</script>";
    unset($_SESSION['complain_success']);
}

if (isset($_SESSION['feedback_success'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['feedback_success']) . "');</script>";
    unset($_SESSION['feedback_success']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>User Profile</title>
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Section -->
    <div class="profile">
        <div class="profilebox">
            <div class="profileupdate">
                <?php
                $image = base64_encode($row['profile_image']);
                ?>
                <img src="data:image/jpeg;base64,<?php echo $image; ?>" alt="Profile Image"
                    style="width: 50px; height: 50px; position: relative; left:20px">
                <p class="headingline" style="text-align: left; font-size: 30px;">Profile </p>
            </div>
            <div class="info" style="padding-left: 10px;">
                <p>Name: <?php echo htmlspecialchars($_SESSION['uname']); ?></p><br>
                <p>Email: <?php echo htmlspecialchars($_SESSION['uemail']); ?></p><br>
                <p>Gender: <?php echo htmlspecialchars($_SESSION['ugender']); ?></p><br>
                <a href="profile_update.php"
                    style="float: left; margin-top: 6px; border-radius: 5px; color: white; padding: 5px 10px;">Edit</a>
            </div>
            <br><br>
            <hr><br>
            <p class="heading">Your donations</p>
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Date/Time</th>
                                <th>Assigned Ngo</th>
                                <th>Status</th>
                                <th>Raise Complain</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM food_donations WHERE email=?";
                            $stmt = $connection->prepare($query);
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $ngo_info = null;
                                if (!empty($row['assigned_to'])) {
                                    $ngo_id = htmlspecialchars($row['assigned_to']);
                                    $sql_2 = "SELECT * FROM ngo WHERE id=?";
                                    $stmt_2 = $connection->prepare($sql_2);
                                    $stmt_2->bind_param("i", $ngo_id);
                                    $stmt_2->execute();
                                    $result_2 = $stmt_2->get_result();
                                    $ngo_info = $result_2->fetch_assoc();
                                }
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['food']) . "</td>
                                        <td>" . htmlspecialchars($row['type']) . "</td>
                                        <td>" . htmlspecialchars($row['category']) . "</td>
                                        <td>" . htmlspecialchars($row['date']) . "</td>";

                                if (!empty($ngo_info['name'])) {
                                    echo "<td style='color:green;font-weight:bold;text-transform:capitalize'>" . htmlspecialchars($ngo_info['name']) . "</td>";
                                } else if(empty($ngo_info['name'])) {
                                    echo "<td style='font-weight:bold;'>Not Assigned</td>";
                                }
                                else{
                                    echo "<td style='color:red;font-weight:bold;text-transform:capitalize'>All ARE REJECTED</td>";
                                }
                                if ($row['is_confirmed'] == 1) {
                                    echo "<td>Complete</td>";
                                } else {
                                    echo "<td>Not Complete</td>";
                                }

                                echo "<td><button onclick=\"openComplainForm(" . htmlspecialchars($row['Fid']) . ")\">Raise Complain</button></td>
                                    </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="feedbackPopup">
        <span id="closeButton">&times;</span>
        <form id="feedbackForm" action="feedback.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['uname']); ?>"
                readonly><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['uemail']); ?>"
                readonly><br><br>

            <label for="orderID">Order ID:</label>
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
            <textarea id="comments" name="comments" rows="4" cols="50" required></textarea><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>

    <div id="complainPopup">
        <span id="closeComplainButton">&times;</span>
        <form id="complainForm" action="complain.php" method="post">
            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="service">Service Issue</option>
                <option value="delivery">Delivery Issue</option>
            </select><br><br>

            <label for="name">Name:</label>
            <input type="text" id="complainName" name="name" value="<?php echo htmlspecialchars($_SESSION['uname']); ?>"
                readonly><br><br>

            <label for="email">Email:</label>
            <input type="email" id="complainEmail" name="email"
                value="<?php echo htmlspecialchars($_SESSION['uemail']); ?>" readonly><br><br>

            <label for="orderID">Order ID:</label>
            <input type="text" id="complainOrderID" name="orderID" value="" readonly><br><br>

            <label for="complain">Message:</label><br>
            <textarea id="complain" name="complain" rows="4" cols="50" required></textarea><br><br>

            <input type="submit" name="complain" value="Submit">
        </form>
    </div>

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