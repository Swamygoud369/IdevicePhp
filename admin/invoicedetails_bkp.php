<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php"); 

// if (!isset($_GET['id'])) {
//     echo "Invalid invoice ID.";
//     exit;
// }

// $invoice_id = intval($_GET['id']);
// $sql = "SELECT * FROM invoice WHERE id = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $invoice_id);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows == 0) {
//     echo "Invoice not found.";
//     exit;
// }

// $row = $result->fetch_assoc();


if (!isset($_GET['id'])) { echo "Invalid invoice ID."; exit; }
$invoice_id = intval($_GET['id']);

// Fetch invoice
$stmt = $conn->prepare("SELECT * FROM invoice WHERE invoice_id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) { echo "Invoice not found."; exit; }
$row = $res->fetch_assoc();
$stmt->close();

// Fetch associated items
$itemStmt = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
$itemStmt->bind_param("i", $invoice_id);
$itemStmt->execute();
$items = $itemStmt->get_result();
$itemStmt->close();


?>
<!-- 
<div class="page-wrapper cardhead">
  <div class="content container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6"><h5 class="card-title mt-3"><?= htmlspecialchars($row['companyname']) ?></h5></div>
          <div class="col-md-6 text-end">
            <button onclick="printInvoice()" class="btn submit-button"><i class="ti ti-printer"></i> Print</button>
            <button onclick="downloadPDF()" class="btn btn-success"><i class="ti ti-download"></i> PDF</button>
            <a href="editinvoice.php?id=<?= $invoice_id ?>" class="btn cancel-button"><i class="ti ti-pencil"></i> Edit</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="dvContainer">
        
          <table style="width:100%; border:1px solid #ccc" cellpadding="0" cellspacing="0" class="mt-4">
            <thead style="background:#333;color:#fff">
              <tr>
                <th style="padding:8px;">Item</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Final Price</th>
                <th>Gift?</th>
              </tr>
            </thead>
            <tbody>
              <?php
            //   $grandTotal = 0;
            //   while($item = $items->fetch_assoc()):
            //     $iname = htmlspecialchars($item['itemname']);
            //     $clr = htmlspecialchars($item['color']);
            //     $qty = (int)$item['quantity'];
            //     $isGift = (int)$item['is_gift'];

            //     $price = 0;
            //     $pstmt = $conn->prepare("SELECT price FROM device_stockmodels WHERE model_name = ? AND color = ? LIMIT 1");
            //     $pstmt->bind_param("ss", $item['itemname'], $item['color']);
            //     $pstmt->execute();
            //     $pres = $pstmt->get_result();
            //     if ($r = $pres->fetch_assoc()) $price = (float)$r['price'];
            //     $pstmt->close();

            //     $final = $qty * $price;
            //     $grandTotal += $final;
              ?>
              <tr>
                <td style="padding:8px;"><?= $iname ?></td>
                <td style="padding:8px;"><?= htmlspecialchars($row['description']) ?></td>
                <td style="padding:8px; text-align:center;"><?= $qty ?></td>
                <td style="padding:8px; text-align:right;">₹<?= number_format($price,2) ?></td>
                <td style="padding:8px; text-align:right;">₹<?= number_format($final,2) ?></td>
                <td style="padding:8px; text-align:center;"><?= $isGift ? 'Yes' : 'No' ?></td>
              </tr>
             

              <tr>
                <td colspan="3"></td>
                <td style="text-align:right;font-weight:600;padding:8px;">Grand Total</td>
                <td colspan="2" style="text-align:right;font-weight:600;padding:8px;">₹<?= number_format($grandTotal,2) ?></td>
              </tr>
            </tbody>
          </table>

          <table style="width:100%; margin-top:20px" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td colspan="4" style="text-align:right;font-weight:600;padding:8px;">Sub total</td>
                <td style="padding:8px;">₹<?= number_format($row['subtotal'],2) ?></td>
              </tr>
              <tr>
                <td colspan="4" style="text-align:right;font-weight:600;padding:8px;">Tax</td>
                <td style="padding:8px;"><?= htmlspecialchars($row['tax']) ?></td>
              </tr>
              <tr>
                <td colspan="4" style="text-align:right;font-weight:600;padding:8px;">Shipping</td>
                <td style="padding:8px;">₹<?= htmlspecialchars($row['shipping']) ?></td>
              </tr>
              <tr>
                <td colspan="4" style="text-align:right;font-weight:600;padding:8px;">Total</td>
                <td style="font-weight:700;padding:8px;">₹<?= number_format($row['total'],2) ?></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div> -->



<!-- 
<div class="page-wrapper cardhead">
  <div class="content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-md-6">
                <h5 class="card-title mt-3"><?= htmlspecialchars($row['companyname']) ?></h5>
              </div>
              <div class="col-md-6 text-end">
                <button onclick="printInvoice()" class="btn submit-button mx-1"><i class="ti ti-printer"></i> Print</button>
                <button onclick="downloadPDF()" class="btn btn-success mx-1"><i class="ti ti-download"></i> PDF</button>
                <a href="editinvoice.php?id=<?= $invoice_id ?>" class="btn cancel-button mx-1"><i class="ti ti-pencil"></i> Edit</a>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div id="dvContainer">
              <div style="text-align:center;"><img src="images/logo.png" style="max-height: 60px;" /></div>
              <h2 style="text-align:center; font-size:38px;">Invoice</h2>

              <table style="width:100%; margin-bottom:25px;">
                <tr>
                  <td>
                    <strong>Invoice No:</strong> <?= htmlspecialchars($row['id']) ?><br>
                    <strong>Invoice Date:</strong> <?= date('d-m-Y', strtotime($row['created_at'])) ?><br><br>
                    <strong>Bill To:</strong><br>
                    <?= htmlspecialchars($row['name']) ?><br>
                    <?= htmlspecialchars($row['address']) ?><br>
                    <?= htmlspecialchars($row['email']) ?><br>
                    <?= htmlspecialchars($row['phonenumber']) ?>
                  </td>
                  <td style="text-align:right;">
                    <strong>From:</strong><br>
                    Idevice<br>
                    +91 96764 92221<br>
                    info@idevice.co.in<br>
                    Kompally, Hyderabad - 500055
                  </td>
                </tr>
              </table>

              <table style="width:100%; border:1px solid #ccc;" cellspacing="0">
                <thead style="background:#333; color:#fff;">
                  <tr>
                    <th style="padding:8px;">Item</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Service Charge</th>
                    <th>Discount %</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="padding:8px;"><?= htmlspecialchars($row['itemname']) ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['description']) ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['quantity']) ?></td>
                    <td style="padding:8px;">₹<?= htmlspecialchars($row['servicecharge']) ?></td>
                    <td style="padding:8px;"><?= htmlspecialchars($row['discount']) ?>%</td>
                    <td style="padding:8px;"><strong>₹<?= htmlspecialchars($row['total']) ?></strong></td>
                  </tr>
                </tbody>
              </table>

              <table style="width:100%; margin-top:20px;">
                <tr>
                  <td colspan="4"></td>
                  <td><strong>Subtotal:</strong></td>
                  <td>₹<?= htmlspecialchars($row['subtotal']) ?></td>
                </tr>
                <tr>
                  <td colspan="4"></td>
                  <td><strong>Tax (<?= htmlspecialchars($row['taxrate']) ?>%):</strong></td>
                  <td>₹<?= htmlspecialchars($row['tax']) ?></td>
                </tr>
                <tr>
                  <td colspan="4"></td>
                  <td><strong>Shipping:</strong></td>
                  <td>₹<?= htmlspecialchars($row['shipping']) ?></td>
                </tr>
              </table>

              <div style="margin-top:20px; font-size:13px;">
                <strong>Terms & Conditions:</strong><br>
                1. All Logic Board Services Carry 30-Day Warranty.<br>
                2. Physical / Liquid Damage Not Covered in Warranty.<br>
                3. 1% GST Under Composition Scheme (GST NO: 36AAFF18494K2Z0).<br>
                4. Cheques Accepted Subject to Clearance.
              </div>

              <div style="margin-top:20px; font-size:14px;">
                <strong>Payment Mode:</strong> Cash<br>
                <strong>Payment Due:</strong> <?= date('d-m-Y', strtotime($row['created_at'] . ' +7 days')) ?><br><br>
                <strong>Signature:</strong> B. Satish Kumar
              </div>

              <div style="border-top:1px solid #ccc; margin-top:20px; font-size:13px; text-align:center; padding-top:10px;">
                <strong>Head Office:</strong> Punjagutta, Hyderabad - 500082. Tel: 040-66 813 713<br>
                <strong>Branch:</strong> Merix Square, Suchitra. Tel: 040-27940789<br>
                Mobile: 89780 89781 | Mail: idevicehyd@gmail.com | Website: www.idevice.co.in
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                <h5 class="card-title mt-3"><?= htmlspecialchars($row['companyname']) ?></h5>
                                </div>
                                <div class="col-md-6">
                                    <div style="text-align: right;">
    <button onclick="printInvoice()" class="btn submit-button mx-1"><i class="ti ti-printer"></i> Print</button>
    <button onclick="downloadPDF()" class="btn btn-success mx-1"><i class="ti ti-download"></i> PDF</button>
    <a href="editinvoice.php?id=<?= $invoice_id ?>" class="btn cancel-button mx-1"><i class="ti ti-pencil"></i> Edit</a>
