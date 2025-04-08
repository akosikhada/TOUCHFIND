<?php
include 'db_connection.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $messageId = $_POST['messageId'];
    $sender = $_POST['sender'];
    $message = $_POST['message'];
    
    // Validate data
    if (empty($messageId) || empty($sender) || empty($message)) {
        echo "error_missing_data";
        exit;
    }
    
    // Update message in database
    $sql = "UPDATE chat SET sender_name = ?, message = ? WHERE chat_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $sender, $message, $messageId);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error_db";
    }
    
    $stmt->close();
    exit;
}

echo "error_invalid_request";