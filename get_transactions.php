<?php
// get_transactions.php
include 'conn.php';

$sql = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$result = $conn->query($sql);

$transactions = array();
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

$conn->close();

echo json_encode($transactions);
?>