</div>

                                </div>
                                </div>
                                                </div>
                        <div class="card-body">
                     <div id="dvContainer" >
            <div style="display: inline-block; width: 100%; text-align:center;">
                <img src="images/logo.png" style="max-height: 60px;"/></div> 
            <h2 style="text-align: center; font-size: 38px;padding-bottom:5px;">Invoice</h2>
            <table style="font-size: 13px; width:100%;  margin-bottom: 25px; padding: 0;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td>
                            <table style="font-size: 13px; margin-bottom: 0px; padding: 0;" cellspacing="0" cellpadding="0">
                <tbody>
                     <tr>
                        <td style="padding-left: 10px;font-size: 16px;font-weight:600;padding-bottom: 3px;padding-top: 10px;">Invoice No: <?= htmlspecialchars($row['invoice_id']) ?></td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 16px; font-weight:600;padding-bottom: 15px;">Invoice Date: <?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;font-size: 17px;padding-bottom: 5px;"><strong>Bill To:</strong></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['name']) ?></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['address']) ?></td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['phonenumber']) ?></td>
                    </tr>
                  
                    </tbody>
                    </table>
                    </td>
                        <td style="float: right;text-align: right;"> 
                            <table style="font-size: 13px; margin-bottom: 25px; padding: 0;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;font-size: 17px;padding-bottom: 5px;"><strong>From :</strong></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;">Idevice </td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;">+91 96764 92221</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;">info@idevice.co.in</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;">Building, D.No 04-009/NR, Survey No 43,Merix Square Bajaj Electronics, <br/> Suchitra Rd, Kompally, Hyderabad - 500055</td>
                    </tr>
                  
                    </tbody>
                    </table></td>
                    </tr>
                    </tbody>
                    </table>
           
          
            <table style="font-size: 13px; width:100%; border:1px solid #cccccc" cellspacing="0" cellpadding="0">
                <thead>
                    <tr style="background-color: #333333; color: #ffffff; -webkit-print-color-adjust: exact; -moz-print-color-adjust: exact; print-color-adjust: exact;">
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px; width: 130px;">Model</th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Item</th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px; width: 90px;">Quantity</th>
                        <!-- <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Service Charge</th> -->
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Unit Price </th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
               $grandTotal = 0;
              // while($item = $items->fetch_assoc()):
              //   $iname = htmlspecialchars($item['itemname']);
              //   $clr = htmlspecialchars($item['color']);
              //   $qty = (int)$item['quantity'];
              //   $isGift = (int)$item['is_gift'];

              //   $price = 0;
              //   $pstmt = $conn->prepare("SELECT price FROM device_stockmodels WHERE model_name = ? AND color = ? LIMIT 1");
              //   $pstmt->bind_param("ss", $item['itemname'], $item['color']);
              //   $pstmt->execute();
              //   $pres = $pstmt->get_result();
              //   if ($r = $pres->fetch_assoc()) $price = (float)$r['price'];
              //   $pstmt->close();

              //   $final = $qty * $price;
              //   $grandTotal += $final;
              

