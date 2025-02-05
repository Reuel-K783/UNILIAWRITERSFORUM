-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2025 at 03:28 AM
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
-- Database: `kavwenje_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('attended','missed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `clothing_id` int(11) NOT NULL,
  `clothing_item` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `plan_type` enum('long-term','short-term') NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_name`, `plan_type`, `start_date`, `end_date`, `details`) VALUES
(2, '29000', 'short-term', '2025-02-02', '2025-03-02', 'Ndinakongola ndalama yokwana 29000 ku bank nkhonde');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_time` time NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `task_time`, `date`, `created_at`) VALUES
(6, 'Analog electronics', '08:00:00', '2025-02-04', '2025-02-04 01:32:30'),
(7, 'Mobile application', '10:00:00', '2025-02-04', '2025-02-04 01:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `timetable_id` int(11) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `activity_type` enum('school','reading','discussion','family_time','friends_time') NOT NULL,
  `activity_time` time NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`timetable_id`, `activity_name`, `activity_type`, `activity_time`, `day_of_week`) VALUES
(4, 'Abstract algebra', 'school', '08:00:00', 'Monday'),
(5, 'System design and analysis', 'school', '10:00:00', 'Monday'),
(6, 'Electrical engineering drawing and installation practice', 'school', '15:30:00', 'Monday'),
(7, 'Mobile Application', 'school', '08:00:00', 'Tuesday'),
(8, 'Electrical engineering drawing and installation practice ', 'school', '15:30:00', 'Tuesday'),
(9, 'Applied analog electronics', 'school', '08:00:00', 'Wednesday'),
(10, 'Abstract algebra', 'school', '13:30:00', 'Wednesday'),
(11, 'Circuit theory', 'school', '10:00:00', 'Wednesday'),
(12, 'Data science', 'school', '15:30:00', 'Wednesday'),
(13, 'Circuit theory', 'school', '10:00:00', 'Thursday'),
(14, 'Mobile application', 'school', '13:30:00', 'Thursday'),
(15, 'Data science', 'school', '15:30:00', 'Thursday'),
(16, 'Applied analog electronics', 'school', '10:00:00', 'Friday');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('income','expense') NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `amount`, `transaction_type`, `category`, `transaction_date`, `notes`) VALUES
(2, 132000.00, 'expense', 'Fertilizer', '2025-02-03', 'Ndinagura fertilizer kukasungu wanthanka'),
(3, 22000.00, 'expense', 'Kugaulitsa ', '2025-01-11', 'Ndinagaulitsa madimba atatu koyamba kwa agogo'),
(4, 7500.00, 'expense', 'Ndinagaulitsa2', '2025-01-21', 'Ndinagaulitsa dimba la number 4 kwa agogo kwakapanga '),
(5, 30000.00, 'expense', 'Ndinalimitsa chimanga', '2024-12-26', 'Ndinalimitsa chimanga akuti Malo othamangira 1 acre'),
(6, 5500.00, 'expense', 'Ndinagura mbewu ', '2024-12-27', 'Ndinagura mbewu ya nyemba'),
(7, 5000.00, 'expense', 'Kuzala mbewu', '2024-12-28', 'Ndinazalitsa mbewu kukasungu'),
(8, 18000.00, 'expense', 'Kupalira chimanga', '2025-01-29', 'Ndinatumiza ndalama zopalilira kukasungu '),
(9, 39900.00, 'income', 'Airtel money', '2025-02-01', 'Ndinalandira ku ka business komwe ndimapanga');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`clothing_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`timetable_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clothing`
--
ALTER TABLE `clothing`
  MODIFY `clothing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `timetables` (`timetable_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
