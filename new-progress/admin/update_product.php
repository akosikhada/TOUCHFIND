<?php
require_once 'components/db_connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['productId'];
    $name = $_POST['productName'];
    $category = $_POST['categ'];
    $stock = $_POST['stock'];
    $shelf = $_POST['shelfLocation'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $sku = $_POST['sku'];

    $targetPath = null;

    // Validate required fields
    if (empty($id) || empty($name) || empty($category) || empty($stock) || empty($price)) {
        echo "error: Missing required fields.";
        exit;
    }

    // Fetch current image path
    $stmt = $conn->prepare("SELECT product_image FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentImagePath);
    $stmt->fetch();
    $stmt->close();

    // Fetch category_id if category name is provided
    if (!is_numeric($category)) {
        $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_name = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $stmt->bind_result($categoryId);
        $stmt->fetch();
        $stmt->close();

        if (!$categoryId) {
            echo "error: Invalid category.";
            exit;
        }
        $category = $categoryId;
    }

    // Check and move uploaded image
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'products/';
        $imgName = time() . '_' . basename($_FILES["productImage"]["name"]);
        $targetPath = $uploadDir . $imgName;

        if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetPath)) {
            echo "error: Failed to upload image.";
            exit;
        }
    } else {
        // Use the existing image path if no new image is uploaded
        $targetPath = $currentImagePath;
    }

    // Prepare the SQL query
    if ($targetPath) {
        $stmt = $conn->prepare("UPDATE products SET product_name=?, category_id=?, product_stock=?, product_shelf=?, product_price=?, product_description=?, product_sku=?, product_image=? WHERE product_id=?");
        $stmt->bind_param("siisdsssi", $name, $category, $stock, $shelf, $price, $desc, $sku, $targetPath, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET product_name=?, category_id=?, product_stock=?, product_shelf=?, product_price=?, product_description=?, product_sku=? WHERE product_id=?");
        $stmt->bind_param("siisdssi", $name, $category, $stock, $shelf, $price, $desc, $sku, $id);
    }

    // Execute the query and handle errors
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>