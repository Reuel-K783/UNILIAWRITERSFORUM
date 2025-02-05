<?php
require 'send_email.php'; // Include the email sending script

// Function to check reminders
function checkReminders() {
    // Connect to your database
   include("conn.php");

    // Get current time and time 5 minutes from now
    $currentTime = date('Y-m-d H:i:s');
    $reminderTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    // Check tasks
    $sql = "SELECT * FROM tasks WHERE task_time BETWEEN '$currentTime' AND '$reminderTime'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subject = 'Task Reminder: ' . $row['task_name'];
            $body = 'Your task "' . $row['task_name'] . '" is scheduled at ' . $row['task_time'] . '.';
            sendEmail($subject, $body, 'ckavwenje139nkk@gmail.com');
        }
    }

    // Check timetables
    $sql = "SELECT * FROM timetables WHERE activity_time BETWEEN '$currentTime' AND '$reminderTime'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subject = 'Timetable Reminder: ' . $row['activity_name'];
            $body = 'Your activity "' . $row['activity_name'] . '" is scheduled at ' . $row['activity_time'] . '.';
            sendEmail($subject, $body, 'ckavwenje139nkk@gmail.com');
        }
    }

    // Check loans (if applicable)
    // Add your loan reminder logic here

    $conn->close();
}

// Run the reminder check
checkReminders();
?>