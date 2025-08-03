<?php
ob_start(); // Start output buffering (prevents premature output)

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");
$selected_category_id = $_GET['category_id'] ?? null;

// Handle Save (Insert or Update)
if (isset($_POST['save_model'])) {
    $model = $_POST['model_name'];
    $cid = $_POST['model_category_id'];
    $mid = $_POST['model_id'];

    if ($mid) {
        $conn->query("UPDATE device_models SET model_name='$model', category_id=$cid WHERE id=$mid");
        $redirect_id = $mid;

    } else {
        $conn->query("INSERT INTO device_models(model_name, category_id) VALUES('$model', $cid)");
        $redirect_id = $conn->insert_id; // Get the last inserted ID

    }

    // Redirect after save to avoid form resubmission
header("Location: device_models.php?id=$redirect_id");
    exit;
}

// Handle Delete
if (isset($_GET['delete_model'])) {
    $id = $_GET['delete_model'];
    $conn->query("DELETE FROM device_models WHERE id=$id");
    header("Location: device_models.php?id=$id");
    exit;
}

// Handle Edit (Fetch data)
$edit_id = $_GET['id'] ?? null;
$edit_model = null;

if ($edit_id) {
    $result = $conn->query("SELECT * FROM device_models WHERE id=$edit_id");
    if ($result->num_rows > 0) {
        $edit_model = $result->fetch_assoc();
    }
}
?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?= $edit_model ? "Edit Model" : "Add Model" ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Model Name</label>
                            <input type="text" name="model_name" placeholder="Model (e.g. iPhone 15)"
                                class="form-control" required
                                value="<?= $edit_model['model_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="model_category_id" class="select form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                $res = $conn->query("SELECT * FROM device_categories");
    while ($cat = $res->fetch_assoc()) {
         $selected = ($edit_model && $cat['id'] == $edit_model['category_id']) ? 'selected' : '';
        echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
        // $selected = $cat['id'] == $edit_id ? 'selected' : '';
        // echo "<option value='{$cat['id']}' $selected>{$cat['category_name']} </option>";
    }
                                
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="model_id" value="<?= $edit_model['id'] ?? '' ?>">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" name="save_model" class="btn btn-primary">Save Model</button>
                        </div>
                    </div>
                </form>

                <hr>

              <div class="card">
            <div class="card-header">
                <h5 class="card-title">Models List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-table">
                    <table class="table" id="booking_list">
                        <thead class="thead-light">
                            <tr>
                            <th>ID</th>
                            <th>Model Name</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT m.id, m.model_name, c.category_name 
                                FROM device_models m
                                JOIN device_categories c ON m.category_id = c.id";
                        $res = $conn->query($sql);
                        while ($row = $res->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['model_name']}</td>
                                    <td>{$row['category_name']}</td>
                                    <td>
                                        <a href='device_models.php?id={$row['category_id']}' class='btn btn-sm btn-warning'>Edit</a>
 
                                    <a href='#' class='btn btn-sm btn-danger delete-btn' 
                                       data-id='{$row['category_id']}' 
                                       data-type='category'
                                       data-bs-toggle='modal' 
                                       data-bs-target='#deleteModal'>Delete</a>
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


<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <strong id="itemName"></strong>?</p>
        <input type="hidden" id="deleteId">
        <input type="hidden" id="deleteType">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDelete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {
    // Populate modal when Delete is clicked
    $('.delete-btn').click(function () {
        const id = $(this).data('id');
        const type = $(this).data('type');
        const name = $(this).data('name');

        $('#deleteId').val(id);
        $('#deleteType').val(type);
        $('#itemName').text(name);
    });

    // Confirm delete
    $('#confirmDelete').click(function () {
        const id = $('#deleteId').val();
        const type = $('#deleteType').val();

        $.post('device_models.php', {
            delete_id: id,
            delete_type: type
        }, function (response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                $('#deleteModal').modal('hide');
                location.reload(); // or remove row via JS
            } else {
                alert('Delete failed.');
            }
        });
    });
});
</script>