<?php
require_once 'components/db_connection.php';

// Paid orders for analytics (Total Sales, Avg Order, etc.)
$sql = "SELECT o.*, oi.product_name, oi.price, oi.quantity AS product_qty 
        FROM orders o 
        JOIN order_items oi ON o.order_id = oi.order_id 
        WHERE o.status = 'paid'
        ORDER BY o.created_at DESC";

$result = $conn->query($sql);

$orders = [];
$totalSales = 0;
$totalOrders = 0;
$avgOrderAmount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
        $totalSales += $row['price'] * $row['product_qty'];
    }
    $totalOrders = count(array_unique(array_column($orders, 'order_id')));
    $avgOrderAmount = $totalOrders ? ($totalSales / $totalOrders) : 0;
}

// All orders for the Recent Orders table (paid + unpaid)
$sqlAllOrders = "SELECT o.*, oi.product_name, oi.price, oi.quantity AS product_qty 
                 FROM orders o 
                 JOIN order_items oi ON o.order_id = oi.order_id 
                 ORDER BY o.created_at DESC";

$resultAllOrders = $conn->query($sqlAllOrders);

$allOrders = [];
if ($resultAllOrders->num_rows > 0) {
    while ($row = $resultAllOrders->fetch_assoc()) {
        $allOrders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TOUCHFIND | Sales</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>
<?php include 'components/admin_header.php'; ?>
<div class="d-flex admin-dashboard">
    <aside class="admin-sidebar">
        <?php include 'components/admin_sidebar.php'; ?>
    </aside>
    <main class="admin-main">
        <div class="container-fluid px-4 py-4">
            <h1 class="admin-page-title mb-4">SALES OVERVIEW</h1>

            <div class="row mb-4">
                <div class="col-md-3"><div class="card"><div class="card-body"><h6>Total Sales</h6><h3>₱<?= number_format($totalSales, 2) ?></h3></div></div></div>
                <div class="col-md-3"><div class="card"><div class="card-body"><h6>Average Order</h6><h3>₱<?= number_format($avgOrderAmount, 2) ?></h3></div></div></div>
                <div class="col-md-3"><div class="card"><div class="card-body"><h6>Total Orders</h6><h3><?= $totalOrders ?></h3></div></div></div>
                <div class="col-md-3"><div class="card"><div class="card-body"><h6>Conversion Rate</h6><h3 id="conversionRate">Loading...</h3></div></div></div>
            </div>

            <!-- Sales Chart -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title">Sales Performance</h5>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-primary" onclick="loadSalesData('today')">Today</button>
                            <button class="btn btn-outline-primary" onclick="loadSalesData('week')">Week</button>
                            <button class="btn btn-outline-primary active" onclick="loadSalesData('month')">Month</button>
                            <button class="btn btn-outline-primary" onclick="loadSalesData('year')">Year</button>
                        </div>
                    </div>
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>

            <!-- All Orders Table -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Orders</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($allOrders)): ?>
                                    <?php foreach ($allOrders as $o): ?>
                                        <tr>
                                            <td><?= $o['order_number'] ?></td>
                                            <td><?= htmlspecialchars($o['product_name']) ?></td>
                                            <td class="text-center"><?= $o['product_qty'] ?></td>
                                            <td class="text-center">
                                                <?php if ($o['status'] === 'paid'): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Unpaid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>₱<?= number_format($o['price'] * $o['product_qty'], 2) ?></td>
                                            <td><?= date('M d, Y', strtotime($o['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center">No orders found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chart;

function loadSalesData(range = 'month') {
    fetch(`get_sales_data.php?range=${range}`)
        .then(res => res.json())
        .then(data => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: data.label,
                        data: data.sales,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => '₱' + value.toLocaleString()
                            }
                        }
                    }
                }
            });

            // Update conversion rate
            document.getElementById('conversionRate').innerText = `${data.conversionRate}%`;

            // Highlight selected time range button
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector(`.btn-group .btn[onclick*="${range}"]`)?.classList.add('active');
        });
}

// Auto-load Month view on page load
window.onload = () => loadSalesData('month');
</script>
</body>
</html>