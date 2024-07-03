-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 10:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `euro`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`) VALUES
(1, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `negara`
--

CREATE TABLE `negara` (
  `id` int(11) NOT NULL,
  `groups_id` int(11) NOT NULL,
  `nama_negara` varchar(100) DEFAULT NULL,
  `menang` int(11) DEFAULT 0,
  `draw` int(11) DEFAULT 0,
  `kalah` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negara`
--

INSERT INTO `negara` (`id`, `groups_id`, `nama_negara`, `menang`, `draw`, `kalah`, `points`) VALUES
(5, 1, 'Jerman', 2, 0, 0, 6),
(6, 1, 'Swiss', 1, 1, 0, 4),
(7, 1, 'Skotlandia', 0, 1, 0, 1),
(8, 1, 'Hungaria', 0, 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nim` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nim`, `password`) VALUES
(1, '211011401046', '$2y$10$tpV5Vo3a42MMDE6scF4G1O2IAr7Eg/BfEZnN.DDyK5HlH/W.SqMYS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `negara`
--
ALTER TABLE `negara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_id` (`groups_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `negara`
--
ALTER TABLE `negara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `negara`
--
ALTER TABLE `negara`
  ADD CONSTRAINT `negara_ibfk_1` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
