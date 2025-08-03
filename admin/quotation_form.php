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
//     $sql = "INSERT INTO quotation (
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

    $companyname   = $_POST['companyname'];
    $name          = $_POST['name'];
    $address       = $_POST['address'];
    $email         = $_POST['email'];
    $phonenumber   = $_POST['phonenumber'];
    $itemname      = $_POST['itemname'];
    $description   = $_POST['description'];
    $quantity      = $_POST['quantity'];
    $servicecharge = $_POST['servicecharge'];
    $discount      = $_POST['discount'];
    $tax           = $_POST['tax'];
    $taxrate       = $_POST['taxrate'];
    $shipping      = $_POST['shipping'];
    $terms         = isset($_POST['termscheckbox']) ? 1 : 0;
    $subtotal = $_POST['subtotal'];
$total = $_POST['total'];

    $sql = "INSERT INTO quotation (
        companyname, name, address, email, phonenumber, itemname,
        description, quantity, servicecharge, discount, tax, taxrate, shipping, termscheckbox, subtotal, total
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "ssssssssssssssdd",
            $companyname, $name, $address, $email, $phonenumber,
            $itemname, $description, $quantity, $servicecharge, $discount,
            $tax, $taxrate, $shipping, $terms, $subtotal, $total
        );

        if ($stmt->execute()) {
            header("Location: quotation.php");
            exit();
        } else {
            echo "Insert failed: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }

    $conn->close();
}

?>
