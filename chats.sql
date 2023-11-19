-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2023 at 05:33 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chats`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE IF NOT EXISTS `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `chat_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `content`, `chat_id`, `created_at`, `update_at`, `is_admin`) VALUES
(17, 'is it working ?', '17000714783432', '2023-11-15 18:27:48', '2023-11-15 18:27:48', 0),
(16, 'any udapte what\'s going on ?', '17000714783432', '2023-11-15 18:27:19', '2023-11-15 18:27:19', 0),
(15, 'any udapte what\'s going on ?', '17000714783432', '2023-11-15 18:26:14', '2023-11-15 18:26:14', 0),
(14, 'great what\'s up ?', '17000714783432', '2023-11-15 18:25:44', '2023-11-15 18:25:44', 0),
(13, 'i am good Thanks how are you ', '17000714783432', '2023-11-15 18:19:15', '2023-11-15 18:19:15', 0),
(12, 'hello how are you ', '17000714783432', '2023-11-15 18:18:58', '2023-11-15 18:18:58', 0),
(18, 'yes it\'s working great to see', '17000714783432', '2023-11-15 18:28:04', '2023-11-15 18:28:04', 1),
(19, 'hello', '17000729910264', '2023-11-15 18:31:13', '2023-11-15 18:31:13', 0),
(20, 'hi', '17000729910264', '2023-11-15 18:31:17', '2023-11-15 18:31:17', 1),
(21, 'how are you ?', '17000729910264', '2023-11-15 18:31:37', '2023-11-15 18:31:37', 0),
(22, 'i am fine Thanks. how are you ?', '17000729910264', '2023-11-15 18:31:54', '2023-11-15 18:31:54', 1),
(23, 'i am good thanks', '17000729910264', '2023-11-15 18:32:20', '2023-11-15 18:32:20', 0),
(24, 'hello', '17000732552039', '2023-11-15 18:34:27', '2023-11-15 18:34:27', 0),
(25, 'hi', '17000732552039', '2023-11-15 18:34:32', '2023-11-15 18:34:32', 1),
(26, 'hello', '17000751501421', '2023-11-15 19:06:11', '2023-11-15 19:06:11', 0),
(27, 'how are you ?', '17000751501421', '2023-11-15 19:06:16', '2023-11-15 19:06:16', 0),
(28, 'i am on the admin side ', '17000732552039', '2023-11-17 13:04:36', '2023-11-17 13:04:36', 0),
(29, 'admin side area', '17000732552039', '2023-11-17 13:05:25', '2023-11-17 13:05:25', 1),
(30, 'whre are you main ', '17000732552039', '2023-11-17 13:05:38', '2023-11-17 13:05:38', 1),
(31, 'hello its a new chat', '1700226359898', '2023-11-17 13:06:16', '2023-11-17 13:06:16', 0),
(32, 'ok it got it from admin side ', '1700226359898', '2023-11-17 13:07:44', '2023-11-17 13:07:44', 1),
(33, 'i am good thanks', '17000751501421', '2023-11-17 13:08:41', '2023-11-17 13:08:41', 1),
(34, 'i am on the admin side ', '17000732552039', '2023-11-17 13:09:03', '2023-11-17 13:09:03', 1),
(35, 'great to hear', '17000732552039', '2023-11-17 13:09:48', '2023-11-17 13:09:48', 0),
(36, 'Hello i am Arslan from Tritechteal i want to get an account from your website', '17002282764152', '2023-11-17 13:38:26', '2023-11-17 13:38:26', 0),
(37, 'Hi Arslan it was good to hear you want an account form us ', '17002282764152', '2023-11-17 13:39:16', '2023-11-17 13:39:16', 1),
(38, 'kindly share your identificaiton nuber and address to proceed further', '17002282764152', '2023-11-17 13:39:47', '2023-11-17 13:39:47', 1),
(39, 'ok i will share shortly', '17002282764152', '2023-11-17 13:40:08', '2023-11-17 13:40:08', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
