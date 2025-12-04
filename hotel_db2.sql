-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Generation Time: Dec 03, 2025 at 03:35 PM
=======
-- Generation Time: Dec 01, 2025 at 01:10 PM
>>>>>>> ef540fc6984869b42fdf2f38087d77b6bd22ee73
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
-- Database: `hotel_db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `related_type` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `action`, `description`, `related_id`, `related_type`, `created_at`) VALUES
(1, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-22 18:03:10'),
(2, 1, 'Profile Updated', 'Updated profile information', NULL, NULL, '2025-11-22 18:03:45'),
(3, 1, 'Logout', 'User logged out', NULL, NULL, '2025-11-22 18:04:07'),
(4, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-22 18:04:24'),
(5, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-22 18:04:39'),
(6, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-22 18:04:45'),
(7, 1, 'Staff Updated', 'Updated staff: Evander Harold Amorcillo', 5, 'staff', '2025-11-22 18:07:38'),
(8, 1, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Available)', 1, 'room', '2025-11-22 18:27:33'),
(9, 1, 'Room Updated', 'Updated room: 4 (Type: Double, Status: Available)', 4, 'room', '2025-11-22 18:29:07'),
(10, 1, 'Room Updated', 'Updated room: 2 (Type: Single, Status: Available)', 2, 'room', '2025-11-22 18:29:25'),
(11, 1, 'Room Updated', 'Updated room: 4 (Type: Double, Status: Unavailable)', 4, 'room', '2025-11-22 18:35:49'),
(12, 1, 'Room Added', 'Added new room: 6 (Double)', NULL, 'room', '2025-11-22 18:36:44'),
(13, 1, 'Room Updated', 'Updated room: 4 (Type: Double, Status: Available)', 4, 'room', '2025-11-22 18:37:20'),
(14, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-24 01:32:19'),
(15, 2, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Occupied)', 1, 'room', '2025-11-24 01:38:20'),
(16, 2, 'Room Updated', 'Updated room: 4 (Type: Double, Status: Occupied)', 4, 'room', '2025-11-24 01:38:45'),
(17, 2, 'Room Updated', 'Updated room: 5 (Type: Double, Status: Unavailable)', 6, 'room', '2025-11-24 01:41:19'),
(18, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-24 01:45:32'),
(19, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-24 01:52:28'),
(20, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-24 01:53:02'),
(21, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-24 02:19:33'),
(22, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-24 02:19:47'),
(23, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-24 02:22:50'),
(24, 1, 'Logout', 'User logged out', NULL, NULL, '2025-11-24 02:26:53'),
(25, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-24 02:34:22'),
(26, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-24 02:45:18'),
(27, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-24 15:19:36'),
(28, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-25 03:37:56'),
(29, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-26 22:20:26'),
(30, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-27 03:55:17'),
(31, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-27 03:57:52'),
(32, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-27 04:28:01'),
(33, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-28 07:14:48'),
(34, 1, 'Logout', 'User logged out', NULL, NULL, '2025-11-28 07:26:11'),
(35, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-28 07:27:57'),
(36, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-28 07:27:57'),
(37, 1, 'Customer Added', 'Added new customer: Evander Harold Amorcillo', NULL, 'customer', '2025-11-28 07:29:41'),
(38, 1, 'Logout', 'User logged out', NULL, NULL, '2025-11-28 07:29:47'),
(39, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-28 20:25:15'),
(40, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 16:18:04'),
(41, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 16:18:45'),
(42, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 16:24:19'),
(43, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 16:50:47'),
(44, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 16:52:30'),
(45, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 16:54:35'),
(46, 2, 'Room Updated', 'Updated room: 5 (Type: Double, Status: Available)', 6, 'room', '2025-11-29 16:54:54'),
(47, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 16:55:01'),
(48, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 16:56:01'),
(49, 2, 'Customer Deleted', 'Deleted customer:  Guest', 18, 'customer', '2025-11-29 17:20:59'),
(50, 2, 'Customer Deleted', 'Deleted customer:  Guest', 17, 'customer', '2025-11-29 17:21:07'),
(51, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 17:21:11'),
(52, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 17:22:54'),
(53, 2, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Available)', 1, 'room', '2025-11-29 17:23:16'),
(54, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 17:23:22'),
(55, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 17:24:16'),
(56, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 17:26:02'),
(57, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 17:46:59'),
(58, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 20:17:04'),
(59, 2, 'Logout', 'User logged out', NULL, NULL, '2025-11-29 20:32:12'),
(60, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-11-29 20:38:54'),
(61, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-01 03:30:07'),
(62, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-01 03:31:06'),
(63, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-01 03:32:20'),
<<<<<<< HEAD
(64, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-01 03:33:34'),
(65, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-01 04:12:12'),
(66, 2, 'Profile Updated', 'Updated profile information', NULL, NULL, '2025-12-01 04:12:33'),
(67, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-01 04:27:23');
=======
(64, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-01 03:33:34');
>>>>>>> ef540fc6984869b42fdf2f38087d77b6bd22ee73

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `profile`, `email`, `password`, `name`, `role`) VALUES
(1, 'uploads/1763863425_69226b8195b17.jpg', 'admin69@gmail.com', '$2y$10$x5vnMR/MwVIwdhHLU0dACe5/5symnRPwKh1omImBb.XC5Wo.3hYGq', 'Cejay Lelis', 'admin'),
<<<<<<< HEAD
(2, 'uploads/1764591153_692d86310785b.jpg', 'admin@admin.com', '$2y$10$hLO7hZnIj1fEe8dIFgjGWehbZfB9e5fG1N2z0qrLMi2rdEQXjsh/.', 'Cejay Lelis', 'admin');
=======
(2, 'uploads/1763784126_692135be1c604.jpg', 'admin@admin.com', '$2y$10$hLO7hZnIj1fEe8dIFgjGWehbZfB9e5fG1N2z0qrLMi2rdEQXjsh/.', 'Cejay Lelis', 'admin');
>>>>>>> ef540fc6984869b42fdf2f38087d77b6bd22ee73

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `customer_id`, `room_id`, `check_in_date`, `check_out_date`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(5, 16, 2, '2025-11-30', '2025-12-01', 0.00, 'Pending', '2025-11-29 16:18:39', NULL),
(8, 19, 1, '2025-11-30', '2025-12-01', 0.00, 'Pending', '2025-11-29 17:24:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `Lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `customer_type` varchar(20) NOT NULL DEFAULT 'guest',
  `password` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `profile`, `Fname`, `Lname`, `email`, `customer_type`, `password`, `contact`, `dob`, `created_at`) VALUES
