<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/db_connection.php");

// if (isset($_POST['model_name']) && isset($_POST['color'])) {
//     $model_name = $_POST['model_name'];
//     $color = $_POST['color'];

//     $stmt = $conn->prepare("SELECT quantity FROM device_stockmodels WHERE model_name = ? AND color = ?");
//     $stmt->bind_param("ss", $model_name, $color);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($row = $result->fetch_assoc()) {
//         echo json_encode(['quantity' => (int)$row['quantity']]);
//     } else {
//         echo json_encode(['quantity' => 0]);
//     }
//     $conn->close();
// }

$model_name = $_POST['model_name'] ?? '';
$color = $_POST['color'] ?? '';

    $stmt = $conn->prepare("SELECT SUM(quantity) as total_quantity FROM device_stockmodels WHERE model_name = ? AND color = ?");
    // $sql = "SELECT quantity FROM device_stockmodels WHERE model_name = ? AND color = ? LIMIT 1";

// $stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $model_name, $color);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

    echo json_encode([
        'quantity' => $result['total_quantity'] ?? 0
    ]);
// $result = $stmt->get_result();

// $qty = 0;
// if ($row = $result->fetch_assoc()) {
//     $qty = $row['quantity'];
// }

// echo json_encode(['quantity' => $qty]);



?>
