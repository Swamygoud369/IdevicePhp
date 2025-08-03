    
<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>
 
 <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                           
                            <div class="row">
										<div class="col-md-5 col-sm-4">
                                        <h5 class="card-title">Service</h5>						
										</div>		
										<div class="col-md-7 col-sm-8 text-end">	
                                            <a href="javascript:void(0);" class="btn btn-primary add-popup btn-sm"  data-id="1" data-bs-toggle="modal" data-bs-target="#addService"><i class="ti ti-square-rounded-plus"></i>Add Service</a>
										</div>
									</div>
                        </div>
                        <div class="card-body">
                     
<div class="mt-5">
        <h2>About Us Entries</h2>
        <?php
        $result = $conn->query("SELECT * FROM about_us ORDER BY created_at DESC");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card mb-3">';
                echo '<img src="' . htmlspecialchars($row['image_url']) . '" class="card-img-top" alt="Image" style="height: 80px;width: 80px;">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . htmlspecialchars($row['about_text']) . '</p>';
                echo '<button type="button" class="btn btn-primary edit-btn" data-id="' . $row['id'] . '" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>';
                echo '<button type="button" class="btn btn-danger delete-btn" data-id="' . $row['id'] . '">Delete</button>';
                echo '</div>';
                echo '<div class="card-footer text-muted">';
                echo 'Created at: ' . htmlspecialchars($row['created_at']);
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No entries found.";
        }

        // Close the connection after all operations are complete
        $conn->close();
        ?>
    </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
<!-- Edit Modal -->
<!-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="crud_operations.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label for="editImage">Choose Image</label>
                        <input type="file" class="form-control-file" id="editImage" name="image">
                    </div>
                    <div class="form-group">
                        <label for="editAboutText">About Us Text</label>
                        <textarea class="form-control" id="editAboutText" name="about_text" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

    <!-- Edit Modal -->
    <div class="modal fade model-lg" id="addService" tabindex="-1" aria-labelledby="addModellabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModellabel">Add Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addform" action="crud_operations.php" method="POST" enctype="multipart/form-data">
                    <!-- <input type="hidden" id="editId" name="id"> -->
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Choose Image</label>
                        <input type="file" class="form-control" id="editImage" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="editAboutText" class="form-label">Title</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label for="editAboutText" class="form-label">Text</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="mb-3">
                        <label for="editAboutText" class="form-label">Price</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include("includes/footer.php");  ?>
