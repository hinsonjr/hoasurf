-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2021 at 11:23 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hoasurf`
--

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address1` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`id`, `name`, `address1`, `address2`, `city`, `state`, `zip`) VALUES
(1, 'South Building', '6727 Turtlemound Rd', NULL, 'New Smyrna Beach', 'FL', '32169'),
(2, 'North Building', '6713 Turtlemound Rd.', NULL, 'New Smyrna Beach', 'FL', '32169');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `firstname`, `lastname`, `start_date`, `end_data`) VALUES
(1, 'Hinson and Sharon', 'Stephens', '2020-09-11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `owner_user`
--

CREATE TABLE `owner_user` (
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owner_user`
--

INSERT INTO `owner_user` (`owner_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `unit_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text DEFAULT NULL,
  `sf` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beds` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `baths` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_sale_data` date DEFAULT NULL,
  `current_owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `building_id`, `unit_number`, `description`, `sf`, `beds`, `baths`, `last_sale_data`, `current_owner_id`) VALUES
(2, 1, '215', '2nd Floor by the pool' , '1406', '3', '2', '2020-09-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `unit_owner`
--

CREATE TABLE `unit_owner` (
  `unit_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `roles`, `password`, `is_verified`) VALUES
(1, 'hinsonjr@outlook.com', 'Hinson Stephens', '[]', '$2y$13$3qFjtw3jg3tu8zV.GdUMV.kzsg/NcdlF1G90Jp9YUTZO9kY8Mh4Z6', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner_user`
--
ALTER TABLE `owner_user`
  ADD PRIMARY KEY (`owner_id`,`user_id`),
  ADD KEY `IDX_1B35B5D97E3C61F9` (`owner_id`),
  ADD KEY `IDX_1B35B5D9A76ED395` (`user_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DCBB0C534D2A7E12` (`building_id`),
  ADD KEY `IDX_DCBB0C53E3441BD3` (`current_owner_id`);

--
-- Indexes for table `unit_owner`
--
ALTER TABLE `unit_owner`
  ADD PRIMARY KEY (`unit_id`,`owner_id`),
  ADD KEY `IDX_44529877F8BD700D` (`unit_id`),
  ADD KEY `IDX_445298777E3C61F9` (`owner_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `owner_user`
--
ALTER TABLE `owner_user`
  ADD CONSTRAINT `FK_1B35B5D97E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1B35B5D9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `FK_DCBB0C534D2A7E12` FOREIGN KEY (`building_id`) REFERENCES `building` (`id`),
  ADD CONSTRAINT `FK_DCBB0C53E3441BD3` FOREIGN KEY (`current_owner_id`) REFERENCES `owner` (`id`);

--
-- Constraints for table `unit_owner`
--
ALTER TABLE `unit_owner`
  ADD CONSTRAINT `FK_445298777E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_44529877F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
