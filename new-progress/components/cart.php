<?php
require 'db_connection.php';
session_start();

// Fetch all items from `cart` table
$sql = "SELECT cart.*, categories.category_name 
        FROM cart
        LEFT JOIN categories ON cart.category_id = categories.category_id
        ORDER BY added_at DESC";
$result = $conn->query($sql);

// Calculate totals
$items = [];
$subtotal = 0;
$tax = 50;
$total = 0;

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
    <title>TOUCHFIND | Cart</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
    <div class="header">
        <div class="brand">TOUCHFIND</div>
    </div>

    <div class="main-container">
        <div class="cart-container">
            <div class="cart-header">
                <h1 class="cart-title"><?php echo count($items); ?> item(s) in your cart</h1>
            </div>

            <div class="cart-content">
                <div class="cart-items">
                    <?php foreach ($items as $index => $item): ?>
                        <div class="cart-item cart-item-delay-<?php echo ($index % 2) + 1; ?>" data-price="<?php echo number_format($item['product_price'], 2); ?>">
                            <div class="image-container">
                                <img src="../admin/<?php echo htmlspecialchars($item['product_image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="cart-item-image">
                            </div>
                            <div class="cart-item-details">
                                <div class="cart-category">Category: <?php echo htmlspecialchars($item['category_name']); ?></div>
                                <div class="cart-title"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                <div class="cart-available">Available: <?php echo htmlspecialchars($item['product_stock']); ?></div>
                            </div>
                            <div class="item-actions">
                                <div class="action-row">
                                    <div class="quantity-controls">
                                        <button class="quantity-btn minus" onclick="decrementQuantity(this)">-</button>
                                        <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" readonly>
                                        <button class="quantity-btn plus" onclick="incrementQuantity(this)">+</button>
                                    </div>
                                    <a class="remove-link" href="remove_cart_item.php?id=<?php echo $item['cart_id']; ?>">Remove</a>
                                </div>
                                <div class="subtotal-box">
                                    <div class="subtotal-label">Subtotal</div>
                                    <div class="subtotal-value">₱<?php echo number_format($item['sub_total'], 2); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Payment Methods -->
                    <div class="payment-methods-container">
                        <h2 class="section-title">Payment Method</h2>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" name="payment" id="paypal" class="payment-method-radio">
                                <div class="payment-method-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#aaa" class="bi bi-paypal" viewBox="0 0 16 16">
                                        <path d="M14.06 3.713c.12-1.071-.093-1.832-.702-2.526C12.628.356 11.312 0 9.626 0H4.734a.7.7 0 0 0-.691.59L2.005 13.509a.42.42 0 0 0 .415.486h2.756l-.202 1.28a.628.628 0 0 0 .62.726H8.14c.429 0 .793-.31.862-.731l.025-.13.48-3.043.03-.164.001-.007a.35.35 0 0 1 .348-.297h.38c1.266 0 2.425-.256 3.345-.91q.57-.403.993-1.005a4.94 4.94 0 0 0 .88-2.195c.242-1.246.13-2.356-.57-3.154a2.7 2.7 0 0 0-.76-.59l-.094-.061ZM6.543 8.82a.7.7 0 0 1 .321-.079H8.3c2.82 0 5.027-1.144 5.672-4.456l.003-.016q.326.186.548.438c.546.623.679 1.535.45 2.71-.272 1.397-.866 2.307-1.663 2.874-.802.57-1.842.815-3.043.815h-.38a.87.87 0 0 0-.863.734l-.03.164-.48 3.043-.024.13-.001.004a.35.35 0 0 1-.348.296H5.595a.106.106 0 0 1-.105-.123l.208-1.32z"/>
                                    </svg>
                                </div>
                                <div class="payment-method-details">
                                <div class="payment-method-name">Pay with PayPal</div>
                                </div>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="payment" id="cash" class="payment-method-radio">
                                <div class="payment-method-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#aaa" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                        <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                        <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/>
                                    </svg>
                                </div>
                                <div class="payment-method-details">
                                <div class="payment-method-name">Cash</div>
                                <div class="payment-method-description">Pay on counter</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
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
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>₱<?php echo number_format($total, 2); ?></span>
                    </div>

                    <button class="action-btn" id="checkout-button">Proceed to Checkout</button>
                    <button class="action-secondary" onclick="window.location.href='categories.php'">Continue Shopping</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll(".payment-method").forEach((method) => {
            method.addEventListener("click", function () {
                // Remove from all
                document.querySelectorAll(".payment-method").forEach((m) => {
                m.classList.remove("selected");
                m.querySelector(".payment-method-radio").checked = false;
                const label = m.querySelector(".payment-selected-label");
                if (label) label.style.display = "none";
                });

                // Add to clicked one
                this.classList.add("selected");
                const radio = this.querySelector(".payment-method-radio");
                if (radio) radio.checked = true;

                const selectedLabel = this.querySelector(".payment-selected-label");
                if (selectedLabel) selectedLabel.style.display = "block";
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const updateSubtotal = (container) => {
                const price = parseFloat(container.getAttribute("data-price"));
                const quantity = parseInt(container.querySelector(".quantity-input").value);
                const subtotal = (price * quantity).toFixed(2);
                container.querySelector(".subtotal-value").textContent = `₱${subtotal}`;
                updateTotal();
            };

            const updateTotal = () => {
                let total = 0;
                document.querySelectorAll(".subtotal-value").forEach((el) => {
                const num = parseFloat(el.textContent.replace("₱", "").replace(",", ""));
                total += num;
                });

                const tax = 50;
                const finalTotal = total + tax;
                document.querySelector(".summary-row:first-child span:last-child").textContent = `₱${total.toFixed(2)}`;
                document.querySelector(".summary-row.total span:last-child").textContent = `₱${finalTotal.toFixed(2)}`;
            };

            document.querySelectorAll(".quantity-btn.plus").forEach((btn) => {
                btn.addEventListener("click", () => {
                const input = btn.parentElement.querySelector(".quantity-input");
                let val = parseInt(input.value);
                if (val < 99) {
                    input.value = val + 1;
                    updateSubtotal(btn.closest(".cart-item"));
                }
                });
            });

            document.querySelectorAll(".quantity-btn.minus").forEach((btn) => {
                btn.addEventListener("click", () => {
                const input = btn.parentElement.querySelector(".quantity-input");
                let val = parseInt(input.value);
                if (val > 1) {
                    input.value = val - 1;
                    updateSubtotal(btn.closest(".cart-item"));
                }
                });
            });
            updateTotal();
        });
    </script>

</body>
</html>
