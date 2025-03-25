-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 09:13 AM
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
-- Database: `styleverse`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `created_at`, `email`) VALUES
(1, 'admin', '$2y$10$.cchX1BkQFOWGLSCaeHRA.kcQBXcLQxgmyQ8K.RzL1zw2SEV1CezC', '2025-01-12 10:29:00', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `image_url`, `created_at`) VALUES
(1, 'Men', '67e0ed0f913d1.jpg', '2025-03-24 05:26:39'),
(2, 'Women', '67e0ed1da0279.jpg', '2025-03-24 05:26:53'),
(5, 'Accessories', '67e0ed2d72fcd.jpg', '2025-03-24 05:27:09'),
(12, 'Unisex', '67aac60c98cc0.jpg', '2025-02-10 22:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

CREATE TABLE `chat_logs` (
  `id` int(11) NOT NULL,
  `user_message` text NOT NULL,
  `bot_reply` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`id`, `user_message`, `bot_reply`, `user_id`, `created_at`) VALUES
(0, 'hi', 'Hey! Need help finding something?', 6, '2025-03-25 06:06:48'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:06:56'),
(0, 'blue', '🤖 I\'m not sure how to help with that. Try asking about a product name or keyword.', 6, '2025-03-25 06:07:14'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:11:39'),
(0, 'hello', '👋 Hi there! What are you looking for today?', 6, '2025-03-25 06:12:10'),
(0, 'blue', '🤖 I\'m not sure how to help with that. Please try asking about a product name or keyword.', 6, '2025-03-25 06:12:17'),
(0, 'saree', '\r\n🛍️ *Elegant Cotton Saree* is available!\r\n\r\n💸 Price: LKR 1,600.00\r\n🎨 Colors: Yellow\r\n📏 Sizes: Free Size\r\n\r\n<a href=\'/StyleVerse/views/products/product_details.php?product_id=137\' target=\'_blank\'>\r\n    <img src=\'/StyleVerse/assets/images/products/67e13698a9b1a.jpg\' width=\'180\'><br>\r\n    👉 Click here to view product\r\n</a>', 6, '2025-03-25 06:13:03'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:13:10'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:22:24'),
(0, 'saree', '❌ Women is currently out of stock.', 6, '2025-03-25 06:23:55'),
(0, 'saree', '❌ Silk sarees is currently out of stock.', 6, '2025-03-25 06:25:33'),
(0, 'saree', '\r\n                    🛍️ *Elegant Cotton Saree* is available!\r\n\r\n                    💸 Price: LKR 1,600.00\r\n                    🎨 Colors: Yellow\r\n                    📏 Sizes: Free Size\r\n\r\n                    <a href=\'/StyleVerse/views/products/product_details.php?product_id=137\' target=\'_blank\'>\r\n                        <img src=\'/StyleVerse/assets/images/products/67e13698a9b1a.jpg\' width=\'180\'><br>\r\n                        👉 Click here to view product\r\n                    </a>', 6, '2025-03-25 06:26:45'),
(0, 'saree', '❌ Fancy Saree is currently out of stock.', 6, '2025-03-25 06:26:45'),
(0, 'saree', '❌ Silk sarees is currently out of stock.', 6, '2025-03-25 06:26:45'),
(0, 'saree', '\r\n            🛍️ *Elegant Cotton Saree* is available!\r\n\r\n            💸 Price: LKR 1,600.00\r\n            🎨 Colors: Yellow\r\n            📏 Sizes: Free Size\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=137\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e13698a9b1a.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', 6, '2025-03-25 06:27:58'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:28:02'),
(0, 'top', '❌ Women\'s Crop Top is currently out of stock.', 6, '2025-03-25 06:28:13'),
(0, 'casual', '❌ Women\'s Casual Top is currently out of stock.', 6, '2025-03-25 06:28:23'),
(0, 'men', '\r\n            🛍️ *Elegant Cotton Saree* is available!\r\n\r\n            💸 Price: LKR 1,600.00\r\n            🎨 Colors: Yellow\r\n            📏 Sizes: Free Size\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=137\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e13698a9b1a.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', 6, '2025-03-25 06:28:31'),
(0, 'men\'s', '❌ Men\'s Black Hoodie is currently out of stock.', 6, '2025-03-25 06:28:42'),
(0, 'denim', '❌ Men\'s Denim Jacket is currently out of stock.', 6, '2025-03-25 06:28:53'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:30:04'),
(0, 'fit', '\r\n            🛍️ *Men\'s Slim Fit Shirt* is available!\r\n\r\n            💸 Price: LKR 2,300.00\r\n            🎨 Colors: pink, Blue, Black, Brown, Gray, Red\r\n            📏 Sizes: M, L, S, XL, 2XL\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=151\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e1492181a6b.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', 6, '2025-03-25 06:30:19'),
(0, 'slim', '\r\n            🛍️ *Men\'s Slim Fit Shirt* is available!\r\n\r\n            💸 Price: LKR 2,300.00\r\n            🎨 Colors: pink, Blue, Black, Brown, Gray, Red\r\n            📏 Sizes: M, L, S, XL, 2XL\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=151\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e1492181a6b.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', 6, '2025-03-25 06:30:34'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:30:48'),
(0, 'shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:30:56'),
(0, 'fit', '\r\n            🛍️ *Men\'s Slim Fit Shirt* is available!\r\n\r\n            💸 Price: LKR 2,300.00\r\n            🎨 Colors: pink, Blue, Black, Brown, Gray, Red\r\n            📏 Sizes: M, L, S, XL, 2XL\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=151\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e1492181a6b.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', 6, '2025-03-25 06:31:09'),
(0, 'fit shirt', 'Hey! Need help finding something?', 6, '2025-03-25 06:31:18'),
(0, 'slim fit', '\r\n            🛍️ *Men\'s Slim Fit Shirt* is available!\r\n\r\n            💸 Price: LKR 2,300.00\r\n            🎨 Colors: pink, Blue, Black, Brown, Gray, Red\r\n            📏 Sizes: M, L, S, XL, 2XL\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=151\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e1492181a6b.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', 6, '2025-03-25 06:31:41'),
(0, 'hi', 'Hey! Need help finding something?', NULL, '2025-03-25 07:37:31'),
(0, 'saree', '\r\n            🛍️ *Elegant Cotton Saree* is available!\r\n\r\n            💸 Price: LKR 1,600.00\r\n            🎨 Colors: Yellow\r\n            📏 Sizes: Free Size\r\n\r\n            <a href=\'/StyleVerse/views/products/product_details.php?product_id=137\' target=\'_blank\'>\r\n                <img src=\'/StyleVerse/assets/images/products/67e13698a9b1a.jpg\' width=\'180\'><br>\r\n                👉 Click here to view product\r\n            </a>', NULL, '2025-03-25 07:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `product_id`, `size`, `color`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 151, 'M', 'pink', 10, 2300.00, '2025-03-24 12:39:05', '2025-03-24 12:39:05'),
(2, 151, 'L', 'Blue', 10, 2300.00, '2025-03-24 12:40:07', '2025-03-24 12:40:07'),
(3, 151, 'S', 'Black', 10, 2300.00, '2025-03-24 12:41:19', '2025-03-24 12:41:19'),
(4, 151, 'XL', 'Brown', 10, 2300.00, '2025-03-24 12:42:08', '2025-03-24 12:42:08'),
(5, 151, '2XL', 'Gray', 9, 2300.00, '2025-03-24 12:43:00', '2025-03-25 07:15:54'),
(6, 151, '2XL', 'Blue', 10, 2300.00, '2025-03-24 12:44:26', '2025-03-24 12:44:26'),
(7, 151, '2XL', 'Red', 10, 2300.00, '2025-03-24 12:45:16', '2025-03-24 12:45:16'),
(8, 137, 'Free Size', 'Yellow', 8, 1600.00, '2025-03-24 12:52:49', '2025-03-25 04:06:58');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `title`, `description`, `discount`, `image_url`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 'Valentine\'s Day Offer', 'Up to 70% offer ', 70.00, 'istockphoto-2161402921-1024x1024.jpg', '2025-02-07', '2025-02-21', 'active', '2025-02-15 17:34:19'),
(2, 'Special sale', 'Sale for Every Purchase', 15.00, 'StyleVerse.png', '2025-02-07', '2025-04-01', 'active', '2025-02-15 17:47:26'),
(3, 'WHOLE SALE', 'COME ON GUYS', 15.00, 'istockphoto-137576095-2048x2048.jpg', '2025-02-01', '2025-03-01', 'active', '2025-02-15 17:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `offer_id` int(11) NOT NULL,
  `final_amount` decimal(10,2) NOT NULL,
  `payment_method` text NOT NULL,
  `transaction_id` text NOT NULL,
  `status` enum('Paid','Pending','Processing','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `delivery_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `offer_id`, `final_amount`, `payment_method`, `transaction_id`, `status`, `delivery_date`) VALUES
(11, 6, 1600.00, '2025-03-25 03:58:46', 0, 1360.00, 'pending', '2', '', NULL),
(12, 6, 1600.00, '2025-03-25 04:06:58', 0, 1360.00, 'paid', '2', '', NULL),
(13, 6, 2300.00, '2025-03-25 07:15:54', 0, 1955.00, 'pending', '2', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `inventory_id`) VALUES
(0, 11, 137, 1, 1600.00, 8),
(0, 12, 137, 1, 1600.00, 8),
(0, 13, 151, 1, 2300.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `additionalImages` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tags` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image_url`, `additionalImages`, `category_id`, `subcategory_id`, `created_at`, `tags`) VALUES
(137, 'Elegant Cotton Saree', 'High quality and stylish product for everyday use.', 1600.00, '67e13698a9b1a.jpg', '[\"67e13698aa03f.jpg\",\"67e13698aa436.jpg\",\"67e13698aa5a4.jpg\",\"67e13698aa71a.jpg\"]', 2, 27, '2025-03-24 03:50:11', 'saree,ethnic,cotton'),
(138, 'Men\'s Black Hoodie', 'Comfortable and trendy wear for all seasons.', 3800.00, '67e1421be6733.jpg', '[]', 1, 39, '2025-03-24 03:50:11', 'hoodie,men,winter'),
(139, 'Women\'s Crop Top', 'Designed with fashion and comfort in mind.', 950.00, '67e143bfa7573.jpg', '[]', 2, 26, '2025-03-24 03:50:11', 'top,women,summer'),
(143, 'Women\'s Casual Top', 'Comfortable and trendy wear for all seasons.', 1200.00, '67e144a25a342.jpg', '[]', 2, 26, '2025-03-24 03:50:11', 'shirt,men,casual'),
(144, 'Men\'s Denim Jacket', 'Designed with fashion and comfort in mind.', 3800.00, '67e14554dc2bb.jpg', '[]', 1, 39, '2025-03-24 03:50:11', 'pants,women,formal'),
(146, 'Running Shoes', 'Best pick for daily and occasional wear.', 4500.00, '67e146e0b6c31.jpg', '[]', 5, 55, '2025-03-24 03:50:11', 'kids,shoes,colorful'),
(147, 'Printed T-Shirt', 'High quality and stylish product for everyday use.', 1300.00, '67e148dbd1e46.jpg', '[]', 2, 26, '2025-03-24 03:50:11', 'ethnic,cotton'),
(150, 'Women\'s Palazzo Pants', 'Ideal accessory to complement your look.', 1281.00, '67e1430fd5311.jpg', '[\"67e1430fd54f0.jpg\",\"67e1430fd5627.jpg\",\"67e1430fd572f.jpg\",\"67e1430fd5836.jpg\"]', 2, 30, '2025-03-24 03:50:11', 'bag,accessory,travel'),
(151, 'Men\'s Slim Fit Shirt', 'Best pick for daily and occasional wear.', 2300.00, '67e1492181a6b.jpg', '[\"67e1505dee4ae.jpg\",\"67e1505dee65e.jpg\",\"67e1505dee720.jpg\"]', 1, 35, '2025-03-24 03:50:11', 'shoes,sneakers,unisex'),
(152, 'Designer Handbag', 'High quality and stylish product for everyday use.', 1355.00, '67e149aff322b.jpeg', '[]', 5, 42, '2025-03-24 03:50:11', 'watch,smart,tech'),
(161, 'Men\'s Track Pants', 'Best pick for daily and occasional wear.', 3000.00, '67e14aeedf6bf.jpeg', '[]', 1, 37, '2025-03-24 03:50:11', 'shoes,sneakers,unisex'),
(168, 'Women\'s Nightwear', 'Comfortable and trendy wear for all seasons.', 1800.00, '67e14c0a2408e.jpg', '[]', 2, 33, '2025-03-24 03:50:11', 'hoodie,men,winter'),
(174, 'Sunglasses', 'Designed with fashion and comfort in mind.', 850.00, '67e1437209c23.jpg', '[\"67e1437209e26.jpg\",\"67e1437209f2c.jpg\",\"67e1437211cd2.jpg\",\"67e1437211ea4.jpg\"]', 5, 46, '2025-03-24 03:50:11', 'pants,women,formal'),
(176, 'Men\'s Shorts', 'Best pick for daily and occasional wear.', 1500.00, '67e14cbfbc362.jpg', '[]', 1, 38, '2025-03-24 03:50:11', 'kids,shoes,colorful'),
(178, 'Unisex Hoodie', 'Comfortable and trendy wear for all seasons.', 5000.00, '67e14d2d430fb.jpg', '[]', 12, 49, '2025-03-24 03:50:11', 'hoodie,men,winter'),
(180, 'Women’s Denim Jacket', 'Ideal accessory to complement your look.', 3300.00, '67e14d981596e.jpg', '[]', 2, 31, '2025-03-24 03:50:11', 'bag,accessory,travel'),
(181, 'Formal Shoes', 'Best pick for daily and occasional wear.', 4300.00, '67e14dec407d3.jpg', '[]', 5, 55, '2025-03-24 03:50:11', 'shoes,sneakers,unisex'),
(186, 'Men\'s Suit', 'Best pick for daily and occasional wear.', 9000.00, '67e14e9a7c490.jpeg', '[]', 1, 41, '2025-03-24 03:50:11', 'kids,shoes,colorful'),
(187, 'Running Shoes', 'Best pick for daily and occasional wear.', 4500.00, '67e1474be1764.jpg', '[]', 5, 55, '2025-03-24 11:51:39', ''),
(189, 'Fancy Saree', 'High quality and stylish product for everyday use.', 1500.00, '67e148a62cf5d.jpg', '[]', 2, 27, '2025-03-24 11:57:26', ''),
(190, 'Silk sarees', 'High quality and stylish product for everyday use.', 2000.00, '67e14fac86a58.jpg', '[]', 2, 27, '2025-03-24 12:27:24', ''),
(191, 'Casual Shirts', 'Best pick for daily and occasional wear.', 2800.00, '67e151075bd21.jpg', '[]', 1, 35, '2025-03-24 12:33:11', ''),
(192, 'Modern Shirts', 'Best pick for daily and occasional wear.', 2900.00, '67e1513e5c40d.jpg', '[]', 1, 35, '2025-03-24 12:34:06', ''),
(193, 'Casual Shirts', 'Best pick for daily and occasional wear.', 2600.00, '67e15169e0262.jpg', '[]', 1, 35, '2025-03-24 12:34:49', '');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `review` longtext NOT NULL,
  `rating` int(11) NOT NULL
) ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `user_id`, `product_id`, `rated_at`, `review`, `rating`) VALUES
(0, 6, 137, '2025-03-25 04:05:39', 'High Quality \r\nI just loved it', 9),
(0, 6, 138, '2025-03-25 05:44:23', 'amazing product', 8),
(0, 6, 139, '2025-03-25 05:45:19', 'good product', 7),
(0, 6, 143, '2025-03-25 05:46:57', 'best quality', 8),
(0, 6, 144, '2025-03-25 05:48:06', 'highly recommended', 6),
(0, 6, 168, '2025-03-25 05:51:36', 'good material', 6),
(0, 6, 151, '2025-03-25 07:07:48', 'high quality product', 8);

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `recommendation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`recommendation_id`, `user_id`, `product_id`, `score`, `created_at`, `reason`) VALUES
(0, 6, 144, 0.38, '2025-03-25 05:47:44', 'Same Category, Seasonal, Trending'),
(0, 6, 146, 0.20, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 147, 0.63, '2025-03-25 05:47:44', 'Content-Based, Search Match, Same Category, Seasonal, Trending'),
(0, 6, 150, 0.02, '2025-03-25 05:47:44', ''),
(0, 6, 151, 0.41, '2025-03-25 05:47:44', 'Search Match, Seasonal, Trending'),
(0, 6, 161, 0.21, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 168, 0.27, '2025-03-25 05:47:44', 'Content-Based, Seasonal, Trending'),
(0, 6, 174, 0.01, '2025-03-25 05:47:44', ''),
(0, 6, 176, 0.21, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 178, 0.04, '2025-03-25 05:47:44', ''),
(0, 6, 180, 0.02, '2025-03-25 05:47:44', ''),
(0, 6, 181, 0.20, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 186, 0.21, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 187, 0.20, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 189, 0.40, '2025-03-25 05:47:44', 'Content-Based, Same Category, Seasonal, Trending'),
(0, 6, 190, 0.20, '2025-03-25 05:47:44', 'Content-Based, Same Category'),
(0, 6, 191, 0.21, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 192, 0.21, '2025-03-25 05:47:44', 'Search Match'),
(0, 6, 193, 0.21, '2025-03-25 05:47:44', 'Search Match');

-- --------------------------------------------------------

--
-- Table structure for table `search_history`
--

CREATE TABLE `search_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `searched_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_history`
--

INSERT INTO `search_history` (`id`, `user_id`, `keyword`, `searched_at`) VALUES
(0, 6, 'blue', '2025-03-25 04:10:20'),
(0, 6, 'sh', '2025-03-25 04:10:33'),
(0, 3, 'sh', '2025-03-25 04:12:47'),
(0, 3, 'sh', '2025-03-25 04:14:26'),
(0, 3, 'sh', '2025-03-25 04:14:26'),
(0, 3, 'sh', '2025-03-25 04:14:41'),
(0, 3, 'sh', '2025-03-25 04:15:31'),
(0, 3, 'sh', '2025-03-25 04:15:31'),
(0, 3, 'sa', '2025-03-25 04:15:39'),
(0, 3, 'sar', '2025-03-25 04:15:39'),
(0, 3, 'sa', '2025-03-25 04:16:15'),
(0, 3, 'sa', '2025-03-25 04:16:15'),
(0, 6, 'sh', '2025-03-25 07:05:19'),
(0, 6, 'shi', '2025-03-25 07:05:20'),
(0, 6, 'shir', '2025-03-25 07:05:21'),
(0, 6, 'shirt', '2025-03-25 07:05:21'),
(0, 6, 'sa', '2025-03-25 07:05:38'),
(0, 6, 'sar', '2025-03-25 07:05:38'),
(0, 6, 'sare', '2025-03-25 07:05:38'),
(0, 6, 'saree', '2025-03-25 07:05:38'),
(0, 6, 'saree', '2025-03-25 07:05:48'),
(0, 6, 'saree', '2025-03-25 07:05:48'),
(0, 3, 'sa', '2025-03-25 07:26:22'),
(0, 3, 'sar', '2025-03-25 07:26:23'),
(0, 3, 'sare', '2025-03-25 07:26:23'),
(0, 3, 'saree', '2025-03-25 07:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

CREATE TABLE `shipping_details` (
  `shipping_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_details`
--

INSERT INTO `shipping_details` (`shipping_id`, `order_id`, `user_id`, `shipping_name`, `shipping_address`, `shipping_phone`, `created_at`) VALUES
(0, 11, 6, 'Tom', 'Jaffna', '78956423', '2025-03-25 03:58:46'),
(0, 12, 6, 'Tom', 'kopay', '78956423', '2025-03-25 04:06:58'),
(0, 13, 6, 'kopika selvarasa', 'jaffna', '0770675436', '2025-03-25 07:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `subcategory_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`subcategory_id`, `category_id`, `subcategory_name`, `description`, `created_at`, `updated_at`, `image_url`) VALUES
(26, 2, 'Tops	', 'T-shirts, blouses, crop tops, casual wear\r\n', '2025-03-24 05:30:29', '2025-03-24 05:36:13', '67e0ef4d066cb.jpg'),
(27, 2, 'Sarees', 'Traditional Indian sarees (cotton, silk, designer)\r\n', '2025-03-24 05:37:10', '2025-03-24 05:37:10', '67e0ef865c32d.jpg'),
(28, 2, 'Skirts	', 'Short, midi, and long skirts\r\n', '2025-03-24 05:38:00', '2025-03-24 05:38:00', '67e0efb8f3d48.jpg'),
(29, 2, 'Jeans	', 'Slim fit, straight, and mom-style jeans\r\n', '2025-03-24 05:39:26', '2025-03-24 05:39:26', '67e0f00e05cda.jpg'),
(30, 2, 'Trousers & Pants	', 'Formal pants, palazzos, culottes\r\n', '2025-03-24 05:43:11', '2025-03-24 05:43:11', '67e0f0ef30c4d.jpg'),
(31, 2, 'Jackets & Shrugs	', 'Light jackets, winter coats, layering\r\n', '2025-03-24 05:45:59', '2025-03-24 05:45:59', '67e0f197c12ef.jpg'),
(32, 2, 'Office Wear	', 'Semi-formal, blazers, pants\r\n', '2025-03-24 05:49:19', '2025-03-24 05:49:19', '67e0f25f5f6f4.jpg'),
(33, 2, 'Nightwear & Loungewear	', 'Pajamas, sleep shirts, comfy sets\r\n', '2025-03-24 05:51:06', '2025-03-24 05:51:06', '67e0f2caefafa.jpg'),
(34, 1, 'T-Shirts	', 'Casual crewneck, V-neck, oversized, and printed tees\r\n', '2025-03-24 05:53:13', '2025-03-24 05:53:13', '67e0f349357b7.jpg'),
(35, 1, 'Shirts	', 'Formal shirts, casual button-downs, printed shirts\r\n', '2025-03-24 05:54:02', '2025-03-24 05:54:02', '67e0f37a9c944.jpg'),
(36, 1, 'Jeans', 'Slim fit, regular, skinny, ripped, and stretch jeans\r\n', '2025-03-24 05:55:14', '2025-03-24 05:55:14', '67e0f3c22657d.jpg'),
(37, 1, 'Trousers & Pants	', 'Chinos, formal trousers, joggers, pleated pants\r\n', '2025-03-24 05:56:33', '2025-03-24 05:56:33', '67e0f411c6339.jpg'),
(38, 1, 'Shorts	', 'Knee-length shorts, cargos, denim shorts\r\n', '2025-03-24 05:57:53', '2025-03-24 05:57:53', '67e0f461102af.jpg'),
(39, 1, 'Jackets	', 'Leather, bomber, quilted, and varsity jackets\r\n', '2025-03-24 06:00:15', '2025-03-24 06:00:15', '67e0f4efb9474.jpg'),
(40, 1, 'Nightwear	', 'Pajamas, lounge pants, sleep t-shirts\r\n', '2025-03-24 06:02:02', '2025-03-24 06:02:02', '67e0f55a707db.jpg'),
(41, 1, 'Suits & Blazers	', '2-piece suits, formal blazers, wedding suits\r\n', '2025-03-24 06:04:44', '2025-03-24 06:04:44', '67e0f5fc147c9.jpg'),
(42, 5, 'Bags	', 'Handbags, totes, backpacks, slings, pouches\r\n', '2025-03-24 06:07:53', '2025-03-24 06:07:53', '67e0f6b94388c.jpg'),
(43, 5, 'Wallets	', 'Leather wallets, card holders, coin pouches\r\n', '2025-03-24 06:09:55', '2025-03-24 06:09:55', '67e0f733065c1.jpg'),
(44, 5, 'Belts	', 'Formal belts, casual belts, reversible belts\r\n', '2025-03-24 06:12:37', '2025-03-24 06:12:37', '67e0f7d540286.jpg'),
(45, 5, 'Watches', 'Analog, smartwatches, fitness bands\r\n', '2025-03-24 06:13:46', '2025-03-24 06:13:46', '67e0f81ab3646.jpg'),
(46, 5, 'Sunglasses	', 'Aviators, wayfarers, square shades\r\n', '2025-03-24 06:14:52', '2025-03-24 06:14:52', '67e0f85c5fa78.jpg'),
(47, 12, 'T-Shirts	', 'Basic round-neck, oversized, graphic tees for all genders\r\n', '2025-03-24 06:29:16', '2025-03-24 06:29:16', '67e0fbbc13508.jpg'),
(49, 12, 'Hoodies', 'Zip-up & pullover hoodies with universal fits\r\n', '2025-03-24 06:32:57', '2025-03-24 06:32:57', '67e0fc99d09b6.jpg'),
(50, 12, 'Jackets', 'Denim, bomber, varsity, and windcheaters\r\n', '2025-03-24 07:04:40', '2025-03-24 07:04:40', '67e1040876dd5.jpg'),
(51, 12, 'Co-ords & Sets	', 'Matching top & bottom sets (great for couple wear)\r\n', '2025-03-24 07:13:02', '2025-03-24 07:13:02', '67e105fedea26.jpg'),
(52, 12, 'Casual Wear	', 'Relaxed fits like shorts, loose tops, layered shirts\r\n', '2025-03-24 07:15:14', '2025-03-24 07:15:14', '67e10682ede20.jpg'),
(53, 12, 'Activewear	', 'Gym wear: tank tops, workout tees, yoga pants\r\n', '2025-03-24 07:20:01', '2025-03-24 07:20:01', '67e107a1785cd.jpg'),
(54, 12, 'Sweatshirts	', 'Cozy crewnecks and fleece tops\r\n', '2025-03-24 07:34:00', '2025-03-24 07:34:00', '67e10ae893643.jpg'),
(55, 5, 'Shoes', 'Running Shoes', '2025-03-24 11:48:33', '2025-03-24 11:48:33', '67e14691eafcd.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`, `role`, `profile_picture`, `address`, `phone`) VALUES
(3, 'Kopika Selvarasa', 'kopikaselvarasa81@gmail.com', '$2y$10$JdIoPc2fR5A..dtgmDJn8ecoVgH8YtSocjOoRNdcS2.XtkuYOvSLO', '2025-01-15 14:24:17', 'admin', '67a8ba7a8495d.jpeg', '', ''),
(5, 'Dilushan Vigneswaran', 'dilushan0314@gmail.com', '$2y$10$/no56SuBM1enyH5Mc2pOR.Bys8kvPTAXsFDkRPctPWTNcR3X/mp4i', '2025-01-22 16:21:52', 'user', 'LanaDRPrimavera310524_(10_of_155)_(53765300307)_(cropped).jpg', 'Nallur, Jaffna', '0778165322'),
(6, 'tom', 'tom@gmail.com', '$2y$10$G3e3NdqXY21AIq/pr4UNI.NemFT7x7HI52jNRs3DKb5Ys4yfT9z8u', '2025-02-09 16:03:24', 'user', '67a8d27c29e69.jpg', 'jaffna', '0771565473');

-- --------------------------------------------------------

--
-- Table structure for table `user_behavior`
--

CREATE TABLE `user_behavior` (
  `behavior_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_behavior`
--

INSERT INTO `user_behavior` (`behavior_id`, `user_id`, `product_id`, `action_type`, `timestamp`) VALUES
(6, 3, 137, 'click', '2025-03-24 10:40:33'),
(7, 3, 137, 'view', '2025-03-24 10:40:33'),
(8, 3, 137, 'view', '2025-03-24 10:41:13'),
(9, 3, 137, 'view', '2025-03-24 10:41:22'),
(12, 5, 137, 'view', '2025-03-24 10:44:12'),
(13, 5, 137, 'view', '2025-03-24 10:44:42'),
(14, 3, 137, 'view', '2025-03-24 10:57:33'),
(27, 6, 137, 'click', '2025-03-24 11:23:38'),
(28, 6, 137, 'view', '2025-03-24 11:23:38'),
(29, 6, 137, 'view', '2025-03-24 11:25:01'),
(30, 6, 137, 'view', '2025-03-24 11:25:06'),
(31, 6, 137, 'view', '2025-03-24 11:25:25'),
(32, 6, 137, 'view', '2025-03-24 11:25:32'),
(33, 3, 138, 'click', '2025-03-24 11:29:46'),
(34, 3, 138, 'view', '2025-03-24 11:29:46'),
(35, 3, 139, 'click', '2025-03-24 11:36:36'),
(36, 3, 139, 'view', '2025-03-24 11:36:37'),
(37, 3, 168, 'click', '2025-03-24 12:11:59'),
(38, 3, 168, 'view', '2025-03-24 12:11:59'),
(39, 6, 138, 'view', '2025-03-24 12:24:55'),
(40, 6, 137, 'view', '2025-03-24 12:25:16'),
(41, 6, 189, 'view', '2025-03-24 12:25:38'),
(42, 6, 137, 'view', '2025-03-24 12:27:53'),
(43, 6, 151, 'view', '2025-03-24 12:28:35'),
(44, 6, 151, 'view', '2025-03-24 12:30:32'),
(45, 6, 151, 'view', '2025-03-24 12:31:20'),
(46, 6, 151, 'view', '2025-03-24 12:35:47'),
(47, 6, 151, 'view', '2025-03-24 12:36:15'),
(48, 6, 151, 'click', '2025-03-24 12:39:13'),
(49, 6, 151, 'view', '2025-03-24 12:39:13'),
(50, 6, 151, 'view', '2025-03-24 12:40:16'),
(51, 6, 151, 'view', '2025-03-24 12:40:17'),
(52, 6, 151, 'view', '2025-03-24 12:43:14'),
(53, 6, 151, 'view', '2025-03-24 12:43:18'),
(54, 6, 151, 'view', '2025-03-24 12:43:21'),
(55, 6, 151, 'view', '2025-03-24 12:43:22'),
(56, 6, 151, 'view', '2025-03-24 12:43:44'),
(57, 6, 151, 'view', '2025-03-24 12:43:45'),
(58, 6, 151, 'view', '2025-03-24 12:46:38'),
(59, 6, 151, 'view', '2025-03-24 12:46:40'),
(60, 6, 151, 'view', '2025-03-24 12:47:34'),
(61, 6, 151, 'view', '2025-03-24 12:48:05'),
(62, 6, 137, 'view', '2025-03-24 12:50:57'),
(63, 6, 137, 'view', '2025-03-24 12:53:28'),
(66, 5, 137, 'click', '2025-03-24 14:15:46'),
(67, 5, 137, 'view', '2025-03-24 14:15:46'),
(68, 5, 137, 'view', '2025-03-24 14:16:14'),
(73, 6, 137, 'click', '2025-03-25 03:59:27'),
(74, 6, 137, 'view', '2025-03-25 03:59:28'),
(75, 6, 137, 'view', '2025-03-25 03:59:38'),
(76, 6, 137, 'view', '2025-03-25 04:05:13'),
(77, 6, 137, 'view', '2025-03-25 04:05:39'),
(78, 6, 137, 'view', '2025-03-25 04:10:57'),
(79, 3, 143, 'view', '2025-03-25 04:14:56'),
(80, 3, 143, 'view', '2025-03-25 04:15:32'),
(81, 3, 147, 'view', '2025-03-25 04:15:44'),
(85, 6, 137, 'view', '2025-03-25 05:42:52'),
(86, 6, 137, 'click', '2025-03-25 05:42:52'),
(87, 6, 138, 'click', '2025-03-25 05:43:16'),
(88, 6, 138, 'view', '2025-03-25 05:43:16'),
(89, 6, 138, 'view', '2025-03-25 05:44:23'),
(90, 6, 138, 'view', '2025-03-25 05:44:28'),
(91, 6, 139, 'click', '2025-03-25 05:44:40'),
(92, 6, 139, 'view', '2025-03-25 05:44:40'),
(93, 6, 139, 'view', '2025-03-25 05:45:19'),
(94, 6, 143, 'click', '2025-03-25 05:45:30'),
(95, 6, 143, 'view', '2025-03-25 05:45:30'),
(96, 6, 143, 'view', '2025-03-25 05:46:57'),
(97, 6, 144, 'click', '2025-03-25 05:47:14'),
(98, 6, 144, 'view', '2025-03-25 05:47:14'),
(99, 6, 144, 'view', '2025-03-25 05:48:06'),
(100, 6, 137, 'click', '2025-03-25 05:50:09'),
(101, 6, 137, 'view', '2025-03-25 05:50:11'),
(102, 6, 168, 'click', '2025-03-25 05:51:03'),
(103, 6, 168, 'view', '2025-03-25 05:51:03'),
(104, 6, 168, 'view', '2025-03-25 05:51:36'),
(106, 6, 137, 'click', '2025-03-25 07:06:14'),
(107, 6, 137, 'view', '2025-03-25 07:06:16'),
(108, 6, 151, 'click', '2025-03-25 07:07:08'),
(109, 6, 151, 'view', '2025-03-25 07:07:08'),
(110, 6, 151, 'view', '2025-03-25 07:07:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_behavior`
--
ALTER TABLE `user_behavior`
  ADD PRIMARY KEY (`behavior_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_behavior`
--
ALTER TABLE `user_behavior`
  MODIFY `behavior_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_behavior`
--
ALTER TABLE `user_behavior`
  ADD CONSTRAINT `user_behavior_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_behavior_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
