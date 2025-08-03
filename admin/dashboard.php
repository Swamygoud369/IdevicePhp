<?php 

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}


include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>
 
    

 <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">DashBoard Page</h5>
                        </div>
                        <div class="card-body">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Close the database connection
    $conn->close();
    ?>

<?php include("includes/footer.php");  ?>