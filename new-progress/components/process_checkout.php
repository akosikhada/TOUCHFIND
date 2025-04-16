<?php
require 'db_connection.php';
session_start();

date_default_timezone_set("Asia/Manila");

// Get cart items
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "<script>alert('Your cart is empty!'); window.location.href='cart.php';</script>";
    exit;
}

$cartItems = [];
$totalAmount = 0;
$totalQuantity = 0;
$tax = 50;

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $totalAmount += $row['sub_total'];
    $totalQuantity += $row['quantity'];
}

$totalAmount += $tax;
$createdAt = date("Y-m-d H:i:s");
$orderNumber = 'ORD-' . date('Y') . '-' . rand(1000, 9999);
$status = 'unpaid';

// Insert order into `orders` table
$stmt = $conn->prepare("INSERT INTO orders (order_number, total_amount, quantity, status, created_at) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdiss", $orderNumber, $totalAmount, $totalQuantity, $status, $createdAt);
$stmt->execute();
$orderId = $stmt->insert_id; // ✅ Get the order_id to use in order_items
$stmt->close();

// Insert each item into order_items table + update product stock
foreach ($cartItems as $item) {
    $productId = $item['product_id'];
    $productName = $item['product_name'];
    $quantity = $item['quantity'];
    $price = $item['product_price']; // unit price

    // ✅ Insert into order_items
    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
    $stmtItem->bind_param("iisid", $orderId, $productId, $productName, $quantity, $price);
    $stmtItem->execute();
    $stmtItem->close();

    // ✅ Reduce stock in products table
    $stmtStock = $conn->prepare("UPDATE products SET product_stock = product_stock - ? WHERE product_id = ?");
    $stmtStock->bind_param("ii", $quantity, $productId);
    $stmtStock->execute();
    $stmtStock->close();
}

// Clear cart
$conn->query("DELETE FROM cart");

// Redirect to success page
header("Location: success.php?order_id=" . urlencode($orderNumber));
exit;
?>