<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spending Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Spending Tracker</h1>
    <form action="save_spending.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
        <button type="submit">Add Spending</button>
    </form>

    <?php
    require 'conn.php';

    // Fetch spending data from the database
    $sql = "SELECT title, date, amount FROM spending ORDER BY date";
    $result = $conn->query($sql);

    // Initialize an array to store grouped data
    $grouped_spending = [];

    // Group spending data by month
    while ($row = $result->fetch_assoc()) {
        $date = new DateTime($row['date']);
        $month = $date->format('Y-m'); // Group by year and month (e.g., "2023-01")

        if (!isset($grouped_spending[$month])) {
            $grouped_spending[$month] = [];
        }

        $grouped_spending[$month][] = $row;
    }

    // Calculate total expenses and display grouped data
    $total_expense = 0;
    foreach ($grouped_spending as $month => $spending_data) {
        echo "<h2>Spending for $month</h2>";
        echo "<table>";
        echo "<tr><th>Title</th><th>Date</th><th>Amount</th></tr>";

        $monthly_total = 0;
        foreach ($spending_data as $entry) {
            echo "<tr>";
            echo "<td>{$entry['title']}</td>";
            echo "<td>{$entry['date']}</td>";
            echo "<td>{$entry['amount']}</td>";
            echo "</tr>";

            $monthly_total += $entry['amount'];
            $total_expense += $entry['amount'];
        }

        echo "<tr><td colspan='2'><strong>Monthly Total</strong></td><td><strong>$monthly_total</strong></td></tr>";
        echo "</table>";
    }

    // Fetch all amounts for calculations
    $amounts = [];
    $result = $conn->query("SELECT amount FROM spending");
    while ($row = $result->fetch_assoc()) {
        $amounts[] = $row['amount'];
    }

    // Check if there are any spending entries
    if (count($amounts) > 0) {
        // Calculate mean (average) spending
        $mean = array_sum($amounts) / count($amounts);

        // Calculate standard deviation
        $sum_squared_diffs = 0;
        foreach ($amounts as $amount) {
            $sum_squared_diffs += pow($amount - $mean, 2);
        }
        $stdDev = sqrt($sum_squared_diffs / (count($amounts) - 1));

        // Predict future spending using mean and standard deviation
        $days_to_predict = 7;
        $predicted_spending = [];
        for ($i = 0; $i < $days_to_predict; $i++) {
            $predicted_spending[] = $mean + (rand(-100, 100) / 100) * $stdDev;
        }

        $predicted_total_expense = array_sum($predicted_spending);
    } else {
        // Handle case where there are no spending entries
        $mean = 0;
        $stdDev = 0;
        $predicted_spending = array_fill(0, 7, 0); // Predict zero spending for 7 days
        $predicted_total_expense = 0;
    }
    ?>

    <h2>Predicted Spending</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        <?php for ($i = 0; $i < $days_to_predict; $i++): ?>
        <tr>
            <td><?= date('Y-m-d', strtotime('+'.($i + 1).' days')) ?></td>
            <td><?= number_format($predicted_spending[$i], 2) ?></td>
        </tr>
        <?php endfor; ?>
    </table>

    <div class="summary">
        <p><strong>Total Expense:</strong> <?= $total_expense ?></p>
        <p><strong>Predicted Total Expense:</strong> <?= number_format($predicted_total_expense, 2) ?></p>
    </div>
</body>
</html>