while($item = $items->fetch_assoc()):
    $iname = htmlspecialchars($item['itemname']);
    $clr = htmlspecialchars($item['color']);
    $qty = (int)$item['quantity'];
    $isGift = (int)$item['is_gift'];

    $price = 0;
    $categoryName = '';

    $pstmt = $conn->prepare("SELECT price, category_id FROM device_stockmodels WHERE model_name = ? AND color = ? LIMIT 1");
    $pstmt->bind_param("ss", $item['itemname'], $item['color']);
    $pstmt->execute();
    $pres = $pstmt->get_result();
    if ($r = $pres->fetch_assoc()) {
        $price = (float)$r['price'];
        $category_id = (int)$r['category_id'];

        // Step 2: Get category name
        $catStmt = $conn->prepare("SELECT category_name FROM stock_categories WHERE id = ?");
        $catStmt->bind_param("i", $category_id);
        $catStmt->execute();
        $catRes = $catStmt->get_result();
        if ($c = $catRes->fetch_assoc()) {
            $categoryName = htmlspecialchars($c['category_name']);
        }
        $catStmt->close();
    }
    $pstmt->close();

    $final = $qty * $price;
    $grandTotal += $final;
?>

                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="description"><?= $categoryName ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; min-width:250px;" id="itemname"><?= $iname . ' (' . $clr . ' )' ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="quantity"><?= $qty ?></td>
                        <!-- <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="servicecharge"><?= htmlspecialchars($row['servicecharge']) ?></td> -->
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="discount"><?= number_format($price,2) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; padding-right: 10px; font-weight: 700;" id="total"><?= number_format($final,2) ?></td>
                    </tr>
                     <?php endwhile; ?>

                    <!-- <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr> -->
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; text-align: center;background-color: #333333; color: #ffffff; -webkit-print-color-adjust: exact; -moz-print-color-adjust: exact; print-color-adjust: exact;" colspan="2">Terms & Conditions Apply</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="2" id="mobile_terms">1 &nbsp; &nbsp;  All Logic Board Service Cary 30day Warranty</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Sub total</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; padding-right: 10px; font-weight: 700;" id="subtotal"><?= number_format($grandTotal,2)?></td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="2" id="mobile_terms1">2 &nbsp; &nbsp;  Physical damage, Liquid Damage & Power Break issues will not accepected in warranty period.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Shipping</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="tax"><?= htmlspecialchars($row['shipping']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <!-- <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="3" id="mobile_terms2">3 &nbsp; &nbsp;  We pay only 1% GST under Govt composition scheme, GST NO: 36AAFF18494K2Z0.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Tax Rate</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="taxrate"><?= htmlspecialchars($row['taxrate']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr> -->
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="2" id="mobile_terms3">4 &nbsp; &nbsp;  All Payment Modes Accepted, Cheques are subject to Clearance Before Delivery.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Total</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">Nill</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600; padding-right: 10px;" id="shipping"><?= number_format($row['total'],2) ?></td>
                    </tr>
                </tbody>
            </table>
            <!-- <input type="hidden" name="termsvalue" id="termsvalue" value="<?= htmlspecialchars($row['termscheckbox']) ?>"> -->

            <div style="padding-top: 10px; font-size: 14px; padding-right: 28%;">we will be happy to supply any further information you may need and trust that you call on us to fill your order, which will receive our prompt and careful attention.</div>
