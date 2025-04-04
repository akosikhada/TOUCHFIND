<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Product Details</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: white;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        /* Header Styles */
        .header {
            background-color: #1a1a1a;
            padding: 10px 30px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            border-bottom: 1px solid #333;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50px;
            z-index: 100;
        }
        
        .brand {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            grid-column: 2;
            text-align: center;
        }
        
        .header-icons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            grid-column: 3;
        }
        
        .search-icon, .cart-icon {
            margin-left: 20px;
            font-size: 20px;
            cursor: pointer;
        }
        
        .cart-badge {
            position: relative;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #1F2937;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Main Content Layout */
        .main-container {
            display: flex;
            margin-top: 50px; /* Header height */
            flex: 1;
            position: relative;
            overflow: hidden;
            height: calc(100vh - 90px); /* Adjust for header and footer */
        }
        
        /* Product Details Styles */
        .product-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            overflow-y: hidden;
            padding: 15px 30px 40px 30px; /* Reduced bottom padding */
        }
        
        .product-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        .product-header {
            display: flex;
            margin-bottom: 15px;
        }
        
        .back-link {
            display: flex;
            align-items: center;
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: white;
        }
        
        .back-icon {
            margin-right: 5px;
        }
        
        .category-tag {
            background-color: #1F2937;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-left: auto;
        }
        
        .product-detail {
            display: flex;
            margin-bottom: 20px; /* Reduced from 30px */
            animation: fadeIn 0.8s ease forwards;
            overflow-y: visible;
            height: auto;
            margin-top: 50px;
        }
        
        .product-detail-inner {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            background-color: #1F2937;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            justify-content: center;
            height: auto;
        }
        
        .product-image-container {
            width: 40%;
            background-color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            animation: slideInLeft 0.8s ease forwards;
            margin: 0;
            border-radius: 10px 0 0 10px;
        }
        
        .product-image {
            width: 80%;
            height: auto;
            max-height: 250px;
            object-fit: contain;
            border-radius: 8px;
        }
        
        .product-info {
            width: 60%;
            padding: 25px;
            display: flex;
            flex-direction: column;
            animation: slideInRight 0.8s ease forwards;
        }
        
        .product-info-flex {
            flex: 1;
        }
        
        .product-category {
            color: #aaa;
            font-size: 14px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }
        
        .product-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px; /* Slightly reduced */
        }
        
        .product-price {
            font-size: 20px;
            font-weight: 600;
            color: #4a90e2;
            margin-bottom: 12px; /* Slightly reduced */
        }
        
        .product-description {
            color: #ddd;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px; /* Reduced from 20px */
        }
        
        .product-meta {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .meta-item {
            display: flex;
            flex-direction: column;
            margin-right: 30px;
            margin-bottom: 0;
        }
        
        .meta-item span:first-child {
            color: #aaa;
            font-size: 13px;
            margin-bottom: 3px;
        }
        
        .meta-item span:last-child {
            font-size: 15px;
            font-weight: 600;
        }
        
        .aisle-highlight {
            color: #4a90e2;
        }
        
        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 10px; /* Reduced gap between buttons */
        }
        
        .quantity-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px; /* Reduced bottom margin */
        }
        
        .quantity-label {
            margin-right: 12px;
            font-size: 14px;
        }
        
        .quantity {
            display: flex;
            align-items: center;
            background-color: #263447;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .quantity-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #263447;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        #quantity {
            width: 36px;
            height: 36px;
            text-align: center;
            border: none;
            background-color: transparent;
            color: white;
            font-size: 16px;
        }
        
        .add-to-cart, .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .add-to-cart {
            background-color: #1F2937;
            color: white;
            border: 2px solid #4a90e2;
        }
        
        .back-button {
            background-color: #263447;
            color: white;
            border: 2px solid #263447;
        }
        
        .btn-text {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 2;
        }
        
        .cart-icon-btn, .shopping-icon {
            margin-right: 8px;
        }
        
        .btn-highlight, .btn-shopping-highlight {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(74,144,226,0.1), rgba(74,144,226,0.4));
            transition: all 0.5s ease;
            z-index: 1;
        }
        
        /* Search Modal Styles */
        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(20, 20, 20, 0.95);
            display: none;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding-top: 60px;
        }
        
        .close-search {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 30px;
            color: white;
            cursor: pointer;
            background: none;
            border: none;
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .search-container {
            width: 90%;
            max-width: 900px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .search-input {
            width: 100%;
            padding: 18px 50px 18px 20px;
            font-size: 18px;
            border: none;
            background-color: #2a2a2a;
            color: white;
            outline: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        
        .search-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #aaa;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .search-results {
            width: 100%;
            max-width: 900px;
            margin-top: 5px;
            overflow-y: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            border-radius: 8px;
            background-color: #2a2a2a;
            max-height: 70vh;
            display: none;
        }
        
        .search-result-item {
            display: flex;
            padding: 15px 20px;
            border-bottom: 1px solid #3a3a3a;
            transition: background-color 0.3s ease;
            cursor: pointer;
            align-items: center;
        }
        
        .search-result-item:hover {
            background-color: #333;
        }
        
        .search-result-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
            background-color: #333;
        }
        
        .search-result-details {
            flex: 1;
        }
        
        .search-result-title {
            font-weight: 500;
            margin-bottom: 5px;
            color: white;
        }
        
        .search-result-price {
            color: #aaa;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }
        
        .no-results {
            padding: 20px;
            text-align: center;
            color: #aaa;
        }
        
        /* Animation Keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Footer Styles */
        .footer-container {
            background-color: #1a1a1a !important;
            border-top: 1px solid #333;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            height: 40px; /* Explicitly set footer height */
            display: flex;
            align-items: center;
        }
        
        .footer-text {
            font-size: 14px;
            margin: 0;
            white-space: nowrap;
        }
        
        .payment-icon {
            width: 28px;
            height: auto;
            transition: transform 0.2s ease;
        }
        
        .payment-icon:hover {
            transform: translateY(-2px);
        }
        
        /* Responsive Footer Styles */
        @media (max-width: 768px) {
            .payment-icon {
                width: 25px;
            }
        }
        
        @media (max-width: 576px) {
            .footer-text {
                font-size: 12px;
            }
            
            .payment-icon {
                width: 20px;
            }
        }
        
        @media (max-width: 400px) {
            .footer-text {
                font-size: 11px;
            }
            
            .payment-icon {
                width: 18px;
            }
        }
        
        /* Styles for tablets and below - column layout */
        @media (max-width: 768px) {
            .product-detail-inner {
                flex-direction: column;
                max-width: 90%;
            }
            
            .product-image-container {
                width: 100%;
                padding: 15px;
                border-radius: 10px 10px 0 0;
                max-height: 250px;
            }
            
            .product-info {
                width: 100%;
                padding: 20px;
            }
            
            .product-container {
                padding: 10px 20px 40px 20px; /* Reduced bottom padding */
            }
            
            .product-description {
                max-height: 60px;
                overflow-y: auto;
            }
            
            .product-meta {
                margin-bottom: 15px;
                padding-bottom: 15px;
            }
            
            .meta-item {
                margin-right: 20px;
            }
            
            .quantity-container {
                margin-bottom: 10px;
            }
            
            /* Update animations for column layout */
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
        
        /* Small mobile styles */
        @media (max-width: 576px) {
            .product-detail-inner {
                max-width: 100%;
            }
            
            .product-image-container {
                padding: 10px;
                max-height: 200px;
            }
            
            .product-info {
                padding: 15px;
            }
            
            .product-title {
                font-size: 20px;
                margin-bottom: 8px;
            }
            
            .product-price {
                font-size: 18px;
                margin-bottom: 10px;
            }
            
            .product-description {
                font-size: 13px;
                line-height: 1.4;
                margin-bottom: 15px;
                max-height: 60px;
            }
            
            .product-container {
                padding: 10px 15px 40px 15px;
            }
            
            .product-meta {
                margin-bottom: 12px;
                padding-bottom: 12px;
            }
            
            .meta-item {
                margin-right: 15px;
            }
            
            .meta-item span:first-child {
                font-size: 12px;
            }
            
            .meta-item span:last-child {
                font-size: 14px;
            }
            
            .add-to-cart, .back-button {
                height: 36px;
            }
            
            .btn-text {
                font-size: 14px;
            }
            
            .product-detail {
                margin-bottom: 15px;
            }
        }
        
        .btn {
            padding: 8px 12px; /* Reduce button padding */
            font-size: 14px; /* Smaller font size */
        }
        
        .quantity-input {
            height: 34px; /* Slightly smaller input height */
            width: 40px; /* Slightly smaller width */
        }
        
        .quantity-btn {
            height: 34px; /* Match input height */
            width: 34px; /* Maintain square shape */
            font-size: 16px; /* Slightly smaller font size */
        }
    </style>
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
            <div class="cart-icon cart-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span class="cart-count">2</span>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <!-- Product Details Content -->
        <div class="product-container">
            <div class="product-header">
                <a href="categories.php" class="back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="back-icon">
                        <path d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Back to Categories
                </a>
                <span class="category-tag">Tools & Hardware</span>
            </div>
            <div class="product-detail">
                <div class="product-detail-inner">
                    <div class="product-image-container">
                        <img src="../assets/drill.png" alt="Professional Power Drill Set" class="product-image" loading="lazy">
                    </div>
                    <div class="product-info">
                        <div class="product-info-flex">
                            <div class="product-category">Tools & Hardware</div>
                            <h1 class="product-title">Professional Power Drill Set</h1>
                            <div class="product-price">₱ 150.00</div>
                            <div class="product-description">
                                This premium power drill set includes everything you need for professional results. Features a powerful motor, adjustable speed settings, and comes with a comprehensive set of bits for various applications.
                            </div>
                            <div class="product-meta">
                                <div class="meta-item">
                                    <span>Aisle</span>
                                    <span class="aisle-highlight">A7</span>
                                </div>
                                <div class="meta-item">
                                    <span>Row</span>
                                    <span>3</span>
                                </div>
                                <div class="meta-item">
                                    <span>Shelf</span>
                                    <span>B2</span>
                                </div>
                            </div>
                        </div>
                        <div class="product-actions">
                            <div class="quantity-container">
                                <div class="quantity-label">Quantity:</div>
                                <div class="quantity">
                                    <button class="quantity-btn minus">-</button>
                                    <input type="text" id="quantity" value="1" readonly>
                                    <button class="quantity-btn plus">+</button>
                                </div>
                            </div>
                            <button class="add-to-cart">
                                <span class="btn-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="cart-icon-btn">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    Add to Cart
                                </span>
                                <span class="btn-highlight"></span>
                            </button>
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
            
            <!-- Related Products Section - removed as requested -->
        </div>
    </div>
    
    <!-- Search Modal -->
    <div class="search-modal" id="searchModal">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
            <button class="search-btn" id="searchButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
        <div class="search-results" id="searchResults">
            <!-- Search results will be populated here -->
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cart functionality
        const cartCountDisplay = document.querySelector('.cart-count');
        
        // Initialize cart from localStorage or create empty cart
        let cart = JSON.parse(localStorage.getItem('touchfindCart')) || [];
        
        // Update cart count display on page load
        updateCartCount();
        
        // Back to Home functionality
        document.querySelector('.back-link').addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'categories.php';
        });
        
        // Add to cart functionality
        document.querySelector('.add-to-cart').addEventListener('click', function() {
            const productName = document.querySelector('.product-title').textContent;
            const productPrice = parseFloat(document.querySelector('.product-price').textContent.replace('₱', '').trim());
            const productImage = document.querySelector('.product-image').src;
            const quantity = parseInt(document.getElementById('quantity').value);
            const productCategory = document.querySelector('.product-category').textContent;
            
            // Check if product exists in cart
            const existingProductIndex = cart.findIndex(item => item.name === productName);
            
            if (existingProductIndex > -1) {
                // Update quantity if product already exists
                cart[existingProductIndex].quantity += quantity;
            } else {
                // Add new product to cart
                cart.push({
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: quantity,
                    category: productCategory
                });
            }
            
            // Save cart to localStorage
            localStorage.setItem('touchfindCart', JSON.stringify(cart));
            
            // Update cart count display
            updateCartCount();
            
            // Show added to cart notification
            showAddedToCartNotification(quantity);
        });
        
        // Function to update cart count
        function updateCartCount() {
            let totalItems = 0;
            cart.forEach(item => {
                totalItems += item.quantity;
            });
            cartCountDisplay.textContent = totalItems;
        }
        
        // Function to show added to cart notification
        function showAddedToCartNotification(quantity) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.position = 'fixed';
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.backgroundColor = '#4CAF50';
            notification.style.color = 'white';
            notification.style.padding = '15px 20px';
            notification.style.borderRadius = '5px';
            notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
            notification.style.zIndex = '1000';
            notification.style.transform = 'translateY(-20px)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.3s ease';
            notification.innerHTML = `<strong>${quantity} item${quantity > 1 ? 's' : ''}</strong> added to cart`;
            
            // Add to body
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.style.transform = 'translateY(0)';
                notification.style.opacity = '1';
            }, 10);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateY(-20px)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
        
        // Quantity buttons functionality
        const quantityInput = document.getElementById('quantity');
        const minusBtn = document.querySelector('.quantity-btn.minus');
        const plusBtn = document.querySelector('.quantity-btn.plus');
        
        // Prevent any direct input on the quantity field
        quantityInput.addEventListener('keydown', function(e) {
            e.preventDefault();
            return false;
        });
        
        minusBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value < 99) { // Adding a reasonable upper limit
                quantityInput.value = value + 1;
            }
        });
        
        // Navigate to cart when cart icon is clicked
        document.querySelector('.cart-icon').addEventListener('click', function() {
            window.location.href = 'cart.php';
        });
        
        // Back button functionality
        document.querySelector('.back-button').addEventListener('click', function() {
            window.history.back();
        });
        
        // Add hover effects for buttons
        const addToCartBtn = document.querySelector('.add-to-cart');
        const backButton = document.querySelector('.back-button');
        
        addToCartBtn.addEventListener('mouseenter', function() {
            const btnHighlight = this.querySelector('.btn-highlight');
            btnHighlight.style.left = '0';
        });
        
        addToCartBtn.addEventListener('mouseleave', function() {
            const btnHighlight = this.querySelector('.btn-highlight');
            btnHighlight.style.left = '-100%';
        });
        
        backButton.addEventListener('mouseenter', function() {
            const btnHighlight = this.querySelector('.btn-shopping-highlight');
            btnHighlight.style.left = '0';
        });
        
        backButton.addEventListener('mouseleave', function() {
            const btnHighlight = this.querySelector('.btn-shopping-highlight');
            btnHighlight.style.left = '-100%';
        });
        
        // Search Modal Functionality
        const searchIcon = document.getElementById('searchIcon');
        const searchModal = document.getElementById('searchModal');
        const closeSearch = document.getElementById('closeSearch');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const searchResults = document.getElementById('searchResults');

        // Sample product data (in a real app, this would come from a database)
        const products = [
            { id: 1, name: 'Professional Power Drill Set', price: '₱ 150.00', image: '../assets/drill.png' },
            { id: 2, name: 'Heavy Duty Tool Box', price: '₱ 150.00', image: '../assets/chainsaw.png' },
            { id: 3, name: 'Premium Paint Brush Set', price: '₱ 150.00', image: '../assets/chair.png' },
            { id: 4, name: 'Multi-Purpose Wrench Set', price: '₱ 150.00', image: '../assets/wrench.png' },
            { id: 5, name: 'Electric Circular Saw', price: '₱ 150.00', image: '../assets/circular-saw.png' },
            { id: 6, name: 'Professional Measuring Tape', price: '₱ 150.00', image: '../assets/measuring-tape.png' },
            { id: 7, name: 'Safety Work Gloves', price: '₱ 150.00', image: '../assets/gloves.png' },
            { id: 8, name: 'Premium Screwdriver Kit', price: '₱ 150.00', image: '../assets/screwdriver.png' }
        ];

        // Open search modal
        searchIcon.addEventListener('click', function() {
            searchModal.style.display = 'flex';
            setTimeout(() => {
                searchModal.style.opacity = '1';
                searchInput.focus();
            }, 10);
        });

        // Close search modal
        closeSearch.addEventListener('click', function() {
            searchModal.style.opacity = '0';
            setTimeout(() => {
                searchModal.style.display = 'none';
                searchResults.style.display = 'none';
            }, 300);
        });

        // Close modal when clicking outside the search container
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                searchModal.style.opacity = '0';
                setTimeout(() => {
                    searchModal.style.display = 'none';
                    searchResults.style.display = 'none';
                }, 300);
            }
        });

        // Display search results
        function performSearch() {
            const query = searchInput.value.toLowerCase().trim();
            
            if (query.length < 1) {
                searchResults.style.display = 'none';
                return;
            }

            // Filter products based on search query
            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(query)
            );

            // Display search results
            if (filteredProducts.length > 0) {
                searchResults.innerHTML = '';
                
                filteredProducts.forEach(product => {
                    const resultItem = document.createElement('div');
                    resultItem.className = 'search-result-item';
                    
                    resultItem.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" loading="lazy" class="search-result-image">
                        <div class="search-result-details">
                            <div class="search-result-title">${product.name}</div>
                            <div class="search-result-price">
                                <span>PRICE :</span>
                                <span>${product.price}</span>
                            </div>
                        </div>
                    `;
                    
                    resultItem.addEventListener('click', function() {
                        window.location.href = `product_details.php?id=${product.id}`;
                    });
                    
                    searchResults.appendChild(resultItem);
                });
            } else {
                searchResults.innerHTML = '<div class="no-results">No products found matching your search</div>';
            }
            
            searchResults.style.display = 'block';
        }

        // Search on button click
        searchButton.addEventListener('click', performSearch);

        // Search on enter key
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
            // Auto-search after typing
            if (searchInput.value.length >= 1) {
                performSearch();
            } else {
                searchResults.style.display = 'none';
            }
        });
    </script>   
    
    <?php include 'footer.php'; ?>
</body>
</html>