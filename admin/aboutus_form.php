<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php"); ?>

<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5 col-sm-4">
                                <h5 class="card-title">About Us</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="crud_operations.php" method="POST" enctype="multipart/form-data">
                            <?php
                            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
                            $row = null;
                            if ($id) {
                                $result = $conn->query("SELECT * FROM about_us WHERE id = $id");
                                $row = $result->fetch_assoc();
                            }
                            ?>
                            <div class="form-group">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Current Image</label>
                                    <div class="col-md-10">
                                        <?php if ($row && $row['image_url']): ?>
                                            <img id="currentImage" src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Current Image" style="max-width: 200px; max-height: 200px;">
                                        <?php else: ?>
                                            <p>No image available</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Choose New Image</label>
                                    <div class="col-md-10">
                                        <input type="file" class="form-control-file" id="image" name="image">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Preview Image</label>
                                    <div class="col-md-10">
                                        <img id="preview" src="#" alt="Preview Image" style="max-width: 200px; max-height: 200px; display: none;">
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">About Us Text</label>
                                    <div class="col-md-10">
                                        <textarea id="summernote2" name="about_text" rows="4"><?php echo $row ? htmlspecialchars($row['about_text']) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $row ? $row['id'] : ''; ?>">
                            <button type="submit" class="btn btn-primary"><?php echo $row ? 'Update' : 'Submit'; ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- Include jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script>
$(document).ready(function() {
    $('#image').change(function() {
        var input = this;
        // var preview = $('#preview');
        var currentImage = $('#currentImage');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                currentImage.attr('src', e.target.result);
                currentImage.show();
            }
            reader.readAsDataURL(input.files[0]);
        } 
    });
});
</script>