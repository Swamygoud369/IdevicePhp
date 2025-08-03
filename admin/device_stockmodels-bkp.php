<?php
ob_start();
include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

$selected_category_id = $_GET['category_id'] ?? null;

// Handle Save (Insert or Update)
if (isset($_POST['save_model'])) {
    $model = $_POST['model_name'];
    $color = $_POST['model_color'];
    $cid = $_POST['model_category_id'];
    $quantity = $_POST['model_quantity'];
    $price = $_POST['model_price'];
    $mid = $_POST['model_id'];
$purchased_price = $_POST['model_purchased_price'] ?? 0;



    if ($mid) {
    $stmt = $conn->prepare("UPDATE device_stockmodels SET model_name=?, color=?, quantity=?, price=?, purchased_price=? WHERE id=?");
$stmt->bind_param("ssiddi", $model, $color, $quantity, $price, $purchased_price, $mid);
        $stmt->execute();
    } else {
    $stmt = $conn->prepare("INSERT INTO device_stockmodels (model_name, color, quantity, price, purchased_price, category_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiddi", $model, $color, $quantity, $price, $purchased_price, $cid);
        $stmt->execute();
    }

    header("Location: device_stockmodels.php?category_id=$cid");
    exit;
}

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_model'])) {
    $id = intval($_POST['delete_model']);
    $conn->query("DELETE FROM device_stockmodels WHERE id = $id");
    echo json_encode(['status' => 'success']);
    exit;
}

// Handle Edit
$edit_id = $_GET['id'] ?? null;
$edit_model = null;
if ($edit_id) {
    $result = $conn->query("SELECT * FROM device_stockmodels WHERE id=$edit_id");
    if ($result->num_rows > 0) {
        $edit_model = $result->fetch_assoc();
        $selected_category_id = $edit_model['category_id'];
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <select name="model_category_id" class="select form-control" required <?= $edit_model ? 'disabled' : '' ?>>
                                <option value="">Select Category</option>
                                <?php
                                $res = $conn->query("SELECT * FROM stock_categories");
                                while ($cat = $res->fetch_assoc()) {
                                    $selected = ($selected_category_id == $cat['id']) ? 'selected' : '';
                                    echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
                                }
                                ?>
                            </select>
                            <?php if ($edit_model): ?>
                                <input type="hidden" name="model_category_id" value="<?= $edit_model['category_id'] ?>">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Model Name</label>
                            <input type="text" name="model_name" class="form-control" required value="<?= $edit_model['model_name'] ?? '' ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" name="model_color" class="form-control" value="<?= $edit_model['color'] ?? '' ?>">
                        </div>
                          <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="text" name="model_quantity" class="form-control" value="<?= $edit_model['quantity'] ?? '' ?>">
                        </div>
                        <div class="col-md-4 mb-3">
  <label class="form-label">Purchased Price</label>
  <input type="text" name="model_purchased_price" class="form-control" value="<?= $edit_model['purchased_price'] ?? '' ?>">
</div>

                          <div class="col-md-4 mb-3">
                            <label class="form-label">Selling Price</label>
                            <input type="text" name="model_price" class="form-control" value="<?= $edit_model['price'] ?? '' ?>">
                        </div>
                        
                    </div>
                    <input type="hidden" name="model_id" value="<?= $edit_model['id'] ?? '' ?>">
                    <button type="submit" name="save_model" class="btn btn-primary">Save Model</button>
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
                                        <th>Color</th>
                                        <th>Category</th>
                                        <th>Purchased Price</th>
                                        <th>Selling Price</th>
                                        <th>Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT m.id, m.model_name, m.color, m.price,m.purchased_price, m.quantity, c.category_name 
                                            FROM device_stockmodels m 
                                            JOIN stock_categories c ON m.category_id = c.id";
                                    if ($selected_category_id) {
                                        $sql .= " WHERE m.category_id = $selected_category_id";
                                    }
                                    $res = $conn->query($sql);
                                    while ($row = $res->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['model_name']}</td>
                                                <td>{$row['color']}</td>
                                                <td>{$row['category_name']}</td>
                                                <td>{$row['purchased_price']}</td>

        <td>{$row['price']}</td>
                                                        <td>{$row['quantity']}</td>

                                                <td>
                                                    <a href='device_stockmodels.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                                    <a href='#' class='btn btn-sm btn-danger delete-model' data-id='{$row['id']}' data-name='" . htmlspecialchars($row['model_name'], ENT_QUOTES) . "'>Delete</a>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <strong id="modelNameText">this model</strong>?</p>
        <input type="hidden" id="deleteModelId">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
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
  });

  $('#confirmDeleteBtn').click(function () {
    if (deleteModelId) {
      $.post(window.location.href, { delete_model: deleteModelId }, function (res) {
        const response = JSON.parse(res);
        if (response.status === 'success') {
          $('a[data-id="' + deleteModelId + '"]').closest('tr').remove();
          $('#deleteModal').modal('hide');
        } else {
          alert('Delete failed.');
        }
      });
    }
  });
</script>
