<?php
ob_start();
session_start();
include("includes/header.php");
if (!isset($_POST['party_name'])) {
  echo "<p>Invalid request</p>";
  exit;
}

$party_name = $conn->real_escape_string($_POST['party_name']);

$sql = "SELECT m.model_name, m.color, m.quantity, m.purchased_price, m.price, m.outstanding_amount 
        FROM device_stockmodels m 
        LEFT JOIN stock_parties p ON m.party_id = p.id 
        WHERE p.party_name = '$party_name'";

$res = $conn->query($sql);

if ($res->num_rows > 0) {
  echo "<table class='table table-bordered'>
          <thead>
            <tr>
              <th>Model Name</th>
              <th>Color</th>
              <th>Quantity</th>
              <th>Purchased Price</th>
              <th>Outstanding</th>
            </tr>
          </thead>
          <tbody>";
  while ($row = $res->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['model_name']) . "</td>
            <td>" . htmlspecialchars($row['color']) . "</td>
            <td>" . $row['quantity'] . "</td>
            <td>₹" . number_format($row['purchased_price'], 2) . "</td>
            <td>₹" . number_format($row['outstanding_amount'], 2) . "</td>
          </tr>";
  }
  echo "</tbody></table>";
} else {
  echo "<p>No models found for this party.</p>";
}
?>
