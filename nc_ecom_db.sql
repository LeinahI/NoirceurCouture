-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2024 at 05:12 AM
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
(7, 16, 'Gessamae Cadiz', 'tzuyutwiceyy@gmail.com', '09653245698', 'Cavite', 'Imus', '4103', 'PH', 'Tomas Morato QC', '2024-01-05 05:49:44'),
(8, 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Cavite', 'Tagaytay', '4120', 'PH', 'Mayors Drive', '2024-01-07 14:50:19'),
(9, 43, 'Hades Jimenez', 'hades@gmail.com', '09652314251', 'Cavite', 'Dasma', '4114', 'PH', 'basta taga Dasma', '2024-01-10 11:02:39');

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
(63, 1, 'Hysteria Supply', 'hysteriasupply', 'Hysteria Supply', 0, 'hysteriasupply-01-08-2024-16-00-17.jpg', 'Hysteria Supply', 'Hysteria Supply', '2024-01-08 08:00:17'),
(69, 42, 'HOOLIGANS.', 'hooligans', 'HOOLIGANS.', 0, 'hooligans-01-08-2024-20-19-13.png', 'HOOLIGANS.', 'HOOLIGANS.', '2024-01-08 11:23:27'),
(70, 43, 'Dope Girl Clothign', 'dopegirlclothign', 'Dope Girl Clothign', 0, 'dopegirlclothign-01-08-2024-22-11-07.png', 'Dope Girl Clothign', 'Dope Girl Clothign', '2024-01-08 14:11:07');

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
  `orders_comments` varchar(300) DEFAULT NULL,
  `orders_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_tracking_no`, `orders_user_ID`, `orders_full_name`, `orders_email`, `orders_phone`, `orders_address`, `orders_state`, `orders_city`, `orders_country`, `orders_postal_code`, `orders_total_price`, `orders_payment_mode`, `orders_payment_id`, `orders_status`, `orders_comments`, `orders_createdAt`) VALUES
