-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 24, 2025 at 04:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `echofolk`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `admin_id`, `admin_name`, `action`, `description`, `created_at`) VALUES
(1, 9, 'root', 'export_generated', 'Admin generated a data export: approved_posts_2025-07-24_13-46-41.json.', '2025-07-24 11:46:41'),
(2, 9, 'root', 'user_deleted', 'Admin deleted user \'try3\' (ID: 16).', '2025-07-24 11:47:12'),
(3, 9, 'root', 'export_generated', 'Admin generated a data export: approved_posts_2025-07-24_13-49-04.json.', '2025-07-24 11:49:04'),
(4, 9, 'root', 'export_generated', 'Admin generated a data export: approved_posts_2025-07-24_14-03-30.json.', '2025-07-24 12:03:30'),
(5, 9, 'root', 'post_rejected', 'Admin rejected post \"ncnciea;lskdjf;iea;lskdjf;\" (ID: 13).', '2025-07-24 12:05:30'),
(6, 9, 'root', 'post_approved', 'Admin approved post \"hee\" (ID: 12).', '2025-07-24 12:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `message` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_name`, `message`, `image_path`, `created_at`) VALUES
(1, 'Bishal Poudel', 'hello i am bishal', NULL, '2025-07-20 13:08:27'),
(2, 'Bishal Poudel', NULL, 'uploads/img_687cea56994ba2.02028624.png', '2025-07-20 13:08:38'),
(3, 'try try', 'hello', 'uploads/img_687ceb622d0285.79663931.png', '2025-07-20 13:13:06'),
(4, 'try try', 'hi', NULL, '2025-07-20 13:13:17'),
(5, 'try try', 'hi', NULL, '2025-07-20 13:13:18'),
(6, 'try try', 'hi', NULL, '2025-07-20 13:13:19'),
(7, 'root', 'hello', NULL, '2025-07-23 07:37:19'),
(8, 'root', 'Hello name', NULL, '2025-07-24 11:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `format` varchar(10) DEFAULT NULL,
  `filter_used` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `exports`
--

INSERT INTO `exports` (`id`, `file_name`, `format`, `filter_used`, `file_size`, `created_at`) VALUES
(1, 'approved_posts_2025-07-24_12-46-08.json', 'JSON', 'approved', 345, '2025-07-24 12:46:08'),
(2, 'pending_posts_2025-07-24_12-46-26.csv', 'CSV', 'pending', 0, '2025-07-24 12:46:26'),
(3, 'all_users_2025-07-24_12-46-33.json', 'JSON', 'users', 945, '2025-07-24 12:46:33'),
(4, 'approved_posts_2025-07-24_13-46-41.json', 'JSON', 'approved', 345, '2025-07-24 13:46:41'),
(5, 'approved_posts_2025-07-24_13-49-04.json', 'JSON', 'approved', 345, '2025-07-24 13:49:04'),
(6, 'approved_posts_2025-07-24_14-03-30.json', 'JSON', 'approved', 345, '2025-07-24 14:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `country` varchar(100) NOT NULL,
  `event_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `user_id`, `title`, `body`, `country`, `event_date`, `image_path`, `tags`, `created_at`, `verified`, `likes`) VALUES
(6, 10, 'ajsdfjl;asdf', 'bee', 'India', '2025-07-08', 'uploads/1753014740_dashboard.png', 'Food', '2025-07-20 12:32:20', 1, 2),
(12, 9, 'hee', 'nciea;lskdjf;nciea;lskdjf;nciea;lskdjf;nciea;lskdjf;', 'Nepal', NULL, NULL, 'Dance', '2025-07-24 12:04:51', 1, 0),
(14, 17, 'nice', 'done', 'Nepal', NULL, NULL, 'Dance', '2025-07-24 12:14:55', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `country`, `password`, `created_at`, `role`) VALUES
(9, 'root', 'root@root.com', 'USA', '$2y$10$wUO.FQkAiGLqfgs3S1R7yOv8Wvt/QtbD6saN7onxSwVgimFWdKXKS', '2025-07-20 11:50:46', 'admin'),
(10, 'Bishal Poudel', 'bishalpoudel19920@gmail.com', 'India', '$2y$10$PZNrlHftgOt8EjDxNm3IP.g9bpXIkq92zoC.4SjomkLAfu1eIl.mC', '2025-07-20 12:04:48', 'admin'),
(14, 'try1', 'try1@try.com', 'USA', '$2y$10$YvWrdRFK59NSLms4/kyul.XdsHDJ.3TSOrCugir/WDU17xl6l9ADO', '2025-07-23 15:03:33', 'user'),
(15, 'try2', 'try2@try.com', 'India', '$2y$10$ty7Y3ZZne.rvlE7Jg/hIIut0YLj8LtriBcY.mbySPDHMhdriqbfJq', '2025-07-23 15:03:54', 'user'),
(17, 'Ram Thapa', 'ram1990@gmail.com', 'India', '$2y$10$CbmwJb8SVeOACQWWnWF1eeqcC2TISgj1UMFpDS/rIoimgCtzLikme', '2025-07-24 12:10:10', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
