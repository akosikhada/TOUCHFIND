// Add click event to product cards to navigate to product details
document.querySelectorAll(".product-card").forEach((card) => {
  card.addEventListener("click", function () {
    window.location.href = "product_details.php";
  });
});

// Add click event to category items
document.querySelectorAll(".category-item").forEach((item) => {
  item.addEventListener("click", function () {
    // Remove active class from all items
    document.querySelectorAll(".category-item").forEach((i) => {
      i.classList.remove("active");
    });
    // Add active class to clicked item
    this.classList.add("active");
  });
});

// Add click event to cart icon to navigate to cart page
document.querySelector(".cart-icon").addEventListener("click", function () {
  window.location.href = "cart.php";
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
  searchModal.classList.add("active");
  setTimeout(() => {
    searchInput.focus();
  }, 300);
});

// Close search modal
closeSearch.addEventListener("click", function () {
  searchModal.classList.remove("active");
  searchResults.classList.remove("active");
  // Keep the search text in the input field
});

// Close modal when clicking outside the search container
searchModal.addEventListener("click", function (e) {
  if (e.target === searchModal) {
    searchModal.classList.remove("active");
    searchResults.classList.remove("active");
    // Keep the search text in the input field
  }
});

// Display search results
function performSearch() {
  const query = searchInput.value.toLowerCase().trim();

  if (query.length < 1) {
    searchResults.classList.remove("active");
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
                        <img src="${product.image}" class="search-result-image" alt="${product.name}" loading="lazy">
                        <div class="search-result-info">
                            <div class="search-result-title">${product.name}</div>
                            <div class="search-result-price">
                                <span>PRICE :</span>
                                <span>₱ 150.00</span>
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

  searchResults.classList.add("active");
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
    searchResults.classList.remove("active");
  }
});
