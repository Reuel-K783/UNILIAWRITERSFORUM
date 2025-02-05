<?php
// add_task.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['task_name'];
    $task_time = $_POST['task_time'];
    $date = date('Y-m-d'); // Assuming tasks are for the current date

    $sql = "INSERT INTO tasks (task_name, task_time, date) VALUES ('$task_name', '$task_time', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "New task added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
