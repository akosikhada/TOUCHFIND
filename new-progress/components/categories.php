<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Categories</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #141414;
            color: white;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        
        /* Header Styles */
        .header {
            background-color: #1a1a1a;
            padding: 15px 30px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            border-bottom: 1px solid #333;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            z-index: 100;
        }
        
        .brand {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            grid-column: 2;
            text-align: center;
        }
        
        .header-icons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            grid-column: 3;
        }
        
        .search-icon, .cart-icon {
            margin-left: 20px;
            font-size: 20px;
            cursor: pointer;
        }
        
        .cart-badge {
            position: relative;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #1F2937;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        /* Main Content Layout */
        .main-container {
            display: flex;
            margin-top: 60px; /* Height of header */
            height: calc(100vh - 60px);
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 220px;
            background-color: #1a1a1a;
            padding-top: 25px;
            height: 100%;
            border-right: 1px solid #333;
            position: fixed;
            top: 60px; /* Height of header */
            left: 0;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
            z-index: 10;
        }
        
        .sidebar::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        .sidebar-title {
            font-size: 20px;
            font-weight: 600;
            padding: 0 20px 20px 30px;
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInDown 0.5s ease forwards;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .category-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .category-item {
            padding: 15px 20px 15px 30px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeIn 0.5s ease forwards;
        }
        
        .category-item:nth-child(1) { animation-delay: 0.1s; }
        .category-item:nth-child(2) { animation-delay: 0.2s; }
        .category-item:nth-child(3) { animation-delay: 0.3s; }
        .category-item:nth-child(4) { animation-delay: 0.4s; }
        .category-item:nth-child(5) { animation-delay: 0.5s; }
        .category-item:nth-child(6) { animation-delay: 0.6s; }
        .category-item:nth-child(7) { animation-delay: 0.7s; }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .category-item:hover {
            background-color: #1a1a1a;
            padding-left: 35px;
        }
        
        .category-item.active {
            background-color: #1F2937;
        }
        
        .category-icon {
            width: 20px;
            height: 20px;
            margin-right: 15px;
            filter: brightness(0) invert(1);
        }
        
        /* Product Grid Styles */
        .product-container {
            flex: 1;
            padding: 30px;
            margin-left: 220px; /* Same as sidebar width */
            height: 100%;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }
        
        .product-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }
        
        .product-card {
            border-radius: 10px;
            overflow: hidden;
            background-color: #1F2937;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
            position: relative;
            top: 0;
            transition: top 0.3s ease, box-shadow 0.3s ease;
        }
        
        /* Product card animation delays - first row */
        .product-grid .product-card:nth-child(1) { animation-delay: 0.8s; }
        .product-grid .product-card:nth-child(2) { animation-delay: 0.9s; }
        .product-grid .product-card:nth-child(3) { animation-delay: 1.0s; }
        .product-grid .product-card:nth-child(4) { animation-delay: 1.1s; }
        
        /* Product card animation delays - second row */
        .product-grid .product-card:nth-child(5) { animation-delay: 1.2s; }
        .product-grid .product-card:nth-child(6) { animation-delay: 1.3s; }
        .product-grid .product-card:nth-child(7) { animation-delay: 1.4s; }
        .product-grid .product-card:nth-child(8) { animation-delay: 1.5s; }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .product-card:hover {
            top: -10px;
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }
        
        .product-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
            background-color: transparent;
            padding: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .product-title {
            padding: 18px 20px 8px 20px;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.3;
            letter-spacing: 0.2px;
        }
        
        .product-price {
            padding: 0px 20px 22px 20px;
            display: flex;
            justify-content: space-between;
            color: #aaa;
            font-size: 14px;
            align-items: center;
        }
        
        .price-value {
            color: white;
            font-weight: 600;
            font-size: 18px;
        }
        
        /* Smart Suggestions */
        .smart-suggestions {
            text-align: center;
            padding: 30px 0;
            margin-top: 30px;
            color: #ccc;
            cursor: pointer;
            opacity: 0;
            animation: fadeIn 0.8s ease forwards 1.7s;
        }
        
        .smart-suggestions:hover {
            color: white;
        }

        /* Search Modal Styles */
        .search-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(20, 20, 20, 0.95);
            display: none;
            flex-direction: column;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding-top: 60px;
        }

        .search-modal.active {
            display: flex;
            opacity: 1;
        }

        .search-container {
            width: 90%;
            max-width: 900px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
        }

        .search-input {
            width: 100%;
            padding: 18px 50px 18px 20px;
            font-size: 18px;
            border: none;
            background-color: #2a2a2a;
            color: white;
            outline: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .search-input:focus {
            background-color: #333;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
        }

        .search-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #aaa;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .search-btn:hover {
            color: white;
        }

        .close-search {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 30px;
            color: white;
            cursor: pointer;
            background: none;
            border: none;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .close-search:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .search-results {
            width: 100%;
            max-width: 900px;
            margin-top: 5px;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
            border-radius: 8px;
            background-color: #2a2a2a;
            max-height: 70vh;
            display: none;
        }

        .search-results::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .search-results.active {
            display: block;
        }

        .search-result-item {
            display: flex;
            padding: 15px 20px;
            border-bottom: 1px solid #3a3a3a;
            transition: background-color 0.3s ease;
            cursor: pointer;
            align-items: center;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background-color: #333;
        }

        .search-result-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
            background-color: #333;
        }

        .search-result-info {
            flex: 1;
        }

        .search-result-title {
            font-weight: 500;
            margin-bottom: 5px;
            color: white;
        }

        .search-result-price {
            color: #aaa;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }

        .no-results {
            padding: 20px;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="brand">TOUCHFIND</div>
        <div class="header-icons">
            <div class="search-icon" id="searchIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </div>
            <div class="cart-icon cart-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span class="cart-count">2</span>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-title">Categories</div>
            <ul class="category-list">
                <li class="category-item">
                    <img src="../assets/tools-icon.png" alt="Tools" class="category-icon" loading="lazy">
                    Tools
                </li>
                <li class="category-item">
                    <img src="../assets/pipes-icon.png" alt="Pipes" class="category-icon" loading="lazy">
                    Pipes
                </li>
                <li class="category-item active">
                    <img src="../assets/hardware-icon.png" alt="Hardware" class="category-icon" loading="lazy">
                    Hardware
                </li>
                <li class="category-item">
                    <img src="../assets/paint-icon.png" alt="Paints" class="category-icon" loading="lazy">
                    Paints
                </li>
                <li class="category-item">
                    <img src="../assets/faucet-icon.png" alt="Faucet" class="category-icon" loading="lazy">
                    Faucet
                </li>
                <li class="category-item">
                    <img src="../assets/wires-icon.png" alt="Wires" class="category-icon" loading="lazy">
                    Wires
                </li>
                <li class="category-item">
                    <img src="../assets/tiles-icon.png" alt="Tiles" class="category-icon" loading="lazy">
                    Tiles
                </li>
            </ul>
        </div>
        
        <!-- Product Grid -->
        <div class="product-container">
            <div class="product-grid">
                <!-- Row 1 -->
                <div class="product-card">
                    <img src="../assets/drill.png" alt="Professional Power Drill Set" class="product-image" loading="lazy">
                    <div class="product-title">Professional Power Drill Set</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="../assets/chainsaw.png" alt="Heavy Duty Tool Box" class="product-image" loading="lazy">
                    <div class="product-title">Heavy Duty Tool Box</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="../assets/chair.png" alt="Premium Paint Brush Set" class="product-image" loading="lazy">
                    <div class="product-title">Premium Paint Brush Set</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="../assets/wrench.png" alt="Multi-Purpose Wrench Set" class="product-image" loading="lazy">
                    <div class="product-title">Multi-Purpose Wrench Set</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <!-- Row 2 -->
                <div class="product-card">
                    <img src="../assets/circular-saw.png" alt="Electric Circular Saw" class="product-image" loading="lazy">
                    <div class="product-title">Electric Circular Saw</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="../assets/measuring-tape.png" alt="Professional Measuring Tape" class="product-image" loading="lazy">
                    <div class="product-title">Professional Measuring Tape</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="../assets/gloves.png" alt="Safety Work Gloves" class="product-image" loading="lazy">
                    <div class="product-title">Safety Work Gloves</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="../assets/screwdriver.png" alt="Premium Screwdriver Kit" class="product-image" loading="lazy">
                    <div class="product-title">Premium Screwdriver Kit</div>
                    <div class="product-price">
                        <span>PRICE :</span>
                        <span class="price-value">₱ 150.00</span>
                    </div>
                </div>
            </div>
            
            <!-- Smart Suggestions -->
            <div class="smart-suggestions">
                Need Help? Get Smart Suggestions
            </div>
        </div>
    </div>
    
    <!-- Search Modal -->
    <div class="search-modal" id="searchModal">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
            <button class="search-btn" id="searchButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
        <div class="search-results" id="searchResults">
            <!-- Search results will be populated here -->
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add click event to product cards to navigate to product details
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function() {
                window.location.href = 'product_details.php';
            });
        });

        // Add click event to category items
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                document.querySelectorAll('.category-item').forEach(i => {
                    i.classList.remove('active');
                });
                // Add active class to clicked item
                this.classList.add('active');
            });
        });
        
        // Add click event to cart icon to navigate to cart page
        document.querySelector('.cart-icon').addEventListener('click', function() {
            window.location.href = 'cart.php';
        });

        // Search Modal Functionality
        const searchIcon = document.getElementById('searchIcon');
        const searchModal = document.getElementById('searchModal');
        const closeSearch = document.getElementById('closeSearch');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const searchResults = document.getElementById('searchResults');

        // Sample product data (in a real app, this would come from a database)
        const products = [
            { id: 1, name: 'Professional Power Drill Set', price: '₱ 150.00', image: '../assets/drill.png' },
            { id: 2, name: 'Heavy Duty Tool Box', price: '₱ 150.00', image: '../assets/chainsaw.png' },
            { id: 3, name: 'Premium Paint Brush Set', price: '₱ 150.00', image: '../assets/chair.png' },
            { id: 4, name: 'Multi-Purpose Wrench Set', price: '₱ 150.00', image: '../assets/wrench.png' },
            { id: 5, name: 'Electric Circular Saw', price: '₱ 150.00', image: '../assets/circular-saw.png' },
            { id: 6, name: 'Professional Measuring Tape', price: '₱ 150.00', image: '../assets/measuring-tape.png' },
            { id: 7, name: 'Safety Work Gloves', price: '₱ 150.00', image: '../assets/gloves.png' },
            { id: 8, name: 'Premium Screwdriver Kit', price: '₱ 150.00', image: '../assets/screwdriver.png' }
        ];

        // Open search modal
        searchIcon.addEventListener('click', function() {
            searchModal.classList.add('active');
            setTimeout(() => {
                searchInput.focus();
            }, 300);
        });

        // Close search modal
        closeSearch.addEventListener('click', function() {
            searchModal.classList.remove('active');
            searchResults.classList.remove('active');
            // Keep the search text in the input field
        });

        // Close modal when clicking outside the search container
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                searchModal.classList.remove('active');
                searchResults.classList.remove('active');
                // Keep the search text in the input field
            }
        });

        // Display search results
        function performSearch() {
            const query = searchInput.value.toLowerCase().trim();
            
            if (query.length < 1) {
                searchResults.classList.remove('active');
                return;
            }

            // Filter products based on search query
            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(query)
            );

            // Display search results
            if (filteredProducts.length > 0) {
                searchResults.innerHTML = '';
                
                filteredProducts.forEach(product => {
                    const resultItem = document.createElement('div');
                    resultItem.className = 'search-result-item';
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
                    resultItem.addEventListener('click', function() {
                        window.location.href = `product_details.php?id=${product.id}`;
                    });
                    
                    searchResults.appendChild(resultItem);
                });
            } else {
                searchResults.innerHTML = '<div class="no-results">No products found matching your search</div>';
            }
            
            searchResults.classList.add('active');
        }

        // Search on button click
        searchButton.addEventListener('click', performSearch);

        // Search on enter key
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
            // Auto-search after typing
            if (searchInput.value.length >= 1) {
                performSearch();
            } else {
                searchResults.classList.remove('active');
            }
        });
    </script>
</body>
</html>