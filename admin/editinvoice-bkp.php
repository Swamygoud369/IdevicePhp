<?php 
ob_start(); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("includes/header.php");


$invoice_id = intval($_GET['id']);
$sql = "SELECT * FROM invoice WHERE invoice_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Invoice not found.";
    exit;
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $companyname = $_POST['companyname'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $itemname = $_POST['itemname'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $servicecharge = $_POST['servicecharge'];
    $discount = $_POST['discount'];
    $tax = $_POST['tax'];
    $taxrate = $_POST['taxrate'];
    $shipping = $_POST['shipping'];
    $subtotal = $_POST['subtotal'];
    $total = $_POST['total'];
    $termscheckbox = isset($_POST['termscheckbox']) ? 1 : 0;

    $sql = "UPDATE invoice SET 
        companyname = ?, name = ?, address = ?, email = ?, phonenumber = ?,
        itemname = ?, description = ?, quantity = ?, servicecharge = ?, discount = ?,
        tax = ?, taxrate = ?, shipping = ?, subtotal = ?, total = ?, termscheckbox = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssdssssddii",
        $companyname, $name, $address, $email, $phonenumber,
        $itemname, $description, $quantity, $servicecharge, $discount,
        $tax, $taxrate, $shipping, $subtotal, $total, $termscheckbox, $id
    );

    if ($stmt->execute()) {
        header("Location: invoicedetails.php?id=$invoice_id");
        exit;
    } else {
        echo "Update failed: " . $stmt->error;
    }
}


include("includes/top_header.php");
include("includes/sidebar.php"); 


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
                   <form action="editinvoice.php?id=<?= $invoice_id ?>" class="form-horizontal" enctype="multipart/form-data" id="frmCompanyData" method="post">
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Company Name</label>
            <input class="form-control" id="companyname" name="companyname" type="text" value="<?= htmlspecialchars($row['companyname']) ?>">
        </div>
       <div class="col-md-4">
            <label class="form-label">Contact Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($row['name']) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">E-Mail</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($row['email']) ?>">
        </div>
       
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?= htmlspecialchars($row['phonenumber']) ?>">
        </div>
         <div class="col-md-4">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($row['address']) ?>">
        </div>
         <div class="col-md-4">
            <label class="form-label">Item Name</label>
            <input type="text" class="form-control" id="itemname" name="itemname" value="<?= htmlspecialchars($row['itemname']) ?>">
        </div>
            </div>
      <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($row['description']) ?>">
        </div>
         <div class="col-md-4">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>">
        </div>
         <div class="col-md-4">
            <label class="form-label">Service Charge</label>
            <input type="text" class="form-control" id="servicecharge" name="servicecharge" value="<?= htmlspecialchars($row['servicecharge']) ?>">
        </div>
            </div>
             <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Discount</label>
            <input type="text" class="form-control" id="discount" name="discount" value="<?= htmlspecialchars($row['discount']) ?>">
        </div>
         <div class="col-md-4">
            <label class="form-label">Tax</label>
            <input type="number" class="form-control" id="tax" name="tax" value="<?= htmlspecialchars($row['tax']) ?>">
        </div>
         <div class="col-md-4">
            <label class="form-label">Tax Rate</label>
            <input type="text" class="form-control" id="taxrate" name="taxrate" value="<?= htmlspecialchars($row['taxrate']) ?>">
        </div>
        
            </div>
    
  <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Shipping</label>
            <input type="text" class="form-control" id="shipping" name="shipping" value="<?= htmlspecialchars($row['shipping']) ?>">
        </div>
        
        
            </div>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="form-check form-switch">
<input class="form-check-input" type="checkbox" role="switch" id="termscheckbox" name="termscheckbox" <?= $row['termscheckbox']==1 ? 'checked' : '' ?>>
                <label class="form-check-label" for="termscheckbox">Accept Terms & Conditions</label>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <input type="hidden" id="hidden_subtotal" name="subtotal" value="<?= $row['subtotal'] ?>">
<input type="hidden" id="hidden_total" name="total" value="<?= $row['total'] ?>">


            <button type="button" class="btn cancel-button rounded-4 mx-2 button_styles">Cancel</button>
            <button type="submit" name="submit"  class="btn submit-button rounded-4 mx-2  button_styles">Update Invoice</button>
           
        </div>
    </div>
</form>
                        </div>  </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Close the database connection
    $conn->close();
    ?>

<?php include("includes/footer.php");  ?>

<script>
    $(document).ready(function () {
    $('#quantity, #servicecharge, #discount, #tax, #shipping').on('keyup change', function () {
        percentage();
    });
});


function percentage() {
    var servicecharge = $("#servicecharge").val();
    var quantity = $("#quantity").val();
    var discount = $("#discount").val();
    var tax = $("#tax").val();
    var shipping = $("#shipping").val();

    var totalCost = parseFloat(quantity) * parseFloat(servicecharge);
    var discountAmount = totalCost * (parseFloat(discount) / 100);
    var subtotal = totalCost - discountAmount;
    var total = subtotal + parseFloat(tax) + parseFloat(shipping);

    $("#subtotal").text(subtotal.toFixed(2));
    $("#total").text(total.toFixed(2));

    // Set hidden fields for server submission
    $("#hidden_subtotal").val(subtotal.toFixed(2));
    $("#hidden_total").val(total.toFixed(2));
}
</script>