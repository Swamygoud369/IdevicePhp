<?php 

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>

<?php
// Fetch all items
$item_sql = "SELECT DISTINCT model_name FROM device_stockmodels";
$item_result = $conn->query($item_sql);

// Fetch all models
$model_sql = "SELECT DISTINCT id, model_name FROM device_stockmodels";
$model_result = $conn->query($model_sql);

// Fetch all colors
$color_sql = "SELECT DISTINCT color FROM device_stockmodels";
$color_result = $conn->query($color_sql);
?>


 <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                                <h5 class="card-title">Add Invoice</h5>
                                                </div>
                        <div class="card-body">
                   <form action="invoice_form.php" class="form-horizontal" enctype="multipart/form-data" id="frmCompanyData" method="post">
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Company Name</label>
            <input class="form-control" id="companyname" name="companyname" type="text" required>
        </div>
       <div class="col-md-4">
            <label class="form-label">Contact Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">E-Mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
       
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
        </div>
         <div class="col-md-4">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
         <div class="col-md-4">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
         <!-- <div class="col-md-4">
            <label class="form-label">Item Name</label>
            <input type="text" class="form-control" id="itemname" name="itemname" required>
        </div> -->
            </div>
      <!-- <div class="row mb-4">
       
        
         <div class="col-md-4">
            <label class="form-label">Service Charge</label>
            <input type="text" class="form-control" id="servicecharge" name="servicecharge" required>
        </div>
            </div> -->
             <!-- <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Discount</label>
            <input type="text" class="form-control" id="discount" name="discount" required>
        </div>
         <div class="col-md-4">
            <label class="form-label">Tax</label>
            <input type="number" class="form-control" id="tax" name="tax" required>
        </div>
         <div class="col-md-4">
            <label class="form-label">Tax Rate</label>
            <input type="text" class="form-control" id="taxrate" name="taxrate" required>
        </div>
        
            </div> -->

    <div class="row">
        <div class="col-md-4 mb-4">
        <label class="form-label">Item Name</label>
        <select name="itemname[]" class="select form-control" required>
            <option value="">Select Item</option>
            <?php while($row = $item_result->fetch_assoc()): ?>
            <option value="<?= $row['model_name'] ?>"><?= $row['model_name'] ?></option>
            <?php endwhile; ?>
        </select>
        </div>
    
        <div class="col-md-4 mb-4">
        <label class="form-label">Color</label>
        <select name="color[]" class="select form-control" required>
            <option value="">Select Color</option>
            <?php while($row = $color_result->fetch_assoc()): ?>
            <option value="<?= $row['color'] ?>"><?= $row['color'] ?></option>
            <?php endwhile; ?>
        </select>
        </div>
         <div class="col-md-4 mb-4">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
       
        <div class="col-md-4 mb-4">
            <label class="form-label">Shipping</label>
            <input type="text" class="form-control" id="shipping" name="shipping" required>
        </div>       
    </div>
  
  <div class="row mb-4">
       
        
            </div>
    
    <!-- <div class="row mb-4">
        <div class="col-md-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="termscheckbox" name="termscheckbox">
                <label class="form-check-label" for="termscheckbox">Accept Terms & Conditions</label>
            </div>
        </div>
    </div>
     -->
    <div class="row mb-4">
        <div class="col-md-12">
            <input type="hidden" id="hidden_subtotal" name="subtotal">
<input type="hidden" id="hidden_total" name="total">

            <button type="button" class="btn cancel-button rounded-4 mx-2 button_styles">Cancel</button>
            <button type="submit" name="submit"  class="btn submit-button rounded-4 mx-2  button_styles">Add</button>
           
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