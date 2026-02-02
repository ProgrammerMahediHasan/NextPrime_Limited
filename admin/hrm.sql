-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2026 at 04:13 PM
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
-- Database: `hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `rt_attendance_logs`
--

CREATE TABLE `rt_attendance_logs` (
  `source` enum('Biometric','Manual','Web') DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `status` enum('Working-Day','Weekend','Holiday') DEFAULT NULL,
  `grace_time` time DEFAULT NULL,
  `late_time` time DEFAULT NULL,
  `total_work_minutes` int(11) DEFAULT 0,
  `remarks` varchar(255) DEFAULT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_attendance_logs`
--

INSERT INTO `rt_attendance_logs` (`source`, `in_time`, `out_time`, `status`, `grace_time`, `late_time`, `total_work_minutes`, `remarks`, `id`) VALUES
('Manual', '09:00:00', '17:00:00', 'Working-Day', '09:10:00', '09:11:00', 480, 'Attendance', 5);

-- --------------------------------------------------------

--
-- Table structure for table `rt_cache`
--

CREATE TABLE `rt_cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_cache_locks`
--

CREATE TABLE `rt_cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_categories`
--

CREATE TABLE `rt_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_customers`
--

CREATE TABLE `rt_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_daily_attendance`
--

CREATE TABLE `rt_daily_attendance` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `att_date` date NOT NULL,
  `day_type` enum('Working','Weekend','Holiday') NOT NULL DEFAULT 'Working',
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `total_work_minutes` int(11) DEFAULT 0,
  `status` enum('Present','Absent','Day Off') DEFAULT 'Present',
  `late_minutes` int(11) DEFAULT 0,
  `overtime_minutes` int(11) DEFAULT 0,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_daily_attendance`
--

INSERT INTO `rt_daily_attendance` (`id`, `emp_id`, `att_date`, `day_type`, `in_time`, `out_time`, `total_work_minutes`, `status`, `late_minutes`, `overtime_minutes`, `remarks`) VALUES
(368, 1, '2025-11-01', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, ''),
(369, 2, '2025-11-01', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(370, 3, '2025-11-01', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, ''),
(371, 4, '2025-11-01', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(373, 19, '2025-11-01', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(374, 1, '2025-11-02', 'Working', '09:05:00', '17:30:00', 505, 'Present', 5, 0, NULL),
(375, 2, '2025-11-02', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(376, 3, '2025-11-02', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(377, 4, '2025-11-02', 'Working', '08:57:00', '17:25:00', 508, 'Present', 0, 0, NULL),
(379, 19, '2025-11-02', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(380, 1, '2025-11-03', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(381, 2, '2025-11-03', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(382, 3, '2025-11-03', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(383, 4, '2025-11-03', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(385, 19, '2025-11-03', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(386, 1, '2025-11-04', 'Working', '09:04:00', '17:30:00', 506, 'Present', 4, 0, NULL),
(387, 2, '2025-11-04', 'Working', '09:13:00', '17:30:00', 497, 'Present', 13, 0, NULL),
(388, 3, '2025-11-04', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(389, 4, '2025-11-04', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(391, 19, '2025-11-04', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(392, 1, '2025-11-05', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(393, 2, '2025-11-05', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(394, 3, '2025-11-05', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(395, 4, '2025-11-05', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(397, 19, '2025-11-05', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(398, 1, '2025-11-06', 'Working', '10:01:00', '17:30:00', 449, 'Absent', 0, 0, NULL),
(399, 2, '2025-11-06', 'Working', '09:05:00', '17:30:00', 505, 'Present', 5, 0, NULL),
(400, 3, '2025-11-06', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(401, 4, '2025-11-06', 'Working', '09:00:00', '16:30:00', 450, 'Present', 0, 0, NULL),
(403, 19, '2025-11-06', 'Working', '09:00:00', '17:45:00', 525, 'Present', 0, 15, NULL),
(404, 1, '2025-11-07', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(405, 2, '2025-11-07', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(406, 3, '2025-11-07', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(407, 4, '2025-11-07', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(408, 5, '2025-11-07', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(409, 19, '2025-11-07', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(410, 1, '2025-11-08', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(411, 2, '2025-11-08', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(412, 3, '2025-11-08', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(413, 4, '2025-11-08', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(415, 19, '2025-11-08', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(416, 1, '2025-11-09', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(417, 2, '2025-11-09', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(418, 3, '2025-11-09', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(419, 4, '2025-11-09', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(421, 19, '2025-11-09', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(422, 1, '2025-11-10', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(423, 2, '2025-11-10', 'Working', '10:05:00', '17:30:00', 445, 'Absent', 0, 0, NULL),
(424, 3, '2025-11-10', 'Working', '09:00:00', '17:35:00', 515, 'Present', 0, 5, NULL),
(425, 4, '2025-11-10', 'Working', '08:45:00', '17:30:00', 525, 'Present', 0, 0, NULL),
(426, 5, '2025-11-10', 'Working', '09:05:00', '17:30:00', 505, 'Present', 5, 0, NULL),
(427, 19, '2025-11-10', 'Working', '09:20:00', '17:52:00', 512, 'Present', 20, 22, NULL),
(428, 1, '2025-11-11', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(429, 2, '2025-11-11', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(430, 3, '2025-11-11', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(431, 4, '2025-11-11', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(432, 5, '2025-11-11', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(433, 19, '2025-11-11', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(434, 1, '2025-11-12', 'Working', '09:00:00', '17:50:00', 530, 'Present', 0, 20, NULL),
(435, 2, '2025-11-12', 'Working', '09:00:00', '16:58:00', 478, 'Present', 0, 0, NULL),
(436, 3, '2025-11-12', 'Working', '09:15:00', '17:30:00', 495, 'Present', 15, 0, NULL),
(437, 4, '2025-11-12', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(438, 5, '2025-11-12', 'Working', '09:30:00', '17:30:00', 480, 'Present', 30, 0, NULL),
(439, 19, '2025-11-12', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(440, 1, '2025-11-13', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(441, 2, '2025-11-13', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(442, 3, '2025-11-13', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(443, 4, '2025-11-13', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(444, 5, '2025-11-13', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(445, 19, '2025-11-13', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(446, 1, '2025-11-14', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(447, 2, '2025-11-14', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(448, 3, '2025-11-14', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(449, 4, '2025-11-14', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(450, 5, '2025-11-14', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(451, 19, '2025-11-14', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(452, 1, '2025-11-15', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(453, 2, '2025-11-15', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(454, 3, '2025-11-15', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(455, 4, '2025-11-15', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(456, 5, '2025-11-15', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(457, 19, '2025-11-15', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(458, 1, '2025-11-16', 'Working', '09:10:00', '17:35:00', 505, 'Present', 10, 5, NULL),
(459, 2, '2025-11-16', 'Working', '08:00:00', '17:30:00', 570, 'Present', 0, 0, NULL),
(460, 3, '2025-11-16', 'Working', '09:30:00', '17:30:00', 480, 'Present', 30, 0, NULL),
(461, 4, '2025-11-16', 'Working', '10:00:00', '17:30:00', 450, 'Present', 60, 0, NULL),
(462, 5, '2025-11-16', 'Working', '09:02:00', '17:30:00', 508, 'Present', 2, 0, NULL),
(463, 19, '2025-11-16', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(464, 1, '2025-11-17', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(465, 2, '2025-11-17', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(466, 3, '2025-11-17', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(467, 4, '2025-11-17', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(468, 5, '2025-11-17', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(469, 19, '2025-11-17', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(470, 1, '2025-11-18', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(471, 2, '2025-11-18', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(472, 3, '2025-11-18', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(473, 4, '2025-11-18', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(474, 5, '2025-11-18', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(475, 19, '2025-11-18', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(476, 1, '2025-11-19', 'Working', '09:01:00', '17:30:00', 509, 'Present', 1, 0, NULL),
(477, 2, '2025-11-19', 'Working', '09:30:00', '17:30:00', 480, 'Present', 30, 0, NULL),
(478, 3, '2025-11-19', 'Working', '09:05:00', '17:30:00', 505, 'Present', 5, 0, NULL),
(479, 4, '2025-11-19', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(480, 5, '2025-11-19', 'Working', '08:00:00', '17:30:00', 570, 'Present', 0, 0, NULL),
(481, 19, '2025-11-19', 'Working', '11:20:00', '17:30:00', 370, 'Absent', 0, 0, NULL),
(482, 1, '2025-11-20', 'Working', '09:00:00', '17:31:00', 511, 'Present', 0, 1, NULL),
(483, 2, '2025-11-20', 'Working', '09:00:00', '16:46:00', 466, 'Present', 0, 0, NULL),
(484, 3, '2025-11-20', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(485, 4, '2025-11-20', 'Working', '09:05:00', '17:30:00', 505, 'Present', 5, 0, NULL),
(486, 5, '2025-11-20', 'Working', '08:55:00', '17:30:00', 515, 'Present', 0, 0, NULL),
(487, 19, '2025-11-20', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(488, 1, '2025-11-21', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(489, 2, '2025-11-21', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(490, 3, '2025-11-21', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(491, 4, '2025-11-21', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(492, 5, '2025-11-21', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(493, 19, '2025-11-21', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(494, 1, '2025-11-22', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(495, 2, '2025-11-22', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(496, 3, '2025-11-22', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(497, 4, '2025-11-22', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(498, 5, '2025-11-22', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(499, 19, '2025-11-22', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(500, 1, '2025-11-23', 'Working', '09:15:00', '17:30:00', 495, 'Present', 15, 0, NULL),
(501, 2, '2025-11-23', 'Working', '09:05:00', '17:30:00', 505, 'Present', 5, 0, NULL),
(502, 3, '2025-11-23', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(503, 4, '2025-11-23', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(504, 5, '2025-11-23', 'Working', '09:00:00', '17:45:00', 525, 'Present', 0, 15, NULL),
(505, 19, '2025-11-23', 'Working', '09:00:00', '18:30:00', 570, 'Present', 0, 60, NULL),
(506, 1, '2025-11-24', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(507, 2, '2025-11-24', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(508, 3, '2025-11-24', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(509, 4, '2025-11-24', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(510, 5, '2025-11-24', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(511, 19, '2025-11-24', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(512, 1, '2025-11-25', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(513, 2, '2025-11-25', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(514, 3, '2025-11-25', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(515, 4, '2025-11-25', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(517, 19, '2025-11-25', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(518, 1, '2025-11-26', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(519, 2, '2025-11-26', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(520, 3, '2025-11-26', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(521, 4, '2025-11-26', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(522, 19, '2025-11-26', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(523, 1, '2025-11-27', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(524, 2, '2025-11-27', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(525, 3, '2025-11-27', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(526, 4, '2025-11-27', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(527, 19, '2025-11-27', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(528, 1, '2025-11-28', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(529, 2, '2025-11-28', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(530, 3, '2025-11-28', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(531, 4, '2025-11-28', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(532, 5, '2025-11-28', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(533, 19, '2025-11-28', 'Weekend', NULL, NULL, 0, 'Day Off', 0, 0, NULL),
(534, 1, '2025-11-29', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(535, 2, '2025-11-29', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(536, 3, '2025-11-29', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(537, 4, '2025-11-29', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(538, 19, '2025-11-29', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(539, 1, '2025-11-30', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(540, 2, '2025-11-30', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(541, 3, '2025-11-30', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(542, 4, '2025-11-30', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(544, 19, '2025-11-30', 'Working', '09:00:00', '17:30:00', 510, 'Present', 0, 0, NULL),
(552, 5, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, ''),
(553, 1, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, ''),
(554, 2, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, ''),
(555, 3, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, ''),
(556, 4, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, ''),
(563, 2, '2026-01-29', 'Working', '09:00:00', '17:35:00', 515, 'Present', 0, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rt_department`
--

