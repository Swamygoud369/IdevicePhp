<?php
header('Content-Type: application/json');
include("includes/db_connection.php");

$party_id = $_POST['party_id'] ?? null;
$pay_amount = $_POST['pay_amount'] ?? null;
$payment_mode = $_POST['payment_mode'] ?? null;

if (!$party_id || !$pay_amount || !$payment_mode) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO payments (party_id, pay_amount, payment_mode) VALUES (?, ?, ?)");
$stmt->bind_param("ids", $party_id, $pay_amount, $payment_mode);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
?>