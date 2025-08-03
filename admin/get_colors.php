<?php
header('Content-Type: application/json');
include("includes/db_connection.php");

$sql = "SELECT color_id, color_name FROM colors ORDER BY color_name ASC";
$result = $conn->query($sql);

$colors = [];

while ($row = $result->fetch_assoc()) {
    $colors[] = [
        'id' => $row['color_id'],
        'name' => $row['color_name']
    ];
}

echo json_encode(['status' => 'success', 'data' => $colors]);
?>
