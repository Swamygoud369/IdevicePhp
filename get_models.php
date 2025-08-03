<?php
include("includes/header.php"); // Make sure this includes your DB credentials

$category_id = $_POST['category_id'] ?? 0;

if ($category_id) {
    $stmt = $conn->prepare("SELECT id, model_name FROM device_models WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Select Model</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['model_name']}'>{$row['model_name']}</option>";
    }

    $stmt->close();
}
$conn->close();
?>
