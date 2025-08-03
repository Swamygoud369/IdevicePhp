<?php

$id = $_POST['id'];
$tagline = $_POST['tagline'];
$image = $_FILES['cover_image']['name'];

if ($image) {
    $tmp_name = $_FILES['cover_image']['tmp_name'];
    $upload_dir = "uploads/covers/";
    $target = $upload_dir . time() . "_" . basename($image);
    move_uploaded_file($tmp_name, $target);
    
    $stmt = $conn->prepare("UPDATE cover_photos SET image = ?, tagline = ? WHERE id = ?");
    $stmt->bind_param("ssi", $target, $tagline, $id);
} else {
    $stmt = $conn->prepare("UPDATE cover_photos SET tagline = ? WHERE id = ?");
    $stmt->bind_param("si", $tagline, $id);
}
$stmt->execute();
$stmt->close();
header("Location: listcovers.php");


?>