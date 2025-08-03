<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>

<?php 

$sql = "SELECT * FROM quotation ORDER BY id DESC";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM quotation WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }

    $conn->close();
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
                                <h5 class="card-title">quotations</h5>
                            </div>
                            <div class="col-md-7 col-sm-8 text-end">
                                
                                    <a href="addquotation.php" class="btn btn-success "><i class="ti ti-square-rounded-plus"></i> Add quotation</a>
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
      <th>Item</th>
      <th>Description</th>
      <th>Qty</th>
      <th>Service Charge</th>
      <th>Discount</th>
      <th>Tax</th>
      <th>Tax Rate</th>
      <th>Shipping</th>
      <th>Terms</th>
       <th>Action</th>
      </tr>
                                </thead>
                                <tbody>
                                  
                                
          <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><a href="quotationdetails.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['companyname']) ?></a></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phonenumber']) ?></td>
          <td><?= htmlspecialchars($row['itemname']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
          <td><?= htmlspecialchars($row['quantity']) ?></td>
          <td><?= htmlspecialchars($row['servicecharge']) ?></td>
          <td><?= htmlspecialchars($row['discount']) ?></td>
          <td><?= htmlspecialchars($row['tax']) ?></td>
          <td><?= htmlspecialchars($row['taxrate']) ?></td>
          <td><?= htmlspecialchars($row['shipping']) ?></td>
          <td><?= $row['termscheckbox'] == 1 ? 'Agreed' : 'Not Agreed' ?></td>
          <td class="action_blk">
  <a href="quotationdetails.php?id=<?= $row['id'] ?>" class="view_quotation"><i class="ti ti-eye"></i></a>
<a href="#" class="delete_quotation" data-id="<?= $row['id'] ?>"><i class="ti ti-trash"></i></a>
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
    // Close the database connection
    $conn->close();
    ?>

<?php include("includes/footer.php");  ?>


<!-- Delete Confirmation Modal -->
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
                        <h3>Remove quotation?</h3>
                        <p class="del-info">
                            Are you sure you want to remove
                            quotation you selected.
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

  $(document).on('click', '.delete_quotation', function (e) {
    e.preventDefault();
    deleteId = $(this).data('id');
    $('#deleteModal').modal('show');
  });

  $('#confirmDeleteBtn').click(function () {
    if (deleteId) {
      $.ajax({
        url: window.location.href,
        type: 'POST',
        data: { id: deleteId },
        success: function (response) {
            console.log(response.trim());
            $('a[data-id="' + deleteId + '"]').closest('tr').remove();
          $('#deleteModal').modal('hide');
        }
      });
    }
  });
</script>
