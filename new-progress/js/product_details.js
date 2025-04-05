// Cart functionality
const cartCountDisplay = document.querySelector(".cart-count");

// Initialize cart from localStorage or create empty cart
let cart = JSON.parse(localStorage.getItem("touchfindCart")) || [];

// Update cart count display on page load
updateCartCount();

// Back to Home functionality
document.querySelector(".back-link").addEventListener("click", function (e) {
  e.preventDefault();
  window.location.href = "categories.php";
});

// Add to cart functionality
document.querySelector(".add-to-cart").addEventListener("click", function () {
  const productName = document.querySelector(".product-title").textContent;
  const productPrice = parseFloat(
    document.querySelector(".product-price").textContent.replace("₱", "").trim()
  );
  const productImage = document.querySelector(".product-image").src;
  const quantity = parseInt(document.getElementById("quantity").value);
  const productCategory =
    document.querySelector(".product-category").textContent;

  // Check if product exists in cart
  const existingProductIndex = cart.findIndex(
    (item) => item.name === productName
  );

  if (existingProductIndex > -1) {
    // Update quantity if product already exists
    cart[existingProductIndex].quantity += quantity;
  } else {
    // Add new product to cart
    cart.push({
      name: productName,
      price: productPrice,
      image: productImage,
      quantity: quantity,
      category: productCategory,
    });
  }

  // Save cart to localStorage
  localStorage.setItem("touchfindCart", JSON.stringify(cart));

  // Update cart count display
  updateCartCount();

  // Show added to cart notification
  showAddedToCartNotification(quantity);
});

// Function to update cart count
function updateCartCount() {
  let totalItems = 0;
  cart.forEach((item) => {
    totalItems += item.quantity;
  });
  cartCountDisplay.textContent = totalItems;
}

// Function to show added to cart notification
function showAddedToCartNotification(quantity) {
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
  notification.innerHTML = `<strong>${quantity} item${
    quantity > 1 ? "s" : ""
  }</strong> added to cart`;

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

// Quantity buttons functionality
const quantityInput = document.getElementById("quantity");
const minusBtn = document.querySelector(".quantity-btn.minus");
const plusBtn = document.querySelector(".quantity-btn.plus");

// Prevent any direct input on the quantity field
quantityInput.addEventListener("keydown", function (e) {
  e.preventDefault();
  return false;
});

minusBtn.addEventListener("click", function () {
  let value = parseInt(quantityInput.value);
  if (value > 1) {
    quantityInput.value = value - 1;
  }
});

plusBtn.addEventListener("click", function () {
  let value = parseInt(quantityInput.value);
  if (value < 99) {
    // Adding a reasonable upper limit
    quantityInput.value = value + 1;
  }
});

// Navigate to cart when cart icon is clicked
document.querySelector(".cart-icon").addEventListener("click", function () {
  window.location.href = "cart.php";
});

// Back button functionality
document.querySelector(".back-button").addEventListener("click", function () {
  window.history.back();
});

// Add hover effects for buttons
const addToCartBtn = document.querySelector(".add-to-cart");
const backButton = document.querySelector(".back-button");

addToCartBtn.addEventListener("mouseenter", function () {
  const btnHighlight = this.querySelector(".btn-highlight");
  btnHighlight.style.left = "0";
});

addToCartBtn.addEventListener("mouseleave", function () {
  const btnHighlight = this.querySelector(".btn-highlight");
  btnHighlight.style.left = "-100%";
});

backButton.addEventListener("mouseenter", function () {
  const btnHighlight = this.querySelector(".btn-shopping-highlight");
  btnHighlight.style.left = "0";
});

backButton.addEventListener("mouseleave", function () {
  const btnHighlight = this.querySelector(".btn-shopping-highlight");
  btnHighlight.style.left = "-100%";
});

// Search Modal Functionality
const searchIcon = document.getElementById("searchIcon");
const searchModal = document.getElementById("searchModal");
const closeSearch = document.getElementById("closeSearch");
const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const searchResults = document.getElementById("searchResults");

// Sample product data (in a real app, this would come from a database)
const products = [
  {
    id: 1,
    name: "Professional Power Drill Set",
    price: "₱ 150.00",
    image: "../assets/drill.png",
  },
  {
    id: 2,
    name: "Heavy Duty Tool Box",
    price: "₱ 150.00",
    image: "../assets/chainsaw.png",
  },
  {
    id: 3,
    name: "Premium Paint Brush Set",
    price: "₱ 150.00",
    image: "../assets/chair.png",
  },
  {
    id: 4,
    name: "Multi-Purpose Wrench Set",
    price: "₱ 150.00",
    image: "../assets/wrench.png",
  },
  {
    id: 5,
    name: "Electric Circular Saw",
    price: "₱ 150.00",
    image: "../assets/circular-saw.png",
  },
  {
    id: 6,
    name: "Professional Measuring Tape",
    price: "₱ 150.00",
    image: "../assets/measuring-tape.png",
  },
  {
    id: 7,
    name: "Safety Work Gloves",
    price: "₱ 150.00",
    image: "../assets/gloves.png",
  },
  {
    id: 8,
    name: "Premium Screwdriver Kit",
    price: "₱ 150.00",
    image: "../assets/screwdriver.png",
  },
];

// Open search modal
searchIcon.addEventListener("click", function () {
  searchModal.style.display = "flex";
  setTimeout(() => {
    searchModal.style.opacity = "1";
    searchInput.focus();
  }, 10);
});

// Close search modal
closeSearch.addEventListener("click", function () {
  searchModal.style.opacity = "0";
  setTimeout(() => {
    searchModal.style.display = "none";
    searchResults.style.display = "none";
  }, 300);
});

// Close modal when clicking outside the search container
searchModal.addEventListener("click", function (e) {
  if (e.target === searchModal) {
    searchModal.style.opacity = "0";
    setTimeout(() => {
      searchModal.style.display = "none";
      searchResults.style.display = "none";
    }, 300);
  }
});

// Display search results
function performSearch() {
  const query = searchInput.value.toLowerCase().trim();

  if (query.length < 1) {
    searchResults.style.display = "none";
    return;
  }

  // Filter products based on search query
  const filteredProducts = products.filter((product) =>
    product.name.toLowerCase().includes(query)
  );

  // Display search results
  if (filteredProducts.length > 0) {
    searchResults.innerHTML = "";

    filteredProducts.forEach((product) => {
      const resultItem = document.createElement("div");
      resultItem.className = "search-result-item";

      resultItem.innerHTML = `
                        <img src="${product.image}" alt="${product.name}" loading="lazy" class="search-result-image">
                        <div class="search-result-details">
                            <div class="search-result-title">${product.name}</div>
                            <div class="search-result-price">
                                <span>PRICE :</span>
                                <span>${product.price}</span>
                            </div>
                        </div>
                    `;

      resultItem.addEventListener("click", function () {
        window.location.href = `product_details.php?id=${product.id}`;
      });

      searchResults.appendChild(resultItem);
    });
  } else {
    searchResults.innerHTML =
      '<div class="no-results">No products found matching your search</div>';
  }

  searchResults.style.display = "block";
}

// Search on button click
searchButton.addEventListener("click", performSearch);

// Search on enter key
searchInput.addEventListener("keyup", function (e) {
  if (e.key === "Enter") {
    performSearch();
  }
  // Auto-search after typing
  if (searchInput.value.length >= 1) {
    performSearch();
  } else {
    searchResults.style.display = "none";
  }
});
