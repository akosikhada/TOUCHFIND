<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Delivery Updates</title>
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
            
            /* Hide less important columns on medium screens */
            table.admin-table colgroup {
                display: none;
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
            /* Card-based layout for mobile */
            .admin-table thead {
                display: none; /* Hide table headers on mobile */
            }
            
            .admin-table tbody tr {
                display: block;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: 0.25rem;
                margin-bottom: 1rem;
                padding: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            }
            
            .admin-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                /* border: none; */
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
            
            /* Special styling for status badges */
            .admin-table td .status-badge {
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
                <?php renderAdminHeader('DELIVERY UPDATES', 'Search deliveries...'); ?>
                
                <!-- Delivery Updates Table -->
                <div class="admin-table-container">
                    <div class="table-responsive">
                        <table class="table admin-table">
                            <colgroup>
                                <col style="width: 12%">
                                <col style="width: 15%">
                                <col style="width: 30%">
                                <col style="width: 13%">
                                <col style="width: 18%">
                                <col style="width: 12%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>CUSTOMER</th>
                                    <th>DELIVERY ADDRESS</th>
                                    <th>STATUS</th>
                                    <th>ESTIMATED DELIVERY</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Sample delivery data
                                $deliveries = [
                                    [
                                        'id' => 1,
                                        'order_id' => 'ORD-10051',
                                        'customer' => 'John Anderson',
                                        'address' => '123 Main St, New York, NY 10001',
                                        'status' => 'In Transit',
                                        'class' => 'in-transit',
                                        'date' => 'Jan 25, 2024'
                                    ],
                                    [
                                        'id' => 2,
                                        'order_id' => 'ORD-10052',
                                        'customer' => 'Sarah Wilson',
                                        'address' => '456 Park Ave, Boston, MA 02108',
                                        'status' => 'Delivered',
                                        'class' => 'delivered',
                                        'date' => 'Jan 24, 2024'
                                    ],
                                    [
                                        'id' => 3,
                                        'order_id' => 'ORD-10053',
                                        'customer' => 'Michael Brown',
                                        'address' => '789 Oak Rd, Chicago, IL 60601',
                                        'status' => 'Pending',
                                        'class' => 'pending',
                                        'date' => 'Jan 26, 2024'
                                    ],
                                    [
                                        'id' => 4,
                                        'order_id' => 'ORD-10054',
                                        'customer' => 'Emily Davis',
                                        'address' => '321 Pine St, San Francisco, CA 94101',
                                        'status' => 'In Transit',
                                        'class' => 'in-transit',
                                        'date' => 'Jan 25, 2024'
                                    ],
                                    [
                                        'id' => 5,
                                        'order_id' => 'ORD-10055',
                                        'customer' => 'Robert Miller',
                                        'address' => '654 Elm St, Seattle, WA 98101',
                                        'status' => 'Delivered',
                                        'class' => 'delivered',
                                        'date' => 'Jan 23, 2024'
                                    ],
                                    [
                                        'id' => 6,
                                        'order_id' => 'ORD-10056',
                                        'customer' => 'Lisa Taylor',
                                        'address' => '987 Cedar Ave, Miami, FL 33101',
                                        'status' => 'Pending',
                                        'class' => 'pending',
                                        'date' => 'Jan 27, 2024'
                                    ],
                                    [
                                        'id' => 7,
                                        'order_id' => 'ORD-10057',
                                        'customer' => 'David Clark',
                                        'address' => '147 Maple Dr, Houston, TX 77001',
                                        'status' => 'In Transit',
                                        'class' => 'in-transit',
                                        'date' => 'Jan 26, 2024'
                                    ],
                                    [
                                        'id' => 8,
                                        'order_id' => 'ORD-10058',
                                        'customer' => 'Jennifer White',
                                        'address' => '258 Birch Ln, Denver, CO 80201',
                                        'status' => 'Delivered',
                                        'class' => 'delivered',
                                        'date' => 'Jan 24, 2024'
                                    ]
                                ];
                                
                                foreach ($deliveries as $delivery): ?>
                                <tr>
                                    <td data-label="ORDER ID"><?php echo $delivery['order_id']; ?></td>
                                    <td data-label="CUSTOMER"><?php echo $delivery['customer']; ?></td>
                                    <td data-label="ADDRESS"><?php echo $delivery['address']; ?></td>
                                    <td data-label="STATUS"><span class="status-badge <?php echo $delivery['class']; ?>"><?php echo $delivery['status']; ?></span></td>
                                    <td data-label="DELIVERY DATE"><?php echo $delivery['date']; ?></td>
                                    <td class="action-buttons" data-label="ACTIONS">
                                        <?php echo renderActionButtons('delivery', $delivery['id']); ?>
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

    <!-- Edit Delivery Modal -->
    <div class="modal fade" id="editDeliveryModal" tabindex="-1" aria-labelledby="editDeliveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDeliveryModalLabel">EDIT DELIVERY</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editDeliveryForm">
                        <input type="hidden" id="editDeliveryId" name="deliveryId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="editOrderId" class="form-label">ORDER ID</label>
                                    <input type="text" class="form-control" id="editOrderId" name="orderId" readonly>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editCustomerName" class="form-label">CUSTOMER</label>
                                    <input type="text" class="form-control" id="editCustomerName" name="customerName" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editDeliveryAddress" class="form-label">DELIVERY ADDRESS</label>
                                    <textarea class="form-control" id="editDeliveryAddress" name="deliveryAddress" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="editDeliveryStatus" class="form-label">STATUS</label>
                                    <select class="form-select" id="editDeliveryStatus" name="deliveryStatus" required>
                                        <option value="In Transit">In Transit</option>
                                        <option value="Delivered">Delivered</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editEstimatedDelivery" class="form-label">ESTIMATED DELIVERY</label>
                                    <input type="date" class="form-control" id="editEstimatedDelivery" name="estimatedDelivery" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="editDeliveryNotes" class="form-label">DELIVERY NOTES</label>
                                    <textarea class="form-control" id="editDeliveryNotes" name="deliveryNotes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-save" id="saveDeliveryChanges">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Delivery Modal -->
    <?php echo renderDeleteModal('delivery'); ?>
</body>
</html>