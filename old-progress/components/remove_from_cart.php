<?php
require 'db_connection.php';
session_start();

if (isset($_GET['id'])) {
    $cartId = intval($_GET['id']);
    
    $deleteSql = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $stmt->close();
    
    $_SESSION['cart_message'] = "Item removed from cart.";
}

header("Location: cart.php");
exit;
?>