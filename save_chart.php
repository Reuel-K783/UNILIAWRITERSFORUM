<?php
$data = json_decode(file_get_contents('php://input'), true);
$image = $data['image'];

$image = str_replace('data:image/png;base64,', '', $image);
$image = str_replace(' ', '+', $image);
$fileData = base64_decode($image);

$filePath = 'dailyTasksChart.png';
file_put_contents($filePath, $fileData);

echo json_encode(['status' => 'success', 'filePath' => $filePath]);
?>
