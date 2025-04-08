<?php
// Include the database connection file
require 'db_connection.php';
session_start(); // Add session start at the top

// Handle Add to Cart action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // Check if product exists and has stock
    $checkSql = "SELECT product_id, product_stock FROM products WHERE product_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $productId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $product = $checkResult->fetch_assoc();
    
    if ($product && $product['product_stock'] > 0) {
        // Check if product already in cart
        $cartSql = "SELECT cart_id, quantity FROM cart WHERE product_id = ?";
        $cartStmt = $conn->prepare($cartSql);
        $cartStmt->bind_param("i", $productId);
        $cartStmt->execute();
        $cartResult = $cartStmt->get_result();
        $cartItem = $cartResult->fetch_assoc();
        
        if ($cartItem) {
            // Update quantity if already in cart
            $newQuantity = $cartItem['quantity'] + $quantity;
            $updateSql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ii", $newQuantity, $cartItem['cart_id']);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Add new item to cart
            $insertSql = "INSERT INTO cart (product_id, quantity, added_at) VALUES (?, ?, NOW())";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("ii", $productId, $quantity);
            $insertStmt->execute();
            $insertStmt->close();
        }
        
        $cartStmt->close();
        $_SESSION['cart_message'] = "Product added to cart successfully!";
    } else {
        $_SESSION['cart_message'] = "Product is out of stock or not available.";
    }
    
    $checkStmt->close();
}

// Get product details for display
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT p.product_id, p.product_name, p.product_description, p.product_price, p.product_stock, p.product_image, c.category_name 
        FROM products p JOIN categories c ON p.category_id = c.category_id 
        WHERE p.product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/view_product.css">
    <title>TouchFind | <?php echo htmlspecialchars($product['product_name']); ?></title>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/view_product.css">
    <title>TouchFind | <?php echo htmlspecialchars($product['product_name']); ?></title>
</head>
<body>
    <?php include ("header.php") ?>
    
    <main class="content-wrapper">
        <!-- X Button to return to main_panel.php -->
        <a href="main_panel.php" class="close-button">X</a>
        
        <?php if (isset($_SESSION['cart_message'])): ?>
            <div class="cart-message">
                <?php echo $_SESSION['cart_message']; ?>
                <?php unset($_SESSION['cart_message']); ?>
            </div>
        <?php endif; ?>
        
        <div class="product-details">
            <div class="product-image">
                <img src="images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($product['product_description']); ?></p>
                <p><strong>Stock:</strong> <?php echo $product['product_stock']; ?></p>
                <p><strong>Price:</strong> ₱<?php echo number_format($product['product_price'], 2); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                <div class="buttons">
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['product_stock']; ?>">
                        <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="buy-now">Buy Now</button>
                </div>
            </div>
        </div>
        <?php include ("footer.php") ?>
    </main>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>