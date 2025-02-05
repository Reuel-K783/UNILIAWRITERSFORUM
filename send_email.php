<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("conn.php");

// Fetch tasks from database
$sql = "SELECT task_name, task_time, date FROM tasks ORDER BY task_time ASC";
$result = $conn->query($sql);

$taskList = "<h1>Daily Task Schedule</h1>";
$taskList .= "<table border='1' cellpadding='5' cellspacing='0'>";
$taskList .= "<tr><th>Task</th><th>Date</th><th>Status</th></tr>";

while ($row = $result->fetch_assoc()) {
    $taskList .= "<tr>
                    <td>{$row['task_name']}</td>
                    <td>{$row['task_time']}</td>
                    <td>{$row['date']}</td>
                  </tr>";
}

$taskList .= "</table>";

$conn->close();

// Send email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ckavwenje139nkk@gmail.com';
    $mail->Password = 'dfqb bpju uqzf fzxt'; // Use an App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('ckavwenje139nkk@gmail.com', 'KAVWENJE');
    $mail->addAddress('ckavwenje139nkk@gmail.com', 'REUEL');

    $mail->isHTML(true);
    $mail->Subject = 'Daily Task Schedule';
    $mail->Body    = $taskList;

    $mail->send();
    echo 'Task schedule email sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
