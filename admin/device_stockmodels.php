<?php
ob_start();
session_start();

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

$selected_category_id = $_GET['category_id'] ?? null;

// Handle Save (Insert or Update)
if (isset($_POST['save_model'])) {
    $model_id = $_POST['smodel_id'];
    $color_id = $_POST['color_id'];
    $cid = $_POST['model_category_id'];
    $quantity = $_POST['model_quantity'];
    $price = $_POST['model_price'];
    $mid = $_POST['model_id'];
$purchased_price = $_POST['model_purchased_price'] ?? 0;
$party_id = $_POST['model_party_id'];
// $outstanding = $_POST['model_outstanding'] ?? 0;
$outstanding = $quantity * $purchased_price;

$model = '';
    if ($model_id) {
        $res = $conn->query("SELECT model_name FROM models WHERE model_id = $model_id");
        $model = $res->fetch_assoc()['model_name'] ?? '';
    }

    $color = '';
    if ($color_id) {
        $res = $conn->query("SELECT color_name FROM colors WHERE color_id = $color_id");
        $color = $res->fetch_assoc()['color_name'] ?? '';
    }

if ($mid) {
    // UPDATE
    $stmt = $conn->prepare("UPDATE device_stockmodels 
        SET model_name=?, color=?, quantity=?, price=?, purchased_price=?, party_id=?, outstanding_amount=? 
        WHERE id=?");
    $stmt->bind_param("ssiddisi", $model, $color, $quantity, $price, $purchased_price, $party_id, $outstanding, $mid);
} else {
    // INSERT - created_at handled automatically
    $stmt = $conn->prepare("INSERT INTO device_stockmodels 
        (model_name, color, quantity, price, purchased_price, category_id, party_id, outstanding_amount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiddisi", $model, $color, $quantity, $price, $purchased_price, $cid, $party_id, $outstanding);
}
$stmt->execute();
$stmt->close();


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
                                $res = $conn->query("SELECT * FROM device_categories");
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
  <label class="form-label">Party Name</label>
  <select name="model_party_id" class="select form-control" required>
    <option value="">Select Party</option>
    <?php
    $party_res = $conn->query("SELECT * FROM stock_parties ORDER BY party_name");
    while ($party = $party_res->fetch_assoc()) {
        $selected = (isset($edit_model['party_id']) && $edit_model['party_id'] == $party['id']) ? 'selected' : '';
        echo "<option value='{$party['id']}' $selected>{$party['party_name']}</option>";
    }
    ?>
  </select>
</div>

<!-- 
<div class="col-md-4 mb-3">
  <label class="form-label">Outstanding Amount</label>
  <input type="text" step="0.01" name="model_outstanding" class="form-control" value="<?= $edit_model['outstanding_amount'] ?? '0.00' ?>">
</div> -->

                        <!-- <div class="col-md-4 mb-3">
                            <label class="form-label">Model Name</label>
                            <input type="text" name="model_name" class="form-control" required value="<?= $edit_model['model_name'] ?? '' ?>">
                        </div> -->
                        <div class="col-md-4 mb-3">
  <label class="form-label w-100">Model Name <a href="#" class="float-end text-success fw-semibold" data-bs-toggle="modal" data-bs-target="#model_name">+ Add model Name</a></label>
  <select name="smodel_id" id="modelSelect" class="form-select" required>
    <option value="">-- Select Model --</option>
  </select>
</div>

                        <div class="col-md-4 mb-3">
  <label class="form-label w-100">Spares
    <a href="#" class="float-end text-success fw-semibold" data-bs-toggle="modal" data-bs-target="#colorModal">+ Add Spares</a>
  </label>
  <select name="color_id" id="colorSelect" class="form-select" required>
    <option value="">-- Select Spares --</option>
  </select>
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
                                        <th>Party</th>
<th>Date</th>
<th>Outstanding</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT m.id, m.model_name, m.color, m.price,m.purchased_price, m.quantity, m.created_at, m.outstanding_amount,
               c.category_name, p.party_name
                                            FROM device_stockmodels m 
                                            JOIN device_categories c ON m.category_id = c.id
        LEFT JOIN stock_parties p ON m.party_id = p.id";
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
                                                           <td>{$row['party_name']}</td>
            <td>{$row['created_at']}</td>
            <td>{$row['outstanding_amount']}</td>

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

<div class="modal fade" id="colorModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addColorForm">
          <div class="mb-3">
            <label class="form-label">Color Name</label>
            <input type="text" name="color_name" class="form-control" required>
          </div>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Color</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="model_name" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Model Name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Add Model Form -->
<form id="addModelForm">
  <div class=" mb-3">
    <label class="form-label">Category Name</label>
<select name="model_category_id" id="category_id" class="select2 form-control" required <?= $edit_model ? 'disabled' : '' ?>>
                                <option value="">Select Category</option>
                                <?php
                                $res = $conn->query("SELECT * FROM device_categories");
                                while ($cat = $res->fetch_assoc()) {
                                    $selected = ($selected_category_id == $cat['id']) ? 'selected' : '';
                                    echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
                                }
                                ?>
                            </select>  </div>
  <div class=" mb-3">
    <label class="form-label">Model Name</label>
    <input type="text" name="model_nametxt" id="model_nametxt" class="form-control" required >
  </div>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

  <button type="submit" class="btn btn-primary">Add Model</button>
</form>

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

function loadgetModelOptions(categoryId = '') {
  if (!categoryId) return;

  $.getJSON('get_models.php', { category_id: categoryId }, function (response) {
    const modelSelect = $('#modelSelect');
    modelSelect.html('<option value="">-- Select Model --</option>');
    response.data.forEach(model => {
      modelSelect.append(`<option value="${model.id}">${model.name}</option>`);
    });
  });
}

$(document).ready(function () {


$('select[name="model_category_id"]').on('change', function () {
  const selectedCategoryId = $(this).val();
  loadgetModelOptions(selectedCategoryId);
});



  // Load model options
  function loadModelOptions() {
    $.getJSON('get_models.php', function (response) {
      const modelSelect = $('#modelSelect');
      modelSelect.html('<option value="">-- Select Model --</option>');
      response.data.forEach(model => {
        modelSelect.append(`<option value="${model.id}">${model.name}</option>`);
      });
    });
  }

  // Load color options
  function loadColorOptions() {
    $.getJSON('get_colors.php', function (response) {
      const colorSelect = $('#colorSelect');
      colorSelect.html('<option value="">-- Select Color --</option>');
      response.data.forEach(color => {
        colorSelect.append(`<option value="${color.id}">${color.name}</option>`);
      });
    });
  }

  // Handle Add Model Submit
  $('#addModelForm').submit(function (e) {
    e.preventDefault();
    var modelName = $('input[name="model_nametxt"]').val();
    var categoryId = $('select[name="model_category_id"]').val(); 


    $.ajax({
      url: 'save_model.php',
      type: 'POST',
       dataType: 'json',
    data: {
        model_nametxt: $('#model_nametxt').val(),
        category_id: $('#category_id').val()
    },
    success: function(response) {
        if (response.status === 'success') {
    loadModelOptions();
    $('#model_name').modal('hide');
    setTimeout(() => {
      $('#modelSelect').val(response.model_id);
    }, 300);
    $('#addModelForm')[0].reset();
  } else {
     console.log("Error: " + response.message);
  }
    },
    error: function(xhr, status, error) {
        console.error("AJAX failed:", error);
    }
//      data: {
//       model_name: modelName,
//       model_category_id: categoryId
//     },
//       dataType: 'json',
//       success: function (response) {
//   console.log(response);
//   if (response.status === 'success') {
//     loadModelOptions();
//     $('#model_name').modal('hide');
//     setTimeout(() => {
//       $('#modelSelect').val(response.model_id);
//     }, 300);
//     $('#addModelForm')[0].reset();
//   } else {
//      console.log("Error: " + response.message);
//   }
// },
// error: function (xhr, status, error) {
//   console.error("AJAX error:", error);
//   console.log("AJAX failed: " + error);
// }

      // success: function (response) {
        
      //   if (response.status === 'success') {
      //     loadModelOptions();
      //     $('#model_name').modal('hide');
      //     setTimeout(() => {
      //       $('#modelSelect').val(response.model_id);
      //     }, 300);
      //     $('#addModelForm')[0].reset();
      //   }
      // }
    });
  });

  // Handle Add Color Submit
  $('#addColorForm').submit(function (e) {
    e.preventDefault();
    var colorName = $('input[name="color_name"]').val();

    $.ajax({
      url: 'add_color.php',
      type: 'GET',
      data: { color_name: colorName },
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          loadColorOptions();
          $('#colorModal').modal('hide');
          setTimeout(() => {
            $('#colorSelect').val(response.color_id);
          }, 300);
          $('#addColorForm')[0].reset();
        }
      }
    });
  });

  // Initial load
  loadModelOptions();
  loadColorOptions();
});



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
