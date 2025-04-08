<?php
include 'db_connection.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;
$offset = ($page - 1) * $itemsPerPage;

$countSql = "SELECT COUNT(*) as total FROM chat";
$countResult = $conn->query($countSql);
$totalMessages = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalMessages / $itemsPerPage);

$sql = "SELECT * FROM chat ORDER BY chat_time DESC LIMIT $offset, $itemsPerPage";
$result = $conn->query($sql);

$messages = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

if(isset($_GET['format']) && $_GET['format'] == 'json') {
    header('Content-Type: application/json');
    echo json_encode([
        'messages' => $messages,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'items_per_page' => $itemsPerPage,
            'total_items' => $totalMessages
        ]
    ]);
    exit;
}
?>