<?php
// Include database connection
include 'components/db_connection.php';

// Initialize variables
$message = "";
$product = null;

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

// Check if product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: product_list.php");
    exit;
}

$productId = $_GET['id'];

// Fetch product data
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: product_list.php");
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $sku = $_POST['sku'];
    $stock = $_POST['stock'];
    $shelfLocation = $_POST['shelfLocation'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $imagePath = $product['product_image']; // Keep existing image by default

    // Handle image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK && $_FILES['productImage']['size'] > 0) {
        $imageName = time() . '_' . basename($_FILES['productImage']['name']);
        $targetDir = "products/";
        $targetFile = $targetDir . $imageName;
    
        if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
            $imagePath = "products/" . $imageName;
            
            // Delete old image if it exists and is not the default
            if (!empty($product['product_image']) && file_exists($product['product_image']) && $product['product_image'] != 'products/default.jpg') {
                unlink($product['product_image']);
            }
        } else {
            $message = "Error uploading the image.";
        }
    }

    // Update product in the database
    if (empty($message)) {
        $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_sku = ?, product_stock = ?, product_shelf = ?, product_price = ?, category_id = ?, product_description = ?, product_image = ? WHERE product_id = ?");
        $stmt->bind_param("ssisdissi", $productName, $sku, $stock, $shelfLocation, $price, $category, $description, $imagePath, $productId);
    
        if ($stmt->execute()) {
            $message = "Product updated successfully!";
            // Refresh product data
            $stmt->close();
            $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
        } else {
            $message = "Error updating product: " . $stmt->error;
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
    <title>TOUCHFIND | Edit Product</title>
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
            
            .row > [class*="col-"] {
                margin-bottom: 0;
            }
            
            .row {
                margin-left: -5px;
                margin-right: -5px;
            }
            
            .product-image-placeholder {
                height: 150px;
            }
        }
        
        @media (max-width: 359.98px) {
            .btn-update-product {
                width: 100%;
                margin-top: 10px;
            }
        }

        .product-image-preview {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
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
                <?php renderAdminHeader('EDIT PRODUCT', '', false); ?>
                
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
                                            <input type="text" autocomplete="off" class="form-control" id="productName" name="productName" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" autocomplete="off" class="form-control" id="sku" name="sku" value="<?php echo htmlspecialchars($product['product_sku']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="stock" class="form-label">STOCK</label>
                                            <input type="number" autocomplete="off" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['product_stock']); ?>" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="shelfLocation" class="form-label">SHELF LOCATION</label>
                                            <select class="form-control" id="shelfLocation" name="shelfLocation" required>
                                                <option value="">Select shelf location...</option>
                                                <?php foreach ($shelfLocations as $code => $location): ?>
                                                    <option value="<?php echo $code; ?>" <?php echo ($product['product_shelf'] == $code) ? 'selected' : ''; ?>>
                                                        <?php echo $location; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="price" class="form-label">PRICE</label>
                                            <input type="text" autocomplete="off" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>
                                        </div>

                                        <div class="mb-4">
                                            <label for="category" class="form-label">CATEGORY</label>
                                            <select class="form-control" id="category" name="category" required>
                                                <option value="">Select category...</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['category_id']; ?>" <?php echo ($product['category_id'] == $category['category_id']) ? 'selected' : ''; ?>>
                                                        <?php echo $category['category_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productImage" class="form-label">PRODUCT IMAGE</label>
                                            <?php if (!empty($product['product_image'])): ?>
                                                <div class="text-center mb-2">
                                                    <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image" class="product-image-preview">
                                                </div>
                                            <?php endif; ?>
                                            <div class="product-image-upload">
                                                <input type="file" class="d-none" id="productImage" name="productImage">
                                                <div class="product-image-placeholder" onclick="document.getElementById('productImage').click()">
                                                    <i class="bi bi-image"></i>
                                                    <p>Choose new image (optional)</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="form-label">DESCRIPTION</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-update-product">
                                        <i class="bi bi-check-circle me-2"></i>
                                        UPDATE PRODUCT
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