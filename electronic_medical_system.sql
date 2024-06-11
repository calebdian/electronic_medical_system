-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 11:26 PM
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
  `dosage` text NOT NULL,
  `billing` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ailment_data`
--

INSERT INTO `ailment_data` (`disease_id`, `disease_name`, `symptoms`, `cure`, `dosage`, `billing`) VALUES
(1, 'Influenza', 'Fever, cough, sore throat, body aches, fatigue', 'Rest, fluids, antiviral medications if prescribed', 'Oseltamivir 75 mg 1*2 for 5 days', 'Antiviral medications: $50'),
(2, 'Hypertension', 'High blood pressure readings, headache, dizziness, chest pain', 'Lifestyle modifications, medications', 'Lisinopril 10 mg 1*1 daily', 'Medications: $100 per month'),
(3, 'Diabetes', 'Increased thirst, frequent urination, fatigue, blurred vision', 'Insulin therapy, dietary changes, regular monitoring', 'Insulin 10 units subcutaneously before meals', 'Insulin: $300 per month, Glucose monitoring: $50 per month'),
(4, 'Malaria', 'fever,chills,sweating,headache,nausea,vomiting', 'Antimalarial medications', 'Chloroquine 600 mg immediately, then 300 mg at 6, 24, and 48 hours', 'Antimalarial medications: $60'),
(5, 'Dengue Fever', 'fever,headache,joint pain,muscle pain,rash', 'Pain relievers, fluids, rest', 'Paracetamol 500 mg 1*3 for pain, maintain hydration', 'Pain relievers: $20'),
(6, 'Tuberculosis', 'cough,fever,night sweats,weight loss,chest pain', 'Antibiotics', 'Rifampicin 600 mg 1*1 daily, Isoniazid 300 mg 1*1 daily', 'Antibiotics: $200 per course'),
(7, 'Asthma', 'wheezing,coughing,shortness of breath,chest tightness', 'Inhalers, corticosteroids, bronchodilators', 'Albuterol 2 puffs as needed, Fluticasone 100 mcg 1*2 daily', 'Inhalers: $50, Corticosteroids: $30 per month'),
(8, 'Diabetes', 'increased thirst,frequent urination,hunger,fatigue,blurred vision', 'Insulin, diet, exercise, medication', 'Insulin 10 units subcutaneously before meals', 'Insulin: $300 per month, Glucose monitoring: $50 per month'),
(9, 'Hypertension', 'headache,dizziness,shortness of breath,nosebleeds', 'Lifestyle changes, antihypertensive drugs', 'Lisinopril 10 mg 1*1 daily', 'Antihypertensive drugs: $100 per month'),
(10, 'Migraine', 'headache,nausea,vomiting,sensitivity to light,sensitivity to sound', 'Pain relievers, triptans, anti-nausea medication', 'Sumatriptan 50 mg as needed, not more than 200 mg/day', 'Pain relievers: $30, Triptans: $40'),
(11, 'COVID-19', 'fever,cough,shortness of breath,fatigue,loss of taste or smell', 'Rest, fluids, antiviral medications, oxygen therapy', 'Paracetamol 500 mg 1*3 for fever, maintain hydration', 'Antiviral medications: $200, Oxygen therapy: $150 per day'),
(12, 'Pneumonia', 'cough,fever,chills,shortness of breath,chest pain', 'Antibiotics, cough medicine, fever reducers', 'Amoxicillin 500 mg 1*3 for 7 days', 'Antibiotics: $100 per course, Cough medicine: $20, Fever reducers: $15'),
(13, 'Bronchitis', 'cough,production of mucus,fatigue,shortness of breath,chest discomfort', 'Cough medicine, rest, fluids', 'Dextromethorphan 10 ml 1*3 as needed for cough', 'Cough medicine: $10, Rest: $0, Fluids: $5'),
(14, 'Hepatitis B', 'fatigue,nausea,abdominal pain,jaundice', 'Antiviral medications, rest, liver transplant', 'Tenofovir 300 mg 1*1 daily', 'Antiviral medications: $150 per course, Rest: $0, Liver transplant: $100,000'),
(15, 'Measles', 'fever,cough,runny nose,red eyes,skin rash', 'Rest, fluids, vitamin A', 'Vitamin A 200,000 IU once', 'Rest: $0, Fluids: $5, Vitamin A: $10'),
(16, 'Mumps', 'swollen salivary glands,fever,headache,fatigue,loss of appetite', 'Rest, fluids, pain relievers', 'Paracetamol 500 mg 1*3 for pain', 'Rest: $0, Fluids: $5, Pain relievers: $10'),
(17, 'Whooping Cough', 'severe cough,runny nose,fever', 'Antibiotics, cough medicine', 'Azithromycin 500 mg 1*1 for 3 days', 'Antibiotics: $20 per course, Cough medicine: $10'),
(18, 'Rubella', 'rash,fever,swollen lymph nodes,joint pain', 'Rest, fluids, pain relievers', 'Paracetamol 500 mg 1*3 for pain', 'Rest: $0, Fluids: $5, Pain relievers: $10'),
(19, 'Tetanus', 'muscle stiffness,lockjaw,difficulty swallowing,muscle spasms', 'Antitoxin, antibiotics, wound care', 'Metronidazole 500 mg 1*3 for 10 days', 'Antitoxin: $200, Antibiotics: $50, Wound care: $100'),
(20, 'Meningitis', 'fever,headache,stiff neck,nausea,sensitivity to light', 'Antibiotics, antiviral drugs, corticosteroids', 'Ceftriaxone 2 g IV 1*1 daily', 'Antibiotics: $100, Antiviral drugs: $150, Corticosteroids: $50'),
(21, 'Encephalitis', 'fever,headache,confusion,seizures,weakness', 'Antiviral drugs, supportive care', 'Acyclovir 10 mg/kg IV every 8 hours', 'Antiviral drugs: $200, Supportive care: $100'),
(22, 'HIV/AIDS', 'fever,weight loss,night sweats,fatigue,swollen lymph nodes', 'Antiretroviral therapy (ART)', 'Tenofovir 300 mg 1*1 daily', 'Antiretroviral therapy (ART): $400 per month'),
(23, 'Zika Virus', 'fever,rash,joint pain,red eyes', 'Rest, fluids, pain relievers', 'Paracetamol 500 mg 1*3 for pain', 'Rest: $0, Fluids: $5, Pain relievers: $10'),
(24, 'Ebola', 'fever,severe headache,muscle pain,weakness,fatigue', 'Supportive care, rehydration, experimental treatments', 'IV fluids as needed, supportive care', 'Supportive care: $150, Rehydration: $50, Experimental treatments: $500'),
(25, 'Cholera', 'diarrhea,nausea,vomiting,dehydration', 'Rehydration therapy, antibiotics', 'Doxycycline 100 mg 1*2 for 7 days', 'Rehydration therapy: $50, Antibiotics: $30'),
(26, 'Typhoid Fever', 'fever,headache,abdominal pain,diarrhea or constipation', 'Antibiotics, fluids, rest', 'Ciprofloxacin 500 mg 1*2 for 10 days', 'Antibiotics: $100 per course, Fluids: $10, Rest: $0'),
(27, 'Leptospirosis', 'fever,headache,muscle pain,red eyes,jaundice', 'Antibiotics, supportive care', 'Doxycycline 100 mg 1*2 for 7 days', 'Antibiotics: $50, Supportive care: $30'),
(28, 'Lyme Disease', 'fever,chills,headache,fatigue,joint pain', 'Antibiotics', 'Doxycycline 100 mg 1*2 for 14 days', 'Antibiotics: $100'),
(29, 'Plague', 'fever,chills,headache,swollen lymph nodes', 'Antibiotics, supportive care', 'Gentamicin 5 mg/kg IV every 24 hours', 'Antibiotics: $50, Supportive care: $30'),
(30, 'Smallpox', 'fever,body aches,skin rash', 'Antiviral drugs, supportive care', 'Tecovirimat 600 mg 1*2 for 14 days', 'Antiviral drugs: $150, Supportive care: $100'),
(31, 'Syphilis', 'sore,skin rash,fever,swollen lymph nodes', 'Antibiotics', 'Penicillin G 2.4 million units IM once', 'Antibiotics: $20 per course'),
(32, 'Gonorrhea', 'painful urination,abnormal discharge,fever', 'Antibiotics', 'Ceftriaxone 250 mg IM once', 'Antibiotics: $20 per course'),
(33, 'Chlamydia', 'painful urination,abnormal discharge,abdominal pain', 'Antibiotics', 'Azithromycin 1 g orally once', 'Antibiotics: $20 per course'),
(34, 'Herpes Simplex', 'blisters,sores,itching,pain during urination', 'Antiviral medications', 'Acyclovir 400 mg 1*3 for 7-10 days', 'Antiviral medications: $150 per course'),
(35, 'Human Papillomavirus (HPV)', 'warts,itching,abnormal discharge', 'Topical treatments, vaccines', 'Imiquimod cream 5% apply 3 times a week for up to 16 weeks', 'Topical treatments: $50, Vaccines: $200'),
(36, 'Lupus', 'fatigue,joint pain,skin rash,fever', 'Immunosuppressants, anti-inflammatory drugs', 'Prednisone 5 mg 1*1 daily, NSAIDs as needed', 'Immunosuppressants: $300 per month, Anti-inflammatory drugs: $50 per month'),
(37, 'Multiple Sclerosis', 'numbness,weakness,vision problems,fatigue', 'Immunotherapy, physical therapy', 'Interferon beta-1a 44 mcg SC 1*3 weekly', 'Immunotherapy: $400 per month, Physical therapy: $100 per session'),
(38, 'Rheumatoid Arthritis', 'joint pain,swelling,stiffness,fatigue', 'Anti-inflammatory drugs, physical therapy', 'Methotrexate 7.5 mg 1*1 weekly', 'Anti-inflammatory drugs: $50 per month, Physical therapy: $100 per session'),
(39, 'Crohn\'s Disease', 'diarrhea,abdominal pain,weight loss,fatigue', 'Anti-inflammatory drugs, surgery', 'Prednisone 5 mg 1*1 daily', 'Anti-inflammatory drugs: $50 per month, Surgery: $5000'),
(40, 'Celiac Disease', 'diarrhea,abdominal pain,bloating,fatigue', 'Gluten-free diet, nutritional supplements', 'Gluten-free diet strictly, supplements as needed', 'Gluten-free diet: $100 per month, Nutritional supplements: $50 per month'),
(41, 'Gastritis', 'Stomach pain, bloating, nausea', 'Antacids, Dietary changes', 'Take antacids after meals. Follow dietary changes recommended by a healthcare provider.', 'Antacids: $20, Dietary changes: $50 per consultation'),
(42, 'Asthma', 'Shortness of breath, wheezing, chest tightness', 'Bronchodilators, Corticosteroids', 'Use bronchodilators for immediate relief. Corticosteroids help reduce inflammation and prevent symptoms.', 'Bronchodilators: $50, Corticosteroids: $30 per month'),
(43, 'Anemia', 'Dizziness, fatigue, pale skin', 'Iron supplements, Vitamin B12 injections', 'Take iron supplements as prescribed. Vitamin B12 injections may be necessary for some types of anemia.', 'Iron supplements: $20, Vitamin B12 injections: $50 per month'),
(44, 'Irritable Bowel Syndrome (IBS)', 'Abdominal cramps, diarrhea, gas', 'Fiber supplements, Probiotics', 'Increase fiber intake through supplements or dietary changes. Probiotics may help improve gut health.', 'Fiber supplements: $30, Probiotics: $20 per month'),
(45, 'Chronic Obstructive Pulmonary Disease (COPD)', 'Coughing, chest pain, difficulty breathing', 'Bronchodilators, Pulmonary rehabilitation', 'Use bronchodilators for symptom relief. Pulmonary rehabilitation programs can improve lung function.', 'Bronchodilators: $50, Pulmonary rehabilitation: $200 per session'),
(46, 'Malnutrition', 'Weight loss, fatigue, hair loss', 'Nutritional supplements, Dietary counseling', 'Take nutritional supplements to meet dietary requirements. Get dietary counseling to improve eating habits.', 'Nutritional supplements: $50 per month, Dietary counseling: $100 per session'),
(47, 'Gastroenteritis', 'Nausea, vomiting, abdominal pain', 'Oral rehydration solution, Antiemetics', 'Drink oral rehydration solution to prevent dehydration. Antiemetics help control nausea and vomiting.', 'Oral rehydration solution: $10, Antiemetics: $20'),
(48, 'Gastroesophageal Reflux Disease (GERD)', 'Difficulty swallowing, heartburn, regurgitation', 'Proton pump inhibitors, Antacids', 'Proton pump inhibitors reduce stomach acid production. Antacids provide immediate relief from heartburn.', 'Proton pump inhibitors: $40 per month, Antacids: $10'),
(49, 'Coronary Artery Disease (CAD)', 'Chest pain, palpitations, shortness of breath', 'Aspirin, Statins, Beta-blockers', 'Aspirin helps prevent blood clots. Statins lower cholesterol levels. Beta-blockers reduce heart rate and blood pressure.', 'Aspirin: $10, Statins: $50 per month, Beta-blockers: $30 per month'),
(50, 'Chronic Bronchitis', 'Chronic cough, mucus production, fatigue', 'Bronchodilators, Antibiotics', 'Bronchodilators help open airways. Antibiotics treat bacterial infections if present.', 'Bronchodilators: $50, Antibiotics: $20 per course'),
(51, 'Diabetes Mellitus', 'Weight loss, excessive hunger, fatigue', 'Insulin, Oral hypoglycemic agents', 'Insulin helps regulate blood sugar levels. Oral hypoglycemic agents may be prescribed to lower blood sugar levels.', 'Insulin: $300 per month, Oral hypoglycemic agents: $50 per month');

-- --------------------------------------------------------

--
-- Table structure for table `diseasedetails`
--

CREATE TABLE `diseasedetails` (
  `record_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `symptoms` text NOT NULL,
  `disease` varchar(100) DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `medication` varchar(20) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` int(1) NOT NULL DEFAULT 0,
  `doc_commented` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseasedetails`
