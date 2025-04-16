-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 06:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `touchfind_kiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_email`, `admin_password`) VALUES
(1, 'admin2025@gmail.com', 'admin2025');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` enum('PayPal','Cash') NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Tools'),
(2, 'Wires'),
(3, 'Paints'),
(4, 'Faucet'),
(5, 'Tiles'),
(6, 'Pipes'),
(7, 'Materials');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `chat_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL,
  `sender_name` enum('Customer','Bot') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chat_id`, `chat_time`, `message`, `sender_name`) VALUES
(1, '2025-04-14 06:59:10', 'hello', 'Customer'),
(2, '2025-04-14 06:59:10', 'Hello! Welcome to TOUCHFIND. How can I help you find hardware supplies today?', 'Bot'),
(3, '2025-04-14 06:59:30', 'i want to build a birdhouse is there a materials for it?', 'Customer'),
(4, '2025-04-14 06:59:30', 'Here are some suggested materials for your <b>birdhouse</b>:<br><br><div class=\'product-result\'><img src=\'../admin/products/1743911812_Hammer.png\' alt=\'Hammer\' class=\'product-image\' style=\'width:60px;height:60px;border-radius:5px;margin-right:10px;\'><div class=\'product-info\' style=\'display:inline-block;vertical-align:top;\'><a href=\'product_details.php?product_id=1\' class=\'product-name\' style=\'font-weight:bold;color:#007bff;text-decoration:none;\'>Hammer</a><br><span>₱150.00</span></div></div><br><div class=\'product-result\'><img src=\'../admin/products/1744022501_chainsaw.png\' alt=\'Chainsaw\' class=\'product-image\' style=\'width:60px;height:60px;border-radius:5px;margin-right:10px;\'><div class=\'product-info\' style=\'display:inline-block;vertical-align:top;\'><a href=\'product_details.php?product_id=4\' class=\'product-name\' style=\'font-weight:bold;color:#007bff;text-decoration:none;\'>Chainsaw</a><br><span>₱1,500.00</span></div></div><br>', 'Bot'),
(5, '2025-04-16 04:20:48', 'hey can you help me find the building materials for creating a birdhouse', 'Customer'),
(6, '2025-04-16 04:20:48', 'Here are some suggested materials for your <b>birdhouse</b>:<br><br><div class=\'product-result\'><img src=\'../admin/products/1744708752_chainsaw.png\' alt=\'Chainsaw\' class=\'product-image\' style=\'width:60px;height:60px;border-radius:5px;margin-right:10px;\'><div class=\'product-info\' style=\'display:inline-block;vertical-align:top;\'><a href=\'product_details.php?product_id=1\' class=\'product-name\' style=\'font-weight:bold;color:#007bff;text-decoration:none;\'>Chainsaw</a><br><span>₱5,750.00</span></div></div><br><div class=\'product-result\'><img src=\'../admin/products/1744715379_Birch_Plywood-removebg-preview.png\' alt=\'Birch Plywood 6mm\' class=\'product-image\' style=\'width:60px;height:60px;border-radius:5px;margin-right:10px;\'><div class=\'product-info\' style=\'display:inline-block;vertical-align:top;\'><a href=\'product_details.php?product_id=3\' class=\'product-name\' style=\'font-weight:bold;color:#007bff;text-decoration:none;\'>Birch Plywood 6mm</a><br><span>₱5,999.00</span></div></div><br><div class=\'product-result\'><img src=\'../admin/products/1744715387_Nails-removebg-preview.png\' alt=\'Nails\' class=\'product-image\' style=\'width:60px;height:60px;border-radius:5px;margin-right:10px;\'><div class=\'product-info\' style=\'display:inline-block;vertical-align:top;\'><a href=\'product_details.php?product_id=4\' class=\'product-name\' style=\'font-weight:bold;color:#007bff;text-decoration:none;\'>Nails</a><br><span>₱5.00</span></div></div><br>', 'Bot');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `total_amount`, `quantity`, `status`, `created_at`) VALUES
(1, 'ORD-2025-7781', 5808.00, 2, 'paid', '2025-04-16 06:49:57'),
(2, 'ORD-2025-5186', 222.00, 10, 'paid', '2025-04-16 07:33:31'),
(3, 'ORD-2025-2780', 158.00, 2, 'paid', '2025-04-16 07:41:32'),
(4, 'ORD-2025-3249', 2550.00, 5, 'unpaid', '2025-04-16 07:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 1, 'Chainsaw', 1, 5750.00),
(2, 1, 5, 'Screws', 1, 8.00),
(3, 2, 5, 'Screws', 9, 8.00),
(4, 2, 6, 'Screwdriver', 1, 100.00),
(5, 3, 6, 'Screwdriver', 1, 100.00),
(6, 3, 5, 'Screws', 1, 8.00),
(7, 4, 7, 'Drill', 5, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(20) NOT NULL,
  `product_shelf` varchar(50) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_stock` int(20) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_sku`, `product_shelf`, `product_description`, `product_image`, `product_price`, `product_stock`, `category_id`) VALUES
(1, 'Chainsaw', 'CHSW-0001', 'C1', 'A chainsaw with powerful HP for cutting Logs and Trees', 'products/1744708752_chainsaw.png', 5750.00, 12, 1),
(2, 'Boysen', 'BYS-0001', 'B3', 'Pang Commercial Lang Ito!', 'products/1744715369_Boysen-removebg-preview.png', 350.00, 28, 3),
(3, 'Birch Plywood 6mm', 'PLYW-0001', 'A3', 'Kahoy na pwede na. Ok na to', 'products/1744715379_Birch_Plywood-removebg-preview.png', 5999.00, 99, 7),
(4, 'Nails', 'NLS-0001', 'A1', 'Nails that is good for wood constructions', 'products/1744715387_Nails-removebg-preview.png', 5.00, 500, 7),
(5, 'Screws', 'SCRW-0001', 'A1', 'For screwing walls and furniture.', 'products/1744715394_Screw-removebg-preview.png', 8.00, 489, 7),
(6, 'Screwdriver', 'SCDV-0001', 'A1', 'Use for locking screws', 'products/1744715439_Screwdriver-removebg-preview.png', 100.00, 39, 1),
(7, 'Drill', 'DRL-0001', 'A2', 'Used for Drilling walls and for tightening of screws', 'products/1744777401_drill.png', 500.00, 45, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cat_ibfk_1` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cat_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
