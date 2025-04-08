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
        .category-item a.active {
            font-weight: bold;
            color: white;
            background-color: #007bff;
            padding: 10px 14px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.4);
            transition: all 0.3s ease;
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
            </div>
            <div class="cart-icon cart-badge" onclick="window.location.href='cart.php'">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span class="cart-count"><?php echo $_SESSION['cart_count'] ?? 0; ?></span>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="sidebar">
            <div class="sidebar-title">Categories</div>
            <ul class="category-list">
                <li class="category-item">
                    <a href="categories.php" class="<?php echo $activeCategory === 0 ? 'active' : ''; ?>" style="text-decoration:none; color:inherit;">
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
                            <a href="categories.php?category_id=' . $row['category_id'] . '" class="' . $isActive . '" style="text-decoration:none; color:inherit;">
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
                $sql = "SELECT * FROM products";
                if ($activeCategory > 0) {
                    $sql .= " WHERE category_id = $activeCategory";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        $productImagePath = '../admin/' . $product['product_image'];
                        echo '<div class="product-card">
                                <a href="product_details.php?product_id=' . $product['product_id'] . '" style="text-decoration:none; color:inherit;">
                                    <img src="' . $productImagePath . '" alt="' . htmlspecialchars($product['product_name']) . '" class="product-image" loading="lazy">
                                    <div class="product-title">' . htmlspecialchars($product['product_name']) . '</div>
                                    <div class="product-price">
                                        <span>PRICE :</span>
                                        <span class="price-value">₱ ' . number_format($product['product_price'], 2) . '</span>
                                    </div>
                                </a>
                              </div>';
                    }
                } else {
                    echo '<p style="margin-left:1rem;">No products found in this category.</p>';
                }
                ?>
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