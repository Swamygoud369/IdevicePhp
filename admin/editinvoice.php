<?php 
include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

$invoice_id = intval($_GET['id']);

// Fetch invoice data
$sql_invoice = "SELECT * FROM invoice WHERE invoice_id = ?";
$stmt_invoice = $conn->prepare($sql_invoice);
$stmt_invoice->bind_param("i", $invoice_id);
$stmt_invoice->execute();
$result_invoice = $stmt_invoice->get_result();
if ($result_invoice->num_rows == 0) {
    die("Invoice not found.");
}
$invoice = $result_invoice->fetch_assoc();

// Fetch item rows
$sql_items = "SELECT * FROM invoice_items WHERE invoice_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $invoice_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
$items = [];
while ($row = $result_items->fetch_assoc()) {
    $items[] = $row;
}

// Fetch item and color options
$item_sql = "SELECT DISTINCT model_name FROM device_stockmodels WHERE quantity > 0";
$item_result = $conn->query($item_sql);
$itemOptions = '';
while ($row = $item_result->fetch_assoc()) {
    $itemOptions .= '<option value="' . $row['model_name'] . '">' . $row['model_name'] . '</option>';
}

$color_sql = "SELECT DISTINCT color FROM device_stockmodels WHERE quantity > 0";
$color_result = $conn->query($color_sql);
$colorOptions = '';
while ($row = $color_result->fetch_assoc()) {
    $colorOptions .= '<option value="' . $row['color'] . '">' . $row['color'] . '</option>';
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyname = $_POST['companyname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $shipping = $_POST['shipping'];
    $payment_mode = $_POST['payment_mode'] ?? '';
    $subtotal = $_POST['subtotal'];
    $total = $_POST['total'];

    $conn->begin_transaction();

    $update_invoice = "UPDATE invoice SET companyname=?, name=?, email=?, phonenumber=?, address=?, description=?, shipping=?, payment_mode=?, subtotal=?, total=? WHERE id=?";
    $stmt = $conn->prepare($update_invoice);
    $stmt->bind_param("ssssssssddi", $companyname, $name, $email, $phonenumber, $address, $description, $shipping, $payment_mode, $subtotal, $total, $invoice_id);
    $stmt->execute();

    // Delete old items
    $conn->query("DELETE FROM invoice_items WHERE invoice_id = $invoice_id");

    // Insert new items
    $itemnames = $_POST['itemname'];
    $colors = $_POST['color'];
    $quantities = $_POST['quantity'];
    $is_gift = $_POST['is_gift'] ?? [];

    foreach ($itemnames as $index => $itemname) {
        $color = $colors[$index];
        $qty = $quantities[$index];
        $gift = isset($is_gift[$index]) ? 1 : 0;

        $insert_item = "INSERT INTO invoice_items (invoice_id, itemname, color, quantity, is_gift) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_item);
        $stmt->bind_param("isssi", $invoice_id, $itemname, $color, $qty, $gift);
        $stmt->execute();
    }

    $conn->commit();
    header("Location: invoicedetails.php?id=$invoice_id");
    exit;
}
?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Invoice</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" id="frmEditInvoice">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" name="companyname" class="form-control" value="<?= htmlspecialchars($invoice['companyname']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($invoice['name']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($invoice['email']) ?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phonenumber" class="form-control" value="<?= htmlspecialchars($invoice['phonenumber']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($invoice['address']) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($invoice['description']) ?>">
                                </div>
                            </div>

                            <div id="itemContainer">
                                <?php foreach ($items as $index => $item): ?>
                                <div class="row itemRow mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Item Name</label>
                                        <select name="itemname[]" class="form-select" required>
                                            <?= str_replace("value=\"{$item['itemname']}\"", "value=\"{$item['itemname']}\" selected", $itemOptions) ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Color</label>
                                        <select name="color[]" class="form-select" required>
                                            <?= str_replace("value=\"{$item['color']}\"", "value=\"{$item['color']}\" selected", $colorOptions) ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <select name="quantity[]" class="form-select" required>
                                            <option value="<?= $item['quantity'] ?>" selected><?= $item['quantity'] ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" name="is_gift[<?= $index ?>]" value="1" <?= $item['is_gift'] ? 'checked' : '' ?>> Gift
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="mb-4">
                                <label>Shipping</label>
                                <input type="text" class="form-control" name="shipping" value="<?= htmlspecialchars($invoice['shipping']) ?>">
                            </div>
                            <div class="mb-4">
                                <label>Payment Mode</label><br>
                                <input type="radio" name="payment_mode" value="Cash" <?= $invoice['payment_mode'] == 'Cash' ? 'checked' : '' ?>> Cash
                                <input type="radio" name="payment_mode" value="Card" <?= $invoice['payment_mode'] == 'Card' ? 'checked' : '' ?>> Card
                            </div>

                            <input type="hidden" name="subtotal" id="hidden_subtotal" value="<?= $invoice['subtotal'] ?>">
                            <input type="hidden" name="total" id="hidden_total" value="<?= $invoice['total'] ?>">

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Invoice</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $(document).on('change', 'select[name="itemname[]"], select[name="color[]"]', function () {
        const row = $(this).closest('.itemRow');
        const item = row.find('select[name="itemname[]"]').val();
        const color = row.find('select[name="color[]"]').val();
        const qtySelect = row.find('select[name="quantity[]"]');

        if (item && color) {
            $.ajax({
                url: 'get_quantity.php',
                method: 'POST',
                data: { model_name: item, color: color },
                dataType: 'json',
                success: function (res) {
                    let maxQty = Math.min(res.quantity, 6);
                    let options = '<option value="">Select Qty</option>';
                    for (let i = 1; i <= maxQty; i++) {
                        options += `<option value="${i}">${i}</option>`;
                    }
                    qtySelect.html(options);
                }
            });
        }
    });
});
</script>