(73, 'nrcrCtr4272653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 1040.00, 'Paypal', '6WG986349R902010S', 3, NULL, '2024-01-08 13:27:24'),
(74, 'nrcrCtr4418653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 1040.00, 'Cash on Delivery', 'COD541096426984120', 3, NULL, '2024-01-08 13:28:04'),
(75, 'nrcrCtr9427653245698', 16, 'Gessamae Cadiz', 'tzuyutwiceyy@gmail.com', '09653245698', 'Tomas Morato QC', 'Cavite', 'Imus', 'PH', '4103', 910.00, 'Cash on Delivery', 'COD918461256984103', 2, NULL, '2024-01-08 14:14:49'),
(76, 'nrcrCtr8258653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 910.00, 'Paypal', '0U3130270C379553E', 1, NULL, '2024-01-08 14:16:38'),
(77, 'nrcrCtr7870653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 1600.00, 'Cash on Delivery', 'COD598333126984120', 0, NULL, '2024-01-09 15:07:35'),
(78, 'nrcrCtr9893653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 1600.00, 'Cash on Delivery', 'COD982221226984120', 2, NULL, '2024-01-09 16:16:41'),
(79, 'nrcrCtr2779653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 3200.00, 'Cash on Delivery', 'COD99260826984120', 3, NULL, '2024-01-10 06:01:32'),
(80, 'nrcrCtr8054653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 3150.00, 'Cash on Delivery', 'COD166051926984120', 3, NULL, '2024-01-10 06:02:39'),
(81, 'nrcrCtr7970653452698', 2, 'Ana Bien Beatriz Salazar', 'anabien@gmail.com', '09653452698', 'Mayors Drive', 'Cavite', 'Tagaytay', 'PH', '4120', 1260.00, 'Cash on Delivery', 'COD589785926984120', 3, NULL, '2024-01-10 06:16:12'),
(82, 'nrcrCtr1172653245698', 16, 'Gessamae Cadiz', 'tzuyutwiceyy@gmail.com', '09653245698', 'Tomas Morato QC', 'Cavite', 'Imus', 'PH', '4103', 7000.00, 'Cash on Delivery', '', 2, NULL, '2024-01-10 18:54:21'),
(83, 'nrcrCtr1648653245698', 16, 'Gessamae Cadiz', 'tzuyutwiceyy@gmail.com', '09653245698', 'Tomas Morato QC', 'Cavite', 'Imus', 'PH', '4103', 800.00, 'Cash on Delivery', 'COD724773456984103', 2, NULL, '2024-01-10 19:20:52'),
(84, 'nrcrCtr9696653245698', 16, 'Gessamae Cadiz', 'tzuyutwiceyy@gmail.com', '09653245698', 'Tomas Morato QC', 'Cavite', 'Imus', 'PH', '4103', 5000.00, 'Cash on Delivery', 'COD55343356984103', 0, NULL, '2024-01-10 19:23:10');

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
(94, 73, 83, 1, 1040.00, '2024-01-08 13:27:24'),
(95, 74, 84, 1, 1040.00, '2024-01-08 13:28:04'),
(96, 75, 85, 1, 910.00, '2024-01-08 14:14:49'),
(97, 76, 85, 1, 910.00, '2024-01-08 14:16:38'),
(98, 77, 84, 2, 800.00, '2024-01-09 15:07:35'),
(99, 78, 84, 2, 800.00, '2024-01-09 16:16:41'),
(100, 79, 88, 4, 800.00, '2024-01-10 06:01:32'),
(101, 80, 85, 5, 630.00, '2024-01-10 06:02:39'),
(102, 81, 85, 2, 630.00, '2024-01-10 06:16:12'),
(103, 82, 86, 14, 500.00, '2024-01-10 18:54:21'),
(104, 83, 84, 1, 800.00, '2024-01-10 19:20:52'),
(105, 84, 86, 10, 500.00, '2024-01-10 19:23:10');

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
  `product_discount` int(2) NOT NULL,
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

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_slug`, `product_small_description`, `product_description`, `product_original_price`, `product_discount`, `product_srp`, `product_image`, `product_qty`, `product_status`, `product_popular`, `product_meta_title`, `product_meta_keywords`, `product_meta_description`, `product_createdAt`) VALUES
(83, 69, 'HLGNZ BABY TEE', 'hlgnzbabytee', 'HLGNZ BABY TEE', 'HLGNZ BABY TEE', 800.00, 10, 720.00, 'hlgnzbabytee-01-08-2024-20-28-07.png', 17, 0, 1, 'HLGNZ BABY TEE', 'HLGNZ BABY TEE', 'HLGNZ BABY TEE', '2024-01-08 12:28:07'),
(84, 63, 'NewJeans', 'newjeans', 'NewJeans', 'NewJeans', 800.00, 0, 800.00, 'newjeans-01-08-2024-20-31-01.jpg', 2, 0, 1, 'NewJeans', 'NewJeans', 'NewJeans', '2024-01-08 12:31:01'),
(85, 70, 'TS 1989 BOOTLEG SHIRT', 'ts1989bootlegshirt', 'TS 1989 BOOTLEG SHIRT', 'TS 1989 BOOTLEG SHIRT', 700.00, 10, 630.00, 'ts1989bootlegshirt-01-08-2024-22-13-19.png', 8, 0, 1, 'TS 1989 BOOTLEG SHIRT', 'TS 1989 BOOTLEG SHIRT', 'TS 1989 BOOTLEG SHIRT', '2024-01-08 14:13:19'),
(86, 63, 'Budots', 'budots', 'Budots', 'Budots', 1000.00, 50, 500.00, 'budots-01-09-2024-14-16-08.jpg', 0, 0, 1, 'Budots', 'Budots', 'Budots', '2024-01-09 06:16:08'),
(87, 69, 'HLGNZ SWEATPANTS AND HOODIE', 'hlgnzsweatpantsandhoodie', 'HLGNZ SWEATPANTS AND HOODIE', 'HLGNZ SWEATPANTS AND HOODIE', 2000.00, 10, 1800.00, 'hlgnzsweatpantsandhoodie-01-09-2024-15-05-21.png', 29, 0, 1, 'HLGNZ SWEATPANTS AND HOODIE', 'HLGNZ SWEATPANTS AND HOODIE', 'HLGNZ SWEATPANTS AND HOODIE', '2024-01-09 07:05:21'),
(88, 70, 'Ednis Rodman', 'ednisrodman', 'Ednis Rodman', 'Ednis Rodman', 800.00, 0, 800.00, 'ednisrodman-01-10-2024-13-49-34.png', 12, 0, 1, 'Ednis Rodman', 'Ednis Rodman', 'Ednis Rodman', '2024-01-10 05:49:34');

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
(8, 70, '70-01-10-2024-14-33-59.png', '2024-01-10 06:33:59'),
(9, 69, '69-01-10-2024-14-35-58.png', '2024-01-10 06:35:58'),
(10, 63, '63-01-10-2024-14-36-50.png', '2024-01-10 06:36:50');

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
(2, 'Ana Bien Beatriz', 'Salazar', 'ana@gmail.com', '09487652986', 'ana123', 'ana123', 0, '2023-06-06 06:30:17'),
(16, 'Gessamae', 'Cadiz', 'tzuyutwiceyy@gmail.com', '09658796545', 'gessamae', 'pn$N!b!SQp9Mm$&', 0, '2023-06-11 01:18:06'),
(42, 'Sammy', 'Cadiz', 'tsvodtbins@gmail.com', '09652365426', 'sammy12', 'zuD!X2', 2, '2024-01-08 03:32:19'),
(43, 'Hades', 'Jimenez', 'hades@gmail.com', '09652314251', 'hades', 'aG~)Z?XbjZeJ6M-', 2, '2024-01-08 14:10:30');

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
(5, 42, 'business', 1, '2024-01-08 03:32:19'),
(6, 43, 'individual', 1, '2024-01-08 14:10:30');

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItems_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `ss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users_seller_details`
--
ALTER TABLE `users_seller_details`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
