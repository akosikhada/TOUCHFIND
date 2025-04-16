<?php
require 'db_connection.php';
session_start();

// Fetch items from cart
$sql = "SELECT cart.*, categories.category_name 
        FROM cart
        LEFT JOIN categories ON cart.category_id = categories.category_id
        ORDER BY added_at DESC";
$result = $conn->query($sql);

$items = [];
$subtotal = 0;
$tax = 50;
$total = 0;
$paymentMethod = 'Cash'; // Default

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $subtotal += $row['sub_total'];
}

$total = $subtotal + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Checkout</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/checkout.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="brand">TOUCHFIND</div>
    </div>

    <div class="main-container">
        <div class="checkout-container">
            <!-- Left Column -->
            <div class="checkout-left">
                <div class="checkout-section checkout-section-delay-2">
                    <h2 class="section-title">Order Items</h2>
                    <div class="order-items">
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                                <div class="order-item">
                                    <div class="image-container">
                                        <img src="../admin/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="order-item-image">
                                    </div>
                                    <div class="order-item-details">
                                        <div class="order-item-title"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                        <div class="order-item-category">Category: <?php echo htmlspecialchars($item['category_name']); ?></div>
                                        <div class="order-item-quantity">Quantity: <?php echo $item['quantity']; ?></div>
                                        <div class="order-item-price">₱<?php echo number_format($item['sub_total'], 2); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No items found in your cart.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="checkout-right">
                <div class="order-summary">
                    <h2 class="section-title">Order Summary</h2>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>₱<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>₱<?php echo number_format($tax, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Payment Method</span>
                        <span><?php echo htmlspecialchars($paymentMethod); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>₱<?php echo number_format($total, 2); ?></span>
                    </div>

                    <?php if (!empty($items)): ?>
                    <form action="process_checkout.php" method="post">
                        <button class="place-order-btn" type="submit">
                            <span class="btn-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" class="btn-icon">
                                    <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                                </svg>
                                Place Order
                            </span>
                            <span class="btn-highlight"></span>
                        </button>
                    </form>
                    <?php else: ?>
                        <p class="text-danger mt-3">You haven't added any products yet. <a href="categories.php">Browse products</a></p>
                    <?php endif; ?>

                    <a href="cart.php" class="return-link">Return to Cart</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/checkout.js" defer></script>
</body>
</html>