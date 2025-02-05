<?php
// get_clothing.php
include 'conn.php';

$sql = "SELECT * FROM clothing ORDER BY date ASC";
$result = $conn->query($sql);

$clothing = array();
while ($row = $result->fetch_assoc()) {
    $clothing[] = $row;
}

$conn->close();

echo json_encode($clothing);
?>
