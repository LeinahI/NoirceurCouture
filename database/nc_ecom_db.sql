-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2024 at 07:38 AM
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
  `address_isDefault` tinyint(1) NOT NULL DEFAULT 0,
  `address_fullName` varchar(254) DEFAULT NULL,
  `address_email` varchar(254) DEFAULT NULL,
  `address_phone` varchar(11) DEFAULT NULL,
  `address_region` varchar(254) DEFAULT NULL,
  `address_province` varchar(254) DEFAULT NULL,
  `address_city` varchar(254) DEFAULT NULL,
  `address_barangay` varchar(254) DEFAULT NULL,
  `address_fullAddress` mediumtext DEFAULT NULL,
  `address_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `address_user_ID`, `address_isDefault`, `address_fullName`, `address_email`, `address_phone`, `address_region`, `address_province`, `address_city`, `address_barangay`, `address_fullAddress`, `address_createdAt`) VALUES
(37, 92, 0, 'Sammy', 'sam@gmail.com', '09465465465', '04', '0421', '042101', '042101007', 'taga alfo', '2024-02-04 11:27:25'),
(59, 90, 1, 'beyabadubi', 'beya@gmail.com', '09342342424', '04', '0410', '041031', '041031001', 'batangs', '2024-02-07 22:27:00'),
(62, 93, 0, 'Hev Abi', 'hev@gmail.com', '09654564564', '13', '1374', '137404', '137404022', '1103 hev abi', '2024-02-09 12:11:05'),
(80, 105, 1, 'Jane Doe', 'janedoe@gmail.com', '09564654465', '04', '0410', '041005', '041005003', 'batangs', '2024-02-15 05:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `category_id` int(8) NOT NULL,
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
  `category_onVacation` tinyint(1) NOT NULL DEFAULT 0,
  `category_image` varchar(300) NOT NULL,
  `category_meta_title` varchar(254) NOT NULL,
  `category_meta_description` mediumtext NOT NULL,
  `category_isBan` tinyint(1) NOT NULL,
  `category_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_user_ID`, `category_name`, `category_slug`, `category_description`, `category_onVacation`, `category_image`, `category_meta_title`, `category_meta_description`, `category_isBan`, `category_createdAt`) VALUES
(94, 92, 'Haters of Letterboxd: Golagat Edition', 'hatersofletterboxdgolagatedition', 'film page para sa tagalog, bisaya atbp.', 0, 'holge-02-02-2024-22-10-16.jpg', 'Haters of Letterboxd: Golagat Edition ', 'film page para sa tagalog, bisaya atbp.', 0, '2024-02-02 14:10:16'),
(95, 93, 'Grasya Worldwide', 'grasyaworldwide', 'asdasdad', 0, 'grasyaworldwide-02-03-2024-16-22-53.jpg', 'Grasya Worldwide', 'asdasdad', 0, '2024-02-03 08:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `categories_banned`
--

CREATE TABLE `categories_banned` (
  `categBan_id` int(8) NOT NULL,
  `categBan_category_id` int(8) NOT NULL,
  `categBan_userID` int(8) NOT NULL,
  `categBan_CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories_deleted_details`
--

CREATE TABLE `categories_deleted_details` (
  `cd_ID` int(8) NOT NULL,
  `cd_category_id` int(8) NOT NULL,
  `cd_user_ID` int(8) NOT NULL,
  `cd_category_name` varchar(254) NOT NULL,
  `cd_image` varchar(300) NOT NULL,
  `cd_confirmed` tinyint(1) DEFAULT NULL,
  `cd_reqCreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories_deleted_details`
--

INSERT INTO `categories_deleted_details` (`cd_ID`, `cd_category_id`, `cd_user_ID`, `cd_category_name`, `cd_image`, `cd_confirmed`, `cd_reqCreatedAt`) VALUES
(13, 93, 88, 'Holge', '', NULL, '2024-01-31 11:15:17'),
(15, 94, 92, 'Haters of Letterboxd: Golagat Edition', '', NULL, '2024-02-15 06:14:03');

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
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notif_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `notif_Header` varchar(255) NOT NULL,
  `notif_Body` varchar(600) NOT NULL,
  `notif_CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notif_id`, `sender_id`, `receiver_id`, `notif_Header`, `notif_Body`, `notif_CreatedAt`) VALUES
(8, 1, 92, 'Unfulfilled Orders or Pending Transactions', 'You have pending orders or transactions that have not been completed. The Seller and Noirceur Couture need to resolve these before deleting your account.', '2024-02-15 06:14:27');

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
  `orders_region` varchar(254) NOT NULL,
  `orders_province` varchar(254) NOT NULL,
  `orders_city` varchar(254) NOT NULL,
  `orders_barangay` varchar(254) NOT NULL,
  `orders_total_price` decimal(10,2) NOT NULL,
  `orders_payment_mode` varchar(254) NOT NULL,
  `orders_payment_id` varchar(30) NOT NULL,
  `orders_status` tinyint(4) NOT NULL DEFAULT 0,
  `orders_cancel_reason` tinyint(2) DEFAULT NULL,
  `orders_last_update_time` datetime NOT NULL DEFAULT current_timestamp(),
  `orders_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_tracking_no`, `orders_user_ID`, `orders_full_name`, `orders_email`, `orders_phone`, `orders_address`, `orders_region`, `orders_province`, `orders_city`, `orders_barangay`, `orders_total_price`, `orders_payment_mode`, `orders_payment_id`, `orders_status`, `orders_cancel_reason`, `orders_last_update_time`, `orders_createdAt`) VALUES
(155, 'nrcrCtr3423424242097', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'Ligaya Drive', '04', '0410', '041031', '041031001', 500.00, 'Cash on Delivery', 'COD3624463', 3, 1, '2024-02-13 10:25:44', '2024-02-13 02:24:15'),
(156, 'nrcrCtr3423424249817', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'Ligaya Drive', '04', '0410', '041031', '041031001', 500.00, 'Cash on Delivery', 'COD8949529', 2, NULL, '2024-02-13 10:32:35', '2024-02-13 02:26:46'),
(157, 'nrcrCtr3423424245060', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'Ligaya Drive', '04', '0410', '041031', '041031001', 500.00, 'Paypal', '4MC06644TJ7360544', 2, NULL, '2024-02-13 20:33:01', '2024-02-13 12:32:38'),
(158, 'nrcrCtr3423424246099', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'Ligaya Drive', '04', '0410', '041031', '041031001', 500.00, 'Cash on Delivery', '', 3, NULL, '2024-02-13 22:02:51', '2024-02-13 14:02:16'),
(159, 'nrcrCtr3423424246169', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'Ligaya Drive', '04', '0410', '041031', '041031001', 642.20, 'Paypal', '0BT80613TJ156604Y', 2, NULL, '2024-02-13 22:14:08', '2024-02-13 14:13:30'),
(160, 'nrcrCtr3423424247522', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'Ligaya Drive', '04', '0410', '041031', '041031001', 500.00, 'Cash on Delivery', '', 2, NULL, '2024-02-14 10:59:16', '2024-02-14 02:47:54'),
(162, 'nrcrCtr6546546568021', 103, 'Jane Doe', 'janedoe@gmail.com', '09654654656', 'ewan', '01', '0128', '012812', '012812074', 560.00, 'Cash on Delivery', 'COD7822269', 2, NULL, '2024-02-14 17:13:37', '2024-02-14 09:13:14'),
(163, 'nrcrCtr3423424249798', 90, 'beyabadubi', 'beya@gmail.com', '09342342424', 'batangs', '04', '0410', '041031', '041031001', 560.00, 'Cash on Delivery', '', 3, 2, '2024-02-15 14:21:32', '2024-02-15 06:21:13');

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
(201, 155, 123, 1, 500.00, '2024-02-13 02:24:15'),
(202, 156, 123, 1, 500.00, '2024-02-13 02:26:46'),
(203, 157, 123, 1, 500.00, '2024-02-13 12:32:38'),
(204, 158, 123, 1, 500.00, '2024-02-13 14:02:16'),
(205, 159, 126, 1, 304.20, '2024-02-13 14:13:30'),
(206, 159, 125, 1, 338.00, '2024-02-13 14:13:30'),
(207, 160, 123, 1, 500.00, '2024-02-14 02:47:54'),
(208, 161, 122, 1, 560.00, '2024-02-14 07:02:49'),
(209, 162, 122, 1, 560.00, '2024-02-14 09:13:14'),
(210, 163, 122, 1, 560.00, '2024-02-15 06:21:13');

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
  `product_visibility` tinyint(1) NOT NULL DEFAULT 0,
  `product_popular` tinyint(4) NOT NULL,
  `product_meta_title` varchar(254) NOT NULL,
  `product_meta_description` mediumtext NOT NULL,
  `product_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_slug`, `product_description`, `product_original_price`, `product_discount`, `product_srp`, `product_image`, `product_qty`, `product_visibility`, `product_popular`, `product_meta_title`, `product_meta_description`, `product_createdAt`) VALUES
(122, 94, 'Maganda cinematography', 'magandacinematography', 'ewan ko', 560.00, 0, 560.00, 'magandacinematography-02-02-2024-22-10-35.jpg', 3, 0, 1, 'Maganda cinematography', 'ewan ko', '2024-02-02 14:10:35'),
(123, 94, 'worst person', 'worstperson', 'taga cavite', 500.00, 0, 500.00, 'worstperson-02-02-2024-22-19-57.jpg', 1, 0, 1, 'worst person', 'taga cavite', '2024-02-02 14:19:57'),
(125, 95, 'pretty girls love hustters', 'prettygirlslovehustters', 'Grasya pretty girls love hustters', 338.00, 0, 338.00, 'prettygirlslovehustters-02-09-2024-20-15-39.png', 4, 0, 1, 'pretty girls love hustters', 'Grasya pretty girls love hustters', '2024-02-09 12:15:39'),
(126, 95, 'bad child', 'badchild', 'grasya bad child', 338.00, 10, 304.20, 'badchild-02-09-2024-20-17-50.png', 4, 0, 1, 'bad child', 'grasya bad child', '2024-02-09 12:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `products_deleted_details`
--

CREATE TABLE `products_deleted_details` (
  `pd_ID` int(8) NOT NULL,
  `pd_product_id` int(8) NOT NULL,
  `pd_category_id` int(8) NOT NULL,
  `pd_product_name` varchar(254) NOT NULL,
  `pd_original_price` decimal(10,2) NOT NULL,
  `pd_product_discount` int(2) NOT NULL,
  `pd_srp` decimal(10,2) NOT NULL,
  `pd_image` varchar(300) DEFAULT NULL,
  `pd_confirmed` tinyint(1) DEFAULT NULL,
  `pd_reqCreatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_reviews`
--

CREATE TABLE `products_reviews` (
  `review_id` int(11) NOT NULL,
  `orders_tracking_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `product_rating` int(1) NOT NULL,
  `product_review` varchar(600) NOT NULL,
  `seller_review` varchar(600) NOT NULL,
  `review_isReviewed` int(1) NOT NULL DEFAULT 0,
  `review_editCount` int(1) NOT NULL DEFAULT 0,
  `review_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_reviews`
