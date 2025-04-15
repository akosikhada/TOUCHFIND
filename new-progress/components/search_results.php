<?php
require 'db_connection.php';

// Get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Sanitize the input
$query = $conn->real_escape_string($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | TOUCHFIND</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/categories.css">
    <style>
        @media (max-width: 576px) {
            .search-container-header {
                display: flex;
                align-items: center;
                position: relative;
            }
            .icon-text {
                display: none;
            }
            .search-input-header {
                width: 100%;
            }
            .search-btn-header {
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .search-btn-header svg {
                width: 18px;
                height: 18px;
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
        /* Fix for blue underlines */
        a, a:hover, a:focus, a:active {
            text-decoration: none !important;
            color: inherit;
        }
        
        .product-card a {
            text-decoration: none !important;
            color: white;
        }
        
        .category-item a {
            text-decoration: none !important;
        }
        
        .search-result-item {
            text-decoration: none !important;
            color: white;
        }
        
        /* Fix for any remaining blue text */
        .category-name, .product-title, .price-value, .search-result-title {
            color: white !important;
        }
        
        .sidebar a, .sidebar a:hover {
            color: white !important;
            text-decoration: none !important;
        }
        
        /* Fix for back-to-all button */
        .back-to-all {
            text-decoration: none !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <div class="search-container-header">
                <input type="text" class="search-input-header" id="searchInput" autocomplete="off" placeholder="Search products..." value="<?php echo htmlspecialchars($query); ?>">
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

    <div class="main-container">
        <div class="sidebar">
            <div class="sidebar-title">Categories</div>
            <ul class="category-list">
                <li class="category-item">
                    <a href="categories.php">
                        <img src="../assets/all-icon.png" alt="All" class="category-icon" loading="lazy">
                        View All
                    </a>
                </li>
                <?php
                $catSql = "SELECT * FROM categories";
                $catResult = $conn->query($catSql);
                while ($row = $catResult->fetch_assoc()) {
                    $iconName = strtolower($row['category_name']) . '-icon.png';
                    echo '<li class="category-item">
                            <a href="categories.php?category_id=' . $row['category_id'] . '">
                                <img src="../assets/' . $iconName . '" alt="' . $row['category_name'] . '" class="category-icon" loading="lazy">
                                ' . htmlspecialchars($row['category_name']) . '
                            </a>
                          </li>';
                }
                ?>
            </ul>
        </div>

        <div class="product-container">
            <h2 class="search-results-heading">
                <?php if (!empty($query)): ?>
                    Search results for: <span>"<?php echo htmlspecialchars($query); ?>"</span>
                <?php else: ?>
                    All Products
                <?php endif; ?>
            </h2>
            
            <div class="product-grid">
                <?php
                if (!empty($query)) {
                    $sql = "SELECT p.*, c.category_name 
                            FROM products p
                            JOIN categories c ON p.category_id = c.category_id
                            WHERE p.product_name LIKE '%$query%' 
                            OR c.category_name LIKE '%$query%' 
                            OR p.product_description LIKE '%$query%'";
                    
                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        while ($product = $result->fetch_assoc()) {
                            $productImagePath = '../admin/' . $product['product_image'];
                            echo '<div class="product-card">
                                    <a href="product_details.php?product_id=' . $product['product_id'] . '" style="text-decoration:none; color:white;">
                                        <div class="image-container">
                                            <img src="' . $productImagePath . '" alt="' . htmlspecialchars($product['product_name']) . '" class="product-image" loading="lazy">
                                        </div>
                                        <div class="product-title" style="color:white;">' . htmlspecialchars($product['product_name']) . '</div>
                                        <div class="product-price">
                                            <span>PRICE :</span>
                                            <span class="price-value" style="color:#00c6ff;">₱ ' . number_format($product['product_price'], 2) . '</span>
                                        </div>
                                    </a>
                                  </div>';
                        }
                    } else {
                        echo '<div class="no-search-results">
                                <div class="no-results-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </div>
                                <h3>No products found</h3>
                                <p>We couldn\'t find any products matching "' . htmlspecialchars($query) . '"</p>
                                <a href="categories.php" class="back-to-all">View all products</a>
                              </div>';
                    }
                } else {
                    // If no query, show all products
                    $sql = "SELECT p.*, c.category_name 
                            FROM products p
                            JOIN categories c ON p.category_id = c.category_id";
                    
                    $result = $conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        while ($product = $result->fetch_assoc()) {
                            $productImagePath = '../admin/' . $product['product_image'];
                            echo '<div class="product-card">
                                    <a href="product_details.php?product_id=' . $product['product_id'] . '" style="text-decoration:none; color:white;">
                                        <div class="image-container">
                                            <img src="' . $productImagePath . '" alt="' . htmlspecialchars($product['product_name']) . '" class="product-image" loading="lazy">
                                        </div>
                                        <div class="product-title" style="color:white;">' . htmlspecialchars($product['product_name']) . '</div>
                                        <div class="product-price">
                                            <span>PRICE :</span>
                                            <span class="price-value" style="color:#00c6ff;">₱ ' . number_format($product['product_price'], 2) . '</span>
                                        </div>
                                    </a>
                                  </div>';
                        }
                    }
                }
                ?>
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
        });
    </script>
</body>
</html> 