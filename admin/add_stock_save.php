<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/db_connection.php");

$product_id = (int)$_POST['product_id'];
$quantity = (int)$_POST['quantity'];
$conn->query("UPDATE products SET stock = stock + $quantity WHERE id = $product_id");
echo "✅ Stock added successfully. <a href='add_stock.php'>Go back</a>";
?>