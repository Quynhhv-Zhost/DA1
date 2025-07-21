-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2025 at 06:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sell_products`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `variation_id` int DEFAULT NULL,
  `quantity` int DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `product_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` enum('momo','cod') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cod'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `payment_method`) VALUES
(1, 3, '1650000.00', 'pending', '2025-07-15 07:38:40', 'cod'),
(2, 3, '1650000.00', 'pending', '2025-07-15 07:39:06', 'cod'),
(3, 3, '1650000.00', 'pending', '2025-07-15 07:40:52', 'cod'),
(4, 3, '1650000.00', 'pending', '2025-07-15 07:42:19', 'cod'),
(5, 3, '3039102.00', 'pending', '2025-07-15 08:05:11', 'cod'),
(6, 3, '2026068.00', 'pending', '2025-07-15 08:09:06', 'cod'),
(7, 3, '1100000.00', 'pending', '2025-07-15 08:09:50', 'cod'),
(8, 3, '1100000.00', 'pending', '2025-07-15 08:10:18', 'cod'),
(9, 3, '1013034.00', 'pending', '2025-07-16 02:03:31', 'cod'),
(10, 3, '4052136.00', 'pending', '2025-07-16 08:18:27', 'cod'),
(11, 4, '1100000.00', 'pending', '2025-07-18 07:39:08', 'cod'),
(12, 4, '550000.00', 'pending', '2025-07-18 08:24:05', 'momo'),
(13, 4, '550000.00', 'pending', '2025-07-18 08:26:38', 'cod'),
(14, 4, '550000.00', 'pending', '2025-07-18 08:28:31', 'cod'),
(15, 5, '4052136.00', 'pending', '2025-07-21 05:16:18', 'cod');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `variation_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `variation_id`) VALUES
(1, 4, 8, 1, '500000.00', 30),
(2, 4, 10, 1, '500000.00', 63),
(3, 4, 11, 1, '500000.00', 78),
(4, 5, 12, 3, '920940.00', 5),
(5, 6, 12, 2, '920940.00', 16),
(6, 7, 10, 2, '500000.00', 58),
(7, 8, 11, 2, '500000.00', 78),
(8, 9, 12, 1, '920940.00', 3),
(9, 10, 12, 4, '920940.00', 1),
(10, 11, 11, 2, '500000.00', 73),
(11, 12, 8, 1, '500000.00', 32),
(12, 13, 11, 1, '500000.00', 73),
(13, 14, 11, 1, '500000.00', 85),
(14, 15, 12, 4, '920940.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `momo_order_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(15,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(8, 'test tiếp 1', 'Đẹp', '3300002.00', 'anh5.jpg', '2025-07-01 08:16:57'),
(9, 'Sản Phẩm 4', 'âlalllaa', '3002902.00', 'anh1.jpeg', '2025-07-01 08:17:27'),
(10, 'AAAAAA', 'ádaaaa', '23242424.00', 'anh1.jpeg', '2025-07-01 08:23:26'),
(11, 'fkkakaha', 'oioio', '2090903.00', 'anh4.jpeg', '2025-07-01 08:23:47'),
(12, 'aasdasd', 'lllajfosjfkawf', '920940.00', 'anh2.jpeg', '2025-07-02 07:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `comment` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 12, 5, 5, 'tốt', '2025-07-21 12:46:40'),
(2, 12, 5, 4, 'tạm', '2025-07-21 12:48:38'),
(3, 12, 5, 4, 'tạm', '2025-07-21 12:50:07'),
(4, 12, 5, 1, 'kém', '2025-07-21 12:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `variation_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int DEFAULT '0',
  `size` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `variation_name`, `price`, `image`, `stock`, `size`, `color`) VALUES
(1, 12, 'Trắng Size 35', '920940.00', '', 10, '35', 'trắng'),
(2, 12, 'Trắng Size 36', '920940.00', '', 8, '36', 'trắng'),
(3, 12, 'Trắng Size 37', '920940.00', '', 5, '37', 'trắng'),
(4, 12, 'Hồng Size 35', '920940.00', '', 6, '35', 'hồng'),
(5, 12, 'Hồng Size 36', '920940.00', '', 5, '36', 'hồng'),
(6, 12, 'Đen Size 35', '920940.00', '', 9, '35', 'đen'),
(7, 12, 'Đen Size 36', '920940.00', '', 7, '36', 'đen'),
(8, 12, 'đen size 35', '920940.00', NULL, 10, '35', 'đen'),
(9, 12, 'trắng size 35', '920940.00', NULL, 10, '35', 'trắng'),
(10, 12, 'hồng size 35', '920940.00', NULL, 10, '35', 'hồng'),
(11, 12, 'đen size 36', '920940.00', NULL, 10, '36', 'đen'),
(12, 12, 'trắng size 36', '920940.00', NULL, 10, '36', 'trắng'),
(13, 12, 'hồng size 36', '920940.00', NULL, 10, '36', 'hồng'),
(14, 12, 'đen size 37', '920940.00', NULL, 10, '37', 'đen'),
(15, 12, 'trắng size 37', '920940.00', NULL, 10, '37', 'trắng'),
(16, 12, 'hồng size 37', '920940.00', NULL, 10, '37', 'hồng'),
(17, 12, 'đen size 38', '920940.00', NULL, 10, '38', 'đen'),
(18, 12, 'trắng size 38', '920940.00', NULL, 10, '38', 'trắng'),
(19, 12, 'hồng size 38', '920940.00', NULL, 10, '38', 'hồng'),
(20, 12, 'đen size 39', '920940.00', NULL, 10, '39', 'đen'),
(21, 12, 'trắng size 39', '920940.00', NULL, 10, '39', 'trắng'),
(22, 12, 'hồng size 39', '920940.00', NULL, 10, '39', 'hồng'),
(27, 8, 'Đen - Size 35', '500000.00', NULL, 10, '35', 'đen'),
(28, 8, 'Đen - Size 36', '500000.00', NULL, 10, '36', 'đen'),
(29, 8, 'Đen - Size 37', '500000.00', NULL, 10, '37', 'đen'),
(30, 8, 'Đen - Size 38', '500000.00', NULL, 10, '38', 'đen'),
(31, 8, 'Đen - Size 39', '500000.00', NULL, 10, '39', 'đen'),
(32, 8, 'Trắng - Size 35', '500000.00', NULL, 10, '35', 'trắng'),
(33, 8, 'Trắng - Size 36', '500000.00', NULL, 10, '36', 'trắng'),
(34, 8, 'Trắng - Size 37', '500000.00', NULL, 10, '37', 'trắng'),
(35, 8, 'Trắng - Size 38', '500000.00', NULL, 10, '38', 'trắng'),
(36, 8, 'Trắng - Size 39', '500000.00', NULL, 10, '39', 'trắng'),
(37, 8, 'Hồng - Size 35', '500000.00', NULL, 10, '35', 'hồng'),
(38, 8, 'Hồng - Size 36', '500000.00', NULL, 10, '36', 'hồng'),
(39, 8, 'Hồng - Size 37', '500000.00', NULL, 10, '37', 'hồng'),
(40, 8, 'Hồng - Size 38', '500000.00', NULL, 10, '38', 'hồng'),
(41, 8, 'Hồng - Size 39', '500000.00', NULL, 10, '39', 'hồng'),
(42, 9, 'Đen - Size 35', '500000.00', NULL, 10, '35', 'đen'),
(43, 9, 'Đen - Size 36', '500000.00', NULL, 10, '36', 'đen'),
(44, 9, 'Đen - Size 37', '500000.00', NULL, 10, '37', 'đen'),
(45, 9, 'Đen - Size 38', '500000.00', NULL, 10, '38', 'đen'),
(46, 9, 'Đen - Size 39', '500000.00', NULL, 10, '39', 'đen'),
(47, 9, 'Trắng - Size 35', '500000.00', NULL, 10, '35', 'trắng'),
(48, 9, 'Trắng - Size 36', '500000.00', NULL, 10, '36', 'trắng'),
(49, 9, 'Trắng - Size 37', '500000.00', NULL, 10, '37', 'trắng'),
(50, 9, 'Trắng - Size 38', '500000.00', NULL, 10, '38', 'trắng'),
(51, 9, 'Trắng - Size 39', '500000.00', NULL, 10, '39', 'trắng'),
(52, 9, 'Hồng - Size 35', '500000.00', NULL, 10, '35', 'hồng'),
(53, 9, 'Hồng - Size 36', '500000.00', NULL, 10, '36', 'hồng'),
(54, 9, 'Hồng - Size 37', '500000.00', NULL, 10, '37', 'hồng'),
(55, 9, 'Hồng - Size 38', '500000.00', NULL, 10, '38', 'hồng'),
(56, 9, 'Hồng - Size 39', '500000.00', NULL, 10, '39', 'hồng'),
(57, 10, 'Đen - Size 35', '500000.00', NULL, 10, '35', 'đen'),
(58, 10, 'Đen - Size 36', '500000.00', NULL, 10, '36', 'đen'),
(59, 10, 'Đen - Size 37', '500000.00', NULL, 10, '37', 'đen'),
(60, 10, 'Đen - Size 38', '500000.00', NULL, 10, '38', 'đen'),
(61, 10, 'Đen - Size 39', '500000.00', NULL, 10, '39', 'đen'),
(62, 10, 'Trắng - Size 35', '500000.00', NULL, 10, '35', 'trắng'),
(63, 10, 'Trắng - Size 36', '500000.00', NULL, 10, '36', 'trắng'),
(64, 10, 'Trắng - Size 37', '500000.00', NULL, 10, '37', 'trắng'),
(65, 10, 'Trắng - Size 38', '500000.00', NULL, 10, '38', 'trắng'),
(66, 10, 'Trắng - Size 39', '500000.00', NULL, 10, '39', 'trắng'),
(67, 10, 'Hồng - Size 35', '500000.00', NULL, 10, '35', 'hồng'),
(68, 10, 'Hồng - Size 36', '500000.00', NULL, 10, '36', 'hồng'),
(69, 10, 'Hồng - Size 37', '500000.00', NULL, 10, '37', 'hồng'),
(70, 10, 'Hồng - Size 38', '500000.00', NULL, 10, '38', 'hồng'),
(71, 10, 'Hồng - Size 39', '500000.00', NULL, 10, '39', 'hồng'),
(72, 11, 'Đen - Size 35', '500000.00', NULL, 10, '35', 'đen'),
(73, 11, 'Đen - Size 36', '500000.00', NULL, 10, '36', 'đen'),
(74, 11, 'Đen - Size 37', '500000.00', NULL, 10, '37', 'đen'),
(75, 11, 'Đen - Size 38', '500000.00', NULL, 10, '38', 'đen'),
(76, 11, 'Đen - Size 39', '500000.00', NULL, 10, '39', 'đen'),
(77, 11, 'Trắng - Size 35', '500000.00', NULL, 10, '35', 'trắng'),
(78, 11, 'Trắng - Size 36', '500000.00', NULL, 10, '36', 'trắng'),
(79, 11, 'Trắng - Size 37', '500000.00', NULL, 10, '37', 'trắng'),
(80, 11, 'Trắng - Size 38', '500000.00', NULL, 10, '38', 'trắng'),
(81, 11, 'Trắng - Size 39', '500000.00', NULL, 10, '39', 'trắng'),
(82, 11, 'Hồng - Size 35', '500000.00', NULL, 10, '35', 'hồng'),
(83, 11, 'Hồng - Size 36', '500000.00', NULL, 10, '36', 'hồng'),
(84, 11, 'Hồng - Size 37', '500000.00', NULL, 10, '37', 'hồng'),
(85, 11, 'Hồng - Size 38', '500000.00', NULL, 10, '38', 'hồng'),
(86, 11, 'Hồng - Size 39', '500000.00', NULL, 10, '39', 'hồng'),
(87, 12, 'Đen - Size 35', '500000.00', NULL, 10, '35', 'đen'),
(88, 12, 'Đen - Size 36', '500000.00', NULL, 10, '36', 'đen'),
(89, 12, 'Đen - Size 37', '500000.00', NULL, 10, '37', 'đen'),
(90, 12, 'Đen - Size 38', '500000.00', NULL, 10, '38', 'đen'),
(91, 12, 'Đen - Size 39', '500000.00', NULL, 10, '39', 'đen'),
(92, 12, 'Trắng - Size 35', '500000.00', NULL, 10, '35', 'trắng'),
(93, 12, 'Trắng - Size 36', '500000.00', NULL, 10, '36', 'trắng'),
(94, 12, 'Trắng - Size 37', '500000.00', NULL, 10, '37', 'trắng'),
(95, 12, 'Trắng - Size 38', '500000.00', NULL, 10, '38', 'trắng'),
(96, 12, 'Trắng - Size 39', '500000.00', NULL, 10, '39', 'trắng'),
(97, 12, 'Hồng - Size 35', '500000.00', NULL, 10, '35', 'hồng'),
(98, 12, 'Hồng - Size 36', '500000.00', NULL, 10, '36', 'hồng'),
(99, 12, 'Hồng - Size 37', '500000.00', NULL, 10, '37', 'hồng'),
(100, 12, 'Hồng - Size 38', '500000.00', NULL, 10, '38', 'hồng'),
(101, 12, 'Hồng - Size 39', '500000.00', NULL, 10, '39', 'hồng');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin'),
(2, 'quynh', 'e10adc3949ba59abbe56e057f20f883e', 'user'),
(3, 'quynhhv', 'e10adc3949ba59abbe56e057f20f883e', 'user'),
(4, 'vuong', 'c4ca4238a0b923820dcc509a6f75849b', 'user'),
(5, 'a', 'c4ca4238a0b923820dcc509a6f75849b', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_id` (`variation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_order_variation` (`variation_id`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_variation` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`id`),
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
