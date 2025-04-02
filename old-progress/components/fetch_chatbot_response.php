<?php
// fetch_chatbot_response.php
header('Content-Type: application/json'); // Ensure the response is JSON

// Include the database connection file
require 'db_connection.php';

// Log the received message
error_log("Received message: " . file_get_contents('php://input'));

// Get the user's message from the request
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['message'])) {
    error_log("Invalid request data");
    echo json_encode(['response' => "Sorry, I couldn't process your request."]);
    exit;
}

$message = strtolower(trim($data['message'])); // Trim whitespace and convert to lowercase

// Function to fetch categories from the database
function fetchCategories($conn) {
    $query = "SELECT category_name FROM categories";
    $result = $conn->query($query);
    if (!$result) {
        error_log("Error fetching categories: " . $conn->error);
        return [];
    }
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = strtolower(trim($row['category_name'])); // Store categories in lowercase
    }
    return $categories;
}

// Function to fetch products by category
function fetchProductsByCategory($conn, $categoryName) {
    $query = "SELECT p.product_name, p.product_id 
              FROM products p 
              JOIN categories c ON p.category_id = c.category_id 
              WHERE c.category_name = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Error preparing query: " . $conn->error);
        return [];
    }
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Store the entire row to access product_id later
    }
    return $products;
}

// Function to check if a product exists and get its category
function getProductCategory($conn, $productName) {
    $query = "SELECT c.category_name 
              FROM products p 
              JOIN categories c ON p.category_id = c.category_id 
              WHERE p.product_name LIKE ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Error preparing query: " . $conn->error);
        return null;
    }
    $likeProductName = "%" . $productName . "%"; // Use LIKE for partial matches
    $stmt->bind_param("s", $likeProductName);
    $stmt->execute();
    $stmt->bind_result($categoryName);
    $stmt->fetch();
    $stmt->close();
    return $categoryName;
}

// Determine the response based on the user's message
$response = "";
if (strpos($message, "categories") !== false) {
    // Fetch and display categories
    $categories = fetchCategories($conn);
    $response = "Here are the categories: " . implode(", ", $categories) . ". Which category are you interested in?";
} else {
    // Check if the user input matches a category
    $categories = fetchCategories($conn);
    $isCategory = in_array($message, $categories);

    if ($isCategory) {
        // Fetch and display products in the specified category
        $products = fetchProductsByCategory($conn, ucfirst($message)); // Use ucfirst to match the original case
        if (!empty($products)) {
            $productLinks = [];
            foreach ($products as $product) {
                // Create clickable links for each product
                $productLinks[] = "<a href='view_product.php?id=" . $product['product_id'] . "'>" . htmlspecialchars($product['product_name']) . "</a>";
            }
            $response = "Here are the products available in the $message category: " . implode(", ", $productLinks) . ".";
        } else {
            $response = "Sorry, there are no products available in the $message category.";
        }
    } else {
        // Check if the user input matches a product
        $categoryName = getProductCategory($conn, $message);
        if ($categoryName) {
            $response = "Is $message a $categoryName? If yes, here are the products in the $categoryName category: " . implode(", ", fetchProductsByCategory($conn, $categoryName)) . ".";
        } else {
            $response = "I couldn't find '$message' in our database . Please try again.";
        }
    }
}

// Return the response as JSON
echo json_encode(['response' => $response]);

// Close the database connection
$conn->close();
?>