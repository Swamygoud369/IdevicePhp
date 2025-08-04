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
$spare_id = $_POST['spare_id'];
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
        $res = $conn->query("SELECT model_name FROM device_models WHERE id = $model_id");
        $model = $res->fetch_assoc()['model_name'] ?? '';
    }

    $spare = '';
if ($spare_id) {
    $res = $conn->query("SELECT spare_name FROM device_spares WHERE id = $spare_id");
    $spare = $res->fetch_assoc()['spare_name'] ?? '';
}
if ($mid) {
    // UPDATE
    $stmt = $conn->prepare("UPDATE device_stockmodels 
        SET model_name=?, spare_id=?, quantity=?, price=?, purchased_price=?, party_id=?, outstanding_amount=? 
        WHERE id=?");
    $stmt->bind_param("siiddiid", $model_id, $spare_id, $quantity, $price, $purchased_price, $party_id, $outstanding, $mid);
} else {
    // INSERT - created_at handled automatically
    $stmt = $conn->prepare("INSERT INTO device_stockmodels 
        (model_name, spare_id, quantity, price, purchased_price, category_id, party_id, outstanding_amount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiddiid", $model_id, $spare_id, $quantity, $price, $purchased_price, $cid, $party_id, $outstanding);
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
  <select name="model_party_id" class="select2 form-control" required>
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

                        <div class="col-md-4 mb-3">
  <label class="form-label w-100">Model Name <a href="#" class="float-end text-success fw-semibold" data-bs-toggle="modal" data-bs-target="#model_name">+ Add model Name</a></label>
  <select name="smodel_id" id="modelSelect" class="select2 form-select" required>
    <option value="">-- Select Model --</option>
  </select>
</div>

                        <div class="col-md-4 mb-3">
                          <label class="form-label w-100">Device Spares
  <a href="#" class="float-end text-success fw-semibold" data-bs-toggle="modal" data-bs-target="#spareModal">+ Add Spare</a>
</label>
<select name="spare_id" id="spareSelect" class="select2 form-select" required>
  <option value="">-- Select Spare --</option>
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
                                        <th>Spare</th>
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
                                    $sql = "SELECT 
            m.id, 
                dm.model_name AS model_name, 
            m.quantity, 
            m.price, 
            m.purchased_price, 
            m.created_at, 
            m.outstanding_amount,
            s.spare_name, 
            c.category_name, 
            p.party_name
        FROM device_stockmodels m
        LEFT JOIN device_models dm ON dm.id = m.model_name
        LEFT JOIN device_spares s ON m.spare_id = s.id
        JOIN device_categories c ON m.category_id = c.id
        LEFT JOIN stock_parties p ON m.party_id = p.id";

        //                             $sql = "SELECT m.id, m.model_name, m.spare_id, m.price,m.purchased_price, m.quantity, m.created_at, m.outstanding_amount,
        //        c.category_id, p.party_id
        //                                     FROM device_stockmodels m 
        //                                     JOIN device_categories c ON m.category_id = c.id
        // LEFT JOIN stock_parties p ON m.party_id = p.id";
                                    if ($selected_category_id) {
                                        $sql .= " WHERE m.category_id = $selected_category_id";
                                    }
                                    $res = $conn->query($sql);
                                    while ($row = $res->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$row['id']}</td>
                                                <td>{$row['model_name']}</td>
<td>{$row['spare_name']}</td>
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

<div class="modal fade" id="spareModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Device Spare</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addSpareForm">
           <div class=" mb-3">
    <label class="form-label">Category Name</label>
<select name="spare_category_id" id="spare_category_id" class="select2 form-control" required <?= $edit_model ? 'disabled' : '' ?>>
                                <option value="">Select Category</option>
                                <?php
                                $res = $conn->query("SELECT * FROM device_categories");
                                while ($cat = $res->fetch_assoc()) {
                                    $selected = ($selected_category_id == $cat['id']) ? 'selected' : '';
                                    echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
                                }
                                ?>
                            </select>  </div>
          <div class="mb-3">
            <label class="form-label">Spare Name</label>
            <input type="text" name="spare_nametxt" id="spare_nametxt" class="form-control" required>
          </div>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Spare</button>
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

<input type="hidden" name="model_id" value="<?= $edit_model['id'] ?? '' ?>">


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


// function loadSparesOptions(categoryId = '') {
//   if (!categoryId) return;

//   $.getJSON('get_spares.php', { category_id: categoryId }, function (response) {
//     const spareSelect = $('#spareSelect');
//     spareSelect.html('<option value="">-- Select Spare --</option>');
//     response.data.forEach(spare => {
//       spareSelect.append(`<option value="${spare.id}">${spare.name}</option>`);
//     });
//   });
// }


function loadSparesOptions(categoryId = '', selectedSpareId = '') {
  if (!categoryId) return;

  $.getJSON('get_spares.php', { category_id: categoryId }, function (response) {
    const spareSelect = $('#spareSelect');
    spareSelect.html('<option value="">-- Select Spare --</option>');
    response.data.forEach(spare => {
      const selected = (spare.id == selectedSpareId) ? 'selected' : '';
      spareSelect.append(`<option value="${spare.id}" ${selected}>${spare.name}</option>`);
    });
  });
}



function loadgetModelOptions(categoryId = '', selectedModelId = '') {
  if (!categoryId) return;

  $.getJSON('get_models.php', { category_id: categoryId }, function (response) {
    const modelSelect = $('#modelSelect');
    modelSelect.html('<option value="">-- Select Model --</option>');
    response.data.forEach(model => {
      const selected = (model.id == selectedModelId) ? 'selected' : '';
      modelSelect.append(`<option value="${model.id}" ${selected}>${model.name}</option>`);
    });
  });
}





// function loadgetModelOptions(categoryId = '') {
//   if (!categoryId) return;

//   $.getJSON('get_models.php', { category_id: categoryId }, function (response) {
//     const modelSelect = $('#modelSelect');
//     modelSelect.html('<option value="">-- Select Model --</option>');
//     response.data.forEach(model => {
//       modelSelect.append(`<option value="${model.id}">${model.name}</option>`);
//     });
//   });
// }


$(document).ready(function () {


const categoryId = "<?= $selected_category_id ?>";
  const selectedModelId = "<?= $edit_model['model_name'] ?? '' ?>";
  const selectedSpareId = "<?= $edit_model['spare_id'] ?? '' ?>";

  if (categoryId) {
    loadgetModelOptions(categoryId, selectedModelId);
    loadSparesOptions(categoryId, selectedSpareId);
  }

  


$('select[name="model_category_id"]').on('change', function () {
  const selectedCategoryId = $(this).val();
  loadgetModelOptions(selectedCategoryId);
    loadSparesOptions(selectedCategoryId);   // loads spares

});



  $('#addSpareForm').submit(function (e) {
  e.preventDefault();

  $.ajax({
    url: 'save_spare.php',
    type: 'POST',
    dataType: 'json',
    data: {
      spare_nametxt: $('#spare_nametxt').val(),
      category_id: $('#spare_category_id').val()
    },
    success: function (response) {
  if (response.status === 'success') {
    loadSparesOptions();
    $('#spareModal').modal('hide');
    setTimeout(() => {
      $('#spareSelect').val(response.model_id);
    }, 300);
    $('#addSpareForm')[0].reset();
  } else {
     console.log("Error: " + response.message);
  }
    
    },
    error: function (xhr, status, error) {
      console.error("AJAX failed:", error);
    }
  });
});


  
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
    loadgetModelOptions();
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

    });
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
      $('#deleteModal').modal('hide');
       window.location.reload(); 

       
       
      });
    }
  });
    });
</script>
