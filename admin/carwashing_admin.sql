-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-13 08:52:23
-- 服务器版本： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `carwashing`
--

-- --------------------------------------------------------

--
-- 表的结构 `car`
--

CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL,
  `identity_code` varchar(200) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `LastName` varchar(10) NOT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `balance` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `FirstName`, `LastName`, `sex`, `tel`, `address`, `balance`) VALUES
(1, 'Mars', '1234', 'Mars', 'Liu', 1, '123456789001', 'CDUTSong2-562', 410),
(2, 'Cary', '1234', 'Cary', 'Tian', 0, '1829444332', 'CDUTSong2-334', 43),
(5, 'kevin', '1234', 'Kevin', 'He', 3, '23333', 'CDUT562', 10);

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `usergroup` enum('manager','worker','day laborer') DEFAULT NULL,
  `hiredate` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`id`, `username`, `password`, `firstname`, `lastname`, `phone`, `usergroup`, `hiredate`) VALUES
(1, 'Marshall', '1234', 'Marshall', 'Liu', '1234567890', 'manager', '2016-12-01'),
(2, 'Cary', '1234', 'Carry', 'Tian', '1234567890', 'manager', '2016-12-01'),
(3, 'Leo', '1234', 'Leo', 'Li', '1234567890', 'manager', '2016-12-01'),
(4, 'Kevin', '1234', 'Kevin', 'He', '1234567890', 'worker', '2016-12-01');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL,
  `cus_id` varchar(6) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `rate` int(11) NOT NULL,
  `Discount` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `cus_id`, `employee_id`, `car_id`, `Date`, `Time`, `status`, `rate`, `Discount`) VALUES
