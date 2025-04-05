// Load cart items from localStorage on page load
document.addEventListener("DOMContentLoaded", function () {
  // Get cart data from localStorage
  const cart = JSON.parse(localStorage.getItem("touchfindCart")) || [];
  const cartItemsContainer = document.querySelector(".cart-items");
  const cartItemElements = document.querySelectorAll(".cart-item");

  // If there are items in localStorage and cart has default items
  if (cart.length > 0 && cartItemElements.length > 0) {
    // Remove default cart items
    cartItemElements.forEach((item) => {
      item.remove();
    });

    // Add items from localStorage
    cart.forEach((item, index) => {
      const delay = index === 0 ? "cart-item-delay-1" : "cart-item-delay-2";
      const subtotal = (item.price * item.quantity).toFixed(2);

      const itemElement = document.createElement("div");
      itemElement.className = `cart-item ${delay}`;
      itemElement.setAttribute("data-price", item.price.toFixed(2));

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
      const paymentMethodsContainer = document.querySelector(
        ".payment-methods-container"
      );
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
  document.querySelectorAll(".minus").forEach((button) => {
    button.addEventListener("click", function () {
      const quantityInput = this.parentNode.querySelector(".quantity-input");
      let value = parseInt(quantityInput.value);
      if (value > 1) {
        quantityInput.value = value - 1;
        updateItemSubtotal(this);
        showNotification("Quantity updated");
      }
    });
  });

  document.querySelectorAll(".plus").forEach((button) => {
    button.addEventListener("click", function () {
      const quantityInput = this.parentNode.querySelector(".quantity-input");
      let value = parseInt(quantityInput.value);
      if (value < 99) {
        // Adding a reasonable upper limit
        quantityInput.value = value + 1;
        updateItemSubtotal(this);
        showNotification("Quantity updated");
      }
    });
  });
}

// Function to attach remove item listeners
function attachRemoveItemListeners() {
  document.querySelectorAll(".remove-link").forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const productId = parseInt(this.getAttribute("data-id"));
      removeCartItem(productId);
    });
  });
}

// Update localStorage when cart is updated
function updateCartInLocalStorage() {
  const cartItems = document.querySelectorAll(".cart-item");
  const cart = [];

  cartItems.forEach((item) => {
    const name = item.querySelector(".cart-title").textContent;
    const category = item
      .querySelector(".cart-category")
      .textContent.replace("Category: ", "");
    const price = parseFloat(item.getAttribute("data-price"));
    const quantity = parseInt(item.querySelector(".quantity-input").value);
    const image = item.querySelector(".cart-item-image").src;

    cart.push({
      name,
      category,
      price,
      quantity,
      image,
    });
  });

  localStorage.setItem("touchfindCart", JSON.stringify(cart));
}

