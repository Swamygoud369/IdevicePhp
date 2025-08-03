<?php
header("Access-Control-Allow-Origin: *");

// $servername = "localhost";
// $username = "u111310158_Idevice";
// $password = "I@Device123";
// $dbname = "u111310158_Idevice";


$servername = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "swamy"; 


// $servername = "localhost";
// $username = "u111310158_Idevice";
// $password = "I@Device123";
// $dbname = "u111310158_Idevice";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed");
}

$sql = "SELECT * FROM bookings ORDER BY id DESC";
$result = $conn->query($sql);

$html = '';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $time = new DateTime($row['booking_time']);
        $nextTime = new DateTime($row['next_booking_time']);

        // $html .= '<tr>';
        // $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        // $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        // $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        // $html .= '<td>' . htmlspecialchars($row['booking_date']) . '</td>';
        // $html .= '<td>' . $time->format('h:i A') . '</td>';
        // $html .= '<td>' . htmlspecialchars($row['device']) . '</td>';
        // $html .= '<td>' . htmlspecialchars($row['brand']) . '</td>';
        // $html .= '<td>' . nl2br(htmlspecialchars($row['message'])) . '</td>';
        // $html .= '</tr>';
         $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['id']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['location']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['imei_no']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['device_issue']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['issue']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['service_location']) . '</td>';
        $html .= '<td>' . nl2br(htmlspecialchars($row['message'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['booking_date']) . '</td>';
        $html .= '<td>' . $time->format('h:i A') . '</td>';
        $html .= '<td>' . htmlspecialchars($row['next_booking_date']) . '</td>';
        $html .= '<td>' . $nextTime->format('h:i A') . '</td>';
        $html .= '<td>' . htmlspecialchars($row['device']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['brand']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['created_at']) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="8" class="text-center">No bookings found.</td></tr>';
}

echo $html;
$conn->close();
?>
