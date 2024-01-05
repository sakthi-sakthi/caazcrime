-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2024 at 05:27 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caaz`
--

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `severity` varchar(30) NOT NULL,
  `notes` varchar(200) NOT NULL,
  `case_num` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `dateofbirth` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `place` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `father` varchar(255) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `joined` varchar(30) NOT NULL,
  `tmp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `name`, `dateofbirth`, `phone`, `email`, `place`, `address`, `gender`, `father`, `mother`, `description`, `joined`, `tmp`) VALUES
(24, '5583990', 'Sakthi Ganapathi S', '2002-05-15', '8870656056', 'sakthiganapathi@dbcyelagiri.edu.in', 'kandhikuppam', 'Yelagiri', 'male', 'Srinivasan S.K', 'Lakshmi S', 'He is the Main Criminal for this Crime', ' 23 Dec 2023 ', '6639'),
(26, '5704936', 'Thirumalai Vasan S', '2023-11-28', '9874562130', 'admin@gmail.com', 'Tiruchy', 'Yelagiri', 'male', 'Srinivasan S.K', 'Lakshmi S', 'welcome to chennai', ' 23 Dec 2023 ', '2474'),
(27, '6367954', 'Nelson', '2003-03-10', '6381445213', 'nelson@gmail.com', 'RAIPUR', 'Yelagiri', 'male', 'test user', 'test users', 'Welcome to Chennai', ' 08 Jan 2024 ', '1474'),
(28, '5203435', 'Kanish', '2021-10-10', '1234567890', 'kanish@gmail.com', 'Kolatti', 'Kolatti,Hosur', 'male', 'Raja', 'Kala', 'Welcome to Hosur,Kollati', ' 08 Jan 2020 ', '3475'),
(29, '6539458', 'Raghul', '2023-12-15', '9874566123', 'raghul@gmail.com', 'Tiruchy', 'Yelagiri', 'male', 'Suresh', 'Eshwari', 'welcome to mallapadi', ' 03 Jan 2022 ', '7452');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `tmp` varchar(90) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `tmp`, `name`) VALUES
(2, '1301', 'user1301.jpg'),
(3, '5267', 'user5267.jpg'),
(4, '6954', 'user6954.jpg'),
(5, '7731', 'user7731.jpg'),
(6, '2255', 'user2255.jpg'),
(7, '4757', 'user4757.jpg'),
(8, '6878', 'user6878.jpg'),
(9, '2620', 'user2620.jpg'),
(10, '1709', 'user1709.png'),
(11, '974', 'user974.jpg'),
(12, '6444', 'user6444.jpg'),
(13, '2399', 'user2399.jpg'),
(14, '6658', 'user6658.jpg'),
(15, '5504', 'user5504.jpg'),
(16, '7222', 'user7222.jpg'),
(17, '3298', 'user3298.jpg'),
(18, '5621', 'user5621.jpg'),
(19, '3555', 'user3555.jpg'),
(20, '6639', 'user6639.png'),
(21, '3217', 'user3217.jpg'),
(22, '2474', 'user2474.jpg'),
(23, '1474', 'user1474.jpg'),
(24, '3475', 'user3475.jpg'),
(25, '7452', 'user7452.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `joined` varchar(30) NOT NULL,
  `type` varchar(10) NOT NULL,
  `permission` varchar(10) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `otp` int(255) NOT NULL,
  `incorrect_attempts` int(11) DEFAULT 0,
  `otp_attempts` int(11) DEFAULT 0,
  `otp_expire_time` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expire` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `username`, `password`, `joined`, `type`, `permission`, `gender`, `phone`, `otp`, `incorrect_attempts`, `otp_attempts`, `otp_expire_time`, `reset_token`, `reset_token_expire`) VALUES
(13, 'sakthi', 'ganapathi', 'sakthiganapathi@dbcyelagiri.edu.in', 'sakthi', '123456', ' 05 Jan 2024 ', 'user', '1', 'M', '2638870656056', 630651, 0, 0, NULL, '0fd0db31b645347d65d5087c494e75e7487019006c43e43371aab25c203a7107', '2024-01-05 14:35:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
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
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
