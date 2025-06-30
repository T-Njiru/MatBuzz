-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 01:00 PM
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
  `matatu_model` varchar(50) DEFAULT NULL,
  `Driver_list` varchar(255) DEFAULT NULL,
  `Conductor_list` varchar(255) DEFAULT NULL,
  `matatu_photo` varchar(255) DEFAULT NULL,
  `owner_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `matatu`
--

INSERT INTO `matatu` (`SACCO`, `Reg_number`, `route`, `matatu_model`, `Driver_list`, `Conductor_list`, `matatu_photo`, `owner_id`) VALUES
('Welkan', 'KAQ 952B', 'Nairobi-Naivasha', 'Toyota Hiace', 'John Kamau, Janet Wairimu, Alex Ochieng', 'Mark Wafula, Nigel Benn', 'uploads/matatu_68580bf2204860.35031881.jpg', 9),
('Lakenya', 'KAT 899Q', 'Nairobi-Rongai', 'Nissan', 'Jefferey-Allen White, Austin', 'Tony, Mark-Andre Ter Stegen', 'uploads/matatu_685810f663ec80.94004617.jpg', 9),
('Makini', 'KCQ 678P', 'Nairobi-Mombasa', 'ISUZU NQR8', 'Johnstone kamau, Tom Mboya', 'Janet Jackson, Michael Jackson', 'uploads/matatu_685bc2e252e981.04176394.jpg', 10),
('Express', 'KDA 123G', 'Nairobi-Kisume', 'ISUZU NQR8', 'Amaya, Ace', 'Austin, Anthony', 'uploads/matatu_68593f2b38ffb6.77951252.jpg', 9),
('Forward Travellers', 'KDA005A', 'Nairobi - Rongai', 'Forward Travellers 005', 'John Maina', 'Peter Kariuki', 'pictures/matatu0.jpeg', 10),
('Super Metro', 'KDA302B', 'Nairobi - Umoja', 'Super Metro 302', 'Sam Njoroge', 'Mike Otieno', 'pictures/matatu1.jpeg', 9),
('Nazigi Sacco', 'KDC222C', 'CBD - Githurai 45', 'Nazigi Sacco 222', 'George Mwai', 'Brian Kipcheng', 'pictures/matatu2.jpeg', 10),
('Zuri Express', 'KDE909D', 'Nairobi - Donholm', 'Zuri Express 909', 'Allan Kiptoo', 'Tony Waweru', 'pictures/matatu4.jpeg', 9),
('Kaka Travellers', 'KDF781E', 'CBD - Kayole', 'Kaka Travellers 781', 'Paul Ochieng', 'David Mutua', 'pictures/matatu5.jpeg', 9),
('Kenya Bus Service', 'KDG110F', 'Nairobi - Ngong', 'Kenya Bus Service 110', 'Steve Mwangi', 'Kevin Wekesa', 'pictures/matatu7.jpeg', 10),
('Buruburu Express', 'KDH808G', 'Nairobi - Buruburu', 'Buruburu Express 808', 'Felix Kimani', 'Tom Were', 'pictures/matatu8.jpeg', 9);

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
(9, 'TEDDD', 'ted.njiru@strathmore.edu', '$2y$10$04EtjgAayWwncvfOOHPP/uV2ABSPti7S23ZevD5uBsvojkpzgHUdq', 'uploads/6853c6b2c1071.jpg', 'Saaa'),
(10, 'Ted Njiru', 'muletedd@gmail.com', '$2y$10$Ytt0zQRAbTJYo0PQtPdxseFLMpCniQkQskVic2TUmGAq6SFEp7y/6', 'uploads/685bc15f5f9a5.jpg', 'Lakenya');

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
(25, 'TEDDD', 'ted.njiru@strathmore.edu', '$2y$10$rM0thUV00ZznGl5Uq29i7.pDjJW4Xdv9hMnetxgIMstsE8GpOsRQS', 'uploads/6853c53a1dd03.jpg'),
(26, 'Ted', 'muletedd@gmail.com', '$2y$10$X.sMuyt0C0HIG0Fvh/YHS.12PLjJyfUE7nOZJ15dlZ6hFOYE.OOXq', 'uploads/685a946257151.jpg');

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
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `reg_number`, `review`, `rating`, `passenger_id`, `review_date`) VALUES
(2, 'KAQ 952B', 'Its rubbish', 1, 25, '2025-06-23 08:15:36'),
(3, 'KAQ 952B', 'Hyugj', 3, 25, '2025-06-23 11:39:13'),
(4, 'KDA 123G', 'Es ist wunderbar', 4, 25, '2025-06-24 09:30:41'),
(5, 'KDA 123G', 'Its is poorly maintained and driven', 1, 25, '2025-06-24 09:37:46'),
(6, 'KCQ 678P', 'Overloaded and poorly maintained', 2, 26, '2025-06-25 09:37:10'),
(7, 'KDA005A', 'Clean interior, good music.', 4, 25, '2025-06-25 10:25:51'),
(8, 'KDA302B', 'Affordable but crowded.', 3, 26, '2025-06-25 10:25:51'),
(9, 'KDC222C', 'Fast and respectful driver.', 5, 25, '2025-06-25 10:25:51'),
(10, 'KDE909D', 'Smooth ride and polite crew.', 4, 26, '2025-06-25 10:25:51'),
(11, 'KDF781E', 'Loud music and occasional delays.', 2, 25, '2025-06-25 10:25:51'),
(12, 'KDG110F', 'Sometimes late', 3, 26, '2025-06-25 10:25:51'),
(13, 'KDH808G', 'Quiet, respectful passengers.', 4, 25, '2025-06-25 10:25:51');

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
  MODIFY `owner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `passenger_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
