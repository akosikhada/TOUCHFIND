<?php
require 'db_connection.php';
$activeCategory = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Categories</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/categories.css">
    <style>
        /* Enhanced styling for categories page */
        .category-item a.active {
            font-weight: 600;
            color: white;
            background: linear-gradient(90deg, #0047ab, #007bff);
            padding: 12px 16px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .category-item a.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .category-item a.active:hover::before {
            left: 100%;
        }
        
        .category-item a {
            display: inline-flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            color: inherit;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .category-item:hover a:not(.active) {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }
        
        .category-item a:not(.active)::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: 0.5s;
        }
        
        .category-item:hover a:not(.active)::before {
            left: 100%;
        }
        
        .product-card {
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            margin-bottom: 15px;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4), 
                        0 0 15px rgba(0, 123, 255, 0.2);
            border-color: rgba(0, 198, 255, 0.3);
        }
        
        .product-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 198, 255, 0.2), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .product-card:hover::after {
            opacity: 1;
        }
        
        .view-details {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 123, 255, 0.8);
            color: white;
            text-align: center;
            padding: 8px 0;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        
        .product-card:hover .view-details {
            transform: translateY(0);
        }
        
        .image-container {
            position: relative;
            overflow: hidden;
            background: #000;
        }
        
        .image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, transparent 80%, rgba(0, 0, 0, 0.4));
            z-index: 1;
            pointer-events: none;
        }
        
        .product-info-wrapper {
            padding: 15px;
        }
        
        .product-title {
            font-weight: 600;
            margin: 0 0 12px;
            font-size: 20px;
            line-height: 1.3;
            color: white;
        }
        
        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            background: rgba(0, 0, 0, 0.4);
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 12px;
        }
        
        .price-label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .price-label svg {
            width: 16px;
            height: 16px;
            opacity: 0.7;
        }
        
        .price-value {
            font-weight: 700;
            font-size: 20px;
            color: #00c6ff;
            text-shadow: 0 0 10px rgba(0, 198, 255, 0.3);
        }
        
        .product-badges {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }
        
        .product-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(0, 123, 255, 0.1);
            color: #00c6ff;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid rgba(0, 123, 255, 0.2);
        }
        
        .product-badge.in-stock {
            background: rgba(40, 167, 69, 0.1);
            color: #2ecc71;
            border-color: rgba(40, 167, 69, 0.2);
        }
        
        .product-badge.low-stock {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border-color: rgba(255, 193, 7, 0.2);
        }
        
        .product-badge.out-of-stock {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-color: rgba(220, 53, 69, 0.2);
        }
        
        .badge-icon {
            width: 12px;
            height: 12px;
            opacity: 0.8;
        }
        
        .action-hint {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 2;
            opacity: 0.7;
        }
        
        .action-hint svg {
            width: 14px;
            height: 14px;
        }
        
        .product-image {
            border-radius: 0;
            height: 220px;
            object-fit: cover;
            width: 100%;
            border-bottom: none;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #141414, #1a1a1a);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-title {
            background: white;
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .header {
            background: linear-gradient(180deg, #121212, #1a1a1a);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .brand {
            background: white;
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .category-icon {
            width: 22px;
            height: 22px;
            margin-right: 15px;
            filter: brightness(0) invert(1);
            transition: transform 0.3s ease;
        }
        
        .category-item:hover .category-icon {
            transform: scale(1.1);
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .product-image {
                height: 160px;
            }
            
            .product-title {
                font-size: 16px;
                margin: 12px 12px 8px;
            }
            
            .product-price {
                margin: 0 12px 12px;
                padding: 8px 12px;
                font-size: 12px;
            }
            
            .price-value {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <div class="search-icon" id="searchIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <span class="icon-text">Search Products</span>
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

    <div class="main-container">
        <div class="sidebar">
            <div class="sidebar-title">Categories</div>
            <ul class="category-list">
                <li class="category-item">
                    <a href="categories.php" class="<?php echo $activeCategory === 0 ? 'active' : ''; ?>">
                        <img src="../assets/all-icon.png" alt="All" class="category-icon" loading="lazy">
                        View All
                    </a>
                </li>
                <?php
                $catSql = "SELECT * FROM categories";
                $catResult = $conn->query($catSql);
                while ($row = $catResult->fetch_assoc()) {
                    $isActive = $row['category_id'] == $activeCategory ? 'active' : '';
                    $iconName = strtolower($row['category_name']) . '-icon.png';
                    echo '<li class="category-item">
                            <a href="categories.php?category_id=' . $row['category_id'] . '" class="' . $isActive . '">
                                <img src="../assets/' . $iconName . '" alt="' . $row['category_name'] . '" class="category-icon" loading="lazy">
                                ' . htmlspecialchars($row['category_name']) . '
                            </a>
                          </li>';
                }
                ?>
            </ul>
        </div>

        <div class="product-container">
            <div class="product-grid">
                <?php
                $sql = "SELECT p.*, c.category_name 
                        FROM products p
                        JOIN categories c ON p.category_id = c.category_id";
                if ($activeCategory > 0) {
                    $sql .= " WHERE p.category_id = $activeCategory";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        $productImagePath = '../admin/' . $product['product_image'];
                        echo '<div class="product-card">
                                <a href="product_details.php?product_id=' . $product['product_id'] . '" style="text-decoration:none; color:inherit;">
                                    <div class="image-container">
                                        <img src="' . $productImagePath . '" alt="' . htmlspecialchars($product['product_name']) . '" class="product-image" loading="lazy">
                                    </div>
                                    <div class="product-title">' . htmlspecialchars($product['product_name']) . '</div>
                                    <div class="product-price">
                                        <span>PRICE :</span>
                                        <span class="price-value">₱ ' . number_format($product['product_price'], 2) . '</span>
                                    </div>
                                </a>
                              </div>';
                    }
                } else {
                    echo '<p style="margin-left:1rem; font-size: 16px; opacity: 0.8; padding: 20px; background: rgba(0,0,0,0.2); border-radius: 8px;">No products found in this category.</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="search-modal" id="searchModal">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-container">
            <div class="search-label">Search for Products</div>
            <div class="search-input-wrapper">
                <input type="text" class="search-input" id="searchInput" autocomplete="off" placeholder="Enter product name, category or keyword...">
                <button class="search-btn" id="searchButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
    
    <?php include 'chatbot.php' ?>

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
    <script src="../js/categories.js" defer></script>
</body>
</html>