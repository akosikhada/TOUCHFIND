document.addEventListener("DOMContentLoaded", function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const productList = document.getElementById('product-list');

    function fetchProducts(categoryId) {
        let url = '../components/fetch_products.php';
        if (categoryId !== "all") {
            url += `?category_id=${categoryId}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    productList.innerHTML = data.map(product => `
                        <div class="product-item">
                            <a href="../components/view_product.php?id=${product.product_id}">
                                ${product.product_image ? `<img src="images/${product.product_image}" alt="${product.product_name}" class="product-image">` : ''}
                                <h3>${product.product_name}</h3>
                                <p>Price: ₱${parseFloat (product.product_price).toFixed(2)}</p>
                            </a>
                        </div>
                    `).join('');
                } else {
                    productList.innerHTML = "<p>No products available.</p>";
                }
            })
            .catch(error => console.error("Error fetching products:", error));
    }

    categoryLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            categoryLinks.forEach(link => link.classList.remove("active"));
            this.classList.add("active");
            fetchProducts(this.id);
        });
    });

    // Load all products initially
    fetchProducts("all");
});