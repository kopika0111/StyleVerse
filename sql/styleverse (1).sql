-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 07:16 AM
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
(1, 2, 'M', 'red', 134, 2500.00, '2025-02-15 01:08:59', '2025-02-15 18:06:23'),
(4, 1, 'L', 'Blue', 99, 1500.00, '2025-02-15 13:36:19', '2025-02-15 17:19:21'),
(2, 1, 'M', 'red', 95, 1750.00, '2025-02-15 14:22:24', '2025-02-15 17:29:25'),
(3, 1, 'M', 'green', 100, 1750.00, '2025-02-15 14:23:28', '2025-02-15 14:27:17');

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
(2, 'Special sale', 'Sale for Every Purchase', 15.00, '', '2025-02-07', '2025-02-14', 'active', '2025-02-15 17:47:26'),
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
  `final_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `offer_id`, `final_amount`) VALUES
(1, 5, 3999.00, '2025-02-09 14:35:18', 0, 0.00),
(2, 5, 5998.00, '2025-02-09 14:35:45', 0, 0.00),
(3, 6, 6499.00, '2025-02-10 14:35:03', 0, 0.00),
(4, 5, 1500.00, '2025-02-15 16:46:36', 0, 0.00),
(5, 5, 2500.00, '2025-02-15 16:49:12', 0, 0.00),
(6, 5, 2500.00, '2025-02-15 16:57:40', 0, 0.00),
(7, 5, 1500.00, '2025-02-15 17:19:21', 0, 0.00),
(8, 5, 16250.00, '2025-02-15 17:29:25', 0, 0.00),
(9, 5, 2500.00, '2025-02-15 18:06:23', 0, 0.00);

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
(1, 1, 2, 1, 3999.00, NULL),
(2, 2, 1, 2, 2999.00, NULL),
(3, 3, 10, 1, 6499.00, NULL),
(4, 5, 2, 1, 2500.00, NULL),
(5, 6, 2, 1, 2500.00, NULL),
(6, 7, 1, 1, 1500.00, 4),
(7, 8, 1, 5, 1750.00, 2),
(8, 8, 2, 3, 2500.00, 1),
(9, 9, 2, 1, 2500.00, 1);

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
(1, 'Men\'s Casual Shirt', 'A stylish and comfortable casual shirt for men. Perfect for any occasion.', 2999.00, '67a9fe9c79ca4.jpg', '[]', 1, 1, '2025-01-12 05:24:26', 'blue,light blue,men,shirt'),
(2, 'Women\'s Summer Dress', 'A lightweight and breezy dress for summer days.', 3999.00, 'womens_summer_dress.jpg', '[\"67a9feef02666.jpg\"]', 2, 5, '2025-01-12 05:24:26', 'summer,lightweight'),
(3, 'Kids\' T-Shirt', 'A colorful t-shirt for kids, made from soft cotton.', 1599.00, 'kids_tshirt.jpg', NULL, 3, 0, '2025-01-12 05:24:26', NULL),
(4, 'Men\'s Formal Suit', 'A sleek formal suit for business and formal events.', 11999.00, 'mens_formal_suit.jpg', NULL, 1, 0, '2025-01-12 05:24:26', NULL),
(5, 'Women\'s Winter Coat', 'A warm and stylish coat to keep you cozy in winter.', 8999.00, 'womens_winter_coat.jpg', NULL, 2, 0, '2025-01-12 05:24:26', NULL),
(7, 'Men\'s Jeans', 'Classic denim jeans for a timeless look.', 4999.00, 'mens_jeans.jpg', NULL, 1, 0, '2025-01-12 05:24:26', NULL),
(8, 'Women\'s Leggings', 'Stretchable and durable leggings for women.', 2599.00, 'womens_leggings.jpg', NULL, 2, 0, '2025-01-12 05:24:26', NULL),
(10, 'Athletic Sneakers', 'Durable and comfortable sneakers for active lifestyles.', 6499.00, 'athletic_sneakers.jpg', NULL, 5, 0, '2025-01-12 05:24:26', NULL),
(11, 'saree', 'cotton', 500.00, 'cotton-silk-peach-weaving-traditional-saree-157451.jpg', NULL, 2, 0, '2025-01-12 08:48:43', NULL),
(12, 'Couple Dress', 'Dress for Couples', 4900.00, '67aacecceacec.jpg', '[\"67aacecceb41d.jpg\",\"67aacecceb7f5.jpg\",\"67aaceccebacd.jpg\"]', 12, 14, '2025-01-11 23:54:26', 'couple,lovers,modern'),
(13, 'Frocks', 'Casual Frocks', 2500.00, '67aacd363c2d2.jpg', '[\"67aacd363c98e.jpg\",\"67aacd363ccec.jpg\",\"67aacd363cf83.jpg\"]', 2, 15, '2025-01-11 23:54:26', 'frock,style,women,modern,dress,cute,casual'),
(15, 'Drink Bottle', 'Drink Bottle', 800.00, '67adc02c334cf.jpg', '[\"67adc02c33fd1.jpg\",\"67adc02c3498d.jpg\",\"67adc02c352f0.jpg\",\"67adc02c36c19.jpg\"]', 5, 13, '2025-02-13 04:19:32', 'drink,water,bottle'),
(16, 'Drink Bottle', 'Drink Bottle', 900.00, '67adc10f8f192.jpg', '[\"67adc10f8f875.jpg\",\"67adc10f8fec6.jpg\",\"67adc10f904a6.jpg\",\"67adc10f9171c.jpg\"]', 5, 13, '2025-02-13 04:23:19', 'drink,water,bottle'),
(17, 'Sunglass with Watch', 'Sunglass With Watch', 1300.00, '67adc2ec77cc4.jpg', '[\"67adc2ec78681.jpg\",\"67adc2ec78d23.jpg\",\"67adc2ec795af.jpg\"]', 5, 17, '2025-02-13 04:31:16', 'sun,sunglass,watch'),
(18, 'Bag', 'Bag', 4900.00, '67ae1de8a30e4.jpg', '[\"67ae1de8a3f90.jpg\",\"67ae1de8a48f5.jpg\"]', 5, 7, '2025-02-13 10:59:28', 'bag'),
(20, 'Shoes', 'Shoes', 4900.00, '67ae20e77ee45.jpg', '[\"67ae20e77f5b9.jpg\",\"67ae20e77fe5c.jpg\",\"67ae20e78069c.jpg\",\"67ae20e78109d.jpg\"]', 1, 21, '2025-02-13 11:12:15', 'footwear,shoes'),
(21, 'Drink Bottle', 'Drink Bottles', 1300.00, '67ae25d82068e.jpg', '[\"67ae25d821510.jpg\",\"67ae25d822536.jpg\"]', 5, 13, '2025-02-13 11:33:20', 'drink,water,bottle'),
(22, 'Footwear', 'Footwear', 1600.00, '67ae28f0b9df2.jpg', '[]', 2, 22, '2025-02-13 11:46:32', 'footwear,slipper'),
(23, 'Footwear', 'footwear', 1700.00, '67ae298c7ffde.jpg', '[]', 2, 22, '2025-02-13 11:49:08', 'footwear,slipper'),
(24, 'Handbags', 'Handbags', 3300.00, '67ae2a32bfa41.jpg', '[\"67ae2a32c1aed.jpg\",\"67ae2a32c22eb.jpg\",\"67ae2a32c35ef.jpg\",\"67ae2a32c5c42.jpg\"]', 5, 7, '2025-02-13 11:51:54', 'handbags,bags'),
(25, 'Sunglass', 'Sunglass', 600.00, '67ae2b95bc868.jpg', '[\"67ae2b95bf6f9.jpg\",\"67ae2b95c02d4.jpg\",\"67ae2b95c09af.jpg\"]', 5, 17, '2025-02-13 11:57:49', 'sunglass,glass'),
(26, 'Frocks', 'Frocks for Women', 1800.00, '67ae2ca7e19cf.jpg', '[\"67ae2ca7e20ea.jpg\",\"67ae2ca7e26e0.jpg\",\"67ae2ca7e2dfe.jpg\",\"67ae2ca7e34a3.jpg\"]', 2, 15, '2025-02-13 12:02:23', 'frock,womencloth,womendress'),
(27, 't-shirts', 't-shirts for Women', 900.00, '67ae2e810ae2c.jpg', '[\"67ae2e810ba94.jpg\",\"67ae2e810c63d.jpg\",\"67ae2e810d504.jpg\"]', 2, 5, '2025-02-13 12:10:17', 't-shirt,womentshirt'),
(28, 'Men Pants', 'Pants for Men', 3500.00, '67ae2f338dbd9.jpg', '[\"67ae2f3390681.jpg\",\"67ae2f33911d8.jpg\",\"67ae2f3391d0c.jpg\"]', 1, 3, '2025-02-13 12:13:15', 'pant,jeans'),
(29, 't-shirts', 't-shirts for Women', 900.00, '67ae31320b2d4.jpg', '[]', 2, 5, '2025-02-13 12:21:46', 't-shirts'),
(30, 'Top', 'Top for Women', 1900.00, '67ae3258cc85c.jpg', '[\"67ae3258cd783.jpg\",\"67ae3258ce417.jpg\",\"67ae3258cebd6.jpg\",\"67ae3258cf39e.jpg\"]', 2, 4, '2025-02-13 12:26:40', 'top'),
(31, 'Shirt', 'Shirt for Men', 2400.00, '67af461e77894.jpg', '[\"67af461e78847.jpg\",\"67af461e99bbc.jpg\"]', 1, 23, '2025-02-14 08:03:18', 'shirt,casualshirt'),
(32, 'Nailpolish', 'Nailpolish', 600.00, '67af4767f0853.jpg', '[\"67af4767f13ed.jpg\",\"67af4767f1e4d.jpg\",\"67af4767f2958.jpg\"]', 5, 20, '2025-02-14 08:08:47', 'nail,nailpolish'),
(33, 'Shorts & t-shirts', 'Shorts & t-shirts', 4000.00, '67af4d3e75a8d.jpg', '[\"67af4d3e77622.jpg\",\"67af4d3e78a22.jpg\",\"67af4d3e7f47b.jpg\",\"67af4d3e808bb.jpg\"]', 1, 24, '2025-02-14 08:33:42', 'shorts,t-shirts,tshirt'),
(34, 'Shorts & t-shirts', 'Shorts & t-shirts', 4200.00, '67af5401b6184.jpg', '[\"67af5401b6727.jpg\",\"67af5401b6c3e.jpg\"]', 1, 24, '2025-02-14 09:02:33', 'shorts,tshirt'),
(35, 'Shoes', 'Shoes for Women', 1100.00, '67af550a6c0b3.jpg', '[\"67af550a6c8e9.jpg\",\"67af550a6cf1c.jpg\",\"67af550a6e54d.jpg\",\"67af550a6ec44.jpg\"]', 2, 22, '2025-02-14 09:06:58', 'shoes,footwear'),
(36, 'Party Wear', 'Party Wear', 5600.00, '67af590fa0f24.jpg', '[\"67af590fa24c2.jpg\",\"67af590fa2f3c.jpg\",\"67af590fa3b0d.jpg\",\"67af590fa477a.jpg\"]', 2, 25, '2025-02-14 09:24:07', 'partywear,function,salwar'),
(37, 'Shoes', 'Shoes for Men', 3900.00, '67af5ac48a6e2.jpg', '[]', 1, 21, '2025-02-14 09:29:17', 'shoes');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `recommendation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(46, 5, 'Sunglasses	', 'Aviators, wayfarers, square shades\r\n', '2025-03-24 06:14:52', '2025-03-24 06:14:52', '67e0f85c5fa78.jpg');

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
(6, 'tom', 'tom@gmail.com', '$2y$10$GyGfjBsowfTK5/PWpfjrLOob8vOlZ.mdJUzPQ9EKfv4aPqYV5gp.S', '2025-02-09 16:03:24', 'user', '67a8d27c29e69.jpg', 'asdasda', '12354');

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
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`recommendation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

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
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `recommendation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_behavior`
--
ALTER TABLE `user_behavior`
  MODIFY `behavior_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `recommendations_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

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
