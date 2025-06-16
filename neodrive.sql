-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2025 at 02:00 PM
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

--
-- Dumping data for table `chat_logs`
--

INSERT INTO `chat_logs` (`chat_log_id`, `user_id`, `message`, `response`, `sent_at`) VALUES
(1, 38, 'hye', 'Sorry, I don\'t quite understand that yet. 😅', '2025-06-15 21:36:41'),
(2, 38, 'hello', 'Hi there! 😊 How can I assist you?', '2025-06-15 21:36:46'),
(3, 38, 'hyee', 'Hi there! 😊 How can I assist you?', '2025-06-15 21:43:11'),
(4, 38, 'i miss renjun', 'Aww 🥺 you miss Renjun? Same here! Let’s stay motivated and make them proud 💚', '2025-06-15 21:43:16'),
(5, 38, 'im tired', 'Hmm... I\'m still learning 🧠 Can you try rephrasing that?', '2025-06-15 21:43:37'),
(6, 38, 'hye', 'Hi there! 😊 How can I assist you?', '2025-06-15 21:45:55'),
(7, 38, 'im tired', 'Sounds like you need a break 🧘‍♀️ Don’t forget to rest. You’re doing your best!', '2025-06-15 21:46:00'),
(8, 38, 'okay', 'Hmm... I\'m still learning 🧠 Can you try rephrasing that?', '2025-06-15 21:46:06'),
(9, 38, 'hyee', 'Hi there! 😊 How can I assist you?', '2025-06-15 21:50:13'),
(10, 38, 'okay', 'Sure thing! ✨', '2025-06-15 21:50:19'),
(11, 38, 'byee', 'Goodbye! 👋 Come back soon and keep up the great work!', '2025-06-15 21:50:54'),
(12, 38, 'hyee', 'Hi there! 😊 How can I assist you?', '2025-06-15 21:56:41'),
(13, 38, 'hyee', 'Hi there! 😊 How can I assist you?', '2025-06-15 21:59:51'),
(14, 38, 'hallu', 'Hi there! 😊 How can I assist you?', '2025-06-15 22:00:22'),
(15, 38, 'bye', 'Goodbye! 👋 Come back soon and keep up the great work!', '2025-06-15 22:01:07'),
(16, 38, 'i miss', 'Hmm... I\'m still learning 🧠 Can you try rephrasing that?', '2025-06-15 22:19:22'),
(17, 38, 'i miss mark', 'Aww 🥺 you miss Mark? Same here! Let’s stay motivated and make them proud 💚', '2025-06-15 22:19:30'),
(18, 38, 'hye', 'Hi there! 😊 How can I assist you?', '2025-06-16 06:35:51'),
(19, 38, 'i miss mark', 'Aww 🥺 you miss Mark? Same here! Let’s stay motivated and make them proud 💚', '2025-06-16 06:36:00'),
(20, 38, 'im tired', 'Sounds like you need a break 🧘‍♀️ Don’t forget to rest. You’re doing your best!', '2025-06-16 06:36:06'),
(21, 38, 'okii', 'Yes, boss 😎', '2025-06-16 06:37:05'),
(22, 38, 'bye', 'Goodbye! 👋 Come back soon and keep up the great work!', '2025-06-16 06:37:10');

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

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_name`, `member_type`, `subunit`, `member_status`, `updated_at`) VALUES
(1, 'Taeyong', 'NCT', 'NCT127', 'Active', '2025-06-09 14:54:09'),
(2, 'Yuta', 'NCT', 'NCT127', 'Active', '2025-06-09 14:54:09'),
(3, 'Jaehyun', 'NCT', 'NCT127', 'Active', '2025-06-09 14:54:09'),
(11, 'Haechan', 'NCT', 'NCTDREAM', 'Active', '2025-06-09 14:54:09'),
(13, 'Jeno', 'NCT', 'NCT Dream', 'Active', '2025-06-09 15:46:15'),
(17, 'Jaemin', 'NCT', 'NCT DREAM', 'Active', '2025-06-09 14:54:09'),
(18, 'Jisung', 'NCT', 'NCT DREAM', 'Active', '2025-06-09 14:54:09'),
(21, 'Renjun', 'NCT', 'NCT DREAM', 'Active', '2025-06-09 14:54:09'),
(22, 'Chenle', 'NCT', 'NCT DREAM', 'Active', '2025-06-09 14:54:09'),
(23, 'Yangyang', 'NCT', 'WayV', 'Active', '2025-06-09 14:54:09'),
(26, 'Kun', 'NCT', 'WayV', 'Active', '2025-06-09 14:54:09'),
(27, 'Xiaojun', 'NCT', 'WayV', 'Active', '2025-06-09 14:54:09'),
(28, 'Hendery', 'NCT', 'WayV', 'Active', '2025-06-09 14:54:09'),
(29, 'Ten', 'NCT', 'WayV', 'Active', '2025-06-09 14:54:09'),
(30, 'Sion', 'NCT', 'NCT WISH', 'Active', '2025-06-09 14:54:09'),
(31, 'Ryo', 'NCT', 'NCT WISH', 'Active', '2025-06-09 14:54:09'),
(32, 'Sakuya', 'NCT', 'NCT WISH', 'Active', '2025-06-09 14:54:09'),
(33, 'Yushi', 'NCT', 'NCT WISH', 'Active', '2025-06-09 14:54:09'),
(41, 'Halim', 'Other', 'None', 'Inactive', '2025-06-09 15:46:57'),
(42, 'Winwin', 'NCT', 'WayV', 'Active', '2025-06-09 15:56:04'),
(43, 'Chris', 'Other', 'None', 'Active', '2025-06-09 15:54:19');

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

--
-- Dumping data for table `mindful_notes`
--

INSERT INTO `mindful_notes` (`mnotes_id`, `mood_type`, `m_notes`, `mnotes_status`, `updated_at`, `created_at`) VALUES
(3, 'Stressed', 'I am safe in this moment. I can breathe and let go, even just a little.', 'Inactive', '2025-04-18 08:48:04', '2025-04-15 00:14:29'),
(4, 'Happy', 'I deserve to feel this light and warmth', 'Inactive', '2025-04-18 08:32:00', '2025-04-15 01:36:36'),
(5, 'Motivated', 'Every small step forward builds my momentum.', 'Active', '2025-04-15 01:38:03', '2025-04-15 01:38:03'),
(6, 'Sad', 'This too shall pass. I am not alone.', 'Active', '2025-04-15 01:38:21', '2025-04-15 01:38:21'),
(7, 'Relieved', 'Now, I breathe a little easier and honor this peace.', 'Active', '2025-04-15 01:38:43', '2025-04-15 01:38:43'),
(8, 'Stressed', 'One step at a time — I don’t have to do it all at once.', 'Active', '2025-04-15 01:38:59', '2025-04-15 01:38:59'),
(9, 'Scared', 'Courage doesn’t mean I’m not afraid — it means I keep going anyway.', 'Active', '2025-04-15 01:39:20', '2025-04-15 01:39:20'),
(10, 'Happy', 'Thats good, sunshine!', 'Active', '2025-04-15 02:07:10', '2025-04-15 02:07:10'),
(11, 'Happy', 'Have a good day today!', 'Active', '2025-04-15 04:23:53', '2025-04-15 04:23:53');

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

--
-- Dumping data for table `mood_checkin`
--

INSERT INTO `mood_checkin` (`mood_id`, `user_id`, `mood_type`, `user_note`, `mindful_note_id`, `checkin_at`, `mood_status`) VALUES
(1, 1, 'Happy', 'im so happy today', 4, '2025-04-15 02:06:36', 'Active'),
(4, 1, 'Motivated', 'lets go', 5, '2025-04-15 02:14:20', 'Active'),
(8, 1, 'Stressed', 'penat', 8, '2025-04-15 02:16:59', 'Active'),
(9, 1, 'Scared', 'im so scared', 9, '2025-04-15 02:19:52', 'Active'),
(10, 1, 'Sad', 'im so sad', 6, '2025-04-15 02:23:23', 'Active'),
(18, 1, 'Motivated', 'im working on my fyp today', 5, '2025-04-15 04:25:17', 'Active'),
(22, 1, 'Happy', 'im work', 11, '2025-04-15 04:25:34', 'Active'),
(25, 1, 'Sad', 'sad so sad', 6, '2025-04-16 10:35:11', 'Active'),
(27, 1, 'Motivated', 'yihaaa', 5, '2025-04-16 10:37:41', 'Active'),
(28, 1, 'Relieved', 'alhamdulillah', 7, '2025-04-16 10:38:25', 'Active'),
(30, 1, 'Stressed', '', 3, '2025-04-16 10:40:34', 'Inactive'),
(31, 4, 'Stressed', 'im so tired of this  fyp', NULL, '2025-04-21 11:11:35', 'Active'),
(32, 4, 'Scared', 'im so scared for presentattion nect  week', 9, '2025-04-21 11:12:39', 'Active'),
(43, 1, 'Scared', 'im scared of the fyp', 9, '2025-04-22 17:15:33', 'Active'),
(44, 1, 'Relieved', 'alhamdulillah, my functions work well', 7, '2025-04-22 17:16:02', 'Active'),
(45, 1, 'Happy', '', 10, '2025-04-22 17:19:05', 'Active'),
(48, 1, 'Scared', 'im so scared of presentation tomorrow', 9, '2025-04-22 17:23:51', 'Active'),
(49, 23, 'Scared', 'Today is my  fyp progress presentation', 9, '2025-04-22 23:16:22', 'Active'),
(50, 23, 'Motivated', 'I cant wait to present my progress today!', 5, '2025-04-22 23:16:53', 'Active'),
(51, 23, 'Happy', 'Saya akan ke pulau hari esok', 11, '2025-04-23 01:30:00', 'Active'),
(52, 1, 'Stressed', 'hmmm', 8, '2025-05-24 08:41:02', 'Active'),
(53, 1, 'Relieved', '', 7, '2025-05-24 15:51:23', 'Active'),
(54, 1, 'Relieved', '', 7, '2025-05-24 16:05:07', 'Active'),
(55, 1, 'Motivated', 'lets go', 5, '2025-05-24 17:05:00', 'Active'),
(56, 1, 'Sad', 'im sad', 6, '2025-05-24 17:10:48', 'Active'),
(57, 36, 'Stressed', 'i dont know if i have enough time or not', 8, '2025-06-12 03:04:05', 'Active'),
(58, 36, 'Happy', 'Berjaya siapkan assignment AI', 10, '2025-06-12 04:49:13', 'Active'),
(59, 38, 'Sad', 'I wanna sleep so bad huaa', 6, '2025-06-15 18:43:29', 'Active'),
(60, 38, 'Happy', '', 10, '2025-06-15 19:18:44', 'Active'),
(61, 38, 'Relieved', '', 7, '2025-06-15 19:18:51', 'Active'),
(62, 38, 'Stressed', '', 8, '2025-06-15 19:18:58', 'Active'),
(63, 38, 'Scared', '', 9, '2025-06-15 19:19:04', 'Active'),
(64, 38, 'Motivated', '', 5, '2025-06-15 19:19:09', 'Active'),
(65, 38, 'Sad', '', 6, '2025-06-15 22:18:53', 'Active'),
(66, 38, 'Motivated', 'yeayy', 5, '2025-06-16 06:35:01', 'Active');

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

--
-- Dumping data for table `photocard_library`
--

INSERT INTO `photocard_library` (`pc_id`, `pc_filepath`, `pc_type`, `pc_title`, `member_name`, `subunit`, `pc_status`, `created_at`, `updated_at`) VALUES
(8, 'assets/photocards/rj7.jpeg', 'Exclusive', 'pink hair', 'Renjun', 'NCTDREAM', 'Active', '2025-04-13 15:39:54', '2025-04-13 15:39:54'),
(9, 'assets/photocards/IMG_1202.JPG', 'Common', 'Peacee', 'Yangyang', 'WAYV', 'Active', '2025-04-14 01:49:22', '2025-04-23 01:09:26'),
(10, 'assets/photocards/IMG_1195.JPG', 'Exclusive', 'Woww', 'Winwin', 'WAYV', 'Active', '2025-04-14 01:51:33', '2025-06-09 16:09:51'),
(11, 'assets/photocards/IMG_1199.JPG', 'Common', 'j,h', 'Riku', 'NCTWISH', 'Active', '2025-04-14 01:52:45', '2025-04-14 01:52:45'),
(12, 'assets/photocards/2022-02-11 (1).png', 'Common', 'lol', 'Xiaojun', 'WAYV', 'Active', '2025-04-14 01:58:09', '2025-04-14 10:32:46'),
(13, 'assets/photocards/Screenshot (17).png', 'Common', 'Hye czennie!', 'Taeyong', 'NCT127', 'Active', '2025-04-15 04:16:49', '2025-04-15 04:17:30'),
(14, 'assets/photocards/photo_2025-04-21_19-06-27.jpg', 'Common', 'Sasaa at the  beach', 'Yuta', 'NCT127', 'Active', '2025-04-21 11:07:09', '2025-04-22 01:58:49'),
(15, 'assets/photocards/yuta.jpg', 'Common', 'Rawr!', 'Yuta', 'NCT127', 'Active', '2025-04-22 02:00:18', '2025-04-22 02:00:18'),
(16, 'assets/photocards/IMG_8055.JPG', 'Common', 'With Leon', 'Xiaojun', 'WAYV', 'Active', '2025-04-23 01:35:45', '2025-04-23 01:35:45'),
(18, 'assets/photocards/IMG_8054.JPG', 'Rare', 'Nyangi nyangi', 'Jaemin', 'NCTDREAM', 'Active', '2025-06-09 16:27:50', '2025-06-09 16:27:50'),
(22, 'assets/photocards/IMG_8053.JPG', 'Common', 'Pout', 'Taeyong', 'NCT127', 'Active', '2025-06-09 16:41:26', '2025-06-10 05:53:26'),
(24, 'assets/photocards/cutie.jpg', 'Common', 'Akiyowooo', 'Renjun', 'NCTDREAM', 'Active', '2025-06-16 10:50:50', '2025-06-16 10:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `priority_levels`
--

CREATE TABLE `priority_levels` (
  `priority_id` int NOT NULL,
  `level_name` enum('low','medium','high') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `priority_levels`
--

INSERT INTO `priority_levels` (`priority_id`, `level_name`) VALUES
(1, 'low'),
(2, 'medium'),
(3, 'high');

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

--
-- Dumping data for table `quotes_library`
--

INSERT INTO `quotes_library` (`quotes_id`, `quotes_text`, `type`, `created_at`, `quotes_status`, `updated_at`, `member_id`) VALUES
(2, 'Knowing which part of yourself is lacking, is also an amazing strength', 'motivational', '2025-04-12 14:03:33', 'Active', '2025-04-12 14:03:33', NULL),
(3, 'Today is a good day', 'philosophical', '2025-04-15 04:18:46', 'Active', '2025-04-15 04:19:00', NULL),
(5, 'Dream high, instead of satisfied of what i have done', 'motivational', '2025-04-21 03:55:13', 'Active', '2025-04-22 16:14:17', 13),
(6, 'I think at the end of the day, the only who stays by our side is our own self. Therefore, we should know ourselves better than anyone', 'motivational', '2025-04-21 03:55:48', 'Active', '2025-04-22 16:16:45', 2),
(7, 'Your efforts will never betray you. All your efforts will pay off.', 'motivational', '2025-04-21 05:15:41', 'Active', '2025-04-21 05:15:41', 1),
(8, 'You can look back when you are tired. Look around you and try not to lose yourself.', 'motivational', '2025-04-21 05:19:07', 'Active', '2025-04-21 05:19:07', 1),
(10, 'You can look back when you are tired. Look around you and try not to lose yourself.', 'funny', '2025-04-21 05:25:59', 'Active', '2025-04-21 05:25:59', 1),
(11, '2 Baddies 2 Baddies 1 Porsche', 'funny', '2025-04-21 05:31:42', 'Active', '2025-04-22 16:22:16', 3),
(12, 'Do not be afraid to fail, be afraid not to try', 'motivational', '2025-04-21 05:58:11', 'Active', '2025-04-22 16:21:29', 11),
(13, 'Do not forget to eat everyone!', 'romantic', '2025-04-23 00:08:31', 'Active', '2025-04-23 00:09:06', 17),
(14, 'My life is for me to lead so I will just be me\r\n\r\n', 'motivational', '2025-04-23 01:37:20', 'Active', '2025-04-23 01:37:20', 21);

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

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`report_id`, `user_id`, `report_type`, `parameters`, `generated_at`, `report_filepath`, `report_status`) VALUES
(6, 35, 'pomodoro', '{\"to\": \"2025-06-10\", \"from\": \"2025-06-09\", \"params\": [\"date_range\", \"user_id\", \"status\"]}', '2025-06-16 19:53:36', '../../assets/reports/report_pomodoro_1750074816.pdf', 'Active'),
(7, 35, 'pomodoro', '{\"to\": \"2025-06-12\", \"from\": \"2025-06-09\", \"params\": [\"date_range\", \"user_id\", \"status\"]}', '2025-06-16 19:53:58', '../../assets/reports/report_pomodoro_1750074838.pdf', 'Active'),
(8, 35, 'pomodoro', '{\"to\": \"2025-06-10\", \"from\": \"2025-06-09\", \"params\": [\"date_range\", \"user_id\", \"status\"]}', '2025-06-16 21:43:45', '../../assets/reports/report_pomodoro_1750081425.pdf', 'Active'),
(9, 35, 'user', '{\"to\": \"\", \"from\": \"\", \"params\": [\"date_range\", \"user_id\", \"status\"]}', '2025-06-16 21:43:48', '../../assets/reports/report_user_1750081428.pdf', 'Active');

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

--
-- Dumping data for table `timer_sessions`
--

INSERT INTO `timer_sessions` (`session_id`, `user_id`, `total_rounds`, `round_duration`, `break_duration`, `completed_rounds`, `status`, `started_at`, `ended_at`, `created_at`) VALUES
(21, 1, 1, 2, 2, 0, 'in_progress', '2025-05-30 04:19:51', NULL, '2025-05-30 04:19:51'),
(22, 1, 1, 25, 2, 0, 'in_progress', '2025-05-30 04:21:01', NULL, '2025-05-30 04:21:01'),
(23, 1, 2, 2, 2, 0, 'in_progress', '2025-05-30 04:21:42', NULL, '2025-05-30 04:21:42'),
(24, 1, 2, 2, 2, 0, 'in_progress', '2025-05-30 05:36:19', NULL, '2025-05-30 05:36:19'),
(25, 35, 1, 1, 1, 0, 'in_progress', '2025-05-30 06:35:39', NULL, '2025-05-30 06:35:40'),
(26, 35, 2, 1, 1, 0, 'in_progress', '2025-05-30 06:47:38', NULL, '2025-05-30 06:47:38'),
(27, 1, 1, 1, 5, 0, 'in_progress', '2025-05-30 06:52:15', NULL, '2025-05-30 06:52:15'),
(28, 1, 1, 1, 1, 1, 'completed', '2025-05-30 06:57:40', NULL, '2025-05-30 06:57:40'),
(33, 36, 1, 2, 2, 1, 'completed', '2025-05-30 15:48:11', '2025-05-30 23:50:19', '2025-05-30 15:48:11'),
(34, 1, 1, 1, 1, 0, 'in_progress', '2025-06-10 16:02:51', NULL, '2025-06-10 16:02:51'),
(35, 1, 1, 1, 1, 0, 'in_progress', '2025-06-10 16:14:50', NULL, '2025-06-10 16:14:50'),
(36, 1, 1, 1, 1, 1, 'completed', '2025-06-11 03:13:08', '2025-06-11 11:14:11', '2025-06-11 03:13:08'),
(37, 1, 1, 1, 1, 1, 'completed', '2025-06-11 03:14:56', '2025-06-11 11:15:58', '2025-06-11 03:14:56'),
(38, 1, 2, 1, 1, 2, 'completed', '2025-06-11 03:16:29', '2025-06-11 11:19:53', '2025-06-11 03:16:29'),
(39, 1, 2, 1, 1, 0, 'in_progress', '2025-06-11 03:16:29', NULL, '2025-06-11 03:16:29'),
(40, 1, 3, 1, 1, 3, 'completed', '2025-06-11 03:21:44', '2025-06-11 11:28:10', '2025-06-11 03:21:44'),
(41, 1, 3, 1, 1, 3, 'in_progress', '2025-06-11 03:56:53', NULL, '2025-06-11 03:56:53'),
(42, 1, 4, 1, 1, 0, 'in_progress', '2025-06-11 04:07:17', NULL, '2025-06-11 04:07:17'),
(43, 1, 3, 1, 1, 3, 'in_progress', '2025-06-11 04:25:58', NULL, '2025-06-11 04:25:58'),
(44, 1, 3, 1, 1, 3, 'in_progress', '2025-06-11 04:32:06', NULL, '2025-06-11 04:32:06'),
(45, 36, 2, 1, 1, 2, 'completed', '2025-06-11 10:35:48', '2025-06-11 18:49:28', '2025-06-11 10:35:48'),
(46, 36, 1, 1, 1, 0, 'in_progress', '2025-06-11 10:52:03', NULL, '2025-06-11 10:52:03'),
(47, 36, 1, 1, 1, 0, 'in_progress', '2025-06-11 11:17:38', NULL, '2025-06-11 11:17:38'),
(48, 36, 2, 1, 1, 0, 'in_progress', '2025-06-11 11:20:02', NULL, '2025-06-11 11:20:02'),
(49, 36, 1, 1, 1, 0, 'in_progress', '2025-06-11 11:22:09', NULL, '2025-06-11 11:22:10'),
(50, 36, 2, 1, 1, 0, 'in_progress', '2025-06-11 11:23:34', NULL, '2025-06-11 11:23:34'),
(51, 36, 1, 1, 1, 0, 'in_progress', '2025-06-11 11:25:49', NULL, '2025-06-11 11:25:49'),
(52, 36, 2, 1, 1, 0, 'in_progress', '2025-06-11 11:27:17', NULL, '2025-06-11 11:27:17'),
(53, 36, 2, 1, 1, 2, 'completed', '2025-06-11 11:29:00', '2025-06-11 19:32:29', '2025-06-11 11:29:00'),
(54, 36, 2, 1, 1, 2, 'completed', '2025-06-11 12:39:53', '2025-06-11 20:45:31', '2025-06-11 12:39:53'),
(55, 36, 3, 1, 1, 3, 'completed', '2025-06-11 16:12:11', '2025-06-12 00:18:05', '2025-06-11 16:12:11'),
(56, 36, 1, 1, 1, 1, 'completed', '2025-06-11 16:30:39', '2025-06-12 00:31:43', '2025-06-11 16:30:39'),
(57, 36, 2, 1, 1, 2, 'completed', '2025-06-11 16:44:37', '2025-06-12 00:49:11', '2025-06-11 16:44:37'),
(58, 36, 3, 1, 1, 3, 'completed', '2025-06-11 16:50:07', '2025-06-12 00:57:50', '2025-06-11 16:50:07'),
(59, 36, 1, 1, 1, 1, 'completed', '2025-06-11 17:45:51', '2025-06-12 01:46:53', '2025-06-11 17:45:51'),
(60, 36, 2, 1, 1, 2, 'completed', '2025-06-11 17:48:09', '2025-06-12 01:51:21', '2025-06-11 17:48:09'),
(61, 36, 2, 1, 1, 2, 'completed', '2025-06-12 02:21:19', '2025-06-12 10:28:39', '2025-06-12 02:21:19'),
(62, 36, 2, 1, 1, 2, 'completed', '2025-06-12 02:32:54', '2025-06-12 10:36:44', '2025-06-12 02:32:54'),
(63, 36, 2, 1, 1, 2, 'completed', '2025-06-12 02:42:34', '2025-06-12 10:45:52', '2025-06-12 02:42:34'),
(64, 36, 2, 1, 1, 2, 'completed', '2025-06-12 04:14:00', '2025-06-12 12:17:13', '2025-06-12 04:14:00'),
(65, 36, 1, 1, 1, 1, 'completed', '2025-06-12 04:17:42', '2025-06-12 12:18:44', '2025-06-12 04:17:42'),
(66, 36, 2, 1, 1, 2, 'completed', '2025-06-12 04:31:21', '2025-06-12 12:34:59', '2025-06-12 04:31:21'),
(67, 1, 2, 1, 1, 2, 'completed', '2025-06-12 05:09:55', '2025-06-12 13:13:11', '2025-06-12 05:09:55'),
(68, 1, 1, 1, 1, 1, 'completed', '2025-06-12 05:25:07', '2025-06-12 13:28:59', '2025-06-12 05:25:07'),
(83, 37, 1, 1, 1, 1, 'completed', '2025-06-13 02:40:23', '2025-06-13 10:41:30', '2025-06-13 02:40:23'),
(84, 37, 1, 1, 1, 0, 'in_progress', '2025-06-13 03:56:30', NULL, '2025-06-13 03:56:30'),
(85, 37, 1, 2, 1, 1, 'completed', '2025-06-13 03:58:42', '2025-06-13 12:00:45', '2025-06-13 03:58:42'),
(86, 37, 1, 1, 1, 1, 'completed', '2025-06-13 04:06:47', '2025-06-13 12:07:52', '2025-06-13 04:06:48'),
(87, 37, 2, 1, 1, 2, 'completed', '2025-06-13 04:08:38', '2025-06-13 12:11:53', '2025-06-13 04:08:38'),
(88, 37, 1, 1, 1, 1, 'completed', '2025-06-13 04:19:35', '2025-06-13 12:20:44', '2025-06-13 04:19:35'),
(89, 37, 1, 1, 1, 1, 'completed', '2025-06-13 04:25:29', '2025-06-13 12:27:11', '2025-06-13 04:25:29'),
(90, 37, 1, 1, 1, 1, 'completed', '2025-06-13 04:30:42', '2025-06-13 12:31:44', '2025-06-13 04:30:42'),
(91, 1, 2, 1, 1, 2, 'completed', '2025-06-15 18:22:13', '2025-06-16 02:28:57', '2025-06-15 18:22:13'),
(92, 37, 1, 1, 1, 1, 'completed', '2025-06-15 18:29:40', '2025-06-16 02:31:06', '2025-06-15 18:29:40'),
(93, 37, 1, 1, 1, 1, 'completed', '2025-06-15 18:31:19', '2025-06-16 02:32:31', '2025-06-15 18:31:19'),
(94, 37, 1, 1, 1, 1, 'completed', '2025-06-15 18:32:53', '2025-06-16 02:33:56', '2025-06-15 18:32:53'),
(95, 37, 2, 1, 1, 2, 'completed', '2025-06-15 18:34:14', '2025-06-16 02:37:55', '2025-06-15 18:34:14'),
(96, 38, 1, 1, 1, 1, 'completed', '2025-06-15 18:38:49', '2025-06-16 02:39:58', '2025-06-15 18:38:49'),
(97, 38, 1, 1, 1, 1, 'completed', '2025-06-15 18:40:19', '2025-06-16 02:41:21', '2025-06-15 18:40:19'),
(98, 38, 1, 1, 1, 0, 'in_progress', '2025-06-15 19:07:45', NULL, '2025-06-15 19:07:45'),
(99, 38, 1, 1, 1, 0, 'in_progress', '2025-06-15 19:09:24', NULL, '2025-06-15 19:09:24'),
(100, 38, 1, 1, 1, 0, 'in_progress', '2025-06-15 19:10:36', NULL, '2025-06-15 19:10:36'),
(101, 38, 2, 1, 1, 2, 'completed', '2025-06-15 22:11:09', '2025-06-16 06:18:13', '2025-06-15 22:11:09'),
(102, 38, 1, 1, 1, 0, 'in_progress', '2025-06-15 22:52:54', NULL, '2025-06-15 22:52:54'),
(103, 38, 1, 1, 1, 0, 'in_progress', '2025-06-15 22:53:23', NULL, '2025-06-15 22:53:23'),
(104, 38, 1, 1, 1, 0, 'in_progress', '2025-06-16 06:40:05', NULL, '2025-06-16 06:40:05');

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

--
-- Dumping data for table `to_do_list`
--

INSERT INTO `to_do_list` (`task_id`, `user_id`, `task_name`, `task_details`, `priority_id`, `is_completed`, `created_at`, `updated_at`, `task_status`) VALUES
(1, 1, ',m.', '. k', 2, 0, '2025-04-22 10:38:30', '2025-05-24 15:29:42', 'Inactive'),
(2, 1, 'test', 'testt', 2, 0, '2025-04-22 10:59:58', '2025-05-30 17:53:51', 'Inactive'),
(3, 1, 'fersg', 'gsdg', 1, 1, '2025-04-22 11:29:28', '2025-05-24 15:26:42', 'Inactive'),
(5, 1, 'gsergbgfn', 'gfbx', 1, 1, '2025-04-22 12:40:50', '2025-05-24 15:27:13', 'Inactive'),
(8, 1, 'ok', 'ok', 2, 0, '2025-04-22 12:58:18', '2025-05-24 15:50:53', 'Inactive'),
(9, 1, 'orait', 'rehsth', 3, 0, '2025-04-22 18:10:01', '2025-05-24 15:55:01', 'Inactive'),
(10, 1, 'jii', '', 2, 0, '2025-04-22 19:15:12', '2025-05-24 15:30:07', 'Inactive'),
(11, 1, 'weii', '', 1, 0, '2025-04-22 19:24:12', '2025-05-24 15:30:49', 'Inactive'),
(12, 23, 'presentation progress', '23/4/2025', 3, 1, '2025-04-23 07:10:42', '2025-04-23 09:27:55', 'Active'),
(13, 23, 'data mining case study', '', 2, 1, '2025-04-23 07:11:35', '2025-04-23 07:22:13', 'Active'),
(14, 23, 'makan ikan', '', 2, 1, '2025-04-23 07:12:39', '2025-04-23 07:13:05', 'Active'),
(15, 23, 'fyp2', 'harini', 2, 0, '2025-04-23 09:27:25', '2025-04-23 09:27:25', 'Active'),
(16, 1, 'testt', 'test2', 2, 1, '2025-05-20 17:28:58', '2025-05-24 15:36:55', 'Inactive'),
(17, 1, 'cuba', '', 3, 0, '2025-05-24 15:38:55', '2025-05-24 15:38:58', 'Inactive'),
(18, 1, 'todolist ok', 'alhamdulillah', 1, 1, '2025-05-24 16:14:07', '2025-05-30 01:43:33', 'Inactive'),
(19, 1, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'gd', 2, 0, '2025-05-24 16:30:15', '2025-05-24 16:35:41', 'Inactive'),
(20, 1, 'ok', '', 3, 1, '2025-05-24 16:39:02', '2025-05-24 16:39:10', 'Inactive'),
(21, 1, 'todolist baru', 'baru', 2, 0, '2025-05-30 00:17:28', '2025-05-30 12:03:54', 'Inactive'),
(23, 1, 'Mi', '', 1, 0, '2025-05-30 17:31:51', '2025-05-30 17:59:08', 'Active'),
(24, 1, 'try timer', '', 1, 0, '2025-05-30 17:51:43', '2025-05-30 17:51:43', 'Active'),
(25, 36, 'exam', 'pai', 3, 1, '2025-05-30 23:45:26', '2025-06-12 12:04:49', 'Active'),
(26, 36, 'kita cuba', 'pcc', 3, 1, '2025-06-12 11:02:58', '2025-06-12 11:03:10', 'Active'),
(27, 36, 'Assignment AI', '30/6', 2, 1, '2025-06-12 12:43:59', '2025-06-12 12:44:42', 'Inactive'),
(28, 38, 'prepare initiary trip', 'they want before 1 July', 2, 1, '2025-06-16 02:42:38', '2025-06-16 02:42:52', 'Active'),
(29, 38, 'test', '', 1, 1, '2025-06-16 03:53:04', '2025-06-16 06:34:31', 'Inactive'),
(30, 38, 'chatlog', 'dah siapp', 3, 1, '2025-06-16 06:06:06', '2025-06-16 06:06:21', 'Active'),
(31, 38, 'kfl', '', 1, 1, '2025-06-16 14:40:15', '2025-06-16 14:40:40', 'Inactive');

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `created_at`, `user_status`, `user_roles`, `bias`, `profile_picture`, `updated_at`) VALUES
(1, 'hye', 'hyesemua@gmail.com', '$2y$10$2HnGpemywQ5kgyFlrRRGLuMteSeshv16YU9nkZlxptxQt6DxJ0RPi', '2025-04-10 04:14:28', 'active', 'user', NULL, NULL, '2025-04-21 10:58:43'),
(3, 'test admin', 'testadmin@gmail.com', '$2y$10$SyLt5OrEstb3H1Kw1X1XDeY8rLa69Q1FCIb5ibS9Pr9ABzCjW7isa', '2025-04-10 04:33:46', 'inactive', 'admin', NULL, NULL, '2025-04-11 15:33:45'),
(4, 'admin 2', 'testadmin2@gmail.com', '$2y$10$nx38pd63kugAr2lQaVkv5./dzEeDRBMSsf/e44dygLykS5E1xxau2', '2025-04-11 13:48:02', 'active', 'admin', NULL, NULL, '2025-04-11 13:48:41'),
(7, 'profnordin', 'profnordin@gmail.com', '$2y$10$ljBzWHo/vnrCjnBUZWs28OLHvuWDGFC1b3L9zRiBsvobsUgaHxqbm', '2025-04-15 04:12:45', 'inactive', 'admin', NULL, '', '2025-04-15 04:15:15'),
(8, 'annisa', 'annisa@gmail.com', '$2y$10$AYTt0YuBDqRCbe.9.0kczun06cXGvCJ4OkrZrs4vizeW.2J3ZB7O6', '2025-04-21 10:59:19', 'active', 'admin', NULL, '', '2025-04-21 10:59:19'),
(10, 'marissa43', 'marissa43@gmail.com', '$2y$10$aKjhR5T1neP61HlIZpB/r.DQC8f.AilQZn6kAfbGV/vI5nqaRUMyy', '2025-04-22 17:33:53', 'active', 'admin', NULL, '', '2025-04-22 17:33:53'),
(23, 'nayralee', 'nayralee@gmail.com', '$2y$10$1W6gnzAUrUgnEIHueMQnWe7JwPYUj7y/G6R2nNVoZzXeUeM5v6ZdS', '2025-04-22 23:07:06', 'active', 'user', NULL, NULL, '2025-04-22 23:07:06'),
(25, 'Admin 3', 'admin3@gmail.com', '$2y$10$MsOHf64dmUxUmDyXnxWZHOzNmhM3VcuPiI729TTtATPeS9SepdzQu', '2025-04-22 23:47:24', 'active', 'admin', NULL, '', '2025-04-22 23:47:24'),
(26, 'aishah', 'aishah@gmail.com', '$2y$10$fdC7xEGdxBZb2JHiLoJQ7uuZGhrrdZeRBu/meOj47yXoUUrHRu3Kq', '2025-04-23 01:33:50', 'active', 'admin', NULL, '', '2025-04-23 01:33:50'),
(27, 'testlagi', 'testlagi@gmail.com', '$2y$10$Pw1EwR9G1MBNP0KSHQMB9efkJqjLaLUkloekPA.rxooMI/cRLnAaO', '2025-05-09 16:45:15', 'active', 'user', NULL, NULL, '2025-05-09 16:45:15'),
(28, 'testlagi3', 'testlagi3@gmail.com', '$2y$10$/TUq2uoTEyosUtPxFIX6HexbE7lhHi0Eo0AFNy7i5kSUHmZl04l3C', '2025-05-09 16:46:21', 'active', 'user', NULL, NULL, '2025-05-09 16:46:21'),
(30, 'testlagi4', 'testlagi4@gmail.com', '$2y$10$7aHkNrUe9rFhhaQ1hNoyeejFVZD4qvSfmLO5x9RiOHROo4unQXoIS', '2025-05-09 16:47:43', 'active', 'user', NULL, NULL, '2025-05-09 16:47:43'),
(31, 'testlagi5', 'testlagi5@gmail.com', '$2y$10$E1i8MgcdRtThaoEg4GdBiubff/q85HC/cKvY4a01weqiITreGVNua', '2025-05-09 17:06:02', 'active', 'user', NULL, NULL, '2025-05-09 17:06:02'),
(32, 'testlagi6', 'testlagi6@gmail.com', '$2y$10$yN7lH0YnXuL7.W1dHqzT7ekAYgIRwpb9zOu/6Kql7pY7ruMtMOCuC', '2025-05-09 17:08:37', 'active', 'user', NULL, NULL, '2025-05-09 17:08:37'),
(33, 'testlagi7', 'testlagi7@gmail.com', '$2y$10$9Oa8x4Hth/hc/5c1sLqCb.QVR9XSJhInunPKyTGksCxGr2emMn.W2', '2025-05-09 17:15:14', 'active', 'user', NULL, NULL, '2025-05-09 17:15:14'),
(34, 'testlagi8', 'testlagi8@gmail.com', '$2y$10$0WWbOypmHmaVLcbBWFzfFuWfRECiyiEC4mHm2puhIfhkGvmlN6mwi', '2025-05-09 17:20:07', 'inactive', 'user', NULL, NULL, '2025-05-30 06:02:29'),
(35, 'admin 1', 'admin1@gmail.com', '$2y$10$Elh88cSanCiZQRnd5R6/2eO0c8Ypp6MA0HJu2Tc2ki1TX7t4pFI5O', '2025-05-24 02:59:19', 'active', 'admin', NULL, NULL, '2025-05-24 03:00:13'),
(36, 'zana', 'zana@gmail.com', '$2y$10$6ohGfZKV92Jv/JAfyUF2MeJERlKMeg2AvjOEUaUPyKgHpRWIJELQi', '2025-05-30 15:43:14', 'active', 'user', NULL, NULL, '2025-05-30 15:43:14'),
(37, 'ainina', 'ainina@gmail.com', '$2y$10$PtUigVEda45gjTTUzRRShOXM23lB6SWsFgZW8XgKouUrUmv6BLAk6', '2025-06-12 13:25:45', 'active', 'user', NULL, NULL, '2025-06-12 13:25:45'),
(38, 'fifi', 'fifi@gmail.com', '$2y$10$BO.Dx3iuJ44Se5IbVLgbz.Mo43DJeVOys25gwsg2usxCcae0pyAi6', '2025-06-15 18:38:27', 'active', 'user', 'Hendery', 'assets/uploads/profile_38_1750019281.jpeg', '2025-06-15 22:19:45');

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

--
-- Dumping data for table `user_pccollection`
--

INSERT INTO `user_pccollection` (`userpc_id`, `user_id`, `pc_id`, `rewarded_at`) VALUES
(15, 37, 9, '2025-06-13 10:06:40'),
(17, 37, 13, '2025-06-13 10:29:46'),
(18, 37, 15, '2025-06-13 10:33:52'),
(19, 37, 12, '2025-06-13 10:36:35'),
(20, 37, 18, '2025-06-13 10:41:30'),
(21, 37, 11, '2025-06-13 12:00:45'),
(22, 37, 22, '2025-06-13 12:07:52'),
(24, 37, 16, '2025-06-13 12:20:44'),
(25, 37, 8, '2025-06-13 12:27:11'),
(26, 37, 14, '2025-06-13 12:31:44'),
(27, 1, 10, '2025-06-16 02:28:57'),
(28, 37, 10, '2025-06-16 02:31:06'),
(29, 38, 15, '2025-06-16 02:39:58'),
(30, 38, 16, '2025-06-16 02:41:21'),
(31, 38, 12, '2025-06-16 06:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_quotes`
--

CREATE TABLE `user_quotes` (
  `user_id` int NOT NULL,
  `quotes_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_quotes`
--

INSERT INTO `user_quotes` (`user_id`, `quotes_id`) VALUES
(23, 6),
(36, 7),
(38, 7),
(1, 8),
(38, 10),
(1, 11),
(1, 12),
(23, 13);

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
  MODIFY `chat_log_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `mindful_notes`
--
ALTER TABLE `mindful_notes`
  MODIFY `mnotes_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mood_checkin`
--
ALTER TABLE `mood_checkin`
  MODIFY `mood_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `photocard_library`
--
ALTER TABLE `photocard_library`
  MODIFY `pc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `priority_levels`
--
ALTER TABLE `priority_levels`
  MODIFY `priority_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quotes_library`
--
ALTER TABLE `quotes_library`
  MODIFY `quotes_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `timer_sessions`
--
ALTER TABLE `timer_sessions`
  MODIFY `session_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `to_do_list`
--
ALTER TABLE `to_do_list`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_pccollection`
--
ALTER TABLE `user_pccollection`
  MODIFY `userpc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
