<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
ini_set('display_errors', 1);
error_reporting(E_ALL);




//local
// $servername = "localhost"; // Replace with your database host
// $username = "root"; // Replace with your database username
// $password = ""; // Replace with your database password
// $dbname = "swamy"; 


//server 

$servername = "localhost";
$username = "u111310158_Idevice";
$password = "I@Device123";
$dbname = "u111310158_Idevice";



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// // Collect POST data
// $name = $_POST['yname'] ?? '';
// $email = $_POST['email'] ?? '';
// $phone = $_POST['phonenumber'] ?? '';
// $date = $_POST['booking_date'] ?? '';
// $time = $_POST['booking_time'] ?? '';
// $device = $_POST['selectOption'] ?? '';
// $brand = $_POST['selectbarnd'] ?? '';
// $message = $_POST['subject'] ?? '';

// // Validate minimal
// if ($name && $email) {
//     $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, booking_date, booking_time, device, brand, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("ssssssss", $name, $email, $phone, $date, $time, $device, $brand, $message);

//     if ($stmt->execute()) {
//         echo "success";
//     } else {
//         echo "Error: " . $stmt->error;
//     }
//     $stmt->close();
// } else {
//     echo "Missing fields.";
// }

// $conn->close();


$name               = $_POST['yname'] ?? '';
$email              = $_POST['email'] ?? '';
$phone              = $_POST['phonenumber'] ?? '';
$location           = $_POST['location'] ?? '';
$imei_no            = $_POST['imeino'] ?? '';
$device_issue       = $_POST['deviceissue'] ?? '';
$issue              = $_POST['issue'] ?? '';
$service_location   = $_POST['location'] ?? '';
$message            = $_POST['subject'] ?? '';
$booking_date       = $_POST['booking_date'] ?? '';
$booking_time       = $_POST['booking_time'] ?? '';
$next_booking_date  = $_POST['nextbooking_date'] ?? '';
$next_booking_time  = $_POST['nextbooking_time'] ?? '';
$categoryId = $_POST['category'] ?? '';
$brand = $_POST['model'] ?? '';



$device = '';
if (!empty($categoryId)) {
    $res = $conn->query("SELECT category_name FROM device_categories WHERE id = " . (int)$categoryId);
    if ($res && $row = $res->fetch_assoc()) {
        $device = $row['category_name'];
    }
}



// Validate basic required fields
if ($name && $email && $phone) {
    $stmt = $conn->prepare("INSERT INTO bookings 
        (name, email, phone, location, imei_no, device_issue, issue, service_location, message, booking_date, booking_time, next_booking_date, next_booking_time, device, brand) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssssss", 
        $name, $email, $phone, $location, $imei_no, $device_issue, $issue, $service_location, $message,
        $booking_date, $booking_time, $next_booking_date, $next_booking_time, $device, $brand);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing required fields.";
}

$conn->close();



?>
