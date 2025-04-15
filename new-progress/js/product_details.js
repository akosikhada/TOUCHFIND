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
document
  .getElementById("addToCartForm")
  .addEventListener("submit", function (e) {
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
  notification.innerHTML = `<strong>${quantity} item${
    quantity > 1 ? "s" : ""
  }</strong> added to cart`;

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

// DOM references for new search
const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const searchResults = document.getElementById("searchResults");

// Real-time search from database
function performSearch() {
  const query = searchInput.value.trim();
  if (query.length < 1) {
    searchResults.classList.remove("active");
    return;
  }

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
}

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

// If search input exists, add event listeners
if (searchInput) {
  searchInput.addEventListener("keyup", function () {
    const query = this.value.trim();
    if (query.length > 1) {
      performSearch();
    } else {
      searchResults.innerHTML = "";
      searchResults.classList.remove("active");
    }
  });

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

// Handle click outside to close results
document.addEventListener("click", function (e) {
  if (
    searchInput &&
    searchResults &&
    !searchInput.contains(e.target) &&
    !searchResults.contains(e.target)
  ) {
    searchResults.classList.remove("active");
  }
});