(13, 'uploads/1763786504_69213f082cad8.jpg', 'Prince Zachary', 'Ducog', 'zakaree@gmail.com', 'Member', '$2y$12$RM6UUydC3fXvdOhkCIr0duaCdVIv6401C1MniaqpPitMPg45IhUc.', '09392321414', '2025-11-22', '2025-11-30 00:17:21'),
(14, 'uploads/1764343649_6929bf618efb3.jpg', 'John Rick', 'Nosenas', 'rick@gmail.com', 'Member', '$2y$12$ESDN3j0GoEwwptGw2O0bkezDBdzhO37F7Vw/FbMTWC6oldWCezd9O', '21212121212', '2025-11-29', '2025-11-30 00:17:38'),
(15, 'uploads/1764343781_6929bfe57c2b2.jpg', 'Evander Harold', 'Amorcillo', 'vander@gmail.com', 'Member', '$2y$12$hjmz3eMqW6WR0JY5Cn06qOa5Pp8I7nT3vjA8ffpuVkt5l5DmMohvO', '09999999', '2025-11-28', '2025-11-30 00:17:58'),
(16, 'images/default_profile.png', 'John', 'Does', 'email@example.com', 'guest', '$2y$12$gEgfeyw9a3NPU.OJjN7MKOdhgVWwiYknG4m2ESXokqtar09cBCnB2', '02020202020', '2025-11-30', '2025-11-29 16:18:39'),
(19, 'images/default_profile.png', 'Charles', 'Xavier', 'charles@gmail.com', 'guest', '$2y$12$GGcmflhnCMl/FcukVa5Jbu8pNTW3aJj5lvaFfOnjZaLL8VVj5dapi', '0707070707', '2025-11-30', '2025-11-29 17:21:49'),
(20, 'uploads/1764466343_692b9ea77d4fb.jpg', 'Cejay', 'Lelis', 'lelis@gmail.com', 'guest', '$2y$12$k08ZyS6EUPs91E276hcXKuXO.na0kmaAaPfHd5GTpsME83LPaQ7oW', '09293135155', '2004-12-29', '2025-11-30 01:32:23'),
(21, 'uploads/1764475327_692bc1bf68aa3.png', 'Harry', 'Potter', 'potter@gmail.com', 'guest', '$2y$12$76R2olfnuDR2Ie135fgSiONMb4M7AZKCFdZ4/cGOrxJfB4AYxcCsi', '0606060660', '2025-11-30', '2025-11-29 20:02:07'),
(22, 'uploads/1764475753_692bc36914a74.png', 'Hayato', 'Suzuki', 'suzuki@gmail.com', 'guest', '$2y$12$OenBCWYjWcGXwrDSqdnIee2vwk2c8Zej3J7oTL7Aphzs9hLO9yD6W', '0505050505', '2025-11-30', '2025-11-29 20:09:13'),
(23, 'uploads/1764475935_692bc41fb56c1.png', 'John', 'Wick', 'wick@gmail.com', 'guest', '$2y$12$pm7cjCEx1IVdepkPlS8c8eF4Ou3sLV4PwSvemd66fcmwsZ2zOzTKW', '04040404', '2025-11-30', '2025-11-29 20:12:16'),
(24, 'uploads/1764476218_692bc53a4894e.png', 'Vhan', 'Manales', 'vhan@gmail.com', 'guest', '$2y$12$vLdy6rvgJSTShrxPZAMKOe3cODBM0Y/6rHxJfDMwIuRtvRhekh.WW', '0929999900', '2025-11-30', '2025-11-29 20:16:58'),
(25, 'uploads/1764477214_692bc91ecc93d.png', 'Rick', 'Grimes', 'grimes@gmail.com', 'Member', '$2y$12$8qfVfVDb4Xz6bV00QMLouOyGb2eFVWln63oVksWHQItX3uhgffp1q', '1234567891', '2025-11-30', '2025-11-29 20:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_option` varchar(100) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `booking_id`, `customer_id`, `payment_option`, `amount`, `paid_at`) VALUES
(6, NULL, 13, 'Cash', 1000.00, '2025-11-22 04:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `room_number` int(3) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_number`, `room_type`, `status`) VALUES
(1, 1, 'Single', 'Occupied'),
(2, 2, 'Single', 'Occupied'),
(4, 4, 'Double', 'Occupied'),
(6, 5, 'Double', 'Occupied'),
(7, 6, 'Double', 'Occupied');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `Fname` varchar(100) NOT NULL,
  `Lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `Fname`, `Lname`, `email`, `contact`, `role`) VALUES
(5, 'Evander Harold', 'Amorcillo', 'vander@gmail.com', '09888888', 'Chef'),
(6, 'John Rick', 'Nosenas', 'rick@gmail.com', '095959595', 'Cleaner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_customer` (`customer_id`),
  ADD KEY `fk_payment_booking` (`booking_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
>>>>>>> ef540fc6984869b42fdf2f38087d77b6bd22ee73

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_payment_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
