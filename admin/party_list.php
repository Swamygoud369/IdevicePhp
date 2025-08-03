<?php
session_start(); // THIS MUST BE AT THE VERY TOP

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

// Initialize error/success messages
$message = '';
$message_type = ''; // 'success' or 'danger'

if (isset($_POST['save_category'])) {
    $name = trim($_POST['party_name']);
    $id = $_POST['category_id'];

    if (empty($name)) {
        $message = "Category name cannot be empty";
        $message_type = "danger";
    } else {
        $check_sql = "SELECT id FROM stock_parties WHERE LOWER(party_name) = LOWER(?)" . ($id ? " AND id != ?" : "");
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
            if ($id) {
                $update = $conn->prepare("UPDATE stock_parties SET party_name=? WHERE id=?");
                $update->bind_param("si", $name, $id);
                if ($update->execute()) {
                    $message = "Category updated successfully";
                    $message_type = "success";
                }
            } else {
                $insert = $conn->prepare("INSERT INTO stock_parties(party_name) VALUES(?)");
                $insert->bind_param("s", $name);
                if ($insert->execute()) {
                    $message = "Category added successfully";
                    $message_type = "success";
                    $_POST['party_name'] = '';
                    $_POST['category_id'] = '';
                }
            }
        }
        $stmt->close();
    }
}

if (isset($_POST['delete_category'])) {
    $id = intval($_POST['delete_category']);
    
        $sql = "DELETE FROM stock_parties WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Category deleted successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error deleting category: " . $conn->error;
            $_SESSION['message_type'] = "danger";
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
                <h5 class="card-title">New Party</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Add New Party</label>
                            <input type="text" name="party_name" class="form-control" required
                                   value="<?= isset($_POST['party_name']) ? htmlspecialchars($_POST['party_name']) : '' ?>">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <button type="submit" name="save_category" class="btn btn-primary">Save Party Name</button>
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
                                <th>Party Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $conn->query("SELECT * FROM stock_parties ORDER BY party_name");
                            while ($row = $res->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>" . htmlspecialchars($row['party_name']) . "</td>
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
    $edit_res = $conn->query("SELECT * FROM stock_parties WHERE id = $id");
    if ($edit_res->num_rows > 0) {
        $edit_row = $edit_res->fetch_assoc();
        echo "<script>
                document.querySelector('[name=\"party_name\"]').value = " . json_encode($edit_row['party_name']) . ";
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
        const type = $(this).data('type');

        $('#deleteId').val(deleteCategoryId);
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