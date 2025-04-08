<?php
require_once 'components/db_connection.php';
session_start();

function truncateDescription($description, $wordLimit) {
    $words = explode(' ', $description);
    if (count($words) > $wordLimit) {
        return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
    }
    return $description;
}
?>

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
    <style>
        /* Responsive table styles */
        @media (max-width: 991.98px) {
            .admin-main {
                padding-left: 0;
            }
            
            .admin-table-container {
                overflow-x: auto;
                margin: 0 -15px;
                padding: 0 15px;
            }
            
            /* Ensure table doesn't overflow container */
            .table-responsive {
                min-width: 100%;
            }
            
            /* Add spacing between pagination components */
            .pagination {
                margin-top: 10px;
            }
        }
        
        /* Mobile specific styles */
        @media (max-width: 767.98px) {
            .admin-table thead {
                display: none; /* Hide table headers on mobile */
            }
            
            .admin-table tbody tr {
                display: block;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: 0.25rem;
                margin-bottom: 1.5rem; /* Increased bottom margin for more space */
                padding: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            }
            
            .admin-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none;
                padding: 0.5rem 0.5rem;
                text-align: right;
            }
            
            /* Create column headers on mobile */
            .admin-table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                padding-right: 0.5rem;
            }
            
            /* Special styling for image column */
            .admin-table td:first-child {
                display: block;
                text-align: center;
                justify-content: center;
            }
            
            .admin-table td:first-child:before {
                display: none;
            }
            
            .product-image {
                width: 100%;
                max-width: 100px;
                margin: 0 auto;
            }
            
            /* Special styling for status badges */
            .admin-table td .stock-badge {
                margin-left: auto;
            }
            
            /* Action buttons centered */
            .admin-table td.action-buttons {
                justify-content: center;
            }
            
            .admin-table td.action-buttons:before {
                display: none;
            }
            
            /* Improve pagination on small screens */
            .d-flex.justify-content-between.align-items-center.mt-4 {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .items-per-page {
                margin-bottom: 1rem;
                width: 100%;
            }
            
            nav[aria-label="Page navigation"] {
                width: 100%;
                display: flex;
                justify-content: center;
            }
        }
        
        /* Edit product modal responsive */
        @media (max-width: 767.98px) {
            .modal-body .row > .col-md-6 {
                margin-bottom: 1rem;
            }
            
            .edit-image-placeholder {
                height: 150px;
            }
        }
        
        /* Add bottom padding to the container */
        .admin-table-container {
            padding-bottom: 2rem;
        }
    </style>
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
                                    <th>DESCRIPTION</th>
                                    <th>CATEGORY</th>
                                    <th>STOCK</th>
                                    <th>SHELF LOCATION</th>
                                    <th>PRICE</th>
                                    <th style="border-bottom: none;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT p.*, c.category_name 
                                        FROM products p
                                        LEFT JOIN categories c ON p.category_id = c.category_id";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0):
                                    while ($product = $result->fetch_assoc()):
                                        // Simulate stock and shelf if you don't have these columns yet
                                        $stock = $product['product_stock'];
                                        $shelf = $product['product_shelf'];
                                        $stockClass = ($stock > 30) ? 'high' : (($stock > 20) ? 'medium' : (($stock > 10) ? 'low' : 'critical'));
                                        $imagePath = !empty($product['product_image']) ? $product['product_image'] : '../assets/placeholder.png';
                                ?>
                                <tr>
                                    <td data-label="IMAGE">
                                        <div class="product-image">
                                            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="img-fluid">
                                        </div>
                                    </td>
                                    <td data-label="PRODUCT">
                                        <div class="product-name"><?= htmlspecialchars($product['product_name']) ?></div>
                                        <div class="product-sku">SKU: <?= htmlspecialchars($product['product_sku']) ?></div>
                                    </td>
                                    <td data-label="DESCRIPTION"><span class="product-description"><?= htmlspecialchars($product['product_description']) ?></span></td>
                                    <td data-label="CATEGORY"><span class="product-category"><?= htmlspecialchars($product['category_name']) ?></span></td>
                                    <td data-label="STOCK"><span class="stock-badge <?= $stockClass ?>"><?= $stock ?></span></td>
                                    <td data-label="LOCATION"><?= htmlspecialchars($shelf) ?></td>
                                    <td data-label="PRICE"><?= number_format($product['product_price'], 2) ?></td>
                                    <td class="action-buttons no-border" style="border-bottom: none; border-top: none;" data-label="ACTIONS">
                                        <div style="border: none; background: transparent;">
                                            <?= renderActionButtons('product', $product['product_id']) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center">No products found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination UI Placeholder (Static) -->
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
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
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
                    <form id="editProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="productId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="editProductName" class="form-label">PRODUCT NAME</label>
                                    <input type="text" class="form-control" id="editProductName" name="productName" required>
                                </div>

                                <div class="mb-4">
                                    <label for="editCategory" class="form-label">CATEGORY</label>
                                    <input type="text" class="form-control" id="editCategory" name="categ" required>
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
                                    <label for="editPrice" class="form-label">PRICE (₱)</label>
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
                                    <input required type="text" class="form-control" id="editSku" name="sku">
                                </div>
                                <div class="mb-4">
                                    <label for="editDesc" class="form-label">DESCRIPTION</label>
                                    <input type="text" class="form-control" id="editDesc" name="desc">
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