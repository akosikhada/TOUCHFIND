// Update quantity field in hidden input whenever plus or minus is clicked
const quantityInput = document.getElementById("quantity");
const hiddenQuantity = document.getElementById("hiddenQuantity");
const minusBtn = document.querySelector(".quantity-btn.minus");
const plusBtn = document.querySelector(".quantity-btn.plus");

// Prevent typing
quantityInput.addEventListener("keydown", (e) => e.preventDefault());

// Quantity increment/decrement
minusBtn.addEventListener("click", function () {
  let value = parseInt(quantityInput.value);
  if (value > 1) {
    quantityInput.value = value - 1;
    hiddenQuantity.value = value - 1;
  }
});

plusBtn.addEventListener("click", function () {
  let value = parseInt(quantityInput.value);
  if (value < 99) {
    quantityInput.value = value + 1;
    hiddenQuantity.value = value + 1;
  }
});

// Submit form to add to cart
document.getElementById("addToCartForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch("add_to_cart.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        showAddedToCartNotification(formData.get("quantity"));
      } else {
        alert("Failed to add to cart: " + data.message);
      }
    })
    .catch((err) => {
      console.error("Error adding to cart:", err);
      alert("Something went wrong.");
    });
});

// Show "Added to cart" notification
function showAddedToCartNotification(quantity) {
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
  notification.innerHTML = `<strong>${quantity} item${quantity > 1 ? "s" : ""}</strong> added to cart`;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.style.transform = "translateY(0)";
    notification.style.opacity = "1";
  }, 10);

  setTimeout(() => {
    notification.style.transform = "translateY(-20px)";
    notification.style.opacity = "0";
    setTimeout(() => {
      document.body.removeChild(notification);
    }, 300);
  }, 3000);
}

// Back button functionality
document.querySelector(".back-button").addEventListener("click", () => {
  window.history.back();
});

// Cart icon click
document.querySelector(".cart-icon").addEventListener("click", () => {
  window.location.href = "cart.php";
});

// DOM references
const searchIcon = document.getElementById("searchIcon");
const searchModal = document.getElementById("searchModal");
const closeSearch = document.getElementById("closeSearch");
const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const searchResults = document.getElementById("searchResults");

// Modal toggle
searchIcon.addEventListener("click", () => {
  searchModal.style.display = "flex";
  setTimeout(() => {
    searchModal.style.opacity = "1";
    searchInput.focus();
  }, 10);
});

closeSearch.addEventListener("click", () => {
  searchModal.style.opacity = "0";
  setTimeout(() => {
    searchModal.style.display = "none";
    searchResults.style.display = "none";
  }, 300);
});

searchModal.addEventListener("click", (e) => {
  if (e.target === searchModal) {
    searchModal.style.opacity = "0";
    setTimeout(() => {
      searchModal.style.display = "none";
      searchResults.style.display = "none";
    }, 300);
  }
});

// Perform Search using live data
function performSearch() {
  const query = searchInput.value.trim();
  if (query.length < 1) {
    searchResults.style.display = "none";
    return;
  }

  fetch(`search_products.php?q=${encodeURIComponent(query)}`)
    .then(res => res.json())
    .then(products => {
      if (products.length > 0) {
        searchResults.innerHTML = products.map(product => `
          <div class="search-result-item" data-id="${product.product_id}">
            <img src="../admin/${product.product_image}" alt="${product.product_name}" class="search-result-image">
            <div class="search-result-details">
              <div class="search-result-title">${product.product_name}</div>
              <div class="search-result-price">
                <span>PRICE :</span> 
                <span>₱ ${parseFloat(product.product_price).toFixed(2)}</span>
              </div>
            </div>
          </div>
        `).join("");

        document.querySelectorAll(".search-result-item").forEach(item => {
          item.addEventListener("click", () => {
            const id = item.getAttribute("data-id");
            window.location.href = `product_details.php?product_id=${id}`;
          });
        });

        searchResults.style.display = "block";
      } else {
        searchResults.innerHTML = `<div class="no-results">No products found matching your search</div>`;
        searchResults.style.display = "block";
      }
    });
}

searchButton.addEventListener("click", performSearch);
searchInput.addEventListener("keyup", (e) => {
  if (e.key === "Enter") performSearch();
  if (searchInput.value.length >= 1) {
    performSearch();
  } else {
    searchResults.style.display = "none";
  }
});