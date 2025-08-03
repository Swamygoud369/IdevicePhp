<?php 
include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php"); 
?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add Cover Photo</h5>
            </div>
            <div class="card-body">
                <form action="cover_form_submit.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tagline</label>
                        <input type="text" name="tagline" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Add Cover</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
