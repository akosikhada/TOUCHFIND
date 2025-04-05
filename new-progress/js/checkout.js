// Payment method selection
document.querySelectorAll(".payment-method").forEach((method) => {
  method.addEventListener("click", function () {
    // Remove selected class from all methods
    document.querySelectorAll(".payment-method").forEach((m) => {
      m.classList.remove("selected");
    });

    // Add selected class to clicked method
    this.classList.add("selected");

    // Check the radio button
    this.querySelector('input[type="radio"]').checked = true;
  });
});

// Place order button effect
const placeOrderBtn = document.querySelector(".place-order-btn");
const btnHighlight = document.querySelector(".btn-highlight");

placeOrderBtn.addEventListener("mouseenter", function () {
  this.style.backgroundColor = "#1e293b";
  this.style.borderColor = "#60a5fa";
  this.style.boxShadow = "0 5px 15px rgba(59, 130, 246, 0.3)";
  btnHighlight.style.left = "0";
});

placeOrderBtn.addEventListener("mouseleave", function () {
  this.style.backgroundColor = "#1e293b";
  this.style.borderColor = "#3b82f6";
  this.style.boxShadow = "none";
  btnHighlight.style.left = "-100%";
});

// Add click handler for place order button
placeOrderBtn.addEventListener("click", function () {
  // Generate a random order ID
  const year = new Date().getFullYear();
  const randomNum = Math.floor(1000 + Math.random() * 9000);
  const orderId = `ORD-${year}-${randomNum}`;

  // Redirect to success page with order ID
  window.location.href = `success.php?order_id=${orderId}`;
});

// Apply animations with delay
document.addEventListener("DOMContentLoaded", function () {
  // First animate payment section from left
  const paymentSection = document.querySelector(".checkout-section-delay-1");
  setTimeout(() => {
    paymentSection.style.opacity = "1";
  }, 100);

  // Then animate order items section from left
  const orderItemsSection = document.querySelector(".checkout-section-delay-2");
  setTimeout(() => {
    orderItemsSection.style.opacity = "1";
  }, 400);

  // Then animate order summary from right
  const orderSummary = document.querySelector(".order-summary");
  setTimeout(() => {
    orderSummary.style.opacity = "1";
  }, 700);

  // Finally animate the individual order items from bottom
  const orderItems = document.querySelectorAll(".order-item");
  orderItems.forEach((item, index) => {
    setTimeout(() => {
      item.style.opacity = "1";
    }, 900 + index * 200);
  });
});

// Ensure all DOM elements are loaded
document.addEventListener("DOMContentLoaded", function () {
  // Navigate to cart when cart icon is clicked
  document.querySelector(".cart-icon").addEventListener("click", function () {
    window.location.href = "cart.php";
  });

  // Form validation for checkout
  // ... existing code ...
});
