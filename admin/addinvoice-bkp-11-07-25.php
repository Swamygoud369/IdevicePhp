<?php 

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>

<?php
// Fetch all items
$item_sql = "SELECT DISTINCT model_name FROM device_stockmodels WHERE quantity > 0";
$item_result = $conn->query($item_sql);

// Fetch all models
$model_sql = "SELECT DISTINCT id, model_name FROM device_stockmodels";
$model_result = $conn->query($model_sql);

// Fetch all colors
$color_sql = "SELECT DISTINCT color FROM device_stockmodels WHERE quantity > 0";
$color_result = $conn->query($color_sql);


$itemOptions = '';
while ($row = $item_result->fetch_assoc()) {
    $itemOptions .= '<option value="'.$row['model_name'].'">'.$row['model_name'].'</option>';
}

$colorOptions = '';
while ($row = $color_result->fetch_assoc()) {
    $colorOptions .= '<option value="'.$row['color'].'">'.$row['color'].'</option>';
}

?>

<div id="itemRowTemplate" class="d-none">
    <div class="row mb-4 itemRow">
        <div class="col-md-4">
            <label class="form-label">Item Name</label>
            <select name="itemname[]" class="form-select form-control" required>
                <option value="">Select Item</option>
                <?php
                // REPEAT the same PHP here (just once)
                $item_sql = "SELECT DISTINCT model_name FROM device_stockmodels";
                $item_result = $conn->query($item_sql);
                while ($row = $item_result->fetch_assoc()) {
                    echo '<option value="'.$row['model_name'].'">'.$row['model_name'].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Color</label>
            <select name="color[]" class="form-select form-control" required>
                <option value="">Select Color</option>
                <?php
                $color_sql = "SELECT DISTINCT color FROM device_stockmodels";
                $color_result = $conn->query($color_sql);
                while ($row = $color_result->fetch_assoc()) {
                    echo '<option value="'.$row['color'].'">'.$row['color'].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Quantity</label>
            <select name="quantity[]" class="form-select form-control" required>
                <option value="">Select Qty</option>
                <!-- <?php for ($i = 1; $i <= 6; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?> -->
            </select>
             <small class="text-muted stock-display"></small>
        </div>
        <div class="col-md-1 d-flex align-items-start mt-4 pt-2">
            <button type="button" class="btn btn-danger removeItemBtn">X</button>
        </div>
    </div>
</div>




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
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
        </div>
         <div class="col-md-4 mb-4">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
         <div class="col-md-4 mb-4">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        
        <div class="col-md-4 mb-4">
            <label class="form-label">Shipping</label>
            <input type="text" class="form-control" id="shipping" name="shipping" required>
        </div>     
            </div>
        <div id="itemContainer">


    <div class="row itemRow">
        <div class="col-md-4 mb-4">
        <label class="form-label">Item Name</label>
        <select name="itemname[]" class="select form-control" required>
            <option value="">Select Item</option>
                <?= $itemOptions ?>

        </select>
        </div>
    
        <div class="col-md-4 mb-4">
        <label class="form-label">Color</label>
        <select name="color[]" class="select form-control" required>
            <option value="">Select Color</option>
                <?= $colorOptions ?>

        </select>
        </div>
         <div class="col-md-3 mb-4">
            <label class="form-label">Quantity</label>
            <select class="select form-control" name="quantity[]" required>
    <option value="">Select Qty</option>
    <!-- <?php for ($i = 1; $i <= 6; $i++): ?>
        <option value="<?= $i ?>"><?= $i ?></option>
    <?php endfor; ?> -->
                                    <small class="text-muted stock-display"></small>

</select>

            <!-- <input type="number" class="form-control" id="quantity" name="quantity" required> -->
        </div>
        <div class="col-md-1 d-flex align-items-center">
  <div class="form-check mt-4">
    <input class="form-check-input" type="checkbox" name="is_gift[]" value="1"> Gift
  </div>
</div>

        
         
    </div>

</div>
            <a href="#"  class="btn btn-secondary mb-3" id="addItemBtn">+ Add More Items</a>

  <div class="mt-4 mb-4 d-flex">
       <div class="form-check form-check-inline ps-0">Payment Mode : </div><div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_mode" id="inlineRadio1" value="Card">
                                        <label class="form-check-label" for="inlineRadio1">Card</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="payment_mode" id="inlineRadio2" value="Cash">
                                        <label class="form-check-label" for="inlineRadio2">Cash</label>
                                    </div>

            </div>
    
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
    $conn->close();
    ?>

<?php include("includes/footer.php");  ?>

<script>
$(document).ready(function () {
   $(document).on('change', 'input[name="is_gift[]"]', function () {
    const isChecked = $(this).is(':checked');

    if (isChecked) {
        // Keep only this itemRow and remove all others
        const currentRow = $(this).closest('.itemRow');
        $('#itemContainer .itemRow').not(currentRow).remove();

        // Hide Add More button
        $('#addItemBtn').hide();
    } else {
        // Show Add More button again
        $('#addItemBtn').show();
    }
});
    $('#addItemBtn').click(function (e) {
        e.preventDefault();
        const itemRow = $('#itemRowTemplate').html();
        $('#itemContainer').append(itemRow);
    });

    // Remove item row
    $(document).on('click', '.removeItemBtn', function () {
        $(this).closest('.itemRow').remove();
        updateDisabledOptions();
    });

    // When item or color changes, check quantity and disable duplicates
    /*$(document).on('change', 'select[name="itemname[]"], select[name="color[]"]', function () {
        const row = $(this).closest('.itemRow');
        const item = row.find('select[name="itemname[]"]').val();
        const color = row.find('select[name="color[]"]').val();
        const qtySelect = row.find('select[name="quantity[]"]');

        // Reset and recheck
        qtySelect.html('<option value="">Select Qty</option>');

        if (item && color) {
            // Check if this combination already exists elsewhere
            let isDuplicate = false;
            $('.itemRow').each(function () {
                const currentRow = $(this);
                if (currentRow[0] !== row[0]) {
                    const otherItem = currentRow.find('select[name="itemname[]"]').val();
                    const otherColor = currentRow.find('select[name="color[]"]').val();
                    if (otherItem === item && otherColor === color) {
                        isDuplicate = true;
                    }
                }
            });

            if (isDuplicate) {
                alert('This item with the selected color is already added.');
                row.find('select[name="itemname[]"]').val('');
                row.find('select[name="color[]"]').val('');
                qtySelect.html('<option value="">Select Qty</option>');
                return;
            }

            // Fetch quantity from server
            $.ajax({
                url: 'get_quantity.php',
                type: 'POST',
                dataType: 'json',
                data: { model_name: item, color: color },
                success: function (res) {
                    let qty = parseInt(res.quantity);
                    if (qty <= 0) {
                        alert(`No stock for ${item} (${color})`);
                        row.find('select[name="itemname[]"]').val('');
                        row.find('select[name="color[]"]').val('');
                        qtySelect.html('<option value="">Select Qty</option>');
                        return;
                    }

                    let options = '<option value="">Select Qty</option>';
                    const maxQty = Math.min(qty, 6);
                    for (let i = 1; i <= maxQty; i++) {
                        options += `<option value="${i}">${i}</option>`;
                    }
                    qtySelect.html(options);
                }
            });
        }

        updateDisabledOptions();
    });*/

      $(document).on('change', 'select[name="itemname[]"], select[name="color[]"]', function () {
        const row = $(this).closest('.itemRow');
        const item = row.find('select[name="itemname[]"]').val();
        const color = row.find('select[name="color[]"]').val();
        const qtySelect = row.find('select[name="quantity[]"]');
        const stockDisplay = row.find('.stock-display');

        if (item && color) {
            // Check duplicates
            let isDuplicate = false;
            $('.itemRow').each(function () {
                if ($(this)[0] !== row[0]) {
                    const otherItem = $(this).find('select[name="itemname[]"]').val();
                    const otherColor = $(this).find('select[name="color[]"]').val();
                    if (item === otherItem && color === otherColor) {
                        isDuplicate = true;
                    }
                }
            });

            if (isDuplicate) {
                alert('This item with selected color is already added.');
                row.find('select[name="itemname[]"]').val('');
                row.find('select[name="color[]"]').val('');
                qtySelect.html('<option value="">Select Qty</option>');
                stockDisplay.text('');
                return;
            }

            // Get quantity from server
            $.ajax({
                url: 'get_quantity.php',
                method: 'POST',
                data: { model_name: item, color: color },
                dataType: 'json',
                success: function (res) {
                    const qty = parseInt(res.quantity);
                    if (qty <= 0) {
                        alert('No stock available for this item-color combination.');
                        row.find('select[name="itemname[]"]').val('');
                        row.find('select[name="color[]"]').val('');
                        qtySelect.html('<option value="">Select Qty</option>');
                        stockDisplay.text('');
                        return;
                    }

                    const maxQty = Math.min(qty, 6);
                    let options = '<option value="">Select Qty</option>';
                    for (let i = 1; i <= maxQty; i++) {
                        options += `<option value="${i}">${i}</option>`;
                    }
                    qtySelect.html(options);
                    stockDisplay.text(`Available: ${qty}`);
                }
            });
        } else {
            qtySelect.html('<option value="">Select Qty</option>');
            stockDisplay.text('');
        }
    });

    function updateDisabledOptions() {
        // Get all selected item+color combos
        const selectedCombos = new Set();

        $('.itemRow').each(function () {
            const item = $(this).find('select[name="itemname[]"]').val();
            const color = $(this).find('select[name="color[]"]').val();
            if (item && color) {
                selectedCombos.add(item + '__' + color);
            }
        });

        // Reset and disable duplicates
        $('.itemRow').each(function () {
            const currentRow = $(this);
            const itemDropdown = currentRow.find('select[name="itemname[]"]');
            const colorDropdown = currentRow.find('select[name="color[]"]');

            const currentItem = itemDropdown.val();
            const currentColor = colorDropdown.val();

            // Re-enable all options first
            $('select[name="itemname[]"] option, select[name="color[]"] option').prop('disabled', false);

            // Disable all used combos except in current row
            $('.itemRow').each(function () {
                const rowItem = $(this).find('select[name="itemname[]"]').val();
                const rowColor = $(this).find('select[name="color[]"]').val();
                const combo = rowItem + '__' + rowColor;

                if (
                    combo !== (currentItem + '__' + currentColor) &&
                    rowItem &&
                    rowColor
                ) {
                    $('select[name="itemname[]"]').each(function () {
                        if (!$(this).is(itemDropdown)) {
                            $(this).find(`option[value="${rowItem}"]`).prop('disabled', true);
                        }
                    });

                    $('select[name="color[]"]').each(function () {
                        if (!$(this).is(colorDropdown)) {
                            $(this).find(`option[value="${rowColor}"]`).prop('disabled', true);
                        }
                    });
                }
            });
        });
    }
});
</script>



<!-- 
<script>

 $(document).ready(function () {
    
    
    $('#addItemBtn').click(function (e) {
        e.preventDefault();
         const itemRow = $('#itemRowTemplate').html();
        $('#itemContainer').append(itemRow);
        
    });

    // Remove item row
    $(document).on('click', '.removeItemBtn', function () {
        $(this).closest('.itemRow').remove();
    });

     $(document).on('change', 'select[name="itemname[]"], select[name="color[]"]', function () {
    const row = $(this).closest('.itemRow');
    const item = row.find('select[name="itemname[]"]').val();
    const color = row.find('select[name="color[]"]').val();
    const qtySelect = row.find('select[name="quantity[]"]');

    if (item && color) {
        $.ajax({
            url: 'get_quantity.php',
            type: 'POST',
            dataType: 'json',
            data: { model_name: item, color: color },
            success: function (res) {
                let qty = parseInt(res.quantity);
                let options = '<option value="">Select Qty</option>';

                if (qty <= 0) {
                    alert(`Stock for "${item}" (${color}) is not available.`);
                    row.find('select[name="itemname[]"]').val('');
                    row.find('select[name="color[]"]').val('');
                    qtySelect.html('<option value="">Select Qty</option>');
                    return;
                }

                const maxQty = Math.min(qty, 6);
                for (let i = 1; i <= maxQty; i++) {
                    options += `<option value="${i}">${i}</option>`;
                }

                qtySelect.html(options);
            }
        });
    } else {
        qtySelect.html('<option value="">Select Qty</option>');
    }
});



    // Auto-dismiss alert messages (if used)
    setTimeout(function () {
        $("#autoDismissAlert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);
});


</script> -->