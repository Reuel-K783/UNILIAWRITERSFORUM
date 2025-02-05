<?php
header("Content-Type: application/json");
require 'conn.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch spending data for chart
    $sql_spending = "SELECT title, date, amount FROM spending ORDER BY date";
    $result_spending = $conn->query($sql_spending);
    $spending_data = [];

    while ($row = $result_spending->fetch_assoc()) {
        $spending_data[] = $row;
    }

    // Fetch income data for chart
    $sql_income = "SELECT title, date, amount FROM income ORDER BY date";
    $result_income = $conn->query($sql_income);
    $income_data = [];

    while ($row = $result_income->fetch_assoc()) {
        $income_data[] = $row;
    }

    // Return both spending and income data as JSON
    echo json_encode([
        'spending' => $spending_data,
        'income' => $income_data
    ]);
} elseif ($method === 'POST') {
    // Add new spending entry
    $input = json_decode(file_get_contents("php://input"), true);
    if (isset($input['title'], $input['date'], $input['amount'])) {
        $title = $conn->real_escape_string($input['title']);
        $date = $conn->real_escape_string($input['date']);
        $amount = (float) $input['amount'];
        
        $sql = "INSERT INTO spending (title, date, amount) VALUES ('$title', '$date', $amount)";
        if ($conn->query($sql)) {
            echo json_encode(["success" => true, "message" => "Spending added successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error adding spending"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
}
