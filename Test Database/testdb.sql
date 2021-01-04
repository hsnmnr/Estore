-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2019 at 10:15 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`user_id`, `first_name`, `last_name`, `password`) VALUES
(1, 'Hassan Munir', 'Chaudhary', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

CREATE TABLE `buy` (
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `total` int(20) NOT NULL,
  `order_id` int(20) NOT NULL,
  `autoincrement` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buy`
--

INSERT INTO `buy` (`product_id`, `user_id`, `quantity`, `total`, `order_id`, `autoincrement`) VALUES
(4, 1, 1, 500, 1, 1),
(4, 1, 10, 5000, 2, 2),
(4, 1, 1, 500, 3, 3),
(4, 1, 1, 500, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `product_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `total` int(20) NOT NULL,
  `autoincrement` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'SWEET'),
(2, 'Fashion'),
(3, 'Electronics'),
(4, 'Clothes'),
(5, 'Wear');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_code` varchar(50) NOT NULL,
  `money` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_code`, `money`) VALUES
('1122', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `status`) VALUES
(1, 1, 'delivered'),
(2, 1, 'delivered'),
(3, 1, 'pending'),
(4, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` int(10) NOT NULL,
  `date_added` datetime NOT NULL,
  `description` varchar(2000) NOT NULL,
  `price` int(10) NOT NULL,
  `icon_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `date_added`, `description`, `price`, `icon_name`) VALUES
(4, 'Handfree Audonic', 3, '2019-05-04 12:25:00', 'We love the louder', 500, 'handfree.jpg'),
(5, 'Leather shoes', 5, '2019-05-12 12:08:47', 'Easy Walk', 5000, 'f3eb66.jpg'),
(6, 'Men Jacket', 4, '2019-05-12 12:10:07', 'New Fashion...\r\nNew look...\r\nNew design', 6000, 'images (3).jpg'),
(7, 'Men Shirt 1', 4, '2019-05-12 12:10:40', 'Shirt', 800, 'ff882d2d5edb41ffb6a1ce6088ff2e47_350x350.jpg'),
(8, 'Men Shirt 3', 4, '2019-05-12 12:11:39', 'Shirt', 800, 'download (1).jpg'),
(9, 'Men Shirt 4', 4, '2019-05-12 12:11:54', 'Shirt', 800, 'images (7).jpg'),
(10, 'Men Shirt 5', 4, '2019-05-12 12:13:32', 'Shirt', 800, 'images (5).jpg'),
(11, 'Jacket', 4, '2019-05-12 12:16:03', 'Beautiful Jacket', 5999, 'HTB1TAyHSMHqK1RjSZFEq6AGMXXaO.jpg_220x220q90.jpg_.webp'),
(12, 'Woman Wear 1', 4, '2019-05-12 12:16:36', 'Beautiful Jacket', 5999, 'blusas-mujer-de-moda-2018-white-hollow-lace-chiffon-blouse-shirt-long-sleeve-womens-tops-and.jpg_220x220xz.webp'),
(13, 'Woman Wear 2', 4, '2019-05-12 12:16:54', 'Beautiful Jacket', 2500, 'download (2).jpg'),
(14, 'Woman Wear 3', 4, '2019-05-12 12:17:20', 'agvbfak', 1800, 'Fashion-5XL-Plus-Large-Size-Women-s-Blouses-Summer-Tops-New-Leisure-Blouse-White-Loose-Feather.jpg_220x220xz.webp');

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `user_id` int(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(34) NOT NULL,
  `wallet` int(20) NOT NULL,
  `address` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`user_id`, `first_name`, `last_name`, `password`, `wallet`, `address`) VALUES
(1, 'Hassan Munir', 'Chaudhary', '12345678', 999999, 'Sargodha'),
(2, 'wajid', 'haneef', '12345678', 500, 'lahore mt'),
(3, 'adeel', 'tajamul', '12345678', 100, 'lahore wt'),
(4, 'jahangir', 'maqsood', '12345678', 50, 'lahore mp'),
(5, 'usman', 'Chaudhary', '12345678', 25, 'lahore');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`autoincrement`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`autoincrement`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buy`
--
ALTER TABLE `buy`
  MODIFY `autoincrement` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `autoincrement` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
