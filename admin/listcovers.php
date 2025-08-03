<?php 
include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");
    
$result = $conn->query("SELECT * FROM cover_photos ORDER BY id DESC");
?>


<div class="page-wrapper cardhead">
    <div class="content container-fluid">

  

        <!-- Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title"><?= $editData ? "Edit" : "Add" ?> Cover Photo</h5>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <?php if ($editData): ?>
                        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                        <img src="<?= $editData['image'] ?>" width="150"><br>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Cover Image </label>
                        <input type="file" name="cover_image" class="form-control" <?= $editData ? "" : "required" ?>>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="tagline" value="<?= $editData['tagline'] ?? '' ?>" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success"><?= $editData ? "Update" : "Add" ?> Cover</button>
                    <?php if ($editData): ?>
                        <a href="cover_image.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Cover List -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Cover Photo List</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Tagline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $covers->fetch_assoc()): ?>
                            <tr>
                                <td><img src="<?= $row['image'] ?>" width="100"></td>
                                <td><?= htmlspecialchars($row['tagline']) ?></td>
                                <td>
                                    <a href="cover_image.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="ti ti-pencil"></i></a>
                                    <a href="#" 
   class="btn btn-danger btn-sm deleteBtn" 
   data-id="<?= $row['id'] ?>" 
   data-bs-toggle="modal" 
   data-bs-target="#deleteModal"><i class="ti ti-trash"></i></a>

                                    <!-- <a href="cover_image.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this cover?')"><i class="ti ti-trash"></i></a> -->
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

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
                    <h3>Remove Cover?</h3>
                    <p class="del-info">Are you sure you want to delete this cover photo?</p>
                    <div class="col-lg-12 text-center modal-btn">
                        <a href="#" class="btn btn-light" data-bs-dismiss="modal">Cancel</a>
                        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete it</a>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>


<!-- 
<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-header"> <div class="row">
                            <div class="col-md-5 col-sm-4">
                <h5 class="card-title">Cover Photos</h5> </div>
                            <div class="col-md-7 col-sm-8 text-end">
                            <a href="addcover.php" class="btn submit-button">Add New Cover</a>
                            </div>                        </div>
</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Tagline</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><img src="<?= $row['image'] ?>" width="100" /></td>
                                <td><?= htmlspecialchars($row['tagline']) ?></td>
                                <td>
                                    <a href="editcover.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="deletecover.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this cover?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->

<?php include("includes/footer.php"); ?>

<script>
$(document).ready(function () {
    let deleteId = null;

    // When delete button is clicked
    $('.deleteBtn').on('click', function () {
        deleteId = $(this).data('id');
    });

    // When confirm delete is clicked
    $('#confirmDeleteBtn').on('click', function () {
        if (deleteId) {
            window.location.href = "cover_image.php";
        }
    });
});
</script>
