<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// Database connection
// $servername = "cpanel-sh048.webhostingservices.com"; // Replace with your database host
// $username = "abhinave_college"; // Replace with your database username
// $password = "Laddunani@123"; // Replace with your database password
// $dbname = "abhinave_college"; 

// local
$servername = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "swamy"; 


//server 

// $servername = "localhost";
// $username = "u111310158_Idevice";
// $password = "I@Device123";
// $dbname = "u111310158_Idevice";



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));} 
    
?>