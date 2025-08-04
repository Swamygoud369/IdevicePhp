<?php
include("includes/db_connection.php");
header('Content-Type: application/json');

// $category_id = $_GET['category_id'] ?? '';
// $data = [];

// if (!empty($category_id)) {
//     $stmt = $conn->prepare("SELECT id, spare_name FROM device_spares WHERE category_id = ?");
//     $stmt->bind_param("i", $category_id);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     while ($row = $result->fetch_assoc()) {
//         $data[] = ['id' => $row['id'], 'name' => $row['spare_name']];
//     }
// }

// echo json_encode(['status' => 'success', 'data' => $data]);





$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$sql = "SELECT id, spare_name FROM device_spares WHERE category_id = $category_id ORDER BY spare_name ASC";
$result = $conn->query($sql);

$models = [];
while ($row = $result->fetch_assoc()) {
    $models[] = [
        'id' => $row['id'],
        'name' => $row['spare_name']
    ];
}

echo json_encode(['status' => 'success', 'data' => $models]);







?>
