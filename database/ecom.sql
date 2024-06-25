-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 25, 2024 at 07:50 PM
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

--
-- Dumping data for table `aboutus`
--

INSERT INTO `aboutus` (`about_us_id`, `about_us_logo`, `about_us_short_description`, `about_us_long_description`, `about_us_main_img`, `about_us_video_images`, `about_us_video`, `about_us_video_description`) VALUES
(1, '', 'sdfghjkl;\'kjhg', 'fghjkljhgvb', 'avatar-6.jpg', 'avatar-1.jpg', 'file_example_MP4_640_3MG.mp4', 'fghjkl;\'lkjhg');

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
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `images`, `categories_status`, `isdisplayhome`, `added_on`, `update_on`) VALUES
(1, 'Man', '../media/avatar-1.jpg', 1, 1, '2024-06-19 20:30:21', '2024-06-24 20:35:49'),
(2, 'Women', 'avatar-1.jpg', 1, 0, '2024-06-19 22:28:15', '2024-06-24 20:48:17'),
(3, 'ABC', '../media/avatar-6.jpg', 1, 0, '2024-06-25 22:35:04', '2024-06-25 22:35:04');

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
  `google_link` varchar(500) NOT NULL,
  `google_map_link` varchar(500) NOT NULL,
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sitesetting`
--

INSERT INTO `sitesetting` (`id`, `site_name`, `site_tag_name`, `mobile_number`, `whatsapp_number`, `frist_email`, `second_email`, `address`, `header_site_logo`, `footer_site_logo`, `meta_title`, `meta_keyword`, `meta_description`, `instagram_link`, `facebook_link`, `twitter_link`, `google_link`, `google_map_link`, `added_on`, `update_on`) VALUES
(1, 'abc1234', 'abc1', '9876543210', '9876543210', 'abc@gmail.com', 'abc@gmail.com', 'adfgasdgadg', 'avatar-6.jpg', 'avatar-6.jpg', 'asdgsdfg', 'aseasdg', 'asdfasdfasdf', 'https://instagram.com', 'https://facebook.com', 'https://twitter.com', 'https://google.com', 'htttps://google.map.com', '2024-06-20 18:27:07', '2024-06-24 22:48:16');

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
  `added_on` datetime NOT NULL,
  `update_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`sub_categories_id`, `categories_id`, `sub_categories_name`, `sub_categories_images`, `status`, `added_on`, `update_on`) VALUES
(1, 2, 'women_new', '', 1, '2024-06-24 23:16:17', '2024-06-24 23:16:17'),
(2, 2, 'w1', '../media/subcategories/avatar-1.jpg', 1, '2024-06-24 23:17:04', '2024-06-24 23:17:04');

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
(1, 'Meghana', 'meghana@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8160598689', '8160598689', '2024-06-18 10:36:22', '2024-06-18 10:36:22');

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
  MODIFY `about_us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sitesetting`
--
ALTER TABLE `sitesetting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `sub_categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
