-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 11:32 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 4, 3, 1, '2025-10-29 14:50:56', '2025-10-29 14:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT 'Demo',
  `payment_reference` varchar(100) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `payment_method`, `payment_reference`, `paid_at`) VALUES
(1, 294, 170.00, 'Pending', '2025-11-05 20:36:00', 'Demo', NULL, NULL),
(2, 294, 25.00, 'Pending', '2025-11-05 20:39:02', 'Demo', NULL, NULL),
(3, 294, 85.00, 'Pending', '2025-11-05 20:41:45', 'Demo', NULL, NULL),
(4, 294, 60.00, 'Paid', '2025-11-05 20:42:29', 'Demo', NULL, NULL),
(5, 294, 95.00, 'Paid', '2025-11-05 20:43:05', 'Demo', NULL, NULL),
(6, 294, 85.00, 'Paid', '2025-11-05 20:55:57', 'Demo Payment', 'DEMO-690B6C9253AAD', '2025-11-05 20:56:10'),
(7, 294, 25.00, 'Paid', '2025-11-05 20:56:51', 'Demo Payment', 'DEMO-690B6CC52FE09', '2025-11-05 20:57:01'),
(8, 294, 25.00, 'Paid', '2025-11-05 21:02:46', 'Demo Payment', 'DEMO-690B6E2098249', '2025-11-05 21:02:48'),
(9, 294, 50.00, 'Paid', '2025-11-05 22:28:08', 'Demo Payment', 'DEMO-690B8259D71A0', '2025-11-05 22:29:05'),
(10, 1, 220.00, 'Paid', '2025-11-06 19:42:25', 'Demo Payment', 'DEMO-690CACCABF39C', '2025-11-06 19:42:26'),
(11, 1, 25.00, 'Paid', '2025-11-06 19:45:07', 'Demo Payment', 'DEMO-690CAD7553C58', '2025-11-06 19:45:17'),
(12, 1, 60.00, 'Demo', '2025-11-06 19:52:55', 'Demo Payment', 'DEMO-690CAF45AC6B9', NULL),
(13, 295, 155.00, 'Demo', '2025-11-06 20:03:10', 'Demo Payment', 'DEMO-690CB1A96610B', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 4, 3, 25.00),
(2, 1, 6, 1, 25.00),
(3, 1, 3, 2, 35.00),
(4, 2, 4, 1, 25.00),
(5, 3, 3, 1, 35.00),
(6, 3, 6, 1, 25.00),
(7, 3, 10, 1, 25.00),
(8, 4, 4, 1, 25.00),
(9, 4, 3, 1, 35.00),
(10, 5, 4, 1, 25.00),
(11, 5, 12, 1, 35.00),
(12, 5, 3, 1, 35.00),
(13, 6, 3, 1, 35.00),
(14, 6, 4, 1, 25.00),
(15, 6, 6, 1, 25.00),
(16, 7, 4, 1, 25.00),
(17, 8, 4, 1, 25.00),
(18, 9, 4, 2, 25.00),
(19, 10, 4, 3, 25.00),
(20, 10, 6, 1, 25.00),
(22, 10, 3, 2, 35.00),
(23, 11, 4, 1, 25.00),
(24, 12, 4, 1, 25.00),
(25, 12, 3, 1, 35.00),
(26, 13, 4, 1, 25.00),
(27, 13, 3, 3, 35.00),
(28, 13, 6, 1, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `created_at`) VALUES
(3, 'Pulses', 35.00, 'These are pulses which is very rich in proteins', 'pulses.JPG', '2025-10-28 06:46:08'),
(4, 'product1', 25.00, 'it is a ball point pen', 'product1.jpg', '2025-10-28 06:55:26'),
(6, 'Black Gram', 25.00, 'This is Black gram ', 'black_pulses.jpg', '2025-10-28 07:11:52'),
(10, 'Blue pen', 25.00, 'This is Blue fountain pen', 'blue_pen.jpg', '2025-11-02 15:08:57'),
(12, 'Roasted Grams', 35.00, 'These are rich in protein', 'roasted_grams.png', '2025-11-04 08:47:47'),
(13, 'Silver Pen', 25.00, 'This is silver fountain pen', 'silver_pen.jpg', '2025-11-06 14:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, '', 'pasumarthimahalakshmi73@gmail.com', '$2y$10$O4kt4A5ZMp7cL7CUwhjOrel9XRItSqhdnIZuh6Q0qVG3VkTtaUl8S', '2025-10-27 09:23:08', 'user'),
(2, '', 'pasumarthimahalakshmi@gmail.com', '$2y$10$00WlZSjoL48EMjJ0beP6qe9cyODfvrv/ZiTanjRQtW0uMpfrtQl3q', '2025-10-29 14:25:07', 'user'),
(3, '', 'manjusha43@gmail.com', '$2y$10$Tg.z.zm5cpACRNX9cMPfpOuBKLzQO2bNFpQch9WYFlZ6yMPm6NhnS', '2025-10-29 14:45:49', 'user'),
(4, '', 'mahalakshmi79@gmail.com', '$2y$10$HuYtpFg29DyDJ0BgL5MpMub2Jh/3SoxJaAI96gCwi5PNdmcPw94Li', '2025-10-29 14:50:52', 'user'),
(292, 'admin sandhya', 'sasi2016@gmail.com', '$2y$10$KoeDFthtA8jpxvcLV4zN5eBpvlser7/smQUGMztLP683eNTTp44Ze', '2025-11-01 12:42:06', 'admin'),
(293, 'admin prasanth', 'saisiva99@gmail.com', '$2y$10$HuhZTxciPmbaQgRjKUXKAuZ3D1U4Q891eJTfIbdqU8gWxa0p2uWBC', '2025-11-04 07:55:25', 'admin'),
(294, '', 'srisivasaimanjusha@gmail.com', '$2y$10$TLKHLdgnXtGtfLbTWvMkMeQIQe8vj11RwNWR7IbdUB.R693TrxYXG', '2025-11-05 14:28:35', 'user'),
(295, '', 'pasumarthimahalakshmi47@gmail.com', '$2y$10$313.e2y6ORiUTgx8ZYsFouW9JVDxe0SGYwXTL2NBaWX.aYFwrpI4G', '2025-11-06 14:32:19', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
