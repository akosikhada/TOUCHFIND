<?php
require_once 'components/db_connection.php';

header('Content-Type: application/json');

$range = $_GET['range'] ?? 'month'; // default to month

$labels = [];
$sales = [];
$labelTitle = '';

// SQL for chart data
switch ($range) {
    case 'today':
        $labelTitle = 'Today\'s Sales (Hourly)';
        $sql = "SELECT HOUR(created_at) as label, SUM(oi.price * oi.quantity) as total
                FROM orders o
                JOIN order_items oi ON o.order_id = oi.order_id
                WHERE o.status = 'paid' AND DATE(o.created_at) = CURDATE()
                GROUP BY HOUR(o.created_at)";
        break;

    case 'week':
        $labelTitle = 'This Week\'s Sales (Daily)';
        $sql = "SELECT DATE(created_at) as label, SUM(oi.price * oi.quantity) as total
                FROM orders o
                JOIN order_items oi ON o.order_id = oi.order_id
                WHERE o.status = 'paid' AND YEARWEEK(o.created_at, 1) = YEARWEEK(CURDATE(), 1)
                GROUP BY DATE(o.created_at)";
        break;

    case 'year':
        $labelTitle = 'This Year\'s Sales (Monthly)';
        $sql = "SELECT DATE_FORMAT(created_at, '%b') as label, SUM(oi.price * oi.quantity) as total
                FROM orders o
                JOIN order_items oi ON o.order_id = oi.order_id
                WHERE o.status = 'paid' AND YEAR(o.created_at) = YEAR(CURDATE())
                GROUP BY MONTH(o.created_at)";
        break;

    default: // month
        $labelTitle = 'This Month\'s Sales (Daily)';
        $sql = "SELECT DATE(created_at) as label, SUM(oi.price * oi.quantity) as total
                FROM orders o
                JOIN order_items oi ON o.order_id = oi.order_id
                WHERE o.status = 'paid' AND MONTH(o.created_at) = MONTH(CURDATE()) AND YEAR(o.created_at) = YEAR(CURDATE())
                GROUP BY DATE(o.created_at)";
        break;
}

// Fetch chart data
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['label'];
    $sales[] = (float) $row['total'];
}

// Calculate conversion rate
$sqlPaidOrders = "SELECT COUNT(DISTINCT order_id) AS paid_orders FROM orders WHERE status = 'paid'";
$resultPaidOrders = $conn->query($sqlPaidOrders);
$rowPaid = $resultPaidOrders->fetch_assoc();
$totalPaidOrders = $rowPaid['paid_orders'] ?? 0;

$sqlTotalOrders = "SELECT COUNT(DISTINCT order_id) AS total_orders FROM orders";
$resultTotalOrders = $conn->query($sqlTotalOrders);
$rowTotalOrders = $resultTotalOrders->fetch_assoc();
$allOrdersCount = $rowTotalOrders['total_orders'] ?? 0;

$conversionRate = ($allOrdersCount > 0) ? round(($totalPaidOrders / $allOrdersCount) * 100, 2) : 0;

// Send JSON
echo json_encode([
    'label' => $labelTitle,
    'labels' => $labels,
    'sales' => $sales,
    'conversionRate' => $conversionRate
]);