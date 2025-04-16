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
if (placeOrderBtn) {
  const btnHighlight = document.querySelector(".btn-highlight");

  placeOrderBtn.addEventListener("mouseenter", function () {
    this.style.backgroundColor = "#1e293b";
    this.style.borderColor = "#60a5fa";
    this.style.boxShadow = "0 5px 15px rgba(59, 130, 246, 0.3)";
    if (btnHighlight) btnHighlight.style.left = "0";
  });

  placeOrderBtn.addEventListener("mouseleave", function () {
    this.style.backgroundColor = "#1e293b";
    this.style.borderColor = "#3b82f6";
    this.style.boxShadow = "none";
    if (btnHighlight) btnHighlight.style.left = "-100%";
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
}

// Apply animations with delay
document.addEventListener("DOMContentLoaded", function () {
  // Animate order items and summary
  const sections = document.querySelectorAll(".checkout-section-delay-2, .order-summary");
  sections.forEach((section, i) => {
    setTimeout(() => {
      section.style.opacity = "1";
    }, 200 * (i + 1));
  });

  const orderItems = document.querySelectorAll(".order-item");
  orderItems.forEach((item, i) => {
    setTimeout(() => {
      item.style.opacity = "1";
    }, 600 + i * 150);
  });

  // Button hover effects
  const placeOrderBtn = document.querySelector(".place-order-btn");
  const btnHighlight = document.querySelector(".btn-highlight");

  if (placeOrderBtn) {
    placeOrderBtn.addEventListener("mouseenter", function () {
      this.style.backgroundColor = "#1e293b";
      this.style.borderColor = "#60a5fa";
      this.style.boxShadow = "0 5px 15px rgba(59, 130, 246, 0.3)";
      if (btnHighlight) btnHighlight.style.left = "0";
    });

    placeOrderBtn.addEventListener("mouseleave", function () {
      this.style.backgroundColor = "#1e293b";
      this.style.borderColor = "#3b82f6";
      this.style.boxShadow = "none";
      if (btnHighlight) btnHighlight.style.left = "-100%";
    });
  }
});

// DOM references for new search
const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const searchResults = document.getElementById("searchResults");

// Ensure all DOM elements are loaded
document.addEventListener("DOMContentLoaded", function () {
  // Navigate to cart when cart icon is clicked
  const cartIcon = document.querySelector(".cart-icon");
  if (cartIcon) {
    cartIcon.addEventListener("click", function () {
      window.location.href = "cart.php";
    });
  }

  // Real-time search functionality
  if (searchInput && searchResults) {
    searchInput.addEventListener("keyup", function () {
      const query = this.value.trim();
      if (query.length > 1) {
        // Use AJAX to fetch search results
        const xhr = new XMLHttpRequest();
        xhr.open(
          "GET",
          `search_products.php?query=${encodeURIComponent(query)}`,
          true
        );
        xhr.onload = function () {
          if (this.status === 200) {
            searchResults.innerHTML = this.responseText;
            searchResults.classList.add("active");
          }
        };
        xhr.send();
      } else {
        searchResults.innerHTML = "";
        searchResults.classList.remove("active");
      }
    });

    // Handle click outside to close results
    document.addEventListener("click", function (e) {
      if (
        !searchInput.contains(e.target) &&
        !searchResults.contains(e.target)
      ) {
        searchResults.classList.remove("active");
      }
    });

    // If search button exists, add event listener
    if (searchButton) {
      searchButton.addEventListener("click", function () {
        const query = searchInput.value.trim();
        if (query.length > 0) {
          window.location.href = `search_results.php?query=${encodeURIComponent(
            query
          )}`;
        }
      });
    }

    // Handle Enter key press
    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        const query = this.value.trim();
        if (query.length > 0) {
          window.location.href = `search_results.php?query=${encodeURIComponent(
            query
          )}`;
        }
      }
    });
  }
});
