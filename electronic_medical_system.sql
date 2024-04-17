-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 04:43 PM
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
-- Table structure for table `ailment_data`
--

CREATE TABLE `ailment_data` (
  `disease_id` int(11) NOT NULL,
  `disease_name` varchar(100) NOT NULL,
  `symptoms` text NOT NULL,
  `cure` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ailment_data`
--

INSERT INTO `ailment_data` (`disease_id`, `disease_name`, `symptoms`, `cure`) VALUES
(1, 'Influenza', 'Fever, cough, sore throat, body aches, fatigue', 'Rest, fluids, antiviral medications if prescribed'),
(2, 'Hypertension', 'High blood pressure readings, headache, dizziness, chest pain', 'Lifestyle modifications, medications'),
(3, 'Diabetes', 'Increased thirst, frequent urination, fatigue, blurred vision', 'Insulin therapy, dietary changes, regular monitoring');

-- --------------------------------------------------------

--
-- Table structure for table `diseasedetails`
--

CREATE TABLE `diseasedetails` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `symptoms` text NOT NULL,
  `disease` varchar(100) DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseasedetails`
--

INSERT INTO `diseasedetails` (`user_id`, `name`, `dob`, `email`, `phone`, `symptoms`, `disease`, `prescription`, `submission_date`) VALUES
(1, 'John Doe', '1990-05-15', 'johndoe@example.com', '1234567890', 'Fever, cough, sore throat', 'Influenza', 'Rest and fluids', '2024-04-17 06:40:05');

-- --------------------------------------------------------

--
-- Table structure for table `medics`
--

CREATE TABLE `medics` (
  `medic_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `qualification` text DEFAULT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `signup_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `response_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`query_id`, `user_id`, `email`, `query_text`, `response_text`, `response_date`) VALUES
(1, '123456', 'user@example.com', 'How can I schedule an appointment?', 'Its good pleasure', '2024-04-17 10:12:37'),
(2, '123456', 'user@example.com', 'I have been stuck', 'Need of help , i can give one', '2024-04-17 13:52:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ailment_data`
--
ALTER TABLE `ailment_data`
  ADD PRIMARY KEY (`disease_id`);

--
-- Indexes for table `diseasedetails`
--
ALTER TABLE `diseasedetails`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `medics`
--
ALTER TABLE `medics`
  ADD PRIMARY KEY (`medic_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`query_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ailment_data`
--
ALTER TABLE `ailment_data`
  MODIFY `disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diseasedetails`
--
ALTER TABLE `diseasedetails`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medics`
--
ALTER TABLE `medics`
  MODIFY `medic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
