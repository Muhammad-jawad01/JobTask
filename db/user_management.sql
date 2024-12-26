-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 26, 2024 at 08:52 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `address` text,
  `profile_img` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `phone`, `gender`, `address`, `profile_img`, `reset_token`, `reset_token_expiry`, `status`, `created_at`) VALUES
(1, 'admin@admin.com', NULL, 'admin@admin.com', '$2y$10$udIQBWelqpTxvldaHHfIoOVdzbbH3n0OkV9C2bvt0KfTlnn7ZVjxe', NULL, 'male', NULL, NULL, NULL, NULL, 1, '2024-12-26 05:54:37'),
(2, 'Muhmmad Jawad', NULL, 'josonroy99@gmail.com', '$2y$10$3fYUfJFXyTdVOK0lUFQcROC856U0brVX3aYi1N3f45.OWCLZwBNc.', NULL, 'male', NULL, NULL, NULL, NULL, 1, '2024-12-26 05:59:29'),
(5, 'Muhmmad Jawad', NULL, 'jawad@gmail.com', '$2y$10$9wg0eVPGhLYAalOyxuvBauyhRUJzV4hCvycrCgUrRubo2Zc.WjP3q', NULL, 'male', NULL, NULL, '70a59773ca60d54da2fa6c2ba0f220e8b2c4c35e0a504588859764a8bc408a92538df2c444338dae732131eb4407250f36ba', '2024-12-26 08:37:36', 1, '2024-12-26 07:33:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
