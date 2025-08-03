<?php 
ob_start();
session_start();

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  

$service_id = $_GET['id'] ?? null;
if (!$service_id) {
    $_SESSION['message'] = "❌ Invalid request.";
    $_SESSION['alert_type'] = "danger";
    header("Location: service.php");
    exit;
}

$sql = "SELECT * FROM device_services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
$stmt->close();

if (!$service) {
    $_SESSION['message'] = "❌ Record not found.";
    $_SESSION['alert_type'] = "danger";
    header("Location: service.php");
    exit;
}
?>
<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

<?php if (isset($_SESSION['message'])): ?>
<div class="alert alert-<?= $_SESSION['alert_type'] ?? 'info' ?> alert-dismissible fade show" role="alert" id="autoDismissAlert">
    <?= $_SESSION['message'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['message'], $_SESSION['alert_type']); endif; ?>

<form action="service_update.php" method="post" enctype="multipart/form-data" class="card">
    <input type="hidden" name="id" value="<?= $service['id'] ?>">
    <div class="card-header">
        <h5 class="card-title">Edit Device Service</h5>
    </div>
    <div class="card-body device_serviceblk">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Job ID</label>
                <input type="text" name="job_id" class="form-control" readonly value="<?= $service['job_id'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="<?= $service['name'] ?>">
            </div>
            <div class="col-md-4">
                <label>Address</label>
                <input type="text" name="address" class="form-control" required value="<?= $service['address'] ?>">
            </div>
            <div class="col-md-4">
                <label>Phone No</label>
                <input type="text" name="phone" class="form-control" required value="<?= $service['phone'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $service['email'] ?>">
            </div>
            <div class="col-md-4">
                <label>Category</label>
                <select class="form-select form-control" name="category" id="categorySelect" required>
                    <option value="">Select Category</option>
                    <?php
                    $res = $conn->query("SELECT * FROM device_categories");
                    while ($row = $res->fetch_assoc()) {
                        $selected = $row['category_name'] == $service['category'] ? "selected" : "";
                        echo "<option value='{$row['id']}' $selected>{$row['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Model</label>
                <input type="text" name="model" class="form-control" value="<?= $service['model'] ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>IMEI No</label>
                <input type="text" name="imei" class="form-control" value="<?= $service['imei_no'] ?>">
            </div>
            <div class="col-md-4">
                <label>Money</label>
                <input type="text" name="rupees_words" id="rupees_words" class="form-control" value="<?= $service['rupees_in_words'] ?>" required>
            </div>
             <div class="col-md-4">
                <label> Battery Percentage</label>
                <input type="text" name="battery_percentage" id="battery_percentage"  class="form-control"  value="<?= $service['battery_percentage'] ?>">
            </div>
                            
           
        </div>

        <input type="hidden" name="remaining" id="remaining" value="<?= $service['remaining'] ?>">

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Screen Damage</label>
                <select name="screen_damage" class="form-select">
                    <option value="Yes" <?= $service['screen_damage'] == 'Yes' ? 'selected' : '' ?>>Yes</option>
                    <option value="No" <?= $service['screen_damage'] == 'No' ? 'selected' : '' ?>>No</option>
                    <option value="New" <?= $service['screen_damage'] == 'New' ? 'selected' : '' ?>>New</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Problem</label>
                <textarea name="problem" class="form-control" rows="3" required><?= $service['problem'] ?></textarea>
            </div>
        </div>

        <h6 class="mobile_datatxt">Mobile Information</h6>
        <div class="row mb-3">
            <?php
            $fields = [
                "Home Button", "Home Button Sensor", "Power Button", "Volume Button's", "Ear Speaker",
                "Face Id", "Battery", "Sensor", "Front Camera", "Back Camera", "Wifi", "Mike",
                "Charging", "Loud Speaker", "Audi & Video Sound", "Torch", "Back Glass",
                "Scratch/Dent on Frame", "Body Bend", "Bottom Screw Available", "Ringer"
            ];

            foreach ($fields as $i => $label) {
                $field_name = strtolower(str_replace([' ', '/', '-'], ['_', '_', '_'], $label));
                $db_value = strtolower($service[$field_name] ?? 'No');
                echo '<div class="col-md-4 mobile_txtblk">
                    <label class="form-label d-block">' . $label . '</label>
                    <div class="mobile_radioblk">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="component[' . $label . ']" value="Yes" ' . ($db_value === 'yes' ? 'checked' : '') . '>
                            <label class="form-check-label yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="component[' . $label . ']" value="No" ' . ($db_value === 'no' ? 'checked' : '') . '>
                            <label class="form-check-label no">No</label>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
<!-- <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>"> -->

        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <a href="service.php" class="btn btn-secondary mx-2">Cancel</a>
                <button type="submit" class="btn btn-primary mx-2">Update</button>
            </div>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>



<script>
     function calculateRemaining() {
        let total = parseFloat($('#rupees_words').val()) || 0;
        let advance = parseFloat($('#advance').val()) || 0;
        let remaining = total - advance;
        if (remaining < 0) remaining = 0;
        $('#remaining').val(remaining.toFixed(2));
    }

    $('#rupees_words, #advance').on('input', calculateRemaining);

    setTimeout(() => {
        $("#autoDismissAlert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);

</script>