<?php
include '../connection.php';
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['restrict_user'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $order_id = $_POST['order_id'];
    $message = "You have been restricted due to abusive comments.";

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rockstarmayank2019@gmail.com'; // Your email
        $mail->Password = 'tthlgaptxjfvigfu'; // Your email password/app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress($email, $name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Abusing Comments On Feedback';
        $mail->Body = $message;
        $mail->send();

        // Ensure $connection is valid
        if ($connection->connect_error) {
            throw new Exception('Database connection failed: ' . $connection->connect_error);
        }

        $query = "DELETE FROM feedback WHERE order_id=? AND email=?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("is", $order_id, $email);
        $stmt->execute();

        header("Location: view_feedback.php?status=success&message=Mail+sent+successfully");
    } catch (Exception $e) {
        header("Location: view_feedback.php?status=error&message=Mail+could+not+be+sent.+Mailer+Error:+" . urlencode($mail->ErrorInfo));
    }
    exit;
}

if (isset($_POST['remove_user'])) {
    $email = $_POST['email'];
    $order_id = $_POST['order_id'];

    // Ensure $connection is valid
    if ($connection->connect_error) {
        throw new Exception('Database connection failed: ' . $connection->connect_error);
    }

    $query = "DELETE FROM login WHERE email=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $query = "DELETE FROM ngo WHERE email=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $query = "DELETE FROM feedback WHERE email=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    header("Location: view_feedback.php?status=success&message=User+removed+successfully");
    exit;
}
?>