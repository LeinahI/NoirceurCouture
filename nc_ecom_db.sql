-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 08:07 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nc_ecom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `address_user_ID` int(11) DEFAULT NULL,
  `address_fullName` varchar(254) DEFAULT NULL,
  `address_email` varchar(254) DEFAULT NULL,
  `address_phone` varchar(11) DEFAULT NULL,
  `address_postal_code` varchar(254) DEFAULT NULL,
  `address_fullAddress` mediumtext DEFAULT NULL,
  `address_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `address_user_ID`, `address_fullName`, `address_email`, `address_phone`, `address_postal_code`, `address_fullAddress`, `address_createdAt`) VALUES
(1, 14, 'Joshua Vidallon', 'joshua123@gmail.com', '09865475632', '4123', 'Sitio Kural Mangas 2 Alfonso, Tagaytay, 4123 Cavite', '2023-06-23 15:44:42'),
(4, 2, 'Ana Bien Beatriz Salazar', 'ana@gmail.com', '09865798565', '4120', 'Tolentino, E Rd, Tagaytay, Cavite', '2023-06-23 16:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_ID` int(8) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_slug` varchar(300) NOT NULL,
  `cart_CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_ID`, `product_id`, `product_qty`, `product_slug`, `cart_CreatedAt`) VALUES
(113, 14, 42, 1, 'linenrayoneasyclothindianblocksquareprintjacketwithdoubletailoredleftfront', '2023-06-23 15:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(254) NOT NULL,
  `category_slug` varchar(300) NOT NULL,
  `category_description` varchar(300) NOT NULL,
  `category_status` tinyint(1) NOT NULL DEFAULT 0,
  `category_popular` tinyint(1) NOT NULL DEFAULT 0,
  `category_image` varchar(300) NOT NULL,
  `category_meta_title` varchar(254) NOT NULL,
  `category_meta_description` mediumtext NOT NULL,
  `category_meta_keywords` mediumtext NOT NULL,
  `category_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `category_description`, `category_status`, `category_popular`, `category_image`, `category_meta_title`, `category_meta_description`, `category_meta_keywords`, `category_createdAt`) VALUES
