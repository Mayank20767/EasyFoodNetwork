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

if (isset($_POST['submit'])) {
    // Retrieve form data
    $num_of_people = mysqli_real_escape_string($connection, $_POST['num_of_people']);
    $category = implode(',', array_map(function($item) use ($connection) {
        return mysqli_real_escape_string($connection, $item);
    }, $_POST['category']));
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $confirm = isset($_POST['confirm']) ? 1 : 0;

    // Update NGO details in the database using a prepared statement
    $update_query = "UPDATE ngo SET persons = ?, category = ?, description = ?, confirm = ? WHERE id = ?";
    $stmt = mysqli_prepare($connection, $update_query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isssi", $num_of_people, $category, $description, $confirm, $ngo_id);
        $update_result = mysqli_stmt_execute($stmt);
        if (!$update_result) {
            die("Database query failed: " . mysqli_stmt_error($stmt)); // Handle query error
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Database query failed: " . mysqli_error($connection)); // Handle prepare error
    }

    header("Location: ngo.php?status=success");
    exit();
}


mysqli_close($connection); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGO More Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 15px;
            display: block;
        }

        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: grey;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .checkbox-container {
            display: flex;
            flex-wrap: wrap;
        }

        .checkbox-container label {
            margin-right: 10px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        textarea {
            resize: vertical;
        }
    </style>
</head>

<body>
    <h2>NGO More Details</h2>
    <form id="ngoForm" action="" method="post">
        <label for="num_of_people">Number of Persons Helped:</label>
        <input type="number" id="num_of_people" name="num_of_people" required>

        <label>Category of Persons Helped:</label>
        <div class="checkbox-container">
            <input type="checkbox" id="child" name="category[]" value="Child">
            <label for="child">Child</label>
            <input type="checkbox" id="adult" name="category[]" value="Adult">
            <label for="adult">Adult</label>
            <input type="checkbox" id="old" name="category[]" value="Old Citizen">
            <label for="old">Old Citizen</label>
        </div>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <div class="checkbox-container">
            <input type="checkbox" id="confirm" name="confirm">
            <label for="confirm">Confirm</label>
        </div>

        <input type="submit" id="submit" name="submit" value="Submit" disabled>
    </form>

    <script>
        document.getElementById('ngoForm').addEventListener('input', function () {
            var submitButton = document.getElementById('submit');
            var numOfPeople = document.getElementById('num_of_people').value;
            var description = document.getElementById('description').value;
            var confirmChecked = document.getElementById('confirm').checked;

            // Check if any category checkbox is checked
            var categoryChecked = Array.from(document.querySelectorAll('input[name="category[]"]')).some(checkbox => checkbox.checked);

            if (numOfPeople && description && confirmChecked && categoryChecked) {
                submitButton.disabled = false;
                submitButton.style.backgroundColor = '#4CAF50'; // Active color
            } else {
                submitButton.disabled = true;
                submitButton.style.backgroundColor = 'grey'; // Inactive color
            }
        });
    </script>
</body>

</html>