<?php
ob_start();
session_start();
include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php");
?>

<div class="page-wrapper cardhead">
  <div class="content container-fluid">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">Party-wise Stock Models</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive custom-table">
          <table class="table table-bordered" id="booking_list">
            <thead class="thead-light">
              <tr>
                <th>Party Name</th>
                <th>Model Name</th>
                <th>Quantity</th>
                <th>Outstanding Amount</th>
                <th>Payment Amount</th>
                <th>Remaining Amount</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT 
               p.id AS party_id,
            p.party_name,
            SUM(m.price * m.quantity) AS total_selling_amount,
            SUM(m.quantity) AS total_quantity,
            SUM(m.outstanding_amount) AS total_outstanding,
            GROUP_CONCAT(m.model_name SEPARATOR ', ') AS model_names,
            (SELECT IFNULL(SUM(pay_amount), 0) FROM payments WHERE party_id = p.id) AS total_paid
        FROM device_stockmodels m
        LEFT JOIN stock_parties p ON m.party_id = p.id
        GROUP BY p.id
        ORDER BY p.party_name";

$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
  $total_paid = $row['total_paid'];
$total_outstanding = $row['total_outstanding'];
$remaining_amount = $total_outstanding - $total_paid;
    echo "<tr>
            <td>" . htmlspecialchars($row['party_name']) . "</td>
            <td>" . htmlspecialchars($row['model_names']) . "</td>        
            <td>" . htmlspecialchars($row['total_quantity']) . "</td>
            <td>₹" . number_format($total_outstanding, 2) . "</td>
            <td>₹" . number_format($total_paid, 2) . "</td>
            <td>₹" . number_format($remaining_amount, 2) . "</td>
            <td>
<a href='#' 
   class='btn btn-sm btn-warning view-party-models me-1' 
   data-party='" . htmlspecialchars($row['party_name'], ENT_QUOTES) . "'>
   View
</a>
 <a href='#' class='btn btn-sm btn-info view-payments me-1' data-party-id='" . $row['party_id'] . "'>View Payments</a>";
 if ($remaining_amount > 0) {
    echo "<a href='#' class='btn btn-sm btn-danger delete-model' data-bs-toggle='modal' data-bs-target='#paymentModal' data-party-id='" . $row['party_id'] . "'>Pay</a>";
}
echo "</td>
          </tr>";
}
              // $sql = "SELECT 
              //             m.model_name,
              //             m.purchased_price,
              //             m.price,
              //             m.quantity,
              //             m.outstanding_amount,
              //             p.party_name
              //         FROM device_stockmodels m
              //         LEFT JOIN stock_parties p ON m.party_id = p.id
              //         ORDER BY p.party_name, m.model_name";
              // $res = $conn->query($sql);
              // while ($row = $res->fetch_assoc()) {
              //   echo "<tr>
              //           <td>" . htmlspecialchars($row['party_name']) . "</td>
              //           <td>" . htmlspecialchars($row['model_name']) . "</td>
              //           <td>₹" . number_format($row['purchased_price'], 2) . "</td>
              //           <td>₹" . number_format($row['price'], 2) . "</td>
              //           <td>" . htmlspecialchars($row['quantity']) . "</td>
              //           <td>₹" . number_format($row['outstanding_amount'], 2) . "</td>
              //         </tr>";
              // }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Payment View Modal -->
<div class="modal fade" id="paymentViewModal" tabindex="-1" aria-labelledby="paymentViewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="paymentHistoryBody">
        <!-- Payment data will be loaded here -->
      </div>
    </div>
  </div>
</div>



<!-- View Modal -->
<div class="modal fade" id="viewPartyModal" tabindex="-1" aria-labelledby="viewPartyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Party Models - <span id="partyNameTitle"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="partyModelList">
        <!-- Models will be loaded here via AJAX -->
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="payAmountForm">
        <div class="modal-header">
          <h5 class="modal-title">Make a Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="partyId" name="party_id">

          <div class="mb-3">
            <label for="payAmount" class="form-label">Pay Amount</label>
            <input type="number" step="0.01" class="form-control" id="payAmount" name="pay_amount" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Payment Mode</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="payment_mode" id="cash" value="Cash" required>
              <label class="form-check-label" for="cash">Cash</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="payment_mode" id="card" value="Card">
              <label class="form-check-label" for="card">Card</label>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php include("includes/footer.php"); ?>


<script>
  $(document).on('click', '.view-payments', function () {
  const partyId = $(this).data('party-id');
  $('#paymentHistoryBody').html('<p>Loading...</p>');

  $.post('ajax_payment_history.php', { party_id: partyId }, function (data) {
    $('#paymentHistoryBody').html(data);
    $('#paymentViewModal').modal('show');
  });
});

  $(document).on('click', '.view-party-models', function () {
    const partyName = $(this).data('party');
    $('#partyNameTitle').text(partyName);
    $('#partyModelList').html('<p>Loading...</p>');

    $.post('ajax_party_models.php', { party_name: partyName }, function (res) {
      $('#partyModelList').html(res);
    });

    $('#viewPartyModal').modal('show');
  });

 $('#paymentModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const partyId = button.data('party-id');
    $('#partyId').val(partyId);
  });

  // Submit form via Ajax
  $('#payAmountForm').submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'ajax_save_payment.php',
      data: $(this).serialize(),
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          $('#paymentModal').modal('hide');
          location.reload();
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("AJAX error.");
      }
    });
  });

</script>
