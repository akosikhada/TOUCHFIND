<?php
require 'db_connection.php';
header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $query = "%" . $_GET['q'] . "%";

    $stmt = $conn->prepare("SELECT product_id, product_name, product_price, product_image FROM products WHERE product_name LIKE ?");
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
} else {
    echo json_encode([]);
}
?>