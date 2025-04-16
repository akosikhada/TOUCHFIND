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
    <title>TOUCHFIND | Order List</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
    <link href="css/admin.css" rel="stylesheet">
    <link href="css/order_list.css" rel="stylesheet">
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
                <div class="admin-header-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="admin-page-title mb-0">LIST OF ORDERS</h1>
                        <div class="d-flex align-items-center">
                            <div class="search-box me-2">
                                <input type="text" class="form-control search-input" placeholder="Search orders...">
                                <i class="bi bi-search search-icon"></i>
                            </div>
                            <button class="btn btn-outline-secondary filter-button d-flex align-items-center">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile search layout -->
                <div class="search-container d-md-none">
                    <h1 class="admin-page-title mb-3">LIST OF ORDERS</h1>
                    <div class="search-box-wrapper mb-3">
                        <input type="text" class="search-input" placeholder="Search orders...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                    <div class="filter-button-wrapper">
                        <button class="filter-button">
                            <i class="bi bi-funnel"></i> Filter Orders
                        </button>
                    </div>
                </div>
                
                <!-- Notifications container -->
                <div id="notifications-container" class="mb-3"></div>

                <!-- Product List Table -->
                <div class="admin-table-card card">
                    <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table admin-table product-table">
                            <thead>
                                <tr>
                                    <th width="15%">ORDER ID</th>
                                    <th width="15%">ORDER NUMBER</th>
                                    <th>TOTAL AMOUNT</th>
                                    <th>QUANTITY</th>
                                    <th width="18%">TIMESTAMP</th>
                                    <th>STATUS</th>
                                    <th width="15%" class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Mock data for demonstration
                                $mockData = [
                                    'order_id' => '1001',
                                    'order_number' => 'ORD-2023-5678',
                                    'total_amount' => 1250.75,
                                    'quantity' => 3,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'status' => 'paid'
                                ];
                                
                                $sql = "SELECT * FROM orders";
                                $result = $conn->query($sql);

                                // Show mock data if no real data exists
                                if ($result && $result->num_rows > 0):
                                    while ($order = $result->fetch_assoc()):
                                        $status = $order['status'] ?? 'unpaid';
                                        $statusClass = ($status == 'paid') ? 'high' : 'critical';
                                ?>
                                <tr data-order-id="<?= $order['order_id'] ?>">
                                    <td data-label="ORDER ID"><?= $order['order_id'] ?></td>
                                    <td data-label="ORDER NUMBER">
                                        <a href="#" onclick="showOrderDetails(<?= $order['order_id'] ?>)" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                            <?= htmlspecialchars($order['order_number']) ?>
                                        </a>
                                    </td>
                                    <td data-label="TOTAL AMOUNT"><span class="price-value">₱<?= number_format($order['total_amount'], 2) ?></span></td>
                                    <td data-label="QUANTITY"><?= $order['quantity'] ?></td>
                                    <td data-label="TIMESTAMP"><?= isset($order['created_at']) ? date('M d, Y h:i A', strtotime($order['created_at'])) : 'N/A' ?></td>
                                    <td data-label="STATUS"><span class="stock-badge <?= $statusClass ?>"><?= ucfirst($status) ?></span></td>
                                    <td class="action-buttons text-center" data-label="ACTIONS">
                                        <div class="action-buttons-container">
                                            <?php if ($status == 'unpaid'): ?>
                                            <button class="btn btn-action edit-btn" onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'paid')">Paid</button>
                                            <?php else: ?>
                                            <button class="btn btn-danger" onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'delete')">Delete</button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    endwhile;
                                else:
                                    // Display mock data
                                    $order = $mockData;
                                    $status = $order['status'] ?? 'unpaid';
                                    $statusClass = ($status == 'paid') ? 'high' : 'critical';
                                ?>
                                <tr data-order-id="<?= $order['order_id'] ?>">
                                    <td><?= $order['order_id'] ?></td>
                                    <td>
                                        <a href="#" onclick="showOrderDetails(<?= $order['order_id'] ?>)" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                                            <?= htmlspecialchars($order['order_number']) ?>
                                        </a>
                                    </td>
                                    <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></td>
                                    <td><span class="stock-badge <?= $statusClass ?>"><?= ucfirst($status) ?></span></td>
                                    <td class="text-center">
                                        <div class="action-buttons-container">
                                            <?php if ($status == 'unpaid'): ?>
                                            <button class="btn btn-action edit-btn" onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'paid')">Paid</button>
                                            <?php else: ?>
                                            <button class="btn btn-danger" onclick="deleteOrder(<?= $order['order_id'] ?>)">Delete</button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                endif; 
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Order Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="orderDetailsContent">Loading...</div>
                        </div>
                    </div>
                </div>

                <!-- Pagination UI -->
                <div class="card admin-table-card">
                    <div class="card-body py-3">
                        <div class="d-flex pagination-container">
                            <div class="items-per-page me-auto">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Items per page</span>
                                    <select class="form-select form-select-sm">
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="pagination-wrapper">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
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

    <script>
        function showOrderDetails(orderId) {
            const container = document.getElementById('orderDetailsContent');
            container.innerHTML = "Loading...";

            fetch('get_order_details.php?order_id=' + orderId)
                .then(res => res.text())
                .then(data => container.innerHTML = data)
                .catch(() => container.innerHTML = "Failed to load order details.");
        }

        function updateOrderStatus(orderId, newStatus) {
            fetch('update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `order_id=${orderId}&status=${newStatus}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Simple solution: refresh to reflect changes
                }
            });
        }

        function deleteOrder(orderId) {
            if (!confirm("Are you sure you want to delete this order?")) return;

            fetch('delete_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `order_id=${orderId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`tr[data-order-id="${orderId}"]`).remove();
                } else {
                    alert("Failed to delete order.");
                }
            });
        }
    </script>
    
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="productId">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editProductName" class="form-label fw-medium">Product Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control" id="editProductName" name="productName" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="editCategory" class="form-label fw-medium">Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-folder"></i></span>
                                        <select class="form-select" id="editCategory" name="categ" required>
                                            <option value="">Select category...</option>
                                            <?php 
                                            $catQuery = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
                                            while($cat = $catQuery->fetch_assoc()): 
                                            ?>
                                                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editStock" class="form-label fw-medium">Stock</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-boxes"></i></span>
                                    <input type="number" class="form-control" id="editStock" name="stock" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editShelfLocation" class="form-label fw-medium">Shelf Location</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                        <select class="form-select" id="editShelfLocation" name="shelfLocation" required>
                                            <option value="">Select shelf location...</option>
                                            <option value="A1">Aisle A, Shelf 1</option>
                                            <option value="A2">Aisle A, Shelf 2</option>
                                            <option value="A3">Aisle A, Shelf 3</option>
                                            <option value="B1">Aisle B, Shelf 1</option>
                                            <option value="B2">Aisle B, Shelf 2</option>
                                            <option value="B3">Aisle B, Shelf 3</option>
                                            <option value="C1">Aisle C, Shelf 1</option>
                                            <option value="C2">Aisle C, Shelf 2</option>
                                            <option value="C3">Aisle C, Shelf 3</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <label for="editPrice" class="form-label fw-medium">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₱</span>
                                    <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editProductImage" class="form-label fw-medium">Product Image</label>
                                    <div class="card">
                                        <div class="card-body p-0 overflow-hidden">
                                            <div class="product-image-upload bg-light p-4 text-center position-relative" onclick="document.getElementById('editProductImage').click()">
                                        <input type="file" class="d-none" id="editProductImage" name="productImage">
                                                <div class="product-image-placeholder edit-image-placeholder">
                                                    <i class="bi bi-image fs-2 text-muted mb-2 d-block"></i>
                                                    <p class="mb-0">Click image to change</p>
                                                </div>
                                                <small class="text-muted d-block mt-3">Click image to change</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="editSku" class="form-label fw-medium">SKU</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">#</span>
                                    <input required type="text" class="form-control" id="editSku" name="sku">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="description-container mt-4">
                            <div class="card">
                                <div class="card-header bg-light py-3">
                                    <label for="editDesc" class="form-label fw-bold mb-0">Product Description</label>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control border-0" id="editDesc" name="desc"></textarea>
                                    <small class="text-muted mt-2 d-block">Enter a detailed description of the product including features, specifications, and usage instructions.</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end border-top">
                    <button type="button" class="btn btn-primary px-4 py-2" id="saveProductChanges">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <?php echo renderDeleteModal('product'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifications system
            window.showNotification = function(message, type = 'success') {
                const notificationsContainer = document.getElementById('notifications-container');
                
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show`;
                notification.role = 'alert';
                
                // Add icon based on type
                let icon = 'check-circle';
                if (type === 'danger') icon = 'exclamation-triangle';
                if (type === 'warning') icon = 'exclamation-circle';
                if (type === 'info') icon = 'info-circle';
                
                notification.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi bi-${icon} me-2"></i>
                        <div>${message}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                notificationsContainer.appendChild(notification);
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
            };
            
            // Handle search functionality for both desktop and mobile
            const searchInputs = document.querySelectorAll('.search-input');
            
            // Add event listeners to all search inputs
            searchInputs.forEach(input => {
                // Search on input change
                input.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    searchOrders(searchTerm);
                });
                
                // Search when Enter key is pressed
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.toLowerCase().trim();
                        searchOrders(searchTerm);
                        e.preventDefault();
                    }
                });
            });
            
            // Make search icons clickable
            document.querySelectorAll('.search-icon').forEach(icon => {
                icon.style.cursor = 'pointer';
                icon.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.search-input');
                    const searchTerm = input.value.toLowerCase().trim();
                    searchOrders(searchTerm);
                });
            });
            
            function searchOrders(searchTerm) {
                const tableRows = document.querySelectorAll('.product-table tbody tr');
                let matches = 0;
                
                tableRows.forEach(row => {
                    let found = false;
                    const cells = row.querySelectorAll('td');
                    
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });
                    
                    if (found) {
                        row.style.display = '';
                        matches++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show feedback about search results
                if (searchTerm.length > 0) {
                    if (matches === 0) {
                        showNotification(`No orders match "${searchTerm}"`, 'warning');
                    }
                }
            }
            
            // Handle filter buttons
            const filterButtons = document.querySelectorAll('.filter-button, .btn-filter');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Implement filter functionality here
                    showNotification('Filter functionality will be implemented soon', 'info');
                });
            });
            
            // Enhanced desktop interactions
            if (window.innerWidth >= 992) {
                // Add row hover effects
                const tableRows = document.querySelectorAll('.admin-table tbody tr');
                tableRows.forEach(row => {
                    row.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-1px)';
                        this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.05)';
                        this.style.transition = 'all 0.2s ease';
                    });
                    
                    row.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
                    });
                });
            }
        });
    </script>
    <script>
        function showOrderDetails(orderId) {
            const container = document.getElementById('orderDetailsContent');
            container.innerHTML = "Loading...";

            fetch('get_order_details.php?order_id=' + orderId)
                .then(res => res.text())
                .then(html => {
                    container.innerHTML = html;
                });
        }
    </script>
    <script>
        function updateOrderStatus(orderId, newStatus) {
            if (newStatus === 'delete') {
                if (!confirm("Are you sure you want to remove this order?")) return;

                fetch('delete_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `order_id=${orderId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`tr[data-order-id="${orderId}"]`).remove();
                        showNotification("Order has been deleted.", "success");
                    }
                });
                return;
            }

            fetch('update_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `order_id=${orderId}&status=${newStatus}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                    const badge = row.querySelector('.stock-badge');
                    const actions = row.querySelector('.action-buttons-container');

                    // Update badge style & text
                    badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    badge.className = 'stock-badge ' + (newStatus === 'paid' ? 'high' : 'critical');

                    // Update buttons
                    if (newStatus === 'paid') {
                        actions.innerHTML = `
                            <button class="btn btn-danger" onclick="updateOrderStatus(${orderId}, 'delete')">Delete</button>
                        `;

                        // Show success message
                        showNotification("The order is now updated to Paid!", "success");
                    }
                }
            });
        }
    </script>
    
</body>
</html>