<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php'; 
require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php';

// Function to generate OTP
function generateOTP($length = 6)
{
    return rand(pow(10, $length - 1), pow(10, $length) - 1);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'send_otp') {
            $email = $_POST['email'];
            $username = $_POST['name'];

            // Generate OTP
            $_SESSION['otp'] = generateOTP();

            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rockstarmayank2019@gmail.com'; // Your email
                $mail->Password = 'tthlgaptxjfvigfu'; // Your email password/app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Sender and recipient
                $mail->setFrom('your_email@example.com', 'Your Name');
                $mail->addAddress($email, $username);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'OTP Verification';
                $mail->Body = 'Your OTP for registration is: ' . $_SESSION['otp'];

                $mail->send();
                echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully.']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
            }
            exit;
        } elseif ($action == 'verify_otp') {
            $otp = $_POST['otp'];
            if ($otp == $_SESSION['otp']) {
                echo json_encode(['status' => 'success', 'message' => 'OTP verified successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Incorrect OTP.']);
            }
            exit;
        }
    }
}
?>
