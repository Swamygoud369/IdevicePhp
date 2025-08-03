<?php 
session_start();

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $delSql = "DELETE FROM device_services WHERE id = $id";
    echo ($conn->query($delSql) === TRUE) ? "success" : "error";
    exit;
}
// $sql = "SELECT * FROM device_services ORDER BY id DESC";
$sql = "SELECT * FROM device_services WHERE status = 'Completed' ORDER BY id DESC";

$result = $conn->query($sql);


?>
 <div class="page-wrapper cardhead">
  <div class="content container-fluid">
    <div class="row">
      <div class="col-md-12">
          <?php if (isset($_SESSION['message'])): ?>
          <div class="alert alert-<?= $_SESSION['alert_type'] ?? 'info' ?> alert-dismissible fade show" role="alert" id="autoDismissAlert">
              <?= $_SESSION['message'] ?>
          </div>
          <?php
              unset($_SESSION['message']);
              unset($_SESSION['alert_type']);
          ?>
        <?php endif; ?>
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6"><h5 class="card-title">Pending Service Records</h5></div>
              <div class="col-md-6 text-end">
                <a href="addservice.php" class="btn btn-success"><i class="ti ti-square-rounded-plus"></i> Add Service</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive custom-table">
              <table class="table" id="booking_list">
                <thead class="thead-light">
                  <tr>
                    <th>Job ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Category</th>
                    <th>Model</th>
                    <th>Problem</th>
                     <th>Total Cost</th>
                    <th>Advance</th>
                     <th>Remaining</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                      <tr>
                        <td><a href="service_details.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['job_id']) ?></a></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['model']) ?></td>
                        <td><?= htmlspecialchars($row['problem']) ?></td>
                         <td><?= htmlspecialchars($row['rupees_in_words']) ?></td>
                        <td><?= htmlspecialchars($row['advance']) ?></td>
                         <td><?= htmlspecialchars($row['remaining']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td class="action_blk">
                          <a href="service_details.php?id=<?= $row['id'] ?>" class="view_service"><i class="ti ti-eye"></i></a>
                          <a href="#" class="delete_service" data-id="<?= $row['id'] ?>"><i class="ti ti-trash"></i></a>
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

<!-- Modal -->
<div class="modal fade custom-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 m-0 justify-content-end">
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
      </div>
      <div class="modal-body">
        <div class="success-message text-center">
          <div class="success-popup-icon"><i class="ti ti-trash-x"></i></div>
          <h3>Remove Service?</h3>
          <p class="del-info">Are you sure you want to remove the selected service record?</p>
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

  $(document).on('click', '.delete_service', function (e) {
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
          if (response.trim() === 'success') {
            $('a[data-id="' + deleteId + '"]').closest('tr').remove();
            $('#deleteModal').modal('hide');
          } else {
            alert("Failed to delete service.");
          }
        }
      });
    }
  });
   setTimeout(function () {
    $("#autoDismissAlert").fadeTo(500, 0).slideUp(500, function () {
      $(this).remove();
    });
  }, 4000);
</script>

<?php include("includes/footer.php"); ?>