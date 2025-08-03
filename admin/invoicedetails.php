<?php include("includes/header.php");
include("includes/top_header.php");
include("includes/sidebar.php"); 


if (!isset($_GET['id'])) { echo "Invalid invoice ID."; exit; }
$invoice_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM invoice WHERE invoice_id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) { echo "Invoice not found."; exit; }
$row = $res->fetch_assoc();
$stmt->close();

$itemStmt = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
$itemStmt->bind_param("i", $invoice_id);
$itemStmt->execute();
$items = $itemStmt->get_result();
$itemStmt->close();
?>

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
    <!-- <a href="editinvoice.php?id=<?= $invoice_id ?>" class="btn cancel-button mx-1"><i class="ti ti-pencil"></i> Edit</a> -->
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
                        <td style="padding-left: 10px;font-size: 16px;font-weight:600;padding-bottom: 3px;padding-top: 10px;">Invoice No: IDI100<?= htmlspecialchars($row['invoice_id']) ?></td>
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
                        <td style="float: right;text-align: right;" align="right"> 
                            <table style="font-size: 13px; margin-bottom: 25px; padding: 0; text-align: right;" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td style="padding-left: 10px;font-size: 17px;padding-bottom: 5px; text-align: right;" align="right"><strong>From :</strong></td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px; text-align: right;" align="right">Idevice </td>
                    </tr>
                     <tr>
                        <td style="padding-left: 10px;font-size: 14px;padding-bottom: 3px; text-align: right;" align="right">+91 96764 92221</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px; text-align: right;" align="right">info@idevice.co.in</td>
                    </tr>
                     <tr>
                        <td style=" padding-left: 10px;font-size: 14px;padding-bottom: 3px; text-align: right;" align="right">Building, D.No 04-009/NR, Survey No 43,Merix Square Bajaj Electronics, <br/> Suchitra Rd, Kompally, Hyderabad - 500055</td>
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
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Unit Price </th>
                        <th style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 40px; padding-left: 10px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
               $grandTotal = 0;
               $totalAmount = 0;
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
        $catStmt = $conn->prepare("SELECT category_name FROM device_categories WHERE id = ?");
        $catStmt->bind_param("i", $category_id);
        $catStmt->execute();
        $catRes = $catStmt->get_result();
        if ($c = $catRes->fetch_assoc()) {
            $categoryName = htmlspecialchars($c['category_name']);
        }
        $catStmt->close();
    }
    $pstmt->close();

    // $final = $qty * $price;
    // $grandTotal += $final;
     if ($isGift === 1) {
        $price = 0;
        $final = 0;
        $giftLabel = " <span style='color: green;'>(Gift Item)</span>";
    } else {
        $final = $qty * $price;
        $grandTotal += $final;
        $giftLabel = "";
    }


    $shipping = htmlspecialchars($row['shipping']) ;
    $totalAmount = $shipping + $grandTotal; 
?>

                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="description"><?= $categoryName ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; min-width:250px;" id="itemname"><?= $iname . ' (' . $clr . ' )'. $giftLabel ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="quantity"><?= $qty ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;" id="discount"><?= number_format($price,2) ?></td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; padding-right: 10px; font-weight: 700;" id="total"><?= number_format($final,2) ?></td>
                    </tr>
                     <?php endwhile; ?>

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
                                                <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">&nbsp;</td>

                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;" id="tax"><?= htmlspecialchars($row['shipping']) ?></td>
                    </tr>
                  
                    <tr>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 20px;" colspan="2" id="mobile_terms3">4 &nbsp; &nbsp;  All Payment Modes Accepted, Cheques are subject to Clearance Before Delivery.</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600;">Total</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px;">-</td>
                        <td style="border-right:1px solid #cccccc; border-bottom:1px solid #cccccc; height: 33px; padding-left: 10px; font-weight: 600; padding-right: 10px; font-weight: 700;" id="shipping"><?= number_format($totalAmount,2) ?></td>
                    </tr>
                </tbody>
            </table>

            <div style="padding-top: 10px; font-size: 14px; padding-right: 28%;">we will be happy to supply any further information you may need and trust that you call on us to fill your order, which will receive our prompt and careful attention.</div>
<div style="display: flex;justify-content: space-between;">
    <div style="padding-top: 10px;"><strong style="font-size: 15px;">Payment Information</strong><br/>
<span style=" line-height: 24px; padding-top: 2px; display: inline-block;">Payment Due Date : <strong> <?= date('d-m-Y', strtotime($row['created_at'])) ?> </strong> <br/>Payment Mode : <strong> <?= htmlspecialchars($row['payment_mode']) ?> </strong><br/></span></div>
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

        const pdfFileName = "<?= htmlspecialchars($row['companyname']) ?>.pdf";


function printInvoice() {
    const printContents = document.getElementById("dvContainer").innerHTML;

    const newWindow = window.open('', '', 'height=800,width=800');
    newWindow.document.write('<html><head><title>Invoice</title>');
    
    // Optional: add stylesheet if needed
    newWindow.document.write('<link rel="stylesheet" href="assets/css/style.css" type="text/css" />');

    newWindow.document.write('</head><body>');
    newWindow.document.write(printContents);
    newWindow.document.write('</body></html>');

    newWindow.document.close(); // necessary for IE >= 10
    newWindow.focus();

    setTimeout(() => {
        newWindow.print();
        newWindow.close();
    }, 500);
}


    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById("dvContainer");

        const canvas = await html2canvas(element, { scale: 2 });
        const imgData = canvas.toDataURL("image/png");

        const pdf = new jsPDF('p', 'mm', 'a4');
        const pdfWidth = pdf.internal.pageSize.getWidth();
            const margin = 5;
    const contentWidth = pdfWidth - margin * 2;

        const pdfHeight = (canvas.height * contentWidth) / canvas.width;

        pdf.addImage(imgData, 'PNG', margin, 10, contentWidth, pdfHeight);
        pdf.save(pdfFileName);
    }
 


</script>
