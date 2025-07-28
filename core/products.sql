-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2025 at 06:20 AM
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_method` enum('momo','cod') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cod',
  `discount` decimal(10,2) DEFAULT '0.00',
  `coupon_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `payment_method`, `discount`, `coupon_code`, `address`, `phone`) VALUES
(1, 3, '1650000.00', 'pending', '2025-07-15 07:38:40', 'cod', '0.00', NULL, NULL, NULL),
(2, 3, '1650000.00', 'pending', '2025-07-15 07:39:06', 'cod', '0.00', NULL, NULL, NULL),
(3, 3, '1650000.00', 'pending', '2025-07-15 07:40:52', 'cod', '0.00', NULL, NULL, NULL),
(4, 3, '1650000.00', 'pending', '2025-07-15 07:42:19', 'cod', '0.00', NULL, NULL, NULL),
(5, 3, '3039102.00', 'pending', '2025-07-15 08:05:11', 'cod', '0.00', NULL, NULL, NULL),
(6, 3, '2026068.00', 'pending', '2025-07-15 08:09:06', 'cod', '0.00', NULL, NULL, NULL),
(7, 3, '1100000.00', 'pending', '2025-07-15 08:09:50', 'cod', '0.00', NULL, NULL, NULL),
(8, 3, '1100000.00', 'pending', '2025-07-15 08:10:18', 'cod', '0.00', NULL, NULL, NULL),
(9, 3, '1013034.00', 'pending', '2025-07-16 02:03:31', 'cod', '0.00', NULL, NULL, NULL),
(10, 3, '4052136.00', 'pending', '2025-07-16 08:18:27', 'cod', '0.00', NULL, NULL, NULL),
(11, 4, '1100000.00', 'pending', '2025-07-18 07:39:08', 'cod', '0.00', NULL, NULL, NULL),
(12, 4, '550000.00', 'pending', '2025-07-18 08:24:05', 'momo', '0.00', NULL, NULL, NULL),
(13, 4, '550000.00', 'pending', '2025-07-18 08:26:38', 'cod', '0.00', NULL, NULL, NULL),
(14, 4, '550000.00', 'pending', '2025-07-18 08:28:31', 'cod', '0.00', NULL, NULL, NULL),
(15, 5, '4052136.00', 'pending', '2025-07-21 05:16:18', 'cod', '0.00', NULL, NULL, NULL),
(16, 5, '1013034.00', 'pending', '2025-07-25 05:30:53', 'cod', '0.00', NULL, NULL, NULL),
(17, 5, '550000.00', 'pending', '2025-07-25 06:38:40', 'cod', '0.00', NULL, NULL, NULL),
(18, 5, '550000.00', 'pending', '2025-07-25 06:39:15', 'cod', '0.00', NULL, NULL, NULL),
(19, 5, '550000.00', 'pending', '2025-07-25 06:41:41', 'cod', '0.00', NULL, NULL, NULL),
(20, 5, '550000.00', 'pending', '2025-07-25 06:45:07', 'cod', '0.00', NULL, NULL, NULL),
(21, 4, '1563034.00', 'pending', '2025-07-25 07:15:50', 'cod', '0.00', NULL, NULL, NULL),
(22, 4, '550000.00', 'pending', '2025-07-25 07:18:07', 'cod', '0.00', NULL, NULL, NULL),
(23, 4, '1100000.00', 'pending', '2025-07-28 05:37:36', 'cod', '0.00', NULL, NULL, NULL),
(24, 4, '550000.00', 'pending', '2025-07-28 05:38:15', 'cod', '0.00', NULL, NULL, NULL),
(25, 4, '1013034.00', 'pending', '2025-07-28 06:11:57', 'cod', '200000.00', 'MAGIAMGIA2', 'P. Trịnh Văn Bô', '0967854619'),
(26, 4, '550000.00', 'pending', '2025-07-28 06:12:49', 'cod', '200000.00', 'MAGIAMGIA2', 'P. Trịnh Văn Bô', '0967854619'),
(27, 4, '550000.00', 'pending', '2025-07-28 06:15:48', 'cod', '200000.00', 'MAGIAMGIA2', 'P. Trịnh Văn Bô', '0967854619');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
