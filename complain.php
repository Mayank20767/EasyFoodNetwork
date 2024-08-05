<?php
include 'connection.php';
session_start(); // Make sure to start the session

if (isset($_POST['complain'])) {
    // Retrieve form data
    $category = $_POST['category'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $orderID = $_POST['orderID'];
    $message = $_POST['complain'];

    // Sanitize user inputs to prevent SQL injection
    $category = mysqli_real_escape_string($connection, $category);
    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);
    $orderID = mysqli_real_escape_string($connection, $orderID);
    $message = mysqli_real_escape_string($connection, $message);

    // Construct the SQL query
    $query = "INSERT INTO complaince (name, category, email, order_id, message) VALUES ('$name', '$category', '$email', '$orderID', '$message')";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        $_SESSION['complain_success'] = "Complaint submitted successfully.";
        header('location:profile.php'); // Redirect to profile page
        exit(); // Ensure no further code execution
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "Data not stored";
}

// Close the database connection
mysqli_close($connection);
?>