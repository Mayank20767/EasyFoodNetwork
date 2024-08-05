<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "demo");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$donation_id = isset($_GET['donation_id']) ? $_GET['donation_id'] : '';

$donation_query = "SELECT * FROM food_donations WHERE Fid = $donation_id";
$donation_result = mysqli_query($connection, $donation_query);
$donation_data = mysqli_fetch_assoc($donation_result);

// Fetch the NGO details
$ngo_id = $donation_data['assigned_to'];
$ngo_query = "SELECT * FROM ngo WHERE id = $ngo_id";
$ngo_result = mysqli_query($connection, $ngo_query);
$ngo_data = mysqli_fetch_assoc($ngo_result);

$mail = new PHPMailer(true);
try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'rockstarmayank2019@gmail.com';
    $mail->Password = 'tthlgaptxjfvigfu';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('rockstarmayank2019@gmail.com', 'MAYANK SHARMA');
    $mail->isHTML(false);
    $mail->Subject = 'Order Received Notification';

    if ($action === 'ngo_verified') {
        // Send email to the donor
        $ngo_message = "Dear " . htmlspecialchars($donation_data['name']) . ",\n\nThe NGO has received your food donation.\n\nThank you for using our service.";
        $mail->clearAddresses();
        $mail->addAddress($donation_data['email']);
        $mail->Body = $ngo_message;
        if ($mail->send()) {
            $ngo_feedback_message ='<a id="feedbackLink" href="http://localhost/Project2/NGO/history.php?showFeedback=true&orderID=' .$donation_id. '">Click here to provide feedback</a>';
            $mail->clearAddresses();
            $mail->addAddress($ngo_data['email']);
            $mail->Body = $ngo_feedback_message;
            $mail->send();

            $remove_ngo_otp = "UPDATE varification SET ngo_otp='' WHERE Fid = $donation_id";
            $remove_ngo_otp_result = mysqli_query($connection, $remove_ngo_otp);

            $update_query = "UPDATE food_donations SET is_confirmed = 1 WHERE Fid = $donation_id";
            mysqli_query($connection, $update_query);
            $update_query = "UPDATE donation_history SET status = 'confirmed' WHERE Fid = $donation_id";
            mysqli_query($connection, $update_query);
            $delete_query = "DELETE FROM varification WHERE Fid = $donation_id";
            mysqli_query($connection, $delete_query);
            header("Location: delivery_history.php?action=NGO notified successfully!");
            // echo '';
        } else {
            echo 'Error sending email to NGO: ' . $mail->ErrorInfo;
        }
        echo "NGO OTP is verified.";
    } elseif ($action === 'donor_verified') {
        // Send email to the ngo
        $ngo_message = "Dear " . htmlspecialchars($ngo_data['name']) . ",\n\nThe donor has confirmed the OTP for their donation.\nPlease arrange to collect the food.\n\nThank you.";
        $mail->addAddress($ngo_data['email']);
        $mail->Body = $ngo_message;

        if ($mail->send()) {
            $donor_feedback_message ='<a id="feedbackLink" href="http://localhost/Project2/profile.php?showFeedback=true&orderID=' . $donation_id. '">Click here to provide feedback</a>';
            $mail->clearAddresses();
            $mail->addAddress($donation_data['email']);
            $mail->Body = $donor_feedback_message;
            $mail->send();

            $remove_donor_otp = "UPDATE varification SET donor_otp='' WHERE Fid = $donation_id";
            $remove_donor_otp_result = mysqli_query($connection, $remove_donor_otp);
            header("Location: delivery_history.php?action=Donor notified successfully!");
            // echo 'Donor notified successfully!';
        } else {
            echo 'Error sending email to donor: ' . $mail->ErrorInfo;
        }
    } else {
        // Handle other cases or errors
        echo "Invalid action.";
    }
} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>
