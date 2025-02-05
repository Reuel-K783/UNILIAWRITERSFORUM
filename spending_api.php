<?php
header("Content-Type: application/json");
require 'conn.php';  // Database connection

// Function to calculate mean
function calculateMean($values) {
    return array_sum($values) / count($values);
}

// Function to calculate standard deviation
function calculateStandardDeviation($values, $mean) {
    $sum_squared_diffs = 0;
    foreach ($values as $value) {
        $sum_squared_diffs += pow($value - $mean, 2);
    }
    return sqrt($sum_squared_diffs / (count($values) - 1));
}

// Fetch spending data
$sql = "SELECT date, amount FROM spending ORDER BY date";
$result = $conn->query($sql);

$amounts = [];
while ($row = $result->fetch_assoc()) {
    $amounts[] = $row['amount'];
}

$response = [];

if (count($amounts) > 0) {
    $mean = calculateMean($amounts);
    $stdDev = calculateStandardDeviation($amounts, $mean);

    // Predict spending for the next 7 days
    $predictions = [];
    for ($i = 0; $i < 7; $i++) {
        $predicted_amount = $mean + (rand(-50, 50) / 100) * $stdDev; // Slight randomness
        $predictions[] = [
            "date" => date('Y-m-d', strtotime("+$i days")),
            "predicted_amount" => round($predicted_amount, 2)
        ];
    }

    
    // API response
    $response = [
        "status" => "success",
        "mean" => round($mean, 2),
        "stdDev" => round($stdDev, 2),
        "predictions" => $predictions
    ];
} else {
    $response = [
        "status" => "error",
        "message" => "No spending data found."
    ];
}

echo json_encode($response);
?>
