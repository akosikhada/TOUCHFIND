<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/search.css">
    <title>TouchFind | Search Products</title>
</head>
<body>

    <?php include ("header.php") ?>

    <div class="search-container">
        <form action="search.php" method="GET">
            <input type="text" name="query" autocomplete="off" placeholder="Search for products or categories..." required>
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="search-results">
        <?php
        include 'db_connection.php';

        if (isset($_GET['query'])) {
            $search_query = $_GET['query'];

            $sql = "SELECT p.product_id, p.product_name, p.product_description, p.product_image, p.product_price, c.category_name 
                    FROM products p
                    JOIN categories c ON p.category_id = c.category_id
                    WHERE p.product_name LIKE ? OR c.category_name LIKE ?";
            
            $stmt = $conn->prepare($sql);
            $search_param = "%$search_query%";
            $stmt->bind_param("ss", $search_param, $search_param);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='view_product.php?id=" . htmlspecialchars($row['product_id']) . "' class='product-link'>";
                    echo "<div class='product'>";
                    echo "<img src='" . htmlspecialchars($row['product_image']) . "' alt='" . htmlspecialchars($row['product_name']) . "'>";
                    echo "<h2>" . htmlspecialchars($row['product_name']) . "</h2>";
                    echo "<p>Price: ₱" . htmlspecialchars($row['product_price']) . "</p>";
                    echo "<p>" . htmlspecialchars($row['category_name']) . "</p>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "<p>No results found for '" . htmlspecialchars($search_query) . "'.</p>";
            }

            $stmt->close();
        }

        $conn->close();
        ?>
    </div>

    <?php if (isset($_GET['query'])): ?>
    <div class="search-again-container">
        <button onclick="window.location.href='search.php'">Search Again</button>
    </div>
    <?php endif; ?>

    <?php include ("footer.php") ?>
</body>
</html>