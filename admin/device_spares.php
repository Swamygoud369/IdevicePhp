<?php
ob_start();
include("includes/db_connection.php");
$selected_category_id = $_GET['category_id'] ?? null;

// Handle Save (Insert or Update)
if (isset($_POST['save_model'])) {
    $model = $_POST['spare_name'];
    $cid = $_POST['model_category_id'];
    $mid = $_POST['model_id'];

    if ($mid) {
        $conn->query("UPDATE device_spares SET spare_name='$model' WHERE id=$mid");
        $redirect_id = $mid;
    } else {
        $conn->query("INSERT INTO device_spares(spare_name, category_id) VALUES('$model', $cid)");
        $redirect_id = $conn->insert_id;
    }
 header("Location: ".$_SERVER['PHP_SELF']);
    // header("Location: device_spares.php?category_id=$cid");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_model'])) {
    $id = intval($_POST['delete_model']);
  $sql = "DELETE FROM device_spares WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
 header("Location: ".$_SERVER['PHP_SELF']);
    $conn->close();
    
}


// Handle Edit
$edit_id = $_GET['id'] ?? null;
$edit_model = null;
if ($edit_id) {
    $result = $conn->query("SELECT * FROM device_spares WHERE id=$edit_id");
    if ($result->num_rows > 0) {
        $edit_model = $result->fetch_assoc();
        $selected_category_id = $edit_model['category_id']; // force category from model
    }
}


include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?= $edit_model ? "Edit Spare" : "Add Spare" ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Spare Name</label>
                            <input type="text" name="spare_name" placeholder="Spare (e.g. iPhone 15)" class="form-control" required value="<?= $edit_model['spare_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="model_category_id" class="select2 form-control" required <?= $edit_model ? 'disabled' : '' ?>>
                                <option value="">Select Category</option>
                                <?php
                                $res = $conn->query("SELECT * FROM device_categories");
                                while ($cat = $res->fetch_assoc()) {
                                    $selected = ($selected_category_id == $cat['id']) ? 'selected' : '';
                                    echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
                                }
                                ?>
                            </select>
                            <?php if ($edit_model): ?>
                                <!-- Hidden input to preserve category ID -->
                                <input type="hidden" name="model_category_id" value="<?= $edit_model['category_id'] ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <input type="hidden" name="model_id" value="<?= $edit_model['id'] ?? '' ?>">

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" name="save_model" class="btn btn-primary">Save Spare</button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Spares List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive custom-table">
                            <table class="table" id="booking_list">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Spare Name</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT m.id, m.spare_name, m.category_id, c.category_name 
                                            FROM device_spares m
                                            JOIN device_categories c ON m.category_id = c.id";
                                    if ($selected_category_id) {
                                        $sql .= " WHERE m.category_id = $selected_category_id";
                                    }
                                    $res = $conn->query($sql);
                                    while ($row = $res->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['spare_name']}</td>
                                                <td>{$row['category_name']}</td>
                                                <td>
                                                    <a href='device_spares.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>

<a href='#' class='btn btn-sm btn-danger delete-model' data-id='{$row['id']}' data-name='" . htmlspecialchars($row['spare_name'], ENT_QUOTES) . "'>Delete</a>

                                                </td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Delete Model Modal -->
<div class="modal fade custom-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-end">
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="ti ti-x"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="success-message text-center">
          <div class="success-popup-icon">
            <i class="ti ti-trash-x"></i>
          </div>
          <h3>Delete Spare?</h3>
          <p class="del-info">
            Are you sure you want to delete <strong id="modelNameText">this Spare</strong>?
          </p>
          <div class="text-center modal-btn">
            <a href="#" class="btn btn-light" data-bs-dismiss="modal">Cancel</a>
            <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete it</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include("includes/footer.php"); ?>


<script>
  let deleteModelId = null;

  $(document).on('click', '.delete-model', function (e) {
    e.preventDefault();
    deleteModelId = $(this).data('id');
    const modelName = $(this).data('name');
    $('#modelNameText').text(modelName);
    $('#deleteModal').modal('show');

    // Store reference to the row for later removal
    $('#confirmDeleteBtn').data('row', $(this).closest('tr'));
  });

  $('#confirmDeleteBtn').click(function (e) {
    e.preventDefault();
    if (deleteModelId) {
      $.ajax({
  url: window.location.href,
  type: 'POST',
  data: { delete_model: deleteModelId },
  success: function (res) {

         $('#confirmDeleteBtn').data('row').remove();
      $('#deleteModal').modal('hide');
       window.location.reload(); 
  },
  error: function (xhr, status, error) {
    console.error('AJAX error:', error);
    alert('Something went wrong while deleting.');
  }
});
    
    }
  });
</script>
