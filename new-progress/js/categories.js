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

// DOM references
const searchIcon = document.getElementById("searchIcon");
const searchModal = document.getElementById("searchModal");
const closeSearch = document.getElementById("closeSearch");
const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const searchResults = document.getElementById("searchResults");

// Modal open/close
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

// Real-time search from database
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