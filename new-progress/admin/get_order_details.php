<?php
require 'components/db_connection.php';

if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);

    $sql = "SELECT oi.*, p.product_image 
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        echo "<ul class='list-group'>";
        while ($item = $result->fetch_assoc()):
            echo "<li class='list-group-item d-flex align-items-center'>";
            echo "<img src='../admin/{$item['product_image']}' alt='' width='50' class='me-3'>";
            echo "<div><strong>{$item['product_name']}</strong><br>Quantity: {$item['quantity']} | ₱" . number_format($item['price'], 2) . "</div>";
            echo "</li>";
        endwhile;
        echo "</ul>";
    else:
        echo "<p>No products found for this order.</p>";
    endif;
}
?>