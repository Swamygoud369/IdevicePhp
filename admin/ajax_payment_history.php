<?php
include("includes/db_connection.php");

$party_id = $_POST['party_id'] ?? null;

if (!$party_id) {
    echo "<p>Invalid party selected.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT pay_amount, payment_mode, created_at FROM payments WHERE party_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $party_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No payments found.</p>";
} else {
    echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>₹" . number_format($row['pay_amount'], 2) . "</td>
                <td>" . htmlspecialchars($row['payment_mode']) . "</td>
                <td>" . date('d-m-Y h:i A', strtotime($row['created_at'])) . "</td>
              </tr>";
    }
    echo "</tbody></table>";
}

$stmt->close();
$conn->close();
?>
