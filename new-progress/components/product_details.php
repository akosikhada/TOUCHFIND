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
<html lang="en" style="overflow-y: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>TOUCHFIND | Product Details</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/product_details.css">
    <link rel="stylesheet" href="../css/categories.css">
    <style>
        /* Override any overflow hidden in body */
        body {
            overflow-y: auto !important;
            min-height: 100vh !important;
            height: auto !important;
        }
        
        /* Enhanced Product Details Styling */
        .main-container {
            padding-top: 40px;
            display: flex;
            justify-content: center;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            height: auto !important;
        }
        
        .product-container {
            width: 100%;
            max-width: 1200px;
            padding: 0 20px;
            margin: 0 auto;
            overflow-y: visible !important;
        }
        
        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            width: 100%;
        }
        
        .back-link {
            display: flex;
            align-items: center;
            color: #888;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
            font-size: 14px;
        }
        
        .back-link:hover {
            color: #00c6ff;
        }
        
        .product-detail {
            background: #1a1a1a;
            border-radius: 20px;
            overflow: visible !important;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            height: auto !important;
            margin-top: 0 !important;
            margin-bottom: 20px !important;
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }
        
        .product-detail::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 198, 255, 0.2), transparent);
        }
        
        .product-detail-inner {
            display: flex;
            flex-direction: row;
            height: auto !important;
        }
        
        .product-image-container {
            flex: 1;
            max-width: 50%;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            background-color: #1a1a1a !important;
        }
        
        .product-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, transparent 80%, rgba(0, 0, 0, 0.6));
            z-index: 1;
            pointer-events: none;
        }
        
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            position: relative;
            z-index: 0;
        }
        
        .product-info {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: auto !important;
        }
        
        .product-category {
            color: #00c6ff;
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .product-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.3;
            background: linear-gradient(90deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }
        
        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            background: rgba(0, 0, 0, 0.4);
            padding: 10px 15px;
            border-radius: 10px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .price-value {
            color: #00c6ff;
            text-shadow: 0 0 10px rgba(0, 198, 255, 0.3);
        }
        
        .product-description {
            margin-bottom: 25px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            max-height: none !important;
            overflow: visible !important;
            padding-right: 10px;
            position: relative;
        }
        
        .product-description::-webkit-scrollbar {
            width: 6px;
        }
        
        .product-description::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.2);
            border-radius: 3px;
        }
        
        .product-description::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
        
        .product-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            background: rgba(0, 0, 0, 0.25);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        
        .meta-item span:first-child {
            font-size: 12px;
            color: #888;
            margin-bottom: 5px;
        }
        
        .meta-item span:last-child {
            font-size: 16px;
            font-weight: 600;
        }
        
        .aisle-highlight {
            color: #00c6ff;
            text-shadow: 0 0 8px rgba(0, 198, 255, 0.2);
        }
        
        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: auto;
        }
        
        .quantity-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .quantity-label {
            margin-right: 15px;
            font-weight: 500;
        }
        
        .quantity {
            display: flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .quantity-btn {
            background: rgba(0, 0, 0, 0.3);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .quantity-btn:hover {
            background: rgba(0, 0, 0, 0.5);
        }
        
        .quantity input {
            width: 60px;
            background: transparent;
            border: none;
            color: white;
            font-size: 16px;
            text-align: center;
            font-weight: 600;
        }
        
        .add-to-cart, .back-button {
            position: relative;
            padding: 15px 20px;
            border-radius: 10px;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .add-to-cart {
            background: linear-gradient(90deg, #0066cc, #0099ff);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
        }
        
        .back-button {
            background: #2c3e50;
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
        }
        
        .add-to-cart:hover, .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        
        .btn-text {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .cart-icon-btn, .shopping-icon {
            margin-right: 5px;
        }
        
        .btn-highlight, .btn-shopping-highlight {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .add-to-cart:hover .btn-highlight, .back-button:hover .btn-shopping-highlight {
            left: 100%;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .product-detail-inner {
                flex-direction: column !important;
            }
            
            .product-image-container {
                max-width: 100% !important;
                height: 350px !important;
                border-right: none !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .product-info {
                padding: 25px !important;
            }
            
            .product-title {
                font-size: 24px !important;
            }
            
            body {
                overflow-y: auto !important;
            }
        }
        
        @media (max-width: 768px) {
            body {
                overflow-y: auto !important;
                height: auto !important;
            }
            
            .main-container {
                height: auto !important;
                overflow-y: auto !important;
                min-height: auto !important;
            }
            
            .product-container {
                width: 100% !important;
                overflow-y: visible !important;
                padding: 0 15px !important;
            }
            
            .product-detail {
                margin-top: 10px !important;
                overflow: visible !important;
                height: auto !important;
                margin-bottom: 20px !important;
            }
            
            .product-meta {
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 10px !important;
                padding: 12px !important;
            }
            
            .product-image-container {
                height: 300px !important;
            }
            
            .product-price {
                font-size: 22px !important;
            }
            
            .product-actions {
                gap: 12px !important;
            }
        }
        
        @media (max-width: 576px) {
            body {
                overflow-y: auto !important;
            }
            
            .main-container {
                min-height: auto !important;
                padding-bottom: 70px !important;
                overflow-y: visible !important;
            }
            
            .product-header {
                flex-direction: row !important;
                align-items: center !important;
                gap: 10px !important;
                padding: 10px 0;
                margin-bottom: 15px !important;
            }
            
            .back-link {
                font-size: 13px !important;
                color: #aaa !important;
            }
            
            .product-detail {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                overflow: visible !important;
                height: auto !important;
            }
            
            .product-detail-inner {
                height: auto !important;
                flex-direction: column !important;
            }
            
            .product-image-container {
                height: 220px !important;
                border-radius: 12px 12px 0 0 !important;
            }
            
            .product-info {
                padding: 20px !important;
                height: auto !important;
            }
            
            .product-title {
                font-size: 20px !important;
                margin-bottom: 10px !important;
            }
            
            .product-price {
                font-size: 18px !important;
                margin-bottom: 15px !important;
            }
            
            .product-description {
                max-height: none !important;
                overflow: visible !important;
                font-size: 14px !important;
                margin-bottom: 15px !important;
                padding-right: 0 !important;
            }
            
            .product-meta {
                grid-template-columns: repeat(2, 1fr) !important;
                margin-bottom: 20px !important;
            }
            
            .meta-item span:last-child {
                font-size: 14px !important;
            }
            
            .quantity-container {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px !important;
                margin-bottom: 15px !important;
            }
            
            .quantity-label {
                margin-right: 0 !important;
            }
            
            .add-to-cart, .back-button {
                padding: 12px 16px !important;
                font-size: 14px !important;
                width: 100% !important;
            }
        }
        
        @media (max-width: 400px) {
            .product-image-container {
                height: 180px !important;
            }
        }
        
        a, a:hover, a:focus, a:active {
            text-decoration: none !important;
            color: inherit;
        }
        
        /* Mobile styles fix for search */
        @media (max-width: 576px) {
            .search-container-header {
                display: flex;
                align-items: center;
                position: relative;
            }
            .search-results-dropdown {
                position: absolute;
                top: 100%;
                left: auto;
                right: 0;
                width: 250px;
                max-height: 70vh;
                z-index: 1100;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <div class="search-container-header">
                <input type="text" class="search-input-header" id="searchInput" autocomplete="off" placeholder="Search products...">
                <button class="search-btn-header" id="searchButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
                <div class="search-results-dropdown" id="searchResults"></div>
            </div>
            <div class="cart-icon cart-badge" onclick="window.location.href='cart.php'">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span class="cart-count"><?php echo $_SESSION['cart_count'] ?? 0; ?></span>
                <span class="icon-text">My Cart</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <div class="product-container">
            <div class="product-detail">
                <div class="product-detail-inner">
                    <div class="product-image-container">
                        <img src="../admin/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="product-image" loading="lazy">
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
                            <button class="back-button" onclick="window.location.href='categories.php'">
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

    <?php include 'chatbot.php' ?>
    <?php include 'footer.php'; ?>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const searchResults = document.getElementById("searchResults");
            const searchButton = document.getElementById("searchButton");

            if (searchInput && searchResults) {
                searchInput.addEventListener("keyup", function() {
                    const query = this.value.trim();
                    if (query.length > 1) {
                        // Use AJAX to fetch search results
                        const xhr = new XMLHttpRequest();
                        xhr.open("GET", `search_products.php?query=${encodeURIComponent(query)}`, true);
                        xhr.onload = function() {
                            if (this.status === 200) {
                                searchResults.innerHTML = this.responseText;
                                searchResults.classList.add("active");
                            }
                        };
                        xhr.send();
                    } else {
                        searchResults.innerHTML = "";
                        searchResults.classList.remove("active");
                    }
                });

                // Handle click outside to close results
                document.addEventListener("click", function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.remove("active");
                    }
                });

                // Handle search button click
                if (searchButton) {
                    searchButton.addEventListener("click", function() {
                        const query = searchInput.value.trim();
                        if (query.length > 0) {
                            window.location.href = `search_results.php?query=${encodeURIComponent(query)}`;
                        }
                    });
                }

                // Handle Enter key press
                searchInput.addEventListener("keypress", function(e) {
                    if (e.key === "Enter") {
                        const query = this.value.trim();
                        if (query.length > 0) {
                            window.location.href = `search_results.php?query=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }
            
            // Add click event for back button
            document.querySelector('.back-button').addEventListener('click', () => {
                window.location.href = 'categories.php';
            });
        });
    </script>
    <script src="../js/product_details.js" defer></script>
</body>
</html>