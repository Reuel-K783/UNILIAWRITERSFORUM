<?php
include 'conn.php';

$date = date('Y-m-d'); // Assuming tasks are for the current date

$sql = "SELECT * FROM tasks WHERE date = '$date'";
$result = $conn->query($sql);

$tasks = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

$conn->close();

echo json_encode($tasks);
?>



