<?php
// update_plan.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_id = $_POST['plan_id'];
    $plan_name = $_POST['plan_name'];
    $plan_type = $_POST['plan_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("UPDATE plans SET plan_name = ?, plan_type = ?, start_date = ?, end_date = ?, details = ? WHERE plan_id = ?");
    $stmt->bind_param("sssssi", $plan_name, $plan_type, $start_date, $end_date, $details, $plan_id);

    if ($stmt->execute()) {
        echo "Plan updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