CREATE TABLE `rt_department` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_department`
--

INSERT INTO `rt_department` (`id`, `name`, `description`, `status`) VALUES
(1, 'Human Resources (HR)', 'Handles employee recruitment, onboarding, training, and welfare. Manages payroll, attendance, and organizational policies', 'Active'),
(2, 'Finance Officer', 'Maintains company accounts, prepares financial statements, and monitors budget usage. Handles billing and auditing tasks.', 'Active'),
(3, 'Information Technology (IT)', 'Responsible for maintaining computer systems, software development, network security, and technical support.', 'Active'),
(4, 'Sales & Marketing', 'Focuses on promoting company products or services, managing sales targets, market research, and advertising strategies.', 'Active'),
(5, 'Operations & Administration', 'Oversees day-to-day business activities, ensures workflow efficiency, and supports all other departments with logistics and planning.', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rt_designations`
--

CREATE TABLE `rt_designations` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_designations`
--

INSERT INTO `rt_designations` (`id`, `dept_id`, `name`, `description`) VALUES
(1, 1, 'HR Manager', 'Oversees recruitment, employee relations, and company policies. Ensures compliance with labor laws and manages HR staff.'),
(2, 2, 'Accountant', 'Manages company finances, prepares financial statements, and ensures accurate record-keeping and reporting.'),
(3, 3, 'Software Engineer', 'Develops, tests, and maintains software applications and provides technical solutions to business needs.'),
(4, 4, 'Sales Executive', 'Identifies business opportunities, manages client relationships, and works to achieve company sales targets.'),
(5, 5, 'Operations Officer', 'Coordinates daily business operations, monitors workflow, and ensures smooth departmental collaboration.'),
(28, 1, 'HR Manager GM', 'Handles employee recruitment, on boarding, training, and welfare. Manages payroll, attendance, and organizational policies'),
(29, 1, 'HRM', 'Managing Director'),
(32, 33, 't2222222222222222', 'fgfhj'),
(33, 34, 'MAHEDI HASAN ABIR22222', 'tttttttttt');

-- --------------------------------------------------------

--
-- Table structure for table `rt_employees`
--

CREATE TABLE `rt_employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `desig_id` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `basic_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `joining_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_employees`
--

INSERT INTO `rt_employees` (`id`, `name`, `dept_id`, `desig_id`, `gender`, `photo`, `email`, `phone`, `basic_salary`, `status`, `joining_date`) VALUES
(1, 'Mahedi Hasan Abir', 3, 3, 'Male', 'emp_697f7918c594a.png', 'mahedihasanabir8@gmail.com', '01732074663', 50000.00, 'Active', '2025-09-30'),
(2, 'Tanvir Jubayer', 33, 32, 'Male', 'emp_697f79cf47e40.png', 'tanvir@gmail.com', '01732074663', 30000.00, 'Active', '2025-09-30'),
(3, 'Pollob Ahmed Sagor', 2, 2, 'Male', NULL, 'pollobsagor@gmail.com', '01575550883', 35000.00, 'Active', '2025-09-30'),
(4, 'Rashed Khan', 5, 5, 'Male', NULL, 'rashed@gmail.com', '01983581152', 42000.00, 'Active', '2025-09-30'),
(5, 'Abdullah Bin Hanif', 1, 1, 'Male', NULL, 'hanif@gmail.com', '01983581152', 55000.00, 'Active', '2025-09-30'),
(19, 'Tithi Akter', 1, 1, 'Female', NULL, 'tithi@gmail.com', '01575550844', 0.00, 'Active', '1997-02-01'),
(20, 'Maherima Islam', 5, 5, 'Female', NULL, 'maherimaislam@gmail.com', '01575550883', 0.00, 'Active', '2025-12-01'),
(25, 'MAHEDI HASAN', 1, 29, 'Male', NULL, 'afranabir03@gmail.com', '01632606827', 0.00, 'Active', '2026-01-27'),
(27, 'Harun Or Rasid', 2, 2, 'Male', NULL, 'afranabir03@gmail.com', '01632606827', 0.00, 'Active', '2026-01-29'),
(30, 'Anamul Haque', 3, 3, 'Male', 'emp_697f829b9807b.jpg', 'anamul@gamil.com', '01983581152', 0.00, 'Active', '2026-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `rt_employee_salary`
--

CREATE TABLE `rt_employee_salary` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `hra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `medical_allowance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_deduction` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pf_deduction` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_salary` decimal(10,2) DEFAULT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_employee_salary`
--

INSERT INTO `rt_employee_salary` (`id`, `emp_id`, `basic_salary`, `hra`, `medical_allowance`, `tax_deduction`, `pf_deduction`, `gross_salary`, `net_salary`) VALUES
(5, 2, 40000.00, 5000.00, 4000.00, 2000.00, 2000.00, 49000.00, 45000.00),
(7, 5, 70000.00, 5000.00, 5000.00, 3000.00, 3000.00, 80000.00, 74000.00),
(8, 1, 40000.00, 5000.00, 5000.00, 2500.00, 2500.00, 50000.00, 45000.00),
(11, 4, 40000.00, 5000.00, 3498.00, 2000.00, 1500.00, 63500.00, 57000.00);

-- --------------------------------------------------------

--
-- Table structure for table `rt_failed_jobs`
--

CREATE TABLE `rt_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_invoices`
--

CREATE TABLE `rt_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_jobs`
--

CREATE TABLE `rt_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_job_batches`
--

CREATE TABLE `rt_job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_leave_assign`
--

CREATE TABLE `rt_leave_assign` (
  `id` int(11) NOT NULL COMMENT 'প্রতিটি রেকর্ডের ইউনিক ID',
  `emp_id` int(11) NOT NULL COMMENT 'যে এমপ্লয়ারের জন্য ছুটি নির্ধারণ করা হয়েছে তার ID',
  `leave_type_id` int(11) NOT NULL COMMENT 'ছুটির ধরন ID (Casual, Sick, Annual ইত্যাদি)',
  `allow_days` int(11) NOT NULL COMMENT 'মোট অনুমোদিত ছুটির দিন সংখ্যা',
  `used_days` int(11) DEFAULT 0 COMMENT 'এখন পর্যন্ত ব্যবহৃত ছুটির দিন সংখ্যা',
  `year` year(4) NOT NULL COMMENT 'কোন বছরের জন্য ছুটি নির্ধারণ করা হয়েছে',
  `created_at` datetime DEFAULT current_timestamp() COMMENT 'রেকর্ড তৈরির সময়',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'রেকর্ড আপডেটের সময়'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='প্রতিটি এমপ্লয়ারের ছুটির বরাদ্দ সংরক্ষণের টেবিল';

--
-- Dumping data for table `rt_leave_assign`
--

INSERT INTO `rt_leave_assign` (`id`, `emp_id`, `leave_type_id`, `allow_days`, `used_days`, `year`, `created_at`, `updated_at`) VALUES
(16, 2, 17, 10, 0, '2025', '2025-12-09 20:50:49', '2026-01-30 16:19:32'),
(21, 5, 20, 12, 12, '2025', '2025-12-11 21:44:33', '2026-02-01 23:35:14'),
(26, 27, 19, 10, 5, '2026', '2026-01-30 16:51:02', '2026-01-30 16:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `rt_leave_request`
--

CREATE TABLE `rt_leave_request` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `leave_id` int(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` int(11) DEFAULT 0,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `approver_id` int(11) DEFAULT NULL,
  `applied_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_leave_request`
