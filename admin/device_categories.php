<?php
session_start(); // THIS MUST BE AT THE VERY TOP

include("includes/db_connection.php");

// Initialize error/success messages
$message = '';
$message_type = ''; // 'success' or 'danger'

if (isset($_POST['save_category'])) {
    $name = trim($_POST['category_name']);
    $id = $_POST['category_id'];
    
    // Validate input
    if (empty($name)) {
        $message = "Category name cannot be empty";
        $message_type = "danger";
    } else {
        // Check if category already exists (case-insensitive)
        $check_sql = "SELECT id FROM device_categories WHERE LOWER(category_name) = LOWER(?)" . ($id ? " AND id != ?" : "");
        $stmt = $conn->prepare($check_sql);
        
        if ($id) {
            $stmt->bind_param("si", $name, $id);
        } else {
            $stmt->bind_param("s", $name);
        }
        
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $message = "Category already exists!";
            $message_type = "danger";
        } else {
            // Proceed with insert/update
            if ($id) {
                $update = $conn->prepare("UPDATE device_categories SET category_name=? WHERE id=?");
                $update->bind_param("si", $name, $id);
                if ($update->execute()) {
                    $message = "Category updated successfully";
                    $message_type = "success";
                }
                header("Location: ".$_SERVER['PHP_SELF']);
            } else {
                $insert = $conn->prepare("INSERT INTO device_categories(category_name) VALUES(?)");
                $insert->bind_param("s", $name);
                if ($insert->execute()) {
                    $message = "Category added successfully";
                    $message_type = "success";
                    // Clear the form by resetting POST data
                    $_POST['category_name'] = '';
                    $_POST['category_id'] = '';
                    header("Location: ".$_SERVER['PHP_SELF']);
                }
            }
        }
        $stmt->close();
    }
}

// if (isset($_POST['delete_category'])) {
//     $id = intval($_POST['delete_category']);
//     $check_models = $conn->query("SELECT COUNT(*) FROM device_models WHERE category_id = $id");
//     $model_count = $check_models->fetch_row()[0];

//     if ($model_count > 0) {
//                 $_SESSION['message'] = "Cannot delete category - it has associated models!";
//         $_SESSION['message_type'] = "danger";

//         // $message = "Cannot delete category - it has associated models!";
//         // $message_type = "danger";
//     } else {
//         $sql = "DELETE FROM device_categories WHERE id = $id";
//     if ($conn->query($sql) === TRUE) {
//         $_SESSION['message'] = "Category deleted successfully";
//             $_SESSION['message_type'] = "success";
//     } else {
//         $_SESSION['message'] = "Error deleting category: " . $conn->error;
//             $_SESSION['message_type'] = "danger";
//     }


       
//     }
//     header("Location: ".$_SERVER['PHP_SELF']);
//     exit();    
// }