<div style="display: flex;justify-content: space-between;">
    <div style="padding-top: 10px;"><strong style="font-size: 15px;">Payment Information</strong><br/>
<span style=" line-height: 24px; padding-top: 2px; display: inline-block;">Payment Due Date : <strong> <?= date('d-m-Y', strtotime($row['created_at'])) ?> </strong> <br/>Payment Mode : <strong> Cash </strong><br/></span></div>
            <div style="padding-top: 20px; font-weight: 500; font-size: 16px; text-align: right;">Signature :  B.Satish Kumar <br/>
                Date: <span id="date"> <?= date('d-m-Y', strtotime($row['created_at'])) ?> </span></div>
                </div>


                <div style="border-top: 1px solid #cccccc; margin-top: 15px; text-align: center; padding-top: 10px; font-size: 13px; line-height: 22px; ">
                   <b> Head Office </b> : #6-3-347/12/A/12, Dwarakapuri Colony, Beside Manchukonda House Punjagutta, Telangana-500082. Tel: 040-66 813 713.<br/>

                   <b>  Branch Office </b> : Bajaj Electronics, Cellar Floor, Merix Square building, Suchitra, Kompally, Hyderabad, Telangana-500 055. <br/> Tel:040-27940789<br/>
                        
                        Mobile : 89780 89781 &nbsp;  &nbsp;  &nbsp;  &nbsp; | &nbsp;  &nbsp;  &nbsp;  &nbsp; Mail : idevicehyd@gmail.com &nbsp;  &nbsp;  &nbsp;  &nbsp; | &nbsp;  &nbsp;  &nbsp;  &nbsp; Website : www.idevice.co.in
                </div>


        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("includes/footer.php"); ?>

