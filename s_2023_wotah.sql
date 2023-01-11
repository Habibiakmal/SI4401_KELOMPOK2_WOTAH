-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 11, 2023 at 02:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s_2023_wotah`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `usage` float DEFAULT NULL,
  `amount_per_usage` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `maintenance_price` int(11) DEFAULT NULL,
  `ppn_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `transaction_id`, `month`, `year`, `usage`, `amount_per_usage`, `total_amount`, `created_at`, `maintenance_price`, `ppn_price`) VALUES
(1, 1, 1, 2023, 10, 2500, 25000, '2023-01-11 04:08:00', NULL, NULL),
(2, 4, 2, 2023, 10, 30000, 349250, '2023-01-11 00:49:08', 17500, 31750);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) DEFAULT NULL,
  `service_description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_name`, `service_description`, `created_at`, `updated_at`) VALUES
(1, 'Perbaikan Pipa', NULL, '2023-01-01 11:03:20', NULL),
(2, 'Saluran Pipa Tersumbat', NULL, '2023-01-01 11:03:20', NULL),
(3, 'Pemasangan Pipa Baru', NULL, '2023-01-01 11:03:20', NULL),
(4, 'Pemasangan Jet Pump', NULL, '2023-01-01 11:03:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_code` varchar(100) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `payment_proof_at` datetime DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `status` enum('pending','waiting_payment','verify','completed','denied') DEFAULT NULL,
  `type` enum('bill','service') DEFAULT NULL,
  `payment_proof` varchar(100) DEFAULT NULL,
  `service_used_by_user` varchar(200) DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `technition_note` text DEFAULT NULL,
  `submit_service_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `transaction_code`, `amount`, `created_at`, `payment_proof_at`, `verified_at`, `status`, `type`, `payment_proof`, `service_used_by_user`, `issue_description`, `technition_note`, `submit_service_at`) VALUES
(1, 1, '3DFXS124', 75000, '2023-01-11 04:06:00', '2023-01-10 23:22:02', '2023-01-11 01:48:10', 'completed', 'bill', '1-202301102322.png', NULL, NULL, NULL, NULL),
(2, 1, 'XHOPMAMYGZ', 250000, '2023-01-10 22:26:15', '2023-01-11 01:46:33', '2023-01-11 01:48:01', 'completed', 'service', '2-202301110146.webp', 'Pemasangan Jet Pump', 'Lorem\r\nIpsum\r\nSip\r\nDolor\r\nAmet', 'Ada kerusakan parah\r\npipa pecah', '2023-01-11 01:43:31'),
(4, 1, 'UTN28SRH93', 349250, '2023-01-11 00:49:08', '2023-01-11 01:15:57', '2023-01-11 01:24:44', 'completed', 'bill', '4-202301110115.webp', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `full_address` varchar(200) DEFAULT NULL,
  `user_photo` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `password`, `full_address`, `user_photo`, `created_at`, `updated_at`, `role`, `phone`) VALUES
(1, 'Wader Jhonson', 'jhonsonwader@gmail.com', '123456789', 'Jl. Taman Rawa Pening V, Jakarta', NULL, '2023-01-10 09:08:32', '2023-01-10 20:39:18', 'user', '085315922225'),
(2, 'Bellatrix Lestrange', 'bella@gmail.com', '123456789', 'Jl. Kebun Raya Bogor', NULL, '2023-01-10 09:30:30', '2023-01-10 09:30:30', 'admin', '083181826488'),
(4, 'Jane Doe', 'jane_doe@gmail.com', '123456789', NULL, NULL, '2023-01-11 00:02:13', NULL, 'user', '08318182648881');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_FK` (`transaction_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_FK` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_FK` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_FK` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
