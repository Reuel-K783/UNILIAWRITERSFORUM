<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload

function sendEmail($subject, $body, $toEmail) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ckavwenje139nkk@gmail.com'; // Your Gmail address
        $mail->Password   = 'dfqb bpju uqzf fzxt'; // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('ckavwenje139nkk@gmail.com', 'KAVWENJE');
        $mail->addAddress($toEmail); // Recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo 'Email sent successfully!';
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}

// Example usage
$subject = 'Task Reminder';
$body = 'Your task is scheduled in 5 minutes.';
$toEmail = 'ckavwenje139nkk@gmail.com';

sendEmail($subject, $body, $toEmail);
?>