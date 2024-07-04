-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 04, 2024 at 05:36 PM
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
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `aboutus`
--

CREATE TABLE `aboutus` (
  `about_us_id` int(11) NOT NULL,
  `about_us_logo` varchar(500) NOT NULL,
  `about_us_short_description` varchar(500) NOT NULL,
  `about_us_long_description` varchar(1000) NOT NULL,
  `about_us_main_img` varchar(1000) NOT NULL,
  `about_us_video_images` varchar(1000) NOT NULL,
  `about_us_video` varchar(10000) NOT NULL,
  `about_us_video_description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `banner_name` varchar(500) NOT NULL,
  `banner_type` varchar(500) NOT NULL,
  `banner_status` tinyint(4) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(500) NOT NULL,
  `images` varchar(10000) NOT NULL,
  `categories_status` tinyint(4) NOT NULL,
  `isdisplayhome` tinyint(4) NOT NULL,
  `meta_title` varchar(500) NOT NULL,
  `meta_keyword` varchar(500) NOT NULL,
  `meta_description` varchar(500) NOT NULL,
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `get_in_touch`
--

CREATE TABLE `get_in_touch` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `sku` varchar(500) NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `special_price` decimal(10,2) NOT NULL,
  `product_main_image` varchar(500) NOT NULL,
  `product_description` text NOT NULL,
  `product_availble_status` varchar(500) NOT NULL,
  `related_products_id` varchar(500) NOT NULL,
  `product_status` tinyint(4) NOT NULL,
  `isdisplayhome` tinyint(4) NOT NULL,
  `meta_title` varchar(500) NOT NULL,
  `meta_keyword` varchar(500) NOT NULL,
  `meta_description` varchar(500) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `sku`, `mrp_price`, `special_price`, `product_main_image`, `product_description`, `product_availble_status`, `related_products_id`, `product_status`, `isdisplayhome`, `meta_title`, `meta_keyword`, `meta_description`, `added_on`, `updated_on`) VALUES
(1, 'abc', 'abc', 11.11, 10.92, 'avatar-1.jpg', '<p>test</p>', 'In Stock', '1', 1, 1, 'text', 'text', '<p>text,jhgjfdshj</p>', '2024-07-02 20:29:20', '2024-07-02 20:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `product_multiple_images`
--

CREATE TABLE `product_multiple_images` (
  `product_images_id` int(11) NOT NULL,
  `product_main_id` int(11) DEFAULT NULL,
  `product_image` varchar(1000) NOT NULL,
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_multiple_images`
--

INSERT INTO `product_multiple_images` (`product_images_id`, `product_main_id`, `product_image`, `added_on`, `update_on`) VALUES
(1, 1, 'avatar-1.jpg', '2024-07-02 20:29:20', '2024-07-02 20:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `sitesetting`
--

CREATE TABLE `sitesetting` (
  `id` int(11) NOT NULL,
  `site_name` varchar(500) NOT NULL,
  `site_tag_name` varchar(500) NOT NULL,
  `mobile_number` varchar(500) NOT NULL,
  `whatsapp_number` varchar(500) NOT NULL,
  `frist_email` varchar(500) NOT NULL,
  `second_email` varchar(500) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `header_site_logo` varchar(500) NOT NULL,
  `footer_site_logo` varchar(500) NOT NULL,
  `meta_title` varchar(500) NOT NULL,
  `meta_keyword` varchar(500) NOT NULL,
  `meta_description` varchar(500) NOT NULL,
  `instagram_link` varchar(500) NOT NULL,
  `facebook_link` varchar(500) NOT NULL,
  `twitter_link` varchar(500) NOT NULL,
  `youtube_link` varchar(500) NOT NULL,
  `google_link` varchar(500) NOT NULL,
  `google_map_link` varchar(500) NOT NULL,
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sitesetting`
--

INSERT INTO `sitesetting` (`id`, `site_name`, `site_tag_name`, `mobile_number`, `whatsapp_number`, `frist_email`, `second_email`, `address`, `header_site_logo`, `footer_site_logo`, `meta_title`, `meta_keyword`, `meta_description`, `instagram_link`, `facebook_link`, `twitter_link`, `youtube_link`, `google_link`, `google_map_link`, `added_on`, `update_on`) VALUES
(1, 'abc', 'abc', '9876543210', '9876543210', 'meghana@gmail.com', 'meghana@gmail.com', '1234', 'avatar-1.jpg', 'avatar-1.jpg', 'abc', 'abc`', 'abc', 'https://instagram.com', 'https://facebook.com', 'https://twitter.com', 'https://youtube.com', 'https://google.com', 'https://google.com', '2024-06-29 15:24:47', '2024-06-29 15:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `sub_categories_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories_name` varchar(500) NOT NULL,
  `sub_categories_images` varchar(10000) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `meta_title` varchar(500) NOT NULL,
  `meta_keyword` varchar(500) NOT NULL,
  `meta_description` varchar(500) NOT NULL,
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `mobile_no` varchar(1000) NOT NULL,
  `wp_mobile_no` varchar(1000) NOT NULL,
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `username`, `email`, `password`, `mobile_no`, `wp_mobile_no`, `added_on`, `update_on`) VALUES
(1, 'meghana', 'meghana@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '9876543210', '9876543210', '2024-06-29 11:36:39', '2024-06-29 11:36:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aboutus`
--
ALTER TABLE `aboutus`
  ADD PRIMARY KEY (`about_us_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `get_in_touch`
--
ALTER TABLE `get_in_touch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_multiple_images`
--
ALTER TABLE `product_multiple_images`
  ADD PRIMARY KEY (`product_images_id`);

--
-- Indexes for table `sitesetting`
--
ALTER TABLE `sitesetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`sub_categories_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aboutus`
--
ALTER TABLE `aboutus`
  MODIFY `about_us_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `get_in_touch`
--
ALTER TABLE `get_in_touch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_multiple_images`
--
ALTER TABLE `product_multiple_images`
  MODIFY `product_images_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sitesetting`
--
ALTER TABLE `sitesetting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `sub_categories_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
