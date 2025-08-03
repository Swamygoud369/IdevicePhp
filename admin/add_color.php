<?php
header('Content-Type: application/json');
include("includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $color_name = trim($_GET['color_name'] ?? '');

    if ($color_name !== '') {
        $stmt = $conn->prepare("INSERT INTO colors (color_name) VALUES (?)");
        $stmt->bind_param("s", $color_name);

        if ($stmt->execute()) {
            $last_id = mysqli_insert_id($conn);
            echo json_encode(['status' => 'success', 'color_id' => $last_id]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Color name required']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