(1, '2', 0, 0, '2016-12-02', '23:08:49', 4, 0, 0),
(4, '2', 0, 0, '2016-12-03', '01:41:34', 4, 0, 0),
(5, '1', 2, 0, '2017-01-22', '18:51:38', 4, 0, 0),
(8, '1', 4, 0, '2017-01-24', '02:51:16', 4, 0, 0),
(9, '1', 3, 0, '2017-01-25', '17:17:28', 4, 0, 0),
(11, '1', 4, 0, '2017-02-19', '14:22:50', 0, 0, 0),
(12, '5', 2, 0, '2017-02-21', '16:15:40', 0, 0, 0),
(13, '5', 2, 0, '2017-03-02', '12:27:19', 4, 0, 0),
(14, '5', 2, 0, '2017-03-03', '10:53:20', 0, 0, 0),
(15, '2', 1, 0, '2017-03-09', '13:20:25', 0, 0, 0),
(16, '5', 3, 0, '2017-03-09', '13:30:41', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `item_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_product`
--

INSERT INTO `order_product` (`item_id`, `order_id`, `product_id`, `Quantity`) VALUES
(1, 1, 10, 1),
(2, 1, 13, 1),
(3, 2, 7, 1),
(6, 4, 13, 1),
(7, 5, 3, 1),
(8, 5, 17, 1),
(9, 5, 6, 1),
(10, 6, 4, 1),
(11, 6, 9, 1),
(12, 6, 7, 2),
(13, 7, 17, 1),
(14, 7, 5, 1),
(15, 7, 6, 1),
(16, 7, 10, 2),
(17, 7, 9, 2),
(18, 7, 15, 1),
(19, 8, 3, 1),
(20, 8, 8, 1),
(21, 9, 3, 1),
(22, 10, 4, 1),
(23, 10, 9, 1),
(24, 10, 7, 1),
(25, 11, 17, 1),
(26, 11, 6, 1),
(27, 11, 10, 2),
(28, 11, 9, 2),
(29, 11, 15, 1),
(30, 12, 3, 1),
(31, 13, 3, 1),
(32, 13, 10, 1),
(33, 14, 11, 1),
(34, 15, 3, 1),
(35, 16, 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'Ongoing'),
(3, 'Unpaid'),
(4, 'Paid');

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `pay_time` time DEFAULT NULL,
  `pay_type` enum('VIPcard','Alipay','WechatPay','cash') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `product_service`
--

CREATE TABLE IF NOT EXISTS `product_service` (
  `id` int(10) unsigned NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `product_service`
--

INSERT INTO `product_service` (`id`, `product_name`, `Price`, `type_id`) VALUES
(1, 'Service', NULL, 1),
(2, 'Accessories ', NULL, 2),
(3, 'Small Car Washing', 25, 1),
(4, 'Big Car Washing', 35, 1),
(5, 'Wax ', 120, 1),
(6, 'Polishing ', 200, 1),
(7, 'Engine oil', 180, 2),
(8, 'Car Navigator ', 200, 2),
(9, 'Glass cleaning water ', 80, 2),
(10, 'Cushion ', 30, 2),
(11, 'Drive Recorder ', 200, 2),
(12, 'Drinks', NULL, 12),
(13, 'Cola', 4, 12),
(14, 'RedBull', 8, 12),
(15, 'Water', 3, 12),
(16, 'Fine Small Car Washing', 35, 1),
(17, 'Fine Big Car Washing', 45, 1);

-- --------------------------------------------------------

--
-- 表的结构 `recharge`
--

CREATE TABLE IF NOT EXISTS `recharge` (
  `id` int(11) NOT NULL,
  `cus_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `paytype` enum('Cash','AliPay','WeChatPay') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `recharge`
--

INSERT INTO `recharge` (`id`, `cus_id`, `price`, `datetime`, `paytype`) VALUES
(1, 1, 100, '2016-12-02 12:00:00', 'Cash'),
(2, 2, 150, '2016-12-02 09:22:25', 'AliPay'),
(3, 5, 10, '2017-03-03 00:11:30', 'WeChatPay'),
(4, 1, 100, '2017-03-03 00:14:28', 'Cash'),
(5, 1, 100, '2017-03-03 00:19:57', 'Cash'),
(6, 1, 100, '2017-03-03 00:20:21', 'Cash'),
(7, 1, 100, '2017-03-03 00:20:32', 'Cash'),
(8, 2, 21, '2017-03-03 00:21:00', 'AliPay'),
(9, 2, 12, '2017-03-11 16:10:58', 'Cash');

-- --------------------------------------------------------

--
-- 表的结构 `salary_category`
--

CREATE TABLE IF NOT EXISTS `salary_category` (
  `id` int(11) NOT NULL,
  `kpi` varchar(100) DEFAULT NULL,
  `monthlysalary` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `salary_category`
--

INSERT INTO `salary_category` (`id`, `kpi`, `monthlysalary`) VALUES
(1, '< 20', 2000),
(2, '20-30', 2200),
(3, '30-40', 2400),
(4, '40-50', 2600),
(5, '50-60', 2800),
(6, '60-70', 3000),
(7, '70-80', 3200),
(8, '80-90', 3400),
(9, '90-100', 3600),
(10, '100-120', 3800),
(11, '> 120', 4000);

-- --------------------------------------------------------

--
-- 表的结构 `salary_record`
--

CREATE TABLE IF NOT EXISTS `salary_record` (
  `id` int(11) NOT NULL,
  `employee_id` int(10) unsigned NOT NULL,
  `kpi` int(11) DEFAULT NULL,
  `salary_category_id` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`), ADD KEY `customer_id` (`cus_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`item_id`), ADD KEY `food_id` (`product_id`), ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_service`
--
ALTER TABLE `product_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_category`
--
ALTER TABLE `salary_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_record`
--
ALTER TABLE `salary_record`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_service`
--
ALTER TABLE `product_service`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `recharge`
--
ALTER TABLE `recharge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `salary_category`
--
ALTER TABLE `salary_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `salary_record`
--
ALTER TABLE `salary_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
