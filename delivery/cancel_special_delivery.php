<?php
session_start();
include "../connection.php";

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fid'])) {
    $fid = $_POST['fid'];

    // Fetch NGO details for sending email
    $query = "SELECT assigned_to FROM food_donations WHERE Fid=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $fid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $assigned_to = $row['assigned_to'];

    $query_ngo = "SELECT email FROM ngo WHERE id=?";
    $stmt_ngo = mysqli_prepare($connection, $query_ngo);
    mysqli_stmt_bind_param($stmt_ngo, "i", $assigned_to);
    mysqli_stmt_execute($stmt_ngo);
    $result_ngo = mysqli_stmt_get_result($stmt_ngo);
    $ngo_row = mysqli_fetch_assoc($result_ngo);
    $ngo_email = $ngo_row['email'];

    // Update the database to remove assignment
    $query_update = "UPDATE food_donations SET assigned_to=NULL, delivery_boy=NULL, assignment_timestamp=NULL WHERE Fid=?";
    $stmt_update = mysqli_prepare($connection, $query_update);
    mysqli_stmt_bind_param($stmt_update, "i", $fid);

    $mail = new PHPMailer(true);

    if (mysqli_stmt_execute($stmt_update)) {
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rockstarmayank2019@gmail.com';
            $mail->Password = 'tthlgaptxjfvigfu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('rockstarmayank2019@gmail.com', 'MAYANK SHARMA');;
            $mail->addAddress($ngo_email);

            $mail->isHTML(false);
            $mail->Subject = 'Order Cancellation Notification';
            $mail->Body = "Your order with ID " . $fid . " has been canceled by the delivery person.";

            if ($mail->send()) {
                echo "Order canceled and email sent successfully.";
            } else {
                echo "Order canceled but failed to send email.";
            }
        } catch (Exception $e) {
            echo "Order canceled but failed to send email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to cancel the order.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($connection);
?>