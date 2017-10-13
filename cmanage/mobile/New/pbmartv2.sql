-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2014 at 02:44 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pbmartv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `gcm_users`
--

CREATE TABLE IF NOT EXISTS `gcm_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gcm_regid` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `gcm_users`
--

INSERT INTO `gcm_users` (`id`, `gcm_regid`, `name`, `email`, `created_at`) VALUES
(2, 'APA91bHdLucaIx056WN7XZvGBpetjdzQWFM_s_3Mva1gd7a1NqwMwCF3gD47S8HXawhORBL7xNyhU2DtcCxPsUXLRnmU9VKwJ7GRXo8EnOFKL8LR7yCSb4G01fViEQ0_cXmFigJleKPR0n-9G8QonEHPTCmEKduvWIeP4mUWuK2WRR7hGOmxsZc', 'voon', 'maxVoongT@gmail.com', '2014-11-12 12:01:15'),
(7, 'APA91bHdLucaIx056WN7XZvGBpetjdzQWFM_s_3Mva1gd7a1NqwMwCF3gD47S8HXawhORBL7xNyhU2DtcCxPsUXLRnmU9VKwJ7GRXo8EnOFKL8LR7yCSb4G01fViEQ0_cXmFigJleKPR0n-9G8QonEHPTCmEKduvWIeP4mUWuK2WRR7hGOmxsZc', 'voon', 'maxVoongT@gmail.com', '2014-11-20 08:02:42'),
(14, 'APA91bFDTN5ScUQrr0rJi4DjJL8XZMmeshiJmfzwxqX-340kmETpgtLTWBQu83By9n9hSNvCR0kjKpAq2CaHQQ2cYEjCZnHDWmmrAQsRZC_bMWBup94UXjuKEP2XUj-DiyaJ71-ca-koN_KJbW39EFqS3yoZWZKN0t4_8GureL4EYiGMSAT07I4', 'Hashan', 'hashan000@gmail.com', '2014-11-21 07:50:24'),
(15, 'APA91bFFsJv4N_JgJbWbLveCfFYziqPvW2Q7HtCqb192OJmcl3zulzTiQdzM84yNlOyQBRzudIeGaoqiaVQXzvSiQC3j3RkOTQY9bCGgeMvZh5T1x3pmyUZdvjEhuFUAw1lie_P6xGA7bLSWXngzS2vlsPfO4ZeElNjOW_v5YzPqmPPx4pkFnMY', 'hash ', 'hashan000@gmail.com', '2014-11-21 07:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `iosuser`
--

CREATE TABLE IF NOT EXISTS `iosuser` (
  `id` int(11) NOT NULL,
  `deviceID` text,
  `type` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iosuser`
--

INSERT INTO `iosuser` (`id`, `deviceID`, `type`) VALUES
(3, 'e5c24965ab8a5cfb2909bf5349323dac1819896e05e275f86230e51640fccff0', ''),
(5, 'e5c24965ab8a5cfb2909bf5349323dac1819896e05e275f86230e51640fccff0', '');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_admin`
--

CREATE TABLE IF NOT EXISTS `pbmart_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pbmart_admin`
--

INSERT INTO `pbmart_admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', ''),
(2, 'nightbaron', '525de2d8063beb195c8223d037b6446d', '');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_admin_cart`
--

CREATE TABLE IF NOT EXISTS `pbmart_admin_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_product_id` int(11) NOT NULL,
  `cart_product_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `cart_product_price` int(11) NOT NULL,
  `cart_product_sale` int(11) NOT NULL,
  `cart_product_amount` int(11) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_banner`
--

CREATE TABLE IF NOT EXISTS `pbmart_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_url` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `banner_path` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `banner_alt` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pbmart_banner`
--

INSERT INTO `pbmart_banner` (`banner_id`, `banner_url`, `banner_path`, `banner_alt`) VALUES
(1, '#', 'css/images/slide1.jpg', ''),
(2, '#', 'css/images/slide2.jpg', ''),
(3, '#', 'css/images/slide3.jpg', ''),
(4, '#', 'css/images/slide4.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_billing_address`
--

CREATE TABLE IF NOT EXISTS `pbmart_billing_address` (
  `billing_id` int(11) NOT NULL,
  `billing_house_no` int(11) NOT NULL,
  `billing_street_name` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `billing_city` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `billing_state` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `billing_postcode` int(11) NOT NULL,
  `billing_country` varchar(20) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`billing_id`),
  UNIQUE KEY `billing_id` (`billing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `pbmart_billing_address`
--

INSERT INTO `pbmart_billing_address` (`billing_id`, `billing_house_no`, `billing_street_name`, `billing_city`, `billing_state`, `billing_postcode`, `billing_country`) VALUES
(21, 11212, 'Kota Sentosa', 'Kuching', 'Sabah', 96654, 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_category`
--

CREATE TABLE IF NOT EXISTS `pbmart_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `category_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=188 ;

--
-- Dumping data for table `pbmart_category`
--

INSERT INTO `pbmart_category` (`category_id`, `category_name`, `category_description`) VALUES
(4, 'Gas', ''),
(5, 'Soft drink', 'Carbohydrate drink'),
(6, 'Cloth', ''),
(8, 'Glove', ''),
(9, 'Furniture', ''),
(10, 'Cooking', ''),
(11, 'Stationary', ''),
(12, 'Toys', ''),
(13, 'Can food', 'Canned food'),
(15, 'Electronics', ''),
(16, 'Car accessories', ''),
(17, 'Technology', ''),
(18, '12', '12'),
(19, '12', '12'),
(20, '12', '12'),
(21, '12', '12'),
(22, '12', '12'),
(23, '121212', '12'),
(24, '12', '12'),
(25, '12', ''),
(26, '12', ''),
(27, '12', ''),
(28, '12', ''),
(29, '12', ''),
(30, '12', ''),
(31, '12', ''),
(32, '12', ''),
(33, '12', ''),
(34, '12', ''),
(35, '12', ''),
(36, '12', ''),
(37, '12', ''),
(38, '12', ''),
(40, '12', ''),
(41, '12', ''),
(42, '12', ''),
(43, '12', ''),
(44, '12', ''),
(45, '12', ''),
(46, '12', ''),
(47, '12', ''),
(48, '12', ''),
(49, '12', ''),
(50, '12', ''),
(51, '12', ''),
(52, '12', ''),
(53, '12', ''),
(54, '12', ''),
(55, '12', ''),
(56, '12', ''),
(57, '12', ''),
(58, '12', ''),
(59, '12', ''),
(60, '12', ''),
(61, '12', ''),
(62, '12', ''),
(63, '12', ''),
(64, '12', ''),
(65, '12', ''),
(66, '12', ''),
(67, '12', ''),
(68, '12', ''),
(69, '12', ''),
(70, '12', ''),
(71, '12', ''),
(72, '12', ''),
(73, '12', ''),
(74, '12', ''),
(75, '12', ''),
(76, '12', ''),
(77, '12', ''),
(78, '12', ''),
(79, '12', ''),
(80, '12', ''),
(81, '12', ''),
(82, '12', ''),
(83, '12', ''),
(84, '12', ''),
(85, '12', ''),
(86, '12', ''),
(87, '12', ''),
(88, '12', ''),
(89, '12', ''),
(90, '12', ''),
(91, '12', ''),
(92, '12', ''),
(93, '12', ''),
(94, '12', ''),
(95, '12', ''),
(96, '12', ''),
(97, '12', ''),
(98, '12', ''),
(99, '12', ''),
(100, '12', ''),
(101, '12', ''),
(102, '12', ''),
(103, '12', ''),
(104, '12', ''),
(105, '12', ''),
(106, '12', ''),
(107, '12', ''),
(108, '12', ''),
(109, '12', ''),
(110, '12', ''),
(111, '12', ''),
(112, '12', ''),
(113, '12', ''),
(114, '12', ''),
(115, '12', ''),
(116, '12', ''),
(117, '12', ''),
(118, '12', ''),
(119, '12', ''),
(120, '12', ''),
(121, '12', ''),
(122, '12', ''),
(123, '12', ''),
(124, '12', ''),
(125, '12', ''),
(126, '12', ''),
(127, '12', ''),
(128, '12', ''),
(129, '12', ''),
(130, '12', ''),
(131, '12', ''),
(132, '12', ''),
(133, '12', ''),
(134, '12', ''),
(135, '12', ''),
(136, '12', ''),
(137, '12', ''),
(138, '12', ''),
(139, '12', ''),
(140, '12', ''),
(141, '12', ''),
(142, '12', ''),
(143, '12', ''),
(144, '12', ''),
(145, '12', ''),
(146, '12', ''),
(147, '12', ''),
(148, '12', ''),
(149, '12', ''),
(150, '12', ''),
(151, '12', ''),
(152, '12', ''),
(153, '12', ''),
(154, '12', ''),
(155, '12', ''),
(156, '12', ''),
(157, '12', ''),
(158, '12', ''),
(159, '12', ''),
(160, '12', ''),
(161, '12', ''),
(162, '12', ''),
(163, '12', ''),
(164, '12', ''),
(165, '12', ''),
(166, '12', ''),
(167, '12', ''),
(168, '12', ''),
(169, '12', ''),
(170, '12', ''),
(171, '12', ''),
(172, '12', ''),
(173, '12', ''),
(174, '12', ''),
(175, '12', ''),
(176, '12', ''),
(177, '12', ''),
(178, '12', ''),
(179, '12', ''),
(180, '12', ''),
(181, '12', ''),
(182, '12', ''),
(183, '12', ''),
(184, '12', ''),
(185, '12', ''),
(186, '12', ''),
(187, '12', '');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_contact_banner`
--

CREATE TABLE IF NOT EXISTS `pbmart_contact_banner` (
  `pbmart_id` int(11) NOT NULL AUTO_INCREMENT,
  `pbmart_banner_path` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_banner_alt` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`pbmart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pbmart_contact_banner`
--

INSERT INTO `pbmart_contact_banner` (`pbmart_id`, `pbmart_banner_path`, `pbmart_banner_alt`) VALUES
(1, 'css/images/contactimage.jpg', 'contact image');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_contact_info`
--

CREATE TABLE IF NOT EXISTS `pbmart_contact_info` (
  `pbmart_id` int(11) NOT NULL AUTO_INCREMENT,
  `pbmart_office_no` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_street_no` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_street_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_city` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_state` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_country` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_telephone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_operate_hour` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pbmart_operate_daily` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`pbmart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pbmart_contact_info`
--

INSERT INTO `pbmart_contact_info` (`pbmart_id`, `pbmart_office_no`, `pbmart_street_no`, `pbmart_street_name`, `pbmart_city`, `pbmart_state`, `pbmart_country`, `pbmart_telephone`, `pbmart_operate_hour`, `pbmart_operate_daily`) VALUES
(1, 'No 15', 'Lot 628', 'Jalan Ketitir', 'Batu Kawa', 'Kuching', 'Malaysia', '082-688968', '8.00am - 7.00pm', 'Everyday');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_member`
--

CREATE TABLE IF NOT EXISTS `pbmart_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_first_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_last_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_email` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_telephone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_mobile` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_house_no` int(11) NOT NULL,
  `member_street_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_postcode` int(11) NOT NULL,
  `member_city` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_state` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_country` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_password` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `member_point` int(11) NOT NULL,
  `member_regis_date` date NOT NULL,
  `member_status` int(11) NOT NULL,
  `member_vcode` varchar(50) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `pbmart_member`
--

INSERT INTO `pbmart_member` (`member_id`, `member_first_name`, `member_last_name`, `member_email`, `member_telephone`, `member_mobile`, `member_house_no`, `member_street_name`, `member_postcode`, `member_city`, `member_state`, `member_country`, `member_password`, `member_point`, `member_regis_date`, `member_status`, `member_vcode`) VALUES
(21, 'Maxx', 'Voong', 'hau_sky@yahoo.com', '082369913', '0168590103', 89, '7 mile', 93250, 'Kuching', 'Sarawak', 'Indonesia', '+fGGkTguJBbqV4lsNlqxd294ZZcywzRPmstIS2uLgH4=', 547, '2014-10-21', 1, '3Qfo85dLPLM8spZU2eUGlNpc7n1WR9xS35tlFAnSxEc9udrIE'),
(23, 'Yuki', 'Hui Chung', 'hausky2010@hotmail.com', '011-1988143', '016-8989109', 89, 'Mei Lee Villa', 93250, 'Kuching', 'Sabah', 'Malaysia', '+fGGkTguJBbqV4lsNlqxd294ZZcywzRPmstIS2uLgH4=', 0, '2014-11-06', 1, 'A5hgjZYevypPCOjlYP16Q8qDn8zU9VdkPrWL6Hr89MNP2CG5j');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_order`
--

CREATE TABLE IF NOT EXISTS `pbmart_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_amount` float NOT NULL,
  `order_date` date NOT NULL,
  `order_delivery` date NOT NULL,
  `order_time` int(11) NOT NULL,
  `order_customer_id` int(11) NOT NULL,
  `order_customer_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_customer_telephone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_customer_mobile` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_customer_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_payment_type` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_payment_status` int(11) NOT NULL,
  `order_status` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `pbmart_order`
--

INSERT INTO `pbmart_order` (`order_id`, `order_number`, `order_amount`, `order_date`, `order_delivery`, `order_time`, `order_customer_id`, `order_customer_name`, `order_customer_telephone`, `order_customer_mobile`, `order_customer_address`, `order_payment_type`, `order_payment_status`, `order_status`) VALUES
(41, 'O03112014', 14997.9, '0000-00-00', '0000-00-00', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 2),
(42, 'O0311201441', 440, '0000-00-00', '2014-11-11', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 0),
(43, 'O0511201442', 146.254, '0000-00-00', '0000-00-00', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 0, 3),
(44, 'O0511201443', 57.1271, '0000-00-00', '2014-11-12', 3, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 0),
(45, 'O0511201444', 2279.99, '0000-00-00', '0000-00-00', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 0, 2),
(46, 'O0511201445', 33, '0000-00-00', '0000-00-00', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 1, 1),
(47, 'O0511201446', 28.1271, '0000-00-00', '2014-11-13', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 0, 0),
(48, 'O0511201447', 28.1271, '0000-00-00', '2014-11-15', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 0, 0),
(49, 'O0511201448', 2279.99, '0000-00-00', '2014-11-14', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 0, 0),
(50, 'O0511201449', 2279.99, '0000-00-00', '2014-11-16', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Credit Card', 0, 0),
(51, 'O0511201450', 2279.99, '0000-00-00', '2014-11-17', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Bank Card', 0, 0),
(52, 'O0511201451', 2279.99, '0000-00-00', '2014-11-19', 3, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 0),
(53, 'O0511201452', 30, '0000-00-00', '0000-00-00', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 2),
(54, 'O0511201453', 33, '0000-00-00', '0000-00-00', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 2),
(55, 'O0511201454', 1371.3, '0000-00-00', '0000-00-00', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 2),
(56, 'O0611201455', 30, '0000-00-00', '0000-00-00', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 2),
(57, 'O2111201456', 30, '0000-00-00', '0000-00-00', 1, 0, 'Cash', '', '', '', 'Cash', 1, 1),
(58, 'O2111201457', 30, '0000-00-00', '0000-00-00', 3, 0, 'Cash', '', '', '', 'Cash', 1, 1),
(59, 'O2111201458', 30, '2014-11-21', '2014-11-21', 2, 0, 'Cash', '', '', '', 'Cash', 1, 1),
(60, 'O2111201459', 1431.02, '2014-11-21', '2014-11-22', 1, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 0),
(61, 'O2211201460', 248.1, '2014-11-22', '2014-11-23', 2, 23, 'Yuki Hui Chung', '011-1988143', '016-8989109', 'No. 89, Mei Lee Villa, 93250 Kuching, Sabah, Malaysia', 'Cash', 0, 0),
(62, 'O2211201461', 32, '2014-11-22', '2014-11-23', 2, 21, 'Maxx Voong', '082369913', '0168590103', 'No. 89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Cash', 0, 0),
(63, 'O2211201462', 30, '2014-11-22', '2014-11-23', 2, 23, 'Yuki Hui Chung', '011-1988143', '016-8989109', 'No. 89, Mei Lee Villa, 93250 Kuching, Sabah, Malaysia', 'Cash', 0, 0),
(64, 'O2211201463', 315, '2014-11-22', '2014-11-23', 2, 23, 'Yuki Hui Chung', '011-1988143', '016-8989109', 'No. 89, Mei Lee Villa, 93250 Kuching, Sabah, Malaysia', 'Cash', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_order_list`
--

CREATE TABLE IF NOT EXISTS `pbmart_order_list` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_product_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `order_product_price` int(11) NOT NULL,
  `order_product_sale` int(11) NOT NULL,
  `order_product_amount` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `pbmart_order_list`
--

INSERT INTO `pbmart_order_list` (`order_id`, `order_number`, `order_product_name`, `order_product_price`, `order_product_sale`, `order_product_amount`) VALUES
(47, 'O03112014', 'iphone 6', 2400, 5, 2),
(48, 'O03112014', 'ipad Mini', 1399, 2, 1),
(49, 'O03112014', 'iphone 6 Plus', 4399, 0, 2),
(50, 'O0311201441', 'Gas Cooker', 120, 0, 1),
(51, 'O0311201441', 'LPG GAS Filter', 60, 0, 1),
(52, 'O0311201441', 'MYGAZ LPG 14KG NEW', 30, 11, 1),
(53, 'O0311201441', 'INSE GAS COOKER', 230, 0, 1),
(54, 'O0511201442', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(55, 'O0511201442', 'MYGAZ LPG 50KG NEW', 32, 13, 2),
(56, 'O0511201442', 'LPG GAS Filter', 60, 0, 1),
(57, 'O0511201443', 'MYGAZ LPG 50KG NEW', 32, 13, 1),
(58, 'O0511201443', 'MYGAZ LPG 14KG NEW', 29, 0, 1),
(59, 'O0511201444', 'iphone 6', 2400, 5, 1),
(60, 'O0511201445', 'MYGAZ LPG 50KG NEW', 33, 0, 1),
(61, 'O0511201446', 'MYGAZ LPG 50KG NEW', 32, 13, 1),
(62, 'O0511201447', 'MYGAZ LPG 50KG NEW', 32, 13, 1),
(63, 'O0511201448', 'iphone 6', 2400, 5, 1),
(64, 'O0511201449', 'iphone 6', 2400, 5, 1),
(65, 'O0511201450', 'iphone 6', 2400, 5, 1),
(66, 'O0511201451', 'iphone 6', 2400, 5, 1),
(67, 'O0511201452', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(68, 'O0511201453', 'MYGAZ LPG 50KG NEW', 33, 0, 1),
(69, 'O0511201454', 'iPad mini S', 1399, 2, 1),
(70, 'O0611201455', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(71, 'O2111201456', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(72, 'O2111201457', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(73, 'O2111201458', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(74, 'O2111201459', 'iPad mini S', 1399, 2, 1),
(75, 'O2111201459', 'LPG GAS Filter', 60, 0, 1),
(76, 'O2211201460', 'LPG GAS Filter', 60, 20, 5),
(77, 'O2211201460', '100 Plus', 3, 10, 3),
(78, 'O2211201461', 'MYGAZ LPG 50KG NEW', 32, 0, 1),
(79, 'O2211201462', 'MYGAZ LPG 14KG NEW', 30, 0, 1),
(80, 'O2211201463', 'MYGAZ LPG 14KG NEW', 30, 0, 3),
(81, 'O2211201463', 'MYGAZ LPG 80KG NEW', 30, 0, 3),
(82, 'O2211201463', 'Coca Colar', 3, 0, 5),
(83, 'O2211201463', 'Gas Cooker', 120, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_point`
--

CREATE TABLE IF NOT EXISTS `pbmart_point` (
  `point_id` int(11) NOT NULL AUTO_INCREMENT,
  `point_rate` int(11) NOT NULL,
  PRIMARY KEY (`point_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pbmart_point`
--

INSERT INTO `pbmart_point` (`point_id`, `point_rate`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_product`
--

CREATE TABLE IF NOT EXISTS `pbmart_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `product_category` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `product_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `product_model` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `product_price` double(10,2) NOT NULL,
  `product_sale` int(11) NOT NULL,
  `product_sale1` int(11) NOT NULL,
  `product_sale_percentage1` int(11) NOT NULL,
  `product_sale2` int(11) NOT NULL,
  `product_sale_percentage3` int(11) NOT NULL,
  `product_sale3` int(11) NOT NULL,
  `product_sale_percentage2` int(11) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_image` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `product_alt` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `product_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `pbmart_product`
--

INSERT INTO `pbmart_product` (`product_id`, `product_category_id`, `product_category`, `product_name`, `product_model`, `product_price`, `product_sale`, `product_sale1`, `product_sale_percentage1`, `product_sale2`, `product_sale_percentage3`, `product_sale3`, `product_sale_percentage2`, `product_stock`, `product_image`, `product_alt`, `product_description`) VALUES
(7, 4, 'Gas', 'MYGAZ LPG 14KG NEW', 'MYGAZ', 30.99, 0, 3, 2, 5, 8, 8, 5, 1, 'photo/big1.jpg', '', 'THE 14KG NEW\r\nGAS CYLINDER'),
(8, 4, 'Gas', 'MYGAZ LPG 50KG NEW', 'MYGAZ', 33.00, 0, 0, 0, 0, 0, 0, 0, 18, 'photo//big2.jpg', '', 'THE 50KG NEW \r\nGAS CYLINDER'),
(11, 4, 'GAS', 'MYGAZ LPG 50KG NEW', 'MYGAZ', 32.33, 0, 0, 13, 0, 0, 0, 0, 4, 'photo/big2.jpg', '', 'THE 50KG NEW\r\nGAS CYLINDER'),
(12, 4, 'GAS', 'MYGAZ LPG 14KG NEW', 'MYGAZ', 30.00, 0, 0, 11, 0, 0, 0, 0, 5, 'photo/big1.jpg', '', 'THE 14KG NEW\r\nGAS CYLINDER'),
(13, 4, 'GAS', 'MYGAZ LPG 50KG NEW', 'MYGAZ', 32.00, 0, 0, 0, 0, 0, 0, 0, 10, 'photo/big2.jpg', '', 'THE 50KG NEW\r\nGAS CYLINDER'),
(14, 4, 'GAS', 'MYGAZ LPG 14KG NEW', 'MYGAZ', 29.00, 0, 0, 0, 0, 0, 0, 0, 9, 'photo/big1.jpg', '', 'THE 14KG NEW GAS CYLINDER'),
(35, 17, 'Technology', 'iPad mini S', 'Apple', 1399.29, 0, 0, 2, 0, 0, 0, 0, 3, 'photo/ipad_mini2.png', 'ipad Mini 16GB', '16GB\r\nRetina Screen'),
(36, 17, 'Technology', 'iphone 6', 'Apple', 2399.99, 0, 0, 5, 0, 0, 0, 0, 1, 'photo/iphone6.jpg', 'New iphone 6', '16GB\r\nIOS 8\r\nRETINA SCREEN'),
(37, 17, 'Technology', 'iphone 6 Plus', 'Apple', 4399.33, 0, 0, 0, 0, 0, 0, 0, 2, 'photo/iphone6_plus2.jpg', 'New iphone 6 Plus', '32GB IOS 8 Retina Screen'),
(38, 4, 'GAS', 'MYGAZ LPG 80KG NEW', 'MYGAZ', 30.00, 0, 0, 4, 0, 0, 0, 0, 47, 'photo/big1.jpg', '', 'THE 80KG NEW\r\nGAS CYLINDER'),
(39, 4, 'GAS', 'MYGAZ LPG 80KG NEW', 'MYGAZ', 30.99, 0, 0, 0, 0, 0, 0, 0, 49, 'photo/big1.jpg', '', 'THE 80KG NEW\r\nGAS CYLINDER'),
(43, 4, 'Gas', 'LPG GAS Filter', '', 60.00, 0, 3, 10, 5, 30, 8, 20, 92, 'photo/5457205d03df5.jpg', '', 'New* LPG Product in Market!'),
(44, 4, 'Gas', 'Gas Cooker', '', 120.00, 0, 0, 0, 0, 0, 0, 0, 3, 'photo/545721b9379c2.jpg', '', 'Butterfly Gas Cooker'),
(45, 4, 'Gas', 'INSE GAS COOKER', '', 230.00, 0, 0, 0, 0, 0, 0, 0, 9, 'photo/5457221d637d3.jpg', '', 'More Security of Gas Cooker'),
(46, 5, 'Soft drink', 'Coca Colar', '', 3.00, 0, 0, 1, 0, 0, 0, 0, 15, 'photo/545e79649402b.jpg', '', 'Test'),
(47, 5, 'Soft drink', '100 Plus', '', 3.00, 0, 3, 10, 5, 30, 8, 20, 97, 'photo/545e79a39ac00.jpg', '', 'Test'),
(48, 5, 'Soft drink', 'Sprite', '', 3.00, 0, 0, 1, 0, 0, 0, 0, 20, 'photo/545e79c23bf67.png', '', 'Test'),
(49, 5, 'Soft drink', 'F&N', '', 3.00, 0, 0, 1, 0, 0, 0, 0, 100, 'photo/545e7a506197a.jpg', '', 'Test'),
(50, 5, 'Soft drink', 'Coca Colar Glass', '', 4.00, 0, 0, 2, 0, 0, 0, 0, 100, 'photo/545e7a7e38f90.jpg', '', 'Test'),
(51, 5, 'Soft drink', '100 Plus Bottle', '', 4.00, 0, 0, 1, 0, 0, 0, 0, 100, 'photo/545e7ab431e9f.jpg', '', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_redeem`
--

CREATE TABLE IF NOT EXISTS `pbmart_redeem` (
  `redeem_id` int(11) NOT NULL AUTO_INCREMENT,
  `redeem_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `redeem_point` int(11) NOT NULL,
  `redeem_stock` int(11) NOT NULL,
  `redeem_image` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `redeem_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`redeem_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pbmart_redeem`
--

INSERT INTO `pbmart_redeem` (`redeem_id`, `redeem_name`, `redeem_point`, `redeem_stock`, `redeem_image`, `redeem_description`) VALUES
(2, 'Sony Tv', 80000, 19, 'photo/543dee8a09cff.jpg', 'BRAVIA HD TV\r\nLCD SCREEN\r\nHIGH RESOLUTION'),
(4, 'Test', 100, 0, 'photo/54569f51a5128.png', 'New Pepsi Flavour\r\n120ml\r\nGood to drink!'),
(5, 'Pepsi', 100, 100, 'photo/54569db7263f0.jpg', 'New Products\r\n100 Litle\r\nNice Drink'),
(6, 'Test', 100, 0, 'photo/54569f51a5128.png', 'New Pepsi Flavour\r\n120ml\r\nGood to drink!'),
(7, 'Pepsi', 100, 100, 'photo/54569db7263f0.jpg', 'New Products\r\n100 Litle\r\nNice Drink');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_redemption_list`
--

CREATE TABLE IF NOT EXISTS `pbmart_redemption_list` (
  `redemption_id` int(11) NOT NULL AUTO_INCREMENT,
  `redemption_member_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `redemption_member_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `redemption_item` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `redemption_image` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `redemption_status` int(11) NOT NULL,
  PRIMARY KEY (`redemption_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pbmart_redemption_list`
--

INSERT INTO `pbmart_redemption_list` (`redemption_id`, `redemption_member_name`, `redemption_member_address`, `redemption_item`, `redemption_image`, `redemption_status`) VALUES
(1, 'Chiu Alan', '14, Jalan Satok, 93150 Kuching, Sarawak, Malaysia', 'Sprite', 'photo/5444bdb413f28.png', 1),
(3, 'Chiu Alan', '14, Jalan Satok, 93150 Kuching, Sarawak, Malaysia', 'Sprite', 'photo/5444bdb413f28.png', 1),
(4, 'Chiu Alan', '14, Jalan Satok, 93150 Kuching, Sarawak, Malaysia', 'Sprite', 'photo/5444bdb413f28.png', 1),
(5, 'Chiu Alan', '14, Jalan Satok, 93150 Kuching, Sarawak, Malaysia', 'Sony Tv', 'photo/543dee8a09cff.jpg', 1),
(7, 'Chiu Alan', '14, Jalan Satok, 93150 Kuching, Sarawak, Malaysia', 'Sprite', 'photo/5444bdb413f28.png', 0),
(8, 'Chiu Alan', '14, Jalan Satok, 93150 Kuching, Sarawak, Malaysia', 'Sprite', 'photo/5444bdb413f28.png', 0),
(9, 'Maxx Voong', '89, 7 mile, 93250 Kuching, Sarawak, Indonesia', 'Test', 'photo/54569f51a5128.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_service_city`
--

CREATE TABLE IF NOT EXISTS `pbmart_service_city` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_city` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pbmart_service_city`
--

INSERT INTO `pbmart_service_city` (`service_id`, `service_city`) VALUES
(3, 'Kuching'),
(4, 'Kota Samarahan'),
(5, 'Lundu'),
(6, 'Bau'),
(7, 'Batu Kawa'),
(8, 'Tabuan Jaya'),
(9, 'Simpang Tiga'),
(10, 'Batu Tujuh'),
(11, 'MJC');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_service_country`
--

CREATE TABLE IF NOT EXISTS `pbmart_service_country` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_country` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pbmart_service_country`
--

INSERT INTO `pbmart_service_country` (`service_id`, `service_country`) VALUES
(1, 'Malaysia'),
(2, 'Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `pbmart_service_state`
--

CREATE TABLE IF NOT EXISTS `pbmart_service_state` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_state` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pbmart_service_state`
--

INSERT INTO `pbmart_service_state` (`service_id`, `service_state`) VALUES
(1, 'Sarawak'),
(2, 'Sabah');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
