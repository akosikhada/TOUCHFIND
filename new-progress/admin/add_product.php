<?php
// Include database connection
include 'components/db_connection.php'; // Adjust the path if necessary

// Initialize variables
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
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
    
        $stmt = $conn->prepare("INSERT INTO products (product_name, product_stock, product_shelf, product_price, category_id, product_description, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisdiss", $productName, $stock, $shelfLocation, $price, $category, $description, $imagePath); // Use $imagePath here
    
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Add Product</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
    <link href="css/admin.css" rel="stylesheet">
    <style>
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
                padding: 15px;
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
                height: 150px;
            }
        }
        
        /* Super small screens */
        @media (max-width: 359.98px) {
            .btn-create-product {
                width: 100%;
                margin-top: 10px;
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
                <?php renderAdminHeader('CREATE PRODUCT', '', false); ?>
                
                <div class="product-form-container">
                    <div class="card product-form-card">
                        <div class="card-body p-4">
                            <?php if (!empty($message)): ?>
                                <div class="alert alert-info"><?php echo $message; ?></div>
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productName" class="form-label">PRODUCT NAME</label>
                                            <input type="text" autocomplete="off" class="form-control" id="productName" name="productName" placeholder="Enter product name..." required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="stock" class="form-label">STOCK</label>
                                            <input type="number" autocomplete="off" class="form-control" id="stock" name="stock" placeholder="Enter stock..." required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="shelfLocation" class="form-label">SHELF LOCATION</label>
                                            <input type="text" autocomplete="off" class="form-control" id="shelfLocation" name="shelfLocation" placeholder="Enter shelf location..." required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="price" class="form-label">PRICE</label>
                                            <input type="text" autocomplete="off" class="form-control" id="price" name="price" placeholder="Enter price..." required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="category" class="form-label">CATEGORY</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <option value="">Select category...</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['category_id']; ?>">
                                                        <?php echo $category['category_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productImage" class="form-label">PRODUCT IMAGE</label>
                                            <div class="product-image-upload">
                                                <input type="file" class="d-none" id="productImage" name="productImage" required>
                                                <div class="product-image-placeholder" onclick="document.getElementById('productImage').click()">
                                                    <i class="bi bi-image"></i>
                                                    <p>Choose file</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="form-label">DESCRIPTION</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-create-product">
                                        <i class="bi bi-plus-circle me-2"></i>
                                        CREATE PRODUCT
                                    </button>
                                </div>
                            </form>
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