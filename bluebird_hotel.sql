-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 10:18 AM
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
-- Database: `bluebird_hotel`
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
(64, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-01 03:33:34'),
(65, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-01 04:12:12'),
(66, 2, 'Profile Updated', 'Updated profile information', NULL, NULL, '2025-12-01 04:12:33'),
(67, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-01 04:27:23'),
(68, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-03 06:40:43'),
(69, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-03 06:48:23'),
(70, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-03 07:08:14'),
(71, 1, 'Room Added', 'Added new room: 7 (Single)', NULL, 'room', '2025-12-03 07:08:45'),
(72, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-03 07:08:53'),
(73, 15, 'Room Booked', 'Member booked Room 7', NULL, NULL, '2025-12-03 07:09:30'),
(74, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-03 07:10:12'),
(75, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-03 07:15:22'),
(76, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-03 07:23:53'),
(77, 1, 'Payment Recorded', 'Recorded payment for booking #9, amount ₱100', 9, 'booking', '2025-12-03 07:24:24'),
(78, 1, 'Payment Recorded', 'Recorded payment for booking #8, amount ₱1200', 8, 'booking', '2025-12-03 07:24:45'),
(79, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-03 07:38:30'),
(80, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-03 07:41:38'),
(81, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-03 07:41:54'),
(82, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-04 04:22:43'),
(83, 1, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Unavailable)', 1, 'room', '2025-12-04 04:36:37'),
(84, 1, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Unavailable)', 1, 'room', '2025-12-04 04:37:24'),
(85, 1, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Under Maintenance)', 1, 'room', '2025-12-04 04:41:16'),
(86, 1, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Available)', 1, 'room', '2025-12-04 04:41:42'),
(87, 1, 'Room Updated', 'Updated room: 1 (Type: Single, Status: Under Maintenance)', 1, 'room', '2025-12-04 04:42:02'),
(88, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-04 04:45:13'),
(89, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-04 04:45:51'),
(90, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-04 22:34:03'),
(91, 2, 'Room Added', 'Added new room: 9 (Single)', NULL, 'room', '2025-12-04 22:34:28'),
(92, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-04 22:35:17'),
(93, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-05 02:32:51'),
(94, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 02:43:22'),
(95, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 02:45:47'),
(96, 1, 'Profile Updated', 'Updated profile information', NULL, NULL, '2025-12-05 02:56:09'),
(97, 1, 'Profile Updated', 'Updated profile information', NULL, NULL, '2025-12-05 02:56:19'),
(98, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 03:03:42'),
(99, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 03:04:12'),
(100, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 03:09:41'),
(101, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 03:09:57'),
(102, 1, 'Room Added', 'Added new room: 3 (Single)', NULL, 'room', '2025-12-05 03:12:46'),
(103, 15, 'Room Booked', 'Member booked Room 3 (Booking #11)', NULL, NULL, '2025-12-05 03:22:48'),
(104, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-05 03:23:50'),
(105, 1, 'Booking Status Updated', 'Updated booking #11 status to Confirmed', 11, 'booking', '2025-12-05 03:25:17'),
(106, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-05 03:25:32'),
(107, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-05 03:25:50'),
(108, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-05 03:27:46'),
(109, 1, 'Room Added', 'Added new room: 10 (Single)', NULL, 'room', '2025-12-05 03:33:26'),
(110, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-05 03:33:58'),
(111, 26, 'Room Booked', 'Member booked Room 10 (Booking #12)', NULL, NULL, '2025-12-05 03:34:41'),
(112, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-05 03:39:33'),
(113, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-05 03:40:02'),
(114, 1, 'Room Booked', 'Booked Room 1', NULL, NULL, '2025-12-05 03:40:12'),
(115, 1, 'Booking Status Updated', 'Updated booking #13 status to Confirmed', 13, 'booking', '2025-12-05 03:41:00'),
(116, 1, 'Payment Recorded', 'Recorded payment for booking #13, amount ₱4000', 13, 'booking', '2025-12-05 03:42:59'),
(117, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-05 03:49:44'),
(118, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-05 04:10:32'),
(119, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 18:21:59'),
(120, 2, 'Room Updated', 'Updated room: 9', 9, 'room', '2025-12-06 18:22:42'),
(121, 2, 'Room Updated', 'Updated room: 9', 9, 'room', '2025-12-06 18:22:54'),
(122, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 18:24:11'),
(123, 15, 'Room Booked', 'Member booked Room 9 (Booking #14)', NULL, NULL, '2025-12-06 18:24:50'),
(124, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 18:26:19'),
(125, 2, 'Booking Status Updated', 'Updated booking #5 status to Confirmed', 5, 'booking', '2025-12-06 18:28:58'),
(126, 2, 'Booking Status Updated', 'Updated booking #5 status to Occupied', 5, 'booking', '2025-12-06 18:29:04'),
(127, 2, 'Payment Recorded', 'Recorded payment for booking #5, amount ₱1000', 5, 'booking', '2025-12-06 18:29:40'),
(128, 2, 'Booking Status Updated', 'Updated booking #10 status to Confirmed', 10, 'booking', '2025-12-06 18:29:50'),
(129, 2, 'Booking Status Updated', 'Updated booking #10 status to Occupied', 10, 'booking', '2025-12-06 18:29:52'),
(130, 2, 'Payment Recorded', 'Recorded payment for booking #10, amount ₱2000', 10, 'booking', '2025-12-06 18:29:59'),
(131, 2, 'Booking Status Updated', 'Updated booking #14 status to Confirmed', 14, 'booking', '2025-12-06 18:32:12'),
(132, 2, 'Booking Status Updated', 'Updated booking #12 status to Occupied', 12, 'booking', '2025-12-06 18:32:20'),
(133, 2, 'Booking Status Updated', 'Updated booking #12 status to Completed', 12, 'booking', '2025-12-06 18:32:32'),
(134, 2, 'Payment Recorded', 'Recorded payment for booking #12, amount ₱14000', 12, 'booking', '2025-12-06 18:32:40'),
(135, 2, 'Booking Status Updated', 'Updated booking #10 status to Completed', 10, 'booking', '2025-12-06 18:33:04'),
(136, 2, 'Payment Recorded', 'Recorded payment for booking #10, amount ₱2000', 10, 'booking', '2025-12-06 18:33:08'),
(137, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 18:33:48'),
(138, 15, 'Room Booked', 'Member booked Room 9 (Booking #15)', NULL, NULL, '2025-12-06 18:34:20'),
(139, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 19:21:18'),
(140, 2, 'Room Added', 'Added new room: 11 (Single)', NULL, 'room', '2025-12-06 19:21:50'),
(141, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 19:22:21'),
(142, 15, 'Room Booked', 'Member booked Room 11 (Booking #17)', NULL, NULL, '2025-12-06 19:23:00'),
(143, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 19:26:28'),
(144, 2, 'Room Added', 'Added new room: 12 (Single)', NULL, 'room', '2025-12-06 19:27:09'),
(145, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 19:29:57'),
(146, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 19:35:09'),
(147, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 19:35:16'),
(148, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 19:40:53'),
(149, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 19:41:08'),
(150, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 19:41:27'),
(151, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 19:41:35'),
(152, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 19:53:53'),
(153, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:01:15'),
(154, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:03:57'),
(155, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:04:04'),
(156, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:04:27'),
(157, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:05:29'),
(158, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:06:56'),
(159, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:30:02'),
(160, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:30:07'),
(161, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:30:11'),
(162, 15, 'Room Booked', 'Member booked Room 12 (Booking #18)', NULL, NULL, '2025-12-06 20:30:38'),
(163, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:33:44'),
(164, 2, 'Room Added', 'Added new room: 13 (Single)', NULL, 'room', '2025-12-06 20:34:18'),
(165, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:34:24'),
(166, 15, 'Room Booked', 'Member booked Room 13 (Booking #19)', NULL, NULL, '2025-12-06 20:34:55'),
(167, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:38:47'),
(168, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:39:13'),
(169, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:39:19'),
(170, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:39:30'),
(171, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:40:15'),
(172, 2, 'Room Added', 'Added new room: 14 (Single)', NULL, 'room', '2025-12-06 20:40:39'),
(173, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:40:55'),
(174, 15, 'Room Booked', 'Member booked Room 14 (Booking #20)', NULL, NULL, '2025-12-06 20:41:26'),
(175, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:42:43'),
(176, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:42:53'),
(177, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:43:02'),
(178, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:43:07'),
(179, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:43:15'),
(180, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:43:26'),
(181, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:43:42'),
(182, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:43:48'),
(183, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:43:57'),
(184, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:44:04'),
(185, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:44:11'),
(186, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:44:19'),
(187, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:44:27'),
(188, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:44:37'),
(189, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:44:44'),
(190, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:44:57'),
(191, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:45:05'),
(192, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:45:33'),
(193, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:45:48'),
(194, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:46:35'),
(195, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:47:56'),
(196, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:47:57'),
(197, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:51:25'),
(198, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:51:42'),
(199, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:52:27'),
(200, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:52:54'),
(201, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:53:06'),
(202, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 20:53:15'),
(203, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 20:53:36'),
(204, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 21:01:11'),
(205, 2, 'Logout', 'User logged out', NULL, NULL, '2025-12-06 21:01:27'),
(206, 2, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-06 21:02:07'),
(207, 2, 'Room Updated', 'Updated room: 2', 2, 'room', '2025-12-06 21:17:54'),
(208, 2, 'Room Updated', 'Updated room: 4', 4, 'room', '2025-12-06 21:18:07'),
(209, 2, 'Room Updated', 'Updated room: 5', 6, 'room', '2025-12-06 21:18:27'),
(210, 2, 'Room Updated', 'Updated room: 6', 7, 'room', '2025-12-06 21:18:39'),
(211, 2, 'Room Updated', 'Updated room: 7', 8, 'room', '2025-12-06 21:18:55'),
(212, 2, 'Room Updated', 'Updated room: 9', 9, 'room', '2025-12-06 21:19:08'),
(213, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-08 01:43:08'),
(214, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-08 01:44:43'),
(215, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-08 01:44:51'),
(216, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-08 01:44:58'),
(217, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-08 01:45:36'),
(218, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-08 01:46:27'),
(219, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-08 01:59:18'),
(220, 1, 'Booking Status Updated', 'Updated booking #13 status to Cancelled', 13, 'booking', '2025-12-08 02:05:47'),
(221, 1, 'Booking Status Updated', 'Updated booking #13 status to Cancelled', 13, 'booking', '2025-12-08 02:06:10'),
(222, 1, 'Booking Status Updated', 'Updated booking #5 status to Completed', 5, 'booking', '2025-12-08 02:06:30'),
(223, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-08 02:10:27'),
(224, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-08 02:10:39'),
(225, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-08 02:10:44'),
(226, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 03:40:57'),
(227, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 03:40:58'),
(228, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-09 03:41:06'),
(229, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 04:13:08'),
(230, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-09 04:13:13'),
(231, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 04:35:14'),
(232, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-09 04:35:26'),
(233, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 04:36:22'),
(234, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-09 04:36:39'),
(235, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 04:52:33'),
(236, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-09 04:52:57'),
(237, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 04:55:09'),
(238, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-09 06:25:27'),
(239, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-09 06:25:34'),
(240, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-10 03:54:23'),
(241, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-10 03:59:07'),
(242, 26, 'Room Booked', 'Member booked Room 1 (Booking #22)', NULL, NULL, '2025-12-10 04:03:46'),
(243, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-10 04:14:54'),
(244, 1, 'Payment Recorded', 'Recorded payment for booking #22, amount ₱4000', 22, 'booking', '2025-12-10 04:15:31'),
(245, 1, 'Booking Status Updated', 'Updated booking #21 status to Confirmed', 21, 'booking', '2025-12-10 04:15:51'),
(246, 1, 'Payment Recorded', 'Recorded payment for booking #21, amount ₱3000', 21, 'booking', '2025-12-10 04:15:57'),
(247, 1, 'Payment Recorded', 'Recorded payment for booking #20, amount ₱2000', 20, 'booking', '2025-12-10 04:16:11'),
(248, 1, 'Payment Recorded', 'Recorded payment for booking #19, amount ₱2000', 19, 'booking', '2025-12-10 04:16:35'),
(249, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-10 04:22:43'),
(250, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-10 04:53:45'),
(251, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-11 03:28:44'),
(252, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-11 03:29:22'),
(253, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-11 03:46:19'),
(254, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-11 03:46:25'),
(255, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-11 04:11:37'),
(256, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-11 04:20:36'),
(257, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-12 22:19:13'),
(258, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-13 16:08:19'),
(259, 1, 'Room Updated', 'Updated room: 2', 2, 'room', '2025-12-13 16:13:45'),
(260, 1, 'Room Updated', 'Updated room: 1', 1, 'room', '2025-12-13 16:14:02'),
(261, 1, 'Room Updated', 'Updated room: 3', 10, 'room', '2025-12-13 16:14:14'),
(262, 1, 'Room Updated', 'Updated room: 9', 9, 'room', '2025-12-13 16:14:28'),
(263, 1, 'Room Updated', 'Updated room: 4', 4, 'room', '2025-12-13 16:14:50'),
(264, 1, 'Room Updated', 'Updated room: 5', 6, 'room', '2025-12-13 16:15:02'),
(265, 1, 'Room Updated', 'Updated room: 6', 7, 'room', '2025-12-13 16:15:16'),
(266, 1, 'Room Updated', 'Updated room: 2', 2, 'room', '2025-12-13 16:15:29'),
(267, 1, 'Room Updated', 'Updated room: 7', 8, 'room', '2025-12-13 16:15:43'),
(268, 1, 'Room Updated', 'Updated room: 8', 14, 'room', '2025-12-13 16:16:02'),
(269, 1, 'Room Updated', 'Updated room: 10', 11, 'room', '2025-12-13 16:16:23'),
(270, 1, 'Room Updated', 'Updated room: 11', 12, 'room', '2025-12-13 16:16:44'),
(271, 1, 'Room Updated', 'Updated room: 12', 13, 'room', '2025-12-13 16:17:05'),
(272, 1, 'Room Updated', 'Updated room: 13', 15, 'room', '2025-12-13 16:17:23'),
(273, 1, 'Room Updated', 'Updated room: 14', 16, 'room', '2025-12-13 16:17:37'),
(274, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-13 16:23:28'),
(275, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-13 16:28:51'),
(276, 1, 'Room Added', 'Added new room: 15 (Luxury)', NULL, 'room', '2025-12-13 16:30:34'),
(277, 1, 'Room Added', 'Added new room: 16 (Luxury)', NULL, 'room', '2025-12-13 16:30:58'),
(278, 1, 'Booking Status Updated', 'Updated booking #18 status to Confirmed', 18, 'booking', '2025-12-13 17:00:30'),
(279, 1, 'Booking Status Updated', 'Updated booking #13 status to Cancelled', 13, 'booking', '2025-12-13 17:04:01'),
(280, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-13 17:33:05'),
(281, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-13 17:35:00'),
(282, 1, 'Booking Status Updated', 'Updated booking #23 status to Confirmed', 23, 'booking', '2025-12-13 17:41:14'),
(283, 1, 'Payment Recorded', 'Recorded payment for booking #23, amount ₱2500', 23, 'booking', '2025-12-13 17:41:23'),
(284, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-13 18:05:21'),
(285, 26, 'Checkout', 'Processed checkout via Cash. Paid: 0', 22, 'booking', '2025-12-14 01:13:29'),
(286, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-14 01:14:44'),
(287, 1, 'Payment Recorded', 'Recorded payment for booking #22, amount ₱4000', 22, 'booking', '2025-12-14 01:15:59'),
(288, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-14 01:19:43'),
(289, 15, 'Checkout', 'Processed checkout via Cash. Paid: 2000', 15, 'booking', '2025-12-14 01:20:36'),
(290, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-14 01:20:50'),
(291, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-14 01:23:32'),
(292, 26, 'Room Booked', 'Member booked Room 15 (Booking #24)', NULL, NULL, '2025-12-14 01:36:46'),
(293, 26, 'Checkout', 'Processed checkout via Cash. Paid: 4500', 24, 'booking', '2025-12-14 01:53:22'),
(294, 15, 'Room Booked', 'Member booked Room 15 (Booking #25)', NULL, NULL, '2025-12-14 02:04:18'),
(295, 15, 'Room Booked', 'Member booked Room 16 (Booking #26)', NULL, NULL, '2025-12-14 02:05:00'),
(296, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-14 02:07:55'),
(297, 15, 'Checkout', 'Processed checkout via Cash. Paid: 2000', 17, 'booking', '2025-12-14 16:51:55'),
(298, 15, 'Checkout', 'Processed checkout via Cash. Paid: 4500', 25, 'booking', '2025-12-14 16:52:11'),
(299, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-14 16:52:34'),
(300, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-14 16:53:41'),
(301, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-14 17:20:00'),
(302, 1, 'Customer Deleted', 'Deleted customer: Harry Potter', 30, 'customer', '2025-12-14 17:20:35'),
(303, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-14 17:21:01'),
(304, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-14 17:21:59'),
(305, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-14 17:22:08'),
(306, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-17 03:58:13'),
(307, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-17 04:03:32'),
(308, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-17 04:13:51'),
(309, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-17 04:21:51'),
(310, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-17 04:23:58'),
(311, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-17 04:24:02'),
(312, 1, 'Login', 'User logged in successfully', NULL, NULL, '2025-12-18 07:40:57'),
(313, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-18 07:41:08'),
(314, 1, 'Login', 'Admin logged in successfully', NULL, NULL, '2025-12-18 08:04:33'),
(315, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-18 08:04:41'),
(316, 15, 'Checkout', 'Processed checkout via Cash. Paid: 4500', 26, 'booking', '2025-12-18 08:10:31'),
(317, 1, 'Login', 'Admin logged in successfully', NULL, NULL, '2025-12-18 08:10:56'),
(318, 1, 'Logout', 'User logged out', NULL, NULL, '2025-12-18 08:11:16'),
(319, 1, 'Login', 'Admin logged in successfully', NULL, NULL, '2025-12-19 06:34:03');

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
(1, 'uploads/1764932179_6932ba5366c91.png', 'admin69@gmail.com', '$2y$10$x5vnMR/MwVIwdhHLU0dACe5/5symnRPwKh1omImBb.XC5Wo.3hYGq', 'Cejay Lelis', 'Admin'),
(2, 'uploads/1764591153_692d86310785b.jpg', 'admin@admin.com', '$2y$10$hLO7hZnIj1fEe8dIFgjGWehbZfB9e5fG1N2z0qrLMi2rdEQXjsh/.', 'John Doe', 'Assistant admin');

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
(5, 16, 2, '2025-11-30', '2025-12-01', 1000.00, 'Completed', '2025-11-29 16:18:39', '2025-12-08 02:06:30'),
(8, 19, 1, '2025-11-30', '2025-12-01', 1200.00, 'Confirmed', '2025-11-29 17:24:10', '2025-12-03 07:24:45'),
(9, 15, 8, '2025-12-03', '2025-12-04', 100.00, 'Confirmed', '2025-12-03 07:09:30', '2025-12-03 07:24:24'),
(11, 15, 10, '2025-12-14', '2025-12-15', 2000.00, 'Confirmed', '2025-12-05 03:22:48', '2025-12-05 03:25:17'),
(12, 26, 11, '2025-12-15', '2025-12-22', 14000.00, 'Completed', '2025-12-05 03:34:41', '2025-12-06 18:32:40'),
(13, 28, 1, '2025-12-05', '2025-12-07', 4000.00, 'Cancelled', '2025-12-05 03:40:12', '2025-12-13 17:04:01'),
(14, 15, 9, '2025-12-08', '2025-12-09', 2000.00, 'Confirmed', '2025-12-06 18:24:50', '2025-12-06 18:32:12'),
(15, 15, 9, '2025-12-14', '2025-12-15', 2000.00, 'Completed', '2025-12-06 18:34:20', '2025-12-14 01:20:36'),
(16, 15, 11, '2025-12-21', '2025-12-22', 2000.00, 'Pending', '2025-12-06 18:39:44', NULL),
(17, 15, 12, '2025-12-23', '2025-12-24', 2000.00, 'Completed', '2025-12-06 19:23:00', '2025-12-14 16:51:55'),
(18, 15, 13, '2025-12-31', '2026-01-01', 2000.00, 'Confirmed', '2025-12-06 20:30:38', '2025-12-13 17:00:30'),
(19, 15, 15, '2026-01-02', '2026-01-03', 2000.00, 'Confirmed', '2025-12-06 20:34:55', '2025-12-10 04:16:35'),
(20, 15, 16, '2025-12-23', '2025-12-24', 2000.00, 'Confirmed', '2025-12-06 20:41:26', '2025-12-10 04:16:11'),
(21, 29, 14, '2025-12-31', '2026-01-01', 3000.00, 'Confirmed', '2025-12-06 20:56:58', '2025-12-10 04:15:57'),
(22, 26, 1, '2025-12-11', '2025-12-13', 4000.00, 'Completed', '2025-12-10 04:03:46', '2025-12-14 01:15:59'),
(23, 31, 2, '2025-12-15', '2025-12-16', 2500.00, 'Confirmed', '2025-12-13 17:34:03', '2025-12-13 17:41:23'),
(24, 26, 17, '2025-12-17', '2025-12-18', 4500.00, 'Completed', '2025-12-14 01:36:46', '2025-12-14 01:53:22'),
(25, 15, 17, '2025-12-23', '2025-12-24', 4500.00, 'Completed', '2025-12-14 02:04:18', '2025-12-14 16:52:11'),
(26, 15, 18, '2025-12-23', '2025-12-24', 4500.00, 'Completed', '2025-12-14 02:05:00', '2025-12-18 08:10:31');

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
  `dob` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `profile`, `Fname`, `Lname`, `email`, `customer_type`, `password`, `contact`, `dob`, `created_at`) VALUES
(13, 'uploads/1763786504_69213f082cad8.jpg', 'Prince Zachary', 'Ducog', 'zakaree@gmail.com', 'Member', '$2y$12$RM6UUydC3fXvdOhkCIr0duaCdVIv6401C1MniaqpPitMPg45IhUc.', '09392321414', '2025-11-22', '2025-11-30 00:17:21'),
(14, 'uploads/1764343649_6929bf618efb3.jpg', 'John Rick', 'Nosenas', 'rick@gmail.com', 'Member', '$2y$12$ESDN3j0GoEwwptGw2O0bkezDBdzhO37F7Vw/FbMTWC6oldWCezd9O', '21212121212', '2025-11-29', '2025-11-30 00:17:38'),
(15, 'uploads/1764343781_6929bfe57c2b2.jpg', 'Evander Harold', 'Amorcillo', 'vander@gmail.com', 'Member', '$2y$12$hjmz3eMqW6WR0JY5Cn06qOa5Pp8I7nT3vjA8ffpuVkt5l5DmMohvO', '09999999', '2025-11-28', '2025-11-30 00:17:58'),
(16, 'images/default_profile.png', 'John', 'Does', 'email@example.com', 'Guest', '$2y$12$gEgfeyw9a3NPU.OJjN7MKOdhgVWwiYknG4m2ESXokqtar09cBCnB2', '02020202020', '2025-11-30', '2025-12-14 01:30:50'),
(19, 'images/default_profile.png', 'Charles', 'Xavier', 'charles@gmail.com', 'Guest', '$2y$12$GGcmflhnCMl/FcukVa5Jbu8pNTW3aJj5lvaFfOnjZaLL8VVj5dapi', '0707070707', '2025-11-30', '2025-12-14 01:31:03'),
(20, 'uploads/1764466343_692b9ea77d4fb.jpg', 'Cejay', 'Lelis', 'lelis@gmail.com', 'Guest', '$2y$12$k08ZyS6EUPs91E276hcXKuXO.na0kmaAaPfHd5GTpsME83LPaQ7oW', '09293135155', '2004-12-29', '2025-12-14 01:31:16'),
(21, 'uploads/1764475327_692bc1bf68aa3.png', 'Harry', 'Potter', 'potter@gmail.com', 'Guest', '$2y$12$76R2olfnuDR2Ie135fgSiONMb4M7AZKCFdZ4/cGOrxJfB4AYxcCsi', '0606060660', '2025-11-30', '2025-12-14 01:31:58'),
(22, 'uploads/1764475753_692bc36914a74.png', 'Hayato', 'Suzuki', 'suzuki@gmail.com', 'Guest', '$2y$12$OenBCWYjWcGXwrDSqdnIee2vwk2c8Zej3J7oTL7Aphzs9hLO9yD6W', '0505050505', '2025-11-30', '2025-12-14 01:31:44'),
(23, 'uploads/1764475935_692bc41fb56c1.png', 'John', 'Wick', 'wick@gmail.com', 'Guest', '$2y$12$pm7cjCEx1IVdepkPlS8c8eF4Ou3sLV4PwSvemd66fcmwsZ2zOzTKW', '04040404', '2025-11-30', '2025-12-14 01:32:10'),
(24, 'uploads/1764476218_692bc53a4894e.png', 'Vhan', 'Manales', 'vhan@gmail.com', 'Guest', '$2y$12$vLdy6rvgJSTShrxPZAMKOe3cODBM0Y/6rHxJfDMwIuRtvRhekh.WW', '0929999900', '2025-11-30', '2025-12-14 01:32:26'),
(25, 'uploads/1764477214_692bc91ecc93d.png', 'Rick', 'Grimes', 'grimes@gmail.com', 'Member', '$2y$12$8qfVfVDb4Xz6bV00QMLouOyGb2eFVWln63oVksWHQItX3uhgffp1q', '1234567891', '2025-11-30', '2025-11-29 20:33:35'),
(26, 'images/default_profile.png', 'Kian Mcbyrne', 'Ymbol', 'kiantot@gmail.com', 'Member', '$2y$12$L7b3YmwLV31UlXwAp1Vjc.uNfG6ajdvC6hcoQBIZ.VjZPwlofb25y', '0303303030', '2025-12-03', '2025-12-03 07:21:17'),
(28, 'images/default_profile.png', 'Albert', 'Melendres', 'albert@gmail.com', 'Guest', '', '45454545', NULL, '2025-12-05 03:40:12'),
(29, 'images/default_profile.png', 'Rick', 'Xavier', 'loo@gmail.com', 'Guest', '', '848484884', NULL, '2025-12-06 20:56:58'),
(31, 'images/default_profile.png', 'Peter', 'Parker', 'parker@gmail.com', 'Guest', '', '5454545454', NULL, '2025-12-13 17:34:03');

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
(6, NULL, 13, 'Cash', 1000.00, '2025-11-22 04:44:55'),
(7, 9, 15, 'Cash', 100.00, '2025-12-03 07:24:24'),
(8, 8, 19, 'Card', 1200.00, '2025-12-03 07:24:45'),
(9, 13, 28, 'Card', 4000.00, '2025-12-05 03:42:59'),
(10, 5, 16, 'Cash', 1000.00, '2025-12-06 18:29:40'),
(12, 12, 26, 'Card', 14000.00, '2025-12-06 18:32:40'),
(13, 22, 26, 'Card', 4000.00, '2025-12-14 01:15:59'),
(14, 21, 29, 'Cash', 3000.00, '2025-12-10 04:15:57'),
(15, 20, 15, 'Cash', 2000.00, '2025-12-10 04:16:11'),
(16, 19, 15, 'Cash', 2000.00, '2025-12-10 04:16:35'),
(17, 23, 31, 'Cash', 2500.00, '2025-12-13 17:41:23'),
(18, 15, 15, 'Cash', 2000.00, '2025-12-14 01:20:36'),
(19, 24, 26, 'Cash', 4500.00, '2025-12-14 01:53:22'),
(20, 17, 15, 'Cash', 2000.00, '2025-12-14 16:51:55'),
(21, 25, 15, 'Cash', 4500.00, '2025-12-14 16:52:11'),
(22, 26, 15, 'Cash', 4500.00, '2025-12-18 08:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `room_number` int(3) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `room_type` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_number`, `picture`, `room_type`, `status`) VALUES
(1, 1, 'uploads/rooms/1764932997_6932bd85e71ce.jpg', 'Standard', 'Available'),
(2, 2, 'uploads/rooms/1765084674_69350e02a1244.jpg', 'Luxury', 'Occupied'),
(4, 4, 'uploads/rooms/1765084687_69350e0f23492.jpg', 'Deluxe', 'Occupied'),
(6, 5, 'uploads/rooms/1765084707_69350e2302a5c.jpg', 'Deluxe', 'Occupied'),
(7, 6, 'uploads/rooms/1765084719_69350e2f87350.jpg', 'Deluxe', 'Occupied'),
(8, 7, 'uploads/rooms/1765084735_69350e3f0c5e2.jpg', 'Standard', 'Occupied'),
(9, 9, 'uploads/rooms/1765084748_69350e4c88c73.jpg', 'Standard', 'Available'),
(10, 3, 'uploads/rooms/1764933166_6932be2e64929.png', 'Standard', 'Occupied'),
(11, 10, 'uploads/rooms/1764934406_6932c306954a5.png', 'Standard', 'Occupied'),
(12, 11, 'uploads/rooms/1765077710_6934f2ce37e1f.png', 'Standard', 'Available'),
(13, 12, 'uploads/rooms/1765078029_6934f40dafd89.png', 'Standard', 'Occupied'),
(14, 8, 'uploads/rooms/1765079602_6934fa32dcb56.png', 'Deluxe', 'Occupied'),
(15, 13, 'uploads/rooms/1765082058_693503cab6aa3.png', 'Standard', 'Occupied'),
(16, 14, 'uploads/rooms/1765082439_693505479e5aa.png', 'Standard', 'Occupied'),
(17, 15, 'uploads/rooms/1765672234_693e052ad9e70.jpg', 'Luxury', 'Available'),
(18, 16, 'uploads/rooms/1765672258_693e05424d655.jpg', 'Luxury', 'Available');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
