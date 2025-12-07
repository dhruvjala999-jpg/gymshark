<?php
include("connection.php");

// Grab posted data
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$product_id = $_POST['product_id'] ?? null;

// In a real system, you'd insert this into an orders table
// Example:
$stmt = $conn->prepare("INSERT INTO orders (fullname,email,address,payment_method,product_id) VALUES (?,?,?,?,?)");
$stmt->bind_param("ssssi", $fullname, $email, $address, $payment_method, $product_id);
$stmt->execute();

header("Location: success.php");
exit;
