<?php
include 'db_connection.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get message ID
    $messageId = $_POST['messageId'];
    
    // Validate data
    if (empty($messageId)) {
        echo "error_missing_id";
        exit;
    }
    
    // Delete message from database
    $sql = "DELETE FROM chat WHERE chat_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $messageId);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error_db";
    }
    
    $stmt->close();
    exit;
}

echo "error_invalid_request";