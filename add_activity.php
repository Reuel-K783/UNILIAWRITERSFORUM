<?php
// add_activity.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $activity_name = $_POST['activity_name'];
    $activity_type = $_POST['activity_type'];
    $activity_time = $_POST['activity_time'];
    $day_of_week = $_POST['day_of_week'];

    $stmt = $conn->prepare("INSERT INTO timetables (activity_name, activity_type, activity_time, day_of_week) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $activity_name, $activity_type, $activity_time, $day_of_week);

    if ($stmt->execute()) {
        echo "Activity added to timetable";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