function showUpdateNotification() {
  // Create notification element
  const notification = document.createElement("div");
  notification.style.position = "fixed";
  notification.style.top = "20px";
  notification.style.right = "20px";
  notification.style.backgroundColor = "#4CAF50";
  notification.style.color = "white";
  notification.style.padding = "15px 20px";
  notification.style.borderRadius = "5px";
  notification.style.boxShadow = "0 4px 8px rgba(0,0,0,0.2)";
  notification.style.zIndex = "1000";
  notification.style.transform = "translateY(-20px)";
  notification.style.opacity = "0";
  notification.style.transition = "all 0.3s ease";
  notification.innerHTML = "Cart updated successfully";

  // Add to body
  document.body.appendChild(notification);

  // Show notification
  setTimeout(() => {
    notification.style.transform = "translateY(0)";
    notification.style.opacity = "1";
  }, 10);

  // Remove notification after 3 seconds
  setTimeout(() => {
    notification.style.transform = "translateY(-20px)";
    notification.style.opacity = "0";
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

function updateItemSubtotal(btn) {
  const item = btn.closest(".cart-item");
  const price = parseFloat(item.getAttribute("data-price"));
  const quantity = parseInt(item.querySelector(".quantity-input").value);
  const subtotal = price * quantity;

  // Update the subtotal display
  item.querySelector(".subtotal-value").textContent = subtotal.toFixed(2);

  // Update cart in localStorage
  updateCartInLocalStorage();

  // Update the order summary
  updateTotalPrice();
}

function updateTotalPrice() {
  let total = 0;
  document.querySelectorAll(".subtotal-value").forEach((el) => {
    const subtotal = parseFloat(el.textContent.replace(",", ""));
    total += subtotal;
  });

  // Fixed tax cost
  const tax = 50;

  // Update the subtotal
  document.querySelector(
    ".summary-row:first-child span:last-child"
  ).textContent = `₱${total.toFixed(2)}`;

  // Calculate final total with tax
  const finalTotal = total + tax;

  // Update the total
  document.querySelector(
    ".summary-row.total span:last-child"
  ).textContent = `₱${finalTotal.toFixed(2)}`;
}

function updateCartCount() {
  const count = document.querySelectorAll(".cart-item").length;
  document.querySelector(".cart-count").textContent = count;
  document.querySelector(
    ".cart-title"
  ).textContent = `${count} items in your cart`;
}

// Animation on page load
document.addEventListener("DOMContentLoaded", function () {
  // Animate cart items
  const cartItems = document.querySelectorAll(".cart-item");
  cartItems.forEach((item, index) => {
    setTimeout(() => {
      item.style.opacity = "1";
    }, 100 + index * 200);
  });

  // Animate order summary
  const orderSummary = document.querySelector(".order-summary");
  setTimeout(() => {
    orderSummary.style.opacity = "1";
  }, 400);
});

// Button effects
const primaryBtn = document.querySelector(".action-btn");
const secondaryBtn = document.querySelector(".action-secondary");

primaryBtn.addEventListener("mouseenter", function () {
  this.style.backgroundColor = "#2563eb";
  this.style.boxShadow = "0 5px 15px rgba(59, 130, 246, 0.3)";
  this.querySelector(".btn-highlight").style.left = "0";
});

primaryBtn.addEventListener("mouseleave", function () {
  this.style.backgroundColor = "#3b82f6";
  this.style.boxShadow = "none";
  this.querySelector(".btn-highlight").style.left = "-100%";
});

secondaryBtn.addEventListener("mouseenter", function () {
  this.style.backgroundColor = "#1e293b";
  this.style.borderColor = "#60a5fa";
  this.style.boxShadow = "0 5px 15px rgba(59, 130, 246, 0.3)";
  this.querySelector(".btn-highlight").style.left = "0";
});

secondaryBtn.addEventListener("mouseleave", function () {
  this.style.backgroundColor = "#1e293b";
  this.style.borderColor = "#3b82f6";
  this.style.boxShadow = "none";
  this.querySelector(".btn-highlight").style.left = "-100%";
});

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

// Proceed to checkout button functionality
document
  .getElementById("checkout-button")
  .addEventListener("click", function () {
    window.location.href = "checkout.php";
  });

// Continue shopping button functionality
document
  .querySelector(".action-secondary")
  .addEventListener("click", function () {
    window.location.href = "categories.php";
  });

// Function to update cart item quantity
function updateCartItemQuantity(productId, newQuantity) {
  // Get cart from localStorage
  let cart = JSON.parse(localStorage.getItem("touchfindCart")) || [];

  // Find the cart item index
  const itemIndex = parseInt(productId);

  if (itemIndex >= 0 && itemIndex < cart.length) {
    // Update quantity
    cart[itemIndex].quantity = newQuantity;

    // Save updated cart to localStorage
    localStorage.setItem("touchfindCart", JSON.stringify(cart));

    // Update subtotal
    updateSubtotal(itemIndex, newQuantity);

    // Update total
    updateTotalPrice();
  }
}

// Function to update subtotal for an item
function updateSubtotal(itemIndex, quantity) {
  let cart = JSON.parse(localStorage.getItem("touchfindCart")) || [];
  if (itemIndex >= 0 && itemIndex < cart.length) {
    const price = cart[itemIndex].price;
    const subtotal = price * quantity;

    // Update subtotal display
    const subtotalElement = document.querySelector(
      `.subtotal[data-id="${itemIndex}"]`
    );
    if (subtotalElement) {
      subtotalElement.textContent = `${subtotal.toFixed(2)}`;
    }
  }
}

// Function to remove cart item
function removeCartItem(productId) {
  // Get cart from localStorage
  let cart = JSON.parse(localStorage.getItem("touchfindCart")) || [];

  // Find the item element
  const itemElement = document
    .querySelector(`.cart-item .remove-link[data-id="${productId}"]`)
    .closest(".cart-item");

  if (itemElement) {
    // Remove the item immediately
    itemElement.remove();

    // Remove from cart array
    cart.splice(productId, 1);

    // Save updated cart to localStorage
    localStorage.setItem("touchfindCart", JSON.stringify(cart));

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
  const notification = document.createElement("div");
  notification.style.position = "fixed";
  notification.style.top = "20px";
  notification.style.right = "20px";
  notification.style.backgroundColor = "#4CAF50";
  notification.style.color = "white";
  notification.style.padding = "15px 20px";
  notification.style.borderRadius = "5px";
  notification.style.boxShadow = "0 4px 8px rgba(0,0,0,0.2)";
  notification.style.zIndex = "1000";
  notification.style.transform = "translateY(-20px)";
  notification.style.opacity = "0";
  notification.style.transition = "all 0.3s ease";
  notification.innerHTML = message;

  // Add to body
  document.body.appendChild(notification);

  // Show notification
  setTimeout(() => {
    notification.style.transform = "translateY(0)";
    notification.style.opacity = "1";
  }, 10);

  // Remove notification after 3 seconds
  setTimeout(() => {
    notification.style.transform = "translateY(-20px)";
    notification.style.opacity = "0";
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

// Direct increment and decrement functions for onclick handlers
function incrementQuantity(button) {
  const quantityInput = button.parentNode.querySelector(".quantity-input");
  let value = parseInt(quantityInput.value);
  if (value < 99) {
    quantityInput.value = value + 1;
    updateItemSubtotal(button);
    showNotification("Quantity updated");
  }
}

function decrementQuantity(button) {
  const quantityInput = button.parentNode.querySelector(".quantity-input");
  let value = parseInt(quantityInput.value);
  if (value > 1) {
    quantityInput.value = value - 1;
    updateItemSubtotal(button);
    showNotification("Quantity updated");
  }
}
