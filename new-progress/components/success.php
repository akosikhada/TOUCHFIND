<?php
// Generate a random order number if not provided in URL
$orderNumber = isset($_GET['order_id']) ? $_GET['order_id'] : 'ORD-' . date('Y') . '-' . rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TOUCHFIND | Order Confirmed</title>
    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/success.css" rel="stylesheet">
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
            </svg>
        </div>
        
        <h1>Order Confirmed!</h1>
        
        <div class="order-number-box">
            <div class="order-number-label">Order Number</div>
            <div class="order-number">#<?php echo $orderNumber; ?></div>
        </div>
        
        <div class="thank-you">Thank you for your purchase!</div>
        
        <div class="footer">© 2024 TOUCHFIND. All rights reserved.</div>
    </div>
    
    <script src="../js/success.js" defer></script>
</body>
</html>