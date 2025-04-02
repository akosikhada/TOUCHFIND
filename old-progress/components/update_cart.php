<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cartId = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    
    // Validate quantity
    if ($quantity > 0) {
        $updateSql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $quantity, $cartId);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['cart_message'] = "Cart updated successfully!";
    }
}

header("Location: cart.php");
exit;
?>