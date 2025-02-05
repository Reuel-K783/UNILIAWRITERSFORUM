<?php
// get_plans.php
include 'conn.php';

$plan_type = isset($_GET['plan_type']) ? $_GET['plan_type'] : '';

if (!empty($plan_type)) {
    $sql = "SELECT * FROM plans WHERE plan_type = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("s", $plan_type);
} else {
    $sql = "SELECT * FROM plans";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
}

$stmt->execute();
$result = $stmt->get_result();

$plans = array();
while ($row = $result->fetch_assoc()) {
    $plans[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($plans);
?>
