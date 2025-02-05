<?php
include 'conn.php';

// Fetch data from the database
$sql = "SELECT * FROM timetables";
$result = $conn->query($sql);

$activities = [
    'school' => [],
    'reading' => [],
    'discussion' => [],
    'family_time' => [],
    'friends_time' => []
];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $activities[$row['activity_type']][] = $row;
    }
}

$conn->close();

function renderTable($activityType, $data) {
    if (count($data) == 0) return;

    echo "<h3>" . ucfirst(str_replace('_', ' ', $activityType)) . "</h3>";
    echo "<table border='1'>
    <tr>
    <th>Activity Name</th>
    <th>Activity Time</th>
    <th>Day of Week</th>
    </tr>";

    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . $row['activity_name'] . "</td>";
        echo "<td>" . $row['activity_time'] . "</td>";
        echo "<td>" . $row['day_of_week'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Timetables</title>
</head>
<body>
    
        <?php
            foreach ($activities as $activityType => $data) {
                renderTable($activityType, $data);
            }
        ?>
 
</body>
</html>
