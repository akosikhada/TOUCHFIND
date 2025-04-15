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
