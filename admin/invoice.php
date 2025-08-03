<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>

<?php 

$sql = "SELECT * FROM invoice ORDER BY invoice_id DESC";
$result = $conn->query($sql);

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
//     $id = intval($_POST['invoice_id']);

//     $sql = "DELETE FROM invoice WHERE invoice_id = $id";

//     if ($conn->query($sql) === TRUE) {
//         echo "success";
//     } else {
//         echo "error";
//     }

//     $conn->close();
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
    $id = intval($_POST['invoice_id']);

   $stmt = $conn->prepare("DELETE FROM invoice WHERE invoice_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
$stmt->close();
exit;

}






?>
 <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
 <div class="row">
                            <div class="col-md-5 col-sm-4">
                                <h5 class="card-title">Invoices</h5>
                            </div>
                            <div class="col-md-7 col-sm-8 text-end">
                                
                                    <a href="addinvoice.php" class="btn btn-success "><i class="ti ti-square-rounded-plus"></i> Add Invoice</a>
                            </div>
                        </div>                        </div>
                        <div class="card-body">
                      <div class="table-responsive custom-table">
                            <table class="table" id="booking_list">
                                <thead class="thead-light">
                                      <tr>
        <th>Company Name</th>
      <th>Name</th>
      <th>Address</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Description</th>
  
      <th>Shipping</th>
       <th>Total Price</th>

       <th>Action</th>
      </tr>
                                </thead>
                                <tbody>
                                  
                                
           <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <?php
                                            $invoice_id = $row['invoice_id'];
                                            $total_price = 0;

                                            $item_result = $conn->query("SELECT itemname, color, quantity, is_gift FROM invoice_items WHERE invoice_id = $invoice_id");
                                            if ($item_result && $item_result->num_rows > 0) {
                                                while ($item = $item_result->fetch_assoc()) {
                                                    $itemname = $conn->real_escape_string($item['itemname']);
                                                    $color = $conn->real_escape_string($item['color']);
                                                    $qty = (int)$item['quantity'];
                                                    $isGift = (int)$item['is_gift'];

                                                    $price_result = $conn->query("SELECT price FROM device_stockmodels WHERE model_name = '$itemname' AND color = '$color' LIMIT 1");
                                                    $price = 0;
                                                    if ($price_result && $price_result->num_rows > 0) {
                                                        $price = (float)$price_result->fetch_assoc()['price'];
                                                    }

                                                    $total_price += $qty * $price;
                                                }
                                            }
                                        ?>
        <tr>
          <td><a href="invoicedetails.php?id=<?= $row['invoice_id'] ?>"><?= htmlspecialchars($row['companyname']) ?></a></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phonenumber']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
       
          <td><?= htmlspecialchars($row['shipping']) ?></td>
                                            <td> <?php  if ($isGift > 0) {
        echo '<span class="badge bg-success">Gifted</span> ₹ 0';
    } else {
        echo '₹ ' . number_format($total_price, 2);
    } ?></td>
          <td class="action_blk">
  <a href="invoicedetails.php?id=<?= $row['invoice_id'] ?>" class="view_invoice"><i class="ti ti-eye"></i></a>
<a href="#" class="delete_invoice" data-id="<?= $row['invoice_id'] ?>"><i class="ti ti-trash"></i></a>
</td>
        </tr>
      <?php endwhile; ?>
      <?php endif; ?>

      
   
       
                                      
                                </tbody>
                            </table>
                        </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $conn->close();
    ?>

<?php include("includes/footer.php");  ?>


<div class="modal fade custom-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 m-0 justify-content-end">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="success-message text-center">
                        <div class="success-popup-icon">
                            <i class="ti ti-trash-x"></i>
                        </div>
                        <h3>Remove Invoice?</h3>
                        <p class="del-info">
                            Are you sure you want to remove
                            Invoice you selected.
                        </p>
                        <div class="col-lg-12 text-center modal-btn">
                            <a href="#" class="btn btn-light" data-bs-dismiss="modal">Cancel</a>
                            <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete it</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
</div>



<script>
   let deleteId = null;

  $(document).on('click', '.delete_invoice', function (e) {
    e.preventDefault();
    deleteId = $(this).data('id');
    $('#deleteModal').modal('show');
  });

  $('#confirmDeleteBtn').click(function () {
    if (deleteId) {
      $.ajax({
        url: window.location.href,
        type: 'POST',
        data: { invoice_id: deleteId },
        success: function (response) {
            console.log(response.trim());
            $('a[data-id="' + deleteId + '"]').closest('tr').remove();
          $('#deleteModal').modal('hide');
        }
      });
    }
  });
</script>
