<?php
header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swamy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

$response = [];

// Check request method
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['id']) && isset($_POST['about_text'])) {
            // Update Operation
            $id = intval($_POST['id']);
            $about_text = $conn->real_escape_string($_POST['about_text']);
    
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = $conn->real_escape_string($target_file);
                    $sql = "UPDATE about_us SET image_url='$image_url', about_text='$about_text' WHERE id=$id";
                } else {
                    $response = ["message" => "Error uploading file."];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $sql = "UPDATE about_us SET about_text='$about_text' WHERE id=$id";
            }
    
            if ($conn->query($sql) === TRUE) {
                $response = ["message" => "Record updated successfully"];
                echo json_encode($response);
                header("Location: aboutus.php");
                exit;
            } else {
                $response = ["message" => "Error updating record: " . $conn->error];
                echo json_encode($response);
                exit;
            }
        } else if (!isset($_FILES['image']) || !isset($_POST['about_text'])) {
            $response = ["message" => "Missing image or text data."];
            echo json_encode($response);
            exit;
        } else {
            // Handle file upload
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $conn->real_escape_string($target_file);
                $about_text = $conn->real_escape_string($_POST['about_text']);
                $sql = "INSERT INTO about_us (image_url, about_text) VALUES ('$image_url', '$about_text')";
                if ($conn->query($sql) === TRUE) {
                    $response = ["message" => "Record created successfully"];
                    echo json_encode($response);
                    header("Location: aboutus.php");
                    exit;
                } else {
                    $response = ["message" => "Error inserting record: " . $conn->error];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = ["message" => "Error uploading file."];
                echo json_encode($response);
                exit;
            }
        }
        break;

    case 'GET':
        // Read Operation
        $sql = "SELECT id, image_url, about_text FROM about_us";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $records = [];
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            $response = $records;
        } else {
            $response = ["message" => "No records found"];
        }
        echo json_encode($response);
        exit;

    default:
        $response = ["message" => "Invalid request method"];
        echo json_encode($response);
        exit;
}

// Close connection
$conn->close();
?>