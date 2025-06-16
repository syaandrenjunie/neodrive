-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2025 at 02:07 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neodrive`
--
CREATE DATABASE IF NOT EXISTS `neodrive` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `neodrive`;

-- --------------------------------------------------------

--
-- Table structure for table `chat_logs`
--

CREATE TABLE `chat_logs` (
  `chat_log_id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `response` text NOT NULL,
  `sent_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int NOT NULL,
  `member_name` varchar(255) NOT NULL,
  `member_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subunit` varchar(255) DEFAULT NULL,
  `member_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Active',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mindful_notes`
--

CREATE TABLE `mindful_notes` (
  `mnotes_id` int NOT NULL,
  `mood_type` enum('Happy','Stressed','Motivated','Sad','Relieved','Scared') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `m_notes` text NOT NULL,
  `mnotes_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mood_checkin`
--

CREATE TABLE `mood_checkin` (
  `mood_id` int NOT NULL,
  `user_id` int NOT NULL,
  `mood_type` enum('Happy','Stressed','Motivated','Sad','Relieved','Scared') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_note` text,
  `mindful_note_id` int DEFAULT NULL,
  `checkin_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `mood_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photocard_library`
--

CREATE TABLE `photocard_library` (
  `pc_id` int NOT NULL,
  `pc_filepath` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pc_type` enum('Common','Rare','Exclusive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Common',
  `pc_title` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `member_name` varchar(50) DEFAULT NULL,
  `subunit` enum('NCT','NCT127','NCTDREAM','NCTWISH','WAYV','NCTDOJAJEUNG') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pc_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priority_levels`
--

CREATE TABLE `priority_levels` (
  `priority_id` int NOT NULL,
  `level_name` enum('low','medium','high') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotes_library`
--

CREATE TABLE `quotes_library` (
  `quotes_id` int NOT NULL,
  `quotes_text` text NOT NULL,
  `type` enum('motivational','funny','philosophical','romantic','lyrics') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'motivational',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quotes_status` enum('Active','Inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Active',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int NOT NULL,
  `user_id` int NOT NULL,
  `report_type` enum('user','pomodoro','photocard','quotes','mood','todolist','chatbot','member') NOT NULL,
  `parameters` json DEFAULT NULL,
  `generated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `report_filepath` varchar(255) NOT NULL,
  `report_status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timer_sessions`
--

CREATE TABLE `timer_sessions` (
  `session_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_rounds` int NOT NULL,
  `round_duration` int NOT NULL,
  `break_duration` int NOT NULL,
  `completed_rounds` int DEFAULT '0',
  `status` enum('in_progress','completed','cancelled') DEFAULT 'in_progress',
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `to_do_list`
--

CREATE TABLE `to_do_list` (
  `task_id` int NOT NULL,
  `user_id` int NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_details` text,
  `priority_id` int DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `task_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_status` enum('active','inactive') DEFAULT 'active',
  `user_roles` enum('user','admin') DEFAULT 'user',
  `bias` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pccollection`
--

CREATE TABLE `user_pccollection` (
  `userpc_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `pc_id` int DEFAULT NULL,
  `rewarded_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_quotes`
--

CREATE TABLE `user_quotes` (
  `user_id` int NOT NULL,
  `quotes_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD PRIMARY KEY (`chat_log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `mindful_notes`
--
ALTER TABLE `mindful_notes`
  ADD PRIMARY KEY (`mnotes_id`);

--
-- Indexes for table `mood_checkin`
--
ALTER TABLE `mood_checkin`
  ADD PRIMARY KEY (`mood_id`),
  ADD KEY `fk_mood_user` (`user_id`),
  ADD KEY `fk_mindful_note` (`mindful_note_id`);

--
-- Indexes for table `photocard_library`
--
ALTER TABLE `photocard_library`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `priority_levels`
--
ALTER TABLE `priority_levels`
  ADD PRIMARY KEY (`priority_id`),
  ADD UNIQUE KEY `level_name` (`level_name`);

--
-- Indexes for table `quotes_library`
--
ALTER TABLE `quotes_library`
  ADD PRIMARY KEY (`quotes_id`),
  ADD KEY `fk_member` (`member_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `timer_sessions`
--
ALTER TABLE `timer_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `to_do_list`
--
ALTER TABLE `to_do_list`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `priority_id` (`priority_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_pccollection`
--
ALTER TABLE `user_pccollection`
  ADD PRIMARY KEY (`userpc_id`),
  ADD UNIQUE KEY `uc_user_photocard` (`user_id`,`pc_id`),
  ADD KEY `pc_id` (`pc_id`);

--
-- Indexes for table `user_quotes`
--
ALTER TABLE `user_quotes`
  ADD PRIMARY KEY (`user_id`,`quotes_id`),
  ADD KEY `quotes_id` (`quotes_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_logs`
--
ALTER TABLE `chat_logs`
  MODIFY `chat_log_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mindful_notes`
--
ALTER TABLE `mindful_notes`
  MODIFY `mnotes_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mood_checkin`
--
ALTER TABLE `mood_checkin`
  MODIFY `mood_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photocard_library`
--
ALTER TABLE `photocard_library`
  MODIFY `pc_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priority_levels`
--
ALTER TABLE `priority_levels`
  MODIFY `priority_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotes_library`
--
ALTER TABLE `quotes_library`
  MODIFY `quotes_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timer_sessions`
--
ALTER TABLE `timer_sessions`
  MODIFY `session_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `to_do_list`
--
ALTER TABLE `to_do_list`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pccollection`
--
ALTER TABLE `user_pccollection`
  MODIFY `userpc_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_logs`
--
ALTER TABLE `chat_logs`
  ADD CONSTRAINT `chat_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `mood_checkin`
--
ALTER TABLE `mood_checkin`
  ADD CONSTRAINT `fk_mindful_note` FOREIGN KEY (`mindful_note_id`) REFERENCES `mindful_notes` (`mnotes_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mood_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `quotes_library`
--
ALTER TABLE `quotes_library`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`),
  ADD CONSTRAINT `fk_member_id` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `timer_sessions`
--
ALTER TABLE `timer_sessions`
  ADD CONSTRAINT `timer_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `to_do_list`
--
ALTER TABLE `to_do_list`
  ADD CONSTRAINT `to_do_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `to_do_list_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `priority_levels` (`priority_id`);

--
-- Constraints for table `user_pccollection`
--
ALTER TABLE `user_pccollection`
  ADD CONSTRAINT `user_pccollection_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_pccollection_ibfk_2` FOREIGN KEY (`pc_id`) REFERENCES `photocard_library` (`pc_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_quotes`
--
ALTER TABLE `user_quotes`
  ADD CONSTRAINT `user_quotes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quotes_ibfk_2` FOREIGN KEY (`quotes_id`) REFERENCES `quotes_library` (`quotes_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
