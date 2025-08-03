<?php 
ob_start();
session_start();

include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  
?>
<?php
function generateNextJobId($conn) {
    // Get the last job ID from the database
    $result = $conn->query("SELECT job_id FROM device_services ORDER BY id DESC LIMIT 1");
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastId = $row['job_id'];
        
        // Extract the numeric part and increment
        if (preg_match('/ID(\d+)/', $lastId, $matches)) {
            $nextNum = (int)$matches[1] + 1;
            return 'ID' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
        }
    }
    
    return 'ID0001';
}
?>
<div class="page-wrapper cardhead">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
       
  <?php 
//    echo $_SESSION['message'];
   
   if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['alert_type'] ?? 'info' ?> alert-dismissible fade show" role="alert" id="autoDismissAlert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION['message']);
        unset($_SESSION['alert_type']);
        ?>
    <?php endif; ?>

                <form action="service_save.php" method="post" enctype="multipart/form-data" class="card">
            
                    <div class="card-header">
                         <div class="row">
              <div class="col-md-6"><h5 class="card-title">Device Service Form</h5></div>
              <div class="col-md-6 text-end">
                <div class="remaining_amount btn btn-success submit-button"> Remaining Amount : <strong id="remainingtxt">0</strong></div>
              </div>
            </div>
                        
                    </div>
                    <div class="card-body device_serviceblk">

                    <div class="row mb-3">
    <div class="col-md-4">
        <label>Job ID</label>
        <input type="text" name="job_id" id="job_id" class="form-control" value="<?php echo generateNextJobId($conn); ?>" readonly>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="job_idmanual" name="job_idmanual">
            <label class="form-check-label" for="job_idmanual">Manual Entry</label>
        </div>
    </div>
</div>

                    
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Phone No</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Category</label>
                                <select class="form-select form-control" name="category" id="categorySelect" required>
                                    <option value="">Select Category</option>
                                    <?php
                                    $res = $conn->query("SELECT * FROM device_categories");
                                    while ($row = $res->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Model</label>
                                <select class="form-select form-control" name="model" id="modelSelect" required>
    <option value="">Select Model</option>
  </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>IMEI No</label>
                                <input type="text" name="imei" class="form-control">
                            </div>
                             <div class="col-md-4">
                                <label> Estimantion Amount</label>
                                <input type="text" name="rupees_words" id="rupees_words"  class="form-control" required>
                            </div>
                           <div class="col-md-4">
                                <label> Battery Percentage</label>
                                <input type="text" name="battery_percentage" id="battery_percentage"  class="form-control" required>
                            </div>
                            
                        </div>

                        <h6 class="mobile_datatxt d-flex justify-content-between align-items-center">Mobile Information <div class="form-check form-switch pt-1">
            <input class="form-check-input" type="checkbox" role="switch" id="deadcheckbox" name="deadcheckbox">
            <label class="form-check-label" for="deadcheckbox">Dead</label>
        </div></h6>
                         <div class="row">
                            
                            <div class="col-md-4 mobile_txtblk">
                                <label>Home Button</label><br />
                                <div class="mobile_radioblk">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_button" value="Yes" required>
                                    <label class="form-check-label yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_button" value="No">
                                    <label class="form-check-label no">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_button" value="NA">
                                    <label class="form-check-label">NA</label>
                                </div>
                                </div>
                            </div>
                              <div class="col-md-4 mobile_txtblk">
                                <label>Home Button Sensor</label><br />
                                <div class="mobile_radioblk">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_button_senser" value="Yes" required>
                                    <label class="form-check-label yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_button_senser" value="No">
                                    <label class="form-check-label no">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_button_senser" value="NA">
                                    <label class="form-check-label">NA</label>
                                </div>
                                </div>
                            </div>
                              <div class="col-md-4 mobile_txtblk">
                                <label>Face Id</label><br />
                                <div class="mobile_radioblk">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="face_id" value="Yes" required>
                                    <label class="form-check-label yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="face_id" value="No">
                                    <label class="form-check-label no">No</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="face_id" value="NA">
                                    <label class="form-check-label">NA</label>
                                </div>
                                </div>
                            </div>

                     
    <?php
    $checkboxes = ["Power Button", "Volume Button's", "Ear Speaker", "Battery", "Sensor", "Front Camera", "Back Camera", "Wifi", "Mike", "Charging", "Loud Speaker", "Audi & Video Sound", "Torch", "Back Glass", "Scratch/Dent on Frame", "Body Bend", "Bottom Screw Available", "Ringer", "Screen Damage"];
    $i = 0;
    foreach ($checkboxes as $label) {
            $idSafe = preg_replace('/[^a-z0-9]/i', '_', $label); 

        echo '<div class="col-md-4 mobile_txtblk">
                <label class="form-label d-block">' . $label . '</label>
                <div class="mobile_radioblk">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="component[' . $label . ']" value="Yes" id="yes' . $i . '" required>
                    <label class="form-check-label yes" for="yes' . $i . '">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="component[' . $label . ']" value="No" id="No' . $i . '">
                    <label class="form-check-label no" for="No' . $i . '">No</label>
                </div>
                </div>
              </div>';
              $i++;
    }

    ?>
</div>


    
                    

                       

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Problem</label>
                                <textarea name="problem" class="form-control" rows="3" required></textarea>
                            </div>
                            
                           
                        </div>

    <input type="hidden" name="remaining" id="remaining" class="form-control" />

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                  <button type="button" class="btn cancel-button rounded-4 mx-2 button_styles">Cancel</button>
            <button type="submit" name="submit"  class="btn submit-button rounded-4 mx-2  button_styles">Add</button>
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


$(document).ready(function() {
    // Toggle manual job ID entry
    $('#job_idmanual').change(function() {
        if ($(this).is(':checked')) {
            $('#job_id').prop('readonly', false).focus();
        } else {
            $('#job_id').prop('readonly', true).val('<?php echo generateNextJobId($conn); ?>');
        }
    });
    
    $('#deadcheckbox').on('change', function () {
    if ($(this).is(':checked')) {
        $('input[type="radio"][value="No"]').each(function () {
            $(this).prop('checked', true);
        });
    } else {
        // Optional: uncheck all "No" radios (or reset form as needed)
        $('input[type="radio"]').prop('checked', false);
    }
});



    // Rest of your existing JavaScript...
});

     function calculateRemaining() {
            let total = parseFloat($('#rupees_words').val()) || 0;
            let advance = parseFloat($('#advance').val()) || 0;
            let remaining = total - advance;

            if (remaining < 0) {
                remaining = 0; // prevent negative
            }

            $('#remaining').val(remaining.toFixed(2));
            $('#remainingtxt').text(remaining.toFixed(2));
        }

        $('#rupees_words, #advance').on('input', calculateRemaining);

    $('#categorySelect').on('change', function () {
      const categoryId = $(this).val();
      $('#modelSelect').html('<option>Loading...</option>');

      if (categoryId) {
        $.ajax({
          url: '../get_models.php',
          type: 'POST',
          data: { category_id: categoryId },
          success: function (response) {
            $('#modelSelect').html(response);
          },
          error: function () {
            $('#modelSelect').html('<option>Error loading models</option>');
          }
        });
      } else {
        $('#modelSelect').html('<option value="">Select Model</option>');
      }
    });
     setTimeout(function () {
        $("#autoDismissAlert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);

</script>