-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2025 at 07:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swamy`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `about_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `image_url`, `about_text`, `created_at`) VALUES
(1, 'uploads/3.png', 'sgfxfgxgfx', '2024-07-28 14:28:26'),
(2, 'uploads/back.jpg', 'Sample Text Data new', '2024-07-29 17:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `imei_no` varchar(100) DEFAULT NULL,
  `device_issue` varchar(255) DEFAULT NULL,
  `issue` varchar(255) DEFAULT NULL,
  `service_location` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `next_booking_date` date DEFAULT NULL,
  `next_booking_time` time DEFAULT NULL,
  `device` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`) VALUES
(0, 'Black'),
(0, 'Grey'),
(0, 'Display White'),
(0, 'Display Black'),
(0, 'Battery'),
(0, 'Charging port'),
(0, 'Ear Speaker'),
(0, 'Sensor strip'),
(0, 'Loudspeaker'),
(0, 'Back Body'),
(0, 'Home Button'),
(0, 'Rear Camera'),
(0, 'Front Camera'),
(0, 'Mother Board Service'),
(0, 'Back Glass'),
(0, 'Side Frame');

-- --------------------------------------------------------

--
-- Table structure for table `covers`
--

CREATE TABLE `covers` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `tagline` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cover_photos`
--

CREATE TABLE `cover_photos` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_categories`
--

CREATE TABLE `device_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_categories`
--

INSERT INTO `device_categories` (`id`, `category_name`) VALUES
(16, 'Ipad'),
(17, 'MacBook');

-- --------------------------------------------------------

--
-- Table structure for table `device_models`
--

CREATE TABLE `device_models` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `model_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_models`
--

INSERT INTO `device_models` (`id`, `category_id`, `model_name`) VALUES
(429, 16, 'ipad 1st gen'),
(430, 16, 'ipad 2st gen'),
(431, 17, 'Charger'),
(432, 17, 'Charger1');

-- --------------------------------------------------------

--
-- Table structure for table `device_services`
--

CREATE TABLE `device_services` (
  `id` int(11) NOT NULL,
  `job_id` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `imei_no` varchar(50) DEFAULT NULL,
  `screen_damage` text DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `rupees_in_words` varchar(200) DEFAULT NULL,
  `advance` decimal(10,2) DEFAULT NULL,
  `remaining` decimal(10,2) DEFAULT NULL,
  `home_button` varchar(5) DEFAULT NULL,
  `home_button_sensor` varchar(5) DEFAULT NULL,
  `power_button` varchar(5) DEFAULT NULL,
  `volume_button` varchar(5) DEFAULT NULL,
  `ear_speaker` varchar(5) DEFAULT NULL,
  `face_id` varchar(5) DEFAULT NULL,
  `battery` varchar(5) DEFAULT NULL,
  `sensor` varchar(5) DEFAULT NULL,
  `front_camera` varchar(5) DEFAULT NULL,
  `back_camera` varchar(5) DEFAULT NULL,
  `wifi` varchar(5) DEFAULT NULL,
  `mike` varchar(5) DEFAULT NULL,
  `charging` varchar(5) DEFAULT NULL,
  `loud_speaker` varchar(5) DEFAULT NULL,
  `audio_video_sound` varchar(5) DEFAULT NULL,
  `torch` varchar(5) DEFAULT NULL,
  `back_glass` varchar(5) DEFAULT NULL,
  `scratch_or_dent` varchar(5) DEFAULT NULL,
  `body_bend` varchar(5) DEFAULT NULL,
  `bottom_screw` varchar(5) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `battery_percentage` varchar(50) DEFAULT NULL,
  `deadcheckbox` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_spares`
--

CREATE TABLE `device_spares` (
  `id` int(11) NOT NULL,
  `spare_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_spares`
--

INSERT INTO `device_spares` (`id`, `spare_name`, `category_id`, `created_at`) VALUES
(1, 'Screen Guard', 16, '2025-08-03 21:42:38'),
(2, 'Pouch', 16, '2025-08-03 21:42:49'),
(3, 'Screen', 17, '2025-08-03 21:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `device_stockmodels`
--

CREATE TABLE `device_stockmodels` (
  `id` int(11) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `spare_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `price` decimal(10,2) DEFAULT 0.00,
  `purchased_price` decimal(10,2) DEFAULT 0.00,
  `category_id` int(11) NOT NULL,
  `party_id` int(11) DEFAULT NULL,
  `outstanding_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `shipping` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_mode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `itemname` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_gift` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `model_id` int(11) NOT NULL,
  `model_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `pay_amount` decimal(10,2) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `id` int(11) NOT NULL,
  `companyname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(50) DEFAULT NULL,
  `itemname` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `servicecharge` varchar(50) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `tax` varchar(50) DEFAULT NULL,
  `taxrate` varchar(50) DEFAULT NULL,
  `shipping` varchar(50) DEFAULT NULL,
  `termscheckbox` tinyint(1) DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_categories`
--

CREATE TABLE `stock_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_parties`
--

CREATE TABLE `stock_parties` (
  `id` int(11) NOT NULL,
  `party_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_parties`
--

INSERT INTO `stock_parties` (`id`, `party_name`) VALUES
(26, 'Gachibowli 2'),
(27, 'MM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'admin@admin.com', 'Admin@123', '2024-07-27 17:24:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `covers`
--
ALTER TABLE `covers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cover_photos`
--
ALTER TABLE `cover_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_categories`
--
ALTER TABLE `device_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_models`
--
ALTER TABLE `device_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `device_services`
--
ALTER TABLE `device_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_spares`
--
ALTER TABLE `device_spares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `device_stockmodels`
--
ALTER TABLE `device_stockmodels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stockmodels_category` (`category_id`),
  ADD KEY `fk_stockmodels_party` (`party_id`),
  ADD KEY `fk_spare_id` (`spare_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_categories`
--
ALTER TABLE `stock_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `stock_parties`
--
ALTER TABLE `stock_parties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `party_name` (`party_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_categories`
--
ALTER TABLE `device_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `device_models`
--
ALTER TABLE `device_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=433;

--
-- AUTO_INCREMENT for table `device_services`
--
ALTER TABLE `device_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_spares`
--
ALTER TABLE `device_spares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `device_stockmodels`
--
ALTER TABLE `device_stockmodels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_categories`
--
ALTER TABLE `stock_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stock_parties`
--
ALTER TABLE `stock_parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `device_models`
--
ALTER TABLE `device_models`
  ADD CONSTRAINT `device_models_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `device_categories` (`id`);

--
-- Constraints for table `device_spares`
--
ALTER TABLE `device_spares`
  ADD CONSTRAINT `device_spares_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `device_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `device_stockmodels`
--
ALTER TABLE `device_stockmodels`
  ADD CONSTRAINT `fk_spare_id` FOREIGN KEY (`spare_id`) REFERENCES `device_spares` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