--

INSERT INTO `products_reviews` (`review_id`, `orders_tracking_no`, `product_id`, `user_ID`, `product_rating`, `product_review`, `seller_review`, `review_isReviewed`, `review_editCount`, `review_createdAt`) VALUES
(11, 'nrcrCtr3423424249817', 123, 90, 5, 'galing TANGINA!', '', 1, 0, '2024-02-13 11:12:40'),
(12, 'nrcrCtr3423424245060', 123, 90, 4, 'hahahaha ewan ko part 2', '', 1, 2, '2024-02-13 12:33:18'),
(13, 'nrcrCtr3423424246169', 125, 90, 4, 'angas nina Demi at Stan e', '', 1, 0, '2024-02-13 14:48:01'),
(14, 'nrcrCtr3423424246169', 126, 90, 3, 'masamang anak e ampota AHAHAHA', '', 1, 2, '2024-02-13 14:49:55'),
(16, 'nrcrCtr6546546568021', 122, 103, 5, 'goods pre hehehehe', '', 1, 0, '2024-02-14 09:13:59');

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
(16, 94, '02-14-2024-14-05-48.png', '2024-02-14 06:04:20'),
(17, 95, '95-02-14-2024-14-06-13.png', '2024-02-14 06:06:13');

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
  `user_profile_image` varchar(300) NOT NULL,
  `user_role` tinyint(1) NOT NULL DEFAULT 0,
  `user_isBan` tinyint(1) NOT NULL DEFAULT 0,
  `user_accCreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `user_firstName`, `user_lastName`, `user_email`, `user_phone`, `user_username`, `user_password`, `user_profile_image`, `user_role`, `user_isBan`, `user_accCreatedAt`) VALUES
(1, 'Shinji', 'Kirigoe', 'shinji@gmail.com', '09152844036', 'nath123', 'P>E]hM?:u)&7g^R', '', 1, 0, '2023-06-06 06:11:49'),
(90, 'Beya', 'Badubi', 'beya@gmail.com', '09565456465', 'beya', 'ana123', 'profile_90_02-14-2024-07-55-28.png', 0, 0, '2024-02-02 08:23:30'),
(92, 'Sam', 'Mmy', 'sam@gmail.com', '09565656565', 'sammy12', 'zuD!X2', '', 2, 0, '2024-02-02 10:25:56'),
(93, 'twiceyy', 'sana', 'tzuyutwiceyy@gmail.com', '09546465465', 'tzuyutwiceyy', 'pn$N!b!SQp9Mm$&', '', 2, 0, '2024-02-03 08:20:54'),
(105, 'Jane', 'Doe', 'janedoe@gmail.com', '09231231313', 'jane', 'Vj9}w*ZS+U_eq8t', '', 0, 0, '2024-02-15 04:09:35');

-- --------------------------------------------------------

--
-- Table structure for table `users_banned`
--

CREATE TABLE `users_banned` (
  `ban_id` int(8) NOT NULL,
  `ban_user_ID` int(8) NOT NULL,
  `ban_CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_deleted_details`
--

CREATE TABLE `users_deleted_details` (
  `ud_ID` int(8) NOT NULL,
  `ud_user_ID` int(8) NOT NULL,
  `ud_firstName` varchar(80) NOT NULL,
  `ud_lastName` varchar(80) NOT NULL,
  `ud_email` varchar(254) NOT NULL,
  `ud_phone` varchar(11) NOT NULL,
  `ud_username` varchar(50) NOT NULL,
  `ud_password` varchar(128) NOT NULL,
  `ud_role` tinyint(1) NOT NULL,
  `ud_reason` varchar(128) NOT NULL,
  `ud_details` varchar(300) DEFAULT '*NONE*',
  `ud_confirmed` tinyint(1) DEFAULT 0,
  `ud_reqCreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_deleted_details`
--

INSERT INTO `users_deleted_details` (`ud_ID`, `ud_user_ID`, `ud_firstName`, `ud_lastName`, `ud_email`, `ud_phone`, `ud_username`, `ud_password`, `ud_role`, `ud_reason`, `ud_details`, `ud_confirmed`, `ud_reqCreatedAt`) VALUES
(54, 104, 'Jane', 'Doe', 'janedoe@gmail.com', '09231231313', 'jane', 'Vj9}w*ZS+U_eq8t', 0, 'Others', 'bounce na', 1, '2024-02-14 16:09:25');

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
(20, 92, 'individual', 1, '2024-02-02 10:25:56'),
(21, 93, 'individual', 1, '2024-02-03 08:20:54');

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
-- Indexes for table `categories_banned`
--
ALTER TABLE `categories_banned`
  ADD PRIMARY KEY (`categBan_id`);

--
-- Indexes for table `categories_deleted_details`
--
ALTER TABLE `categories_deleted_details`
  ADD PRIMARY KEY (`cd_ID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likes_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notif_id`);

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
-- Indexes for table `products_deleted_details`
--
ALTER TABLE `products_deleted_details`
  ADD PRIMARY KEY (`pd_ID`);

--
-- Indexes for table `products_reviews`
--
ALTER TABLE `products_reviews`
  ADD PRIMARY KEY (`review_id`);

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
-- Indexes for table `users_banned`
--
ALTER TABLE `users_banned`
  ADD PRIMARY KEY (`ban_id`);

--
-- Indexes for table `users_deleted_details`
--
ALTER TABLE `users_deleted_details`
  ADD PRIMARY KEY (`ud_ID`);

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=509;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `categories_banned`
--
ALTER TABLE `categories_banned`
  MODIFY `categBan_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories_deleted_details`
--
ALTER TABLE `categories_deleted_details`
  MODIFY `cd_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItems_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `products_deleted_details`
--
ALTER TABLE `products_deleted_details`
  MODIFY `pd_ID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_reviews`
--
ALTER TABLE `products_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `ss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `users_banned`
--
ALTER TABLE `users_banned`
  MODIFY `ban_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users_deleted_details`
--
ALTER TABLE `users_deleted_details`
  MODIFY `ud_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users_seller_details`
--
ALTER TABLE `users_seller_details`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
