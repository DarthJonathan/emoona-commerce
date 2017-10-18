-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 18, 2017 at 03:48 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emoona_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `item_detail_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `valid_until` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `hidden` int(11) NOT NULL,
  `preorder` int(11) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `name`, `sku`, `description`, `price`, `hidden`, `preorder`, `created_at`, `updated_at`) VALUES
(1, 1, 'Apel', 'AP001', 'Apel is a fruitaaaa', 13000, 0, 1, '2017-09-22', '2017-10-02'),
(16, 1, 'Kentang', 'KT-199', 'asdasdasd', 1000, 0, 0, '2017-09-30', '2017-09-30'),
(17, 1, 'Bryan', 'BRY1000', 'kentang apel dufan', 1000, 0, 0, '2017-10-02', '2017-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `name`, `description`, `gender`) VALUES
(1, 'Fruits', 'Its edible', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `item_detail`
--

CREATE TABLE `item_detail` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_detail`
--

INSERT INTO `item_detail` (`id`, `item_id`, `color`, `size`, `images`, `stock`, `status`, `updated_at`, `created_at`) VALUES
(34, 1, 'blue', 'L', '1.150703758259d3918e01d1a', 100, 'available', '2017-10-03', '2017-10-03'),
(35, 16, 'Black', 'L', '16.150798111359e1f73927cf8', 100, 'available', '2017-10-14', '2017-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `item_notify`
--

CREATE TABLE `item_notify` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_studio`
--

CREATE TABLE `item_studio` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `files` varchar(255) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `blasted_date` date NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`id`, `name`) VALUES
(1, 'Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `minimum` double DEFAULT NULL,
  `amount` double NOT NULL,
  `created` date NOT NULL,
  `valid_until` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sign_up_participant`
--

CREATE TABLE `sign_up_participant` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sign_up_participant`
--

INSERT INTO `sign_up_participant` (`id`, `email`, `hash`, `created`) VALUES
(3, 'gitaandreina@ymail.com', 'f13a76b2d04edbbda9da70a433d15ff7', '2017-09-18'),
(4, 'reii_chan723@ymail.com', '7733e42be12b56a4b08ee1489baa7774', '2017-09-18'),
(5, 'michellevinnetan@gmail.com', NULL, '2017-09-18'),
(6, 'rxzraiser@gmail.com', NULL, '2017-09-18'),
(7, 'gitaandreina@gmail.com', NULL, '2017-09-18'),
(9, 'sharonputri27@gmail.com', NULL, '2017-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `studio_category`
--

CREATE TABLE `studio_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `template` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL,
  `priority` int(10) NOT NULL DEFAULT '0',
  `completed` date DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `category`, `priority`, `completed`, `created_at`, `updated_at`) VALUES
(2, 'Kentang', 'APel', 0, NULL, '2017-10-11', '2017-10-13'),
(3, 'Sudah Dikirim', 'STUFF', 0, NULL, '2017-10-18', '2017-10-18'),
(4, 'Sudah Dikirim', 'A', 0, NULL, '2017-10-18', '2017-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_detail`
--

CREATE TABLE `tickets_detail` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `additionals` text,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets_detail`
--

INSERT INTO `tickets_detail` (`id`, `ticket_id`, `text`, `additionals`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dufan', NULL, '2017-10-11', '2017-10-11'),
(2, 2, 'Kentang', NULL, '2017-10-12', '2017-10-12'),
(3, 2, 'Kiki', NULL, '2017-10-12', '2017-10-12'),
(4, 2, 'APEL', NULL, '2017-10-12', '2017-10-12'),
(5, 2, 'BLA', NULL, '2017-10-12', '2017-10-12'),
(6, 2, 'BLUE', NULL, '2017-10-12', '2017-10-12'),
(7, 2, 'Kentang', NULL, '2017-10-12', '2017-10-12'),
(8, 2, 'KULLITTTT', NULL, '2017-10-12', '2017-10-12'),
(9, 2, 'Kentang', NULL, '2017-10-12', '2017-10-12'),
(10, 2, 'Jeffry', NULL, '2017-10-12', '2017-10-12'),
(11, 2, 'asdasdasdasd', NULL, '2017-10-12', '2017-10-12'),
(12, 2, 'aaaaaaaa', NULL, '2017-10-12', '2017-10-12'),
(13, 2, 'asdasdasdasd', NULL, '2017-10-12', '2017-10-12'),
(14, 2, 'adlkfjhnisvgukvdnjkbfhs', NULL, '2017-10-12', '2017-10-12'),
(15, 2, 'Ridzky', NULL, '2017-10-12', '2017-10-12'),
(16, 2, 'asdasdasd', NULL, '2017-10-12', '2017-10-12'),
(17, 2, 'aaaaaaa', NULL, '2017-10-12', '2017-10-12'),
(18, 2, 'asdasdasdasdasd', NULL, '2017-10-12', '2017-10-12'),
(19, 2, 'asdasdasdasdasdasdasdxxxxxxx', NULL, '2017-10-12', '2017-10-12'),
(20, 2, 'xxxxxxxxxx', NULL, '2017-10-12', '2017-10-12'),
(21, 2, 'zzzzzzzz', NULL, '2017-10-12', '2017-10-12'),
(22, 2, 'yyyyyyyyyyy', NULL, '2017-10-12', '2017-10-12'),
(23, 2, 'qqqqqqqqqqq', NULL, '2017-10-12', '2017-10-12'),
(24, 2, 'DAVID', NULL, '2017-10-12', '2017-10-12'),
(25, 3, 'SUDAH DI KRIM PAK', NULL, '2017-10-18', '2017-10-18'),
(26, 4, 'Sudah DI kirm', NULL, '2017-10-18', '2017-10-18'),
(27, 4, 'Siap', NULL, '2017-10-18', '2017-10-18'),
(28, 3, 'KENTANG', NULL, '2017-10-18', '2017-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `notes` text,
  `transfer_proof` varchar(255) DEFAULT NULL,
  `shipping_codes` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL,
  `finished_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `payment_type_id`, `status`, `notes`, `transfer_proof`, `shipping_codes`, `created_at`, `finished_at`, `updated_at`) VALUES
