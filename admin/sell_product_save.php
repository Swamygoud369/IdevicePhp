<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/db_connection.php");

$product_id = (int)$_POST['product_id'];
$qty = (int)$_POST['quantity'];

$res = $conn->query("SELECT stock FROM products WHERE id = $product_id");
$row = $res->fetch_assoc();

if ($row['stock'] >= $qty) {
    $conn->query("UPDATE products SET stock = stock - $qty WHERE id = $product_id");
    echo "✅ Sale successful. <a href='sell_product.php'>Sell More</a>";
} else {
    echo "❌ Not enough stock. <a href='sell_product.php'>Try Again</a>";
}
?>