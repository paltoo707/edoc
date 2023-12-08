-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2023 at 05:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_acknowledge`
--

CREATE TABLE `tb_acknowledge` (
  `ack_id` int NOT NULL,
  `ack_status` varchar(20) COLLATE utf8mb4_persian_ci NOT NULL,
  `ack_user_approve` int NOT NULL,
  `ack_app_id` int NOT NULL,
  `ack_book_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_approve`
--

CREATE TABLE `tb_approve` (
  `app_id` int NOT NULL,
  `app_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `app_use_paper` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `app_comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `app_user_approve` int NOT NULL,
  `app_book_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_book`
--

CREATE TABLE `tb_book` (
  `book_id` int NOT NULL,
  `book_receive_no` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `book_sent_no` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `book_from` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `book_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `book_receive_date` date NOT NULL,
  `book_sent_date` date NOT NULL,
  `book_files` text COLLATE utf8mb4_general_ci NOT NULL,
  `book_comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `book_user_update` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int NOT NULL,
  `user_fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_fname`, `user_lname`, `user_type`, `user_image`, `user_status`, `username`, `password`, `created_at`, `updated_at`) VALUES
(11, 'อานนท์', 'แสนใจเป็ง', 'Admin', 'img-169778918394.jpg', 'Active', 'nonx', '$2y$10$JzM4cOE20jaVj7Y9f5gX0em9AjhjnFM3DVTB8JCqY7TN8L1JtNv/O', '2023-10-20 15:06:23', '2023-11-21 13:35:54'),
(13, 'วัชณี', 'สุวรรณชมภู', 'User', '', 'Active', 'Watchanee.s', '$2y$10$lRu8YRePwwTOfOrVs8wT4.uTakyTz95IsKTyHuVtS3JqphunV0TLO', '2023-10-30 09:05:09', '2023-12-01 09:58:51'),
(14, 'ศรีสุชา', 'เชาว์พร้อม', 'Boss', '', 'Active', 'Srisucha.c', '$2y$10$Nh8.T6yGSEUEddnAGVrQheg8eIaWBDHezbHYwdXeHf8UUkMgIgFDq', '2023-11-03 09:37:57', '2023-12-01 09:57:47'),
(15, 'นายมานะ', 'สุภาพ', 'Administrative', '', 'Active', 'Mana.s', '$2y$10$/F5heTuM/Rc4Fs9HsFah.uQPaB3gEiW99nLJmOsZA/vJvE1zX.4uK', '2023-11-03 09:38:23', '2023-12-01 09:56:52'),
(28, 'กรรณิการ์', 'เจริญไทย', 'User', '', 'Active', 'Kannikar.j', '$2y$10$S2MYI3swcZfgxC3Ql0SY1u1BPKE0qzD4gbqoildGZwogBIusMHVau', '2023-12-01 10:00:03', '0000-00-00 00:00:00'),
(29, 'ศรีทรงชัย', 'รัตนเจียมรังษี', 'User', '', 'Active', 'Srisongchai.r', '$2y$10$Fqo0MYisGBQ9p3ABeR6l.OqMic/BuZFdz9tFxbNXn0ojMrsCBOfaC', '2023-12-01 10:02:27', '0000-00-00 00:00:00'),
(30, 'ฐิติวรกาญจน์', 'วงศ์โยธา', 'User', '', 'Active', 'Thitiworakan.w', '$2y$10$RAJZdgMZqCoODEe6XcBNbepZtWernzr2fIBcrBue4r4WwgLY.09D6', '2023-12-01 10:03:22', '0000-00-00 00:00:00'),
(31, 'นรินทร์', 'สุทธศรี', 'Admin', '', 'Active', 'Narin.s', '$2y$10$2a2fLh5SFn1sHj2AQOWibulF5yOaJWeSDRJKINoAGFQ9fWl7V.p.O', '2023-12-01 10:04:05', '0000-00-00 00:00:00'),
(32, 'กรนิภา', 'เธียรธนาวร', 'Admin', '', 'Active', 'Kornipa.t', '$2y$10$TbUxY5B1mW.7Bpxl7AvmU.FhN2AOH4.VrtRA5MIjxNX4H6TflBT9u', '2023-12-01 10:05:54', '0000-00-00 00:00:00'),
(33, 'วณิชธารณ์', 'ยมวนา', 'Admin', '', 'Active', 'wanichatarn.y', '$2y$10$cRpXhc5zBc1AR1aHIQauyeTeQ5pV02Lak4ynvczkkBWByVGnxSNHe', '2023-12-01 10:12:52', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_acknowledge`
--
ALTER TABLE `tb_acknowledge`
  ADD PRIMARY KEY (`ack_id`);

--
-- Indexes for table `tb_approve`
--
ALTER TABLE `tb_approve`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `tb_book`
--
ALTER TABLE `tb_book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_acknowledge`
--
ALTER TABLE `tb_acknowledge`
  MODIFY `ack_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `tb_approve`
--
ALTER TABLE `tb_approve`
  MODIFY `app_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `tb_book`
--
ALTER TABLE `tb_book`
  MODIFY `book_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
