<?php
// add_clothing.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clothing_item = $_POST['clothing_item'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO clothing (clothing_item, date) VALUES (?, ?)");
    $stmt->bind_param("ss", $clothing_item, $date);

    if ($stmt->execute()) {
        echo "Clothing arrangement saved";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
