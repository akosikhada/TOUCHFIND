<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $categoryId = intval($_POST['category_id']);
    $quantity = intval($_POST['quantity']);
    $addedAt = date("Y-m-d H:i:s");
    $paymentMethod = 'Cash'; // Default payment method

    // Get product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $productName = $product['product_name'];
        $productStock = $product['product_stock'];
        $productPrice = $product['product_price'];
        $productImage = $product['product_image'];

        $tax = 50.00;
        $subTotal = $productPrice * $quantity;
        $total = $subTotal + $tax;

        $stmt = $conn->prepare("
            INSERT INTO cart (
                product_id, category_id, quantity, product_name,
                product_stock, product_price, product_image, tax,
                sub_total, total, payment_method, added_at
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiisdssdddss", 
            $productId,
            $categoryId,
            $quantity,
            $productName,
            $productStock,
            $productPrice,
            $productImage,
            $tax,
            $subTotal,
            $total,
            $paymentMethod,
            $addedAt
        );

        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Product added to cart"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
    }
}
?>