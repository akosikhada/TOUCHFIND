<?php
require '../db_connection.php';

if (isset($_POST['order_id'], $_POST['status'])) {
    $orderId = intval($_POST['order_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $orderId);
    $stmt->execute();

    echo json_encode(['success' => true]);
}
?>