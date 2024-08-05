<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $orderID = $conn->real_escape_string($_POST['orderID']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $comments = $conn->real_escape_string($_POST['comments']);

    $query = "SELECT * FROM feedback WHERE order_id='$orderID' AND email='$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        $row = mysqli_fetch_assoc($result);
        if ($row > 0) {
            echo "Thanks Your Feedback is already Submitted";
        } else {
            $sql = "INSERT INTO feedback (name, email, order_id, rating, comment) VALUES ('$name', '$email', '$orderID', '$rating', '$comments')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['feedback_success'] = "Complaint submitted successfully.";
                header('location:profile.php');
                exit(); 
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>
