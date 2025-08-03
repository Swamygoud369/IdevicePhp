<?php 
ob_start();
session_start();

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  
?>
<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
<h2>Sell Product</h2>
<form method="POST" action="sell_product_save.php">
    <label>Product:</label>
    <select name="product_id">
        <?php
        $result = $conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br>
    <label>Quantity:</label>
    <input type="number" name="quantity" required><br>
    <button type="submit">Sell</button>
</form>
</div>
</div>
</div>
</div>
<?php include("includes/footer.php"); ?>