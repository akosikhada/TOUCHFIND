<?php
// Include database connection
include 'components/db_connection.php'; // Adjust the path if necessary

// Initialize variables
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $sku = $_POST['sku'];
    $stock = $_POST['stock'];
    $shelfLocation = $_POST['shelfLocation'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $imageName = "";

    // Handle image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $imageName = time() . '_' . basename($_FILES['productImage']['name']);
        $targetDir = "products/"; // Ensure this is set to "products/"
        $targetFile = $targetDir . $imageName;
    
        if (!move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
            $message = "Error uploading the image.";
        }
    }

    // Insert product into the database
    if (empty($message)) {
        // Prepend "products/" to the image name
        $imagePath = "products/" . $imageName;
    
        $stmt = $conn->prepare("INSERT INTO products (product_name, product_sku, product_stock, product_shelf, product_price, category_id, product_description, product_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisdiss", $productName, $sku, $stock, $shelfLocation, $price, $category, $description, $imagePath); // Use $imagePath here
    
        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product: " . $stmt->error;
        }
    
        $stmt->close();
    }
}

// Fetch categories
$categories = [];
$result = $conn->query("SELECT category_id, category_name FROM categories");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Define shelf locations
$shelfLocations = [
    'A1' => 'Aisle A, Shelf 1',
    'A2' => 'Aisle A, Shelf 2',
    'A3' => 'Aisle A, Shelf 3',
    'B1' => 'Aisle B, Shelf 1',
    'B2' => 'Aisle B, Shelf 2',
    'B3' => 'Aisle B, Shelf 3',
    'C1' => 'Aisle C, Shelf 1',
    'C2' => 'Aisle C, Shelf 2',
    'C3' => 'Aisle C, Shelf 3'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Product Management</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
    <link href="css/admin.css" rel="stylesheet">
    <style>
        /* Form styling improvements */
        .product-form-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .product-form-card .card-body {
            padding: 25px;
        }
        
        /* Form label styling */
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        
        /* Input styling */
        .form-control, .form-select {
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background-color: #fff;
            color: #2d3748;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }
        
        /* Image upload styling */
        .product-image-upload {
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            padding: 30px 20px;
            background-color: #f8fafc;
            transition: all 0.2s;
        }
        
        .product-image-upload:hover {
            border-color: #4299e1;
            background-color: #ebf8ff;
        }
        
        .product-image-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            cursor: pointer;
        }
        
        .product-image-placeholder i {
            font-size: 48px;
            color: #a0aec0;
            margin-bottom: 15px;
        }
        
        .product-image-placeholder p {
            color: #718096;
            font-weight: 500;
        }
        
        /* Create product button */
        .btn-create-product {
            background-color: #38a169;
            color: white;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            border: none;
            font-size: 0.95rem;
        }
        
        .btn-create-product:hover {
            background-color: #2f855a;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            color: white;
        }
        
        .btn-create-product i {
            margin-right: 8px;
        }
        
        /* Form groups spacing */
        .mb-4 {
            margin-bottom: 1.75rem !important;
        }
        
        /* Textarea styling */
        textarea.form-control {
            min-height: 120px;
            line-height: 1.5;
        }
        
        /* Page title */
        .admin-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }
        
        /* Form input groups */
        .input-group-text {
            background-color: #f8fafc;
            border-color: #e2e8f0;
            color: #718096;
        }
        
        /* Success message */
        .alert-info {
            background-color: #e6fffa;
            border-color: #b2f5ea;
            color: #234e52;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        /* Additional responsive styles */
        @media (max-width: 767.98px) {
            .admin-main {
                padding-left: 0;
            }
            
            .product-form-card {
                margin: 0 -10px;
                border-radius: 0;
            }
            
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .card-body {
                padding: 20px 15px;
            }
            
            /* Stack form fields in a single column on mobile */
            .row > [class*="col-"] {
                margin-bottom: 0;
            }
            
            /* Override Bootstrap column spacing */
            .row {
                margin-left: -5px;
                margin-right: -5px;
            }
            
            .product-image-placeholder {
                min-height: 150px;
            }
        }
        
        /* Super small screens */
        @media (max-width: 359.98px) {
            .btn-create-product {
                width: 100%;
                margin-top: 10px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/admin_header.php'; ?>
    
    <div class="d-flex admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <?php include 'components/admin_sidebar.php'; ?>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <div class="container-fluid px-4 py-4">
                <?php renderAdminHeader('Product Management', '', false); ?>
                
                <div class="product-form-container">
                    <div class="card product-form-card">
                        <div class="card-header bg-white py-3">
                            <h4 class="card-title mb-0 fw-bold text-black">Add New Product</h4>
                            <p class="text-muted mb-0 mt-1">Fill in the details to create a new product</p>
                        </div>
                        <div class="card-body p-4">
                            <?php if (!empty($message)): ?>
                                <div class="alert alert-info">
                                    <i class="bi bi-check-circle me-2"></i><?php echo $message; ?>
                                </div>
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data" id="add-product-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productName" class="form-label">Product Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                                <input type="text" autocomplete="off" class="form-control" id="productName" name="productName" placeholder="e.g. Hammer, Screwdriver, Nails, etc." required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="stock" class="form-label">Stock</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-boxes"></i></span>
                                                <input type="number" autocomplete="off" class="form-control" id="stock" name="stock" placeholder="Enter quantity of product available..." required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="shelfLocation" class="form-label">Shelf Location</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                                <select class="form-control form-select" id="shelfLocation" name="shelfLocation" required>
                                                    <option value="">Select shelf location...</option>
                                                    <?php foreach ($shelfLocations as $code => $location): ?>
                                                        <option value="<?php echo $code; ?>">
                                                            <?php echo $location; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="price" class="form-label">Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₱</span>
                                                <input type="text" autocomplete="off" class="form-control" id="price" name="price" placeholder="e.g. 19.99, 5.00, 0.99..." required>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="category" class="form-label">Category</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-folder"></i></span>
                                                <select class="form-control form-select" id="category" name="category" required>
                                                    <option value="">Select category...</option>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?php echo $category['category_id']; ?>">
                                                            <?php echo $category['category_name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productImage" class="form-label">Product Image</label>
                                            <div class="product-image-upload">
                                                <input type="file" class="d-none" id="productImage" name="productImage" required>
                                                <div class="product-image-placeholder" onclick="document.getElementById('productImage').click()">
                                                    <i class="bi bi-image"></i>
                                                    <p>Click to upload image</p>
                                                    <small class="text-muted mt-2">Recommended size: 800×800px</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="sku" class="form-label">SKU</label>
                                            <div class="input-group">
                                                <span class="input-group-text">#</span>
                                                <input type="text" autocomplete="off" class="form-control" id="sku" name="sku" placeholder="Enter product SKU..." required>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer bg-light py-3 text-end">
                            <a href="product_list.php" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-left me-1"></i> Back to Products
                            </a>
                            <button type="submit" form="add-product-form" class="btn btn-create-product">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="js/admin.js"></script>
</body>
</html>