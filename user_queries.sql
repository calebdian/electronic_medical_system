-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 10:24 AM
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
-- Database: `electronic_medical_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `query_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `query_text` text NOT NULL,
  `response_text` text DEFAULT NULL,
  `doctor_id` int(10) NOT NULL,
  `checked_status` int(11) DEFAULT 0,
  `viewed_status` int(11) NOT NULL,
  `response_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`query_id`, `user_id`, `email`, `query_text`, `response_text`, `doctor_id`, `checked_status`, `viewed_status`, `response_date`) VALUES
(1, '1', 'user@example.com', 'How can I schedule an appointment?', 'Its good pleasure', 1, 1, 0, '2024-06-06 16:09:57'),
(2, '2', 'user@example.com', 'I have been stuck', 'Need of help , i can give one', 0, 0, 0, '2024-04-17 13:52:12'),
(4, '1', 'user@example.com', 'I am wondering why it is saying i have a certain disease', 'heheee you are sick man', 0, 0, 0, '2024-04-19 16:49:45'),
(5, '1', 'user@example.com', 'help i am been suspected to have a disease which i cant take it ', 'hee you are finished', 0, 0, 0, '2024-04-23 15:02:32'),
(6, '1', 'user@example.com', 'I am having high tempers to food all the time', 'You are very sick', 0, 0, 0, '2024-06-09 12:26:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`query_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
