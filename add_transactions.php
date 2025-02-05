<?php
// add_transaction.php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $transaction_type = $_POST['transaction_type'];
    $category = $_POST['category'];
    $transaction_date = $_POST['transaction_date'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO transactions (amount, transaction_type, category, transaction_date, notes) VALUES ('$amount', '$transaction_type', '$category', '$transaction_date', '$notes')";

if ($conn->query($sql) === TRUE) {
    echo "Transaction recorded successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>