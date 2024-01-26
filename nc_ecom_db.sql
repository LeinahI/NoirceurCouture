-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2024 at 12:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
  `address_state` varchar(254) DEFAULT NULL,
  `address_city` varchar(254) DEFAULT NULL,
  `address_postal_code` varchar(254) DEFAULT NULL,
  `address_country` varchar(254) DEFAULT NULL,
  `address_fullAddress` mediumtext DEFAULT NULL,
  `address_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `address_user_ID`, `address_fullName`, `address_email`, `address_phone`, `address_state`, `address_city`, `address_postal_code`, `address_country`, `address_fullAddress`, `address_createdAt`) VALUES
(13, 47, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09651245365', 'Cavite', 'Tagaytay City', '4121', 'PH', 'Taga Tagaytay', '2024-01-16 02:56:34'),
(14, 46, 'Gessamae Cadiz', 'gessC@gmail.com', '09652123546', 'Cavite', 'Imus', '4103', 'PH', 'Taga Imus', '2024-01-16 07:42:01'),
(18, 48, 'Johna Doctora', 'tzuyutwiceyy@gmail.com', '09654123879', 'Cavite', 'Silang', '4118', 'PH', 'tartaria', '2024-01-17 18:40:13'),
(19, 49, 'Gessamae Cadiz', 'gessC@gmail.com', '09546545446', 'Cavite', 'Imus', '4103', 'PH', 'asd', '2024-01-25 05:54:45'),
(20, 58, 'Gessamae Cadiz', 'gessC@gmail.com', '09652423658', 'Cavite', 'Imus', '4103', 'PH', 'asd', '2024-01-26 07:53:38');

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
(421, 78, 103, 1, 'anonabombanagreytee', '2024-01-26 11:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_user_ID` int(11) NOT NULL,
  `category_name` varchar(254) NOT NULL,
  `category_slug` varchar(300) NOT NULL,
  `category_description` varchar(300) NOT NULL,
  `category_status` tinyint(1) NOT NULL DEFAULT 0,
  `category_image` varchar(300) NOT NULL,
  `category_meta_title` varchar(254) NOT NULL,
  `category_meta_description` mediumtext NOT NULL,
  `category_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_user_ID`, `category_name`, `category_slug`, `category_description`, `category_status`, `category_image`, `category_meta_title`, `category_meta_description`, `category_createdAt`) VALUES
(72, 47, 'Bessygod', 'bessygod', 'bessygod to ya', 0, 'bessygod-01-15-2024-20-08-35.png', 'Bessygod', 'bessygod to ya', '2024-01-15 12:08:35'),
(84, 48, 'Dope Girl Clothign', 'dopegirlclothign', 'DGC', 0, 'dopegirlclothign-01-18-2024-02-40-23.png', 'Dope Girl Clothign', 'DGC', '2024-01-17 18:40:23');

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
  `orders_state` varchar(254) NOT NULL,
  `orders_city` varchar(254) NOT NULL,
  `orders_country` varchar(254) NOT NULL,
  `orders_postal_code` varchar(254) NOT NULL,
  `orders_total_price` decimal(10,2) NOT NULL,
  `orders_payment_mode` varchar(254) NOT NULL,
  `orders_payment_id` varchar(30) NOT NULL,
  `orders_status` tinyint(4) NOT NULL DEFAULT 0,
  `orders_cancel_reason` tinyint(2) DEFAULT NULL,
  `orders_comments` varchar(300) DEFAULT NULL,
  `orders_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_tracking_no`, `orders_user_ID`, `orders_full_name`, `orders_email`, `orders_phone`, `orders_address`, `orders_state`, `orders_city`, `orders_country`, `orders_postal_code`, `orders_total_price`, `orders_payment_mode`, `orders_payment_id`, `orders_status`, `orders_cancel_reason`, `orders_comments`, `orders_createdAt`) VALUES
