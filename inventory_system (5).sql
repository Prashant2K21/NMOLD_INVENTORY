-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 06:40 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory system`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(40) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `buyer_contact` varchar(100) NOT NULL,
  `buyer_gstin` varchar(100) NOT NULL,
  `buyer_account_name` varchar(40) NOT NULL,
  `buyer_account_number` varchar(50) NOT NULL,
  `buyer_ifsc` varchar(40) NOT NULL,
  `buyer_location` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_by` int(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`id`, `buyer_name`, `buyer_contact`, `buyer_gstin`, `buyer_account_name`, `buyer_account_number`, `buyer_ifsc`, `buyer_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'aditya', '987154549', 'g03456789678', '', '', '', 'haryana', 'divyasain7419@gmail.com', 54, '2024-01-27 08:58:43', '2024-01-27 08:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Block'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order`
--

CREATE TABLE `invoice_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_receiver_name` varchar(250) NOT NULL,
  `order_receiver_address` text NOT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `order_total_tax` decimal(10,2) NOT NULL,
  `order_tax_per` varchar(250) NOT NULL,
  `order_total_after_tax` double(10,2) NOT NULL,
  `order_amount_paid` decimal(10,2) NOT NULL,
  `order_total_amount_due` decimal(10,2) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice_order`
--

INSERT INTO `invoice_order` (`order_id`, `user_id`, `order_date`, `order_receiver_name`, `order_receiver_address`, `order_total_before_tax`, `order_total_tax`, `order_tax_per`, `order_total_after_tax`, `order_amount_paid`, `order_total_amount_due`, `note`) VALUES
(691, 54, '2024-01-21 13:26:52', 'abc', 'mohali', 120000.00, 21600.00, '18', 141600.00, 1000.00, 140600.00, 'fdfd');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order_item`
--

CREATE TABLE `invoice_order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_code` varchar(250) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `order_item_price` decimal(10,2) NOT NULL,
  `order_item_final_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice_order_item`
--

INSERT INTO `invoice_order_item` (`order_item_id`, `order_id`, `item_code`, `product_name`, `order_item_quantity`, `order_item_price`, `order_item_final_amount`) VALUES
(4378, 691, '1', 'product3', 12.00, 10000.00, 120000.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(40) NOT NULL,
  `supplier` int(100) DEFAULT NULL,
  `product` int(100) DEFAULT NULL,
  `quantity_ordered` int(50) DEFAULT NULL,
  `quantity_received` int(100) DEFAULT NULL,
  `quantity_remaining` int(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `batch` int(50) DEFAULT NULL,
  `created_by` int(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `supplier`, `product`, `quantity_ordered`, `quantity_received`, `quantity_remaining`, `status`, `batch`, `created_by`, `created_at`, `updated_at`) VALUES
(90, 17, 49, 120, 12, 108, 'incomplete', 1705843458, 54, '2024-01-21 14:24:18', '2024-01-21 14:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_product_history`
--

CREATE TABLE `order_product_history` (
  `id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `qty_received` int(11) NOT NULL,
  `date_received` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_product_history`
--

INSERT INTO `order_product_history` (`id`, `order_product_id`, `qty_received`, `date_received`, `date_updated`) VALUES
(41, 90, 12, '2024-01-21 14:24:49', '2024-01-21 14:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(40) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `created_by` int(40) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `img`, `stock`, `created_by`, `created_at`, `updated_at`) VALUES
(48, 'product1', 'hjijkjrfndkjdf', 'product-1705843390.png', 0, 54, '2024-01-21 14:23:10', '2024-01-21 14:23:10'),
(49, 'product2', 'skjdjsf', 'product-1705843436.png', 12, 54, '2024-01-21 14:23:56', '2024-01-21 14:23:56'),
(50, 'product3', 'vvhvhh', 'product-1705843544.png', 0, 54, '2024-01-21 14:25:44', '2024-01-21 14:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `productsuppliers`
--

CREATE TABLE `productsuppliers` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `updated_at`, `created_at`) VALUES
(51, 17, 49, '2024-01-21 14:23:56', '2024-01-21 14:23:56'),
(52, 18, 50, '2024-01-21 14:25:44', '2024-01-21 14:25:44'),
(53, 17, 50, '2024-01-21 14:25:44', '2024-01-21 14:25:44'),
(54, 24, 49, '2024-02-03 15:07:02', '2024-02-03 15:07:02'),
(55, 23, 50, '2024-02-03 15:08:37', '2024-02-03 15:08:37');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(40) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_contact` varchar(255) NOT NULL,
  `supplier_gstin` varchar(30) NOT NULL,
  `supplier_account_name` varchar(255) NOT NULL,
  `supplier_account_number` varchar(255) NOT NULL,
  `supplier_ifsc` varchar(255) NOT NULL,
  `supplier_location` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_by` int(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_contact`, `supplier_gstin`, `supplier_account_name`, `supplier_account_number`, `supplier_ifsc`, `supplier_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(17, 'supplier1', '', '', '', '', '', 'haryana', 'desf8349@gmail.com2', 54, '2024-01-21 14:23:29', '2024-01-21 14:23:29'),
(18, 'test42', '', '', '', '', '', 'test noida2', 'desf89@gmail.com', 54, '2024-01-21 14:25:21', '2024-01-21 14:25:21'),
(19, '', '', '', '', '', '', '', 'dfdfygcdh@gmail.com', 54, '2024-01-27 08:33:43', '2024-01-27 08:33:43'),
(20, '', '', '', '', '', '', '', '', 54, '2024-01-27 08:34:26', '2024-01-27 08:34:26'),
(21, '', '', '', '', '', '', '', '', 54, '2024-01-27 08:35:22', '2024-01-27 08:35:22'),
(22, 'asd', '7419266629', 'g3000668788697', '', '', '', 'haryana', 'dfdfygcdh@gmail.com', 54, '2024-01-27 08:53:30', '2024-01-27 08:53:30'),
(23, 'divya', '7419266629', 'g035r67890', '', '', '', 'canda', 'dogranonu699@gmail.com', 54, '2024-01-27 08:54:17', '2024-01-27 08:54:17'),
(24, 'abcd', '123456789', 'g034567890', 'dfg', '1234', 'hgfjhf431524', 'haryana', 'hdgfhg@gmail.com', 54, '2024-02-03 09:43:26', '2024-02-03 09:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(40) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 0 COMMENT '(0=>user,1=>admin,2=>sales,3=purchase>)\r\n',
  `created_by` int(40) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `role`, `created_by`, `created_at`, `updated_at`) VALUES
(52, 'def', 'qwe', '$2y$10$CbyN3BUZU21WzNsT0VzrNOIbQ6kAM7XYET4IkOGhRm1rG4bTgmkxu', 'abc1234567', 2, 0, '2024-01-14 15:05:40', '2024-01-14 15:05:40'),
(53, 'juy', 'yut', '$2y$10$Sh4MSYuO14VnVIG3idaIgObymJlX6Sirty1UW8qoShbgK7yUpscLe', 'abc12345678', 3, 0, '2024-01-14 15:06:05', '2024-01-14 15:06:05'),
(54, 'iuy', 'opi', '$2y$10$boMWoAA7MnSfhTk/TKKWqOtV7jjjU77W1vFVLP6hMwWjfj/duKbgS', 'abc123456789', 1, 0, '2024-01-14 15:06:32', '2024-01-14 15:06:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `invoice_order`
--
ALTER TABLE `invoice_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier` (`supplier`),
  ADD KEY `product` (`product`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_id` (`order_product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`created_by`);

--
-- Indexes for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`),
  ADD KEY `supplier` (`supplier`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_order`
--
ALTER TABLE `invoice_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=692;

--
-- AUTO_INCREMENT for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4379;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `order_product_history`
--
ALTER TABLE `order_product_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyers`
--
ALTER TABLE `buyers`
  ADD CONSTRAINT `buyers_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD CONSTRAINT `order_product_history_ibfk_1` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD CONSTRAINT `productsuppliers_ibfk_1` FOREIGN KEY (`product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `productsuppliers_ibfk_2` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
