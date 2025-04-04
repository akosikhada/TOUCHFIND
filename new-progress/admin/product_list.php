<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Product List</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>
    <?php include 'components/edit_product.php'; ?>
    <?php include 'components/delete_product.php'; ?>
    <?php include 'components/admin_header.php'; ?>
    
    <div class="d-flex admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <?php include 'components/admin_sidebar.php'; ?>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <div class="container-fluid px-4 py-4">
                <?php renderAdminHeader('LIST OF PRODUCT', 'Search products...'); ?>
                
                <!-- Product List Table -->
                <div class="admin-table-container">
                    <div class="table-responsive">
                        <table class="table admin-table product-table">
                            <thead>
                                <tr>
                                    <th>IMAGE</th>
                                    <th>PRODUCT NAME</th>
                                    <th>STOCK</th>
                                    <th>SHELF LOCATION</th>
                                    <th>PRICE</th>
                                    <th style="border-bottom: none;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Sample product data
                                $products = [
                                    [
                                        'id' => 'TL-1001',
                                        'name' => 'Hammer',
                                        'image' => '../assets/hammer-icon.png',
                                        'stock' => 15,
                                        'shelf' => 'A-11',
                                        'price' => 19.99,
                                        'class' => 'low'
                                    ],
                                    [
                                        'id' => 'TL-1002',
                                        'name' => 'Screwdriver Set',
                                        'image' => '../assets/screwdriver.png',
                                        'stock' => 28,
                                        'shelf' => 'A-12',
                                        'price' => 24.99,
                                        'class' => 'medium'
                                    ],
                                    [
                                        'id' => 'TL-1003',
                                        'name' => 'Wrench',
                                        'image' => '../assets/wrench.png',
                                        'stock' => 42,
                                        'shelf' => 'A-13',
                                        'price' => 15.99,
                                        'class' => 'high'
                                    ],
                                    [
                                        'id' => 'TL-1004',
                                        'name' => 'Power Drill',
                                        'image' => '../assets/drill.png',
                                        'stock' => 7,
                                        'shelf' => 'B-21',
                                        'price' => 89.99,
                                        'class' => 'critical'
                                    ],
                                    [
                                        'id' => 'TL-1005',
                                        'name' => 'Measuring Tape',
                                        'image' => '../assets/measuring-tape.png',
                                        'stock' => 35,
                                        'shelf' => 'B-22',
                                        'price' => 9.99,
                                        'class' => 'high'
                                    ]
                                ];
                                
                                foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <div class="product-image">
                                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-name"><?php echo $product['name']; ?></div>
                                        <div class="product-sku">SKU: <?php echo $product['id']; ?></div>
                                    </td>
                                    <td>
                                        <span class="stock-badge <?php echo $product['class']; ?>"><?php echo $product['stock']; ?></span>
                                    </td>
                                    <td><?php echo $product['shelf']; ?></td>
                                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                                    <td class="action-buttons no-border" style="border-bottom: none; border-top: none;">
                                        <div style="border: none; background: transparent;">
                                            <?php echo renderActionButtons('product', $product['id']); ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="items-per-page">
                        <span>Items per page:</span>
                        <select class="form-select form-select-sm d-inline-block w-auto ms-2">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    Previous
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    Next
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="js/admin.js"></script>
    
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">EDIT PRODUCT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId" name="productId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="editProductName" class="form-label">PRODUCT NAME</label>
                                    <input type="text" class="form-control" id="editProductName" name="productName" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editStock" class="form-label">STOCK</label>
                                    <input type="number" class="form-control" id="editStock" name="stock" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editShelfLocation" class="form-label">SHELF LOCATION</label>
                                    <input type="text" class="form-control" id="editShelfLocation" name="shelfLocation" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editPrice" class="form-label">PRICE ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="editProductImage" class="form-label">PRODUCT IMAGE</label>
                                    <div class="product-image-upload">
                                        <input type="file" class="d-none" id="editProductImage" name="productImage">
                                        <div class="product-image-placeholder edit-image-placeholder" onclick="document.getElementById('editProductImage').click()">
                                            <i class="bi bi-image"></i>
                                            <p>Choose file</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="editSku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="editSku" name="sku" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-save" id="saveProductChanges">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <?php echo renderDeleteModal('product'); ?>
</body>
</html>