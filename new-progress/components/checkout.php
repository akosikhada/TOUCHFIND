<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
            overflow-y: scroll;
        }
        
        html::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none; /* Chrome, Safari, Opera */
        }
        
        body {
            background-color: #1a1a1a;
            color: white;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }
        
        body::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        /* Header Styles */
        .header {
            background-color: #1a1a1a;
            padding: 15px 30px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
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
            margin-top: 60px; /* Height of header */
            min-height: calc(100vh - 100px); /* Adjusted to account for footer */
            padding-bottom: 0;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }
        
        .main-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        /* Checkout Container Styles */
        .checkout-container {
            flex: 1;
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 30px;
            width: 100%;
            overflow: hidden;
            box-sizing: border-box;
        }
        
        .checkout-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
            max-width: calc(100% - 390px);
            box-sizing: border-box;
            width: 100%;
        }
        
        .checkout-right {
            width: 360px;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
            flex-shrink: 0;
        }
        
        .section-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }
        
        .checkout-section {
            background-color: #1e293b;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            opacity: 0;
            width: 100%;
        }
        
        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            background-color: #263447;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            background-color: #2a3b50;
        }
        
        .payment-method.selected {
            border: 1px solid #3b82f6;
            background-color: #1e293b;
        }
        
        .payment-method-radio {
            width: 20px;
            height: 20px;
            margin-right: 15px;
            accent-color: #4a90e2;
        }
        
        .payment-method-icon {
            margin-right: 15px;
        }
        
        .payment-method-details {
            display: flex;
            flex-direction: column;
        }
        
        .payment-method-name {
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: 0.2px;
        }
        
        .payment-method-description {
            font-size: 14px;
            color: #aaa;
            letter-spacing: 0.1px;
        }
        
        .order-summary {
            background-color: #1e293b;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeInRight 0.6s ease forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: none;
            letter-spacing: 0.2px;
        }
        
        .summary-row span {
            max-width: 50%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .summary-row span:last-child {
            text-align: right;
        }
        
        .summary-row:nth-child(2) span:last-child {
            max-width: 170px;
        }
        
        .summary-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #333;
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 0.5px;
        }
        
        .order-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
            width: 100%;
        }
        
        .order-items::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none; /* Chrome, Safari, Opera */
        }
        
        .order-item {
            display: flex;
            background-color: #1e293b;
            border-radius: 8px;
            overflow: hidden;
            opacity: 0;
            align-items: stretch;
            height: 110px;
            max-width: 100%;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        
        .order-item-delay-1 {
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.5s;
        }
        
        .order-item-delay-2 {
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.6s;
        }
        
        .checkout-section-delay-1 {
            animation: fadeInLeft 0.6s ease forwards;
            animation-delay: 0.1s;
        }
        
        .checkout-section-delay-2 {
            animation: fadeInLeft 0.6s ease forwards;
            animation-delay: 0.3s;
            overflow: hidden;
        }
        
        .image-container {
            width: 120px;
            height: 110px;
            background-color: #1e293b;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            border-radius: 8px 0 0 8px;
            padding: 10px;
        }
        
        .order-item-image {
            width: 90%;
            height: 90%;
            object-fit: contain;
            object-position: center;
            display: block;
            padding: 0;
            margin: 0;
            border-radius: 8px;
        }
        
        .order-item-details {
            flex: 1;
            padding: 12px 15px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
            width: calc(100% - 120px);
            box-sizing: border-box;
            position: relative;
            border-radius: 0 8px 8px 0;
        }
        
        .order-item-title {
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
            font-size: 18px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            color: white;
        }
        
        .order-item-category {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 4px;
            letter-spacing: 0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .order-item-quantity {
            color: #94a3b8;
            font-size: 14px;
            letter-spacing: 0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .order-item-price {
            font-weight: 600;
            color: white;
            font-size: 18px;
            letter-spacing: 0.3px;
            position: absolute;
            bottom: 12px;
            right: 15px;
        }
        
        .place-order-btn {
            width: 100%;
            background-color: #1e293b;
            border: 1px solid #3b82f6;
            color: white;
            padding: 14px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }
        
        .btn-text {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.5px;
        }
        
        .btn-highlight {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(74,144,226,0.1), rgba(74,144,226,0.4));
            transition: all 0.5s ease;
            z-index: 1;
        }
        
        .return-link {
            display: inline-block;
            margin-top: 15px;
            color: #4a90e2;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            text-align: center;
            width: 100%;
            letter-spacing: 0.3px;
        }
        
        .return-link:hover {
            color: #63b3ed;
            text-decoration: none;
        }
        
        /* Animation Keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        footer {
            text-align: center;
            padding: 10px;
            color: #94a3b8;
            font-size: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 0;
            position: relative;
            bottom: 0;
            width: 100%;
            background-color: #1a1a1a;
        }
        
        @media (max-width: 992px) {
            .checkout-container {
                flex-direction: column;
            }
            
            .checkout-left {
                max-width: 100%;
            }
            
            .checkout-right {
                width: 100%;
            }
        }
        
        .checkout-left::-webkit-scrollbar, 
        .checkout-right::-webkit-scrollbar,
        .order-items::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none; /* Chrome, Safari, Opera */
        }
        
        .btn-icon {
            margin-right: 10px;
        }
        
        .footer-logo {
            height: 20px;
            margin-left: 10px;
            vertical-align: middle;
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
        <div class="checkout-container">
            <!-- Left Column -->
            <div class="checkout-left">
                <!-- Payment Method Section -->
                <div class="checkout-section checkout-section-delay-1">
                    <h2 class="section-title">Payment Method</h2>
                    <div class="payment-methods">
                        <div class="payment-method selected">
                            <input type="radio" name="payment" id="paypal" class="payment-method-radio" checked>
                            <div class="payment-method-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#4a90e2" viewBox="0 0 16 16">
                                    <path d="M14.06 3.713c.12-1.071-.093-1.832-.702-2.526C12.628.356 11.312 0 9.626 0H4.734a.7.7 0 0 0-.691.59L2.005 13.509a.42.42 0 0 0 .415.486h2.756l-.202 1.28a.628.628 0 0 0 .62.726H8.14c.429 0 .793-.31.862-.731l.025-.13.48-3.043.03-.164.001-.007a.351.351 0 0 1 .348-.297h.38c1.266 0 2.425-.256 3.345-.91.379-.27.712-.603.993-1.005a4.942 4.942 0 0 0 .88-2.195c.242-1.246.13-2.356-.57-3.154a2.687 2.687 0 0 0-.76-.59l-.094-.061Z"/>
                                </svg>
                            </div>
                            <div class="payment-method-details">
                                <div class="payment-method-name">Pay with PayPal</div>
                            </div>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment" id="cash" class="payment-method-radio">
                            <div class="payment-method-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#aaa" viewBox="0 0 16 16">
                                    <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                    <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V4zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2H3z"/>
                                </svg>
                            </div>
                            <div class="payment-method-details">
                                <div class="payment-method-name">Cash</div>
                                <div class="payment-method-description">Pay at the counter</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items Section -->
                <div class="checkout-section checkout-section-delay-2">
                    <h2 class="section-title">Order Items</h2>
                    <div class="order-items">
                        <div class="order-item order-item-delay-1">
                            <div class="image-container">
                                <img src="../assets/chair.png" alt="Boysen Paint" class="order-item-image">
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-title">Boysen 600</div>
                                <div class="order-item-category">Category: Paints</div>
                                <div class="order-item-quantity">Quantity: 3</div>
                                <div class="order-item-price">₱2,442.00</div>
                            </div>
                        </div>
                        
                        <div class="order-item order-item-delay-2">
                            <div class="image-container">
                                <img src="../assets/drill.png" alt="Hammer Tool" class="order-item-image">
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-title">Hammer</div>
                                <div class="order-item-category">Category: Tools</div>
                                <div class="order-item-quantity">Quantity: 3</div>
                                <div class="order-item-price">₱450.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="checkout-right">
                <div class="order-summary">
                    <h2 class="section-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>₱2,892.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>₱0.00</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>₱2,892.00</span>
                    </div>
                    
                    <button class="place-order-btn">
                        <span class="btn-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="btn-icon">
                                <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                            </svg>
                            Place Order
                        </span>
                        <span class="btn-highlight"></span>
                    </button>
                    
                    <a href="cart.php" class="return-link">Return to Cart</a>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        © 2025 TOUCHFIND. All Rights Reserved.
        <img src="../assets/paypal-logo.png" alt="PayPal" class="footer-logo">
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                // Remove selected class from all methods
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('selected');
                });
                
                // Add selected class to clicked method
                this.classList.add('selected');
                
                // Check the radio button
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
        
        // Place order button effect
        const placeOrderBtn = document.querySelector('.place-order-btn');
        const btnHighlight = document.querySelector('.btn-highlight');
        
        placeOrderBtn.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#1e293b';
            this.style.borderColor = '#60a5fa';
            this.style.boxShadow = '0 5px 15px rgba(59, 130, 246, 0.3)';
            btnHighlight.style.left = '0';
        });
        
        placeOrderBtn.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '#1e293b';
            this.style.borderColor = '#3b82f6';
            this.style.boxShadow = 'none';
            btnHighlight.style.left = '-100%';
        });
        
        // Apply animations with delay
        document.addEventListener('DOMContentLoaded', function() {
            // First animate payment section from left
            const paymentSection = document.querySelector('.checkout-section-delay-1');
            setTimeout(() => {
                paymentSection.style.opacity = '1';
            }, 100);
            
            // Then animate order items section from left
            const orderItemsSection = document.querySelector('.checkout-section-delay-2');
            setTimeout(() => {
                orderItemsSection.style.opacity = '1';
            }, 400);
            
            // Then animate order summary from right
            const orderSummary = document.querySelector('.order-summary');
            setTimeout(() => {
                orderSummary.style.opacity = '1';
            }, 700);
            
            // Finally animate the individual order items from bottom
            const orderItems = document.querySelectorAll('.order-item');
            orderItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                }, 900 + (index * 200));
            });
        });
        
        // Ensure all DOM elements are loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Navigate to cart when cart icon is clicked
            document.querySelector('.cart-icon').addEventListener('click', function() {
                window.location.href = 'cart.php';
            });
            
            // Form validation for checkout
            // ... existing code ...
        });
    </script>
</body>
</html>