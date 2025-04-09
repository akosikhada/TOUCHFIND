<?php

$host = 'localhost';
$dbname = 'touchfind_kiosk';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Update cart count in session since javascript is not used in this file
if (!isset($_SESSION['cart_count'])) {
    $countSql = "SELECT COUNT(*) as count FROM cart";
    $countResult = $conn->query($countSql);
    $countData = $countResult->fetch_assoc();
    $_SESSION['cart_count'] = $countData['count'];
}
?>