(109, 'nrcrCtr6524236586993', 58, 'Gessamae Cadiz', 'gessC@gmail.com', '09652423658', 'asd', 'Cavite', 'Imus', 'PH', '4103', 3500.00, 'Cash on Delivery', 'COD495495936584103', 0, NULL, NULL, '2024-01-26 07:58:28'),
(110, 'nrcrCtr1526542365369', 78, 'Gessamae Cadiz', 'gess@gmail.com', '09152654236', 'taga Imus', 'Cavite', 'Imus', 'PH', '4103', 1450.00, 'Cash on Delivery', 'COD4936393', 0, NULL, NULL, '2024-01-26 11:01:05');

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
(140, 109, 91, 5, 700.00, '2024-01-26 07:58:28'),
(141, 110, 103, 1, 750.00, '2024-01-26 11:01:05'),
(142, 110, 90, 1, 700.00, '2024-01-26 11:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(254) NOT NULL,
  `product_slug` varchar(300) NOT NULL,
  `product_description` mediumtext NOT NULL,
  `product_original_price` decimal(10,2) NOT NULL,
  `product_discount` int(2) NOT NULL,
  `product_srp` decimal(10,2) NOT NULL,
  `product_image` varchar(300) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_status` tinyint(4) NOT NULL DEFAULT 0,
  `product_popular` tinyint(4) NOT NULL,
  `product_meta_title` varchar(254) NOT NULL,
  `product_meta_description` mediumtext NOT NULL,
  `product_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_slug`, `product_description`, `product_original_price`, `product_discount`, `product_srp`, `product_image`, `product_qty`, `product_status`, `product_popular`, `product_meta_title`, `product_meta_description`, `product_createdAt`) VALUES
(90, 72, 'Kurolody 666', 'kurolody666', 'Kurolody Black Shirt', 700.00, 0, 700.00, 'kurolody666-01-15-2024-20-16-23.png', 0, 0, 1, 'Kurolody 666', 'Kurolody Black Shirt', '2024-01-15 12:16:23'),
(91, 72, 'Cinnamurin 666', 'cinnamurin666', 'Cinnamurin 666 White Shirt', 700.00, 0, 700.00, 'cinnamurin666-01-15-2024-20-18-08.png', 0, 0, 1, 'Cinnamurin 666', 'Cinnamurin 666 White Shirt', '2024-01-15 12:18:08'),
(94, 72, 'Ravenlust', 'ravenlust', 'Ravenlust Black Shirt', 750.00, 0, 750.00, 'ravenlust-01-16-2024-10-51-36.png', 5, 0, 0, 'Ravenlust', 'Ravenlust Black Shirt', '2024-01-16 02:51:36'),
(102, 84, 'ANO NA BOMBA NA BLACK TEE', 'anonabombanablacktee', 'Ano na bomba na Black shirt', 750.00, 0, 750.00, 'anonabombanatee-01-20-2024-11-42-44.png', 22, 0, 1, 'ANO NA BOMBA NA BLACK TEE', 'Ano na bomba na Black shirt', '2024-01-20 03:42:44'),
(103, 84, 'ANO NA BOMBA NA GREY TEE ', 'anonabombanagreytee', 'Ano na bomba na Sports Grey shirt', 750.00, 0, 750.00, 'anonabombanagreytee-01-20-2024-11-44-05.png', 19, 0, 1, 'ANO NA BOMBA NA GREY TEE ', 'Ano na bomba na Sports Grey shirt', '2024-01-20 03:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE `slideshow` (
  `ss_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `ss_image` varchar(300) NOT NULL,
  `ss_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`ss_id`, `category_id`, `ss_image`, `ss_createdAt`) VALUES
(12, 72, '72-01-16-2024-21-52-41.png', '2024-01-16 13:52:41');

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
(1, 'Nathaniel', 'Gatpandan', 'gtpndn@gmail.com', '09152844036', 'nath123', 'P>E]hM?:u)&7g^R', 1, '2023-06-06 06:11:49'),
(47, 'Ana Bien Beatriz', 'Salazar', 'anabien@gmail.com', '09651245365', 'ana123', 'ana123', 2, '2024-01-15 11:43:44'),
(48, 'Johna', 'Doctora', 'tzuyutwiceyy@gmail.com', '09874563215', 'jhna123', 'pn$N!b!SQp9Mm$&', 2, '2024-01-17 18:19:16'),
(78, 'Gessamae', 'Cadiz', 'gessC@gmail.com', '09652136542', 'sammy12', 'zuD!X2', 0, '2024-01-26 10:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `users_deleted_details`
--

CREATE TABLE `users_deleted_details` (
  `deleted_ID` int(8) NOT NULL,
  `deleted_user_ID` varchar(8) NOT NULL,
  `deleted_user_firstName` varchar(80) NOT NULL,
  `deleted_user_lastName` varchar(80) NOT NULL,
  `deleted_user_email` varchar(254) NOT NULL,
  `deleted_user_phone` varchar(11) NOT NULL,
  `deleted_user_username` varchar(50) NOT NULL,
  `deleted_user_password` varchar(128) NOT NULL,
  `deleted_user_role` tinyint(1) NOT NULL,
  `deleted_reason` varchar(128) NOT NULL,
  `deleted_reason_details` varchar(300) DEFAULT NULL,
  `deleted_confirmed` tinyint(1) DEFAULT 0,
  `deleted_reqCreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_deleted_details`
--

INSERT INTO `users_deleted_details` (`deleted_ID`, `deleted_user_ID`, `deleted_user_firstName`, `deleted_user_lastName`, `deleted_user_email`, `deleted_user_phone`, `deleted_user_username`, `deleted_user_password`, `deleted_user_role`, `deleted_reason`, `deleted_reason_details`, `deleted_confirmed`, `deleted_reqCreatedAt`) VALUES
(31, '76', 'Gessamae', 'Cadiz', 'gessC@gmail.com', '09652136542', 'sammy12', 'zuD!X2', 0, 'I am no longer want to use Noirceur Couture', '', 1, '2024-01-26 10:27:45'),
(32, '77', 'Gessamae', 'Cadiz', 'gessC@gmail.com', '09652136542', 'sammy12', 'zuD!X2', 0, 'I want to change my username', 'asd', 1, '2024-01-26 10:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `users_seller_details`
--

CREATE TABLE `users_seller_details` (
  `seller_id` int(11) NOT NULL,
  `seller_user_ID` int(11) NOT NULL,
  `seller_seller_type` varchar(254) NOT NULL,
  `seller_confirmed` int(1) NOT NULL DEFAULT 0,
  `seller_accCreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_seller_details`
--

INSERT INTO `users_seller_details` (`seller_id`, `seller_user_ID`, `seller_seller_type`, `seller_confirmed`, `seller_accCreatedAt`) VALUES
(8, 47, 'individual', 1, '2024-01-15 11:43:44'),
(9, 48, 'individual', 1, '2024-01-17 18:19:16');

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
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`ss_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indexes for table `users_deleted_details`
--
ALTER TABLE `users_deleted_details`
  ADD PRIMARY KEY (`deleted_ID`);

--
-- Indexes for table `users_seller_details`
--
ALTER TABLE `users_seller_details`
  ADD PRIMARY KEY (`seller_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItems_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `ss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users_deleted_details`
--
ALTER TABLE `users_deleted_details`
  MODIFY `deleted_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users_seller_details`
--
ALTER TABLE `users_seller_details`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
