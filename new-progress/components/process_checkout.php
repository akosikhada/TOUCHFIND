<?php
require 'db_connection.php';
session_start();

// Calculate total from cart
$sql = "SELECT SUM(sub_total) AS subtotal FROM cart";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$subtotal = $row['subtotal'] ?? 0;
$tax = 50;
$total = $subtotal + $tax;
$createdAt = date("Y-m-d H:i:s");
$orderNumber = 'ORD-' . date('Y') . '-' . rand(1000, 9999);

// Insert into orders table
$stmt = $conn->prepare("INSERT INTO orders (order_number, total_amount, created_at) VALUES (?, ?, ?)");
$stmt->bind_param("sds", $orderNumber, $total, $createdAt);
$stmt->execute();

// Clear cart after placing the order
$conn->query("DELETE FROM cart");

// Redirect to success page
header("Location: success.php?order_id=" . $orderNumber);
exit;
?>
