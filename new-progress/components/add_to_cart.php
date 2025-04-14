<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $categoryId = intval($_POST['category_id']);
    $quantity = intval($_POST['quantity']);
    $addedAt = date("Y-m-d H:i:s");
    $paymentMethod = 'Cash';

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

        // Check if item already exists in cart
        $check = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
        $check->bind_param("i", $productId);
        $check->execute();
        $existing = $check->get_result()->fetch_assoc();

        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $newSubTotal = $newQty * $productPrice;
            $newTotal = $newSubTotal + 50;

            $update = $conn->prepare("UPDATE cart SET quantity = ?, sub_total = ?, total = ?, added_at = ? WHERE cart_id = ?");
            $update->bind_param("iddsi", $newQty, $newSubTotal, $newTotal, $addedAt, $existing['cart_id']);
            $update->execute();
        } else {
            $tax = 50.00;
            $subTotal = $productPrice * $quantity;
            $total = $subTotal + $tax;

            $insert = $conn->prepare("
                INSERT INTO cart (
                    product_id, category_id, quantity, product_name,
                    product_stock, product_price, product_image, tax,
                    sub_total, total, payment_method, added_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $insert->bind_param(
                "iiisdssdddss",
                $productId, $categoryId, $quantity, $productName,
                $productStock, $productPrice, $productImage, $tax,
                $subTotal, $total, $paymentMethod, $addedAt
            );
            $insert->execute();
        }

        echo json_encode(["status" => "success", "message" => "Product added to cart"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
    }
}
?>