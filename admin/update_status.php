<?php
session_start();
include("includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $status = $_POST['status'] ?? 'Pending';

    $stmt = $conn->prepare("UPDATE device_services SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
                    session_start();

        $_SESSION['message'] = "✅ Status updated to $status";
        $_SESSION['alert_type'] = "success";
    } else {
                    session_start();

        $_SESSION['message'] = "❌ Failed to update status.";
        $_SESSION['alert_type'] = "danger";
    }

    $stmt->close();
    header("Location: service_details.php?id=$id");
    exit;
}