(25, 'S\'YTE', 'syte', 'S\'YTE', 0, 1, 'syte_logo.jpg', 'S\'YTE', 'S\'YTE', 'S\'YTE', '2023-06-15 07:50:43'),
(26, 'GroundY', 'groundy', 'GroundY', 0, 1, 'GroundY.jpg', 'GroundY', 'GroundY', 'GroundY', '2023-06-15 07:52:48'),
(27, 'Demonia Cult', 'demoniacult', 'Demonia Cult', 0, 1, 'demonia_cult.png', 'Demonia Cult', 'Demonia Cult', 'Demonia Cult', '2023-06-15 07:53:23'),
(29, 'Anthony Wang', 'anthonywang', 'Anthony Wang', 0, 1, 'anthony_wang_logo.jpg', 'Anthony Wang', 'Anthony Wang', 'Anthony Wang', '2023-06-15 08:11:54'),
(34, 'TRIPP NYC', 'trippnyc', 'TRIPP NYC', 0, 1, 'tripp.jpg', 'TRIPP NYC', 'TRIPP NYC', 'TRIPP NYC', '2023-06-16 01:33:47'),
(41, 'DarkSplash', 'darksplash', 'DarkSplash', 0, 1, '1686882734.jpg', 'DarkSplash', 'DarkSplash', 'DarkSplash', '2023-06-16 02:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likes_id` int(11) NOT NULL,
  `user_ID` int(8) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_slug` varchar(300) NOT NULL,
  `likes_CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likes_id`, `user_ID`, `product_id`, `product_slug`, `likes_CreatedAt`) VALUES
(10, 2, 33, 'bratty304', '2023-06-23 12:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `orders_tracking_no` varchar(255) NOT NULL,
  `orders_user_ID` int(11) NOT NULL,
  `orders_full_name` varchar(254) NOT NULL,
  `orders_email` varchar(254) NOT NULL,
  `orders_phone` varchar(11) NOT NULL,
  `orders_address` mediumtext NOT NULL,
  `orders_postal_code` varchar(254) NOT NULL,
  `orders_total_price` decimal(10,2) NOT NULL,
  `orders_payment_mode` varchar(254) NOT NULL,
  `orders_payment_id` int(30) NOT NULL,
  `orders_status` tinyint(4) NOT NULL DEFAULT 0,
  `orders_comments` varchar(300) DEFAULT NULL,
  `orders_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_tracking_no`, `orders_user_ID`, `orders_full_name`, `orders_email`, `orders_phone`, `orders_address`, `orders_postal_code`, `orders_total_price`, `orders_payment_mode`, `orders_payment_id`, `orders_status`, `orders_comments`, `orders_createdAt`) VALUES
(8, 'nrcrCtr5957874563214', 2, 'ana', 'ana@gmaill.com', '09874563214', 'ana', 'ana', '42112.20', 'Cash on Delivery', 2147483647, 2, NULL, '2023-06-19 14:40:43'),
(9, 'nrcrCtr7019874563214', 2, 'ana', 'ana@gmaill.com', '09874563214', 'ana', 'ana111', '76661.00', 'Cash on Delivery', 2147483647, 2, NULL, '2023-06-20 01:41:19'),
(10, 'nrcrCtr9230876541235', 2, 'ana', 'ana@gmaill.com', '09876541235', 'anaasdadadadas', 'anaasdasddas', '26946.40', 'Cash on Delivery', 2147483647, 3, NULL, '2023-06-20 07:06:17'),
(11, 'nrcrCtr3848547951465', 14, 'joshua123', 'joshua123@gmail.com', '09547951465', 'joshua123', 'joshua123', '102921.00', 'Cash on Delivery', 2147483647, 2, NULL, '2023-06-20 08:25:41'),
(12, 'nrcrCtr4140878564125', 14, 'joshua', 'joshua123@gmail.com', '09878564125', 'joshuajoshua', 'joshuajoshua', '17056.00', 'Cash on Delivery', 0, 0, NULL, '2023-06-20 08:30:14'),
(13, 'nrcrCtr6846875468987', 14, 'joshua', 'joshua123@gmail.com', '09875468987', 'joshua', 'joshua', '10019.10', 'Cash on Delivery', 2147483647, 0, NULL, '2023-06-20 08:32:23'),
(14, 'nrcrCtr4120876542365', 2, 'asd', 'ASD@GMAIL.COM', '09876542365', 'asd', 'asd', '78413.40', 'Cash on Delivery', 2147483647, 2, NULL, '2023-06-21 07:28:19'),
(15, 'nrcrCtr2757658978562', 2, 'asdasd', 'asdasdadas@g.co', '09658978562', 'asdadasd', 'asdasd', '42112.20', 'Cash on Delivery', 2147483647, 0, NULL, '2023-06-21 07:33:09'),
(16, 'nrcrCtr1166865798565', 2, 'Ana Bien Beatriz Salazar', 'ana@gmail.com', '09865798565', 'Tolentino, E Rd, Tagaytay, Cavite', '4120', '8730.80', 'Cash on Delivery', 2147483647, 0, NULL, '2023-06-23 16:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderItems_id` int(11) NOT NULL,
  `orderItems_order_id` int(11) NOT NULL,
  `orderItems_product_id` int(11) NOT NULL,
  `orderItems_qty` int(11) NOT NULL,
  `orderItems_price` decimal(10,2) NOT NULL,
  `orderItems_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderItems_id`, `orderItems_order_id`, `orderItems_product_id`, `orderItems_qty`, `orderItems_price`, `orderItems_createdAt`) VALUES
