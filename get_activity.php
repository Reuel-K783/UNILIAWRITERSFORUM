<?php
// get_activities.php
include 'conn.php';

$day_of_week = isset($_GET['day_of_week']) ? $_GET['day_of_week'] : '';

if (!empty($day_of_week)) {
    $sql = "SELECT * FROM timetables WHERE day_of_week = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("s", $day_of_week);
} else {
    $sql = "SELECT * FROM timetables";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
}

if ($stmt->execute() === false) {
    die("Failed to execute statement: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result === false) {
    die("Failed to get result: " . $stmt->error);
}

$activities = array();
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($activities);
?>
