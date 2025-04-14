<?php
require 'db_connection.php';

header('Content-Type: application/json');

if (isset($_POST['message'])) {
    $userMessage = strtolower(trim($_POST['message']));

    // Extract keywords from the user message
    function extractKeywords($text) {
        $stopWords = ['i', 'am', 'is', 'are', 'the', 'to', 'a', 'an', 'and', 'or', 'in', 'on', 'of', 'for', 'that', 'with', 'can', 'you', 'your'];
        $words = preg_split('/\W+/', strtolower($text));
        return array_filter(array_diff($words, $stopWords));
    }

    function searchProducts($conn, $keywords) {
        if (empty($keywords)) return [];

        $where = implode(' OR ', array_map(function ($word) {
            return "product_name LIKE '%$word%' OR product_description LIKE '%$word%'";
        }, $keywords));

        $sql = "SELECT product_id, product_name, product_price, product_image FROM products WHERE $where LIMIT 5";
        $result = $conn->query($sql);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    // Function to suggest materials based on project keywords
    // Add more projects and their keywords as needed
    // Example: 'birdhouse' => ['wood', 'nail', 'glue', 'hammer', 'saw', 'paint']
    // your choice of projects or builds

    function suggestMaterialsByProject($conn, $message) {
        $projectSuggestions = [
            'birdhouse' => ['wood', 'nail', 'glue', 'hammer', 'saw', 'paint'],
            'bookshelf' => ['wood', 'screw', 'drill', 'sandpaper', 'stain'],
            'doghouse' => ['plywood', 'roofing', 'nail', 'paint', '2x4', 'shingles'],
            'cabinet' => ['hinge', 'plywood', 'screw', 'handle', 'varnish'],
            'table' => ['leg', 'plywood', 'nail', 'sandpaper', 'wood glue'],
            'fence' => ['wire', 'wood', 'screw', 'paint', 'mesh']
        ];

        foreach ($projectSuggestions as $project => $keywords) {
            if (strpos($message, $project) !== false) {
                $where = implode(' OR ', array_map(function ($word) {
                    return "product_name LIKE '%$word%' OR product_description LIKE '%$word%'";
                }, $keywords));

                $sql = "SELECT product_id, product_name, product_price, product_image 
                        FROM products 
                        WHERE $where 
                        LIMIT 5";
                $result = $conn->query($sql);

                $products = [];
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }

                if (!empty($products)) {
                    $response = "Here are some suggested materials for your <b>$project</b>:<br><br>";
                    foreach ($products as $product) {
                        $response .= "<div class='product-result'>";
                        $response .= "<img src='../admin/{$product['product_image']}' alt='{$product['product_name']}' class='product-image' style='width:60px;height:60px;border-radius:5px;margin-right:10px;'>";
                        $response .= "<div class='product-info' style='display:inline-block;vertical-align:top;'>";
                        $response .= "<a href='product_details.php?product_id={$product['product_id']}' class='product-name' style='font-weight:bold;color:#007bff;text-decoration:none;'>" . htmlspecialchars($product['product_name']) . "</a><br>";
                        $response .= "<span>₱" . number_format($product['product_price'], 2) . "</span>";
                        $response .= "</div></div><br>";
                    }
                    return $response;
                } else {
                    return "I couldn't find any materials for <b>$project</b> right now. Try again later or browse manually.";
                }
            }
        }

        return null;
    }

    // Try suggesting materials based on project keywords
    $response = suggestMaterialsByProject($conn, $userMessage);

    // If no project match, try keyword product search
    if ($response === null) {
        $keywords = extractKeywords($userMessage);
        $products = searchProducts($conn, $keywords);

        if (!empty($products)) {
            $response = "Is this what you're looking for?<br><br>";
            foreach ($products as $product) {
                $response .= "<div class='product-result'>";
                $response .= "<img src='../admin/{$product['product_image']}' alt='{$product['product_name']}' class='product-image' style='width:60px;height:60px;border-radius:5px;margin-right:10px;'>";
                $response .= "<div class='product-info' style='display:inline-block;vertical-align:top;'>";
                $response .= "<a href='product_details.php?product_id={$product['product_id']}' class='product-name' style='font-weight:bold;color:#007bff;text-decoration:none;'>" . htmlspecialchars($product['product_name']) . "</a><br>";
                $response .= "<span>₱" . number_format($product['product_price'], 2) . "</span>";
                $response .= "</div></div><br>";
            }
        } else {
            $response = getBotResponse($userMessage);
        }
    }

    // Save both messages to DB
    $stmt = $conn->prepare("INSERT INTO chat (message, sender_name) VALUES (?, 'Customer')");
    $stmt->bind_param("s", $userMessage);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO chat (message, sender_name) VALUES (?, 'Bot')");
    $stmt->bind_param("s", $response);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'reply' => $response]);
} else {
    echo json_encode(['status' => 'error', 'reply' => 'Invalid request.']);
}

