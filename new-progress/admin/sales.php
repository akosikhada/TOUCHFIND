<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Sales</title>
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
                <?php renderAdminHeader('SALES OVERVIEW', 'Search sales...'); ?>
                
                <!-- Sales Overview Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card overview-card">
                            <div class="card-body">
                                <h6 class="overview-title">Total Sales</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="overview-value">₱45,231</h3>
                                    <span class="overview-change positive">
                                        <i class="bi bi-graph-up-arrow"></i>
                                        +12.5%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card overview-card">
                            <div class="card-body">
                                <h6 class="overview-title">Average Order</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="overview-value">₱125</h3>
                                    <span class="overview-change positive">
                                        <i class="bi bi-graph-up-arrow"></i>
                                        +3.2%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card overview-card">
                            <div class="card-body">
                                <h6 class="overview-title">Total Orders</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="overview-value">362</h3>
                                    <span class="overview-change positive">
                                        <i class="bi bi-graph-up-arrow"></i>
                                        +8.4%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card overview-card">
                            <div class="card-body">
                                <h6 class="overview-title">Conversion Rate</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="overview-value">3.8%</h3>
                                    <span class="overview-change negative">
                                        <i class="bi bi-graph-down-arrow"></i>
                                        -2.1%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sales Performance Chart -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Sales Performance</h5>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary">Today</button>
                                <button class="btn btn-sm btn-outline-secondary">Week</button>
                                <button class="btn btn-sm btn-outline-secondary active">Month</button>
                                <button class="btn btn-sm btn-outline-secondary">Year</button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="salesChart" class="sales-chart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Sales Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Recent Sales</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="entriesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Show 10 entries
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="entriesDropdown">
                                    <li><a class="dropdown-item" href="#">Show 10 entries</a></li>
                                    <li><a class="dropdown-item" href="#">Show 25 entries</a></li>
                                    <li><a class="dropdown-item" href="#">Show 50 entries</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover sales-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-001</td>
                                        <td>John Smith</td>
                                        <td>Power Drill</td>
                                        <td>₱89.99</td>
                                        <td><span class="status-badge completed">Completed</span></td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon"><i class="bi bi-three-dots-vertical"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-002</td>
                                        <td>Sarah Johnson</td>
                                        <td>Hammer Set</td>
                                        <td>₱34.99</td>
                                        <td><span class="status-badge pending">Pending</span></td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon"><i class="bi bi-three-dots-vertical"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-003</td>
                                        <td>Mike Wilson</td>
                                        <td>Measuring Tape</td>
                                        <td>₱12.99</td>
                                        <td><span class="status-badge failed">Failed</span></td>
                                        <td>2024-01-14</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon"><i class="bi bi-three-dots-vertical"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-004</td>
                                        <td>Emily Brown</td>
                                        <td>Screwdriver Set</td>
                                        <td>₱45.99</td>
                                        <td><span class="status-badge completed">Completed</span></td>
                                        <td>2024-01-14</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon"><i class="bi bi-three-dots-vertical"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-005</td>
                                        <td>David Lee</td>
                                        <td>Wrench Set</td>
                                        <td>₱67.99</td>
                                        <td><span class="status-badge pending">Pending</span></td>
                                        <td>2024-01-13</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon"><i class="bi bi-three-dots-vertical"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="entries-info">Showing 1 to 5 of 25 entries</div>
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
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Admin JS -->
    <script src="js/admin.js"></script>
</body>
</html>