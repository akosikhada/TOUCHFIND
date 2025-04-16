<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'], $_POST['quantity'])) {
    $cartId = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = ?, sub_total = product_price * ? WHERE cart_id = ?");
        $stmt->bind_param("iii", $quantity, $quantity, $cartId);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid data']);
?>