<?php
include "connection.php";

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// // Check if file is uploaded and is of allowed type
// if ($_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
//     $file_type = $_FILES['user_image']['type'];
//     if ($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/png') {
//         $file_content = addslashes(file_get_contents($_FILES['user_image']['tmp_name']));
//     } else {
//         // File type not allowed
//         echo "Only JPG, JPEG, and PNG files are allowed.";
//         exit; // Stop execution if file type is not allowed
//     }
// } else {
//     // Use default image
//     $default_image_path = 'default.png';
//     $file_content = addslashes(file_get_contents($default_image_path));
// }


// Insert data into database
$query = "INSERT INTO complaince (name, order_id, email, message) VALUES ('$name', '0', '$email', '$message')";

$result = mysqli_query($connection, $query);

if ($result) {
    // Data inserted successfully
    header("location:contact.php");
    echo "Feedback submitted successfully.";
} else {
    // Error inserting data into database
    echo "Error: " . mysqli_error($connection);
}
?>