function getBotResponse($message) {
    if (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false || strpos($message, 'hey') !== false) {
        return "Hello! Welcome to TOUCHFIND. How can I help you find hardware supplies today?";
    } elseif (strpos($message, 'help') !== false || strpos($message, 'support') !== false) {
        return "I can help you find tools, hardware supplies, or provide information about our products and services. What are you looking for?";
    } elseif (strpos($message, 'product') !== false || strpos($message, 'find') !== false) {
        return "We have a wide range of hardware products in different categories. You can browse them from the sidebar or use the search function at the top of the page.";
    } elseif (strpos($message, 'tool') !== false || strpos($message, 'tools') !== false) {
        return "We offer professional-grade tools including power drills, circular saws, measuring equipment, and hand tools. Is there a specific tool you're looking for?";
    } elseif (strpos($message, 'price') !== false || strpos($message, 'cost') !== false) {
        return "Our product prices are displayed on each product card. We aim to provide competitive pricing on all our hardware supplies.";
    } elseif (strpos($message, 'order') !== false || strpos($message, 'checkout') !== false) {
        return "To place an order, add items to your cart and then click on the 'Checkout' button in the cart page. We offer Cash payment for your convenience.";
    } elseif (strpos($message, 'payment') !== false || strpos($message, 'pay') !== false) {
        return "We accept PayPal and Cash. All transactions are secure and your information is protected.";
    } elseif (strpos($message, 'return') !== false || strpos($message, 'refund') !== false) {
        return "We have a 30-day return policy for most items. Products must be in original condition with packaging. Contact our support team to initiate a return.";
    } elseif (strpos($message, 'warranty') !== false || strpos($message, 'guarantee') !== false) {
        return "Most of our tools come with a manufacturer's warranty. Details of each product's warranty are listed on the product details page.";
    } elseif (strpos($message, 'paint') !== false || strpos($message, 'painting') !== false) {
        return "We offer a variety of paints, primers, and painting supplies including brushes, rollers, and spray equipment. Our paint brands include premium quality options for all your projects.";
    } elseif (strpos($message, 'hardware') !== false || strpos($message, 'supplies') !== false) {
        return "Our hardware selection includes screws, nails, brackets, hinges, and other essential supplies for construction and repair projects.";
    } elseif (strpos($message, 'plumbing') !== false || strpos($message, 'pipes') !== false) {
        return "We carry plumbing supplies including pipes, fittings, valves, and fixtures for your home improvement needs.";
    } elseif (strpos($message, 'electric') !== false || strpos($message, 'electrical') !== false) {
        return "Our electrical department offers wiring, switches, outlets, and other electrical components for both DIY and professional use.";
    } elseif (strpos($message, 'contact') !== false || strpos($message, 'call') !== false) {
        return "You can contact our support team at support@touchfind.com or call us at 123-456-7890 during business hours (Mon-Fri, 9AM-6PM).";
    } elseif (strpos($message, 'thanks') !== false || strpos($message, 'thank you') !== false) {
        return "You're welcome! Is there anything else I can help you with regarding our hardware products?";
    } elseif (strpos($message, 'bye') !== false || strpos($message, 'goodbye') !== false) {
        return "Thank you for chatting with TOUCHFIND. Feel free to return if you have more questions about our tools and hardware supplies!";
    } else {
        return "I'm sorry, but I couldn't find any products matching your description.";
    }
}