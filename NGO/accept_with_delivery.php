<?php
session_start();
include '../connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $status = 'pending';

    // Get the food ID from the form
    $food_id = isset($_POST['fid']) ? intval($_POST['fid']) : 0;
    $delivery_id = isset($_POST['dname']) ? intval($_POST['dname']) : 0;

    // Prepare the statement to select the donation record
    $select_query = $connection->prepare("SELECT * FROM food_donations WHERE Fid = ?");
    $select_query->bind_param("i", $food_id);
    $select_query->execute();
    $select_result = $select_query->get_result();

    if ($select_result->num_rows > 0) {
        // Fetch the donation record
        $donation_data = $select_result->fetch_assoc();

        // Extract data for insertion into donation_history table
        $ngoname = htmlspecialchars($_SESSION['ngo_name']);
        $Fid = $donation_data['Fid'];
        $name = htmlspecialchars($donation_data['name']);
        $food = htmlspecialchars($donation_data['food']);
        $category = htmlspecialchars($donation_data['category']);
        $phoneno = htmlspecialchars($donation_data['phoneno']);
        $datetime = htmlspecialchars($donation_data['date']);
        $city = htmlspecialchars($donation_data['location']);
        $address = htmlspecialchars($donation_data['address']);
        $quantity = htmlspecialchars($donation_data['quantity']);
        $status = 'pending';

        // Prepare the statement to insert data into donation_history table
        $insert_query = $connection->prepare("INSERT INTO donation_history (Fid, ngo_name, name, food, category, phoneno, date, city, address, quantity, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_query->bind_param("isssssssssi", $Fid, $ngoname, $name, $food, $category, $phoneno, $datetime, $city, $address, $quantity, $status);
        $insert_result = $insert_query->execute();

        if ($insert_result) {
            // Prepare the statement to update the assigned_to column in food_donations table
            $update_assigned_query = $connection->prepare("UPDATE food_donations SET assigned_to = ?, delivery_boy = ? WHERE Fid = ?");
            $update_assigned_query->bind_param("iii", $_SESSION['ngo_id'], $delivery_id, $food_id);
            $update_assigned_result = $update_assigned_query->execute();
            if ($update_assigned_result) {
                echo "Order successfully accepted!";
                sendEmailNotification($donation_data);
            } else {
                echo "Error updating assigned_to: " . $connection->error;
            }
        } else {
            echo "Error updating donation status: " . $connection->error;
        }
    } else {
        echo "Donation record not found!";
    }
}

function sendEmailNotification($donation_data)
{
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rockstarmayank2019@gmail.com';
        $mail->Password = 'tthlgaptxjfvigfu'; // Note: Never hardcode credentials in your code
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('rockstarmayank2019@gmail.com', 'MAYANK SHARMA');
        $mail->isHTML(false);
        $mail->Subject = 'Order Received Notification';

        // Send email to the donor
        $ngo_message = "Dear " . htmlspecialchars($donation_data['name']) . ",\n\nThe NGO has received your food donation.\n\nThank you for using our service.";
        $mail->clearAddresses();
        $mail->addAddress($donation_data['email']);
        $mail->Body = $ngo_message;
        if ($mail->send()) {
            echo 'Mail sent successfully';
        } else {
            echo 'Error sending email to NGO: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Error sending email: " . $mail->ErrorInfo;
    }
}
?>