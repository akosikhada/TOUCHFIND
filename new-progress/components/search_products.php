<?php
require 'db_connection.php';

// Get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Sanitize the input
$query = $conn->real_escape_string($query);

if (strlen($query) > 1) {
    // Search products matching the query
    $sql = "SELECT p.*, c.category_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_name LIKE '%$query%' 
            OR c.category_name LIKE '%$query%' 
            OR p.product_description LIKE '%$query%'
            LIMIT 8";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            $productImagePath = '../admin/' . $product['product_image'];
            echo '<a href="product_details.php?product_id=' . $product['product_id'] . '" class="search-result-item" style="text-decoration:none; color:white;">
                    <img src="' . $productImagePath . '" alt="' . htmlspecialchars($product['product_name']) . '" class="search-result-image" loading="lazy">
                    <div class="search-result-info">
                        <div class="search-result-title" style="color:white;">' . htmlspecialchars($product['product_name']) . '</div>
                        <div class="search-result-price">
                            <span>' . htmlspecialchars($product['category_name']) . '</span>
                            <span style="color:#00c6ff;">₱ ' . number_format($product['product_price'], 2) . '</span>
                        </div>
                    </div>
                </a>';
        }
    } else {
        echo '<div class="no-results">No products found matching "' . htmlspecialchars($query) . '"</div>';
    }
}
?>