--

INSERT INTO `diseasedetails` (`record_id`, `user_id`, `name`, `dob`, `email`, `phone`, `symptoms`, `disease`, `prescription`, `medication`, `submission_date`, `approval_status`, `doc_commented`) VALUES
(1, 0, 'John Doe', '1990-05-15', 'johndoe@example.com', '1234567890', 'Fever, cough, sore throat', 'Influenza', 'Rest, fluids, antiviral medications if prescribed', '', '2024-04-17 06:40:05', 1, 0),
(2, 0, 'Caleb Kipkemboi Toromo', '2024-04-11', 'calebtoromo@gmail.com', '0797223505', 'I am sick and apparently been diagnosed with headache, muscle cramps and lack of sleepness', 'Diabetes', 'sleep in bed good and take water frequently', 'Insulin 10 units sub', '2024-04-19 16:35:15', 1, 0),
(52, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have a headache , sore throat, cough, fever', 'Influenza', 'Avoid alot of exposure to cold', '', '2024-05-25 07:25:14', 0, 0),
(53, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have diahorrea, fever , headache and dizziness', 'Hypertension', 'you will heal', '', '2024-05-25 07:26:30', 0, 0),
(54, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have apparently feeling fatigue and stomachache', 'Influenza', 'Rest, fluids, antiviral medications if prescribed', '', '2024-05-25 07:28:01', 0, 0),
(55, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'stomachache', 'Unknown', NULL, '', '2024-05-25 07:28:19', 0, 0),
(56, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'have fatigue and hunger', 'Diabetes', NULL, '', '2024-05-25 07:29:12', 0, 0),
(69, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have a stomach ache', 'Gastritis', 'Antacids, Dietary changes', '', '2024-05-25 08:17:31', 0, 0),
(70, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I\'ve been experiencing severe abdominal pain, especially after eating. I also feel bloated and nauseous most of the time.', 'Hepatitis B', NULL, '', '2024-05-25 08:34:05', 0, 0),
(71, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I\'ve been having shortness of breath, wheezing, and tightness in my chest, especially during physical activities or at night.', 'Asthma', 'Inhalers, corticosteroids, bronchodilators', '', '2024-05-25 08:34:19', 0, 0),
(72, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'Lately, I\'ve been feeling extremely tired and dizzy, even with enough rest. My skin appears paler than usual.', 'Measles', NULL, '', '2024-05-25 08:34:34', 0, 0),
(73, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I frequently experience abdominal cramps, diarrhea, and excessive gas, which affects my daily routine.', 'Irritable Bowel Syndrome (IBS)', NULL, '', '2024-05-25 08:34:48', 0, 0),
(74, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I have a persistent cough with mucus production, chest pain, and difficulty breathing, especially in the mornings.', 'Bronchitis', NULL, '', '2024-05-25 08:35:02', 0, 0),
(75, 0, 'Caleb', '2021-07-04', 'calebtoromo@gmail.com', '0797223506', 'I\'ve noticed significant weight loss recently, along with excessive hunger and fatigue despite eating regularly.', 'Diabetes Mellitus', NULL, '', '2024-05-25 08:35:22', 0, 0);

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
(2, 'griham', '098', 'gm@gmail.com', '$2y$10$Hw866YgoQr994S86azbEmOUdmxUhUhpJVRYZyQtXjvXuw7kFWUn7y', 'Clinical', '2024-04-23 15:01:59'),
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
(1, 'Caleb', 'Toromo', '2021-07-04', 'calebtoromo@gmail.com', '12345678', '0797223506', '097-678-980', '2024-04-18 04:48:44'),
(2, 'endine', 'reing', '2002-04-23', 'pukko@g.com', '123', '0748339466', '576-098', '2024-04-18 05:57:42'),
(3, 'tnt', 'edge', '2024-04-12', 'ryantoromo@gmail.com', '12345', '0748339466', '780-345', '2024-04-18 06:24:38');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist`
--

CREATE TABLE `pharmacist` (
  `pharmacist_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacist`
--

INSERT INTO `pharmacist` (`pharmacist_id`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(1, 'Caleb', 'Toromo', 'calebtoromo@gmail.com', '0797223505', '$2y$10$yQ/VjYRTSSDy5jDtnkWaEuI8P7ZHZFIiRhQ2ivL4BN641v/6S1ZA.');

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
  ADD PRIMARY KEY (`record_id`);

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
-- Indexes for table `pharmacist`
--
ALTER TABLE `pharmacist`
  ADD PRIMARY KEY (`pharmacist_id`);

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
  MODIFY `disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `diseasedetails`
--
ALTER TABLE `diseasedetails`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

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
-- AUTO_INCREMENT for table `pharmacist`
--
ALTER TABLE `pharmacist`
  MODIFY `pharmacist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
