-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2022 at 04:42 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soits_db`
--
CREATE DATABASE IF NOT EXISTS `soits_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `soits_db`;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `contact`) VALUES
(1, 'Company 1', 'Company 1', '+18456-5455-55'),
(2, 'Company 2', 'Company 1', '+18456-5455-55'),
(3, 'Company 3', 'Company 3', '8747808787');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `description`) VALUES
(1, 'Course 1', 'Course 1'),
(2, 'Course 2', 'Course 2'),
(3, 'Course 3', 'Course 3');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `course_id` int(30) NOT NULL,
  `company_id` int(30) NOT NULL,
  `id_no` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `required_duration` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `address`, `contact`, `course_id`, `company_id`, `id_no`, `password`, `status`, `required_duration`) VALUES
(1, 'Hà Huy Sơn', 'vinh', '0388580624', 1, 1, '123456', '1254737c076cf867dc53d60a0364f38e', 0, '600'),
(2, 'kiên', 'Hà Tĩnh', '123456789', 2, 2, '20140623', '4744ddea876b11dcb1d169fadf494418', 0, '600');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time_start` time NOT NULL DEFAULT current_timestamp(),
  `time_end` time NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= Unverified, 1=Verified',
  `timer_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=timer started, 0 = timer ends'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `student_id`, `date`, `time_start`, `time_end`, `remarks`, `status`, `timer_status`) VALUES
(1, 1, '2020-11-05', '10:00:00', '15:29:00', 'sample', 0, 0),
(3, 1, '2020-11-05', '15:37:50', '15:37:00', 'sample \r\nsample', 0, 0),
(4, 1, '2020-11-05', '15:48:35', '16:50:00', 'test 101', 0, 0),
(5, 2, '2020-11-05', '08:05:00', '16:49:00', 'Sample Task', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1),
(2, 'Hà Huy Sơn', 'son', '498d3c6bfa033f6dc1be4fcc3c370aa7', 2),
(3, 'Sơn Huy', 'kientrung', '5d2297b2f56654636090aaad75d0578f', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
