<?php
// Include the database connection file
require 'db_connection.php';
session_start();

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_quantity'])) {
        $cartId = intval($_POST['cart_id']);
        $newQuantity = intval($_POST['quantity']);
        
        // Validate quantity (must be at least 1)
        if ($newQuantity > 0) {
            $updateSql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ii", $newQuantity, $cartId);
            $updateStmt->execute();
            $updateStmt->close();
            
            $_SESSION['cart_message'] = "Cart updated successfully!";
        } else {
            $_SESSION['cart_message'] = "Quantity must be at least 1.";
        }
    } elseif (isset($_POST['remove_item'])) {
        $cartId = intval($_POST['cart_id']);
        
        $deleteSql = "DELETE FROM cart WHERE cart_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $cartId);
        $deleteStmt->execute();
        $deleteStmt->close();
        
        $_SESSION['cart_message'] = "Item removed from cart.";
    }
    
    // Redirect to prevent form resubmission
    header("Location: cart.php");
    exit;
}

// Fetch cart items
$sql = "SELECT c.cart_id, c.quantity, c.added_at, 
               p.product_id, p.product_name, p.product_description, 
               p.product_price, p.product_stock, p.product_image,
               cat.category_name
        FROM cart c
        JOIN products p ON c.product_id = p.product_id
        JOIN categories cat ON p.category_id = cat.category_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $total = 0;
    $cartItems = array();
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = array(
            'cart_id' => $row['cart_id'],
            'product_id' => $row['product_id'],
            'product_name' => htmlspecialchars($row['product_name']),
            'category_name' => htmlspecialchars($row['category_name']),
            'product_description' => htmlspecialchars($row['product_description']),
            'product_price' => $row['product_price'],
            'product_stock' => $row['product_stock'],
            'product_image' => $row['product_image'],
            'quantity' => $row['quantity'],
            'added_at' => htmlspecialchars($row['added_at']),
            'subtotal' => $row['product_price'] * $row['quantity']
        );
        $total += $row['product_price'] * $row['quantity'];
    }
} else {
    $cartItems = array();
    $total = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/cart.css">
    <title>TouchFind | Cart</title>
</head>
<body>
    <?php include ("header.php") ?>
    <main class="content-wrapper">
        <div class="cart-container">
            <h1 class="cart-title">My Cart</h1>
            
            <?php if (isset($_SESSION['cart_message'])): ?>
                <div class="cart-message">
                    <?php echo $_SESSION['cart_message']; ?>
                    <?php unset($_SESSION['cart_message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($cartItems)): ?>
                <div class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <div class="product-image">
                                <img src="images/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo $item['product_name']; ?>">
                            </div>
                            <div class="cart-item-details">
                                <p class="category"><strong>Category:</strong> <?php echo $item['category_name']; ?></p>
                                <h3><?php echo $item['product_name']; ?></h3>
                                <p class="price"><strong>Price:</strong> ₱<?php echo number_format($item['product_price'], 2); ?></p>
                                <p class="stock "><strong>Available:</strong> <?php echo $item['product_stock']; ?></p>
                                <form method="post" class="remove-form">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                    <button type="submit" name="remove_item" class="remove-btn">Remove Item</button>
                                </form>
                            </div>
                            <div class="cart-item-quantity">
                                <form method="post">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                    <div class="quantity-controls">
                                        <button type="button" class="quantity-button minus" data-cart-id="<?php echo $item['cart_id']; ?>">-</button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['product_stock']; ?>" class="quantity-input">
                                        <button type="button" class="quantity-button plus" data-cart-id="<?php echo $item['cart_id']; ?>">+</button>
                                    </div>
                                    <button type="submit" name="update_quantity" class="update-btn">Update</button>
                                </form>
                            </div>
                            <div class="cart-item-subtotal">
                                <strong>Subtotal:</strong> ₱<?php echo number_format($item['subtotal'], 2); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <div class="cart-total">
                        <span>Total:</span>
                        <span class="total-amount">₱<?php echo number_format($total, 2); ?></span>
                    </div>
                    
                    <div class="cart-actions">
                        <a href="main_panel.php" class="continue-shopping">Continue Shopping</a>
                        <button class="checkout-btn">Proceed to Checkout</button>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <p>Your cart is empty.</p>
                    <a href="main_panel.php" class="continue-shopping">Browse Products</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include ("footer.php") ?>
    <script>
        // JavaScript for quantity controls
        document.querySelectorAll('.quantity-button').forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                const input = this.closest('.quantity-controls').querySelector('.quantity-input');
                let value = parseInt(input.value);
                
                if (this.classList.contains('minus')) {
                    value = Math.max(value - 1, 1);
                } else if (this.classList.contains('plus')) {
                    const max = parseInt(input.getAttribute('max'));
                    value = Math.min(value + 1, max);
                }
                
                input.value = value;
            });
        });
    </script>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>