<?php 
ob_start();
session_start();

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $stock = (int)$_POST['stock'];
    $price = (float)$_POST['price'];

    $stmt = $conn->prepare("INSERT INTO products (name, stock, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $name, $stock, $price);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Product added successfully!";
        $_SESSION['alert_type'] = "success";
        header("Location: create_product.php");
        exit;
    } else {
        $_SESSION['message'] = "❌ Failed: " . $stmt->error;
        $_SESSION['alert_type'] = "danger";
    }
}
?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4>Add New Product</h4>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['alert_type'] ?? 'info' ?>">
                        <?= $_SESSION['message'] ?>
                    </div>
                    <?php unset($_SESSION['message'], $_SESSION['alert_type']); ?>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label>Initial Stock</label>
                        <input type="number" name="stock" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>