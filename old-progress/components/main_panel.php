<?php
require 'db_connection.php';

// Fetch all categories
$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

if (!$categoryResult) {
    die("Error fetching categories: " . $conn->error);
}

$categories = $categoryResult->fetch_all(MYSQLI_ASSOC);

// Fetch all products by default
$productSql = "SELECT * FROM products";
$productResult = $conn->query($productSql);

if (!$productResult) {
    die("Error fetching products: " . $conn->error);
}

$products = $productResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="../js/main_panel.js"></script>
    <title>TouchFind | KIOSK</title>
</head>
<body>
    <?php include ("header.php") ?>
    <?php include ("search_cart.php") ?>

    <div class="main-container">
        <div class="category-panel">
            <h2>Categories</h2>
            <ul id="category-list">
                <li><a href="#" id="all" class="category-link active">All Products</a></li>
                <?php foreach ($categories as $category): ?>
                    <li><a href="#" id="<?php echo $category['category_id']; ?>" class="category-link">
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="product-display">
            <h2>Products</h2>
            <div id="product-list">
                <?php if (empty($products)): ?>
                    <p>No products available.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-item">
                            <a href="view_product.php?id=<?php echo $product['product_id']; ?>">
                                <?php if (!empty($product['product_image'])): ?>
                                    <img src="images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image">
                                <?php endif; ?>
                                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                <p>Price: ₱<?php echo number_format($product['product_price'], 2); ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="chatbot-icon" id="chatbot-icon">
        <i class="fas fa-comments"></i>
    </div>

    <?php include ("chatbot.php") ?>

    <?php include ("footer.php") ?>

    <script>
        document.getElementById('chatbot-icon').addEventListener('click', function() {
            const chatbotContainer = document.querySelector('.chatbot-container');
            chatbotContainer.style.display = chatbotContainer.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>