<?php
require_once 'components/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($order_id && $status) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $status, $order_id);
        $success = $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>