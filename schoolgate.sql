-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 05, 2025 at 04:05 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolgate`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `autodate` datetime DEFAULT CURRENT_TIMESTAMP,
  `schoolid` text NOT NULL,
  `student_id` text,
  `student_fname` text,
  `our_date` date DEFAULT NULL,
  `our_time` time DEFAULT NULL,
  `our_user` text,
  `action` text NOT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`autoid`, `autodate`, `schoolid`, `student_id`, `student_fname`, `our_date`, `our_time`, `our_user`, `action`, `status`) VALUES
(1, '2025-04-03 02:04:14', '', '1', 'ZIMULA', '2025-04-02', '23:04:14', 'ask111', '', 1),
(2, '2025-04-03 02:07:52', '', '1', 'ZIMULA', '2025-04-02', '23:07:52', 'ask111', '', 1),
(3, '2025-04-03 02:12:58', '', '1', 'ZIMULA', '2025-04-02', '23:12:58', 'ask111', '', 1),
(4, '2025-04-03 04:25:00', 'sc123', 'st0003', 'King', '2025-04-03', '01:25:00', 'ask111', '', 1),
(5, '2025-04-03 04:28:00', 'sc123', 'st0003', 'King', '2025-04-03', '04:28:00', 'ask111', '', 1),
(6, '2025-04-03 04:37:57', 'sc123', 'st0003', 'King', '2025-04-03', '01:37:57', 'ask111', 'arrived', 1),
(7, '2025-04-03 04:38:05', 'sc123', 'st0003', 'King', '2025-04-03', '01:38:05', 'ask111', 'left', 1),
(8, '2025-04-03 04:38:24', '', '1', 'ZIMULA', '2025-04-03', '01:38:24', 'ask111', 'left', 1),
(9, '2025-04-03 04:38:46', 'sc123', 'st0002', 'Dory Fi', '2025-04-03', '01:38:46', 'ask111', 'arrived', 1),
(10, '2025-04-03 05:46:14', '', '1', 'ZIMULA', '2025-04-03', '02:46:14', 'ask111', 'arrived', 1),
(11, '2025-04-03 05:56:43', 'sc123', 'st0003', 'King', '2025-04-03', '02:56:43', 'ask111', 'arrived', 1),
(12, '2025-04-03 05:57:28', 'sc123', 'st0003', 'King', '2025-04-03', '02:57:28', 'ask111', 'arrived', 1),
(13, '2025-04-03 05:59:11', 'sc123', 'st0003', 'King', '2025-04-03', '02:59:11', 'ask111', 'arrived', 1),
(14, '2025-04-03 06:00:05', '', '1', 'ZIMULA', '2025-04-03', '03:00:05', 'ask111', 'arrived', 1),
(15, '2025-04-03 06:00:45', 'sc123', 'st0001', 'King', '2025-04-03', '03:00:45', 'ask111', 'left', 1),
(16, '2025-04-03 06:01:21', '', '1', 'ZIMULA', '2025-04-03', '03:01:21', 'ask111', 'arrived', 1),
(17, '2025-04-03 06:03:34', '', '1', 'ZIMULA', '2025-04-03', '06:03:34', 'ask111', 'arrived', 1),
(18, '2025-04-03 06:10:36', 'sc123', 'st0001', 'King', '2025-04-03', '06:10:36', 'ask111', 'left', 1),
(19, '2025-04-03 17:00:00', 'sc123', 'st0004', 'Nicole', '2025-04-03', '17:00:00', 'sca01', 'arrived', 1),
(20, '2025-04-03 17:05:12', 'sc123', 'st0004', 'Nicole', '2025-04-03', '17:05:12', 'sca01', 'arrived', 1),
(21, '2025-04-03 17:05:26', 'sc123', 'st0005', 'Debbie', '2025-04-03', '17:05:26', 'sca01', 'left', 1),
(22, '2025-04-05 18:23:45', '', '1', 'ZIMULA', '2025-04-05', '18:23:45', 'sca01', 'arrived', 1),
(23, '2025-04-05 18:24:13', 'sc123', 'st0001', 'King', '2025-04-05', '18:24:13', 'sca01', 'left', 1);

-- --------------------------------------------------------

--
-- Table structure for table `keyfields`
--

DROP TABLE IF EXISTS `keyfields`;
CREATE TABLE IF NOT EXISTS `keyfields` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `autodate` datetime DEFAULT CURRENT_TIMESTAMP,
  `rolenumber` text,
  `email` text,
  `username` text,
  `password` text,
  `expiry` date DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `keyfields`
--

INSERT INTO `keyfields` (`autoid`, `autodate`, `rolenumber`, `email`, `username`, `password`, `expiry`, `status`) VALUES
(1, '2025-03-14 00:00:00', 'ask111', 'amos@email.com', 'amos', 'gate', NULL, 1),
(2, '2025-03-14 00:00:00', 'sca01', 'captain@gmail.cocom', 'captain', '9991', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `autodate` datetime DEFAULT CURRENT_TIMESTAMP,
  `message_id` text,
  `message_name` text,
  `rolenumber` int DEFAULT NULL,
  `part1` text,
  `part2` text,
  `status` int DEFAULT '1',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

DROP TABLE IF EXISTS `recipients`;
CREATE TABLE IF NOT EXISTS `recipients` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `autodate` datetime DEFAULT CURRENT_TIMESTAMP,
  `schoolid` text NOT NULL,
  `recipient_id` text,
  `student_id` text,
  `rolenumber` int DEFAULT NULL,
  `phone` text,
  `email` text,
  `status` int DEFAULT '1',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scrap`
