<?php
include("includes/db_connection.php");
header('Content-Type: application/json');

// $spare_name = $_POST['spare_nametxt'] ?? '';
// $category_id = $_POST['category_id'] ?? '';

// if (empty($spare_name) || empty($category_id)) {
//     echo json_encode(['status' => 'error', 'message' => 'Missing spare name or category ID']);
//     exit;
// }

// $stmt = $conn->prepare("INSERT INTO device_spares (spare_name, category_id) VALUES (?, ?)");
// $stmt->bind_param("si", $spare_name, $category_id);

// if ($stmt->execute()) {
//     echo json_encode(['status' => 'success', 'message' => 'Spare added', 'spare_id' => $stmt->insert_id]);
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
// }




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spare_name = $_POST['spare_nametxt'] ?? '';
    $category_id = $_POST['category_id'] ?? '';

    if (empty($spare_name) || empty($category_id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing model name or category ID'
        ]);
        exit;
    }

    // FIXED: Use correct column name 'model_name'
    $stmt = $conn->prepare("INSERT INTO device_spares (spare_name, category_id) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $spare_name, $category_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'spare_id' => $conn->insert_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}



?>
