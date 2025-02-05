<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Tracker</title>
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
    <h1>Income Tracker</h1>
    
    <form action="save_income.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
        <button type="submit">Add Income</button>
    </form>

    <?php
    require 'conn.php';

    // Fetch income data from the database
    $sql = "SELECT title, date, amount FROM income ORDER BY date";
    $result = $conn->query($sql);

    // Initialize an array to store grouped data
    $grouped_income = [];

    // Group income data by month
    while ($row = $result->fetch_assoc()) {
        $date = new DateTime($row['date']);
        $month = $date->format('Y-m'); // Group by year and month (e.g., "2025-02")

        if (!isset($grouped_income[$month])) {
            $grouped_income[$month] = [];
        }

        $grouped_income[$month][] = $row;
    }

    // Calculate total income and display grouped data
    $total_income = 0;
    foreach ($grouped_income as $month => $income_data) {
        echo "<h2>Income for $month</h2>";
        echo "<table>";
        echo "<tr><th>Title</th><th>Date</th><th>Amount</th></tr>";

        $monthly_total = 0;
        foreach ($income_data as $entry) {
            echo "<tr>";
            echo "<td>{$entry['title']}</td>";
            echo "<td>{$entry['date']}</td>";
            echo "<td>{$entry['amount']}</td>";
            echo "</tr>";

            $monthly_total += $entry['amount'];
            $total_income += $entry['amount'];
        }

        echo "<tr><td colspan='2'><strong>Monthly Total</strong></td><td><strong>$monthly_total</strong></td></tr>";
        echo "</table>";
    }

    // Fetch all amounts for calculations
    $amounts = [];
    $result = $conn->query("SELECT amount FROM income");
    while ($row = $result->fetch_assoc()) {
        $amounts[] = $row['amount'];
    }

    // Check if there are any income entries
    if (count($amounts) > 0) {
        // Calculate mean (average) income
        $mean = array_sum($amounts) / count($amounts);

        // Calculate standard deviation
        $sum_squared_diffs = 0;
        foreach ($amounts as $amount) {
            $sum_squared_diffs += pow($amount - $mean, 2);
        }
        $stdDev = sqrt($sum_squared_diffs / (count($amounts) - 1));

        // Predict future income using mean and standard deviation
        $days_to_predict = 7;
        $predicted_income = [];
        for ($i = 0; $i < $days_to_predict; $i++) {
            $predicted_income[] = $mean + (rand(-100, 100) / 100) * $stdDev;
        }

        $predicted_total_income = array_sum($predicted_income);
    } else {
        // Handle case where there are no income entries
        $mean = 0;
        $stdDev = 0;
        $predicted_income = array_fill(0, 7, 0); // Predict zero income for 7 days
        $predicted_total_income = 0;
    }
    ?>

    <h2>Predicted Income</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        <?php for ($i = 0; $i < $days_to_predict; $i++): ?>
        <tr>
            <td><?= date('Y-m-d', strtotime('+'.($i + 1).' days')) ?></td>
            <td><?= number_format($predicted_income[$i], 2) ?></td>
        </tr>
        <?php endfor; ?>
    </table>

    <div class="summary">
        <p><strong>Total Income:</strong> <?= $total_income ?></p>
        <p><strong>Predicted Total Income:</strong> <?= number_format($predicted_total_income, 2) ?></p>
    </div>
</body>
</html>
