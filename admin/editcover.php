<?php
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM cover_photos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

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
<form action="cover_form_submit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
      <div class="mb-4">
            <img src="<?= $data['image'] ?>" width="150"><br>

                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tagline</label>
    <input type="text" name="tagline" value="<?= htmlspecialchars($data['tagline']) ?>" class="form-control"><br>
                    </div>
</form>

 </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