--

DROP TABLE IF EXISTS `scrap`;
CREATE TABLE IF NOT EXISTS `scrap` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `autodate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `item` varchar(50) NOT NULL,
  `item2` varchar(50) DEFAULT NULL,
  `item3` varchar(50) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `item4` varchar(50) DEFAULT NULL,
  `item5` varchar(50) DEFAULT NULL,
  `item6` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `scrap`
--

INSERT INTO `scrap` (`autoid`, `autodate`, `item`, `item2`, `item3`, `type`, `item4`, `item5`, `item6`) VALUES
(1, '2025-03-31 01:43:07', 'S1', NULL, NULL, 'seniorclass', NULL, NULL, NULL),
(2, '2025-03-31 01:43:07', 'S2', NULL, NULL, 'seniorclass', NULL, NULL, NULL),
(3, '2025-03-31 01:43:07', 'S3', NULL, NULL, 'seniorclass', NULL, NULL, NULL),
(4, '2025-03-31 01:43:07', 'S4', NULL, NULL, 'seniorclass', NULL, NULL, NULL),
(5, '2025-03-31 01:43:07', 'S5', NULL, NULL, 'seniorclass', NULL, NULL, NULL),
(6, '2025-03-31 01:43:07', 'S6', NULL, NULL, 'seniorclass', NULL, NULL, NULL),
(7, '2025-03-31 01:43:07', 'Baby', NULL, NULL, 'primclass', NULL, NULL, NULL),
(8, '2025-03-31 01:43:07', 'Middle', NULL, NULL, 'primclass', NULL, NULL, NULL),
(9, '2025-03-31 01:43:07', 'Top', NULL, NULL, 'primclass', NULL, NULL, NULL),
(10, '2025-03-31 01:43:07', 'P1', NULL, NULL, 'primclass', NULL, NULL, NULL),
(11, '2025-03-31 01:43:07', 'P2', NULL, NULL, 'primclass', NULL, NULL, NULL),
(12, '2025-03-31 01:43:07', 'P3', NULL, NULL, 'primclass', NULL, NULL, NULL),
(13, '2025-03-31 01:43:07', 'P4', NULL, NULL, 'primclass', NULL, NULL, NULL),
(14, '2025-03-31 01:43:07', 'P5', NULL, NULL, 'primclass', NULL, NULL, NULL),
(15, '2025-03-31 01:43:07', 'P6', NULL, NULL, 'primclass', NULL, NULL, NULL),
(16, '2025-03-31 01:43:07', 'P7', NULL, NULL, 'primclass', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `autodate` datetime DEFAULT CURRENT_TIMESTAMP,
  `schoolid` text NOT NULL,
  `student_id` text NOT NULL,
  `student_class` text,
  `student_fname` text,
  `student_lname` text,
  `student_image` text NOT NULL,
  `credits` int DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`autoid`, `autodate`, `schoolid`, `student_id`, `student_class`, `student_fname`, `student_lname`, `student_image`, `credits`, `status`) VALUES
(1, '2025-03-14 23:28:59', '', '1', 'S3', 'ZIMULA', 'ABDULNASSER', '123.jpg', 50000, 1),
(2, '2025-03-14 23:46:10', '', '2', 'S5', 'NASSER', 'NASSER', '', 5000, 1),
(3, '2025-03-15 00:15:38', '', '3', 'rgwcg', 'dwv', 'vvfhw', 'nasser.jpg', 400, 1),
(20, '2025-04-03 17:03:49', 'sc123', 'st0005', 'S1', 'Debbie', 'Anana', 'pics/st0005.png', NULL, 1),
(19, '2025-04-03 16:58:31', 'sc123', 'st0004', 'S1', 'Nicole', 'Nakanwagi', 'pics/default.png', NULL, 1),
(18, '2025-04-03 03:47:03', 'sc123', 'st0003', 'S4', 'King', 'Kong', 'pics/st0003.png', NULL, 1),
(17, '2025-04-03 03:46:41', 'sc123', 'st0002', 'S4', 'King', 'Kong', 'pics/st0002.png', NULL, 1),
(16, '2025-04-03 03:46:13', 'sc123', 'st0001', 'S3', 'King', 'Kong', 'pics/default.png', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `autoid` int NOT NULL AUTO_INCREMENT,
  `schoolid` text NOT NULL,
  `schoollevel` text NOT NULL,
  `autodate` datetime DEFAULT CURRENT_TIMESTAMP,
  `username` text NOT NULL,
  `fname` text,
  `lname` text,
  `rolenumber` text,
  `role` text,
  `email` text,
  `phone` text,
  `status` int DEFAULT '1',
  PRIMARY KEY (`autoid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`autoid`, `schoolid`, `schoollevel`, `autodate`, `username`, `fname`, `lname`, `rolenumber`, `role`, `email`, `phone`, `status`) VALUES
(1, 'sc123', 'seniorclass', NULL, 'amos', 'Amos', 'Aa', 'ask111', 'ask', 'amos@email.com', NULL, 1),
(15, 'sc123', 'seniorclass', '2025-03-18 23:02:29', 'captain', 'Captain', 'Nemo', 'sca01', 'sca', '', '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
