<?php
// delete_plan.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_id = $_POST['plan_id'];

    $stmt = $conn->prepare("DELETE FROM plans WHERE plan_id = ?");
    $stmt->bind_param("i", $plan_id);

    if ($stmt->execute()) {
        echo "Plan deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
