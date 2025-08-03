<?php
include("includes/db_connection.php");

$editData = null;
$message = "";

// Handle Add/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $tagline = $_POST['tagline'];
    $image = $_FILES['cover_image']['name'] ?? '';
    $upload_dir = "uploads/covers/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target = '';
    if ($image) {
        $tmp_name = $_FILES['cover_image']['tmp_name'];
        $target = $upload_dir . time() . "_" . basename($image);
        move_uploaded_file($tmp_name, $target);
    }

    if ($id) {
        if ($image) {
            $stmt = $conn->prepare("UPDATE cover_photos SET image = ?, tagline = ? WHERE id = ?");
            $stmt->bind_param("ssi", $target, $tagline, $id);
        } else {
            $stmt = $conn->prepare("UPDATE cover_photos SET tagline = ? WHERE id = ?");
            $stmt->bind_param("si", $tagline, $id);
        }
        $stmt->execute();
        $stmt->close();
        $message = "Cover updated successfully!";
    } else {
        $stmt = $conn->prepare("INSERT INTO cover_photos (image, tagline) VALUES (?, ?)");
        $stmt->bind_param("ss", $target, $tagline);
        $stmt->execute();
        $stmt->close();
        $message = "Cover added successfully!";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = $conn->query("SELECT image FROM cover_photos WHERE id = $id");
    $row = $result->fetch_assoc();
    if ($row && file_exists($row['image'])) {
        unlink($row['image']);
    }
    $conn->query("DELETE FROM cover_photos WHERE id = $id");
    header("Location: cover_image.php");
    exit;
}

// Handle Edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM cover_photos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $editData = $res->fetch_assoc();
    $stmt->close();
}

// Fetch all cover data
$covers = $conn->query("SELECT * FROM cover_photos ORDER BY id DESC");

// Now include the HTML layout
include("listcovers.php");
?>
