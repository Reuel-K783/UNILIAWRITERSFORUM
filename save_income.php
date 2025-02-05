<?php
// Include the database connection file
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];

    // Use a prepared statement to insert data safely
    $sql = "INSERT INTO income (title, date, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $title, $date, $amount); // "ssd" means string, string, double

    if ($stmt->execute()) {
        // Redirect back to the main page
        header('Location: income.php'); 
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
