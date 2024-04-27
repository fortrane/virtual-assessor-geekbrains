-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2024 at 01:36 AM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tsesehjbsdbjdsjbhg`
--

-- --------------------------------------------------------

--
-- Table structure for table `gb_chat`
--

CREATE TABLE `gb_chat` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sender_type` text NOT NULL,
  `question_id` int NOT NULL,
  `answer_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message_type` text NOT NULL,
  `message_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gb_material`
--

CREATE TABLE `gb_material` (
  `id` int NOT NULL,
  `material_name` text NOT NULL,
  `filename` text NOT NULL,
  `upload_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gb_metrics`
--

CREATE TABLE `gb_metrics` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `question_id` int NOT NULL,
  `metrics` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gb_questions`
--

CREATE TABLE `gb_questions` (
  `id` int NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `material_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gb_tests`
--

CREATE TABLE `gb_tests` (
  `id` int NOT NULL,
  `material_id` int NOT NULL,
  `test_json` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `gb_users`
--

CREATE TABLE `gb_users` (
  `id` int NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `gb_users`
--

INSERT INTO `gb_users` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gb_chat`
--
ALTER TABLE `gb_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_material`
--
ALTER TABLE `gb_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_metrics`
--
ALTER TABLE `gb_metrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_questions`
--
ALTER TABLE `gb_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_tests`
--
ALTER TABLE `gb_tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gb_users`
--
ALTER TABLE `gb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gb_chat`
--
ALTER TABLE `gb_chat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_material`
--
ALTER TABLE `gb_material`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_metrics`
--
ALTER TABLE `gb_metrics`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_questions`
--
ALTER TABLE `gb_questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_tests`
--
ALTER TABLE `gb_tests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gb_users`
--
ALTER TABLE `gb_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
