<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload

$to = "ckavwenje139nkk@gmail.com";
$subject = "Test Email";
$message = "Hello! This is a test email from PHP.";

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ckavwenje139nkk@gmail.com'; // Your Gmail address
    $mail->Password   = 'dfqb bpju uqzf fzxt'; // Your Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port       = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom('ckavwenje139nkk@gmail.com', 'Your Name');
    $mail->addAddress($to); // Add a recipient

    // Content
    $mail->isHTML(false); // Set email format to plain text
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    echo "Email sent successfully!";
} catch (Exception $e) {
    echo "Failed to send email. Error: {$mail->ErrorInfo}";
}
?>
