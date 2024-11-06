-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 12:38 AM
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
-- Database: `ckiosk`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement_tbl`
--

CREATE TABLE `announcement_tbl` (
  `announcement_id` int(25) NOT NULL,
  `announcement_details` longtext NOT NULL,
  `announcement_creator` int(25) NOT NULL,
  `announcement_image` varchar(250) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_tbl`
--

INSERT INTO `announcement_tbl` (`announcement_id`, `announcement_details`, `announcement_creator`, `announcement_image`, `created_at`, `updated_at`) VALUES
(4, '<p>&nbsp;Important Announcement: TSU Student Activity Week</p><p>Dear TSU Students,</p><p>We are excited to announce the upcoming TSU Student Activity Week, a series of engaging events and activities designed to enhance your university experience and foster community spirit.</p><p>Event Details:</p><ul><li>Event Name: TSU Student Activity Week 2024</li><li>Date: Monday, September 30, 2024 - Friday, October 4, 2024</li><li>Time: Various times throughout the week</li><li>Location: TSU Main Campus<', 18, '1724683502_slide_1.jpg', '2024-08-26 00:45:02.000000', '2024-08-26 00:45:02.000000'),
(5, '<p><strong>&nbsp;Upcoming TSU Sports Festival</strong></p><p>Dear TSU Students,</p><p>We are excited to announce the <strong>TSU Sports Festival</strong> coming up next month! Join us for a day filled with sports, fun, and community spirit.</p><p><strong>Event Details:</strong></p><ul><li><strong>Event Name:</strong> TSU Sports Festival 2024</li><li><strong>Date:</strong> Saturday, October 12, 2024</li><li><strong>Time:</strong> 8:00 AM - 5:00 PM</li><li><strong>Location:</strong> TSU Sports Com', 23, '1724683965_portfolio_big_2.jpg', '2024-08-26 00:52:45.000000', '2024-08-26 00:52:45.000000'),
(6, '<p><strong>TSU Career Development Workshop</strong></p><p>Dear TSU Students,</p><p>We are pleased to invite you to the <strong>TSU Career Development Workshop</strong> designed to help you enhance your career skills and prepare for future opportunities.</p><p><strong>Event Details:</strong></p><ul><li><strong>Event Name:</strong> TSU Career Development Workshop 2024</li><li><strong>Date:</strong> Friday, October 18, 2024</li><li><strong>Time:</strong> 9:00 AM - 3:00 PM</li><li><strong>Location:<', 23, '1724684006_portfolio_big_5.jpg', '2024-08-26 00:53:26.000000', '2024-08-26 00:53:26.000000'),
(7, '<p><strong>TSU Library Book Sale</strong></p><p>Dear TSU Students,</p><p>We are excited to announce the <strong>TSU Library Book Sale</strong> happening next week! This is a great opportunity to stock up on books and support our library.</p><p><strong>Event Details:</strong></p><ul><li><strong>Event Name:</strong> TSU Library Book Sale 2024</li><li><strong>Date:</strong> Tuesday, October 8, 2024</li><li><strong>Time:</strong> 10:00 AM - 4:00 PM</li><li><strong>Location:</strong> TSU Library, Mai', 22, '1724684101_blog_3.jpg', '2024-08-26 00:55:01.000000', '2024-08-26 00:55:01.000000'),
(8, '<p><strong>&nbsp;TSU Art Exhibition Opening</strong></p><p>Dear TSU Students,</p><p>We are thrilled to invite you to the grand opening of the <strong>TSU Art Exhibition</strong>, showcasing the incredible talents of our student artists.</p><p><strong>Event Details:</strong></p><ul><li><strong>Event Name:</strong> TSU Art Exhibition 2024</li><li><strong>Date:</strong> Thursday, October 10, 2024</li><li><strong>Time:</strong> 5:00 PM - 8:00 PM</li><li><strong>Location:</strong> TSU Art Gallery, Bu', 22, '1724684147_slide_2.jpg', '2024-08-26 00:55:47.000000', '2024-08-26 00:55:47.000000'),
(13, '<p>dwdwadwa</p>', 23, '1727432305_e3a95ea66a9ba30614d76dbf4d835a62.jpg', '2024-09-27 04:18:25.000000', '2024-09-27 04:18:25.000000'),
(14, '<p>dwadawdwa</p>', 22, '', '2024-09-27 04:19:31.000000', '2024-09-27 04:19:31.000000'),
(15, '<p>dwadwadwaad</p>', 22, '1727701068_FlavoredBread.jpg', '2024-09-30 06:57:48.000000', '2024-09-30 06:57:48.000000');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_tbl`
--

CREATE TABLE `calendar_tbl` (
  `calendar_id` int(25) NOT NULL,
  `calendar_date` date NOT NULL,
  `calendar_details` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_tbl`
--

INSERT INTO `calendar_tbl` (`calendar_id`, `calendar_date`, `calendar_details`) VALUES
(42, '2024-10-02', '<p>dwadwadwadw</p>'),
(43, '2024-10-03', '<p>HI TSU</p>'),
(44, '2024-10-04', '<p>hi tsu</p><p><br></p>'),
(45, '2024-10-02', '<p>HI TSU</p>');

