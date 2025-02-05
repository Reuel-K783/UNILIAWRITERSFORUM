<?php
// delete_expired_tasks.php
include 'conn.php';

$sql = "DELETE FROM tasks WHERE created_at < NOW() - INTERVAL 24 HOUR";

if ($conn->query($sql) === TRUE) {
    echo "Expired tasks deleted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
