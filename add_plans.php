<?php
// add_plan.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_name = $_POST['plan_name'];
    $plan_type = $_POST['plan_type']; // 'long-term' or 'short-term'
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("INSERT INTO plans (plan_name, plan_type, start_date, end_date, details) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $plan_name, $plan_type, $start_date, $end_date, $details);

    if ($stmt->execute()) {
        echo "New plan added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
