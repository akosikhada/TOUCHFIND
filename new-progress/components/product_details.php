<?php
require 'db_connection.php';

$product = null;

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    $sql = "SELECT p.*, c.category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.category_id 
            WHERE p.product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found.");
    }
} else {
    die("Invalid product.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TOUCHFIND | Product Details</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/product_details.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <div class="search-icon" id="searchIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </div>
            <div class="cart-icon cart-badge" onclick="window.location.href='cart.php'">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span class="cart-count"><?php echo $_SESSION['cart_count'] ?? 0; ?></span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="product-container">
            <div class="product-header">
                <a href="categories.php" class="back-link">&larr; Back to Categories</a>
                <span class="category-tag"><?php echo htmlspecialchars($product['category_name']); ?></span>
            </div>
            <div class="product-detail">
                <div class="product-detail-inner">
                    <div class="product-image-container">
                        <img src="../admin/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image" loading="lazy" style="object-fit: fill;">
                    </div>
                    <div class="product-info">
                        <div class="product-info-flex">
                            <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                            <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                            <div class="product-price">₱ <?php echo number_format($product['product_price'], 2); ?></div>
                            <div class="product-description">
                                <?php echo nl2br(htmlspecialchars($product['product_description'])); ?>
                            </div>
                            <div class="product-meta">
                                <div class="meta-item">
                                    <span>SKU</span>
                                    <span class="aisle-highlight"><?php echo htmlspecialchars($product['product_sku']); ?></span>
                                </div>
                                <div class="meta-item">
                                    <span>Shelf</span>
                                    <span><?php echo htmlspecialchars($product['product_shelf']); ?></span>
                                </div>
                                <div class="meta-item">
                                    <span>Stock</span>
                                    <span><?php echo htmlspecialchars($product['product_stock']); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="product-actions">
                        <form id="addToCartForm" style="all: unset; display: contents;">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $product['category_id']; ?>">
                            <input type="hidden" name="quantity" id="hiddenQuantity" value="1">

                            <div class="quantity-container">
                                <div class="quantity-label">Quantity:</div>
                                <div class="quantity">
                                    <button type="button" class="quantity-btn minus">-</button>
                                    <input type="text" id="quantity" value="1" readonly>
                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                            </div>
                            <button type="submit" class="add-to-cart">
                                <span class="btn-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="cart-icon-btn">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    Add to Cart
                                </span>
                                <span class="btn-highlight"></span>
                            </button>
                        </form>
                            <button class="back-button">
                                <span class="btn-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="shopping-icon">
                                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                                    </svg>
                                    Continue Shopping
                                </span>
                                <span class="btn-shopping-highlight"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="search-modal" id="searchModal">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" autocomplete="off" placeholder="Search products...">
            <button class="search-btn" id="searchButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchIcon = document.getElementById("searchIcon");
            const searchModal = document.getElementById("searchModal");
            const closeSearch = document.getElementById("closeSearch");

            if (searchIcon && searchModal && closeSearch) {
                searchIcon.addEventListener("click", () => {
                    searchModal.style.display = "flex";
                    setTimeout(() => searchModal.style.opacity = 1, 10);
                });

                closeSearch.addEventListener("click", () => {
                    searchModal.style.opacity = 0;
                    setTimeout(() => searchModal.style.display = "none", 300);
                });
            }
        });
    </script>
    <script src="../js/product_details.js" defer></script>
</body>
</html>