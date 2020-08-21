-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2018 at 08:51 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bitetoeat`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(50) unsigned NOT NULL,
  `seller` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `customer` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `product_id` int(50) unsigned DEFAULT NULL,
  `qty` int(50) unsigned DEFAULT NULL,
  `add_date` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `add_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `seller`, `customer`, `product_id`, `qty`, `add_date`, `add_time`) VALUES
(1, '9983751677', '9988998899', 14, 1, '2016-09-07', '01:23:38pm');

-- --------------------------------------------------------

--
-- Table structure for table `c_info`
--

CREATE TABLE IF NOT EXISTS `c_info` (
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `mbl_no` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `delivery_mbl` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `landmark` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `pincode` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'Jaipur',
  `state` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'Rajasthan',
  `Country` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT 'India',
  `add_date` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `add_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_info`
--

INSERT INTO `c_info` (`name`, `mbl_no`, `delivery_mbl`, `email`, `address`, `landmark`, `pincode`, `city`, `state`, `Country`, `add_date`, `add_time`) VALUES
('Namita Kumawat', '8769017730', NULL, 'namita@gmail.com', '26, Adarsh Basti, Tonk Phatak, Jaipur', NULL, NULL, 'Jaipur', 'Rajasthan', 'India', '2016-09-06', '09:28:59pm'),
('Dinesh Kumar Kumawat', '9414654054', '8769017731', '013him@gmail.com', '26, Adarsh Basti, Tonk Phatak, Gali No. 2, Jaipur', 'Tonk Road', '302015', 'Jaipur', 'Rajasthan', 'India', '2016-07-18', '06:12:11pm'),
('Himanshu Kumawat', '9983751677', '8769017731', '013himanshu@gmail.com', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan', 'Near Tonk Roads', '302015', 'Jaipur', 'Rajasthan', 'India', '2016-07-18', '06:02:25pm'),
('Rahul Gupta', '9988998899', NULL, '013himanshu@gmai.com', NULL, NULL, NULL, 'Jaipur', 'Rajasthan', 'India', '2016-09-07', '01:18:08pm');

-- --------------------------------------------------------

--
-- Table structure for table `c_login`
--

CREATE TABLE IF NOT EXISTS `c_login` (
  `mbl_no` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `password` varchar(300) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `c_login`
--

INSERT INTO `c_login` (`mbl_no`, `password`) VALUES
('8769017730', 'hello'),
('9414654054', 'hello'),
('9983751677', 'hello'),
('9988998899', 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `orders_child`
--

CREATE TABLE IF NOT EXISTS `orders_child` (
  `id` int(50) unsigned NOT NULL,
  `order_parent_id` int(50) unsigned NOT NULL,
  `cart_id` int(50) unsigned DEFAULT NULL,
  `seller` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `product_id` int(50) unsigned DEFAULT NULL,
  `selling_price` int(15) unsigned DEFAULT NULL,
  `discount` int(3) unsigned DEFAULT NULL,
  `discount_type` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `net_price` int(15) unsigned DEFAULT NULL,
  `qty` int(50) unsigned DEFAULT NULL,
  `measure_unit` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `subtotal` int(15) unsigned DEFAULT NULL,
  `receive` int(1) NOT NULL DEFAULT '0',
  `dispatch` int(1) NOT NULL DEFAULT '0',
  `complete` int(1) NOT NULL DEFAULT '0',
  `snd_mail` int(2) unsigned DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_child`
--

INSERT INTO `orders_child` (`id`, `order_parent_id`, `cart_id`, `seller`, `product_id`, `selling_price`, `discount`, `discount_type`, `net_price`, `qty`, `measure_unit`, `subtotal`, `receive`, `dispatch`, `complete`, `snd_mail`) VALUES
(51, 64, 75, '9983751677', 6, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(52, 65, 57, '9983751677', 15, 140, NULL, NULL, 140, 1, 'pack', 140, 0, 0, 0, 0),
(53, 65, 64, '9983751677', 8, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(54, 65, 73, '9983751677', 6, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(55, 65, 74, '9983751677', 6, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(56, 66, 57, '9983751677', 15, 140, NULL, NULL, 140, 1, 'pack', 140, 0, 0, 0, 0),
(57, 66, 64, '9983751677', 8, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(58, 66, 73, '9983751677', 6, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(59, 67, 78, '9983751677', 15, 140, NULL, NULL, 140, 1, 'pack', 140, 0, 0, 0, 0),
(60, 67, 79, '9983751677', 4, 400, 50, 'Percent off', 200, 2, 'Half Plate', 400, 0, 0, 0, 0),
(61, 68, 80, '9983751677', 4, 400, 50, 'Percent off', 200, 1, 'Half Plate', 200, 0, 0, 0, 0),
(62, 69, 81, '9983751677', 4, 400, 50, 'Percent off', 200, 5, 'Half Plate', 1000, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders_parent`
--

CREATE TABLE IF NOT EXISTS `orders_parent` (
  `order_id` int(50) unsigned NOT NULL,
  `customer_mbl` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `customer_address` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `subtotal` int(15) unsigned DEFAULT NULL,
  `delivery_fee` int(15) unsigned DEFAULT NULL,
  `amt_pay` int(15) unsigned DEFAULT NULL,
  `payment_mode` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT 'COD',
  `payment_status` varchar(15) CHARACTER SET utf8 NOT NULL DEFAULT 'Due',
  `add_date` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `add_time` varchar(11) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_parent`
--

INSERT INTO `orders_parent` (`order_id`, `customer_mbl`, `customer_address`, `subtotal`, `delivery_fee`, `amt_pay`, `payment_mode`, `payment_status`, `add_date`, `add_time`) VALUES
(64, '9983751677', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan<br>Jaipur<br>302015<br>Near Tonk Roads<br>Ph. 8769017731', 200, 40, 240, 'COD', 'Due', '2016-09-05', '04:55:16pm'),
(65, '9983751677', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan<br>Jaipur<br>302015<br>Near Tonk Roads<br>Ph. 8769017731', 740, 0, 740, 'COD', 'Due', '2016-09-05', '04:56:48pm'),
(66, '9983751677', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan<br>Jaipur<br>302015<br>Near Tonk Roads<br>Ph. 8769017731', 540, 0, 540, 'COD', 'Due', '2016-09-05', '05:02:15pm'),
(67, '9983751677', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan<br>Jaipur<br>302015<br>Near Tonk Roads<br>Ph. 8769017731', 540, 0, 540, 'COD', 'Due', '2016-09-05', '05:05:47pm'),
(68, '9983751677', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan<br>Jaipur<br>302015<br>Near Tonk Roads<br>Ph. 8769017731', 200, 40, 240, 'COD', 'Due', '2016-09-05', '05:06:00pm'),
(69, '9983751677', '26, Adarsh Basti, Tonk Phatak, Jaipur, Rajasthan<br>Jaipur<br>302015<br>Near Tonk Roads<br>Ph. 8769017731', 1000, 0, 1000, 'COD', 'Due', '2016-09-05', '05:06:12pm');

-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE IF NOT EXISTS `pincode` (
  `s_no` int(50) unsigned NOT NULL,
  `Area` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `City` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pin` varchar(10) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pincode`
--

INSERT INTO `pincode` (`s_no`, `Area`, `City`, `pin`) VALUES
(1, 'Civil Lines', 'jaipur', '302006'),
(2, 'amba bari', 'jaipur', '302039'),
(3, 'JLN Marg', 'jaipur', '302018'),
(4, 'C Scheme', 'Jaipur', '302001'),
(7, 'Bajar Nagar', 'Jaipur', '302015'),
(9, 'Bani Park', 'Jaipur', '302016'),
(11, 'durgapura', 'jaipur', '302018'),
(13, 'Jhotwara ', 'Jaipur', '302012'),
(14, 'Jagatpura', 'Jaipur', '302017'),
(17, 'pratap nagar', 'jaipur', '302033'),
(19, 'sanganer', 'JAIPUR', '302029'),
(21, 'mansarovar', 'jaipur', '302020'),
(23, 'malviya nagar', 'jaipur', '302017'),
(26, 'Vaishali nagar', 'jaipur', '302021'),
(27, 'shyam nagar', 'jaipur', '302019'),
(30, 'Rajapark', 'jaipur', '302004'),
(31, 'chand pole bazar', 'jaipur', '302001'),
(34, 'Haldiyo ka rasta', 'jaipur', '302003'),
(36, 'indra bazar', 'jaipur', '302001'),
(38, 'kishan pole bazaar', 'jaipur', '302002'),
(40, 'muhana', 'jaipur', '302029'),
(42, 'sitapura industrial area', 'jaipur', '302022'),
(44, 'Johri bazar', 'jaipur', '302003'),
(46, 'Imli Phatak', 'jaipur', '302005'),
(47, 'gopalpura', 'jaipur', '303108'),
(48, 'gopalpura', 'jaipur', '303108'),
(50, 'JLN Marg ', 'jaipur', '302018');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `p_id` int(50) unsigned NOT NULL,
  `server` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `p_type` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `v_nv` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
  `p_img` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `p_name` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `p_desc` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `p_category` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `p_ori_cost` int(15) DEFAULT NULL,
  `p_cost` int(15) DEFAULT NULL,
  `cost_on` int(50) unsigned DEFAULT NULL,
  `measure_unit` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `p_discount` int(3) unsigned DEFAULT '0',
  `p_discount_type` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `add_date` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `add_time` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `server`, `p_type`, `v_nv`, `p_img`, `p_name`, `p_desc`, `p_category`, `p_ori_cost`, `p_cost`, `cost_on`, `measure_unit`, `p_discount`, `p_discount_type`, `add_date`, `add_time`) VALUES
(4, '9983751677', 'Service', 'Veg', 'upload\\2-Scoops_635629046897514090.jpg', 'Himanshu', 'BCa', 'Sweets', 500, 400, 1, 'Half Plate', 50, 'Percent off', '2016-06-18', '01:04:20pm'),
(5, '9983751677', 'One Time', 'Non Veg', 'upload\\Tandoori-dishes.jpg', 'Himanshussadasd sadsadas dsads', 'BCasafsafasfasf', 'Sweets', 500, 400, 1, 'Half Plate', 50, 'Percent off', '2016-06-18', '01:05:31pm'),
(6, '9983751677', 'Service', 'Non Veg', 'upload\\mainproduct_11.jpg', 'Himanshus', 'BCa', 'Dairy', 500, 400, 1, 'Half Plate', 50, 'Percent off', '2016-06-27', '09:54:57pm'),
(7, '9983751677', 'One Time', 'Non Veg', 'upload\\Untitled-2.png', 'Himanshus', 'BCa', 'Dairy', 500, 400, 1, 'Half Plate', 50, 'Percent off', '2016-06-27', '09:56:49pm'),
(8, '9983751677', 'One Time', 'Non Veg', 'upload\\Kaju-Katli-7.jpg', 'Himanshus', 'BCa', 'Dairy', 500, 400, 1, 'Half Plate', 50, 'Percent off', '2016-06-27', '09:57:10pm'),
(9, '9983751677', 'One Time', 'Non Veg', 'upload\\low-sugar-dunkin-choco-frosted.jpg', 'Himanshus', 'BCa', 'Drink', 500, 400, 1, 'piece', 50, 'Percent off', '2016-06-28', '05:35:20pm'),
(10, '9983751677', 'One Time', 'Non Veg', 'upload\\original.png', 'Himanshus', 'BCa', 'Dairy', 500, 400, 1, 'Half Plate', 50, 'Percent off', '2016-06-28', '05:36:36pm'),
(11, '9983751677', 'One Time', 'Non Veg', 'upload\\rs_560x415.jpg', 'Himanshu', 'BCa', 'Sweets', 500, 400, 1, 'Half Plate', 50, 'Money off', '2016-06-30', '02:15:11pm'),
(12, '9983751677', 'One Time', 'Veg', 'upload\\1421666878-649_a.jpg', 'One on One', 'sdfsdfsdfsd', 'Desert', 250, 200, 1, 'unit', NULL, NULL, '2016-07-08', '07:11:29pm'),
(13, '9983751677', 'One Time', 'Veg', 'upload\\him.png', 'dfg', 'dfg', 'Drink', 345, 345, 345, 'Half Plate', NULL, NULL, '2016-07-08', '07:20:02pm'),
(14, '9983751677', 'One Time', 'Non Veg', 'upload\\CPVG_owWIAAoHhB.png', 'aDSa', 'daDad', 'Dairy', 324, 234, 23, 'mg', NULL, NULL, '2016-07-11', '01:52:04pm'),
(15, '9983751677', 'One Time', 'Veg', 'upload\\asd.jpg', 'Veg Burger', 'J mata di', 'Drink', 150, 140, 1, 'pack', NULL, NULL, '2016-07-10', '03:08:17pm'),
(16, '9983751677', 'One Time', 'Non Veg', 'upload\\double-motton.png', 'mutton burger', 'mutton burger', 'Drink', 65, 65, 1, 'unit', 8, 'Percent off', '2016-07-14', '06:46:13pm'),
(17, '9414654054', 'One Time', 'Veg', 'upload\\anti raging.png', 'Anti Ragging', 'asdasdasdadasdsadasdasdasdasdasdadasdsadasdasdasdasdasdadasdsadasdasdasdasdasdadasdsadasdasdasdasdasdadasdsadasdasd', 'Sweets', 2222, 222, 1, 'Half Plate', NULL, NULL, '2016-08-12', '02:03:30pm');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE IF NOT EXISTS `register` (
  `owner_name` varchar(50) DEFAULT NULL,
  `mbl_no` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `res_add` varchar(200) DEFAULT NULL,
  `firm_name` varchar(50) DEFAULT NULL,
  `firm_reg_no` varchar(30) DEFAULT NULL,
  `office_no` varchar(15) DEFAULT NULL,
  `office_add` varchar(200) DEFAULT NULL,
  `reg_date` varchar(10) DEFAULT NULL,
  `reg_time` varchar(15) DEFAULT NULL,
  `proceed` char(1) NOT NULL DEFAULT 'Y',
  `proceed_date` varchar(10) DEFAULT NULL,
  `proceed_time` varchar(15) DEFAULT NULL,
  `store_status` varchar(3) NOT NULL DEFAULT '0',
  `acc_status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`owner_name`, `mbl_no`, `email`, `res_add`, `firm_name`, `firm_reg_no`, `office_no`, `office_add`, `reg_date`, `reg_time`, `proceed`, `proceed_date`, `proceed_time`, `store_status`, `acc_status`) VALUES
(NULL, '1234091241', '013himanshu@gmail.com', NULL, 'testing18', NULL, NULL, NULL, '2016-08-03', '07:26:12pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '1234098741', '013himanshu@gmail.com', NULL, 'testing18', NULL, NULL, NULL, '2016-08-03', '07:23:52pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '1234554321', '013himanshu@gmail.com', NULL, 'Check2', NULL, NULL, NULL, '2016-06-25', '01:29:22pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '1234567811', '013himanshu@gmail.com', NULL, 'rtesing16', NULL, NULL, NULL, '2016-08-03', '07:20:27pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '1234567812', '013himanshu@gmail.com', NULL, 'rtesing16', NULL, NULL, NULL, '2016-08-03', '07:19:02pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '1234567815', '013himanshu@gmail.com', NULL, 'rtesing16', NULL, NULL, NULL, '2016-08-03', '07:22:21pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '1357801357', '013himanshu@gmail.com', NULL, 'Dhaba', NULL, NULL, NULL, '2016-06-25', '01:27:29pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '4455445544', '013himanshu@gmail.com', NULL, 'testing105', NULL, NULL, NULL, '2016-08-03', '07:12:13pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '5555555555', '013himanshu@gmail.com', NULL, 'testing014', NULL, NULL, NULL, '2016-08-03', '06:51:56pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '6666666664', '013himanshu@gmail.com', NULL, 'testing103', NULL, NULL, NULL, '2016-08-03', '06:52:12pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '6666666666', '013himanshu@gmail.com', NULL, 'testing103', NULL, NULL, NULL, '2016-08-03', '06:51:12pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '7777777777', '013himanshu@gmail.com', NULL, 'testing102', NULL, NULL, NULL, '2016-08-03', '06:50:10pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '8769017730', '013himanshu@gmail.com', NULL, 'test3', NULL, NULL, NULL, '2016-06-23', '12:40:02pm', 'Y', NULL, NULL, '0', 'Active'),
(NULL, '8888888888', '013himanshu@gmail.com', NULL, 'Testing101', NULL, NULL, NULL, '2016-08-03', '06:48:14pm', 'Y', NULL, NULL, '0', 'Active'),
('Dinesh Kumar', '9414654054', '013himanshu@gmail.com', '26, Adarsh Basti, Tonk Phatak, Jaipur', 'Burger King', NULL, NULL, NULL, '2016-06-10', '06:02:36pm', 'Y', NULL, NULL, 'Set', 'Active'),
(NULL, '9694020006', '013himanshu@gmail.com', NULL, 'Anurag Di Firm', NULL, NULL, NULL, '2016-06-19', '08:53:33pm', 'Y', NULL, NULL, '0', 'Active'),
('Himanshu Kumawat', '9983751677', '013himanshu@gmail.com', '26, Adarsh Basti, Tonk Phatak, Jaipur', 'Pizza World', NULL, NULL, NULL, '2016-06-10', '03:28:24pm', 'Y', NULL, NULL, 'Set', 'Active'),
(NULL, '9988998899', '013himanshu@gmail.com', NULL, 'tesing105', NULL, NULL, NULL, '2016-08-03', '07:13:06pm', 'Y', NULL, NULL, '0', 'Active'),
('Himanshu', '9999999999', '013himanshu@gmail.com', '26, Adarsh Basti, Tonk Phatak, Jaipur', 'Mc Donalds', '151004010', '2592543', '26/156, Pratap Nagar, Jaipur', '2016-06-21', '01:36:01pm', 'Y', NULL, NULL, 'Set', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `s_docs`
--

CREATE TABLE IF NOT EXISTS `s_docs` (
  `mbl_no` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `add_proof` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fssai_no` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `fssai_upload` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `food_license_no` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `food_license_upload` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `pan_card_no` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pan_card_upload` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `bank_ac_no` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `cancel_check_upload` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `tin_no` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tin_no_upload` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `s_login`
--

CREATE TABLE IF NOT EXISTS `s_login` (
  `mbl_no` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `s_login`
--

INSERT INTO `s_login` (`mbl_no`, `password`) VALUES
('1234091241', 'PkioDbHK'),
('1234098741', 'rERtMWVJ'),
('1234554321', 'C9m3skSV'),
('1234567811', 'EmYIq5MK'),
('1234567812', 'n4pRziYF'),
('1234567815', '6NrEPRxe'),
('1357801357', 'I1ni8PVD'),
('4455445544', '9ntFywWU'),
('5555555555', 'tZ6XiRsN'),
('6666666664', 'qnR0gIpW'),
('6666666666', 'l5GUodNc'),
('7777777777', 'OqcW3S6k'),
('8769017730', 'u6qQ3PCB'),
('8888888888', 'FW8J0uAU'),
('9414654054', 'hello234'),
('9694020006', 'W6HBepYd'),
('9983751677', 'hello'),
('9988998899', 'aFeClJAq'),
('9999999999', 'AguE3YHv');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`), ADD KEY `customer` (`customer`), ADD KEY `seller` (`seller`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `c_info`
--
ALTER TABLE `c_info`
  ADD PRIMARY KEY (`mbl_no`);

--
-- Indexes for table `c_login`
--
ALTER TABLE `c_login`
  ADD UNIQUE KEY `mbl_no` (`mbl_no`);

--
-- Indexes for table `orders_child`
--
ALTER TABLE `orders_child`
  ADD PRIMARY KEY (`id`), ADD KEY `seller` (`seller`), ADD KEY `order_parent_id` (`order_parent_id`), ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders_parent`
--
ALTER TABLE `orders_parent`
  ADD PRIMARY KEY (`order_id`), ADD KEY `customer_mbl` (`customer_mbl`);

--
-- Indexes for table `pincode`
--
ALTER TABLE `pincode`
  ADD PRIMARY KEY (`s_no`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`), ADD KEY `server` (`server`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`mbl_no`);

--
-- Indexes for table `s_docs`
--
ALTER TABLE `s_docs`
  ADD UNIQUE KEY `mbl_no` (`mbl_no`);

--
-- Indexes for table `s_login`
--
ALTER TABLE `s_login`
  ADD UNIQUE KEY `mbl_no` (`mbl_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(50) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `orders_child`
--
ALTER TABLE `orders_child`
  MODIFY `id` int(50) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `orders_parent`
--
ALTER TABLE `orders_parent`
  MODIFY `order_id` int(50) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `pincode`
--
ALTER TABLE `pincode`
  MODIFY `s_no` int(50) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(50) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `c_info` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`seller`) REFERENCES `register` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `c_login`
--
ALTER TABLE `c_login`
ADD CONSTRAINT `c_login_ibfk_1` FOREIGN KEY (`mbl_no`) REFERENCES `c_info` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_child`
--
ALTER TABLE `orders_child`
ADD CONSTRAINT `orders_child_ibfk_1` FOREIGN KEY (`seller`) REFERENCES `register` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_child_ibfk_2` FOREIGN KEY (`order_parent_id`) REFERENCES `orders_parent` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_child_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_parent`
--
ALTER TABLE `orders_parent`
ADD CONSTRAINT `orders_parent_ibfk_1` FOREIGN KEY (`customer_mbl`) REFERENCES `c_info` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`server`) REFERENCES `register` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `s_docs`
--
ALTER TABLE `s_docs`
ADD CONSTRAINT `s_docs_ibfk_1` FOREIGN KEY (`mbl_no`) REFERENCES `register` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `s_login`
--
ALTER TABLE `s_login`
ADD CONSTRAINT `s_login_ibfk_1` FOREIGN KEY (`mbl_no`) REFERENCES `register` (`mbl_no`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
