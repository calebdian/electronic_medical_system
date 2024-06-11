-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 11:55 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `ailment_data`
--

CREATE TABLE `ailment_data` (
  `disease_id` int(11) NOT NULL,
  `disease_name` varchar(100) NOT NULL,
  `symptoms` text NOT NULL,
  `cure` text NOT NULL,
  `dosage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ailment_data`
--

INSERT INTO `ailment_data` (`disease_id`, `disease_name`, `symptoms`, `cure`, `dosage`) VALUES
(1, 'Influenza', 'Fever, cough, sore throat, body aches, fatigue', 'Rest, fluids, antiviral medications if prescribed', ''),
(2, 'Hypertension', 'High blood pressure readings, headache, dizziness, chest pain', 'Lifestyle modifications, medications', ''),
(3, 'Diabetes', 'Increased thirst, frequent urination, fatigue, blurred vision', 'Insulin therapy, dietary changes, regular monitoring', ''),
(4, 'Malaria', 'fever,chills,sweating,headache,nausea,vomiting', 'Antimalarial medications', ''),
(5, 'Dengue Fever', 'fever,headache,joint pain,muscle pain,rash', 'Pain relievers, fluids, rest', ''),
(6, 'Tuberculosis', 'cough,fever,night sweats,weight loss,chest pain', 'Antibiotics', ''),
(7, 'Asthma', 'wheezing,coughing,shortness of breath,chest tightness', 'Inhalers, corticosteroids, bronchodilators', ''),
(8, 'Diabetes', 'increased thirst,frequent urination,hunger,fatigue,blurred vision', 'Insulin, diet, exercise, medication', ''),
(9, 'Hypertension', 'headache,dizziness,shortness of breath,nosebleeds', 'Lifestyle changes, antihypertensive drugs', ''),
(10, 'Migraine', 'headache,nausea,vomiting,sensitivity to light,sensitivity to sound', 'Pain relievers, triptans, anti-nausea medication', ''),
(11, 'COVID-19', 'fever,cough,shortness of breath,fatigue,loss of taste or smell', 'Rest, fluids, antiviral medications, oxygen therapy', ''),
(12, 'Pneumonia', 'cough,fever,chills,shortness of breath,chest pain', 'Antibiotics, cough medicine, fever reducers', ''),
(13, 'Bronchitis', 'cough,production of mucus,fatigue,shortness of breath,chest discomfort', 'Cough medicine, rest, fluids', ''),
(14, 'Hepatitis B', 'fatigue,nausea,abdominal pain,jaundice', 'Antiviral medications, rest, liver transplant', ''),
(15, 'Measles', 'fever,cough,runny nose,red eyes,skin rash', 'Rest, fluids, vitamin A', ''),
(16, 'Mumps', 'swollen salivary glands,fever,headache,fatigue,loss of appetite', 'Rest, fluids, pain relievers', ''),
(17, 'Whooping Cough', 'severe cough,runny nose,fever', 'Antibiotics, cough medicine', ''),
(18, 'Rubella', 'rash,fever,swollen lymph nodes,joint pain', 'Rest, fluids, pain relievers', ''),
(19, 'Tetanus', 'muscle stiffness,lockjaw,difficulty swallowing,muscle spasms', 'Antitoxin, antibiotics, wound care', ''),
(20, 'Meningitis', 'fever,headache,stiff neck,nausea,sensitivity to light', 'Antibiotics, antiviral drugs, corticosteroids', ''),
(21, 'Encephalitis', 'fever,headache,confusion,seizures,weakness', 'Antiviral drugs, supportive care', ''),
(22, 'HIV/AIDS', 'fever,weight loss,night sweats,fatigue,swollen lymph nodes', 'Antiretroviral therapy (ART)', ''),
(23, 'Zika Virus', 'fever,rash,joint pain,red eyes', 'Rest, fluids, pain relievers', ''),
(24, 'Ebola', 'fever,severe headache,muscle pain,weakness,fatigue', 'Supportive care, rehydration, experimental treatments', ''),
(25, 'Cholera', 'diarrhea,nausea,vomiting,dehydration', 'Rehydration therapy, antibiotics', ''),
(26, 'Typhoid Fever', 'fever,headache,abdominal pain,diarrhea or constipation', 'Antibiotics, fluids, rest', ''),
(27, 'Leptospirosis', 'fever,headache,muscle pain,red eyes,jaundice', 'Antibiotics, supportive care', ''),
(28, 'Lyme Disease', 'fever,chills,headache,fatigue,joint pain', 'Antibiotics', ''),
(29, 'Plague', 'fever,chills,headache,swollen lymph nodes', 'Antibiotics, supportive care', ''),
(30, 'Smallpox', 'fever,body aches,skin rash', 'Antiviral drugs, supportive care', ''),
(31, 'Syphilis', 'sore,skin rash,fever,swollen lymph nodes', 'Antibiotics', ''),
(32, 'Gonorrhea', 'painful urination,abnormal discharge,fever', 'Antibiotics', ''),
(33, 'Chlamydia', 'painful urination,abnormal discharge,abdominal pain', 'Antibiotics', ''),
(34, 'Herpes Simplex', 'blisters,sores,itching,pain during urination', 'Antiviral medications', ''),
(35, 'Human Papillomavirus (HPV)', 'warts,itching,abnormal discharge', 'Topical treatments, vaccines', ''),
(36, 'Lupus', 'fatigue,joint pain,skin rash,fever', 'Immunosuppressants, anti-inflammatory drugs', ''),
(37, 'Multiple Sclerosis', 'numbness,weakness,vision problems,fatigue', 'Immunotherapy, physical therapy', ''),
(38, 'Rheumatoid Arthritis', 'joint pain,swelling,stiffness,fatigue', 'Anti-inflammatory drugs, physical therapy', ''),
(39, 'Crohn\'s Disease', 'diarrhea,abdominal pain,weight loss,fatigue', 'Anti-inflammatory drugs, surgery', ''),
(40, 'Celiac Disease', 'diarrhea,abdominal pain,bloating,fatigue', 'Gluten-free diet, nutritional supplements', '');

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
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` int(1) NOT NULL DEFAULT 0,
  `doc_commented` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseasedetails`
--

INSERT INTO `diseasedetails` (`user_id`, `name`, `dob`, `email`, `phone`, `symptoms`, `disease`, `prescription`, `submission_date`, `approval_status`, `doc_commented`) VALUES
(1, 'John Doe', '1990-05-15', 'johndoe@example.com', '1234567890', 'Fever, cough, sore throat', 'Influenza', 'taking a good rest from the bed and ensuring you drink adequately water', '2024-04-17 06:40:05', 0, 0),
(2, 'Caleb Kipkemboi Toromo', '2024-04-11', 'calebtoromo@gmail.com', '0797223505', 'I am sick and apparently been diagnosed with headache, muscle cramps and lack of sleepness', 'Diabetes', 'sleep in bed good and take water frequently', '2024-04-19 16:35:15', 1, 0),
(3, 'Caleb', '2002-07-21', 'tkipkemboi@kabarak.ac.ke', '0797223505', 'I have stomach crumps and a headche, what could be wrong?', NULL, NULL, '2024-04-23 15:10:05', 0, 0),
(4, 'Caleb', '2024-04-10', 'calebtoromo@gmail.com', '0797223505', 'I have a serious headache that is hard to heal', NULL, NULL, '2024-05-14 16:29:43', 0, 0),
(5, 'Denik', '2002-02-01', 'calebtoromo@gmail.com', '0797223505', 'I am having tonsils , high temperatures , sores on the hand', NULL, NULL, '2024-05-20 18:55:49', 0, 0),
(6, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I am always feeling dizzy and having headache', 'Unknown', NULL, '2024-05-21 08:11:20', 0, 0),
(7, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I am always feeling dizzy and having headache', 'Unknown', NULL, '2024-05-21 09:17:51', 0, 0),
(8, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I am terribly feeling a stomach ache and high fever ', 'Unknown', NULL, '2024-05-21 09:28:04', 0, 0),
(9, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I am terribly feeling a stomach ache and high fever after sometime ', 'Unknown', NULL, '2024-05-21 10:26:04', 0, 0),
(10, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223505', 'I am having headache ', 'Unknown', NULL, '2024-05-21 11:20:49', 0, 0),
(11, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I am having a headache and cough', 'Unknown', NULL, '2024-05-21 11:51:02', 0, 0),
(12, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have headache', NULL, NULL, '2024-05-21 12:23:00', 0, 0),
(13, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have headache', 'Hypertension', NULL, '2024-05-21 12:29:34', 0, 0),
(14, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have fever and nausea', 'Influenza', NULL, '2024-05-21 12:30:26', 0, 0),
(15, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have coughs , stomach crumps and sore throat', 'Unknown', NULL, '2024-05-21 20:37:52', 0, 0),
(16, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have a headache and stomachache', 'Unknown', 'You are sick and need a medication', '2024-05-23 16:36:23', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `medics`
--

CREATE TABLE `medics` (
  `medic_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medics`
--

INSERT INTO `medics` (`medic_id`, `first_name`, `last_name`, `email`, `password`, `specialization`, `registration_date`) VALUES
(1, 'Toromo', 'Okongo', 'toromoOkongo@gmail.com', '$2y$10$mm5137o1zYpAmYrORCykdeL6y05TNgCln0ps2DNeLNOgLmXBNm4sO', 'Dentist', '2024-04-18 14:43:51'),
(2, 'griham', '098', 'gm@gmail.com', '$2y$10$D8/QFimpicTxQHLw7NJkz.Uy70VrM5XdRZf3WFCRHVMNinVfSFgE.', 'Clinical', '2024-04-23 15:01:59'),
(3, 'mark', 'Mutai', 'markmutai15@gmail.com', '$2y$10$yqbnzYC42OD8gtCQ27dQ/OJFxQNE68R9Q8IIYt2YqtOhq3cy.Y0ZO', 'Doctor', '2024-05-23 16:42:27');

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
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `signup_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `first_name`, `last_name`, `date_of_birth`, `email`, `password`, `phone`, `address`, `signup_date`) VALUES
(1, 'Caleb', 'Toromo', '2021-07-04', 'calebtoromo@gmail.com', '1234', '0797223506', '097-678-980', '2024-04-18 04:48:44'),
(2, 'endine', 'reing', '2002-04-23', 'pukko@g.com', '123', '0748339466', '576-098', '2024-04-18 05:57:42'),
(3, 'tnt', 'edge', '2024-04-12', 'ryantoromo@gmail.com', '12345', '0748339466', '780-345', '2024-04-18 06:24:38');

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
  `checked_status` int(11) DEFAULT 0,
  `response_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`query_id`, `user_id`, `email`, `query_text`, `response_text`, `checked_status`, `response_date`) VALUES
(1, '123456', 'user@example.com', 'How can I schedule an appointment?', 'Its good pleasure', 1, '2024-04-17 10:12:37'),
(2, '123456', 'user@example.com', 'I have been stuck', 'Need of help , i can give one', 0, '2024-04-17 13:52:12'),
(4, '123456', 'user@example.com', 'I am wondering why it is saying i have a certain disease', 'heheee you are sick man', 0, '2024-04-19 16:49:45'),
(5, '123456', 'user@example.com', 'help i am been suspected to have a disease which i cant take it ', 'hee you are finished', 0, '2024-04-23 15:02:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ailment_data`
--
ALTER TABLE `ailment_data`
  MODIFY `disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `diseasedetails`
--
ALTER TABLE `diseasedetails`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `medics`
--
ALTER TABLE `medics`
  MODIFY `medic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
