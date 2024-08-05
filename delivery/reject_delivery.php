<?php
session_start();

// Connect to your database
include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the fid parameter is set
    if (isset($_POST["fid"])) {
        $fid = $_POST["fid"];

        // Update the delivery_by column to null for the given fid
        $update_query = "UPDATE food_donations SET delivery_by = NULL WHERE Fid = ?";
        
        $stmt = mysqli_prepare($connection, $update_query);
        mysqli_stmt_bind_param($stmt, "i", $fid);
        
        if(mysqli_stmt_execute($stmt)) {
            // Delivery rejected successfully
            echo "Delivery rejected successfully";
        } else {
            // Error occurred while rejecting delivery
            echo "Error: " . mysqli_error($connection);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Fid parameter is not set
        echo "Error: Fid parameter is not set";
    }
} else {
    // Invalid request method
    echo "Error: Invalid request method";
}

// Close database connection
mysqli_close($connection);
?>
