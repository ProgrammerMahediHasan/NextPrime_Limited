-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2026 at 07:57 AM
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
  `source` enum('Biometric','Manual','Web') DEFAULT 'Manual',
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `status` enum('Working-Day','Weekend','Holiday') DEFAULT 'Weekend',
  `grace_time` time DEFAULT '09:10:00',
  `late_time` time DEFAULT '09:11:00',
  `total_work_minutes` int(11) DEFAULT 0,
  `remarks` varchar(255) DEFAULT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_attendance_logs`
--

INSERT INTO `rt_attendance_logs` (`source`, `in_time`, `out_time`, `status`, `grace_time`, `late_time`, `total_work_minutes`, `remarks`, `id`) VALUES
('Manual', '09:00:00', '17:00:00', 'Working-Day', '09:10:00', '09:11:00', 480, 'Good', 0);

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
(557, 19, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, ''),
(558, 20, '2025-12-12', 'Weekend', '00:00:00', '00:00:00', 0, 'Day Off', 0, 0, '');

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
  `dept_id` int(11) NOT NULL,
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
(5, 5, 'Operations Officer', 'Coordinates daily business operations, monitors workflow, and ensures smooth departmental collaboration.');

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
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `basic_salary` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `joining_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_employees`
--

INSERT INTO `rt_employees` (`id`, `name`, `dept_id`, `desig_id`, `gender`, `email`, `phone`, `basic_salary`, `status`, `joining_date`) VALUES
(1, 'Mahedi Hasan Abir', 3, 3, 'Male', 'mahedihasanabir8@gmail.com', '01732074663', 50000.00, 'Active', '2025-09-30'),
(2, 'Tanvir Jubayer', 4, 4, 'Male', 'tanvir@gmail.com', '01732074663', 30000.00, 'Active', '2025-09-30'),
(3, 'Pollob Ahmed Sagor', 2, 2, 'Male', 'pollobsagor@gmail.com', '01575550883', 35000.00, 'Active', '2025-09-30'),
(4, 'Rashed Khan', 5, 5, 'Male', 'rashed@gmail.com', '01983581152', 42000.00, 'Active', '2025-09-30'),
(5, 'Abdullah Bin Hanif', 1, 1, 'Male', 'hanif@gmail.com', '01983581152', 55000.00, 'Active', '2025-09-30'),
(19, 'Tithi Akter', 1, 1, 'Female', 'tithi@gmail.com', '01575550844', 0.00, 'Active', '1997-02-01'),
(20, 'Maherima Islam', 5, 5, 'Female', 'maherimaislam@gmail.com', '01575550883', 0.00, 'Active', '2025-12-01');

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
(16, 2, 17, 10, 0, '2025', '2025-12-09 20:50:49', '2025-12-10 09:06:40'),
(21, 5, 20, 12, 13, '2025', '2025-12-11 21:44:33', '2025-12-11 21:46:22');

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
(76, 5, 20, '2025-11-01', '2025-11-03', 3, 'Casual', 'Approved', 0, '2025-12-01 00:00:00');

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
-- Table structure for table `rt_roles`
--

CREATE TABLE `rt_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_roles`
--

INSERT INTO `rt_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(39, 'Admin', '2025-12-12 10:21:05', '2025-12-12 10:21:05'),
(41, 'HR Manager', '2025-12-12 10:21:37', '2025-12-12 10:21:37'),
(42, 'Accounts Manager', '2025-12-12 10:21:50', '2025-12-12 10:21:50'),
(43, 'Department Manager', '2025-12-12 10:22:01', '2025-12-12 10:22:01'),
(44, 'Employee', '2025-12-12 10:22:10', '2025-12-12 10:22:10');

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
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt_users`
--

INSERT INTO `rt_users` (`id`, `name`, `password`, `email`, `role_id`, `address`, `status`, `created_at`, `updated_at`, `photo`) VALUES
(1, 'mahedi', 'mahedi123', 'mahedi@gmail.com', 0, 'dhaka', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(37, 'Kofil', 'Kofil123', 'kofil@gmail.com', 29, 'Gulshan-1', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(38, 'Maherima', 'Maherima123', 'maherima@gmail.com', 0, 'dhaka', 'Active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `rt_roles`
--
ALTER TABLE `rt_roles`
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
-- AUTO_INCREMENT for table `rt_daily_attendance`
--
ALTER TABLE `rt_daily_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=559;

--
-- AUTO_INCREMENT for table `rt_department`
--
ALTER TABLE `rt_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rt_designations`
--
ALTER TABLE `rt_designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rt_employees`
--
ALTER TABLE `rt_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rt_employee_salary`
--
ALTER TABLE `rt_employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rt_leave_assign`
--
ALTER TABLE `rt_leave_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'প্রতিটি রেকর্ডের ইউনিক ID', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rt_leave_request`
--
ALTER TABLE `rt_leave_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `rt_leave_types`
--
ALTER TABLE `rt_leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `rt_roles`
--
ALTER TABLE `rt_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `rt_users`
--
ALTER TABLE `rt_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
