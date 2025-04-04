<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Cart</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet">
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
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
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
            background-color: #121212;
            padding: 15px 30px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            background-color: #3b82f6;
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
            margin-top: 80px; 
            min-height: calc(100vh - 150px);
            padding-bottom: 0;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }
        
        .main-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        /* Cart Container Styles */
        .cart-container {
            flex: 1;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 30px;
            width: 100%;
            overflow: hidden;
            box-sizing: border-box;
        }
        
        .cart-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .cart-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .cart-count-display {
            margin-left: 15px;
            font-size: 16px;
            color: #94a3b8;
        }
        
        .cart-content {
            display: flex;
            gap: 30px;
            width: 100%;
        }
        
        .cart-items {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
        }
        
        .cart-item {
            display: flex;
            background-color: #1a1f2e;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            align-items: center;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            height: auto;
            min-height: 120px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            flex-wrap: wrap;
        }
        
        .cart-item.removing {
            display: none;
        }
        
        .cart-item-delay-1 {
            animation-delay: 0.1s;
        }
        
        .cart-item-delay-2 {
            animation-delay: 0.2s;
        }
        
        .image-container {
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            overflow: hidden;
            background-color: #111827;
            flex-shrink: 0;
            border-radius: 8px;
        }
        
        .cart-item-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            padding: 0;
            margin: 0;
            border-radius: 4px;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-category {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .cart-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .cart-available {
            color: #94a3b8;
            font-size: 14px;
        }
        
        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 20px;
            background-color: #1e293b;
            border-radius: 6px;
            padding: 2px;
        }
        
        .quantity-btn {
            width: 32px;
            height: 32px;
            background: #2a3449;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-input {
            width: 40px;
            background: transparent;
            border: none;
            color: white;
            font-size: 16px;
            text-align: center;
            font-weight: 600;
            appearance: none; /* Standard property */
            -webkit-appearance: none; /* Chrome, Safari, Edge */
            -moz-appearance: textfield; /* Firefox */
        }
        
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .cart-update-btn {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-left: 10px;
        }
        
        .subtotal-box {
            min-width: 120px;
            background-color: #111827;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        
        .subtotal-label {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 8px;
            text-align: center;
        }
        
        .subtotal-value {
            font-weight: 700;
            font-size: 24px;
            color: white;
        }
        
        .item-actions {
            display: flex;
            align-items: center;
            margin-left: auto;
            flex-wrap: nowrap;
        }
        
        .action-row {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }
        
        .remove-link {
            color: #ef4444;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            white-space: nowrap;
            margin-left: 15px;
        }
        
        .remove-link:hover {
            color: #f87171;
            text-decoration: underline;
        }
        
        .order-summary {
            background-color: #1e293b;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            height: fit-content;
            opacity: 0;
            animation: fadeInRight 0.6s ease forwards;
            animation-delay: 0.3s;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
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
        
        .summary-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #333;
            font-weight: 600;
            font-size: 18px;
            letter-spacing: 0.5px;
        }
        
        .section-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }
        
        .action-btn {
            width: 100%;
            background-color: #3b82f6;
            border: none;
            color: white;
            padding: 14px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
            font-size: 16px;
        }
        
        .action-btn:hover {
            background-color: #2563eb;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }
        
        .action-secondary {
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
            margin-top: 10px;
            font-size: 16px;
        }
        
        .action-secondary:hover {
            background-color: rgba(59, 130, 246, 0.1);
            border-color: #60a5fa;
        }
        
        .btn-text {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.5px;
            font-size: 16px;
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
        
        .btn-icon {
            margin-right: 10px;
        }
        
        .benefits-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding: 0 10px;
        }
        
        .benefit-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 30%;
        }
        
        .benefit-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            color: #3b82f6;
        }
        
        .benefit-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .benefit-text {
            color: #94a3b8;
            font-size: 14px;
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
        
        footer {
            text-align: center;
            padding: 10px;
            color: #94a3b8;
            font-size: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
            position: relative;
            bottom: 0;
            width: 100%;
            background-color: #121212;
        }
        
        .payment-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .payment-icon {
            height: 20px;
            filter: grayscale(100%);
            opacity: 0.7;
        }
        
        @media (max-width: 992px) {
            .cart-content {
                flex-direction: column;
            }
            
            .order-summary {
                width: 100%;
                margin-top: 20px;
            }
            
            .cart-container {
                padding: 20px 15px;
            }
            
            .item-actions {
                flex-wrap: wrap;
                margin-top: 15px;
                width: 100%;
                justify-content: space-between;
            }
            
            .action-row {
                margin-right: 0;
            }
        }
        
        @media (max-width: 768px) {
            .cart-container {
                padding: 15px 10px;
            }
            
            .cart-title {
                font-size: 20px;
            }
            
            .section-title {
                font-size: 20px;
            }
            
            .cart-item {
                padding: 15px;
            }
            
            .cart-item-details {
                margin-bottom: 10px;
            }
            
            .image-container {
                width: 80px;
                height: 80px;
            }
            
            .subtotal-box {
                min-width: 100px;
                padding: 10px;
            }
            
            .subtotal-value {
                font-size: 20px;
            }
            
            .quantity-controls {
                margin: 0 10px;
            }
        }
        
        @media (max-width: 576px) {
            .header {
                padding: 10px 15px;
                height: 50px;
            }
            
            .brand {
                font-size: 20px;
            }
            
            .main-container {
                margin-top: 60px;
            }
            
            .cart-container {
                padding: 10px;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }
            
            .image-container {
                width: 100%;
                height: 150px;
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .cart-item-image {
                width: auto;
                height: 100%;
                max-width: 100%;
            }
            
            .cart-item-details {
                width: 100%;
                margin-bottom: 15px;
            }
            
            .item-actions {
                width: 100%;
                flex-direction: column;
                margin-left: 0;
            }
            
            .action-row {
                width: 100%;
                justify-content: space-between;
                margin-bottom: 15px;
                margin-right: 0;
            }
            
            .subtotal-box {
                width: 100%;
                margin-top: 0;
            }
            
            .quantity-controls {
                margin: 0;
            }
            
            .remove-link {
                margin-left: auto;
            }
            
            .payment-methods-container {
                padding: 15px;
            }
            
            .payment-method {
                padding: 10px;
            }
            
            .payment-method-name {
                font-size: 14px;
            }
            
            .payment-method-description {
                font-size: 12px;
            }
        }
        
        /* Helper class for mobile layout */
        @media (max-width: 576px) {
            .item-actions {
                display: flex;
                flex-wrap: wrap;
                width: 100%;
            }
            
            .action-row {
                display: flex;
                justify-content: space-between;
                width: 100%;
                align-items: center;
                margin-bottom: 10px;
            }
            
            .action-row:last-child {
                margin-bottom: 0;
            }
        }
        
        /* Payment Methods Section */
        .payment-methods-container {
            background-color: #1e293b;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            width: 100%;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            animation-delay: 0.3s;
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
            color: #94a3b8;
            letter-spacing: 0.1px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <!-- Icons removed from cart page -->
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <div class="cart-container">
            <div class="cart-header">
                <h1 class="cart-title">2 items in your cart</h1>
            </div>
            
            <div class="cart-content">
                <div class="cart-items">
                    <div class="cart-item cart-item-delay-1" data-price="814.00">
                        <div class="image-container">
                            <img src="../assets/chair.png" alt="Boysen Paint" class="cart-item-image">
                        </div>
                        <div class="cart-item-details">
                            <div class="cart-category">Category: Paints</div>
                            <div class="cart-title">Boysen 600</div>
                            <div class="cart-available">Available: In Stock</div>
                        </div>
                        <div class="item-actions">
                            <div class="action-row">
                                <div class="quantity-controls">
                                    <button class="quantity-btn minus" onclick="decrementQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="3" min="1" max="99" readonly>
                                    <button class="quantity-btn plus" onclick="incrementQuantity(this)">+</button>
                                </div>
                                <a class="remove-link" data-id="0" onclick="removeCartItem(0)">Remove</a>
                            </div>
                            <div class="subtotal-box">
                                <div class="subtotal-label">Subtotal</div>
                                <div class="subtotal-value">2,442.00</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-item cart-item-delay-2" data-price="150.00">
                        <div class="image-container">
                            <img src="../assets/chair.png" alt="Hammer Tool" class="cart-item-image">
                        </div>
                        <div class="cart-item-details">
                            <div class="cart-category">Category: Tools</div>
                            <div class="cart-title">Hammer</div>
                            <div class="cart-available">Available: 50</div>
                        </div>
                        <div class="item-actions">
                            <div class="action-row">
                                <div class="quantity-controls">
                                    <button class="quantity-btn minus" onclick="decrementQuantity(this)">-</button>
                                    <input type="number" class="quantity-input" value="3" min="1" max="99" readonly>
                                    <button class="quantity-btn plus" onclick="incrementQuantity(this)">+</button>
                                </div>
                                <a class="remove-link" data-id="1" onclick="removeCartItem(1)">Remove</a>
                            </div>
                            <div class="subtotal-box">
                                <div class="subtotal-label">Subtotal</div>
                                <div class="subtotal-value">450.00</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Methods Section -->
                    <div class="payment-methods-container">
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
                                    <div class="payment-method-name">Cash on Delivery</div>
                                    <div class="payment-method-description">Pay when you receive</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h2 class="section-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>₱2,892.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>₱50.00</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>₱2,942.00</span>
                    </div>
                    
                    <button class="action-btn" id="checkout-button">
                        <span class="btn-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="btn-icon">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            Proceed to Checkout
                        </span>
                        <span class="btn-highlight"></span>
                    </button>
                    
                    <button class="action-secondary">
                        <span class="btn-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="btn-icon">
                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                            </svg>
                            Continue Shopping
                        </span>
                        <span class="btn-highlight"></span>
                    </button>
                </div>
            </div>
            
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    
    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load cart items from localStorage on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Get cart data from localStorage
            const cart = JSON.parse(localStorage.getItem('touchfindCart')) || [];
            const cartItemsContainer = document.querySelector('.cart-items');
            const cartItemElements = document.querySelectorAll('.cart-item');
            
            // If there are items in localStorage and cart has default items
            if (cart.length > 0 && cartItemElements.length > 0) {
                // Remove default cart items
                cartItemElements.forEach(item => {
                    item.remove();
                });
                
                // Add items from localStorage
                cart.forEach((item, index) => {
                    const delay = index === 0 ? 'cart-item-delay-1' : 'cart-item-delay-2';
                    const subtotal = (item.price * item.quantity).toFixed(2);
                    
                    const itemElement = document.createElement('div');
                    itemElement.className = `cart-item ${delay}`;
                    itemElement.setAttribute('data-price', item.price.toFixed(2));
                    
                    itemElement.innerHTML = `
                        <div class="image-container">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        </div>
                        <div class="cart-item-details">
                            <div class="cart-category">Category: ${item.category}</div>
                            <div class="cart-title">${item.name}</div>
                            <div class="cart-available">Available: 50</div>
                        </div>
                        <div class="item-actions">
                            <div class="action-row">
                                <div class="quantity-controls">
                                    <button class="quantity-btn minus" data-id="${index}" onclick="decrementQuantity(this)">-</button>
                                    <input type="text" class="quantity-input" value="${item.quantity}" data-id="${index}" readonly>
                                    <button class="quantity-btn plus" data-id="${index}" onclick="incrementQuantity(this)">+</button>
                                </div>
                                <a class="remove-link" data-id="${index}" onclick="removeCartItem('${index}')">Remove</a>
                            </div>
                            <div class="subtotal-box">
                                <div class="subtotal-label">Subtotal</div>
                                <div class="subtotal-value">${subtotal}</div>
                            </div>
                        </div>
                    `;
                    
                    // Insert before payment methods section
                    const paymentMethodsContainer = document.querySelector('.payment-methods-container');
                    cartItemsContainer.insertBefore(itemElement, paymentMethodsContainer);
                });
                
                // Update cart count display
                updateCartCount();
                
                // Update total price
                updateTotalPrice();
                
                // Attach event listeners to quantity buttons
                attachQuantityButtonListeners();
                
                // Attach event listeners for remove links
                attachRemoveItemListeners();
            }
        });
        
        // Function to attach quantity button listeners
        function attachQuantityButtonListeners() {
            document.querySelectorAll('.minus').forEach(button => {
                button.addEventListener('click', function() {
                    const quantityInput = this.parentNode.querySelector('.quantity-input');
                    let value = parseInt(quantityInput.value);
                    if (value > 1) {
                        quantityInput.value = value - 1;
                        updateItemSubtotal(this);
                        showNotification("Quantity updated");
                    }
                });
            });

            document.querySelectorAll('.plus').forEach(button => {
                button.addEventListener('click', function() {
                    const quantityInput = this.parentNode.querySelector('.quantity-input');
                    let value = parseInt(quantityInput.value);
                    if (value < 99) { // Adding a reasonable upper limit
                        quantityInput.value = value + 1;
                        updateItemSubtotal(this);
                        showNotification("Quantity updated");
                    }
                });
            });
        }

        // Function to attach remove item listeners
        function attachRemoveItemListeners() {
            document.querySelectorAll('.remove-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = parseInt(this.getAttribute('data-id'));
                    removeCartItem(productId);
                });
            });
        }
        
        // Update localStorage when cart is updated
        function updateCartInLocalStorage() {
            const cartItems = document.querySelectorAll('.cart-item');
            const cart = [];
            
            cartItems.forEach(item => {
                const name = item.querySelector('.cart-title').textContent;
                const category = item.querySelector('.cart-category').textContent.replace('Category: ', '');
                const price = parseFloat(item.getAttribute('data-price'));
                const quantity = parseInt(item.querySelector('.quantity-input').value);
                const image = item.querySelector('.cart-item-image').src;
                
                cart.push({
                    name,
                    category,
                    price,
                    quantity,
                    image
                });
            });
            
            localStorage.setItem('touchfindCart', JSON.stringify(cart));
        }
        
        function showUpdateNotification() {
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
            notification.innerHTML = 'Cart updated successfully';
            
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
        
        function updateItemSubtotal(btn) {
            const item = btn.closest('.cart-item');
            const price = parseFloat(item.getAttribute('data-price'));
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            const subtotal = price * quantity;
            
            // Update the subtotal display
            item.querySelector('.subtotal-value').textContent = subtotal.toFixed(2);
            
            // Update cart in localStorage
            updateCartInLocalStorage();
            
            // Update the order summary
            updateTotalPrice();
        }
        
        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.subtotal-value').forEach(el => {
                const subtotal = parseFloat(el.textContent.replace(',', ''));
                total += subtotal;
            });
            
            // Fixed tax cost
            const tax = 50;
            
            // Update the subtotal
            document.querySelector('.summary-row:first-child span:last-child').textContent = `₱${total.toFixed(2)}`;
            
            // Calculate final total with tax
            const finalTotal = total + tax;
            
            // Update the total
            document.querySelector('.summary-row.total span:last-child').textContent = `₱${finalTotal.toFixed(2)}`;
        }
        
        function updateCartCount() {
            const count = document.querySelectorAll('.cart-item').length;
            document.querySelector('.cart-count').textContent = count;
            document.querySelector('.cart-title').textContent = `${count} items in your cart`;
        }
        
        // Animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cart items
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                }, 100 + (index * 200));
            });
            
            // Animate order summary
            const orderSummary = document.querySelector('.order-summary');
            setTimeout(() => {
                orderSummary.style.opacity = '1';
            }, 400);
        });
        
        // Button effects
        const primaryBtn = document.querySelector('.action-btn');
        const secondaryBtn = document.querySelector('.action-secondary');
        
        primaryBtn.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#2563eb';
            this.style.boxShadow = '0 5px 15px rgba(59, 130, 246, 0.3)';
            this.querySelector('.btn-highlight').style.left = '0';
        });
        
        primaryBtn.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '#3b82f6';
            this.style.boxShadow = 'none';
            this.querySelector('.btn-highlight').style.left = '-100%';
        });
        
        secondaryBtn.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#1e293b';
            this.style.borderColor = '#60a5fa';
            this.style.boxShadow = '0 5px 15px rgba(59, 130, 246, 0.3)';
            this.querySelector('.btn-highlight').style.left = '0';
        });
        
        secondaryBtn.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '#1e293b';
            this.style.borderColor = '#3b82f6';
            this.style.boxShadow = 'none';
            this.querySelector('.btn-highlight').style.left = '-100%';
        });
        
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
        
        // Proceed to checkout button functionality
        document.getElementById('checkout-button').addEventListener('click', function() {
            window.location.href = 'checkout.php';
        });
        
        // Continue shopping button functionality
        document.querySelector('.action-secondary').addEventListener('click', function() {
            window.location.href = 'categories.php';
        });

        // Function to update cart item quantity
        function updateCartItemQuantity(productId, newQuantity) {
            // Get cart from localStorage
            let cart = JSON.parse(localStorage.getItem('touchfindCart')) || [];
            
            // Find the cart item index
            const itemIndex = parseInt(productId);
            
            if (itemIndex >= 0 && itemIndex < cart.length) {
                // Update quantity
                cart[itemIndex].quantity = newQuantity;
                
                // Save updated cart to localStorage
                localStorage.setItem('touchfindCart', JSON.stringify(cart));
                
                // Update subtotal
                updateSubtotal(itemIndex, newQuantity);
                
                // Update total
                updateTotalPrice();
            }
        }

        // Function to update subtotal for an item
        function updateSubtotal(itemIndex, quantity) {
            let cart = JSON.parse(localStorage.getItem('touchfindCart')) || [];
            if (itemIndex >= 0 && itemIndex < cart.length) {
                const price = cart[itemIndex].price;
                const subtotal = price * quantity;
                
                // Update subtotal display
                const subtotalElement = document.querySelector(`.subtotal[data-id="${itemIndex}"]`);
                if (subtotalElement) {
                    subtotalElement.textContent = `${subtotal.toFixed(2)}`;
                }
            }
        }

        // Function to remove cart item
        function removeCartItem(productId) {
            // Get cart from localStorage
            let cart = JSON.parse(localStorage.getItem('touchfindCart')) || [];
            
            // Find the item element
            const itemElement = document.querySelector(`.cart-item .remove-link[data-id="${productId}"]`).closest('.cart-item');
            
            if (itemElement) {
                // Remove the item immediately
                itemElement.remove();
                
                // Remove from cart array
                cart.splice(productId, 1);
                
                // Save updated cart to localStorage
                localStorage.setItem('touchfindCart', JSON.stringify(cart));
                
                // Update cart count
                updateCartCount();
                
                // Update total price
                updateTotalPrice();
                
                // Refresh the page if cart is empty
                if (cart.length === 0) {
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            }
        }

        // Function to show a notification
        function showNotification(message) {
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
            notification.innerHTML = message;
            
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

        // Direct increment and decrement functions for onclick handlers
        function incrementQuantity(button) {
            const quantityInput = button.parentNode.querySelector('.quantity-input');
            let value = parseInt(quantityInput.value);
            if (value < 99) {
                quantityInput.value = value + 1;
                updateItemSubtotal(button);
                showNotification("Quantity updated");
            }
        }

        function decrementQuantity(button) {
            const quantityInput = button.parentNode.querySelector('.quantity-input');
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
                updateItemSubtotal(button);
                showNotification("Quantity updated");
            }
        }
    </script>
</body>
</html>