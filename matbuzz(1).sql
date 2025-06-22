-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2025 at 04:22 PM
-- Server version: 8.0.41
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matbuzz`
--

-- --------------------------------------------------------

--
-- Table structure for table `matatu`
--

CREATE TABLE `matatu` (
  `SACCO` varchar(20) DEFAULT NULL,
  `Reg_number` varchar(20) NOT NULL,
  `route` varchar(100) DEFAULT NULL,
  `matatu_model` varchar(20) DEFAULT NULL,
  `Driver_list` varchar(255) DEFAULT NULL,
  `Conductor_list` varchar(255) DEFAULT NULL,
  `matatu_photo` varchar(255) DEFAULT NULL,
  `owner_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `matatu`
--

INSERT INTO `matatu` (`SACCO`, `Reg_number`, `route`, `matatu_model`, `Driver_list`, `Conductor_list`, `matatu_photo`, `owner_id`) VALUES
('Welkan', 'KAQ 952B', 'Nairobi-Nakuru', 'Toyota Hiace', 'John Kamau, Janet Wairimu, Alex Ochieng', 'Mark Wafula, Nigel Benn', 'uploads/matatu_68580bf2204860.35031881.jpg', 9),
('Lakenya', 'KAT 899Q', 'Nairobi-Rongai', 'Nissan', 'Jefferey-Allen White, Austin', 'Tony, Mark-Andre Ter Stegen', 'uploads/matatu_685810f663ec80.94004617.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `sacco` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `name`, `email`, `password_hash`, `photo_url`, `sacco`) VALUES
(9, 'TEDDD', 'ted.njiru@strathmore.edu', '$2y$10$04EtjgAayWwncvfOOHPP/uV2ABSPti7S23ZevD5uBsvojkpzgHUdq', 'uploads/6853c6b2c1071.jpg', 'Saaa');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `passenger_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`passenger_id`, `name`, `email`, `password_hash`, `photo_url`) VALUES
(25, 'TEDDD', 'ted.njiru@strathmore.edu', '$2y$10$rM0thUV00ZznGl5Uq29i7.pDjJW4Xdv9hMnetxgIMstsE8GpOsRQS', 'uploads/6853c53a1dd03.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `reg_number` varchar(20) NOT NULL,
  `review` text NOT NULL,
  `rating` int NOT NULL,
  `passenger_id` int NOT NULL,
  `review_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matatu`
--
ALTER TABLE `matatu`
  ADD PRIMARY KEY (`Reg_number`),
  ADD KEY `fk_owner_id` (`owner_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`passenger_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reg_number` (`reg_number`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `passenger_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matatu`
--
ALTER TABLE `matatu`
  ADD CONSTRAINT `fk_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`reg_number`) REFERENCES `matatu` (`Reg_number`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`passenger_id`) REFERENCES `passenger` (`passenger_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