(21, 8, 39, 2, '21056.10', '2023-06-19 14:40:43'),
(22, 9, 58, 1, '76661.00', '2023-06-20 01:41:19'),
(23, 10, 27, 1, '12126.40', '2023-06-20 07:06:17'),
(24, 10, 23, 1, '6240.00', '2023-06-20 07:06:17'),
(25, 10, 32, 1, '8580.00', '2023-06-20 07:06:17'),
(26, 11, 34, 3, '9620.00', '2023-06-20 08:25:41'),
(27, 11, 44, 3, '24687.00', '2023-06-20 08:25:41'),
(28, 12, 35, 1, '10816.00', '2023-06-20 08:30:14'),
(29, 12, 23, 1, '6240.00', '2023-06-20 08:30:14'),
(30, 13, 26, 1, '10019.10', '2023-06-20 08:32:23'),
(31, 14, 54, 1, '78413.40', '2023-06-21 07:28:19'),
(32, 15, 39, 2, '21056.10', '2023-06-21 07:33:09'),
(33, 16, 28, 1, '8730.80', '2023-06-23 16:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(254) NOT NULL,
  `product_slug` varchar(300) NOT NULL,
  `product_small_description` mediumtext NOT NULL,
  `product_description` mediumtext NOT NULL,
  `product_original_price` decimal(10,2) NOT NULL,
  `product_srp` decimal(10,2) NOT NULL,
  `product_image` varchar(300) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_status` tinyint(4) NOT NULL,
  `product_popular` tinyint(4) NOT NULL,
  `product_meta_title` varchar(254) NOT NULL,
  `product_meta_keywords` mediumtext NOT NULL,
  `product_meta_description` mediumtext NOT NULL,
  `product_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_slug`, `product_small_description`, `product_description`, `product_original_price`, `product_srp`, `product_image`, `product_qty`, `product_status`, `product_popular`, `product_meta_title`, `product_meta_keywords`, `product_meta_description`, `product_createdAt`) VALUES
(22, 34, 'CURVE BO PEEP HALTER CORSET RED', 'curvebopeephaltercorsetred', 'CURVE BO PEEP HALTER CORSET RED', 'CURVE BO PEEP HALTER CORSET RED', '4970.00', '6461.00', '1687015583.jpg', 12, 0, 1, 'CURVE BO PEEP HALTER CORSET RED', 'CURVE BO PEEP HALTER CORSET RED', 'CURVE BO PEEP HALTER CORSET RED', '2023-06-17 15:26:23'),
(23, 34, 'LOLITA CROP HOODY PURPLE', 'lolitacrophoodypurple', 'LOLITA CROP HOODY PURPLE', 'LOLITA CROP HOODY PURPLE', '4800.00', '6240.00', '1687042645.jpg', 11, 0, 1, 'LOLITA CROP HOODY PURPLE', 'LOLITA CROP HOODY PURPLE', 'LOLITA CROP HOODY PURPLE', '2023-06-17 22:57:25'),
(24, 34, 'CLASH HOODY', 'clashhoody', 'CLASH HOODY', 'CLASH HOODY', '7484.00', '9729.20', '1687042720.jpg', 18, 0, 0, 'CLASH HOODY', 'CLASH HOODY', 'CLASH HOODY', '2023-06-17 22:58:40'),
(26, 34, 'BIG SKULL PANTS', 'bigskullpants', 'BIG SKULL PANTS', 'BIG SKULL PANTS', '7707.00', '10019.10', '1687043042.jpg', 16, 0, 0, 'BIG SKULL PANTS', 'BIG SKULL PANTS', 'BIG SKULL PANTS', '2023-06-17 23:04:02'),
(27, 41, 'Pink Crucifix collar baby pink collar choker', 'pinkcrucifixcollarbabypinkcollarchoker', 'Pink Crucifix collar baby pink collar choker', 'Pink Crucifix collar baby pink collar choker', '9328.00', '12126.40', '1687044701.jpg', 19, 0, 1, 'Pink Crucifix collar baby pink collar choker', 'Pink Crucifix collar baby pink collar choker', 'Pink Crucifix collar baby pink collar choker', '2023-06-17 23:31:41'),
(28, 41, 'Goth body harness Spike collar body bondage', 'gothbodyharnessspikecollarbodybondage', 'Goth body harness Spike collar body bondage', 'Goth body harness Spike collar body bondage', '6716.00', '8730.80', '1687046729.jpg', 15, 0, 1, 'Goth body harness Spike collar body bondage', 'Goth body harness Spike collar body bondage', 'Goth body harness Spike collar body bondage', '2023-06-18 00:05:29'),
(29, 41, 'Spike bag waist bag shoulder bag skull leather', 'spikebagwaistbagshoulderbagskullleather', 'Spike bag waist bag shoulder bag skull leather', 'Spike bag waist bag shoulder bag skull leather', '11940.00', '15522.00', '1687046809.jpg', 14, 0, 0, 'Spike bag waist bag shoulder bag skull leather', 'Spike bag waist bag shoulder bag skull leather', 'Spike bag waist bag shoulder bag skull leather', '2023-06-18 00:06:49'),
(30, 41, 'Goth statement necklace goth necklace bat necklace', 'gothstatementnecklacegothnecklacebatnecklace', 'Goth statement necklace goth necklace bat necklace', 'Goth statement necklace goth necklace bat necklace', '8955.00', '11641.50', '1687046904.jpg', 11, 0, 0, 'Goth statement necklace goth necklace bat necklace', 'Goth statement necklace goth necklace bat necklace', 'Goth statement necklace goth necklace bat necklace', '2023-06-18 00:08:24'),
(31, 27, 'DEMON-18', 'demon18', 'DEMON-18', 'DEMON-18', '4500.00', '5850.00', '1687047006.jpg', 15, 0, 1, 'DEMON-18', 'DEMON-18', 'DEMON-18', '2023-06-18 00:10:06'),
(32, 27, 'CAMEL-65', 'camel65', 'CAMEL-65', 'CAMEL-65', '6600.00', '8580.00', '1687047075.jpg', 17, 0, 1, 'CAMEL-65', 'CAMEL-65', 'CAMEL-65', '2023-06-18 00:11:15'),
(33, 27, 'BRATTY-304', 'bratty304', 'BRATTY-304', 'BRATTY-304', '7500.00', '9750.00', '1687047164.jpg', 20, 0, 0, 'BRATTY-304', 'BRATTY-304', 'BRATTY-304', '2023-06-18 00:12:44'),
(34, 27, 'BOLT-450', 'bolt450', 'BOLT-450', 'BOLT-450', '7400.00', '9620.00', '1687047221.jpg', 19, 0, 0, 'BOLT-450', 'BOLT-450', 'BOLT-450', '2023-06-18 00:13:41'),
(35, 29, 'Soursop-04 PINK', 'soursop04pink', 'Soursop-04 PINK', 'Soursop-04 PINK', '8320.00', '10816.00', '1687047478.jpg', 24, 0, 1, 'Soursop-04 PINK', 'Soursop-04 PINK', 'Soursop-04 PINK', '2023-06-18 00:17:58'),
(36, 29, 'Quince 03 - Burgundy', 'quince03burgundy', 'Quince 03 - Burgundy', 'Quince 03 - Burgundy', '6310.00', '8203.00', '1687047532.jpg', 23, 0, 1, 'Quince 03 - Burgundy', 'Quince 03 - Burgundy', 'Quince 03 - Burgundy', '2023-06-18 00:18:52'),
(37, 29, 'Pomegranate 01 - White', 'pomegranate01white', 'Pomegranate 01 - White', 'Pomegranate 01 - White', '6870.00', '8931.00', '1687047673.jpg', 24, 0, 0, 'Pomegranate 01 - White', 'Pomegranate 01 - White', 'Pomegranate 01 - White', '2023-06-18 00:21:13'),
(38, 29, 'Black Guava - Black', 'blackguavablack', 'Black Guava - Black', 'Black Guava - Black', '10050.00', '13065.00', '1687047736.jpg', 26, 0, 0, 'Black Guava - Black', 'Black Guava - Black', 'Black Guava - Black', '2023-06-18 00:22:16'),
(39, 25, 'COTTON BROAD CLOTH FOIL PRINT LONG SHIRT', 'cottonbroadclothfoilprintlongshirt', 'COTTON BROAD CLOTH FOIL PRINT LONG SHIRT', 'COTTON BROAD CLOTH FOIL PRINT LONG SHIRT', '16197.00', '21056.10', '1687047948.jpg', 25, 0, 1, 'COTTON BROAD CLOTH FOIL PRINT LONG SHIRT', 'COTTON BROAD CLOTH FOIL PRINT LONG SHIRT', 'COTTON BROAD CLOTH FOIL PRINT LONG SHIRT', '2023-06-18 00:25:48'),
(40, 25, 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT JACKET', 'woolpolyestertropicalclothfoilprintjacket', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT JACKET', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT JACKET', '27925.00', '36302.50', '1687048115.jpg', 27, 0, 1, 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT JACKET', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT JACKET', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT JACKET', '2023-06-18 00:28:35'),
(41, 25, 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT 12-PLEAT PANTS', 'woolpolyestertropicalclothfoilprint12pleatpants', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT 12-PLEAT PANTS', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT 12-PLEAT PANTS', '20100.00', '26130.00', '1687048408.jpg', 27, 0, 0, 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT 12-PLEAT PANTS', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT 12-PLEAT PANTS', 'WOOL/POLYESTER TROPICAL CLOTH FOIL PRINT 12-PLEAT PANTS', '2023-06-18 00:33:28'),
(42, 25, 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT JACKET WITH DOUBLE-TAILORED LEFT FRONT', 'linenrayoneasyclothindianblocksquareprintjacketwithdoubletailoredleftfront', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT JACKET WITH DOUBLE-TAILORED LEFT FRONT', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT JACKET WITH DOUBLE-TAILORED LEFT FRONT', '29320.00', '38116.00', '1687048549.jpg', 28, 0, 0, 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT JACKET WITH DOUBLE-TAILORED LEFT FRONT', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT JACKET WITH DOUBLE-TAILORED LEFT FRONT', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT JACKET WITH DOUBLE-TAILORED LEFT FRONT', '2023-06-18 00:35:49'),
(43, 25, 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT PANTS', 'linenrayoneasyclothindianblocksquareprintpants', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT PANTS', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT PANTS', '18150.00', '23595.00', '1687048646.jpg', 28, 0, 0, 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT PANTS', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT PANTS', 'LINEN/RAYON EASY CLOTH+INDIAN BLOCK SQUARE PRINT PANTS', '2023-06-18 00:37:26'),
(44, 25, 'SMOOTH POLYESTER FLAME DOUBLE DRAPE COAT', 'smoothpolyesterflamedoubledrapecoat', 'SMOOTH POLYESTER FLAME DOUBLE DRAPE COAT', 'SMOOTH POLYESTER FLAME DOUBLE DRAPE COAT', '18990.00', '24687.00', '1687049069.jpg', 26, 0, 1, 'SMOOTH POLYESTER FLAME DOUBLE DRAPE COAT', 'SMOOTH POLYESTER FLAME DOUBLE DRAPE COAT', 'SMOOTH POLYESTER FLAME DOUBLE DRAPE COAT', '2023-06-18 00:44:29'),
(45, 25, 'SMOOTH POLYESTER 12-PLEAT PANTS WITH DRAWCORD HEM', 'smoothpolyester12pleatpantswithdrawcordhem', 'SMOOTH POLYESTER 12-PLEAT PANTS WITH DRAWCORD HEM', 'SMOOTH POLYESTER 12-PLEAT PANTS WITH DRAWCORD HEM', '15000.00', '19500.00', '1687049105.jpg', 29, 0, 0, 'SMOOTH POLYESTER 12-PLEAT PANTS WITH DRAWCORD HEM', 'SMOOTH POLYESTER 12-PLEAT PANTS WITH DRAWCORD HEM', 'SMOOTH POLYESTER 12-PLEAT PANTS WITH DRAWCORD HEM', '2023-06-18 00:45:05'),
(46, 25, 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT RAGLAN SLEEVE JACKET', 'woolpolyestertropicalclothindianblockpaisleyprintraglansleevejacket', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT RAGLAN SLEEVE JACKET', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT RAGLAN SLEEVE JACKET', '26800.00', '34840.00', '1687049152.jpg', 30, 0, 1, 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT RAGLAN SLEEVE JACKET', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT RAGLAN SLEEVE JACKET', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT RAGLAN SLEEVE JACKET', '2023-06-18 00:45:52'),
(47, 25, 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT THAI-STYLE PANTS', 'woolpolyestertropicalclothindianblockpaisleyprintthaistylepants', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT THAI-STYLE PANTS', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT THAI-STYLE PANTS', '17310.00', '22503.00', '1687049322.jpg', 30, 0, 0, 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT THAI-STYLE PANTS', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT THAI-STYLE PANTS', 'WOOL/POLYESTER TROPICAL CLOTH + INDIAN BLOCK PAISLEY PRINT THAI-STYLE PANTS', '2023-06-18 00:48:42'),
(48, 26, '60/LINEN FIREWORKS TWO-TUCK SLIM PANTS', '60linenfireworkstwotuckslimpants', '60/LINEN FIREWORKS TWO-TUCK SLIM PANTS', '60/LINEN FIREWORKS TWO-TUCK SLIM PANTS', '43560.00', '56628.00', '1687052957.jpg', 20, 0, 1, '60/LINEN FIREWORKS TWO-TUCK SLIM PANTS', '60/LINEN FIREWORKS TWO-TUCK SLIM PANTS', '60/LINEN FIREWORKS TWO-TUCK SLIM PANTS', '2023-06-18 01:49:17'),
(49, 26, '60/- LINEN FIREWORKS PRINT COLLARLESS JACKET', '60linenfireworksprintcollarlessjacket', '60/- LINEN FIREWORKS PRINT COLLARLESS JACKET', '60/- LINEN FIREWORKS PRINT COLLARLESS JACKET', '61660.00', '80158.00', '1687053025.jpg', 20, 0, 0, '60/- LINEN FIREWORKS PRINT COLLARLESS JACKET', '60/- LINEN FIREWORKS PRINT COLLARLESS JACKET', '60/- LINEN FIREWORKS PRINT COLLARLESS JACKET', '2023-06-18 01:50:25'),
(50, 26, 'L/C/N WATER REPELLENT WEATHER LONG WORK COAT', 'lcnwaterrepellentweatherlongworkcoat', 'L/C/N WATER REPELLENT WEATHER LONG WORK COAT', 'L/C/N WATER REPELLENT WEATHER LONG WORK COAT', '61660.00', '80158.00', '1687053217.jpg', 20, 0, 0, 'L/C/N WATER REPELLENT WEATHER LONG WORK COAT', 'L/C/N WATER REPELLENT WEATHER LONG WORK COAT', 'L/C/N WATER REPELLENT WEATHER LONG WORK COAT', '2023-06-18 01:53:37'),
(51, 26, 'L/C/N WATER REPELLENT WEATHER 4D POCKET SHORTS', 'lcnwaterrepellentweather4dpocketshorts', 'L/C/N WATER REPELLENT WEATHER 4D POCKET SHORTS', 'L/C/N WATER REPELLENT WEATHER 4D POCKET SHORTS', '28150.00', '36595.00', '1687053294.jpg', 20, 0, 0, 'L/C/N WATER REPELLENT WEATHER 4D POCKET SHORTS', 'L/C/N WATER REPELLENT WEATHER 4D POCKET SHORTS', 'L/C/N WATER REPELLENT WEATHER 4D POCKET SHORTS', '2023-06-18 01:54:54'),
(52, 26, '60/LINEN STRIPE ASYMMETRIC JACKET TYPE2', '60linenstripeasymmetricjackettype2', '60/LINEN STRIPE ASYMMETRIC JACKET TYPE2', '60/LINEN STRIPE ASYMMETRIC JACKET TYPE2\r\n', '56960.00', '74048.00', '1687053441.jpg', 20, 0, 0, '60/LINEN STRIPE ASYMMETRIC JACKET TYPE2', '60/LINEN STRIPE ASYMMETRIC JACKET TYPE2\r\n', '60/LINEN STRIPE ASYMMETRIC JACKET TYPE2\r\n', '2023-06-18 01:57:21'),
(53, 26, '60/LINEN STRIPE TWO-TUCK SLIM PANTS', '60linenstripetwotuckslimpants', '60/LINEN STRIPE TWO-TUCK SLIM PANTS', '60/LINEN STRIPE TWO-TUCK SLIM PANTS', '41550.00', '54015.00', '1687053487.jpg', 20, 0, 1, '60/LINEN STRIPE TWO-TUCK SLIM PANTS', '60/LINEN STRIPE TWO-TUCK SLIM PANTS', '60/LINEN STRIPE TWO-TUCK SLIM PANTS', '2023-06-18 01:58:07'),
(54, 26, '60/- LINEN LAWN TRENCH COAT-STYLE PONCHO', '60linenlawntrenchcoatstyleponcho', '60/- LINEN LAWN TRENCH COAT-STYLE PONCHO', '60/- LINEN LAWN TRENCH COAT-STYLE PONCHO\r\n', '60318.00', '78413.40', '1687053670.jpg', 19, 0, 0, '60/- LINEN LAWN TRENCH COAT-STYLE PONCHO', '60/- LINEN LAWN TRENCH COAT-STYLE PONCHO\r\n', '60/- LINEN LAWN TRENCH COAT-STYLE PONCHO\r\n', '2023-06-18 02:01:10'),
(55, 26, '50/- LINEN PLEATED BONTAN PANTS WITH FRONT SEAM', '50linenpleatedbontanpantswithfrontseam', '50/- LINEN PLEATED BONTAN PANTS WITH FRONT SEAM', '50/- LINEN PLEATED BONTAN PANTS WITH FRONT SEAM', '26800.00', '34840.00', '1687053747.jpg', 20, 0, 0, '50/- LINEN PLEATED BONTAN PANTS WITH FRONT SEAM', '50/- LINEN PLEATED BONTAN PANTS WITH FRONT SEAM', '50/- LINEN PLEATED BONTAN PANTS WITH FRONT SEAM', '2023-06-18 02:02:27'),
(56, 26, '50 LINEN CLOTH MESH HOODIE JACKET', '50linenclothmeshhoodiejacket', '50 LINEN CLOTH MESH HOODIE JACKET', '50 LINEN CLOTH MESH HOODIE JACKET', '64340.00', '83642.00', '1687053788.jpg', 20, 0, 0, '50 LINEN CLOTH MESH HOODIE JACKET', '50 LINEN CLOTH MESH HOODIE JACKET', '50 LINEN CLOTH MESH HOODIE JACKET', '2023-06-18 02:03:08'),
(57, 26, 'BLOCK FLOWER PRINT OVERSIZED SHIRT', 'blockflowerprintoversizedshirt', 'BLOCK FLOWER PRINT OVERSIZED SHIRT', 'BLOCK FLOWER PRINT OVERSIZED SHIRT', '29480.00', '38324.00', '1687054090.jpg', 20, 0, 0, 'BLOCK FLOWER PRINT OVERSIZED SHIRT', 'BLOCK FLOWER PRINT OVERSIZED SHIRT', 'BLOCK FLOWER PRINT OVERSIZED SHIRT', '2023-06-18 02:08:10'),
(58, 26, 'BLOCK FLOWER PRINT HOODED DRESS', 'blockflowerprinthoodeddress', 'BLOCK FLOWER PRINT HOODED DRESS', 'BLOCK FLOWER PRINT HOODED DRESS', '58970.00', '76661.00', '1687054170.jpg', 19, 0, 1, 'BLOCK FLOWER PRINT HOODED DRESS', 'BLOCK FLOWER PRINT HOODED DRESS', 'BLOCK FLOWER PRINT HOODED DRESS', '2023-06-18 02:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(8) NOT NULL,
  `user_firstName` varchar(80) NOT NULL,
  `user_lastName` varchar(80) NOT NULL,
  `user_email` varchar(254) NOT NULL,
  `user_phone` varchar(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(128) NOT NULL,
  `user_role` tinyint(1) NOT NULL DEFAULT 0,
  `user_accCreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `user_firstName`, `user_lastName`, `user_email`, `user_phone`, `user_username`, `user_password`, `user_role`, `user_accCreatedAt`) VALUES
(1, 'Nathaniel', 'Gatpandan', 'gtpndn@gmail.com', '09152844036', 'nath123', 'nath123', 1, '2023-06-06 06:11:49'),
(2, 'Ana Bien Beatriz', 'Salazar', 'ana@gmail.com', '09487652986', 'ana123', 'ana123', 0, '2023-06-06 06:30:17'),
(14, 'Joshua', 'Vidallon', 'joshua123@gmail.com', '222', 'joshua123', 'joshua123', 0, '2023-06-06 08:36:38'),
(16, 'test', 'test', 'test@gmail.com', '2', 'test', 'test', 0, '2023-06-11 01:18:06'),
(19, 'vien', 'vien', 'vienmar@gmail.com', '09876541235', 'vien', 'vien', 0, '2023-06-20 01:06:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likes_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderItems_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItems_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