(1, 22, 1, 0, 'asdasdasd', NULL, '', '2017-09-08', '0000-00-00', NULL),
(2, 22, 1, 3, 'Kentnag', NULL, 'LLLL', '2017-09-08', NULL, '2017-10-12'),
(3, 22, 1, 2, 'Kentng Apel Dufan', '123123.jpg', '', '2017-10-05', NULL, NULL),
(4, 22, 1, 3, 'Kentng Apel Dufan', '1231232.jpg', 'UUUU', '2017-10-05', NULL, NULL),
(10, 30, 1, 0, NULL, NULL, NULL, '2017-10-15', NULL, '2017-10-15'),
(11, 30, 1, 3, NULL, 'public/payment_verification/11/OW3xDEABfkExBslxev3r82PDRO6ndPKjd9LwNKZ6.jpeg', 'KENTANGAPELDUFAN', '2017-10-15', NULL, '2017-10-18'),
(12, 30, 1, 0, NULL, NULL, NULL, '2017-10-16', NULL, '2017-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE `transaction_detail` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_detail_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_detail`
--

INSERT INTO `transaction_detail` (`id`, `transaction_id`, `item_id`, `item_detail_id`, `quantity`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, 20, '0000-00-00', '0000-00-00'),
(4, 11, 1, 34, 1, '2017-10-15', '2017-10-15'),
(5, 12, 1, 34, 1, '2017-10-16', '2017-10-16'),
(6, 12, 16, 35, 1, '2017-10-16', '2017-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `activation_code`, `email`, `password`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(22, 'Jonathan', 'Hosea', NULL, 'jonathan.hosea@me.com', '$2y$10$6Xd3Y7E.CcYAsSsDbGD82eWDg2tmh31F.TfRSYiGK923eMENkT4ti', '2017-09-11 05:01:07', 'xdDo0FeD9FTgaV5kYElMkTVHqdxZ2D4a7WUNSskAmZq3QnP5CPuL21Kcu6FU', '2017-09-05 12:46:09', '2017-09-05 16:15:17'),
(24, 'Administrator', 'Admin', '150468752659afb5a698dc0', 'admin@admin.com', '$2y$10$awV4e.Kuz85DjE.jnx/Cz.EtIvxuYSZv8Wl0nDofqVcXkmPoOi5My', '2017-10-18 05:57:57', '4enGNpbvcoYOCHwhd6JxdQXHf6z8oPP96MASbKIDV5Oe5S28pFFXHO0rIDoP', '2017-09-05 18:45:26', '2017-09-05 18:45:26'),
(30, 'Jonathan', 'Hosea', NULL, 'zonecaptain@gmail.com', '$2y$10$uYlrGR8aPoq0iHXxKIADCelP3b1BNop47qFapxNg.5MAfLbYmtmCe', '2017-10-18 05:55:33', 'IIJyPEaISlyzAW9ItBO7oGhGV4lH9OOONwI1pecpFG55e1jZFqdPlI8CSpVb', '2017-09-25 05:31:12', '2017-09-25 05:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(7, 22, 2),
(8, 24, 1),
(13, 30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `suspended` int(11) DEFAULT NULL,
  `newsletter` int(11) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `address`, `postcode`, `province`, `country`, `birthday`, `phone`, `gender`, `suspended`, `newsletter`, `picture`) VALUES
(14, 22, 'Taman Pegangsaan Indah Blok D No 11', '14250', 'Jakarta', 'INA', '1997-04-03', '87875763570', 'male', 1, 0, NULL),
(15, 24, NULL, NULL, NULL, NULL, '1997-04-03', NULL, NULL, NULL, 0, NULL),
(20, 30, 'Taman Pegangsaan Indah Blok D No 11', '14250', 'Jakarta', 'INA', '1997-04-03', '087875763570', 'male', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_name` varchar(255) NOT NULL,
  `notification_url` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`id`, `user_id`, `notification_name`, `notification_url`, `created_at`, `updated_at`) VALUES
(3, 30, 'Transaction Number 10', '/transactions/10', '2017-10-15', '2017-10-15'),
(4, 30, 'Transaction Number 11', '/transactions/11', '2017-10-15', '2017-10-15'),
(5, 30, 'Transaction Number 12', '/transactions/12', '2017-10-16', '2017-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `webconfig`
--

CREATE TABLE `webconfig` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value_1` text NOT NULL,
  `value_2` text,
  `value_3` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_detail_id` (`item_detail_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_detail`
--
ALTER TABLE `item_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_notify`
--
ALTER TABLE `item_notify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_studio`
--
ALTER TABLE `item_studio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sign_up_participant`
--
ALTER TABLE `sign_up_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studio_category`
--
ALTER TABLE `studio_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_detail`
--
ALTER TABLE `tickets_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webconfig`
--
ALTER TABLE `webconfig`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `item_detail`
--
ALTER TABLE `item_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `item_studio`
--
ALTER TABLE `item_studio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sign_up_participant`
--
ALTER TABLE `sign_up_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `studio_category`
--
ALTER TABLE `studio_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tickets_detail`
--
ALTER TABLE `tickets_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `transaction_detail`
--
ALTER TABLE `transaction_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `webconfig`
--
ALTER TABLE `webconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
