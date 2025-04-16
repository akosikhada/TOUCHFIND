<?php
require 'components/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);

    // Delete order items first (foreign key constraint)
    $conn->query("DELETE FROM order_items WHERE order_id = $orderId");

    // Then delete the order
    $result = $conn->query("DELETE FROM orders WHERE order_id = $orderId");

    echo json_encode(['success' => $result]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;