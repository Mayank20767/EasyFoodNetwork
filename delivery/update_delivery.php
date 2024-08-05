<?php
session_start();
include '../connection.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function generateOtp($length = 6)
{
    return substr(str_shuffle("0123456789"), 0, $length);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the food ID from the request
    $food_id = isset($_POST['fid']) ? intval($_POST['fid']) : 0;
    $delivery_person_phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $delivery_person_name = mysqli_real_escape_string($connection, $_SESSION['dname']);

    // Fetch the donation details
    $select_query = "SELECT * FROM food_donations WHERE Fid = $food_id";
    $donation_result = mysqli_query($connection, $select_query);
    $donation_data = mysqli_fetch_assoc($donation_result);

    // Fetch the NGO details
    $ngo_id = $donation_data['assigned_to'];
    $ngo_query = "SELECT * FROM ngo WHERE id = $ngo_id";
    $ngo_result = mysqli_query($connection, $ngo_query);
    $ngo_data = mysqli_fetch_assoc($ngo_result);

    // Generate OTPs
    $donor_otp = generateOtp();
    $ngo_otp = generateOtp();

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'rockstarmayank2019@gmail.com'; // SMTP username
        $mail->Password = 'tthlgaptxjfvigfu'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        // *****************U CAN CHANGE THE DEFAULT NAME**************************

        $donor_email = $donation_data['email'];
        // $donor_email = 'mayank20sharma24@gmail.com';
        $ngo_email = $ngo_data['email'];
        // $ngo_email = 'mayank20sharma24@gmail.com';
        $subject = "Delivery Assignment Notification";

        $donor_message = "Dear %s,\n\nYour order has been assigned to the delivery person:\n\nName: %s\nPhone: %s\nNGO Name: %s\nEstimated Delivery Time: 1 hour from now.\n\nThank you for using our service.\n\nYour OTP IS: %s\n";
        $ngo_message = "Dear %s,\n\nYour assigned donation has been picked up by the delivery person:\n\nName: %s\nPhone: %s\nEstimated Delivery Time: 1 hour from now.\n\nThank you for using our service.\n\nYour OTP IS: %s\n";

        // Sender settings
        $mail->setFrom('rockstarmayank2019@gmail.com', 'MAYANK SHARMA'); // Sender's email and name

        // Email subject and body
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = $subject;

        // Send email to the donor
        $donor_message_body = sprintf($donor_message, htmlspecialchars($donation_data['name']), $delivery_person_name, $delivery_person_phone, htmlspecialchars($ngo_data['name']), $donor_otp);
        $mail->addAddress($donor_email); // Add donor's email
        $mail->Body = $donor_message_body; // Set body to donor message

        if ($mail->send()) {
            $mail->clearAddresses(); // Clear recipient addresses for the next email

            // Send email to the NGO
            $ngo_message_body = sprintf($ngo_message, htmlspecialchars($ngo_data['name']), $delivery_person_name, $delivery_person_phone, $ngo_otp);
            $mail->addAddress($ngo_email); // Add NGO's email
            $mail->Body = $ngo_message_body; // Set body to NGO message

            if ($mail->send()) {
                // Update the verification table with OTPs
                $insert_query = "INSERT INTO varification (Fid, ngo_otp, donor_otp) VALUES ($food_id, '$ngo_otp', '$donor_otp')";
                mysqli_query($connection, $insert_query);

                // Update the food_donations table
                $update_query = "UPDATE food_donations SET delivery_by = " . $_SESSION['Did'] . ", delivery_time = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 HOUR), '%d-%m-%y %H:%i:%s') WHERE Fid = $food_id";
                mysqli_query($connection, $update_query);

                echo 'Order successfully accepted and notifications sent!';
            } else {
                echo 'Error sending email to NGO: ' . $mail->ErrorInfo;
            }
        } else {
            echo 'Error sending email to donor: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
} else {
    echo "Error updating delivery details: " . mysqli_error($connection);
}

?>