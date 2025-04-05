<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/checkout.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <!-- Icons removed from checkout page -->
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
    
    <?php include 'footer.php'; ?>
    
    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/checkout.js" defer></script>
</body>
</html>