<script>
function printInvoice() {
  const html = document.getElementById("dvContainer").innerHTML;
  document.body.innerHTML = html; window.print(); location.reload();
}
async function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const canvas = await html2canvas(document.getElementById("dvContainer"),{scale:2});
  const pdf = new jsPDF('p','mm','a4');
  const img = canvas.toDataURL('image/png');
  const w = pdf.internal.pageSize.getWidth() - 10;
  const h = (canvas.height * w) / canvas.width;
  pdf.addImage(img,'PNG',5,10,w,h);
  pdf.save("Invoice_<?= $invoice_id ?>.pdf");
}
</script>
<script>

//         const pdfFileName = "<?= htmlspecialchars($row['companyname']) ?>.pdf";

  
//  function printInvoice() {
//         const originalContent = document.body.innerHTML;
//         const printArea = document.getElementById("dvContainer").innerHTML;

//         document.body.innerHTML = printArea;
//         window.print();
//         document.body.innerHTML = originalContent;
//         location.reload();
//     }

//     async function downloadPDF() {
//         const { jsPDF } = window.jspdf;
//         const element = document.getElementById("dvContainer");

//         const canvas = await html2canvas(element, { scale: 2 });
//         const imgData = canvas.toDataURL("image/png");

//         const pdf = new jsPDF('p', 'mm', 'a4');
//         const pdfWidth = pdf.internal.pageSize.getWidth();
//             const margin = 5;
//     const contentWidth = pdfWidth - margin * 2;

//         const pdfHeight = (canvas.height * contentWidth) / canvas.width;

//         pdf.addImage(imgData, 'PNG', margin, 10, contentWidth, pdfHeight);
//         pdf.save(pdfFileName);
//     }
 


</script>

 <!-- <div class="page-wrapper cardhead">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                <h5 class="card-title mt-3"><?= htmlspecialchars($row['companyname']) ?></h5>
                                </div>
                                <div class="col-md-6">
                                    <div style="text-align: right;">
    <button onclick="printInvoice()" class="btn submit-button mx-1"><i class="ti ti-printer"></i> Print</button>
    <button onclick="downloadPDF()" class="btn btn-success mx-1"><i class="ti ti-download"></i> PDF</button>
    <a href="editinvoice.php?id=<?= $invoice_id ?>" class="btn cancel-button mx-1"><i class="ti ti-pencil"></i> Edit</a>
