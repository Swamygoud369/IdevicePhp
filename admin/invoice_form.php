<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/db_connection.php");

// Check if form submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Escape and get all values
//     // $companyname = $_POST['companyname'];
//     // $name = $conn->real_escape_string($_POST['name']);
//     // $address = $conn->real_escape_string($_POST['address']);
//     // $email = $conn->real_escape_string($_POST['email']);
//     // $phonenumber = $conn->real_escape_string($_POST['phonenumber']);
//     // $itemname = $conn->real_escape_string($_POST['itemname']);
//     // $description = $conn->real_escape_string($_POST['description']);
//     // $quantity = $conn->real_escape_string($_POST['quantity']);
//     // $servicecharge = $conn->real_escape_string($_POST['servicecharge']);
//     // $discount = $conn->real_escape_string($_POST['discount']);
//     // $tax = $conn->real_escape_string($_POST['tax']);
//     // $taxrate = $conn->real_escape_string($_POST['taxrate']);
//     // $shipping = $conn->real_escape_string($_POST['shipping']);
//     // $terms = isset($_POST['termscheckbox']) ? 1 : 0;
//     $companyname = $_POST['companyname'];
//     $name = $_POST['name'];
//     $address = $_POST['address'];
//     $email = $_POST['email'];
//     $phonenumber = $_POST['phonenumber'];
//     $itemname = $_POST['itemname'];
//     $description = $_POST['description'];
//     $quantity = $_POST['quantity'];
//     $servicecharge = $_POST['servicecharge'];
//     $discount = $_POST['discount'];
//     $tax = $_POST['tax'];
//     $taxrate = $_POST['taxrate'];
//     $shipping = $_POST['shipping'];
//     $terms = isset($_POST['termscheckbox']) ? 1 : 0;

//     // Insert query
//     $sql = "INSERT INTO invoice (
//         companyname, name, address, email, phonenumber, itemname,
//         description, quantity, servicecharge, discount, tax, taxrate, shipping, termscheckbox
//     ) VALUES (
//         '$companyname', '$name', '$address', '$email', '$phonenumber', '$itemname',
//         '$description', '$quantity', '$servicecharge', '$discount', '$tax', '$taxrate', '$shipping', '$terms'
//     )";

//     if ($conn->query($sql) === TRUE) {
//         echo "Form submitted successfully!";
//          header("Location: dashboard.php");
//         // Redirect if needed: header("Location: thank_you.php");
//     } else {
//         echo "Error: " . $conn->error;
//     }

//     $conn->close();
// }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get master invoice fields
    $companyname   = $_POST['companyname'];
    $name          = $_POST['name'];
    $address       = $_POST['address'];
    $email         = $_POST['email'];
    $phonenumber   = $_POST['phonenumber'];
    $description   = $_POST['description'];
    $shipping      = $_POST['shipping'];
    $subtotal      = $_POST['subtotal'];
    $total         = $_POST['total'];

    // 2. Get item details arrays
    $itemnames  = $_POST['itemname'];
    $colors     = $_POST['color'];
    $quantities = $_POST['quantity'];
$gift_flags = isset($_POST['is_gift']) ? $_POST['is_gift'] : [];
$payment_mode = $_POST['payment_mode'];


    // 3. Insert into invoice table
    $stmt = $conn->prepare("INSERT INTO invoice (companyname, name, address, email, phonenumber, description, shipping, subtotal, total, payment_mode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssddds", $companyname, $name, $address, $email, $phonenumber, $description, $shipping, $subtotal, $total, $payment_mode);
    
    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id;  // get inserted invoice ID

        // 4. Insert each item into invoice_items and deduct from stock
        for ($i = 0; $i < count($itemnames); $i++) {
            $itemname = $itemnames[$i];
            $color    = $colors[$i];
            $qty      = (int)$quantities[$i];
                $is_gift  = isset($gift_flags[$i]) ? 1 : 0;


            // Insert item line
            $item_stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, itemname, color, quantity, is_gift) VALUES (?, ?, ?, ?, ?)");
            $item_stmt->bind_param("issii", $invoice_id, $itemname, $color, $qty, $is_gift);
            $item_stmt->execute();
            $item_stmt->close();

            // Update stock table
            $stock_stmt = $conn->prepare("UPDATE device_stockmodels SET quantity = quantity - ? WHERE model_name = ? AND color = ?");
            $stock_stmt->bind_param("iss", $qty, $itemname, $color);
            $stock_stmt->execute();
            $stock_stmt->close();
        }

        $stmt->close();
        $conn->close();
        header("Location: invoice.php?success=1");
        exit();
    } else {
        echo "Failed to create invoice: " . $stmt->error;
        $stmt->close();
    }
}





// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $companyname   = $_POST['companyname'];
//     $name          = $_POST['name'];
//     $address       = $_POST['address'];
//     $email         = $_POST['email'];
//     $phonenumber   = $_POST['phonenumber'];
//     $itemname      = $_POST['itemname'];
//     $description   = $_POST['description'];
//     $quantity      = $_POST['quantity'];
//     $servicecharge = $_POST['servicecharge'];
//     $discount      = $_POST['discount'];
//     $tax           = $_POST['tax'];
//     $taxrate       = $_POST['taxrate'];
//     $shipping      = $_POST['shipping'];
//     $terms         = isset($_POST['termscheckbox']) ? 1 : 0;
//     $subtotal = $_POST['subtotal'];
// $total = $_POST['total'];

//     $sql = "INSERT INTO invoice (
//         companyname, name, address, email, phonenumber, itemname,
//         description, quantity, servicecharge, discount, tax, taxrate, shipping, termscheckbox, subtotal, total
//     ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//     $stmt = $conn->prepare($sql);

//     if ($stmt) {
//         $stmt->bind_param(
//             "ssssssssssssssdd",
//             $companyname, $name, $address, $email, $phonenumber,
//             $itemname, $description, $quantity, $servicecharge, $discount,
//             $tax, $taxrate, $shipping, $terms, $subtotal, $total
//         );

//         if ($stmt->execute()) {
//             header("Location: invoice.php");
//             exit();
//         } else {
//             echo "Insert failed: " . $stmt->error;
//         }

//         $stmt->close();
//     } else {
//         echo "Prepare failed: " . $conn->error;
//     }

//     $conn->close();
// }



?>