--

INSERT INTO `rt_leave_request` (`id`, `emp_id`, `leave_id`, `start_date`, `end_date`, `total_days`, `reason`, `status`, `approver_id`, `applied_on`) VALUES
(72, 5, 20, '2025-11-04', '2025-11-06', 3, 'Personal', 'Approved', 0, '1970-01-01 00:00:00'),
(73, 5, 20, '2025-11-08', '2025-11-09', 2, 'Personal', 'Approved', 0, '1970-01-01 00:00:00'),
(74, 5, 20, '2025-11-25', '2025-11-27', 3, 'Wedding', 'Approved', 0, '1970-01-01 00:00:00'),
(75, 5, 20, '2025-11-29', '2025-11-30', 2, 'personal', 'Approved', 0, '1970-01-01 00:00:00'),
(76, 5, 20, '2025-11-01', '2025-11-02', 2, 'Casual', 'Approved', 0, '1970-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rt_leave_types`
--

CREATE TABLE `rt_leave_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `leave_code` varchar(20) DEFAULT NULL,
  `total_days` int(11) NOT NULL DEFAULT 0,
  `deduct_apply` tinyint(5) DEFAULT 0,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_leave_types`
--

INSERT INTO `rt_leave_types` (`id`, `name`, `leave_code`, `total_days`, `deduct_apply`, `description`, `status`) VALUES
(17, 'Casual Leave', 'CL', 10, 0, 'Personal or urgent work leave', 'Active'),
(18, 'Sick Leave', 'SL', 8, 0, 'Leave due to illness', 'Active'),
(19, 'Earned Leave', 'EL', 10, 0, 'Leave earned based on work performance', 'Active'),
(20, 'Leave Without Pay', 'LWP', 12, 1, 'Employee is allowed to take leave without pay. No salary will be paid for the days taken under this leave.', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `rt_menus`
--

CREATE TABLE `rt_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_migrations`
--

CREATE TABLE `rt_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rt_migrations`
--

INSERT INTO `rt_migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_03_165547_create_categories_table', 1),
(5, '2026_01_04_055650_create_menus_table', 1),
(6, '2026_01_04_121119_create_customers_table', 1),
(7, '2026_01_04_152533_create_restaurants_table', 1),
(8, '2026_01_11_040306_create_personal_access_tokens_table', 1),
(9, '2026_01_12_033634_create_orders_table', 1),
(10, '2026_01_12_033653_create_orders_items_table', 1),
(11, '2026_01_17_061458_create_payment_methods_table', 1),
(12, '2026_01_17_061529_create_payments_table', 1),
(13, '2026_01_17_061634_create_invoices_table', 1),
(14, '2026_01_18_054917_create_suppliers_table', 1),
(15, '2026_01_18_055118_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rt_orders`
--

CREATE TABLE `rt_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `restaurant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_type` enum('dine_in','takeaway','delivery') NOT NULL DEFAULT 'dine_in',
  `status` enum('pending','confirmed','preparing','ready','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_order_items`
--

CREATE TABLE `rt_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(8,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `special_request` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_password_reset_tokens`
--

CREATE TABLE `rt_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_payments`
--

CREATE TABLE `rt_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `service_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_payment_methods`
--

CREATE TABLE `rt_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `config` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_personal_access_tokens`
--

CREATE TABLE `rt_personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_products`
--

CREATE TABLE `rt_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'piece',
  `current_stock` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reorder_level` decimal(10,2) NOT NULL DEFAULT 10.00,
  `last_purchase_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_purchase_orders`
--

CREATE TABLE `rt_purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `status` enum('draft','pending','approved','received','cancelled') NOT NULL DEFAULT 'draft',
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_restaurants`
--

CREATE TABLE `rt_restaurants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_roles`
--

CREATE TABLE `rt_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_roles`
--

INSERT INTO `rt_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(39, 'Admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'HR Manager', '2025-12-12 04:21:37', '2026-01-22 12:05:46'),
(42, 'Accounts Manager', '2025-12-12 04:21:50', '2025-12-12 04:21:50'),
(43, 'Department Manager', '2025-12-12 04:22:01', '2026-01-23 05:11:49'),
(57, 'Employees', '2026-01-27 07:58:15', '2026-01-27 07:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `rt_sessions`
--

CREATE TABLE `rt_sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rt_sessions`
--

INSERT INTO `rt_sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1akri3iUiKyrjQeJiKJmUoXUa7gUe8cu2VS2X7wd', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidERjTXh6OGhWakxkeWdiemhRQkc1U0VZdXFBNnBRNFpsbm9FZjBuVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3QvQWJpcnNfRm9vZENvdXJ0XzAvcHVibGljIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769687072),
('3xuwT3GkRNslH5aAoEknoq1z6HNfYmlIeqdkThAe', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidGRNZ0FrYVBBbEszUGowTTNpUVdBQmhjdWxWSmR3bksxRVBjZmd6NSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3QvQWJpcnNfRm9vZENvdXJ0XzAvcHVibGljL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MToiaHR0cDovL2xvY2FsaG9zdC9BYmlyc19Gb29kQ291cnRfMC9wdWJsaWMvZGFzaGJvYXJkIjt9fQ==', 1769399689),
('4SCVCTpNzr67XdHCTySkXulYqxlMccmeXEZwHXWk', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOWd6TXBoT2dQSjRkTWlFVE9YaWo4RWFncVhsVVhjZmdBSW1DbmttayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3QvQWJpcnNfRm9vZENvdXJ0XzAvcHVibGljL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MToiaHR0cDovL2xvY2FsaG9zdC9BYmlyc19Gb29kQ291cnRfMC9wdWJsaWMvZGFzaGJvYXJkIjt9fQ==', 1769101595),
('7nBHatxZh3lJF3qFWFnDQaDIqE9ROPGYiWO41R7x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOTluVHBYRVYzSzdXRDFsdTlSa2dRYnlrQnVVR0NSRjV0QTNTbEN2MiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769688761),
('8wo77umtkFrQafgaPA1HaNPDQAI4pFDg1RU3LDtH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibDFnT3ExaFd3UWpyVHBVSzVleHZ4TVg5TWJqWTZWYWdDNGdGRUZPayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769869253),
('DkMZryY411RDgo8xLhSOaJ5sAJJtpjCydLVxRAbm', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieFg1TjI0UklLNjduazBMWXBuejdsN3ZLd0h1RHk1Z24xbEZjS1huTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fX0=', 1769521873),
('EJgjWVCBsGPg2QsmLNjY1yMs18hAlTbJoksvnz6U', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkh3b3VndTMxaURCWlNXOW1nRjRzNHRPdFhtQU5tbWdRcHhKQW1OSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769747891),
('GJhKrrh9DlHQgttFNOxdJ0FyJTlqb053pTn3CImk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOVM2WERFS1FzTkRwczRUYTlTTUFHWDZzMmZQdjIwNVlNUnhoNTJMcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769174879),
('IdeNsYMn3Rww80DwfAcjhvURpplV9J4QXdCQFln7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkcwS1ZEYTZxb082TDdyeXU0QmxSYkpEcll1N21HTUV3UDZCUHFQTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769258846),
('Px4YCwx9QlDGwsShLemMTreIa1TaFBk4L5sVa5T1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR3g2RkNyZkhWeUp3TzRBTTlxN3JZTTl6VjN1VVRaTXdwY2R3R1dNZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fX0=', 1769315853),
('TgwNBgdmUanvZon3HelGf9X5ogvsPOjbdioA1eZu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGt3ZFA3UmVTT0pKa0NXTlNYSWI4N2V6bldYQ2o2Rjg2SVB6SWQ1QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769399496),
('XUENBYhVyWeSppjQAmRgFWJaqKeTYfwZOe1VsSWf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXQyOUFMQVlFbnQyREtFdFYyVFBqMmVxSFJpc1Ribnc1OTVQVlUxaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1769147661);

-- --------------------------------------------------------

--
-- Table structure for table `rt_suppliers`
--

CREATE TABLE `rt_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `supplier_type` varchar(255) NOT NULL DEFAULT 'food',
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_terms` varchar(255) NOT NULL DEFAULT 'cash',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt_users`
--

CREATE TABLE `rt_users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_users`
--

INSERT INTO `rt_users` (`id`, `name`, `password`, `email`, `role_id`, `address`, `status`, `created_at`, `updated_at`, `photo`) VALUES
(1, 'MAHEDI HASAN', '$2y$12$AAwse5s50Tn32Ckoa1nVfu4/EbQzXFS3GxfR5O7oV6vS/.Y6n0aOm', 'mahedi@gmail.com', 0, 'dhaka', 'Inactive', '0000-00-00 00:00:00', '2026-01-23 06:53:12', ''),
(37, 'Kofil', 'Kofil123', 'kofil@gmail.com', 29, 'Gulshan-1', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(38, 'Maherima', 'Maherima123', 'maherima@gmail.com', 39, 'dhaka', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(42, 'Pollob Sagor', '$2y$12$vl2M7yuetNrzv.oTm0HRcuwaDnYqmeg44/ZDCWqibHHncBZKJ/rHC', 'pollob@example.com', NULL, 'Narayanganj,Siddhirganj, Mouchak Bus Stand', 'Inactive', '2026-01-27 07:57:47', '2026-01-27 07:57:47', NULL),
(43, 'Harun Or Rasid', '$2y$12$mLyTfnk.ZjOOl6Ow6qpU/ehoAze6A5rUpsjn0hTiIOLfN.R1wYPca', 'harun@gmail.com', NULL, 'Narayanganj,Siddhirganj', 'Active', '2026-01-31 08:33:23', '2026-01-31 08:33:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rt_attendance_logs`
--
ALTER TABLE `rt_attendance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_cache`
--
ALTER TABLE `rt_cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `rt_cache_locks`
--
ALTER TABLE `rt_cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `rt_categories`
--
ALTER TABLE `rt_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_categories_name_unique` (`name`);

--
-- Indexes for table `rt_customers`
--
ALTER TABLE `rt_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_daily_attendance`
--
ALTER TABLE `rt_daily_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `idx_att_date` (`att_date`);

--
-- Indexes for table `rt_department`
--
ALTER TABLE `rt_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_designations`
--
ALTER TABLE `rt_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_employees`
--
ALTER TABLE `rt_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_employee_salary`
--
ALTER TABLE `rt_employee_salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_emp` (`emp_id`);

--
-- Indexes for table `rt_failed_jobs`
--
ALTER TABLE `rt_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `rt_invoices`
--
ALTER TABLE `rt_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_invoices_invoice_no_unique` (`invoice_no`),
  ADD KEY `rt_invoices_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `rt_jobs`
--
ALTER TABLE `rt_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rt_jobs_queue_index` (`queue`);

--
-- Indexes for table `rt_job_batches`
--
ALTER TABLE `rt_job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_leave_assign`
--
ALTER TABLE `rt_leave_assign`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`,`leave_type_id`,`year`) COMMENT 'একই বছরে একই এমপ্লয়ারের একই ছুটির ধরন একাধিকবার এন্ট্রি না করতে';

--
-- Indexes for table `rt_leave_request`
--
ALTER TABLE `rt_leave_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_leave_types`
--
ALTER TABLE `rt_leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `leave_code` (`leave_code`);

--
-- Indexes for table `rt_menus`
--
ALTER TABLE `rt_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_migrations`
--
ALTER TABLE `rt_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_orders`
--
ALTER TABLE `rt_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_orders_order_no_unique` (`order_no`),
  ADD KEY `rt_orders_customer_id_status_index` (`customer_id`,`status`),
  ADD KEY `rt_orders_restaurant_id_ordered_at_index` (`restaurant_id`,`ordered_at`);

--
-- Indexes for table `rt_order_items`
--
ALTER TABLE `rt_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rt_order_items_menu_id_foreign` (`menu_id`),
  ADD KEY `rt_order_items_order_id_menu_id_index` (`order_id`,`menu_id`);

--
-- Indexes for table `rt_password_reset_tokens`
--
ALTER TABLE `rt_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `rt_payments`
--
ALTER TABLE `rt_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `rt_payments_order_id_foreign` (`order_id`),
  ADD KEY `rt_payments_customer_id_foreign` (`customer_id`),
  ADD KEY `rt_payments_payment_method_id_foreign` (`payment_method_id`);

--
-- Indexes for table `rt_payment_methods`
--
ALTER TABLE `rt_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_payment_methods_code_unique` (`code`);

--
-- Indexes for table `rt_personal_access_tokens`
--
ALTER TABLE `rt_personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_personal_access_tokens_token_unique` (`token`),
  ADD KEY `rt_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `rt_personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `rt_products`
--
ALTER TABLE `rt_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rt_products_code_unique` (`code`),
  ADD KEY `rt_products_category_id_foreign` (`category_id`),
  ADD KEY `rt_products_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `rt_purchase_orders`
--
ALTER TABLE `rt_purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rt_purchase_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `rt_restaurants`
--
ALTER TABLE `rt_restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_roles`
--
ALTER TABLE `rt_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_sessions`
--
ALTER TABLE `rt_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rt_sessions_user_id_index` (`user_id`),
  ADD KEY `rt_sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `rt_suppliers`
--
ALTER TABLE `rt_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rt_users`
--
ALTER TABLE `rt_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_roles` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rt_attendance_logs`
--
ALTER TABLE `rt_attendance_logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rt_categories`
--
ALTER TABLE `rt_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_customers`
--
ALTER TABLE `rt_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_daily_attendance`
--
ALTER TABLE `rt_daily_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=566;

--
-- AUTO_INCREMENT for table `rt_department`
--
ALTER TABLE `rt_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `rt_designations`
--
ALTER TABLE `rt_designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `rt_employees`
--
ALTER TABLE `rt_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `rt_employee_salary`
--
ALTER TABLE `rt_employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rt_failed_jobs`
--
ALTER TABLE `rt_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_invoices`
--
ALTER TABLE `rt_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_jobs`
--
ALTER TABLE `rt_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_leave_assign`
--
ALTER TABLE `rt_leave_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'প্রতিটি রেকর্ডের ইউনিক ID', AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rt_leave_request`
--
ALTER TABLE `rt_leave_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `rt_leave_types`
--
ALTER TABLE `rt_leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rt_menus`
--
ALTER TABLE `rt_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_migrations`
--
ALTER TABLE `rt_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rt_orders`
--
ALTER TABLE `rt_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_order_items`
--
ALTER TABLE `rt_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_payments`
--
ALTER TABLE `rt_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_payment_methods`
--
ALTER TABLE `rt_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_personal_access_tokens`
--
ALTER TABLE `rt_personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_products`
--
ALTER TABLE `rt_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_purchase_orders`
--
ALTER TABLE `rt_purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_restaurants`
--
ALTER TABLE `rt_restaurants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_roles`
--
ALTER TABLE `rt_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `rt_suppliers`
--
ALTER TABLE `rt_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rt_users`
--
ALTER TABLE `rt_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rt_daily_attendance`
--
ALTER TABLE `rt_daily_attendance`
  ADD CONSTRAINT `rt_daily_attendance_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `rt_employees` (`id`);

--
-- Constraints for table `rt_employee_salary`
--
ALTER TABLE `rt_employee_salary`
  ADD CONSTRAINT `fk_emp` FOREIGN KEY (`emp_id`) REFERENCES `rt_employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rt_invoices`
--
ALTER TABLE `rt_invoices`
  ADD CONSTRAINT `rt_invoices_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `rt_payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rt_orders`
--
ALTER TABLE `rt_orders`
  ADD CONSTRAINT `rt_orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `rt_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rt_orders_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `rt_restaurants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rt_order_items`
--
ALTER TABLE `rt_order_items`
  ADD CONSTRAINT `rt_order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `rt_menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rt_order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `rt_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rt_payments`
--
ALTER TABLE `rt_payments`
  ADD CONSTRAINT `rt_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `rt_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rt_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `rt_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rt_payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `rt_payment_methods` (`id`);

--
-- Constraints for table `rt_products`
--
ALTER TABLE `rt_products`
  ADD CONSTRAINT `rt_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `rt_categories` (`id`),
  ADD CONSTRAINT `rt_products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `rt_suppliers` (`id`);

--
-- Constraints for table `rt_purchase_orders`
--
ALTER TABLE `rt_purchase_orders`
  ADD CONSTRAINT `rt_purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `rt_suppliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