-- --------------------------------------------------------

--
-- Table structure for table `department_tbl`
--

CREATE TABLE `department_tbl` (
  `department_id` int(25) NOT NULL,
  `department_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_tbl`
--

INSERT INTO `department_tbl` (`department_id`, `department_name`) VALUES
(1, 'IT Deparment'),
(2, 'CS Department'),
(3, 'IS Department'),
(4, 'MIT'),
(5, 'Dean');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_tbl`
--

CREATE TABLE `faculty_tbl` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(250) NOT NULL,
  `faculty_dept` int(25) NOT NULL,
  `faculty_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_tbl`
--

INSERT INTO `faculty_tbl` (`faculty_id`, `faculty_name`, `faculty_dept`, `faculty_image`) VALUES
(2, 'John Wick', 2, 'John Wick_p1.jpg'),
(6, 'Juan Dela Cruz', 3, 'John Wick_p3.jpg'),
(8, 'Shrek Org', 1, 'Shrek Org_og.jpg'),
(35, 'Luffy', 4, '1724230725_1.jpg'),
(36, 'Zoro', 4, '1724221472_2.png'),
(37, 'Nami', 2, '5.jpg'),
(38, 'EDIT FACULTY TEST', 2, '1721292414_p1.jpg'),
(46, 'TSU', 1, '455657021_3441338802835268_7216133741851703356_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `faqs_tbl`
--

CREATE TABLE `faqs_tbl` (
  `faqs_id` int(25) NOT NULL,
  `faqs_question` varchar(500) NOT NULL,
  `faqs_answer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs_tbl`
--

INSERT INTO `faqs_tbl` (`faqs_id`, `faqs_question`, `faqs_answer`) VALUES
(9, '<p><b>G?dwadwad</b></p>', '<p>123</p>'),
(34, '<p>dwad</p>', '<p>dwad</p>'),
(35, '<p><b>HI TSU</b></p>', '<b>HI TSU</b>'),
(36, '<p>dwadwa</p>', '<p>dwadwa</p>'),
(37, '<p>dwad</p>', '<p>dwadaw</p>'),
(38, '<p>dwadwa</p>', '<p>wdwadw</p>');

-- --------------------------------------------------------

--
-- Table structure for table `heads_tbl`
--

CREATE TABLE `heads_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `faculty_dept` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `heads_tbl`
--

INSERT INTO `heads_tbl` (`id`, `name`, `img`, `faculty_dept`) VALUES
(1, 'Al vincent', '1.jpg', 1),
(2, 'John Doe', '2.png', 2),
(3, 'Jane Smith', '3.png', 3),
(4, 'Alice Johnson', '4.png', 4),
(5, 'Bob Brown', '5.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `organization_tbl`
--

CREATE TABLE `organization_tbl` (
  `org_id` int(25) NOT NULL,
  `org_name` text NOT NULL,
  `org_image` varchar(250) NOT NULL,
  `users_type` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_tbl`
--

INSERT INTO `organization_tbl` (`org_id`, `org_name`, `org_image`, `users_type`) VALUES
(1, 'STUDENT CLUB &amp; ORGS', 'PROGRAMMERS DEN_1st.png', 0),
(2, 'INNOVATORS', 'INNoVATORS_2nd.png', 0),
(3, 'CAMPUS STUDENT ORGANIZATION', 'CAMPUS STUDENT ORGANIZATION_3rd.jpg', 0),
(5, 'ADMIN', 'ADMIN_5th.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orgmembers_tbl`
--

CREATE TABLE `orgmembers_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `org_type` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `users_type` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orgmembers_tbl`
--

INSERT INTO `orgmembers_tbl` (`id`, `name`, `username`, `position`, `org_type`, `password`, `users_type`) VALUES
(28, 'hanzsadsadsadsa', 'HANZ PILLERVA', 'Member', 2, 'b5f89e316ac9d1c60462b2f7bfb0dabedbcf21b4783dc3cf4a7b14434d0ee168', 3);

-- --------------------------------------------------------

--
-- Table structure for table `room_tbl`
--

CREATE TABLE `room_tbl` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(25) NOT NULL,
  `floor_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_tbl`
--

INSERT INTO `room_tbl` (`room_id`, `room_name`, `floor_id`) VALUES
(1, 'blank', 1),
(2, 'C111', 1),
(3, 'C112', 1),
(4, 'LOBBY', 1),
(5, 'FACULTY', 1),
(6, 'blank', 1),
(7, 'FACULTY', 1),
(8, 'STAIRS', 1),
(9, 'STAIRS', 1),
(10, 'L102', 1),
(11, 'GROUND FLOOR', 1),
(12, 'R121', 1),
(13, 'L101', 1),
(14, 'R122', 1),
(15, 'blank', 1),
(16, 'blank', 1),
(17, 'STAIRS', 1),
(18, 'STAIRS', 1),
(19, 'CR', 2),
(20, 'C211', 2),
(21, 'C212', 2),
(22, 'C213', 2),
(23, 'C214', 2),
(24, 'DEAN OFFICE', 2),
(25, 'FACULTY', 2),
(26, 'STAIRS', 2),
(27, 'STAIRS', 2),
(28, 'L202', 2),
(29, 'GROUND FLOOR', 2),
(30, 'R222', 2),
(31, 'L201', 2),
(32, 'R221', 2),
(33, 'blank', 2),
(34, 'blank', 2),
(35, 'STAIRS', 2),
(36, 'STAIRS', 2),
(37, 'CR', 3),
(38, 'C311', 3),
(39, 'C312', 3),
(40, 'C313', 3),
(41, 'C314', 3),
(42, 'C315', 3),
(43, 'CR', 3),
(44, 'STAIRS', 3),
(45, 'STAIRS', 3),
(46, 'L302', 3),
(47, 'GROUND FLOOR', 3),
(48, 'R321', 3),
(49, 'blank', 3),
(50, 'L301', 3),
(51, 'blank', 3),
(52, 'blank', 3),
(53, 'STAIRS', 3),
(54, 'STAIRS', 3),
(55, 'CR', 4),
(56, 'C411', 4),
(57, 'C412', 4),
(58, 'C413', 4),
(59, 'C414', 4),
(60, 'C415', 4),
(61, 'CSC OFFICE', 4),
(62, 'MIT ROOM', 4),
(63, 'STAIRS', 4),
(64, 'STAIRS', 4),
(65, 'L402', 4),
(66, 'GROUND FLOOR', 4),
(67, 'R421', 4),
(68, 'L401', 4),
(69, 'R422', 4),
(70, 'BLANK', 4),
(71, 'MIS', 4),
(72, 'STAIRS', 4),
(73, 'STAIRS', 4),
(74, 'blank', 5),
(75, 'AVR', 5),
(76, 'CR', 5),
(77, 'STAIRS', 5),
(78, 'STAIRS', 5),
(79, 'L502', 5),
(80, 'GROUND FLOOR', 5),
(81, 'CISCO ROOM', 5),
(82, 'L501', 5),
(83, 'blank', 5),
(84, 'blank', 5),
(85, 'STAIRS', 5),
(86, 'STAIRS', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `users_id` int(25) NOT NULL,
  `users_username` varchar(250) NOT NULL,
  `users_password` varchar(250) NOT NULL,
  `users_org` int(25) NOT NULL,
  `users_type` int(25) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`users_id`, `users_username`, `users_password`, `users_org`, `users_type`) VALUES
(18, 'admin', 'd07e7c4cce2afb5fdab874b1f6c1f95a06564921bad3486805e5bd27fad62457', 5, 1),
(22, 'org1', 'b5f89e316ac9d1c60462b2f7bfb0dabedbcf21b4783dc3cf4a7b14434d0ee168', 2, 2),
(23, 'org2', '29d07a242e8f608b02ddf19f7673b973b40414360a983c56ea24f982d104a3e1', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type_tbl`
--

CREATE TABLE `user_type_tbl` (
  `user_id` int(25) NOT NULL,
  `user_type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type_tbl`
--

INSERT INTO `user_type_tbl` (`user_id`, `user_type`) VALUES
(1, 'admin'),
(3, 'member'),
(2, 'organization');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement_tbl`
--
ALTER TABLE `announcement_tbl`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `calendar_tbl`
--
ALTER TABLE `calendar_tbl`
  ADD PRIMARY KEY (`calendar_id`);

--
-- Indexes for table `department_tbl`
--
ALTER TABLE `department_tbl`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `faculty_tbl`
--
ALTER TABLE `faculty_tbl`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `faqs_tbl`
--
ALTER TABLE `faqs_tbl`
  ADD PRIMARY KEY (`faqs_id`);

--
-- Indexes for table `heads_tbl`
--
ALTER TABLE `heads_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_tbl`
--
ALTER TABLE `organization_tbl`
  ADD PRIMARY KEY (`org_id`);

--
-- Indexes for table `orgmembers_tbl`
--
ALTER TABLE `orgmembers_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_tbl`
--
ALTER TABLE `room_tbl`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `user_type_tbl`
--
ALTER TABLE `user_type_tbl`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_type` (`user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement_tbl`
--
ALTER TABLE `announcement_tbl`
  MODIFY `announcement_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `calendar_tbl`
--
ALTER TABLE `calendar_tbl`
  MODIFY `calendar_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `department_tbl`
--
ALTER TABLE `department_tbl`
  MODIFY `department_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculty_tbl`
--
ALTER TABLE `faculty_tbl`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `faqs_tbl`
--
ALTER TABLE `faqs_tbl`
  MODIFY `faqs_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `heads_tbl`
--
ALTER TABLE `heads_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `organization_tbl`
--
ALTER TABLE `organization_tbl`
  MODIFY `org_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orgmembers_tbl`
--
ALTER TABLE `orgmembers_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `room_tbl`
--
ALTER TABLE `room_tbl`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `users_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_type_tbl`
--
ALTER TABLE `user_type_tbl`
  MODIFY `user_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
