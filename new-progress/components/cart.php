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
    <link rel="stylesheet" href="../css/cart.css">
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
    <script src="../js/cart.js" defer></script>
</body>
</html>