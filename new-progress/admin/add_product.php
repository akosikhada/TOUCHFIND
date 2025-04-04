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
                            <form action="#" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productName" class="form-label">PRODUCT NAME</label>
                                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name...">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="stock" class="form-label">STOCK</label>
                                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter stock...">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="shelfLocation" class="form-label">SHELF LOCATION</label>
                                            <input type="text" class="form-control" id="shelfLocation" name="shelfLocation" placeholder="Enter shelf location...">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="price" class="form-label">PRICE</label>
                                            <input type="text" class="form-control" id="price" name="price" placeholder="Enter price...">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="productImage" class="form-label">PRODUCT IMAGE</label>
                                            <div class="product-image-upload">
                                                <input type="file" class="d-none" id="productImage" name="productImage">
                                                <div class="product-image-placeholder" onclick="document.getElementById('productImage').click()">
                                                    <i class="bi bi-image"></i>
                                                    <p>Choose file</p>
                                                </div>
                                            </div>
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