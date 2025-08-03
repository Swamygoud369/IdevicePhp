<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");  ?>


<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sql = "SELECT * FROM bookings ORDER BY id DESC";
$result = $conn->query($sql);
?>
 <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Bookings</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-table">
                            <table class="table" id="booking_list">
                               <thead class="thead-light">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Location</th>
    <th>IMEI No</th>
    <th>Device Issue</th>
    <th>Issue</th>
    <th>Service Location</th>
    <th>Message</th>
    <th>Booking Date</th>
    <th>Booking Time</th>
    <th>Next Booking Date</th>
    <th>Next Booking Time</th>
    <th>Device</th>
    <th>Brand</th>
    <th>Created At</th>
  </tr>
</thead>

<tbody>
<?php if ($result && $result->num_rows > 0): ?>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['location']) ?></td>
      <td><?= htmlspecialchars($row['imei_no']) ?></td>
      <td><?= htmlspecialchars($row['device_issue']) ?></td>
      <td><?= htmlspecialchars($row['issue']) ?></td>
      <td><?= htmlspecialchars($row['service_location']) ?></td>
      <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
      <td><?= htmlspecialchars($row['booking_date']) ?></td>
      <td>
        <?php
          $time = new DateTime($row['booking_time']);
          echo $time->format('h:i A');
        ?>
      </td>
      <td><?= htmlspecialchars($row['next_booking_date']) ?></td>
      <td>
        <?php
          $nextTime = new DateTime($row['next_booking_time']);
          echo $nextTime->format('h:i A');
        ?>
      </td>
      <td><?= htmlspecialchars($row['device']) ?></td>
      <td><?= htmlspecialchars($row['brand']) ?></td>
      <td><?= htmlspecialchars($row['created_at']) ?></td>
    </tr>
  <?php endwhile; ?>
<?php else: ?>
  <tr><td colspan="17" class="text-center">No bookings found.</td></tr>
<?php endif; ?>
</tbody>


                              
                            </table>
                        </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

<?php include("includes/footer.php");  ?>


<script>
let oldHtml = '';

function loadBookings() {
    fetch('get_bookings.php')
    .then(res => res.text())
    .then(html => {
        const tbody = document.querySelector("#booking_list tbody");
        if (html !== oldHtml) {
            // If new data available, update table and show notification
            tbody.innerHTML = html;
            document.getElementById("notify").classList.remove('d-none');
            document.getElementById("notify").innerText = "New";
            oldHtml = html;

            // Hide notification after 3 seconds
            setTimeout(() => {
                document.getElementById("notify").classList.add('d-none');
            }, 3000);
        }
    });
}

// Initial fetch and interval polling
loadBookings();
setInterval(loadBookings, 5000);
</script>