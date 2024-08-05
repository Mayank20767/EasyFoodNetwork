<?php
session_start();
include '../connection.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_id = isset($_POST['fid']) ? intval($_POST['fid']) : 0;

    $search_query = "SELECT ngos FROM food_donations WHERE Fid = $food_id";
    $result = mysqli_query($connection, $search_query);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $left_ngos = str_replace($_SESSION['ngo_name'], '', $row['ngos']);
            $left_ngos = trim($left_ngos, ', ');
            $left_ngos = preg_replace('/\s*,\s*/', ',', $left_ngos);
            $update_query = "UPDATE food_donations SET ngos='$left_ngos' WHERE Fid='$food_id'";
            $result = mysqli_query($connection, $update_query);
        }
        if ($result && empty(trim($left_ngos))) {

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

                // Fetch donor's email
                $donor_query = "SELECT email, name FROM food_donations WHERE Fid = $food_id";
                $donor_result = mysqli_query($connection, $donor_query);
                if ($donor_result && mysqli_num_rows($donor_result) > 0) {
                    $donor_data = mysqli_fetch_assoc($donor_result);
                    $donor_email = $donor_data['email'];
                    $donor_name = $donor_data['name'];

                    // Compose email
                    $subject = "Order Rejected Notification";
                    $message = "Dear $donor_name,\n\nWe regret to inform you that your order has been rejected by the NGO.\n\nThank you for using our service.";
                    $repeat_order = '<a href="http://localhost/Project2/fooddonateform.php">Again Order</a>';
                    $donor_feedback_message = '<a id="feedbackLink" href="http://localhost/Project2/profile.php?showFeedback=true&orderID=' . $food_id . '">Click here to provide feedback</a>';

                    // Sender and recipient settings
                    $mail->setFrom('rockstarmayank2019@gmail.com', 'MAYANK SHARMA'); // Sender's email and name
                    $mail->addAddress($donor_email); // Add donor's email

                    // Email subject and body
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = $subject;
                    $mailContent = nl2br($message) . "<br><br>" . $repeat_order . "<br><br>" . $donor_feedback_message;
                    $mail->Body = $mailContent;

                    // Send email
                    if ($mail->send()) {
                        echo 'Notification sent to donor: Order rejected.';
                        $query = "DELETE FROM food_donations WHERE Fid = $food_id";
                        mysqli_query($connection, $query);
                    } else {
                        echo 'Error sending notification to donor: ' . $mail->ErrorInfo;
                    }
                } else {
                    echo 'Donor not found.';
                }
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    } else {
        echo "Invalid request method.";
    }
}
?>