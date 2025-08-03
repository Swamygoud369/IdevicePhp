<?php
header('Content-Type: application/json');
include("includes/db_connection.php");

// // $sql = "SELECT model_id, model_name FROM models ORDER BY model_name ASC";
// $sql = "SELECT id, model_name FROM device_models ORDER BY model_name ASC";

// $result = $conn->query($sql);

// $models = [];

// while ($row = $result->fetch_assoc()) {
//     $models[] = [
//         'id' => $row['id'],
//         'name' => $row['model_name']
//     ];
// }

// echo json_encode(['status' => 'success', 'data' => $models]);

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$sql = "SELECT id, model_name FROM device_models WHERE category_id = $category_id ORDER BY model_name ASC";
$result = $conn->query($sql);

$models = [];
while ($row = $result->fetch_assoc()) {
    $models[] = [
        'id' => $row['id'],
        'name' => $row['model_name']
    ];
}

echo json_encode(['status' => 'success', 'data' => $models]);


?>
