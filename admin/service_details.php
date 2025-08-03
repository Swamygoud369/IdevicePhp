<?php
include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM device_services WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
    echo "<div class='alert alert-danger'>No service found!</div>";
    exit;
}
?>

<div class="page-wrapper cardhead service_blk">
  <div class="content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow p-4 rounded-4 border-0">

         <div class="card-header p-0 mb-3 border-0">
            <div class="row">
              <div class="col-md-6"><h5 class="card-title">Service Details - <?= htmlspecialchars($data['job_id']) ?></h5></div>
              <div class="col-md-6 text-end" >
               
           <button onclick="window.print()" class="btn btn-outline-dark btn-sm me-2">
              <i class="ti ti-printer"></i> Print
            </button>
           
            <button id="downloadPdf" class="btn btn-outline-primary btn-sm me-2">
  <i class="ti ti-download"></i> Download PDF
</button>


                <a href="#" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#statusModal">Status</a>

                <a href="editservice.php?id=<?= $data['id'] ?>" class="btn btn-sm submit-button rounded-3"><i class="ti ti-edit"></i> Edit</a>
              </div>
            </div>
          </div>
      

          <div class="row g-4">
            <div class="col-md-6">
              <div class="border rounded-3 p-3 bg-white">
                <h6 class="text-primary fw-bold mb-3">👤 Customer Info</h6>
                <p><strong>Name:</strong> <?= htmlspecialchars($data['name']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($data['phone']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($data['address']) ?></p>
              </div>
            </div>

            <!-- Device Info -->
            <div class="col-md-6">
              <div class="border rounded-3 p-3 bg-white">
                <h6 class="text-success fw-bold mb-3">📱 Device Info</h6>
                <p><strong>Category:</strong> <?= htmlspecialchars($data['category']) ?></p>
                <p><strong>Model:</strong> <?= htmlspecialchars($data['model']) ?></p>
                <p><strong>IMEI No:</strong> <?= htmlspecialchars($data['imei_no']) ?></p>
                <p><strong>Screen Damage:</strong> <?= htmlspecialchars($data['screen_damage']) ?></p>
              </div>
            </div>

            <!-- Service Summary -->
            <div class="col-md-12">
              <div class="border rounded-3 p-3 bg-white">
                <h6 class="text-danger fw-bold mb-3">🧾 Service Summary</h6>
                <p><strong>Problem:</strong> <?= htmlspecialchars($data['problem']) ?></p>
                <div class="row">
                  <div class="col-md-4"><strong>Total Cost:</strong> ₹<?= htmlspecialchars($data['rupees_in_words']) ?></div>
                  <div class="col-md-4"><strong>Advance Paid:</strong> ₹<?= htmlspecialchars($data['advance']) ?></div>
                  <div class="col-md-4"><strong>Remaining:</strong> ₹<?= htmlspecialchars($data['remaining']) ?></div>
                </div>
              </div>
            </div>

            <!-- Component Info -->
            <div class="col-md-12">
              <div class="border rounded-3 p-3 bg-white">
                <h6 class="text-info fw-bold mb-3">⚙️ Component Status</h6>
                <div class="row">
                  <?php
                  $components = [
                      'home_button', 'home_button_sensor', 'power_button', 'volume_button', 'ear_speaker',
                      'face_id', 'battery', 'sensor', 'front_camera', 'back_camera',
                      'wifi', 'mike', 'charging', 'loud_speaker', 'audio_video_sound',
                      'torch', 'back_glass', 'scratch_or_dent', 'body_bend', 'bottom_screw'
                  ];
                  foreach ($components as $comp) {
                      echo "<div class='col-md-3 mb-2'><span class='badge bg-light text-dark border'><strong>" . ucwords(str_replace("_", " ", $comp)) . ":</strong> " . htmlspecialchars($data[$comp]) . "</span></div>";
                  }
                  ?>
                </div>
              </div>
            </div>

           
          </div>

        </div>
      </div>
    </div>
  </div>
</div>


<!-- Status Modal -->
<div class="modal fade custom-modal" id="statusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 m-0 justify-content-end">
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x"></i></button>
      </div>
      <div class="modal-body">
        <div class="success-message update_service">
          <h3 class="mb-3">Update Status</h3>


          <form action="update_status.php" method="POST" class="gap-2 mb-3">
  <input type="hidden" name="id" value="<?= $data['id'] ?>">
  <label>Status:</label>
  <select name="status" class="form-select form-control" required>
    <option value="Pending" <?= $data['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
    <option value="Completed" <?= $data['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
  </select>

  <div class="row mt-4">
    <div class="col-md-12 text-center">
      <button type="button" class="btn cancel-button rounded-4 mx-2 button_styles" data-bs-dismiss="modal">Cancel</button>
      <button type="submit" name="submit" class="btn submit-button rounded-4 mx-2 button_styles">Update</button>
    </div>
  </div>
</form>


          <!-- Actions -->
          

        </div>
      </div>
    </div>
  </div>
</div>

<div id="printArea" style="display: none;">
    <div class="page-wrapper cardhead service_blk">
  <div class="content container-fluid">
  <h4 class="text-center mb-4">Service Details</h4>

  <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <tr><th colspan="2" style="background-color: #f2f2f2;">Customer Info</th></tr>
    <tr><td><strong>Name</strong></td><td><?= htmlspecialchars($data['name']) ?></td></tr>
    <tr><td><strong>Phone</strong></td><td><?= htmlspecialchars($data['phone']) ?></td></tr>
    <tr><td><strong>Email</strong></td><td><?= htmlspecialchars($data['email']) ?></td></tr>
    <tr><td><strong>Address</strong></td><td><?= htmlspecialchars($data['address']) ?></td></tr>

    <tr><th colspan="2" style="background-color: #f2f2f2;">Device Info</th></tr>
    <tr><td><strong>Category</strong></td><td><?= htmlspecialchars($data['category']) ?></td></tr>
    <tr><td><strong>Model</strong></td><td><?= htmlspecialchars($data['model']) ?></td></tr>
    <tr><td><strong>IMEI No</strong></td><td><?= htmlspecialchars($data['imei_no']) ?></td></tr>

    <tr><th colspan="2" style="background-color: #f2f2f2;">Service Summary</th></tr>
    <tr><td><strong>Problem</strong></td><td><?= htmlspecialchars($data['problem']) ?></td></tr>
    <tr><td><strong>Total Cost</strong></td><td>₹<?= htmlspecialchars($data['rupees_in_words']) ?></td></tr>
    <tr><td><strong>Advance</strong></td><td>₹<?= htmlspecialchars($data['advance']) ?></td></tr>
    <tr><td><strong>Remaining</strong></td><td>₹<?= htmlspecialchars($data['remaining']) ?></td></tr>

    <tr><th colspan="2" style="background-color: #f2f2f2;">Component Status</th></tr>
    <?php
    foreach ($components as $comp) {
        echo "<tr><td><strong>" . ucwords(str_replace("_", " ", $comp)) . "</strong></td><td>" . htmlspecialchars($data[$comp]) . "</td></tr>";
    }
    ?>
  </table>
  </div>
  </div>
</div> 

<?php include("includes/footer.php"); ?>
<script>
  $(document).ready(function () {
    $('#downloadPdf').on('click', function () {
        $("#printArea").show();
      let element = document.getElementById('printArea');
      html2pdf()
        .from(element)
        .set({
          margin: 0.5,
          filename: 'service-details.pdf',
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        })
        .save();
    });

    $('#printPage').on('click', function () {
      window.print();
    });
  });
</script>
