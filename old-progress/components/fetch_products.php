<?php
require 'db_connection.php';

$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

if ($categoryId > 0) {
    $sql = "SELECT * FROM products WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
} else {
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$products = array();
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);

$stmt->close();
$conn->close();
?>