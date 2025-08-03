<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/db_connection.php");
$result = $conn->query("SELECT * FROM products");

echo "<h2>Stock List</h2>";
echo "<table border='1'><tr><th>Product</th><th>Stock</th><th>Price</th><th>Status</th></tr>";
while ($row = $result->fetch_assoc()) {
    $status = ($row['stock'] <= $row['low_stock_threshold']) ? "<span style='color:red;'>Low</span>" : "OK";
    echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['stock']}</td>
        <td>₹{$row['price']}</td>
        <td>{$status}</td>
    </tr>";
}
echo "</table>";
?>