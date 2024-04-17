-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 11:49 AM
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
-- Database: `project_database_server`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(2, 'game'),
(5, 'e-walllet');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `username`, `first_name`, `last_name`, `email`, `password`, `user_type`, `image`) VALUES
(2, 'admin', 'admin', 'first', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'admin', 'admin.jpeg'),
(3, 'test', 'test', 'first', 'test@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 'user', '2179151c492c743e10b15dca9bec671e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `productdetails_id` int(11) DEFAULT NULL,
  `orderdetails_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_id`, `product_id`, `productdetails_id`, `orderdetails_id`) VALUES
(47, 47, 29, 12);

-- --------------------------------------------------------

--
-- Table structure for table `ordermaster`
--

CREATE TABLE `ordermaster` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `userid` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ordermaster`
--

INSERT INTO `ordermaster` (`order_id`, `customer_id`, `order_date`, `userid`) VALUES
(47, 3, '2024-04-17 11:48:10', 'Rayn#409');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `transaction_date` datetime NOT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_method`, `transaction_date`, `order_id`) VALUES
(32, 'Qris', '2024-04-17 00:00:00', 47);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `image`, `category_id`, `product_name`) VALUES
(21, 'pubg_mobile.jpg', 2, 'PUBG'),
(25, 'freefire.jpg', 2, 'Free Fire'),
(26, 'eafc.jpg', 2, 'EA SPORT FC Mobile'),
(28, 'gopay.png', 5, 'Go-Pay'),
(29, 'dana.jpg', 5, 'DANA'),
(30, 'ovo.png', 5, 'OVO'),
(31, 'spay.png', 5, 'Shopee-Pay'),
(32, 'linkaja.png', 5, 'LinkAja'),
(33, 'isaku.png', 5, 'I-Saku'),
(34, 'yukk.png', 5, 'Yukk'),
(35, 'steam.jpg', 5, 'Steam-Wallet'),
(36, 'codm.jpg', 2, 'Call of Duty Mobile'),
(37, 'genshin.jpg', 2, 'Genshin Impact'),
(38, 'hayday.jpg', 2, 'HayDay'),
(39, 'honkaiimpact.jpg', 2, 'Honkai Impact 3'),
(40, 'honkairail.jpg', 2, 'Honkai Star Rail'),
(41, 'legendsofrunetrra.jpg', 2, 'Legend of Runeterra'),
(42, 'lol.jpg', 2, 'League of Legends'),
(43, 'metalslug.jpg', 2, 'Metal Slug'),
(44, 'supersus.jpg', 2, 'SuperSus'),
(45, 'ttm.jpg', 2, 'Teamfight Tactics Mobile'),
(46, 'undawn.jpg', 2, 'Undawn'),
(47, 'valorant.jpg', 2, 'Valorant'),
(49, 'mobile_legends.jpg', 2, 'Mobile Legends');

-- --------------------------------------------------------

--
-- Table structure for table `productdetails`
--

CREATE TABLE `productdetails` (
  `productdetails_id` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productdetails`
--

INSERT INTO `productdetails` (`productdetails_id`, `image`, `product_id`, `description`, `price`) VALUES
(8, 'uc_pubg.png', 21, '100 uc', 100000.00),
(9, 'eafc.jpg', NULL, NULL, NULL),
(10, 'eafc.jpg', NULL, NULL, NULL),
(11, 'eafc.jpg', NULL, NULL, NULL),
(12, 'diamond.jpg', 49, '100 diamonds', 100.00),
(13, 'diamond.jpg', 25, '100 diamonds', 100.00),
(14, 'fc.jpeg', 26, '100 FC POINT', 100.00),
(15, 'cp.jpeg', 36, '100 CP', 100.00),
(16, 'diamond.jpg', 37, '300 Genesis Crystals', 100.00),
(17, 'diamond.jpg', 38, '300 diamonds', 100.00),
(18, 'diamond.jpg', 39, '500 Crystals', 100.00),
(19, 'oneiric.jpeg', 40, '1000 Oneiric Shard', 100.00),
(21, 'coinlor.jpeg', 41, '1100 Coins', 100.00),
(23, 'lol.png', 42, '900 Wild Cores', 100.00),
(24, 'ruby.jpeg', 43, '100 Ruby', 100.00),
(25, 'gopay.png', 28, '100.000', 100500.00),
(26, 'goldenstar.png', 44, '100 Golden Stars', 100.00),
(27, 'coinlor.jpeg', 45, '1100 Coins', 100.00),
(28, 'logo.png', 46, '950 RC', 100.00),
(29, 'vp.png', 47, '1100 VP', 100.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderdetails_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `productdetails_id` (`productdetails_id`);

--
-- Indexes for table `ordermaster`
--
ALTER TABLE `ordermaster`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `FK_order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `productdetails`
--
ALTER TABLE `productdetails`
  ADD PRIMARY KEY (`productdetails_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `orderdetails_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ordermaster`
--
ALTER TABLE `ordermaster`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `productdetails`
--
ALTER TABLE `productdetails`
  MODIFY `productdetails_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ordermaster` (`order_id`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `orderdetails_ibfk_3` FOREIGN KEY (`productdetails_id`) REFERENCES `productdetails` (`productdetails_id`);

--
-- Constraints for table `ordermaster`
--
ALTER TABLE `ordermaster`
  ADD CONSTRAINT `ordermaster_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_order_id` FOREIGN KEY (`order_id`) REFERENCES `ordermaster` (`order_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `productdetails`
--
ALTER TABLE `productdetails`
  ADD CONSTRAINT `productdetails_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