if (isset($_POST['delete_category'])) {
    $id = intval($_POST['delete_category']);
    $check_models = $conn->query("SELECT COUNT(*) FROM device_models WHERE category_id = $id");
    $model_count = $check_models->fetch_row()[0];

    if ($model_count > 0) {
        $_SESSION['message'] = "Cannot delete category - it has associated models!";
        $_SESSION['message_type'] = "danger";
    } else {
        $sql = "DELETE FROM device_categories WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Category deleted successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error deleting category: " . $conn->error;
            $_SESSION['message_type'] = "danger";
        }
    }
    
    // If this is an AJAX request, return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => ($model_count > 0 || $conn->error) ? 'error' : 'success',
            'message' => $_SESSION['message'],
            'message_type' => $_SESSION['message_type']
        ]);
        exit();
    } else {
        // Regular form submission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <?php if ($message): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Device Categories</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="category_name" placeholder="Category (e.g. iPhone)" 
                                   class="form-control" required
                                   value="<?= isset($_POST['category_name']) ? htmlspecialchars($_POST['category_name']) : '' ?>">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" name="save_category" class="btn btn-primary">Save Category</button>
                        </div>
                    </div>
                    <input type="hidden" name="category_id" value="<?= isset($_POST['category_id']) ? $_POST['category_id'] : '' ?>">
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Categories List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-table">
                    <table class="table" id="booking_list">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <a href='?edit_category={$row['id']}' class='btn btn-sm btn-primary'>Edit</a> -->
                            <?php
                            $res = $conn->query("SELECT * FROM device_categories ORDER BY category_name");
                            while ($row = $res->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>" . htmlspecialchars($row['category_name']) . "</td>
                                        <td>
                                            <a href='?edit_category={$row['id']}' class='btn btn-sm btn-primary'>Edit</a> 
 <a href='#' class='btn btn-sm btn-danger delete-btn' 
                                       data-id='{$row['id']}' 
                                       data-type='model'
                                       data-bs-toggle='modal' 
                                       data-bs-target='#deleteModal'>Delete</a>                                        </td>
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

<?php 
// Handle edit functionality
if (isset($_GET['edit_category'])) {
    $id = intval($_GET['edit_category']);
    $edit_res = $conn->query("SELECT * FROM device_categories WHERE id = $id");
    if ($edit_res->num_rows > 0) {
        $edit_row = $edit_res->fetch_assoc();
        echo "<script>
                document.querySelector('[name=\"category_name\"]').value = " . json_encode($edit_row['category_name']) . ";
                document.querySelector('[name=\"category_id\"]').value = {$edit_row['id']};
                document.querySelector('h5.card-title').textContent = 'Edit Category';
                window.scrollTo(0, 0);
              </script>";
    }
}

include("includes/footer.php"); 
?>


<script>
$(document).ready(function () {
    let deleteCategoryId = null;
    
    // Populate modal when Delete is clicked
    $('.delete-btn').click(function () {
        deleteCategoryId = $(this).data('id');
        const name = $(this).closest('tr').find('td:nth-child(2)').text().trim();
        $('#itemName').text(name);
    });

    $('#confirmDelete').click(function (e) {
        e.preventDefault();
        if (deleteCategoryId) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: { delete_category: deleteCategoryId },
                success: function (res) {
                    $('#deleteModal').modal('hide');
                    window.location.reload(); 
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                    $('#deleteModal').modal('hide');
                    $('.page-wrapper').prepend(
                        '<div class="alert alert-danger alert-dismissible fade show">' +
                        'Something went wrong while deleting.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>'
                    );
                }
            });
        }
    });
});
</script>

<!-- 
<script>
$(document).ready(function () {
      let deleteCategoryId = null;
    // Populate modal when Delete is clicked
    $('.delete-btn').click(function () {
            deleteCategoryId = $(this).data('id');

        const id = $(this).data('id');
        const type = $(this).data('type');
        const name = $(this).data('name');

        $('#deleteId').val(id);
        $('#deleteType').val(type);
        $('#itemName').text(name);
    });

    
$('#confirmDelete').click(function (e) {
    e.preventDefault();
    if (deleteCategoryId) {
      $.ajax({
  url: window.location.href,
  type: 'POST',
  data: { delete_category: deleteCategoryId },
  success: function (res) {
      $('#deleteModal').modal('hide');
      //alert(res);
      window.location.reload();
  },
  error: function (xhr, status, error) {
    console.error('AJAX error:', error);
 $('#deleteModal').modal('hide');
$('.page-wrapper').prepend(
    '<div class="alert alert-danger alert-dismissible fade show">' +
    'Something went wrong while deleting.' +
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
    '</div>'
);  }
});


    // $('#confirmDelete').click(function () {
    //     const id = $('#deleteId').val();
    //     const type = $('#deleteType').val();

    //     $.post('device_models.php', {
    //         delete_id: id,
    //         delete_type: type
    //     }, function (response) {
    //         const res = JSON.parse(response);
    //         if (res.status === 'success') {
    //             $('#deleteModal').modal('hide');
    //             location.reload(); 
    //         } else {
    //             alert('Delete failed.');
    //         }
    //     });
}
    });
});
</script> -->