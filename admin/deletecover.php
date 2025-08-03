<?php
$id = $_GET['id'];

// First delete the image file
$result = $conn->query("SELECT image FROM cover_photos WHERE id = $id");
$row = $result->fetch_assoc();
if (file_exists($row['image'])) {
    unlink($row['image']);
}

$conn->query("DELETE FROM cover_photos WHERE id = $id");
header("Location: listcovers.php");