</div>

                                </div>
                                </div>
                                                </div>
                        <div class="card-body">
                     <div id="dvContainer" >
            <div style="display: inline-block; width: 100%; text-align:center;">
                <img src="images/logo.png" style="max-height: 60px;"/></div> 
            <h2 style="text-align: center; font-size: 38px;padding-bottom:5px;">Invoice</h2>
            <table style="font-size: 13px; width:100%;  margin-bottom: 25px; padding: 0;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td>
                            <table style="font-size: 13px; margin-bottom: 25px; padding: 0;" cellspacing="0" cellpadding="0">
                <tbody>
                     <tr>
                        <td style="padding-left: 10px;font-size: 16px;font-weight:600;padding-bottom: 3px;padding-top: 10px;">Invoice No: 12568</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 16px; font-weight:600;padding-bottom: 15px;">Invoice Date: 24-06-2025</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px;font-size: 17px;padding-bottom: 5px;"><strong>Bill To:</strong></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['name']) ?></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['address']) ?></td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;"><?= htmlspecialchars($row['phonenumber']) ?></td>
                    </tr>
                  
                    </tbody>
                    </table>
                    </td>
                        <td style="float: right;text-align: right;"> 
                            <table style="font-size: 13px; margin-bottom: 25px; padding: 0;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;font-size: 17px;padding-bottom: 5px;"><strong>From :</strong></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;">Idevice </td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px;">+91 96764 92221</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;">info@idevice.co.in</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px;">Building, D.No 04-009/NR, Survey No 43,Merix Square Bajaj Electronics, <br/> Suchitra Rd, Kompally, Hyderabad - 500055</td>
                    </tr>
                  
                    </tbody>
                    </table></td>
                    </tr>
                    </tbody>
                    </table>
           
          
            <table style="font-size: 13px; width:100%; border:1px solid #cccccc" cellspacing="0" cellpadding="0">
                <thead>
                    <tr style="background-color: #333333; color: #ffffff; -webkit-print-color-adjust: exact; -moz-print-color-adjust: exact; print-color-adjust: exact;">
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px; width: 130px;">Item</th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Description</th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px; width: 90px;">Quantity</th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Service Charge</th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Discount % </th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="itemname"><?= htmlspecialchars($row['itemname']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="description"><?= htmlspecialchars($row['description']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="quantity"><?= htmlspecialchars($row['quantity']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="servicecharge"><?= htmlspecialchars($row['servicecharge']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="discount"><?= htmlspecialchars($row['discount']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; padding-right: 10px; font-weight: 700;" id="total"><?= htmlspecialchars($row['total']) ?></td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; text-align: center;background-color: #333333; color: #ffffff; -webkit-print-color-adjust: exact; -moz-print-color-adjust: exact; print-color-adjust: exact;" colspan="3">Terms & Conditions Apply</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="3" id="mobile_terms">1 &nbsp; &nbsp;  All Logic Board Service Cary 30day Warranty</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Sub total</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; padding-right: 10px; font-weight: 700;" id="subtotal"><?= htmlspecialchars($row['subtotal']) ?></td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="3" id="mobile_terms1">2 &nbsp; &nbsp;  Physical damage, Liquid Damage & Power Break issues will not accepected in warranty period.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Tax</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="tax"><?= htmlspecialchars($row['tax']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="3" id="mobile_terms2">3 &nbsp; &nbsp;  We pay only 1% GST under Govt composition scheme, GST NO: 36AAFF18494K2Z0.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Tax Rate</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="taxrate"><?= htmlspecialchars($row['taxrate']) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="3" id="mobile_terms3">4 &nbsp; &nbsp;  All Payment Modes Accepted, Cheques are subject to Clearance Before Delivery.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Shipping</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">Nill</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600; padding-right: 10px;" id="shipping"><?= htmlspecialchars($row['shipping']) ?></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="termsvalue" id="termsvalue" value="<?= htmlspecialchars($row['termscheckbox']) ?>">

            <div style="padding-top: 10px; font-size: 14px; padding-right: 28%;">we will be happy to supply any further information you may need and trust that you call on us to fill your order, which will receive our prompt and careful attention.</div>
<div style="display: flex;justify-content: space-between;">
    <div style="padding-top: 10px;"><strong style="font-size: 15px;">Payment Information</strong><br/>
<span style=" line-height: 24px; padding-top: 2px; display: inline-block;">Payment Due Date : <strong> 24-06-2025</strong> <br/>Payment Mode : <strong> Cash </strong><br/></span></div>
            <div style="padding-top: 20px; font-weight: 500; font-size: 16px; text-align: right;">Signature :  B.Satish Kumar <br/>
                Date: <span id="date"> 24.04.2023 </span></div>
                </div>


                <div style="border-top: 1px solid #cccccc; margin-top: 15px; text-align: center; padding-top: 10px; font-size: 13px; line-height: 22px; ">
                   <b> Head Office </b> : #6-3-347/12/A/12, Dwarakapuri Colony, Beside Manchukonda House Punjagutta, Telangana-500082. Tel: 040-66 813 713.<br/>

                   <b>  Branch Office </b> : Bajaj Electronics, Cellar Floor, Merix Square building, Suchitra, Kompally, Hyderabad, Telangana-500 055. <br/> Tel:040-27940789<br/>
                        
                        Mobile : 89780 89781 &nbsp;  &nbsp;  &nbsp;  &nbsp; | &nbsp;  &nbsp;  &nbsp;  &nbsp; Mail : idevicehyd@gmail.com &nbsp;  &nbsp;  &nbsp;  &nbsp; | &nbsp;  &nbsp;  &nbsp;  &nbsp; Website : www.idevice.co.in
                </div>


        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Close the database connection
    //$conn->close();
    ?>

 -->