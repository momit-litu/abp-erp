-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table abpdb.actions
CREATE TABLE IF NOT EXISTS `actions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) NOT NULL DEFAULT 0,
  `is_menu` bigint(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_actions_menus` (`module_id`),
  KEY `FK_actions_menus_2` (`is_menu`),
  CONSTRAINT `FK_actions_menus` FOREIGN KEY (`module_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `FK_actions_menus_2` FOREIGN KEY (`is_menu`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.actions: ~76 rows (approximately)
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` (`id`, `activity_name`, `module_id`, `is_menu`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Admin User Management', 4, 5, 1, NULL, NULL),
	(2, 'Admin User Entry', 4, NULL, 1, NULL, NULL),
	(3, 'Admin User Update', 4, NULL, 1, NULL, NULL),
	(4, 'Admin User Delete', 4, NULL, 1, NULL, NULL),
	(5, 'Action Management', 7, 10, 1, NULL, NULL),
	(6, 'Action Entry', 7, NULL, 1, NULL, NULL),
	(7, 'Action Update', 7, NULL, 1, NULL, NULL),
	(8, 'Module Management', 7, 9, 1, NULL, NULL),
	(9, 'Module Entry', 7, NULL, 1, NULL, NULL),
	(10, 'Module Update', 7, NULL, 1, NULL, NULL),
	(11, 'Module Delete', 7, NULL, 1, NULL, NULL),
	(12, 'General Setting Management', 11, 8, 1, '2020-04-09 14:26:07', '2020-04-10 01:28:49'),
	(15, 'General Setting Update', 11, NULL, 1, '2020-04-10 00:50:37', '2020-04-10 01:28:54'),
	(16, 'Group Management', 11, 14, 1, '2020-04-10 10:54:39', '2020-04-10 10:59:51'),
	(17, 'User Group Entry', 11, NULL, 1, '2020-04-10 10:55:22', '2020-04-10 10:55:22'),
	(18, 'User Group Update', 11, NULL, 1, '2020-04-10 10:55:36', '2020-04-10 10:55:36'),
	(19, 'User Group Delete', 11, NULL, 1, '2020-04-10 10:56:36', '2020-04-10 10:56:36'),
	(20, 'Assign Group Permission', 11, NULL, 1, '2020-04-10 11:26:19', '2020-04-10 11:26:19'),
	(21, 'Unit Management', 15, 18, 1, '2021-03-21 07:07:10', '2021-03-21 07:07:10'),
	(22, 'Unit Entry', 15, NULL, 1, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(23, 'Unit Update', 15, NULL, 1, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(24, 'Unit Delete', 15, NULL, 1, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(25, 'Course Management', 15, 17, 1, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(26, 'Course Entry', 15, NULL, 1, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(27, 'Course Update', 15, NULL, 1, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(28, 'Course Delete', 15, NULL, 1, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(38, 'Student Management', 19, 19, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(39, 'Student Entry', 19, NULL, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(40, 'Student Update', 19, NULL, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(41, 'Student Delete', 19, NULL, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(66, 'Expense Category Management', 28, 29, 1, '2021-06-12 07:42:36', '2021-06-12 07:42:36'),
	(67, 'Expense Category Entry', 28, NULL, 1, '2021-06-12 08:22:03', '2021-06-12 08:22:03'),
	(68, 'Expense Category Update', 28, NULL, 1, '2021-06-12 08:23:18', '2021-06-12 08:23:18'),
	(69, 'Expense Category Delete', 28, NULL, 1, '2021-06-12 08:23:28', '2021-06-12 08:23:28'),
	(73, 'Expense Head Management', 28, 33, 1, '2021-07-06 12:20:48', '2021-07-06 12:20:48'),
	(74, 'Expense Head Entry', 28, NULL, 1, '2021-07-06 12:21:15', '2021-07-06 12:21:15'),
	(75, 'Expense Head Update', 28, NULL, 1, '2021-07-06 12:21:23', '2021-07-06 12:21:23'),
	(76, 'Expense Head Delete', 28, NULL, 1, '2021-07-06 12:21:31', '2021-07-06 12:21:31'),
	(77, 'Expense Management', 28, 34, 1, '2021-07-06 12:22:02', '2021-07-06 12:22:02'),
	(78, 'Expenses Entry', 28, NULL, 1, '2021-07-06 12:22:16', '2021-07-06 12:22:16'),
	(79, 'Expense Update', 28, NULL, 1, '2021-07-06 12:22:27', '2021-07-06 12:22:27'),
	(80, 'Expense Delete', 28, NULL, 1, '2021-07-06 12:22:36', '2021-07-06 12:22:36'),
	(81, 'Batch Management', 15, 35, 1, '2021-07-07 12:54:26', '2021-07-07 12:54:26'),
	(82, 'Batch Entry', 15, NULL, 1, '2021-07-07 12:54:43', '2021-07-07 12:54:43'),
	(83, 'Batch Update', 15, NULL, 1, '2021-07-07 12:55:01', '2021-07-07 12:55:01'),
	(84, 'Batch Delete', 15, NULL, 1, '2021-07-07 12:55:12', '2021-07-07 12:55:12'),
	(85, 'Batch Student Enroll', 17, NULL, 1, '2021-07-10 07:45:23', '2021-07-10 07:45:23'),
	(86, 'Payment Management', 36, 37, 1, '2021-07-12 07:31:30', '2021-07-12 07:34:12'),
	(87, 'Payment Entry', 36, NULL, 1, '2021-07-12 07:35:49', '2021-07-12 07:35:49'),
	(88, 'Payment Update', 37, NULL, 1, '2021-07-12 07:36:06', '2021-07-12 07:36:06'),
	(89, 'Payment Delete', 36, NULL, 1, '2021-07-12 07:36:21', '2021-07-12 07:36:21'),
	(90, 'Payment Schedule Management', 36, 38, 1, '2021-07-13 11:40:16', '2021-07-13 11:40:16'),
	(91, 'Payment Schedule Edit', 36, NULL, 1, '2021-07-13 11:40:29', '2021-07-13 11:40:29'),
	(92, 'Payment Schedule Delete', 36, NULL, 1, '2021-07-13 11:40:41', '2021-07-13 11:40:41'),
	(93, 'Revise Payment Management', 36, 39, 1, '2021-08-24 07:50:55', '2021-08-24 07:50:55'),
	(94, 'Send SMS', 40, NULL, 1, '2021-08-24 13:50:25', '2021-08-24 13:50:25'),
	(95, 'Send Email', 40, 42, 1, '2021-08-24 13:50:40', '2021-08-24 13:50:40'),
	(96, 'Bulk SMS', 40, 41, 1, '2021-08-30 14:01:34', '2021-08-30 14:01:34'),
	(97, 'Course Report', 44, 45, 1, '2021-08-31 07:38:38', '2021-08-31 07:38:38'),
	(98, 'Batch Report', 44, 46, 1, '2021-08-31 07:38:59', '2021-08-31 07:38:59'),
	(99, 'Student Report', 44, 47, 1, '2021-08-31 07:39:15', '2021-08-31 07:39:15'),
	(100, 'Payment Schedule Report', 44, 48, 1, '2021-08-31 07:39:44', '2021-08-31 07:39:44'),
	(101, 'Payment Collection Report', 44, 49, 1, '2021-08-31 07:39:58', '2021-08-31 07:39:58'),
	(102, 'Schedule Vs Collection Report', 44, 50, 1, '2021-08-31 07:40:26', '2021-08-31 07:40:26'),
	(103, 'Expense report', 44, 51, 1, '2021-08-31 07:41:30', '2021-08-31 07:41:30'),
	(104, 'Expense Vs Income', 44, 52, 1, '2021-08-31 07:41:41', '2021-08-31 07:41:41'),
	(105, 'Financial Report', 44, 53, 1, '2021-10-01 13:13:14', '2021-10-01 13:13:14'),
	(106, 'Dashboard Registration info', 22, NULL, 1, '2021-12-18 05:59:08', '2021-12-18 05:59:49'),
	(107, 'Dashboard Payment and schedule info', 22, NULL, 1, '2021-12-18 06:00:23', '2021-12-18 06:00:23'),
	(108, 'Dashboard Student registration barchart', 22, NULL, 1, '2021-12-18 06:00:35', '2021-12-18 06:00:35'),
	(109, 'Dashboard Financial status', 22, NULL, 1, '2021-12-18 06:00:44', '2021-12-18 06:00:44'),
	(110, 'Dashboard Registered students', 22, NULL, 1, '2021-12-18 06:00:58', '2021-12-18 06:00:58'),
	(111, 'Dashboard Enrolled students', 22, NULL, 1, '2021-12-18 06:01:11', '2021-12-18 06:01:11'),
	(112, 'Dashboard Payments', 22, NULL, 1, '2021-12-18 06:01:28', '2021-12-18 06:01:28'),
	(113, 'Dashboard Upcoming Batches', 22, NULL, 1, '2021-12-18 06:01:37', '2021-12-18 06:01:37'),
	(114, 'Draft Batch', 35, NULL, 1, '2022-01-19 03:06:40', '2022-01-19 03:06:40'),
	(115, 'Books', 15, 54, 1, '2022-02-18 05:17:13', '2022-02-18 05:17:13'),
	(116, 'Book entry', 15, NULL, 1, '2022-02-18 05:17:37', '2022-02-18 05:17:37'),
	(117, 'Template CRUD', 40, 55, 1, '2022-02-25 02:02:46', '2022-02-25 02:02:46'),
	(118, 'Batch transfer', 15, 56, 1, '2022-03-04 09:07:06', '2022-03-04 09:07:06');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;

-- Dumping structure for table abpdb.batches
CREATE TABLE IF NOT EXISTS `batches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `batch_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `class_schedule` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fees` double NOT NULL DEFAULT 0,
  `discounted_fees` double(22,0) NOT NULL DEFAULT 0,
  `student_limit` tinyint(2) NOT NULL DEFAULT 0,
  `total_enrolled_student` tinyint(2) NOT NULL DEFAULT 0,
  `details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `running_status` enum('Completed','Running','Upcoming') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Upcoming',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `draft` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `show_seat_limit` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `featured` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_batches_courses` (`course_id`),
  CONSTRAINT `FK_batches_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batches: ~8 rows (approximately)
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
INSERT INTO `batches` (`id`, `course_id`, `batch_name`, `start_date`, `end_date`, `class_schedule`, `fees`, `discounted_fees`, `student_limit`, `total_enrolled_student`, `details`, `running_status`, `status`, `draft`, `show_seat_limit`, `featured`, `created_by`, `created_at`, `updated_at`) VALUES
	(5, 9, '12', '2021-08-15', NULL, 'Monday 12.00PM - 2.00PM', 50000, 48000, 20, 20, 'some details', 'Upcoming', 'Active', 'No', 'No', 'No', 0, '2021-07-08 14:07:47', '2021-08-17 20:00:50'),
	(10, 9, '13', '2021-10-15', NULL, 'Monday 12.00PM - 2.00PM', 60000, 55000, 30, 6, NULL, 'Upcoming', 'Active', 'No', 'No', 'No', 0, '2021-07-08 14:31:13', '2021-09-23 03:43:57'),
	(11, 9, '14', '2022-01-01', NULL, 'Monday 12.00PM - 2.00PM', 50000, 44000, 20, 5, NULL, 'Running', 'Active', 'No', 'No', 'No', 0, '2021-07-08 18:50:31', '2022-01-18 07:31:24'),
	(12, 10, '01', '2021-09-01', '2022-08-31', 'Monday 12.00PM - 2.00PM', 25000, 20000, 30, 11, NULL, 'Running', 'Active', 'No', 'No', 'Yes', 0, '2021-07-14 15:28:26', '2022-03-04 06:03:25'),
	(13, 10, '045', '2021-08-29', '2021-09-29', 'Monday 12.00PM - 2.00PM', 500000, 500000, 50, 1, NULL, 'Completed', 'Active', 'No', 'No', 'No', 0, '2021-09-01 10:13:10', '2021-09-25 06:58:17'),
	(15, 9, '14', '2021-11-11', NULL, 'Monday 12.00PM - 2.00PM', 80000, 78000, 50, 4, NULL, 'Upcoming', 'Inactive', 'No', 'No', 'No', 0, '2021-09-23 04:20:06', '2022-01-18 10:51:32'),
	(16, 10, '046', '2022-01-01', NULL, NULL, 660000, 60000, 40, 2, NULL, 'Upcoming', 'Active', 'No', 'No', 'No', 0, '2021-10-07 13:30:36', '2022-01-18 07:28:19'),
	(17, 9, 'Test Batch1', '2022-01-19', NULL, NULL, 40000, 40000, 5, 1, NULL, 'Upcoming', 'Active', 'Yes', 'No', 'No', 0, '2022-01-18 10:57:57', '2022-03-02 15:49:30');
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;

-- Dumping structure for table abpdb.batch_books
CREATE TABLE IF NOT EXISTS `batch_books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` bigint(20) unsigned NOT NULL,
  `book_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_books: ~5 rows (approximately)
/*!40000 ALTER TABLE `batch_books` DISABLE KEYS */;
INSERT INTO `batch_books` (`id`, `batch_id`, `book_no`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
	(1, 13, 'asdasdFF', 0, 'Active', '2022-03-02 20:01:18', '2022-03-03 14:06:33'),
	(2, 13, 'DDDD', 0, 'Inactive', '2022-03-02 20:01:18', '2022-03-03 15:11:38'),
	(8, 13, 'AAAA', 0, 'Active', '2022-03-03 15:07:43', '2022-03-03 15:07:43'),
	(13, 12, 'Book1', 0, 'Active', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(14, 12, 'Book2', 0, 'Active', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(15, 13, 'ZBoo4', 1, 'Active', '2022-03-04 20:32:44', '2022-03-04 20:32:44'),
	(16, 12, 'Book3', 1, 'Active', '2022-03-05 08:49:00', '2022-03-05 08:49:00');
/*!40000 ALTER TABLE `batch_books` ENABLE KEYS */;

-- Dumping structure for table abpdb.batch_fees
CREATE TABLE IF NOT EXISTS `batch_fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` bigint(20) unsigned NOT NULL,
  `plan_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_installment` tinyint(2) NOT NULL,
  `installment_duration` tinyint(2) NOT NULL,
  `payable_amount` double(8,2) NOT NULL,
  `payment_type` enum('Installment','Onetime') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Onetime',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_batch_fees_batches` (`batch_id`),
  CONSTRAINT `FK_batch_fees_batches` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_fees: ~13 rows (approximately)
/*!40000 ALTER TABLE `batch_fees` DISABLE KEYS */;
INSERT INTO `batch_fees` (`id`, `batch_id`, `plan_name`, `total_installment`, `installment_duration`, `payable_amount`, `payment_type`, `status`, `created_at`, `updated_at`) VALUES
	(10, 5, 'Onetime', 1, 0, 48000.00, 'Onetime', 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(11, 5, '2Installment', 2, 6, 50000.00, 'Installment', 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(12, 5, '3Installment', 3, 4, 52000.00, 'Installment', 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(18, 10, 'Onetime', 1, 0, 55000.00, 'Onetime', 'Active', '2021-07-08 14:31:13', '2021-07-08 14:31:13'),
	(19, 10, '2Installment', 2, 6, 60000.00, 'Installment', 'Active', '2021-07-08 14:31:13', '2021-07-08 14:31:13'),
	(20, 11, 'Onetime', 1, 0, 44000.00, 'Onetime', 'Active', '2021-07-08 18:50:31', '2021-07-08 19:04:46'),
	(21, 11, '3installment', 3, 4, 50000.00, 'Installment', 'Active', '2021-07-08 18:50:31', '2021-07-08 19:39:35'),
	(23, 11, '2Installment', 2, 6, 50000.00, 'Installment', 'Active', '2021-07-08 19:39:35', '2021-07-08 19:39:35'),
	(24, 12, 'Onetime', 1, 0, 20000.00, 'Onetime', 'Active', '2021-07-14 15:28:26', '2021-07-14 15:28:26'),
	(25, 12, '2Installment', 2, 6, 22000.00, 'Installment', 'Active', '2021-07-14 15:28:26', '2021-07-14 15:28:26'),
	(26, 13, 'Onetime', 1, 0, 500000.00, 'Onetime', 'Active', '2021-09-01 10:13:10', '2021-09-01 10:13:10'),
	(28, 15, 'Onetime', 1, 0, 78000.00, 'Onetime', 'Active', '2021-09-23 04:20:06', '2021-09-23 04:20:06'),
	(29, 15, '3Installment', 3, 6, 80000.00, 'Installment', 'Active', '2021-09-23 04:20:06', '2021-09-23 04:20:06'),
	(30, 16, 'Onetime', 1, 0, 60000.00, 'Onetime', 'Active', '2021-10-07 13:30:36', '2021-10-07 13:30:36'),
	(31, 17, 'Onetime', 1, 0, 40000.00, 'Onetime', 'Active', '2022-01-18 10:57:57', '2022-01-18 10:57:57');
/*!40000 ALTER TABLE `batch_fees` ENABLE KEYS */;

-- Dumping structure for table abpdb.batch_fees_details
CREATE TABLE IF NOT EXISTS `batch_fees_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_fees_id` bigint(20) unsigned NOT NULL,
  `installment_no` tinyint(2) NOT NULL DEFAULT 1,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_batch_fees_details_batch_fees` (`batch_fees_id`),
  CONSTRAINT `FK_batch_fees_details_batch_fees` FOREIGN KEY (`batch_fees_id`) REFERENCES `batch_fees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_fees_details: ~25 rows (approximately)
/*!40000 ALTER TABLE `batch_fees_details` DISABLE KEYS */;
INSERT INTO `batch_fees_details` (`id`, `batch_fees_id`, `installment_no`, `amount`, `status`, `created_at`, `updated_at`) VALUES
	(10, 10, 1, 48000.00, 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(11, 11, 1, 30000.00, 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(12, 11, 2, 20000.00, 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(13, 12, 1, 20000.00, 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(14, 12, 2, 20000.00, 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(15, 12, 3, 12000.00, 'Active', '2021-07-08 14:07:47', '2021-07-08 14:07:47'),
	(22, 18, 1, 55000.00, 'Active', '2021-07-08 14:31:13', '2021-07-08 14:31:13'),
	(23, 19, 1, 30000.00, 'Active', '2021-07-08 14:31:13', '2021-07-08 14:31:13'),
	(24, 19, 2, 30000.00, 'Active', '2021-07-08 14:31:13', '2021-07-08 14:31:13'),
	(25, 20, 1, 44000.00, 'Active', '2021-07-08 18:50:31', '2021-07-08 19:04:46'),
	(41, 21, 1, 20000.00, 'Active', '2021-07-08 19:40:33', '2021-07-08 19:40:33'),
	(42, 21, 2, 20000.00, 'Active', '2021-07-08 19:40:33', '2021-07-08 19:40:33'),
	(43, 21, 3, 10000.00, 'Active', '2021-07-08 19:40:33', '2021-07-08 19:40:33'),
	(44, 23, 1, 30000.00, 'Active', '2021-07-08 19:40:33', '2021-07-08 19:40:33'),
	(45, 23, 2, 20000.00, 'Active', '2021-07-08 19:40:33', '2021-07-08 19:40:33'),
	(46, 24, 1, 20000.00, 'Active', '2021-07-14 15:28:26', '2021-07-14 15:28:26'),
	(47, 25, 1, 11000.00, 'Active', '2021-07-14 15:28:26', '2021-07-14 15:28:26'),
	(48, 25, 2, 11000.00, 'Active', '2021-07-14 15:28:26', '2021-07-14 15:28:26'),
	(49, 26, 1, 500000.00, 'Active', '2021-09-01 10:13:10', '2021-09-01 10:13:10'),
	(51, 28, 1, 78000.00, 'Active', '2021-09-23 04:20:06', '2021-09-23 04:20:06'),
	(64, 30, 1, 60000.00, 'Active', '2021-10-07 13:30:36', '2021-10-07 13:30:36'),
	(68, 29, 1, 30000.00, 'Active', '2022-01-18 10:51:32', '2022-01-18 10:51:32'),
	(69, 29, 2, 30000.00, 'Active', '2022-01-18 10:51:32', '2022-01-18 10:51:32'),
	(70, 29, 3, 20000.00, 'Active', '2022-01-18 10:51:32', '2022-01-18 10:51:32'),
	(71, 31, 1, 40000.00, 'Active', '2022-01-18 10:57:57', '2022-01-18 10:57:57');
/*!40000 ALTER TABLE `batch_fees_details` ENABLE KEYS */;

-- Dumping structure for table abpdb.batch_students
CREATE TABLE IF NOT EXISTS `batch_students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `batch_fees_id` bigint(20) unsigned NOT NULL,
  `student_enrollment_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `total_payable` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `total_paid` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `balance` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `current_batch` enum('Yes','Transfered') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `prev_batch_student_id` bigint(20) DEFAULT NULL,
  `transfer_fee` double DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `overall_result` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dropout` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `result_published_status` enum('Published','Not-published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not-published',
  `welcome_email` enum('Sent','Not-sent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not-sent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_batch_students_batches` (`batch_id`),
  KEY `FK_batch_students_students` (`student_id`),
  CONSTRAINT `FK_batch_students_batches` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `FK_batch_students_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_students: ~24 rows (approximately)
/*!40000 ALTER TABLE `batch_students` DISABLE KEYS */;
INSERT INTO `batch_students` (`id`, `batch_id`, `student_id`, `batch_fees_id`, `student_enrollment_id`, `total_payable`, `total_paid`, `balance`, `status`, `current_batch`, `prev_batch_student_id`, `transfer_fee`, `transfer_date`, `remarks`, `overall_result`, `dropout`, `result_published_status`, `welcome_email`, `created_at`, `updated_at`) VALUES
	(33, 11, 21, 20, 'HRM14004', 44000.00, 44000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-07-12 08:21:31', '2022-01-18 07:51:56'),
	(34, 12, 28, 25, '', 20000.00, 15000.00, 5000.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-07-14 15:28:50', '2021-08-16 15:51:51'),
	(35, 5, 21, 12, '', 52000.00, 32000.00, 20000.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-08-17 20:00:50', '2021-09-02 17:10:23'),
	(36, 12, 21, 24, '', 20000.00, 20000.00, 0.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-08-18 10:57:17', '2021-09-27 03:59:09'),
	(40, 11, 39, 24, 'HRM14004', 20000.00, 20000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-13 14:35:43', '2021-09-19 06:39:23'),
	(45, 10, 42, 18, 'HRM13002', 55000.00, 55000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-15 01:26:52', '2021-09-15 01:54:04'),
	(46, 11, 42, 20, 'HRM14002', 44000.00, 44000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-15 02:01:36', '2021-09-15 02:02:24'),
	(47, 11, 38, 20, 'HRM14003', 44000.00, 44000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-15 02:04:22', '2022-01-18 07:53:41'),
	(49, 12, 42, 24, 'GDF01001', 20000.00, 20000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-15 02:52:27', '2021-09-15 03:07:06'),
	(50, 12, 38, 24, 'GDF01002', 20000.00, 0.00, 20000.00, 'Inactive', '', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-18 06:34:20', '2022-03-04 19:54:44'),
	(51, 10, 38, 18, 'HRM13001', 55000.00, 0.00, 55000.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-23 03:43:57', '2021-09-23 04:55:41'),
	(52, 15, 38, 29, 'HRM14001', 80000.00, 50000.00, 30000.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-23 04:20:37', '2022-01-18 07:28:56'),
	(53, 12, 39, 25, 'GDF01003', 22000.00, 0.00, 22000.00, 'Inactive', 'Transfered', NULL, NULL, '2022-03-05', NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-23 04:37:23', '2022-03-04 21:50:54'),
	(54, 13, 38, 26, '', 500000.00, 0.00, 500000.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-25 06:58:17', '2021-09-25 06:58:17'),
	(55, 15, 40, 29, '', 80000.00, 0.00, 80000.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-27 00:27:21', '2021-09-27 00:27:21'),
	(56, 15, 39, 29, 'HRM14002', 80000.00, 0.00, 80000.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-27 00:31:04', '2021-09-27 00:31:04'),
	(57, 15, 37, 29, 'HRM14004', 80000.00, 50000.00, 30000.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-09-27 00:33:00', '2022-02-17 19:13:31'),
	(64, 16, 39, 30, 'GDF046005', 60000.00, 60000.00, 0.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-10-17 03:52:13', '2021-10-17 03:53:47'),
	(65, 12, 48, 24, '', 20000.00, 0.00, 20000.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-11-25 06:54:45', '2021-11-25 06:54:45'),
	(66, 12, 51, 24, '', 20000.00, 0.00, 20000.00, 'Inactive', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2021-12-20 08:43:17', '2021-12-20 08:43:17'),
	(67, 17, 55, 31, 'HRMTest Batch1001', 40000.00, 40000.00, 0.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2022-01-19 02:42:10', '2022-02-25 06:11:07'),
	(77, 12, 32, 25, 'GDF01004', 22000.00, 0.00, 22000.00, 'Inactive', 'Transfered', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2022-03-04 05:55:39', '2022-03-04 20:12:50'),
	(78, 12, 49, 24, 'GDF01005', 20000.00, 0.00, 20000.00, 'Active', 'Yes', NULL, NULL, NULL, NULL, NULL, 'No', 'Not-published', 'Not-sent', '2022-03-04 06:03:25', '2022-03-04 06:03:25'),
	(84, 16, 32, 25, 'GDF046006', 22111.00, 0.00, 22111.00, 'Active', 'Yes', 77, 111, '2022-03-05', NULL, NULL, 'No', 'Not-published', 'Not-sent', '2022-03-04 20:12:50', '2022-03-04 20:12:50'),
	(91, 13, 39, 25, 'GDF045001', 22005.00, 0.00, 22005.00, 'Active', 'Yes', 53, 5, '2022-03-05', 'test', NULL, 'No', 'Not-published', 'Not-sent', '2022-03-04 21:50:54', '2022-03-04 21:50:54');
/*!40000 ALTER TABLE `batch_students` ENABLE KEYS */;

-- Dumping structure for table abpdb.batch_student_units
CREATE TABLE IF NOT EXISTS `batch_student_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `batch_student_id` bigint(20) unsigned NOT NULL,
  `unit_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` bigint(20) DEFAULT NULL,
  `score` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_student_units: ~4 rows (approximately)
/*!40000 ALTER TABLE `batch_student_units` DISABLE KEYS */;
INSERT INTO `batch_student_units` (`id`, `batch_student_id`, `unit_id`, `result`, `score`, `remarks`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
	(5, 84, '23', NULL, '', NULL, 1, 'Active', '2022-03-04 05:55:39', '2022-03-04 20:12:50'),
	(6, 84, '24', NULL, '', NULL, 1, 'Active', '2022-03-04 05:55:39', '2022-03-04 20:12:50'),
	(7, 78, '23', NULL, '', NULL, 1, 'Active', '2022-03-04 06:03:25', '2022-03-04 06:03:25'),
	(8, 78, '24', NULL, '', NULL, 1, 'Active', '2022-03-04 06:03:25', '2022-03-04 06:03:25');
/*!40000 ALTER TABLE `batch_student_units` ENABLE KEYS */;

-- Dumping structure for table abpdb.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trainers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accredited_by` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `awarder_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `programme_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester_no` tinyint(2) DEFAULT 1,
  `semester_details` text COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `assessment` text COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `grading_system` text COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `course_profile_image` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT '',
  `requirements` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT '',
  `experience_required` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT '',
  `youtube_video_link` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT '',
  `tqt` int(11) NOT NULL,
  `glh` int(11) NOT NULL,
  `total_credit_hour` int(11) NOT NULL,
  `registration_fees` double(8,2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `study_mode` enum('Online','Campus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Online',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualifications_level_id_foreign` (`level_id`),
  CONSTRAINT `qualifications_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.courses: ~5 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` (`id`, `level_id`, `code`, `title`, `short_name`, `short_name_id`, `trainers`, `accredited_by`, `awarder_by`, `programme_duration`, `course_cover_image`, `semester_no`, `semester_details`, `assessment`, `grading_system`, `course_profile_image`, `objective`, `requirements`, `experience_required`, `youtube_video_link`, `tqt`, `glh`, `total_credit_hour`, `registration_fees`, `status`, `study_mode`, `created_at`, `updated_at`) VALUES
	(9, 1, 'Q2021001', 'Post Graduate on Human Resource Management', 'PGDHRM', 'HRM', 'Trainers HH', '<p>SEMESTER 1: Unit 1- 5&nbsp;</p><p>SEMESTER 2: Unit 6 – 9&nbsp;</p>', NULL, '8-12 Months', NULL, 1, '<p>SEMESTER 1: Unit 1- 5&nbsp;</p><p>SEMESTER 2: Unit 6 – 9&nbsp;</p>', '<p>Learning outcomes are assessed by a combination of formative (course work) and summative (final) assessment in the following manner.&nbsp;</p><figure class="table"><table><tbody><tr><td>&nbsp;<i><strong>Formative Assessment (40%)</strong></i></td><td><i><strong>Summative Assessment (60%)</strong></i></td></tr><tr><td><ul><li>assignments</li><li>case studies</li><li>integrated work activities</li><li>group and individual presentations</li><li>reports</li></ul></td><td><ul><li>time constrained tests</li><li>examinations</li></ul></td></tr></tbody></table></figure>', '<p>Your performance in each module will be assigned one of four grades:</p><p><strong>Distinction</strong>: 80% or more – indicating outstanding performance.</p><p>&nbsp;</p><p><strong>Merit</strong>: 65-79% – indicating a high degree of competence in the subject.</p><p>&nbsp;</p><p><strong>Pass</strong>: 50-64% – an acceptable level of performance in which all learning outcomes have been achieved.</p><p>&nbsp;</p><p><strong>Referred</strong>: 49% or less – a failure to achieve all learning outcomes. The module can be retaken provided that the attempt is made within the eligibility period. You will be referred in a module if your mark is less than 50%.</p>', '1627796494.png', '<p>The objective of this qualification is to support professional development and practices in Islamic finance environment, whether an individual intends to develop career or aspire to enter this sector. It is applicable to roles in areas such as finance, banking, portfolio management, corporate finance, treasury, and consultancy. It provides a thorough grounding in areas such as Islamic economics, Islamic financial system, financial decision-making in IFIs, financial reporting and governance of IFIs.</p>', '<p>Admission is open to individuals with an undergraduate degree from a recognised institution.</p><p>Those who do not hold a degree, but have exceptional professional experience in the relevant area are eligible to apply and will be considered on a case-by-case basis.</p>', '<p>One year of working experience in Finance and/or Banking industry is preferred but NOT mandatory.</p>', 'https://www.youtube.com/watch?v=Wmbt8a9RPrE', 600, 70, 30, 500.00, 'Active', 'Online', '2021-06-22 13:19:12', '2021-09-15 00:43:46'),
	(10, 1, 'Q2021002', 'Post Graduate on  Finance', 'PGDF', 'GDF', 'Trainers HH', '<p>1</p>', NULL, NULL, NULL, 1, '<p>1</p>', '<p>1</p>', '<p>1</p>', NULL, '<p>The objective of this qualification is to support professional development and practices in Islamic finance environment, whether an individual intends to develop career or aspire to enter this sector. It is applicable to roles in areas such as finance, banking, portfolio management, corporate finance, treasury, and consultancy. It provides a thorough grounding in areas such as Islamic economics, Islamic financial system, financial decision-making in IFIs, financial reporting and governance of IFIs.</p>', NULL, NULL, 'https://www.youtube.com/watch?v=Wmbt8a9RPrE', 340, 70, 30, 20.00, 'Active', 'Online', '2021-07-05 12:53:43', '2021-07-30 13:31:48'),
	(12, 12, 'Q2021003', 'Asssasasa as asdas dsdasd asd d HH', 'ASD', '', 'Trainers HH', '<p>Accredited HH</p>', 'Awarder HH', '4-12 Months HH', NULL, 4, '<p>Semester Details HH</p>', '<p>Assesment HH</p>', '<p>Grading System HH</p>', '1625568790.jpg', '<p>HHHHHHHHHHHHHHHHHHHH DD</p>', '<p>Requirements HH</p>', '<p>Experience Required HH</p>', 'https://www.youtube.com/watch?v=Wmbt8a9RPrE', 340, 70, 70, 20.00, 'Active', 'Campus', '2021-07-06 09:48:11', '2021-07-07 12:43:33'),
	(13, 1, '0002', 'MOMIT TEST COURSE', 'MMM', 'MMM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>SOmething details</p>', NULL, NULL, NULL, 200, 100, 20, 1000.00, 'Active', 'Online', '2021-09-20 13:22:09', '2021-09-20 13:22:09'),
	(14, 1, '00001', 'Test another course', 'NNN', 'NNN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>etao</p>', NULL, NULL, NULL, 200, 100, 20, 100.00, 'Active', 'Online', '2021-09-20 13:28:02', '2021-09-20 13:28:02');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;

-- Dumping structure for table abpdb.courses_units
CREATE TABLE IF NOT EXISTS `courses_units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `type` enum('Optional','Mandatory') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Optional',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_units_unit_id_foreign` (`unit_id`),
  KEY `qualification_units_qualification_id_foreign` (`course_id`) USING BTREE,
  CONSTRAINT `FK_courses_units_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `qualification_units_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.courses_units: ~6 rows (approximately)
/*!40000 ALTER TABLE `courses_units` DISABLE KEYS */;
INSERT INTO `courses_units` (`id`, `unit_id`, `course_id`, `status`, `type`, `created_at`, `updated_at`) VALUES
	(75, 23, 12, 'Active', 'Optional', '2021-07-07 12:43:33', '2021-07-07 12:43:33'),
	(76, 24, 12, 'Active', 'Optional', '2021-07-07 12:43:33', '2021-07-07 12:43:33'),
	(81, 23, 10, 'Active', 'Optional', '2021-07-30 13:31:48', '2021-07-30 13:31:48'),
	(82, 24, 10, 'Active', 'Optional', '2021-07-30 13:31:48', '2021-07-30 13:31:48'),
	(85, 23, 9, 'Active', 'Optional', '2021-09-15 00:43:46', '2021-09-15 00:43:46'),
	(86, 24, 9, 'Active', 'Optional', '2021-09-15 00:43:46', '2021-09-15 00:43:46');
/*!40000 ALTER TABLE `courses_units` ENABLE KEYS */;

-- Dumping structure for table abpdb.expenses
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `expense_head_id` bigint(20) NOT NULL,
  `expense_date` date NOT NULL DEFAULT curdate(),
  `amount` double(8,2) NOT NULL,
  `details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Due','Partial','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Due',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.expenses: ~5 rows (approximately)
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` (`id`, `expense_head_id`, `expense_date`, `amount`, `details`, `attachment`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, '2021-08-26', 1500.00, 'Electric bill for the month of June 2021', 'assets/images/expense/1625575679.png', 'Paid', 'Active', '2021-07-06 12:47:59', '2021-07-06 12:47:59'),
	(2, 2, '2021-08-26', 650.00, 'sdasdsd', 'green.png1625585896.png', 'Paid', 'Active', '2021-07-06 15:38:16', '2021-07-06 15:38:16'),
	(6, 3, '2021-08-26', 102.00, 'ss', '1625728575.jpg', 'Paid', 'Active', '2021-07-06 15:48:06', '2021-07-08 07:16:15'),
	(7, 1, '2021-08-26', 5000.00, 'month of july', NULL, 'Paid', 'Active', '2021-07-15 14:21:57', '2021-07-15 14:21:57'),
	(8, 5, '2021-08-26', 150.00, 'sddfasdasd', NULL, 'Due', 'Active', '2021-08-04 05:32:07', '2021-08-04 05:32:07'),
	(9, 2, '2021-08-26', 250.00, 'sdfsdf', NULL, 'Paid', 'Active', '2021-08-26 00:52:43', '2021-08-26 00:52:43'),
	(10, 2, '2021-08-25', 8000.00, 'ljoklhky k urf', NULL, 'Due', 'Active', '2021-08-26 01:08:03', '2021-08-26 01:14:38');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;

-- Dumping structure for table abpdb.expense_heads
CREATE TABLE IF NOT EXISTS `expense_heads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `expense_head_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_category_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.expense_heads: ~5 rows (approximately)
/*!40000 ALTER TABLE `expense_heads` DISABLE KEYS */;
INSERT INTO `expense_heads` (`id`, `expense_head_name`, `expense_category_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Monthly Electric bill', 2, 'Active', '2021-07-06 12:41:47', '2021-07-06 12:58:21'),
	(2, 'Monthly Gas Bill', 3, 'Active', '2021-07-06 12:43:20', '2021-07-06 12:58:18'),
	(3, 'Electric repair bill', 2, 'Active', '2021-07-06 12:43:43', '2021-07-06 12:58:15'),
	(4, 'Soyabin Oil', 6, 'Active', '2021-08-04 05:28:58', '2021-08-04 05:28:58'),
	(5, 'Mastered Oil', 6, 'Active', '2021-08-04 05:29:17', '2021-08-04 05:29:17'),
	(6, 'Rice', 4, 'Active', '2021-08-04 05:30:36', '2021-08-04 05:30:36'),
	(7, 'Monthly gass bill', 3, 'Active', '2021-08-26 00:27:12', '2021-08-26 00:27:12'),
	(8, 'Olive oil', 6, 'Active', '2021-09-27 00:44:11', '2021-09-27 00:44:32');
/*!40000 ALTER TABLE `expense_heads` ENABLE KEYS */;

-- Dumping structure for table abpdb.expnese_categories
CREATE TABLE IF NOT EXISTS `expnese_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.expnese_categories: ~5 rows (approximately)
/*!40000 ALTER TABLE `expnese_categories` DISABLE KEYS */;
INSERT INTO `expnese_categories` (`id`, `category_name`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'BILL', NULL, 'Active', NULL, NULL),
	(2, 'Electric Bill Expense', 1, 'Active', '2021-07-06 12:32:51', '2021-09-12 13:50:31'),
	(3, 'Gas Bill', 1, 'Active', '2021-07-06 12:33:07', '2021-07-06 12:54:52'),
	(4, 'Grocery', NULL, 'Active', '2021-08-04 05:26:29', '2021-08-04 05:26:29'),
	(6, 'Oil', 4, 'Active', '2021-08-04 05:28:11', '2021-08-04 05:28:11'),
	(7, 'AAAAA', NULL, 'Active', '2021-10-08 10:38:55', '2021-10-08 10:38:55');
/*!40000 ALTER TABLE `expnese_categories` ENABLE KEYS */;

-- Dumping structure for table abpdb.levels
CREATE TABLE IF NOT EXISTS `levels` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table abpdb.levels: ~12 rows (approximately)
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
INSERT INTO `levels` (`id`, `name`) VALUES
	(1, '1'),
	(2, '2'),
	(3, '3'),
	(4, '4'),
	(5, '5'),
	(6, '6'),
	(7, '7'),
	(8, '8'),
	(9, '9'),
	(10, '10'),
	(11, '11'),
	(12, '12');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;

-- Dumping structure for table abpdb.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'value:0 if the menu is itself a parent otherwise anyother parent id',
  `serial_no` int(11) DEFAULT NULL,
  `menu_icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.menus: ~40 rows (approximately)
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`id`, `module_name`, `menu_title`, `menu_url`, `parent_id`, `serial_no`, `menu_icon_class`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'Users', 'Users', '', 0, 5, 'pe-7s-users', 1, NULL, NULL),
	(5, 'Users', 'Admin Users', 'user/admin/admin-user-management?type=Admin', 4, 1, NULL, 1, NULL, NULL),
	(6, 'Users', 'Center Users', 'user/admin/admin-user-management?type=Center', 4, 2, NULL, 1, NULL, NULL),
	(7, 'Cpanel', 'Control Panel', '', 0, 9, 'pe-7s-tools', 1, NULL, NULL),
	(8, 'Settings', 'General Setting', 'settings/general/general-setting', 11, 1, NULL, 1, NULL, NULL),
	(9, 'Cpanel', 'Menus/Moduls', 'cp/module/manage-module', 7, 2, NULL, 1, NULL, NULL),
	(10, 'Cpanel', 'Actions', 'cp/web-action/web-action-management', 7, 3, NULL, 1, NULL, NULL),
	(11, 'Settings', 'Settings', '', 0, 7, 'pe-7s-settings', 1, NULL, NULL),
	(14, 'Settings', 'User Groups', 'settings/admin/admin-group-management', 11, 2, NULL, 1, '2020-04-10 10:58:01', '2020-04-10 10:58:01'),
	(15, 'Courses', 'Courses', '', 0, 1, 'pe-7s-notebook', 1, '2021-03-21 06:57:45', '2021-03-21 06:57:45'),
	(17, 'Courses', 'Courses', 'course', 15, 2, NULL, 1, '2021-03-21 07:05:46', '2021-03-21 07:05:46'),
	(18, 'Units', 'Units', 'unit', 15, 4, NULL, 1, '2021-03-21 07:06:31', '2021-03-21 07:06:31'),
	(19, 'Students', 'Students', 'student', 0, 2, 'pe-7s-add-user', 1, '2021-03-23 18:40:06', '2021-03-23 18:40:06'),
	(22, 'Dashboard', 'Dashboard', '', 0, NULL, NULL, 1, '2021-04-10 15:52:11', '2021-04-10 15:52:11'),
	(28, 'Expenses', 'Expenses', '', 0, 4, 'pe-7s-cash', 1, '2021-06-12 07:35:56', '2021-06-12 07:35:56'),
	(29, 'Expense Category', 'Expense Category', 'expense/expense-category', 28, 3, NULL, 1, '2021-06-12 07:42:11', '2021-06-12 07:43:50'),
	(33, 'Expense Head', 'Expense Head', 'expense/expense-head', 28, 2, NULL, 1, '2021-07-06 12:20:14', '2021-07-06 12:20:14'),
	(34, 'Expenses', 'Expenses', 'expense/expense', 28, 1, NULL, 1, '2021-07-06 12:20:27', '2021-07-06 12:20:27'),
	(35, 'Batches', 'Batches', 'batch', 15, 1, NULL, 1, '2021-07-07 12:53:58', '2021-07-07 12:53:58'),
	(36, 'Payments', 'Payments', '', 0, 3, 'pe-7s-cash', 1, '2021-07-12 07:30:58', '2021-07-12 07:30:58'),
	(37, 'Payment Collections', 'Payment Collections', 'payment', 36, 1, NULL, 1, '2021-07-12 07:33:52', '2021-07-12 07:33:52'),
	(38, 'Payment Schedules', 'Payment Schedules', 'payment-schedule', 36, 2, NULL, 1, '2021-07-13 11:39:43', '2021-07-13 11:39:43'),
	(39, 'Revise Requests', 'Revised Requests', 'revise-payment', 36, 3, NULL, 1, '2021-08-24 07:50:19', '2021-08-24 07:50:19'),
	(40, 'Notifications', 'Notifications', '', 0, 6, 'lnr-envelope', 1, '2021-08-24 13:47:34', '2021-08-24 13:47:34'),
	(41, 'SMS', 'Bulk SMS', 'sms/send', 40, 1, NULL, 1, '2021-08-24 13:48:55', '2021-08-24 14:08:27'),
	(42, 'Email', 'Bulk Email', 'email/send', 40, 2, NULL, 1, '2021-08-24 13:49:19', '2021-08-24 13:49:19'),
	(43, 'Notifications', 'Notifications', 'notifications', 40, 3, NULL, 1, '2021-08-24 13:49:45', '2021-08-24 13:49:45'),
	(44, 'Reports', 'Reports', '', 0, 8, 'pe-7s-file', 1, '2021-08-31 07:28:40', '2021-08-31 07:28:40'),
	(45, 'Course Status', 'Course Status', 'course-report', 44, 1, NULL, 1, '2021-08-31 07:31:04', '2021-08-31 07:31:04'),
	(46, 'Batch Status', 'Batch Status', 'batch-report', 44, 2, NULL, 1, '2021-08-31 07:32:22', '2021-08-31 07:32:22'),
	(47, 'Student Status', 'Students Status', 'student-report', 44, 3, NULL, 1, '2021-08-31 07:32:47', '2021-08-31 07:32:47'),
	(48, 'Payment schedule', 'Payments schedule', 'payment-schedule-report', 44, 4, NULL, 1, '2021-08-31 07:33:10', '2021-08-31 07:33:10'),
	(49, 'Payment Collection', 'Payment Collection', 'payment-collection-report', 44, 5, NULL, 1, '2021-08-31 07:34:12', '2021-08-31 07:34:12'),
	(50, 'Payment Schedule Vs Collection', 'Payment Schedule Vs Collection', 'schedule-collection-report', 44, 6, NULL, 1, '2021-08-31 07:34:54', '2021-08-31 07:34:54'),
	(51, 'Expenses Report', 'Expenses Report', 'expense-report', 44, 7, NULL, 1, '2021-08-31 07:35:20', '2021-08-31 07:35:20'),
	(52, 'Expense Vs Income', 'Expense Vs Income', 'expense-income', 44, 8, NULL, 1, '2021-08-31 07:35:42', '2021-08-31 07:35:42'),
	(53, 'Financial Report', 'Financial Report', 'financial-report', 44, 9, NULL, 1, '2021-10-01 13:12:13', '2021-10-01 13:12:13'),
	(54, 'Books', 'Books', 'batch-book', 15, 3, NULL, 1, '2022-02-18 05:16:34', '2022-02-18 05:16:34'),
	(55, 'Template', 'Template', 'template', 40, 3, NULL, 1, '2022-02-25 02:02:05', '2022-02-25 02:02:05'),
	(56, 'Batch Transfer', 'Batch Transfer', 'batch-transfer', 15, NULL, NULL, 1, '2022-03-04 09:06:24', '2022-03-04 09:06:24');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Dumping structure for table abpdb.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.migrations: ~9 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(8, '2016_06_01_000001_create_oauth_auth_codes_table', 8),
	(9, '2016_06_01_000002_create_oauth_access_tokens_table', 8),
	(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 8),
	(11, '2016_06_01_000004_create_oauth_clients_table', 8),
	(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 8),
	(29, '2021_06_12_074741_create_expnese_categories_table', 9),
	(31, '2021_11_25_054059_add_designation_with_student_table', 10),
	(35, '2021_11_29_051333_add_otp_column_with_user_table', 11),
	(38, '2022_01_18_075606_add_draft_column_with_batch_table', 12),
	(40, '2022_01_27_100928_add_dropout_column_with_batch_students_table', 13),
	(41, '2022_02_18_045734_create_batch_books_table', 14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table abpdb.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.notifications: ~157 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('00332164-170e-451b-afcf-129978b07a82', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":38,"Message":"Maariz Hasan has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-23 04:20:37', '2021-09-23 04:20:37'),
	('0463d393-b328-4c74-9907-818171ad7320', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":47,"Message":"New student registration done. MOMIT TEST"}', NULL, '2021-11-25 06:37:56', '2021-11-25 06:37:56'),
	('05f89e17-12df-49d3-adc0-49c698b47a2c', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Message":"Maariz Hasan has made a payment of TK 20000 OKKK","Id":"66"}', NULL, '2021-09-08 06:51:26', '2021-09-08 06:51:26'),
	('061ae2e1-3626-4b01-becc-2adf6506978f', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":40,"Message":"New student registration done. nnnn"}', NULL, '2021-09-14 12:29:11', '2021-09-14 12:29:11'),
	('07dd6b21-b461-41ab-b8d9-493e254c16d8', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 36, '{"Type":"Courses","Id":39,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 02:04:22', '2021-09-15 02:04:22'),
	('0921f7fc-bac7-45d8-a69b-f4d247fc4cbc', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":80,"Message":"Maariz Hasan has made a payment of TK 30000"}', NULL, '2021-09-23 05:16:49', '2021-09-23 05:16:49'),
	('09fa3ce9-20c2-4540-82dd-32869b1311b5', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":48,"Message":"MOMIT TEST NEW 2 has enrolled in  Post Graduate on  Finance"}', NULL, '2021-11-25 06:54:45', '2021-11-25 06:54:45'),
	('0af64a02-3606-4b86-bfb4-7a12b8194edf', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 23, '{"Type":"Success","Message":" You have a due payment of TK 44000. Please make the payment."}', '2021-09-13 05:18:00', '2021-09-03 13:39:45', '2021-09-13 05:18:00'),
	('0ba5e597-f9ad-4fee-90de-9f4df8b662eb', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":21,"Message":"Muniff enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:09:40', '2021-09-13 12:09:40'),
	('0f635415-dfe2-47ba-b9e4-9cd18117b4ae', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Message":"Maariz Hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-08 01:55:51', '2021-09-08 01:55:51'),
	('0face6f8-cd48-408a-bd6c-1600538ab21f', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":74,"Message":"MMM has made a payment of TK 44000"}', NULL, '2021-09-15 02:05:37', '2021-09-15 02:05:37'),
	('12c93482-75c2-4415-ba55-057e76e5deb8', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Id":15,"Message":"Enrollment has been successful in  Post Graduate on Human Resource Management"}', NULL, '2021-09-23 04:20:37', '2021-09-23 04:20:37'),
	('12e5b1bb-94a7-4f4e-b8c7-95505791a64b', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 36, '{"Type":"Courses","Id":15,"Message":"Enrollment has been successful in  Post Graduate on Human Resource Management"}', NULL, '2021-09-27 00:31:11', '2021-09-27 00:31:11'),
	('130fce39-1b9f-49cc-b812-8f23b24e243c', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Message":"Payment has been successfull of TK 20000","Id":"64"}', '2021-09-09 03:58:41', '2021-09-08 06:51:26', '2021-09-09 03:58:41'),
	('13c5822b-669c-4f25-b8a0-37a6240df4a1', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":32,"Message":"Litu has enrolled in  Post Graduate on  Finance"}', NULL, '2021-10-07 13:51:51', '2021-10-07 13:51:51'),
	('15616a48-6bb3-41a9-bde3-e1a90f5a2a45', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":51,"Message":"New student registration done. Test Meeting"}', NULL, '2021-12-20 08:40:51', '2021-12-20 08:40:51'),
	('15d11673-f78c-4120-9b76-6ad6e7754911', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 52, '{"Type":"Courses","Id":17,"Message":"Enrollment has been successful in  Post Graduate on Human Resource Management"}', NULL, '2022-01-19 02:42:10', '2022-01-19 02:42:10'),
	('1f47d443-941e-47ed-9c6b-0e5a9708d37e', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":78,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-05 08:27:27', '2022-03-05 08:27:27'),
	('1fc5fd4b-fd07-4198-b775-1d3c62234e3f', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 37, '{"Type":"Courses","Id":15,"Message":"Enrollment has been successful in  Post Graduate on Human Resource Management"}', NULL, '2021-09-27 00:27:22', '2021-09-27 00:27:22'),
	('2451ef47-8c78-4c06-97c1-5ec003402e8c', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":49,"Message":"New student registration done. MMounota"}', NULL, '2021-11-29 01:14:29', '2021-11-29 01:14:29'),
	('2877a8dd-c403-4270-839d-ef4160f74ad7', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 39, '{"Type":"Payments","Id":71,"Message":"Payment has been successfull of TK 55000"}', NULL, '2021-09-15 01:15:28', '2021-09-15 01:15:28'),
	('2933ff6e-5516-4d47-94c2-4e9d21e5ec74', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Message":"Maariz Hasan has made a payment of TK 10000"}', NULL, '2021-09-08 02:01:49', '2021-09-08 02:01:49'),
	('2f9f2c00-5653-4ac7-bdfb-57a757cde43a', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":73,"Message":"ggg hasan has made a payment of TK 44000"}', NULL, '2021-09-15 02:02:24', '2021-09-15 02:02:24'),
	('310b0fba-abac-4b35-aa9a-2d57657dd401', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 45, '{"Type":"Courses","Id":12,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-11-25 06:54:45', '2021-11-25 06:54:45'),
	('3537d731-3146-4726-8db5-03423037e4b7', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":76,"Message":"ggg hasan has made a payment of TK 20000"}', NULL, '2021-09-15 03:07:06', '2021-09-15 03:07:06'),
	('35d748e6-67f6-435d-9ac1-98755ec193e6', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:12:29', '2021-09-15 01:12:29'),
	('38ecfbcf-e6fc-47fb-9763-1d0408693ca9', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 02:01:36', '2021-09-15 02:01:36'),
	('3e902fa6-4401-45a3-9bca-a5cdb60067e1', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 23, '{"Type":"Success","Message":" You have a due payment of TK 44000. Please make the payment."}', '2021-09-13 05:16:58', '2021-09-03 13:43:07', '2021-09-13 05:16:58'),
	('3eea46d9-09db-4216-b742-8f18c4cf2f7d', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":40,"Message":"New student registration done. nnnn"}', NULL, '2021-09-14 12:29:11', '2021-09-14 12:29:11'),
	('3f1a6d87-2fab-4b5a-9756-f92ed9faf4f6', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 23, '{"Type":"Payments","Id":56,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 18:06:38', '2022-03-02 18:06:38'),
	('3f8a46cf-e2aa-451d-8986-1a11428f1058', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 36, '{"Type":"Payments","Id":83,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 18:21:08', '2022-03-02 18:21:08'),
	('3fd5bcc0-b579-4d24-8f04-301b438d3946', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 34, '{"Type":"Payments","Id":92,"Message":"Payment has been successfull of TK 30000"}', NULL, '2022-02-17 19:13:32', '2022-02-17 19:13:32'),
	('4833be6f-dce3-47cd-be2c-f1d1dec6fc3b', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:07:53', '2021-09-15 01:07:53'),
	('4a002656-38cb-44fe-b1af-34d5215dc3a0', 'App\\Notifications\\studentBookSent', 'App\\Models\\User', 36, '{"Type":"Courses","Id":12,"Message":"Book3 has been sent for the course Post Graduate on  Finance"}', '2022-03-05 08:53:09', '2022-03-05 08:49:23', '2022-03-05 08:53:09'),
	('4b00bed8-bf2e-4350-971e-a3091bedf1ed', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":38,"Message":"Maariz Hasan enrolled in  Post Graduate on  Finance"}', NULL, '2021-09-13 14:35:43', '2021-09-13 14:35:43'),
	('4b8ed98d-84ca-4bf5-8672-bf209eb4687a', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 34, '{"Type":"Courses","Id":15,"Message":"Enrollment has been successful in  Post Graduate on Human Resource Management"}', NULL, '2021-09-27 00:33:12', '2021-09-27 00:33:12'),
	('4bf03d6e-f05c-45c1-9777-7cefdf345692', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":51,"Message":"New student registration done. Test Meeting"}', NULL, '2021-12-20 08:40:51', '2021-12-20 08:40:51'),
	('4e7dbfa9-c92c-4884-95c1-e095f848781a', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":55,"Message":"New student registration done. Test Strudent"}', NULL, '2022-01-19 02:41:57', '2022-01-19 02:41:57'),
	('50999217-312a-4faf-915e-cf6a04918918', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":38,"Message":"Maariz Hasan has enrolled in  Post Graduate on  Finance"}', NULL, '2021-09-25 06:58:18', '2021-09-25 06:58:18'),
	('50a3390b-5d29-4e17-ac6d-548b43b17c40', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":57,"Message":"New student registration done. sdsdsad"}', NULL, '2022-02-27 18:34:41', '2022-02-27 18:34:41'),
	('51be4bfa-5258-48b6-820b-fa80d03f44d2', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Message":"Maariz Hasan has made a payment of TK 10000","Id":"66"}', '2021-09-08 16:10:23', '2021-09-08 02:01:49', '2021-09-08 16:10:23'),
	('51cb41ae-5668-47c5-a4a1-bfb180ad6f39', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Message":"Maariz Hasan enrolled in  Post Graduate on Human Resource Management","Id":"35"}', NULL, '2021-09-08 01:55:51', '2021-09-08 15:48:28'),
	('525dcd82-6ac3-4710-a377-342c20183ede', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":38,"Message":"Maariz Hasan enrolled in  Post Graduate on  Finance"}', NULL, '2021-09-13 14:35:43', '2021-09-13 14:35:43'),
	('54a139db-430d-431a-9279-c7e3ce8385ec', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":92,"Message":"Zikra Hasan has made a payment of TK 30000"}', NULL, '2022-02-17 19:13:32', '2022-02-17 19:13:32'),
	('55522ea3-9702-49b8-9ce9-da3f0ed4e9ad', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":49,"Message":"New student registration done. MMounota"}', NULL, '2021-11-29 01:14:29', '2021-11-29 01:14:29'),
	('56c3d047-bfbf-489f-b4f6-ad26cbf7f447', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":74,"Message":"MMM has made a payment of TK 44000"}', NULL, '2021-09-15 02:05:37', '2021-09-15 02:05:37'),
	('573a5e88-f117-4b90-a9db-a1b356bb7ddf', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":53,"Message":"New student registration done. UUU tt"}', NULL, '2021-12-22 14:28:50', '2021-12-22 14:28:50'),
	('58400032-a392-43c5-8dd9-7a9b3f191ed6', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":93,"Message":"Zikra Hasan has made a payment of TK 20000"}', NULL, '2021-09-27 01:23:00', '2021-09-27 01:23:00'),
	('5c59bdbf-9959-4085-9929-e3add1504c8f', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Id":67,"Message":"Payment has been successfull of TK 20000"}', NULL, '2021-09-19 06:39:24', '2021-09-19 06:39:24'),
	('5d95e5ed-b207-48c8-9908-6f2570bd6d9a', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on  Finance"}', NULL, '2021-09-15 02:52:36', '2021-09-15 02:52:36'),
	('607c8cd2-bd74-41c9-ba33-71456fa51a36', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:12:29', '2021-09-15 01:12:29'),
	('61309a09-09f4-4680-870f-55e6dae85b27', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":101,"Message":"Test Strudent has made a payment of TK 40000"}', NULL, '2022-01-31 09:44:59', '2022-01-31 09:44:59'),
	('61bdde90-f943-4bbd-84bb-c3041b78c361', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 52, '{"Type":"Payments","Id":101,"Message":"Payment has been successfull of TK 40000"}', NULL, '2022-01-31 09:44:59', '2022-01-31 09:44:59'),
	('66287428-51b0-4910-9b8e-f09c77dd6905', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":55,"Message":"New student registration done. Test Strudent"}', NULL, '2022-01-19 02:41:57', '2022-01-19 02:41:57'),
	('6863fa7b-cace-40a7-ac94-d4f23d4a97fd', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":38,"Message":"Maariz Hasan has enrolled in  Post Graduate on  Finance"}', NULL, '2021-09-25 06:58:18', '2021-09-25 06:58:18'),
	('68a1a6e3-64a1-4919-bff0-99ab4b1acb1a', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Message":"New student registration done. Maariz Hasan"}', NULL, '2021-09-08 01:46:16', '2021-09-08 01:46:16'),
	('697fd442-0642-4c3d-b815-ea4d2cba42f9', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":40,"Message":"nnnn has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-27 00:27:22', '2021-09-27 00:27:22'),
	('6a82adc8-b927-47b2-923f-7b668e2665c3', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 00:52:52', '2021-09-15 00:52:52'),
	('6af1d54b-9242-4c49-b1ed-f4e0e3ec60e5', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 23, '{"Type":"Courses","Id":21,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:08:30', '2021-09-13 12:08:30'),
	('6bd762ee-8e91-4750-b3f1-498a56d4b437', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":92,"Message":"Zikra Hasan has made a payment of TK 30000"}', NULL, '2022-02-17 19:13:32', '2022-02-17 19:13:32'),
	('6c9ef3b8-e40d-431b-b9ed-2f1c593fc5af', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 23, '{"Type":"Courses","Id":21,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:04:56', '2021-09-13 12:04:56'),
	('6d8988fc-4409-4ab3-9e13-4e7817b85961', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 02:01:36', '2021-09-15 02:01:36'),
	('6e0fc0c6-c527-4d56-9221-5b2f1fe272eb', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":80,"Message":"Maariz Hasan has made a payment of TK 30000"}', NULL, '2021-09-23 05:16:49', '2021-09-23 05:16:49'),
	('6f5ba27b-09d4-4182-9b2f-39431e90a32b', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 39, '{"Type":"Payments","Id":76,"Message":"Payment has been successfull of TK 20000"}', NULL, '2021-09-15 03:07:06', '2021-09-15 03:07:06'),
	('70692a90-ee0a-4da8-bc9e-8f545445c9fd', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":101,"Message":"Test Strudent has made a payment of TK 40000"}', NULL, '2022-01-31 09:44:59', '2022-01-31 09:44:59'),
	('707da5ab-a4a5-47ea-8dde-dee4a14498e8', 'App\\Notifications\\studentBatchTransfered', 'App\\Models\\User', 36, '{"Type":"Courses","Id":10,"Message":"Batch transfer from 045 to 01  (Post Graduate on  Finance)"}', NULL, '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	('70c68501-3ca4-48d1-9be2-0cd2c135597c', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Id":77,"Message":"Payment has been successfull of TK 20000"}', '2021-09-18 09:36:40', '2021-09-18 06:57:14', '2021-09-18 09:36:40'),
	('72730d8c-c517-4f2e-9bab-c38520cad9b2', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Id":16,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', '2021-12-19 12:25:08', '2021-10-07 13:46:43', '2021-12-19 12:25:08'),
	('75541ba0-c11b-4374-866d-ecb36b5ea469', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 00:52:52', '2021-09-15 00:52:52'),
	('76095375-f7ba-4413-9204-7de3e958d894', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":54,"Message":"New student registration done. SSS UUUU"}', NULL, '2021-12-22 14:33:41', '2021-12-22 14:33:41'),
	('7a4ebb67-8adb-4cb7-b224-d463370a99fb', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 36, '{"Type":"Payments","Id":99,"Message":"Payment has been successfull of TK 60000"}', NULL, '2021-10-17 03:53:29', '2021-10-17 03:53:29'),
	('7bf87ef2-a538-463c-8d1a-f23e1e9d503f', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":55,"Message":"Test Strudent has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2022-01-19 02:42:10', '2022-01-19 02:42:10'),
	('7c397cae-38b9-4fda-aa67-74bcd675f461', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 36, '{"Type":"Payments","Id":74,"Message":"Payment has been successfull of TK 44000"}', NULL, '2021-09-15 02:05:37', '2021-09-15 02:05:37'),
	('7c61f2c6-c771-43ab-815c-2730686280d6', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":77,"Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-18 06:57:14', '2021-09-18 06:57:14'),
	('7f0e58a9-800e-48b8-9329-13816f350ea4', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:06:13', '2021-09-15 01:06:13'),
	('823e0c14-9097-43f7-878c-fde1a3e744d0', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":38,"Message":"Maariz Hasan enrolled in  Post Graduate on  Finance"}', NULL, '2021-09-18 06:34:21', '2021-09-18 06:34:21'),
	('8308e30c-c8c9-4033-9307-0fed18d23d38', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Message":"Payment has been successfull of TK 20000" ,"Id":"65"}', '2021-09-08 16:25:19', '2021-09-08 07:08:05', '2021-09-08 16:25:19'),
	('83373983-725c-4fa4-967f-580c27e6fa0d', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":32,"Message":"Litu has enrolled in  Post Graduate on  Finance"}', NULL, '2021-10-07 13:51:51', '2021-10-07 13:51:51'),
	('83796221-c8b8-4c59-b7c3-851e24e261c1', 'App\\Notifications\\studentBookSent', 'App\\Models\\User', 24, '{"Type":"Courses","Id":12,"Message":"Book1 has been sent for the course Post Graduate on  Finance"}', NULL, '2022-03-03 20:30:19', '2022-03-03 20:30:19'),
	('8459ac57-802d-4182-8125-1a375fa37889', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":72,"Message":"ggg hasan has made a payment of TK 55000"}', NULL, '2021-09-15 01:54:04', '2021-09-15 01:54:04'),
	('86b5172f-3edf-4049-898c-9672c74a91fa', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Message":"Maariz Hasan has made a payment of TK 20000","Id":"65"}', NULL, '2021-09-08 07:08:05', '2021-09-08 15:49:35'),
	('875403db-746a-4ee4-a853-6fb37e3f541b', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":81,"Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-23 04:31:50', '2021-09-23 04:31:50'),
	('88db14b4-afdf-496e-9c92-ce69b86d852d', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Message":"Payment has been successfull of TK 10000","Id":"66"}', '2021-09-09 06:36:24', '2021-09-08 02:01:49', '2021-09-09 06:36:24'),
	('8d4b3538-fd58-4615-bfa3-1ad79341c383', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":21,"Message":"Muniff enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 11:59:04', '2021-09-13 11:59:04'),
	('8d655e44-9f8f-44db-a760-fca347b6f0f1', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":39,"Message":"MMM enrolled in  Post Graduate on Human Resource Management"}', '2021-09-18 06:31:02', '2021-09-15 02:04:22', '2021-09-18 06:31:02'),
	('8f22c9ba-76d0-477b-9c54-5d017ff1f402', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 00:52:52', '2021-09-15 00:52:52'),
	('9104f078-fc2c-4bc8-9c7c-73bed8c68c8d', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":48,"Message":"New student registration done. MOMIT TEST NEW 2"}', NULL, '2021-11-25 06:54:30', '2021-11-25 06:54:30'),
	('911e79f5-9e94-4ca8-acf7-cc9dffbe66b3', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":71,"Message":"ggg hasan has made a payment of TK 55000"}', NULL, '2021-09-15 01:15:28', '2021-09-15 01:15:28'),
	('9296e8ba-2bc5-4ad6-bf63-cb6930aee858', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":72,"Message":"ggg hasan has made a payment of TK 55000"}', NULL, '2021-09-15 01:54:04', '2021-09-15 01:54:04'),
	('94ab7026-5d5f-45cd-ae5a-5bfe8f36db16', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Id":38,"Message":"Enrollment has been successfull in  Post Graduate on  Finance"}', '2021-09-18 09:36:46', '2021-09-13 14:35:43', '2021-09-18 09:36:46'),
	('94df4b15-33a9-442f-a099-63a5f2a58829', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":73,"Message":"ggg hasan has made a payment of TK 44000"}', NULL, '2021-09-15 02:02:24', '2021-09-15 02:02:24'),
	('96bce8fb-35f5-4e9e-affc-03015cda0f08', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":48,"Message":"MOMIT TEST NEW 2 has enrolled in  Post Graduate on  Finance"}', NULL, '2021-11-25 06:54:45', '2021-11-25 06:54:45'),
	('99832592-7960-4291-b20c-bc8357b13904', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:26:52', '2021-09-15 01:26:52'),
	('9c5a5ba4-3c3a-44e5-9f8c-232ac9ccf1ce', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":84,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-05 08:27:38', '2022-03-05 08:27:38'),
	('9f2d0bd9-fdbe-4abb-a97f-4ae4d68590ce', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 34, '{"Type":"Payments","Id":93,"Message":"Payment has been successfull of TK 20000"}', NULL, '2021-09-27 01:23:00', '2021-09-27 01:23:00'),
	('a2f5a648-3dd2-445e-ae3f-2b3de6a93c8d', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":21,"Message":"Muniff enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 11:59:04', '2021-09-13 11:59:04'),
	('a52e6ac3-e6fe-44f1-9d85-8f577dab518a', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 46, '{"Type":"Courses","Id":12,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2022-03-04 06:03:39', '2022-03-04 06:03:39'),
	('a6701a22-145c-4fa7-976d-a9f279713097', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 23, '{"Type":"Payments","Id":56,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 18:05:15', '2022-03-02 18:05:15'),
	('a69ff148-f673-48ab-ae23-a5e38fce4e20', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Id":13,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-09-25 06:58:18', '2021-09-25 06:58:18'),
	('a7c9b878-b24c-4e52-8b38-9790beb5124d', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":38,"Message":"Maariz Hasan has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-23 03:43:58', '2021-09-23 03:43:58'),
	('a8a2ecf3-ad6c-4e4c-880e-a341e9a6d333', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":79,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 17:59:52', '2022-03-02 17:59:52'),
	('a97b133f-5369-4b91-bca9-3cadf319e544', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":48,"Message":"New student registration done. MOMIT TEST NEW 2"}', NULL, '2021-11-25 06:54:30', '2021-11-25 06:54:30'),
	('adbaf641-f7f2-4971-956a-40d412c70399', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":99,"Message":"MMM has made a payment of TK 60000"}', NULL, '2021-10-17 03:53:29', '2021-10-17 03:53:29'),
	('af28c10c-d072-4f2b-be4e-6e9ed2936466', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":99,"Message":"MMM has made a payment of TK 60000"}', NULL, '2021-10-17 03:53:29', '2021-10-17 03:53:29'),
	('af7c7334-616e-4e3d-a8be-445679d46883', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 36, '{"Type":"Courses","Id":16,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-10-17 03:52:22', '2021-10-17 03:52:22'),
	('b0d2180e-59f7-4861-b1fa-3f8367d2c8aa', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":40,"Message":"New student registration done. nnnn"}', NULL, '2021-09-14 12:15:22', '2021-09-14 12:15:22'),
	('b125a999-ff43-437f-9a26-d56e7fb3f963', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":77,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 17:59:42', '2022-03-02 17:59:42'),
	('b15338dd-c8a7-4588-9378-2bf384cd13d3', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":77,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-05 08:27:04', '2022-03-05 08:27:04'),
	('b2acfedc-a9d4-4527-8ed8-a78f4ac133f2', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 39, '{"Type":"Payments","Id":72,"Message":"Payment has been successfull of TK 55000"}', NULL, '2021-09-15 01:54:04', '2021-09-15 01:54:04'),
	('b2d7447b-880a-4f5f-b5e7-914c0cb30c1b', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:12:29', '2021-09-15 01:12:29'),
	('b358104c-ca61-4a47-b728-9daf3ce903c5', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 28, '{"Type":"Courses","Id":16,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-10-07 13:51:51', '2021-10-07 13:51:51'),
	('b4455f89-05c6-4d21-ab7a-d6c8c3497d5c', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":57,"Message":"New student registration done. sdsdsad"}', NULL, '2022-02-27 18:34:41', '2022-02-27 18:34:41'),
	('b46e2fee-be43-430b-9140-daa56ba1bac0', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 36, '{"Type":"Courses","Id":16,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-10-07 13:41:10', '2021-10-07 13:41:10'),
	('b4a4cc55-4054-492f-8fe2-2232dbb17054', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":67,"Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-19 06:39:24', '2021-09-19 06:39:24'),
	('b8e00a59-fc5a-4af2-971b-d4449a23da4a', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":21,"Message":"Muniff enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:04:56', '2021-09-13 12:04:56'),
	('b98749d2-c220-4fb9-b7e6-f80c2111bf2c', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":93,"Message":"Zikra Hasan has made a payment of TK 20000"}', NULL, '2021-09-27 01:23:00', '2021-09-27 01:23:00'),
	('b9f7039d-4178-4879-8d28-b9ac8f6bbc15', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Id":80,"Message":"Payment has been successfull of TK 30000"}', NULL, '2021-09-23 05:16:49', '2021-09-23 05:16:49'),
	('badee61e-09f0-4927-b56d-1364c681bbe0', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 23, '{"Type":"Payments","Id":56,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 17:59:36', '2022-03-02 17:59:36'),
	('bbf0dc8f-830e-41a4-adb8-f826c1a7782c', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":52,"Message":"New student registration done. 2nd test"}', NULL, '2021-12-20 09:03:21', '2021-12-20 09:03:21'),
	('bf4cdb19-26fa-44ee-bf76-8bb414d0d7b0', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-08 07:08:05', '2021-09-08 07:08:05'),
	('c26b096e-8b26-4e86-b125-e9caba473ff8', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":81,"Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-23 04:31:50', '2021-09-23 04:31:50'),
	('c3b32c5e-6d99-4823-8649-5d31a00b1b39', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Message":"New student registration done. Maariz Hasan","Id":"35"}', NULL, '2021-09-08 01:46:16', '2021-09-08 15:41:28'),
	('c44f33e3-29f4-4394-936f-62d8932c0d6b', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 28, '{"Type":"Courses","Id":12,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2022-03-04 05:55:47', '2022-03-04 05:55:47'),
	('c513b5e5-fbe6-4ef4-bfbc-a2b069fd6cda', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":40,"Message":"New student registration done. nnnn"}', NULL, '2021-09-14 12:15:22', '2021-09-14 12:15:22'),
	('c55d3413-89ac-4bca-86b9-8122a5a23ce7', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":16,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-10-07 13:47:26', '2021-10-07 13:47:26'),
	('c5e3b030-7e82-4a26-9662-936f0add1326', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":21,"Message":"Muniff enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:04:56', '2021-09-13 12:04:56'),
	('c6a6afe2-4fe7-4b96-80b4-fee731f2eec8', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":54,"Message":"New student registration done. SSS UUUU"}', NULL, '2021-12-22 14:33:41', '2021-12-22 14:33:41'),
	('c886e242-03b2-4b7c-bb94-bce77e1d87bb', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Id":12,"Message":"Enrollment has been successfull in  Post Graduate on  Finance"}', '2021-09-18 09:35:38', '2021-09-18 06:34:21', '2021-09-18 09:35:38'),
	('cc2b8088-5205-4606-b374-47aaf7515c6b', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 36, '{"Type":"Payments","Id":83,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 18:20:03', '2022-03-02 18:20:03'),
	('ccab6d0c-9fb5-4f27-b7ba-3ae9b8f45274', 'App\\Notifications\\studentBookSent', 'App\\Models\\User', 24, '{"Type":"Courses","Id":12,"Message":"Book1 has been sent for the course Post Graduate on  Finance"}', '2022-03-03 20:45:49', '2022-03-03 20:34:29', '2022-03-03 20:45:49'),
	('ccf07e12-3431-4c4a-b443-59c05b34f766', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":38,"Message":"Maariz Hasan has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-23 03:43:58', '2021-09-23 03:43:58'),
	('ce62b2a5-3b26-4a7f-b775-22547e7422b3', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":52,"Message":"New student registration done. 2nd test"}', NULL, '2021-12-20 09:03:21', '2021-12-20 09:03:21'),
	('cfb1e548-a6bf-4cd7-ab3a-3afbad504898', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 23, '{"Type":"Courses","Id":21,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:09:40', '2021-09-13 12:09:40'),
	('d0aba5ea-6ab0-426f-bb29-4fea13b0ae92', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":38,"Message":"Maariz Hasan has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-23 04:20:37', '2021-09-23 04:20:37'),
	('d261d3e1-eaaa-46d5-8d93-c4f378b761e4', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 36, '{"Type":"Courses","Id":12,"Message":"Enrollment has been successful in  Post Graduate on  Finance"}', NULL, '2021-09-23 04:37:28', '2021-09-23 04:37:28'),
	('d2b38559-c2d2-4eed-935b-8426888d414e', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":47,"Message":"New student registration done. MOMIT TEST"}', NULL, '2021-11-25 06:37:56', '2021-11-25 06:37:56'),
	('d85ba3a7-b2d3-4f75-888d-51dec8dcab7e', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":40,"Message":"nnnn has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-27 00:27:22', '2021-09-27 00:27:22'),
	('d8ebfa1d-5659-41b1-b203-7b8d459499ff', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":21,"Message":"Muniff enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-13 12:09:40', '2021-09-13 12:09:40'),
	('d9d0dd02-4006-4f5d-8f4b-0f70d4828b94', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management","Id":"35"}', '2021-09-08 16:27:12', '2021-09-08 01:55:51', '2021-09-08 16:27:12'),
	('dea32fec-9361-4064-ae86-08371ca4b43c', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":84,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 17:59:56', '2022-03-02 17:59:56'),
	('e5247bd2-f667-4cf5-9e14-e38f28bd2ac7', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 35, '{"Type":"Courses","Id":10,"Message":"Enrollment has been successful in  Post Graduate on Human Resource Management"}', NULL, '2021-09-23 03:43:58', '2021-09-23 03:43:58'),
	('e69d9187-4270-4c16-878b-7625978c7ebf', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":79,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-05 08:27:32', '2022-03-05 08:27:32'),
	('e6fb7c7c-4cd5-4375-8a6b-165bb200a3f9', 'App\\Notifications\\duePaymentNotification', 'App\\Models\\User', 35, '{"Type":"Payments","Id":78,"Message":" You have a due payment of TK 0. Please make the payment."}', NULL, '2022-03-02 17:59:47', '2022-03-02 17:59:47'),
	('e700e7dd-d1d7-48b6-871d-273ea313ebda', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":67,"Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-19 06:39:24', '2021-09-19 06:39:24'),
	('e7d40120-7629-4c6b-a622-efca1c370949', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-08 06:51:26', '2021-09-08 06:51:26'),
	('e831a8c1-82c6-456d-92fc-2c7382210669', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 35, '{"Type":"Payments","Id":81,"Message":"Payment has been successfull of TK 20000"}', NULL, '2021-09-23 04:31:50', '2021-09-23 04:31:50'),
	('ea77407d-b525-4c22-9a43-1239296eba63', 'App\\Notifications\\newPaymentByStudentOwn', 'App\\Models\\User', 39, '{"Type":"Payments","Id":73,"Message":"Payment has been successfull of TK 44000"}', NULL, '2021-09-15 02:02:24', '2021-09-15 02:02:24'),
	('eb525cf9-c567-4660-acee-83de067ad596', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":76,"Message":"ggg hasan has made a payment of TK 20000"}', NULL, '2021-09-15 03:07:06', '2021-09-15 03:07:06'),
	('ebab18db-8a23-4ab2-a058-68f6a8065058', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:07:53', '2021-09-15 01:07:53'),
	('ec2691d2-13aa-4547-96ba-c53ddeb2cd92', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:26:52', '2021-09-15 01:26:52'),
	('ecf8eb14-b71d-43f2-8af1-fe350ec266b9', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 1, '{"Type":"Students","Id":50,"Message":"New student registration done. HHH"}', NULL, '2021-12-13 16:03:14', '2021-12-13 16:03:14'),
	('ed812336-1a9d-4411-9ed5-1d490fa7ec4e', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:06:13', '2021-09-15 01:06:13'),
	('ee95dad4-f50b-475c-ac18-c9a8480b72f5', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 1, '{"Type":"Payments","Id":71,"Message":"ggg hasan has made a payment of TK 55000"}', NULL, '2021-09-15 01:15:28', '2021-09-15 01:15:28'),
	('f0b34a11-c0c8-4f61-ad9c-d66f963b91c6', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":53,"Message":"New student registration done. UUU tt"}', NULL, '2021-12-22 14:28:50', '2021-12-22 14:28:50'),
	('f21593cb-88e2-4a42-9249-97dcf525dd46', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":38,"Message":"Maariz Hasan enrolled in  Post Graduate on  Finance"}', NULL, '2021-09-18 06:34:21', '2021-09-18 06:34:21'),
	('f2f7490e-312f-415a-a074-21b00591cdd0', 'App\\Notifications\\newStudentEnrolledOwn', 'App\\Models\\User', 39, '{"Type":"Courses","Id":42,"Message":"Enrollment has been successfull in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 02:01:36', '2021-09-15 02:01:36'),
	('f40be095-4661-4216-882b-08ea285c052b', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:26:52', '2021-09-15 01:26:52'),
	('f45f5db8-740c-4154-852c-9b60262fe611', 'App\\Notifications\\newStudentCreated', 'App\\Models\\User', 31, '{"Type":"Students","Id":50,"Message":"New student registration done. HHH"}', NULL, '2021-12-13 16:03:15', '2021-12-13 16:03:15'),
	('f7439001-6c9c-4c31-a3ba-a0cb1e7e2052', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":39,"Message":"MMM enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 02:04:22', '2021-09-15 02:04:22'),
	('f890feab-9b5c-4655-8589-5d8b36b9f3bc', 'App\\Notifications\\newPaymentByStudent', 'App\\Models\\User', 31, '{"Type":"Payments","Id":77,"Message":"Maariz Hasan has made a payment of TK 20000"}', NULL, '2021-09-18 06:57:14', '2021-09-18 06:57:14'),
	('fe34397e-e66f-4d16-a945-4c36532d3a3d', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 1, '{"Type":"Students","Id":55,"Message":"Test Strudent has enrolled in  Post Graduate on Human Resource Management"}', NULL, '2022-01-19 02:42:10', '2022-01-19 02:42:10'),
	('ff6fdbb7-d3b7-47e8-865b-a8718390ff1d', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:07:53', '2021-09-15 01:07:53'),
	('ffc5d6cd-4b34-4266-8db3-8ad214280ed4', 'App\\Notifications\\newStudentEnrolled', 'App\\Models\\User', 31, '{"Type":"Students","Id":42,"Message":"ggg hasan enrolled in  Post Graduate on Human Resource Management"}', NULL, '2021-09-15 01:06:13', '2021-09-15 01:06:13');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

-- Dumping structure for table abpdb.notification_templates
CREATE TABLE IF NOT EXISTS `notification_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(260) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` bigint(20) DEFAULT NULL,
  `type` enum('Email','SMS','Notificaton') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Email',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.notification_templates: ~7 rows (approximately)
/*!40000 ALTER TABLE `notification_templates` DISABLE KEYS */;
INSERT INTO `notification_templates` (`id`, `title`, `details`, `category`, `type`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Payment due sms', 'Hello [student_name],\r\nYour payment [payment_amount] is due from [payment_date]. Please clear the payment as soon as possible.\r\nThank you\r\nABP', 1, 'SMS', 'Active', '2021-08-24 18:36:30', '2021-08-24 18:36:31'),
	(2, 'Close Notice', 'Hello [student_name],\r\n the institution will remain close untill 12-10-2021 \r\nThank you\r\nABP', 2, 'SMS', 'Active', NULL, NULL),
	(3, 'Monthly upcoming payment reminder', 'Dear [student_name],\r\nGreetings from ABP,\r\nThis is just a gentle reminder that your monthly installment payment is due for this month. Please make the payment by 7th of [month] using ABP Payment Portal:   https://abpbd.org/app\r\nBest regards, \r\nABP Accounts', 3, 'SMS', 'Active', NULL, NULL),
	(4, 'OTP message', 'Your OTP for ABP portal login is', 4, 'SMS', 'Active', NULL, NULL),
	(5, 'Payment due email', 'Hello [student_name],\r\nYour payment [payment_amount] is due from [payment_date]. Please clear the payment as soon as possible.\r\nThank you\r\nABP', 1, 'Email', 'Active', '2021-08-24 18:36:30', '2021-08-24 18:36:31'),
	(6, 'Close Notice', 'Hello [student_name],\r\n the institution will remain close untill 12-10-2021 \r\nThank you\r\nABP', 2, 'Email', 'Active', NULL, NULL),
	(7, 'Monthly upcoming payment reminder', 'Dear [student_name],\r\nGreetings from ABP,\r\nThis is just a gentle reminder that your monthly installment payment is due for this month. Please make the payment by 7th of [month] using ABP Payment Portal:   https://abpbd.org/app\r\nBest regards, \r\nABP Accounts', 3, 'Email', 'Active', NULL, NULL),
	(8, 'Welcome Email', 'Dear [student_name],\r\nGreetings from ABP,\r\nWelcome to the course [batch_name]\r\nBest regards, \r\nABP', 5, 'Email', 'Active', '2022-02-25 02:10:02', '2022-02-25 02:10:02');
/*!40000 ALTER TABLE `notification_templates` ENABLE KEYS */;

-- Dumping structure for table abpdb.oauth_access_tokens
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.oauth_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- Dumping structure for table abpdb.oauth_auth_codes
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.oauth_auth_codes: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- Dumping structure for table abpdb.oauth_clients
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.oauth_clients: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- Dumping structure for table abpdb.oauth_personal_access_clients
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.oauth_personal_access_clients: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- Dumping structure for table abpdb.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.oauth_refresh_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- Dumping structure for table abpdb.result_states
CREATE TABLE IF NOT EXISTS `result_states` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table abpdb.result_states: ~4 rows (approximately)
/*!40000 ALTER TABLE `result_states` DISABLE KEYS */;
INSERT INTO `result_states` (`id`, `name`) VALUES
	(1, 'Distinction'),
	(2, 'Merit'),
	(3, 'Pass'),
	(4, 'Resit');
/*!40000 ALTER TABLE `result_states` ENABLE KEYS */;

-- Dumping structure for table abpdb.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_date` tinyint(2) NOT NULL DEFAULT 1,
  `bkash_mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rocket_mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fade_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.settings: ~1 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `company_name`, `short_name`, `site_name`, `admin_email`, `admin_mobile`, `bill_date`, `bkash_mobile_no`, `rocket_mobile_no`, `site_url`, `support_url`, `admin_url`, `logo`, `fade_logo`, `address`, `created_at`, `updated_at`) VALUES
	(1, 'Academy Of Business Professionals', 'ABPBD', 'ABPBD', 'admin@abpbd.com', '45455', 8, '01980340482', '01980340482', NULL, 'https://abpbd.org/contact ', NULL, 'abp.png', 'logo-fade.png', 'sdfsd f, sdf sdf', NULL, '2021-09-17 02:08:04');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table abpdb.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emergency_contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `user_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `study_mode` enum('Online','Campus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Online',
  `type` enum('Enrolled','Non-enrolled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Non-enrolled',
  `register_type` enum('Admin','Self') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `registration_completed` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yes',
  `current_emplyment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_qualification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `how_know` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passing_year` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `contact_no` (`contact_no`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.students: ~23 rows (approximately)
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` (`id`, `name`, `student_no`, `email`, `contact_no`, `emergency_contact`, `address`, `nid_no`, `date_of_birth`, `user_profile_image`, `remarks`, `status`, `study_mode`, `type`, `register_type`, `registration_completed`, `current_emplyment`, `current_designation`, `last_qualification`, `how_know`, `passing_year`, `created_at`, `updated_at`) VALUES
	(21, 'Muniff', '00500006', 'munif@gmail.com', '01980340482', '454', 'asdasds', '123313131231', '2021-06-25', '', 'sdr fsfsfsdff', 'Active', 'Online', 'Enrolled', 'Admin', 'Yes', 'dfsdf', '', 'Masters bachelor', 'From a Trainee of ABP', '2012-01-01', '2021-06-21 09:46:55', '2021-08-18 09:49:34'),
	(28, 'Muntakim hasan', '00500007', 'muntakim@gmail.com', '8646485', '78764453', 'dhaka', '6497846', '2021-07-28', '1625479466.jpg', ' sdf hfsdj fhsdkfh sdnfhkl sdf', 'Active', 'Online', 'Enrolled', 'Admin', 'Yes', NULL, '', 'Masters bachelor', 'From a Trainee of ABP', '2014-01-02', '2021-07-05 07:24:16', '2021-07-05 10:04:26'),
	(32, 'Litu', '00500008', 'litu@gmail1.com', '646465', '456456', 'zxcc', '6545646', '2021-04-21', NULL, NULL, 'Active', 'Online', 'Enrolled', 'Admin', 'Yes', NULL, '', 'Fazil', 'From a Trainee of ABP', NULL, '2021-08-16 15:37:45', '2021-10-07 13:51:47'),
	(33, 'Mounota Hasan', '00033', 'mounota@gmail.com', '654648864', '574646456', 'dhaka', '456456', '2021-07-20', '1629271136.jpg', NULL, 'Active', 'Online', 'Enrolled', 'Admin', 'Yes', 'Suvastu', '', 'Masters bachelor', 'From FaceBook', NULL, '2021-08-18 07:18:56', '2021-08-18 07:18:56'),
	(34, 'Student Momit', '00034', 'momit.litu@gmail.com', '546464145', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'No', NULL, '', 'Masters bachelor', 'From a Trainee of ABP', NULL, '2021-08-25 10:28:46', '2021-08-25 10:28:46'),
	(35, 'Zarif Hasan', '00035', 'zarif@gmail.com', '464654', NULL, 'fvsdfsd f', '45645646', '1996-11-21', '', NULL, 'Active', 'Online', 'Non-enrolled', 'Admin', 'Yes', NULL, '', 'Masters bachelor', 'From a Trainee of ABP', NULL, '2021-09-01 12:03:14', '2021-09-01 12:03:14'),
	(36, 'Samin Hasan', '88888', 'samin@gmail.com', '456456465', NULL, 'sfg dg', '45645646', '2008-08-12', '', NULL, 'Active', 'Online', 'Non-enrolled', 'Admin', 'Yes', NULL, '', 'Masters bachelor', 'From a Trainee of ABP', NULL, '2021-09-01 12:05:40', '2021-09-01 12:05:40'),
	(37, 'Zikra Hasan', '00037', 'zikra@gmail.com', '46546546', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', NULL, '', 'Masters bachelor', 'From a Trainee of ABP', NULL, '2021-09-02 15:43:23', '2021-09-02 15:45:02'),
	(38, 'Maariz Hasan', '00038', 'maariz@gmail.com', '01987783633', '89745645', 'dhaka', '465545', '2022-09-15', '1631945533.jpg', NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'Suvastu', 'SR Developer', NULL, 'From a Trainee of ABP', '2021-07-08', '2021-09-08 01:45:47', '2022-03-02 16:48:40'),
	(39, 'MMM', '008039', 'mm@mm.com', '54645', '45645646', 'erewr', '5665+', '2021-07-12', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'sdfssdf', '', 'Masters bachelor', 'By google search', '2021-09-05', '2021-09-14 12:12:03', '2021-09-15 02:04:16'),
	(40, 'nnnn', '008040', 'nn@nn.nn', '6465465', '4564656456', 'asdasd', '456456465', '2021-07-05', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', NULL, '', 'Kamil', 'From a Trainee of ABP', '2021-09-22', '2021-09-14 12:14:56', '2021-09-27 00:27:17'),
	(42, 'ggg hasan', '008042', 'gg@gg.gg', '456645', '6445654', 'asdasdasds', '164646', '2021-05-11', '', NULL, 'Active', 'Online', 'Non-enrolled', 'Admin', 'Yes', 'dsfadf', '', 'Master\'s', 'From a Trainee of ABP', '2021-06-22', '2021-09-14 12:45:14', '2021-09-18 05:32:48'),
	(43, 'Zikra Hasan', '008043', 'zikraa@gmail.com', '646545649', '465456465', 'rajshahi', '64645', '2021-06-15', '1632189635.jpg', NULL, 'Active', 'Online', 'Non-enrolled', 'Admin', 'Yes', NULL, '', 'Bachelor (Engineering & Technology)', 'From a Trainee of ABP', NULL, '2021-09-21 01:58:26', '2021-09-21 02:00:35'),
	(44, 'Test wothout dpb and add', '008044', 'sdf@xf.fg', '464556', NULL, NULL, NULL, NULL, '', NULL, 'Active', 'Online', 'Non-enrolled', 'Admin', 'Yes', NULL, '', 'Bachelor (Engineering & Technology)', 'From a Trainee of ABP', NULL, '2021-09-28 05:16:06', '2021-09-28 05:16:06'),
	(45, 'TEST', '008045', 'sometest.gmil@gmail.com', '45656789', NULL, NULL, NULL, '2021-07-19', '', NULL, 'Active', 'Online', 'Non-enrolled', 'Admin', 'Yes', NULL, '', 'Bachelor (Engineering & Technology)', 'From a Trainee of ABP', NULL, '2021-10-03 08:24:51', '2021-10-03 08:24:51'),
	(46, 'hhh', '008046', 'hh@hh.com', '8976546312', '5446878974', 'sdf', '456456', '2021-08-17', '', NULL, 'Active', 'Online', 'Enrolled', 'Admin', 'Yes', NULL, '', 'Bachelor (Engineering & Technology)', 'From a Trainee of ABP', NULL, '2021-10-08 10:55:04', '2021-10-08 10:55:04'),
	(47, 'MOMIT TEST', '008047', 'momitnew@gmail.com', '465456798', '46546589', 'xfgdfgd', '864564564', '2021-11-01', '1637822276.jpg', NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'ASD', '', 'Bachelor (Engineering & Technology)', 'From a Trainee of ABP', '2021-11-15', '2021-11-25 06:37:56', '2021-11-25 06:37:56'),
	(48, 'MOMIT TEST NEW 2', '008048', 'momittest2@gmail.com', '4566456', '7897894', 'asd dasd sd', '456456789', '2021-11-24', '1637823270.jpg', NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'SSD', 'Sr. Developer', 'Bachelor (Engineering & Technology)', 'From a Trainee of ABP', NULL, '2021-11-25 06:54:30', '2021-11-25 06:59:10'),
	(49, 'MMounota', '008049', 'nnss@nn.nn', '54569789', NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', NULL, '', NULL, 'From a Trainee of ABP', NULL, '2021-11-29 01:14:27', '2021-11-29 01:14:27'),
	(50, 'HHH', '008050', 'dsdddd@f.dfg', '65465489', '8978979', '8977', '89678974', '2021-12-16', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'SDL', 'SR', 'Kamil', 'From a Trainee of ABP', NULL, '2021-12-13 16:03:14', '2021-12-13 16:03:14'),
	(51, 'Test Meeting', '008051', 'test@test.com', '7989465', '32121655', 'dhaka', '77777', '2021-12-01', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'Suvastu', 'Jr ENG', 'Diploma', 'From a Trainee of ABP', NULL, '2021-12-20 08:40:50', '2021-12-20 08:40:50'),
	(52, '2nd test', '008052', 'testt2@gmail.com', '465478796', '6546784', 'dhaka', '4565468', '2021-12-27', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', 'ABP', 'SR Exc.', 'Bachelor\'s', 'From a Trainee of ABP', NULL, '2021-12-20 09:03:20', '2021-12-20 09:03:20'),
	(54, 'SSS UUUU', '008054', 'UUUU@UUU.UU', '455555555', '5555555', 'Dhaa', '8979878', '2021-12-23', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', NULL, NULL, 'Kamil', 'From a Trainee of ABP', NULL, '2021-12-22 14:33:41', '2021-12-22 14:33:41'),
	(55, 'Test Strudent', '008055', 'dd@dddd.com', '6545489', '6548664', 'dhka', '65464', '2021-12-31', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', NULL, NULL, 'Bachelor\'s', 'By google search', NULL, '2022-01-19 02:41:57', '2022-01-19 02:41:57'),
	(56, 'Test Student2', '008056', 'ss@ss.com', '87986415', '689798645', 'dhaja', '546456', '2022-01-19', '', NULL, 'Active', 'Online', 'Enrolled', 'Admin', 'Yes', 'Suvastu', 'Jr ENG', 'Doctorate', 'From office colleague', '2022-01-20', '2022-01-19 02:51:18', '2022-01-19 02:51:18'),
	(57, 'sdsdsad', '008057', 'sdf@fgdf.sdf', '34534534', '67567', '45645', '13131233', '2022-02-15', NULL, NULL, 'Active', 'Online', 'Non-enrolled', 'Self', 'Yes', NULL, NULL, 'Diploma', NULL, NULL, '2022-02-27 18:34:39', '2022-02-27 18:34:39');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

-- Dumping structure for table abpdb.student_books
CREATE TABLE IF NOT EXISTS `student_books` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_book_id` bigint(20) NOT NULL,
  `batch_student_id` bigint(20) DEFAULT NULL,
  `student_id` bigint(20) NOT NULL,
  `sent_date` timestamp NULL DEFAULT NULL,
  `received_date` timestamp NULL DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.student_books: ~18 rows (approximately)
/*!40000 ALTER TABLE `student_books` DISABLE KEYS */;
INSERT INTO `student_books` (`id`, `batch_book_id`, `batch_student_id`, `student_id`, `sent_date`, `received_date`, `status`, `created_at`, `updated_at`) VALUES
	(1, 8, 0, 38, NULL, NULL, 'Inactive', '2022-03-03 15:07:43', '2022-03-03 15:07:43'),
	(16, 13, 34, 28, '2022-03-03 00:00:00', NULL, 'Inactive', '2022-03-03 16:20:24', '2022-03-03 20:34:29'),
	(17, 13, 36, 21, NULL, NULL, 'Inactive', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(18, 13, 49, 42, NULL, NULL, 'Active', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(19, 13, 50, 38, NULL, NULL, 'Active', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(20, 13, 53, 39, NULL, NULL, 'Active', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(21, 13, 65, 48, NULL, NULL, 'Inactive', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(22, 13, 66, 51, NULL, NULL, 'Inactive', '2022-03-03 16:20:24', '2022-03-03 16:20:24'),
	(23, 14, 34, 28, NULL, NULL, 'Inactive', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(24, 14, 36, 21, NULL, NULL, 'Inactive', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(25, 14, 49, 42, NULL, NULL, 'Active', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(26, 14, 50, 38, '2022-03-04 00:03:29', NULL, 'Active', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(27, 14, 53, 39, NULL, NULL, 'Active', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(28, 14, 65, 48, NULL, NULL, 'Inactive', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(29, 14, 66, 51, NULL, NULL, 'Inactive', '2022-03-03 16:26:03', '2022-03-03 16:26:03'),
	(30, 2, 84, 32, NULL, NULL, 'Active', '2022-03-04 05:55:39', '2022-03-04 05:55:39'),
	(32, 13, 78, 49, NULL, NULL, 'Active', '2022-03-04 06:03:25', '2022-03-04 06:03:25'),
	(33, 14, 78, 49, NULL, NULL, 'Active', '2022-03-04 06:03:25', '2022-03-04 06:03:25'),
	(37, 1, 84, 32, NULL, NULL, 'Active', NULL, NULL),
	(38, 8, 84, 32, NULL, NULL, 'Active', NULL, NULL),
	(39, 15, 54, 38, NULL, NULL, 'Inactive', '2022-03-04 20:32:44', '2022-03-04 20:32:44'),
	(44, 1, 91, 39, NULL, NULL, 'Active', '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	(45, 2, 91, 39, NULL, NULL, 'Active', '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	(46, 8, 91, 39, NULL, NULL, 'Active', '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	(47, 15, 91, 39, NULL, NULL, 'Active', '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	(48, 16, 34, 28, NULL, NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(49, 16, 36, 21, NULL, NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(50, 16, 49, 42, NULL, NULL, 'Active', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(51, 16, 50, 38, NULL, NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(52, 16, 53, 39, '2022-03-05 00:00:00', NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:23'),
	(53, 16, 65, 48, NULL, NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(54, 16, 66, 51, NULL, NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(55, 16, 77, 32, NULL, NULL, 'Inactive', '2022-03-05 08:49:00', '2022-03-05 08:49:00'),
	(56, 16, 78, 49, NULL, NULL, 'Active', '2022-03-05 08:49:00', '2022-03-05 08:49:00');
/*!40000 ALTER TABLE `student_books` ENABLE KEYS */;

-- Dumping structure for table abpdb.student_books_feedback
CREATE TABLE IF NOT EXISTS `student_books_feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_book_id` bigint(20) NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.student_books_feedback: ~4 rows (approximately)
/*!40000 ALTER TABLE `student_books_feedback` DISABLE KEYS */;
INSERT INTO `student_books_feedback` (`id`, `student_book_id`, `feedback`, `created_at`, `updated_at`) VALUES
	(1, 26, 'bla bla bla', NULL, NULL),
	(2, 26, 'kla kla kla ', NULL, NULL),
	(3, 26, 'chu chu', '2022-03-03 18:31:22', '2022-03-03 18:31:22'),
	(4, 25, 'Gu GU', '2022-03-03 18:39:12', '2022-03-03 18:39:12'),
	(5, 52, 'this is a feedbak for book3', '2022-03-05 08:49:53', '2022-03-05 08:49:53'),
	(6, 52, 'this is a feedbak for book3 again', '2022-03-05 08:50:04', '2022-03-05 08:50:04');
/*!40000 ALTER TABLE `student_books_feedback` ENABLE KEYS */;

-- Dumping structure for table abpdb.student_documents
CREATE TABLE IF NOT EXISTS `student_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table abpdb.student_documents: ~16 rows (approximately)
/*!40000 ALTER TABLE `student_documents` DISABLE KEYS */;
INSERT INTO `student_documents` (`id`, `student_id`, `document_name`, `type`) VALUES
	(5, 28, 'avatar-1.jpg1625469856.jpg', 'jpg'),
	(9, 28, 'avatar-3.jpg1625481872.jpg', 'jpg'),
	(18, 28, 'avatar-1.jpg1625724018.jpg', 'jpg'),
	(19, 28, 'avatar-2.jpg1625724018.jpg', 'jpg'),
	(20, 28, 'bg_3.png1625724018.png', 'png'),
	(21, 28, 'bg_4.png1625724018.png', 'png'),
	(22, 33, 'bg_3.png1629271137.png', 'png'),
	(23, 21, 'logo-3.png1629277878.png', 'png'),
	(24, 21, 'logo-4.png1629277878.png', 'png'),
	(25, 38, 'responsive1.png1631065666.png', 'png'),
	(26, 38, 'responsive2.png1631065666.png', 'png'),
	(27, 38, 'slidebg3.png1631065666.png', 'png'),
	(28, 42, 'bg.png1631667163.png', 'png'),
	(29, 42, 'bg_2.png1631667163.png', 'png'),
	(30, 39, 'blue.png1631671456.png', 'png'),
	(31, 39, 'darkgrey.png1631671456.png', 'png'),
	(32, 40, 'bg.png1632702437.png', 'png'),
	(33, 40, 'bg_2.png1632702437.png', 'png'),
	(34, 32, 'bg_2.png1633614707.png', 'png'),
	(35, 47, '1627796494.png1637822276.png', 'png'),
	(36, 48, 'image08_thumb.jpg1637823270.jpg', 'jpg'),
	(37, 38, 'blackandwhite.png1646239720.png', 'png');
/*!40000 ALTER TABLE `student_documents` ENABLE KEYS */;

-- Dumping structure for table abpdb.student_payments
CREATE TABLE IF NOT EXISTS `student_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_enrollment_id` bigint(20) unsigned NOT NULL,
  `installment_no` int(11) unsigned NOT NULL DEFAULT 0,
  `payable_amount` bigint(20) unsigned NOT NULL,
  `paid_amount` bigint(20) unsigned NOT NULL DEFAULT 0,
  `payment_status` enum('Paid','Unpaid','Partial') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `paid_type` enum('Cash','SSL','Bkash','Rocket','EFT','Others') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `last_payment_date` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_refference_no` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_no` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_status` enum('Received','Not Received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Received',
  `paid_by` enum('Pending','Self','Admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `payment_received_by` bigint(20) unsigned DEFAULT NULL,
  `attachment` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_student_payments_batch_students` (`student_enrollment_id`),
  CONSTRAINT `FK_student_payments_batch_students` FOREIGN KEY (`student_enrollment_id`) REFERENCES `batch_students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.student_payments: ~37 rows (approximately)
/*!40000 ALTER TABLE `student_payments` DISABLE KEYS */;
INSERT INTO `student_payments` (`id`, `student_enrollment_id`, `installment_no`, `payable_amount`, `paid_amount`, `payment_status`, `paid_type`, `last_payment_date`, `paid_date`, `details`, `payment_refference_no`, `invoice_no`, `receive_status`, `paid_by`, `status`, `payment_received_by`, `attachment`, `created_at`, `updated_at`) VALUES
	(48, 33, 1, 44000, 44000, 'Paid', 'Cash', '2021-07-12', '2021-07-14', NULL, '111', 'INV-000001', 'Received', 'Pending', 'Active', NULL, NULL, '2021-07-12 08:21:31', '2021-07-13 11:33:51'),
	(49, 34, 1, 11000, 11000, 'Paid', 'Cash', '2021-07-14', '2021-07-15', 'some details', '12334', 'INV-000002', 'Received', 'Pending', 'Active', NULL, '1626276980image05_thumb.jpg', '2021-07-14 15:28:50', '2021-07-14 15:36:20'),
	(50, 34, 2, 5000, 0, 'Unpaid', 'Cash', '2022-03-01', NULL, NULL, NULL, NULL, 'Not Received', 'Pending', 'Active', NULL, NULL, '2021-07-14 15:28:50', '2021-07-15 14:44:59'),
	(54, 34, 3, 4000, 4000, 'Paid', 'Cash', '2021-11-26', '2021-11-26', NULL, NULL, 'INV-000011', 'Received', 'Pending', 'Active', NULL, NULL, '2021-07-15 14:44:51', '2021-07-16 18:13:17'),
	(55, 35, 1, 20000, 20000, 'Paid', 'Cash', '2021-08-14', '2021-08-31', NULL, NULL, NULL, 'Not Received', 'Pending', 'Active', NULL, NULL, '2021-08-17 20:00:50', '2021-08-17 20:00:50'),
	(56, 35, 2, 20000, 0, 'Unpaid', 'SSL', '2021-12-15', NULL, NULL, NULL, NULL, 'Not Received', 'Pending', 'Active', NULL, NULL, '2021-08-17 20:00:50', '2021-09-01 16:33:47'),
	(57, 35, 3, 12000, 12000, 'Paid', 'Cash', '2022-04-15', '2022-04-15', NULL, NULL, 'INV-000013', 'Received', 'Pending', 'Active', NULL, NULL, '2021-08-17 20:00:50', '2021-09-02 17:10:23'),
	(58, 36, 1, 20000, 20000, 'Paid', 'SSL', '2021-08-18', '2021-08-18', NULL, NULL, 'INV-000012', 'Not Received', 'Pending', 'Active', NULL, NULL, '2021-08-18 10:57:17', '2021-09-02 02:40:58'),
	(67, 40, 1, 20000, 20000, 'Paid', 'SSL', '2021-09-13', '2021-09-19', NULL, '6146db01db95f', 'INV-002002', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-13 14:35:43', '2021-09-19 06:39:23'),
	(72, 45, 1, 55000, 55000, 'Paid', 'SSL', '2021-09-15', '2021-09-15', NULL, '61414bed35707', 'INV-000017', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-15 01:26:52', '2021-09-15 01:54:04'),
	(73, 46, 1, 44000, 44000, 'Paid', 'SSL', '2021-09-15', '2021-09-15', NULL, '61415412ce6a2', 'INV-000018', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-15 02:01:36', '2021-09-15 02:02:24'),
	(74, 47, 1, 44000, 44000, 'Paid', 'SSL', '2021-09-15', '2021-09-15', NULL, '614154c56405d', 'INV-000019', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-15 02:04:22', '2021-09-15 02:05:37'),
	(76, 49, 1, 20000, 20000, 'Paid', 'Cash', '2021-09-15', '2021-09-15', NULL, NULL, 'INV-002000', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-15 02:52:27', '2021-09-15 03:07:06'),
	(77, 50, 1, 20000, 0, 'Unpaid', 'SSL', '2021-09-18', NULL, NULL, '614714f154bb3', 'INV-002001', 'Received', 'Pending', 'Inactive', NULL, NULL, '2021-09-18 06:34:20', '2022-03-04 19:54:44'),
	(78, 51, 1, 55000, 0, 'Unpaid', 'Cash', '2021-10-23', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-23 03:43:57', '2021-09-23 03:43:57'),
	(79, 52, 1, 30000, 0, 'Unpaid', 'Cash', '2021-09-23', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-23 04:20:37', '2021-09-23 04:20:37'),
	(80, 52, 2, 30000, 30000, 'Paid', 'Cash', '2022-05-11', '2022-05-11', NULL, NULL, 'INV-002004', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-23 04:20:37', '2021-09-23 05:16:49'),
	(81, 52, 3, 20000, 20000, 'Paid', 'Cash', '2022-11-11', '2022-11-11', NULL, NULL, 'INV-002003', 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-23 04:20:37', '2021-09-23 04:31:50'),
	(82, 53, 1, 11000, 0, 'Unpaid', 'Cash', '2021-09-23', NULL, NULL, '62014f219280c', NULL, 'Received', 'Pending', 'Inactive', NULL, NULL, '2021-09-23 04:37:23', '2022-03-04 21:50:54'),
	(83, 53, 2, 11000, 0, 'Unpaid', 'Cash', '2022-03-01', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Inactive', NULL, NULL, '2021-09-23 04:37:23', '2022-03-04 21:50:54'),
	(84, 54, 1, 500000, 0, 'Unpaid', 'Cash', '2021-09-25', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-25 06:58:17', '2021-09-25 06:58:17'),
	(85, 55, 1, 30000, 0, 'Unpaid', 'Cash', '2021-09-27', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:27:21', '2021-09-27 00:27:21'),
	(86, 55, 2, 30000, 0, 'Unpaid', 'Cash', '2022-05-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:27:21', '2021-09-27 00:27:21'),
	(87, 55, 3, 20000, 0, 'Unpaid', 'Cash', '2022-11-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:27:21', '2021-09-27 00:27:21'),
	(88, 56, 1, 30000, 0, 'Unpaid', 'Cash', '2021-11-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:31:04', '2021-09-27 00:31:04'),
	(89, 56, 2, 30000, 0, 'Unpaid', 'Cash', '2022-05-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:31:04', '2021-09-27 00:31:04'),
	(90, 56, 3, 20000, 0, 'Unpaid', 'Cash', '2022-11-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:31:04', '2021-09-27 00:31:04'),
	(91, 57, 1, 30000, 0, 'Unpaid', 'Cash', '2021-11-11', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-09-27 00:33:00', '2021-09-27 00:33:00'),
	(92, 57, 2, 30000, 30000, 'Paid', 'Cash', '2022-05-08', '2022-05-08', NULL, NULL, 'INV-002008', 'Received', 'Admin', 'Active', 1, NULL, '2021-09-27 00:33:00', '2022-02-17 19:13:31'),
	(93, 57, 3, 20000, 20000, 'Paid', 'Cash', '2022-11-08', '2022-11-08', NULL, NULL, 'INV-002005', 'Received', 'Admin', 'Active', 1, NULL, '2021-09-27 00:33:00', '2021-09-27 01:23:00'),
	(99, 64, 1, 60000, 60000, 'Paid', 'Cash', '2022-01-01', '2022-01-01', NULL, NULL, 'INV-002006', 'Received', 'Admin', 'Active', 1, NULL, '2021-10-17 03:52:13', '2021-10-17 03:53:29'),
	(100, 65, 1, 20000, 0, 'Unpaid', 'Cash', '2021-11-25', NULL, NULL, '619f334b93234', NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2021-11-25 06:54:45', '2021-11-25 06:55:07'),
	(101, 67, 1, 40000, 40000, 'Paid', 'Bkash', '2022-01-19', '2022-01-19', NULL, NULL, 'INV-002007', 'Received', 'Admin', 'Active', 1, NULL, '2022-01-19 02:42:10', '2022-01-31 09:44:58'),
	(104, 77, 1, 11000, 0, 'Unpaid', 'Cash', '2021-09-01', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Inactive', NULL, NULL, '2022-03-04 05:55:39', '2022-03-04 20:12:50'),
	(105, 77, 2, 11000, 0, 'Unpaid', 'Cash', '2022-03-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Inactive', NULL, NULL, '2022-03-04 05:55:39', '2022-03-04 20:12:50'),
	(106, 78, 1, 20000, 0, 'Unpaid', 'Cash', '2021-09-01', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 06:03:25', '2022-03-04 06:03:25'),
	(109, 84, 1, 11000, 0, 'Unpaid', 'Cash', '2021-09-01', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 20:12:50', '2022-03-04 20:12:50'),
	(110, 84, 2, 11000, 0, 'Unpaid', 'Cash', '2022-03-08', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 20:12:50', '2022-03-04 20:12:50'),
	(111, 84, 0, 111, 0, 'Unpaid', 'Cash', '2022-03-04', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 20:12:50', '2022-03-04 20:12:50'),
	(115, 91, 1, 11000, 0, 'Unpaid', 'Cash', '2021-09-23', NULL, NULL, '62014f219280c', NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	(116, 91, 2, 11000, 0, 'Unpaid', 'Cash', '2022-03-01', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 21:50:54', '2022-03-04 21:50:54'),
	(117, 91, 0, 5, 0, 'Unpaid', 'Cash', '2022-03-04', NULL, NULL, NULL, NULL, 'Received', 'Pending', 'Active', NULL, NULL, '2022-03-04 21:50:54', '2022-03-04 21:50:54');
/*!40000 ALTER TABLE `student_payments` ENABLE KEYS */;

-- Dumping structure for table abpdb.student_revise_payments
CREATE TABLE IF NOT EXISTS `student_revise_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_enrollment_id` bigint(20) unsigned NOT NULL,
  `revise_details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revise_status` enum('Approved','Pending','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.student_revise_payments: ~0 rows (approximately)
/*!40000 ALTER TABLE `student_revise_payments` DISABLE KEYS */;
INSERT INTO `student_revise_payments` (`id`, `student_enrollment_id`, `revise_details`, `revise_status`, `created_at`, `updated_at`) VALUES
	(2, 36, 'sdf sdsdff', 'Rejected', '2021-08-24 07:15:50', '2021-08-24 11:56:51');
/*!40000 ALTER TABLE `student_revise_payments` ENABLE KEYS */;

-- Dumping structure for table abpdb.template_categories
CREATE TABLE IF NOT EXISTS `template_categories` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `category_name` varchar(50) DEFAULT NULL,
  `placeholders` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table abpdb.template_categories: ~5 rows (approximately)
/*!40000 ALTER TABLE `template_categories` DISABLE KEYS */;
INSERT INTO `template_categories` (`id`, `category_name`, `placeholders`) VALUES
	(1, 'Unpaid', '[student_name],[payment_date],[payment_amount]'),
	(2, 'Student', '[student_name]'),
	(3, 'upcoming-due', '[student_name],[month]'),
	(4, 'otp', ''),
	(5, 'welcome', '[student_name],[batch_name]');
/*!40000 ALTER TABLE `template_categories` ENABLE KEYS */;

-- Dumping structure for table abpdb.units
CREATE TABLE IF NOT EXISTS `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `glh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_hour` int(11) NOT NULL,
  `tut` int(11) NOT NULL,
  `assessment_type` enum('Internal','External') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Internal',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.units: ~4 rows (approximately)
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` (`id`, `unit_code`, `name`, `glh`, `credit_hour`, `tut`, `assessment_type`, `status`, `created_at`, `updated_at`) VALUES
	(23, 'EPU 170457', 'Unit name 1', '40', 10, 100, 'Internal', 'Active', '2021-06-22 07:24:17', '2021-09-20 13:18:59'),
	(24, 'EPU 170458', 'Unit Name 2', '30', 10, 200, 'Internal', 'Active', '2021-06-22 07:48:57', '2021-06-22 07:48:57'),
	(25, '456456', 'fsd f', '45', 5, 6, 'Internal', 'Active', '2021-09-01 10:02:20', '2021-09-20 13:41:51'),
	(27, 'HHH0001', 'MOIT TEST', '120', -5, 20, 'Internal', 'Active', '2021-09-20 13:44:10', '2021-09-20 13:49:33');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;

-- Dumping structure for table abpdb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_id` bigint(20) DEFAULT NULL COMMENT 'when a user is under a client then client id will set here',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `type` enum('Admin','Student') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `login_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:logged-in,0:Not logged in',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `contact_no` (`contact_no`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.users: ~29 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_profile_image`, `contact_no`, `remarks`, `student_id`, `status`, `type`, `login_status`, `password`, `email_verified_at`, `remember_token`, `otp`, `created_at`, `updated_at`) VALUES
	(1, 'Momit', 'Hasan', 'momit@technolife.ee', '1616308888.jpg', '74645564654', NULL, NULL, 1, 'Admin', 0, '$2y$10$l7pbujEwdwtKp53IptFxnOJ7c09o1cPJk3QvUEkg5WbMRV36Jph3.', NULL, NULL, '', '2021-06-07 12:50:15', '2022-03-05 08:22:03'),
	(23, 'Muniff DD', 'Hasannn', 'munif@gmail.comm', '1631513007.jpg', '654646800', NULL, 21, 1, 'Student', 1, '$2y$10$KuzBDu8QI.9wk3PdzKq79uZ0qB68R/iSe4hoXUVE7pq2i5B0LREB2', NULL, NULL, '', '2021-06-21 09:46:55', '2021-09-13 06:06:14'),
	(24, 'Muntakim hasan', NULL, 'muntakim@gmail.com', '1625479466.jpg', '8646485', 'sdf hfsdj fhsdkfh sdnfhkl sdf', 28, 1, 'Student', 1, '$2y$10$zFj3Z1gRkrbgUvoNXF6cXubdAp8p54yy4kRgJ421RQNqllCEvHJka', NULL, NULL, '', '2021-07-05 07:24:16', '2022-03-03 20:41:29'),
	(28, 'Litu', NULL, 'litu@gmail1.com', NULL, '646465', NULL, 32, 1, 'Student', 0, '$2y$10$5Z7y7Bt1TDrjp.mtolCSBu.MOayoHhvtMQmLIPV6eLywYVo2XtGGy', NULL, NULL, '', '2021-08-16 15:37:45', '2021-10-07 13:51:47'),
	(29, 'Mounota Hasan', NULL, 'mounota@gmail.com', NULL, '654648864', NULL, 33, 1, 'Student', 0, '$2y$10$kt2KaSpzPiqTNRQaFMdZ3.5tDN/PoMHt.HLKo8IwMj6sLHOEflhjm', NULL, NULL, '', '2021-08-18 07:18:57', '2021-08-18 07:18:57'),
	(30, 'Student Momit', NULL, 'momit.litu@gmail.com', NULL, '546464145', NULL, 34, 1, 'Student', 1, '$2y$10$68k00lFkMUf7mS.jBPwyheXD.o83kNRERuJpYmf9tycFX6DaUpdaG', NULL, NULL, '', '2021-08-25 10:28:46', '2021-08-25 10:59:59'),
	(31, 'Admin', 'User', 'admin@abp.com', NULL, '46456456', NULL, NULL, 1, 'Admin', 0, '$2y$10$DiM72TqtCZyCEtdqSP26W.HcMOfzTQhHB2qLz419g5tacuhYLHPi2', NULL, NULL, '', '2021-08-25 11:00:49', '2021-08-25 11:01:03'),
	(32, 'Zarif Hasan', NULL, 'zarif@gmail.com', NULL, '464654', NULL, 35, 1, 'Student', 0, '$2y$10$1yuPJcZtGqCXEMT7TC.ceOF316MmIGn5n41jmW5j4pBEMNjmwXnPe', NULL, NULL, '', '2021-09-01 12:03:14', '2021-09-01 12:03:14'),
	(33, 'Samin Hasan', NULL, 'samin@gmail.com', NULL, '456456465', NULL, 36, 1, 'Student', 0, '$2y$10$9kGfMdKSqY0JVJyRhsuy0.TOm.Z14Pxk2B8tjipIgc2L3bPfYYlSG', NULL, NULL, '', '2021-09-01 12:05:40', '2021-09-01 12:05:40'),
	(34, 'Zikra Hasan', NULL, 'zikra@gmail.com', NULL, '46546546', NULL, 37, 1, 'Student', 0, '$2y$10$fiM.EM7kdxux6QEgPQJ97eV9bpce/P68HFN2tb.WV1EtnOcIOPaPq', NULL, NULL, '', '2021-09-02 15:43:23', '2021-09-02 15:43:23'),
	(35, 'Maariz Hasan', NULL, 'maariz@gmail.com', '1631945533.jpg', '01987783633', NULL, 38, 1, 'Student', 1, '$2y$10$TQ/EjJaWWwH/q4EveSFl5.fW3aIm1zVCaA6isMmtjFiU/8Nf9oHFO', NULL, NULL, '', '2021-09-08 01:45:47', '2022-03-05 08:52:47'),
	(36, 'MMM', NULL, 'mm@mm.com', NULL, '54645', NULL, 39, 1, 'Student', 0, '$2y$10$P8KteUhsXudRtpfkfq58FuYmVEL6SgZ04cv/L6rk7vn1R3NpbnNEi', NULL, NULL, '', '2021-09-14 12:12:03', '2022-03-05 08:52:56'),
	(37, 'nnnn', NULL, 'nn@nn.nn', NULL, '6465465', NULL, 40, 1, 'Student', 1, '$2y$10$7WKN4pOShBPyFR6.Au2VBuAo2sI5ASAhhvY3vPo3/uuSb.JXcQwg2', NULL, NULL, '', '2021-09-14 12:14:57', '2021-12-01 03:20:26'),
	(39, 'ggg hasan', NULL, 'gg@gg.gg', NULL, '456645', NULL, 42, 1, 'Student', 1, '$2y$10$64jG.PGZoqlCoj2OHanfs.0QPUkVfft5JlOVi3c1jgMUmUpdW4x32', NULL, NULL, '', '2021-09-14 12:45:14', '2021-09-18 05:32:48'),
	(40, 'Zikra Hasan', NULL, 'zikraa@gmail.com', '1632189635.jpg', '646545649', NULL, 43, 1, 'Student', 0, '$2y$10$X6iXLD1fXgTTcniXl5AK1umoZUY3p0NrZus3y6gKwGBvsf7LwaVvK', NULL, NULL, '', '2021-09-21 01:58:26', '2021-09-21 02:00:35'),
	(41, 'Test wothout dpb and add', NULL, 'sdf@xf.fg', NULL, '464556', NULL, 44, 1, 'Student', 0, '$2y$10$WP00RrhMsc9tgDxrTeLFNOeYTNPnMfYhf1KQ60kXxqxaT2FutjWUq', NULL, NULL, '', '2021-09-28 05:16:06', '2021-09-28 05:16:06'),
	(42, 'TEST', NULL, 'sometest.gmil@gmail.com', NULL, '45656789', NULL, 45, 1, 'Student', 0, '$2y$10$QTdJNjTndfRKGDBwe/Qo..6YrJC4vm8BSOhXzgkNMXxJ424Vt38Ee', NULL, NULL, '', '2021-10-03 08:24:51', '2021-10-03 09:32:11'),
	(43, 'hhh', NULL, 'hh@hh.com', NULL, '8976546312', NULL, 46, 1, 'Student', 0, '$2y$10$dnV1gi6tR5HKxFbZHM7vt.eHSx7UTeom7OqN6VdRN8ECJeEnvpSX6', NULL, NULL, '', '2021-10-08 10:55:04', '2021-10-08 10:55:04'),
	(44, 'MOMIT TEST', NULL, 'momitnew@gmail.com', '1637822276.jpg', '465456798', NULL, 47, 1, 'Student', 0, '$2y$10$k06Aw1FAo5Y4G5fBWCv1HuSXZ6rJqOjaBo5yGuT017py9rZFIQuC6', NULL, NULL, '', '2021-11-25 06:37:56', '2021-11-25 06:37:56'),
	(45, 'MOMIT TEST NEW 2', NULL, 'momittest2@gmail.com', '1637823270.jpg', '4566456', NULL, 48, 1, 'Student', 1, '$2y$10$ZcwC9KOn8bSVuUpZfhBQO.qNcxh2SyeQiOeHJahi5dc5UTtkODsuu', NULL, 'ZoPIHj4qMc8OqxqWoxycQmtKcZgvvvoNfpTOnmgHw0hwYTQaq2UZkc70kYGU', '', '2021-11-25 06:54:30', '2021-11-29 01:13:09'),
	(46, 'MMounota', NULL, 'nnss@nn.nn', NULL, '54569789', NULL, 49, 1, 'Student', 0, '$2y$10$Xkf1ckzP95c7t2U54yrAlOfbhiXLeqgmgPK3FNqeFIDsnpMgjQ7QS', NULL, NULL, '', '2021-11-29 01:14:28', '2021-11-29 01:14:28'),
	(47, 'HHH', NULL, 'dsdddd@f.dfg', NULL, '65465489', NULL, 50, 1, 'Student', 0, '$2y$10$AAiBpx/XE3Vk6c4n8HvLW.KE8XMtGH34.lfUE82sZgNLfE.wzGv7C', NULL, '5uwJy4VpNm64mwrvbZaHcIXhzBGa7gRDDaqTb3ZT3oyjHcf11agxWdNDONKK', '', '2021-12-13 16:03:14', '2021-12-13 16:03:14'),
	(48, 'Test Meeting', NULL, 'test@test.com', NULL, '7989465', NULL, 51, 1, 'Student', 1, '$2y$10$P8wIGLaHcUPrXGwh7/aUz.l4AD7GW/4LSEVp4Hvn6MecikTJTda6q', NULL, 'slwoYbARRTtw2pYsGKXN8xrAQrRIpta1lQyXhsoceNueL9PvgZ3t53tKA9PN', '', '2021-12-20 08:40:50', '2021-12-20 08:44:16'),
	(49, '2nd test', NULL, 'testt2@gmail.com', NULL, '465478796', NULL, 52, 1, 'Student', 1, '$2y$10$9HsvX.ufJQ1Sjs/WnpaXAu2iBC6rRGs90LE8YiOXWEbA9SlQYyIUa', NULL, 'Uz0X327tLa8B29CUP3QYfmkO6LOObbBiLPt9HIZLzGlb09XJf7HBW8F1toed', '', '2021-12-20 09:03:20', '2021-12-20 09:05:26'),
	(50, 'UUU tt', NULL, 'ss@ss.ss', NULL, '89465451', NULL, 53, 1, 'Student', 1, '$2y$10$sW9lRDN5zd../Gk9ECzUg.IU6malzrYDNFHGxOsDev1stNirEfD9q', NULL, 'S3MRbmeaecwcQGB8pA3Ls7cDEM30mOH6DJFcknxptk7nvHu2LRDwMFUkQW4m', '', '2021-12-22 14:28:48', '2021-12-22 14:31:31'),
	(51, 'SSS UUUU', NULL, 'UUUU@UUU.UU', NULL, '455555555', NULL, 54, 1, 'Student', 0, '$2y$10$/aEkMZvI/oRz/lETW8065.Yx20SK2oxt3qHEhg.oI1mcFvkrjC1E6', NULL, 'RsKjVlqJmAfOeAXGL5DCBDBsf4LGb1ucK9XTTO8rDCtoXwQpN0yqrPq6ohYm', '', '2021-12-22 14:33:41', '2021-12-22 14:33:41'),
	(52, 'Test Strudent', NULL, 'dd@dddd.com', NULL, '6545489', NULL, 55, 1, 'Student', 1, '$2y$10$U9YDs.qmHiukxqRBpuPC9u898FwG70zRyEOOBjrkEI/mT30ddmyfW', NULL, 'BOcPcRYbaIBUWYKUUybRviigB25iSmufZKMbgauVBNyRyPIR1PAt6QIJNxGh', '', '2022-01-19 02:41:57', '2022-01-19 02:42:58'),
	(53, 'Test Student2', NULL, 'ss@ss.com', NULL, '87986415', NULL, 56, 1, 'Student', 0, '$2y$10$32T6UVUSznSzUsME4zzl4ebNjmApEgAqh360J0Tscs7ZI6MyWdlmi', NULL, NULL, '', '2022-01-19 02:51:18', '2022-01-19 02:51:18'),
	(54, 'sdsdsad', NULL, 'sdf@fgdf.sdf', NULL, '34534534', NULL, 57, 1, 'Student', 0, '$2y$10$FzQRL67RLsXF.5ebxaP/2utyRg8sxUuMb.92G7KH2v8RYSC5PGB9K', NULL, 'iidXYdSWPElFCvNECAi0iCoFG0hyP6ds4LaatUMoElZdxw2bf1wvehHZRDPY', '', '2022-02-27 18:34:39', '2022-02-27 18:34:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table abpdb.user_groups
CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Admin User, 2: client User',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `editable` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:yes,0:no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_groups: ~4 rows (approximately)
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` (`id`, `group_name`, `type`, `status`, `editable`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 1, 1, 0, NULL, NULL),
	(2, 'Admin', 1, 1, 1, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(27, 'Student', 2, 1, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(29, 'Accounts', 1, 1, 1, '2021-07-15 14:16:47', '2021-07-15 14:16:47');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;

-- Dumping structure for table abpdb.user_group_members
CREATE TABLE IF NOT EXISTS `user_group_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_group_members_users` (`user_id`),
  KEY `FK_user_group_members_user_groups` (`group_id`),
  CONSTRAINT `FK_user_group_members_user_groups` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`),
  CONSTRAINT `FK_user_group_members_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_group_members: ~33 rows (approximately)
/*!40000 ALTER TABLE `user_group_members` DISABLE KEYS */;
INSERT INTO `user_group_members` (`id`, `user_id`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, NULL, NULL),
	(4, 1, 2, 0, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(5, 1, 27, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(23, 23, 27, 1, '2021-06-21 09:46:55', '2021-06-21 09:46:55'),
	(24, 24, 27, 1, '2021-07-05 07:24:16', '2021-07-05 07:24:16'),
	(27, 1, 29, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(28, 23, 29, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(29, 24, 29, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(30, 28, 27, 1, '2021-08-16 15:37:45', '2021-08-16 15:37:45'),
	(31, 29, 27, 1, '2021-08-18 07:18:57', '2021-08-18 07:18:57'),
	(32, 30, 27, 1, '2021-08-25 10:28:46', '2021-08-25 10:28:46'),
	(33, 31, 1, 0, '2021-08-25 11:00:49', '2021-08-25 11:00:49'),
	(34, 31, 2, 1, '2021-08-25 11:00:49', '2021-08-25 11:00:49'),
	(35, 31, 29, 0, '2021-08-25 11:00:49', '2021-08-25 11:00:49'),
	(36, 32, 27, 1, '2021-09-01 12:03:14', '2021-09-01 12:03:14'),
	(37, 33, 27, 1, '2021-09-01 12:05:40', '2021-09-01 12:05:40'),
	(38, 34, 27, 1, '2021-09-02 15:43:24', '2021-09-02 15:43:24'),
	(39, 35, 27, 1, '2021-09-08 01:45:47', '2021-09-08 01:45:47'),
	(40, 36, 27, 1, '2021-09-14 12:12:03', '2021-09-14 12:12:03'),
	(41, 37, 27, 1, '2021-09-14 12:14:57', '2021-09-14 12:14:57'),
	(43, 39, 27, 1, '2021-09-14 12:45:14', '2021-09-14 12:45:14'),
	(44, 40, 27, 1, '2021-09-21 01:58:26', '2021-09-21 01:58:26'),
	(45, 41, 27, 1, '2021-09-28 05:16:06', '2021-09-28 05:16:06'),
	(46, 42, 27, 1, '2021-10-03 08:24:51', '2021-10-03 08:24:51'),
	(47, 43, 27, 1, '2021-10-08 10:55:04', '2021-10-08 10:55:04'),
	(48, 44, 27, 1, '2021-11-25 06:37:56', '2021-11-25 06:37:56'),
	(49, 45, 27, 1, '2021-11-25 06:54:30', '2021-11-25 06:54:30'),
	(50, 46, 27, 1, '2021-11-29 01:14:28', '2021-11-29 01:14:28'),
	(51, 47, 27, 1, '2021-12-13 16:03:14', '2021-12-13 16:03:14'),
	(52, 48, 27, 1, '2021-12-20 08:40:50', '2021-12-20 08:40:50'),
	(53, 49, 27, 1, '2021-12-20 09:03:20', '2021-12-20 09:03:20'),
	(54, 50, 27, 1, '2021-12-22 14:28:48', '2021-12-22 14:28:48'),
	(55, 51, 27, 1, '2021-12-22 14:33:41', '2021-12-22 14:33:41'),
	(56, 52, 27, 1, '2022-01-19 02:41:57', '2022-01-19 02:41:57'),
	(57, 53, 27, 1, '2022-01-19 02:51:18', '2022-01-19 02:51:18'),
	(58, 54, 27, 1, '2022-02-27 18:34:39', '2022-02-27 18:34:39');
/*!40000 ALTER TABLE `user_group_members` ENABLE KEYS */;

-- Dumping structure for table abpdb.user_group_permissions
CREATE TABLE IF NOT EXISTS `user_group_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) NOT NULL DEFAULT 0,
  `action_id` bigint(20) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_group_permissions_user_groups` (`group_id`),
  KEY `FK_user_group_permissions_actions` (`action_id`),
  CONSTRAINT `FK_user_group_permissions_actions` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `FK_user_group_permissions_user_groups` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=489 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_group_permissions: ~282 rows (approximately)
/*!40000 ALTER TABLE `user_group_permissions` DISABLE KEYS */;
INSERT INTO `user_group_permissions` (`id`, `group_id`, `action_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, NULL, NULL),
	(2, 1, 2, 1, NULL, NULL),
	(3, 1, 3, 1, NULL, NULL),
	(4, 1, 4, 1, NULL, NULL),
	(5, 1, 5, 1, NULL, NULL),
	(6, 1, 6, 1, NULL, NULL),
	(7, 1, 7, 1, NULL, NULL),
	(8, 1, 8, 1, NULL, NULL),
	(9, 1, 9, 1, NULL, NULL),
	(10, 1, 10, 1, NULL, NULL),
	(11, 1, 11, 1, NULL, NULL),
	(12, 1, 12, 1, '2020-04-09 14:26:07', '2020-04-09 14:26:07'),
	(15, 1, 15, 1, '2020-04-10 00:50:37', '2020-04-10 00:50:37'),
	(16, 1, 16, 1, '2020-04-10 10:54:39', '2020-04-10 10:54:39'),
	(17, 1, 17, 1, '2020-04-10 10:55:22', '2020-04-10 10:55:22'),
	(18, 1, 18, 1, '2020-04-10 10:55:36', '2020-04-10 10:55:36'),
	(19, 1, 19, 1, '2020-04-10 10:56:36', '2020-04-10 10:56:36'),
	(20, 1, 20, 1, '2020-04-10 11:26:19', '2020-04-10 11:26:19'),
	(39, 27, 1, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(40, 27, 2, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(41, 27, 3, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(42, 27, 4, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(43, 27, 5, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(44, 27, 6, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(45, 27, 7, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(46, 27, 8, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(47, 27, 9, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(48, 27, 10, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(49, 27, 11, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(50, 27, 12, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(51, 27, 15, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(52, 27, 16, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(53, 27, 17, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(54, 27, 18, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(55, 27, 19, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(56, 27, 20, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(57, 1, 21, 1, '2021-03-21 07:07:10', '2021-03-21 07:07:10'),
	(58, 2, 21, 1, '2021-03-21 07:07:10', '2021-03-21 07:07:10'),
	(59, 27, 21, 0, '2021-03-21 07:07:10', '2021-03-21 07:07:10'),
	(60, 1, 22, 1, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(61, 2, 22, 1, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(62, 27, 22, 0, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(63, 1, 23, 1, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(64, 2, 23, 1, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(65, 27, 23, 0, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(66, 1, 24, 1, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(67, 2, 24, 1, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(68, 27, 24, 0, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(69, 1, 25, 1, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(70, 2, 25, 1, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(71, 27, 25, 0, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(72, 1, 26, 1, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(73, 2, 26, 1, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(74, 27, 26, 0, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(75, 1, 27, 1, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(76, 2, 27, 1, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(77, 27, 27, 0, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(78, 1, 28, 1, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(79, 2, 28, 1, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(80, 27, 28, 0, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(108, 1, 38, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(109, 2, 38, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(110, 27, 38, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(111, 1, 39, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(112, 2, 39, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(113, 27, 39, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(114, 1, 40, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(115, 2, 40, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(116, 27, 40, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(117, 1, 41, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(118, 2, 41, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(119, 27, 41, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(250, 1, 66, 1, '2021-06-12 07:42:36', '2021-06-12 07:42:36'),
	(251, 2, 66, 1, '2021-06-12 07:42:36', '2021-06-12 07:42:36'),
	(252, 27, 66, 0, '2021-06-12 07:42:36', '2021-06-12 07:42:36'),
	(253, 1, 67, 1, '2021-06-12 08:22:03', '2021-06-12 08:22:03'),
	(254, 2, 67, 1, '2021-06-12 08:22:03', '2021-06-12 08:22:03'),
	(255, 27, 67, 0, '2021-06-12 08:22:03', '2021-06-12 08:22:03'),
	(256, 1, 68, 1, '2021-06-12 08:23:18', '2021-06-12 08:23:18'),
	(257, 2, 68, 1, '2021-06-12 08:23:18', '2021-06-12 08:23:18'),
	(258, 27, 68, 0, '2021-06-12 08:23:18', '2021-06-12 08:23:18'),
	(259, 1, 69, 1, '2021-06-12 08:23:28', '2021-06-12 08:23:28'),
	(260, 2, 69, 1, '2021-06-12 08:23:28', '2021-06-12 08:23:28'),
	(261, 27, 69, 0, '2021-06-12 08:23:28', '2021-06-12 08:23:28'),
	(271, 1, 73, 1, '2021-07-06 12:20:48', '2021-07-06 12:20:48'),
	(272, 2, 73, 1, '2021-07-06 12:20:48', '2021-07-06 12:20:48'),
	(273, 27, 73, 0, '2021-07-06 12:20:48', '2021-07-06 12:20:48'),
	(274, 1, 74, 1, '2021-07-06 12:21:15', '2021-07-06 12:21:15'),
	(275, 2, 74, 1, '2021-07-06 12:21:15', '2021-07-06 12:21:15'),
	(276, 27, 74, 0, '2021-07-06 12:21:15', '2021-07-06 12:21:15'),
	(277, 1, 75, 1, '2021-07-06 12:21:23', '2021-07-06 12:21:23'),
	(278, 2, 75, 1, '2021-07-06 12:21:23', '2021-07-06 12:21:23'),
	(279, 27, 75, 0, '2021-07-06 12:21:23', '2021-07-06 12:21:23'),
	(280, 1, 76, 1, '2021-07-06 12:21:31', '2021-07-06 12:21:31'),
	(281, 2, 76, 1, '2021-07-06 12:21:31', '2021-07-06 12:21:31'),
	(282, 27, 76, 0, '2021-07-06 12:21:31', '2021-07-06 12:21:31'),
	(283, 1, 77, 1, '2021-07-06 12:22:02', '2021-07-06 12:22:02'),
	(284, 2, 77, 1, '2021-07-06 12:22:02', '2021-07-06 12:22:02'),
	(285, 27, 77, 0, '2021-07-06 12:22:02', '2021-07-06 12:22:02'),
	(286, 1, 78, 1, '2021-07-06 12:22:16', '2021-07-06 12:22:16'),
	(287, 2, 78, 1, '2021-07-06 12:22:16', '2021-07-06 12:22:16'),
	(288, 27, 78, 0, '2021-07-06 12:22:16', '2021-07-06 12:22:16'),
	(289, 1, 79, 1, '2021-07-06 12:22:27', '2021-07-06 12:22:27'),
	(290, 2, 79, 1, '2021-07-06 12:22:27', '2021-07-06 12:22:27'),
	(291, 27, 79, 0, '2021-07-06 12:22:27', '2021-07-06 12:22:27'),
	(292, 1, 80, 1, '2021-07-06 12:22:36', '2021-07-06 12:22:36'),
	(293, 2, 80, 1, '2021-07-06 12:22:36', '2021-07-06 12:22:36'),
	(294, 27, 80, 0, '2021-07-06 12:22:36', '2021-07-06 12:22:36'),
	(295, 1, 81, 1, '2021-07-07 12:54:26', '2021-07-07 12:54:26'),
	(296, 2, 81, 1, '2021-07-07 12:54:26', '2021-07-07 12:54:26'),
	(297, 27, 81, 0, '2021-07-07 12:54:26', '2021-07-07 12:54:26'),
	(298, 1, 82, 1, '2021-07-07 12:54:43', '2021-07-07 12:54:43'),
	(299, 2, 82, 1, '2021-07-07 12:54:43', '2021-07-07 12:54:43'),
	(300, 27, 82, 0, '2021-07-07 12:54:43', '2021-07-07 12:54:43'),
	(301, 1, 83, 1, '2021-07-07 12:55:01', '2021-07-07 12:55:01'),
	(302, 2, 83, 1, '2021-07-07 12:55:01', '2021-07-07 12:55:01'),
	(303, 27, 83, 0, '2021-07-07 12:55:01', '2021-07-07 12:55:01'),
	(304, 1, 84, 1, '2021-07-07 12:55:12', '2021-07-07 12:55:12'),
	(305, 2, 84, 1, '2021-07-07 12:55:12', '2021-07-07 12:55:12'),
	(306, 27, 84, 0, '2021-07-07 12:55:12', '2021-07-07 12:55:12'),
	(307, 1, 85, 1, '2021-07-10 07:45:23', '2021-07-10 07:45:23'),
	(308, 2, 85, 0, '2021-07-10 07:45:23', '2021-07-10 07:45:23'),
	(309, 27, 85, 0, '2021-07-10 07:45:23', '2021-07-10 07:45:23'),
	(310, 1, 86, 1, '2021-07-12 07:31:30', '2021-07-12 07:31:30'),
	(311, 2, 86, 0, '2021-07-12 07:31:30', '2021-07-12 07:31:30'),
	(312, 27, 86, 0, '2021-07-12 07:31:30', '2021-07-12 07:31:30'),
	(313, 1, 87, 1, '2021-07-12 07:35:49', '2021-07-12 07:35:49'),
	(314, 2, 87, 0, '2021-07-12 07:35:49', '2021-07-12 07:35:49'),
	(315, 27, 87, 0, '2021-07-12 07:35:49', '2021-07-12 07:35:49'),
	(316, 1, 88, 1, '2021-07-12 07:36:06', '2021-07-12 07:36:06'),
	(317, 2, 88, 0, '2021-07-12 07:36:06', '2021-07-12 07:36:06'),
	(318, 27, 88, 0, '2021-07-12 07:36:06', '2021-07-12 07:36:06'),
	(319, 1, 89, 1, '2021-07-12 07:36:21', '2021-07-12 07:36:21'),
	(320, 2, 89, 0, '2021-07-12 07:36:21', '2021-07-12 07:36:21'),
	(321, 27, 89, 0, '2021-07-12 07:36:21', '2021-07-12 07:36:21'),
	(322, 1, 90, 1, '2021-07-13 11:40:16', '2021-07-13 11:40:16'),
	(323, 2, 90, 0, '2021-07-13 11:40:16', '2021-07-13 11:40:16'),
	(324, 27, 90, 0, '2021-07-13 11:40:16', '2021-07-13 11:40:16'),
	(325, 1, 91, 1, '2021-07-13 11:40:29', '2021-07-13 11:40:29'),
	(326, 2, 91, 0, '2021-07-13 11:40:29', '2021-07-13 11:40:29'),
	(327, 27, 91, 0, '2021-07-13 11:40:29', '2021-07-13 11:40:29'),
	(328, 1, 92, 1, '2021-07-13 11:40:41', '2021-07-13 11:40:41'),
	(329, 2, 92, 0, '2021-07-13 11:40:41', '2021-07-13 11:40:41'),
	(330, 27, 92, 0, '2021-07-13 11:40:41', '2021-07-13 11:40:41'),
	(331, 29, 1, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(332, 29, 2, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(333, 29, 3, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(334, 29, 4, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(335, 29, 5, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(336, 29, 6, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(337, 29, 7, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(338, 29, 8, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(339, 29, 9, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(340, 29, 10, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(341, 29, 11, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(342, 29, 12, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(343, 29, 15, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(344, 29, 16, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(345, 29, 17, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(346, 29, 18, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(347, 29, 19, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(348, 29, 20, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(349, 29, 21, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(350, 29, 22, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(351, 29, 23, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(352, 29, 24, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(353, 29, 25, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(354, 29, 26, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(355, 29, 27, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(356, 29, 28, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(357, 29, 81, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(358, 29, 82, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(359, 29, 83, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(360, 29, 84, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(361, 29, 85, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(362, 29, 38, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(363, 29, 39, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(364, 29, 40, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(365, 29, 41, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(366, 29, 66, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(367, 29, 67, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(368, 29, 68, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(369, 29, 69, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(370, 29, 73, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(371, 29, 74, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(372, 29, 75, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(373, 29, 76, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(374, 29, 77, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(375, 29, 78, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(376, 29, 79, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(377, 29, 80, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(378, 29, 86, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(379, 29, 87, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(380, 29, 89, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(381, 29, 90, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(382, 29, 91, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(383, 29, 92, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(384, 29, 88, 0, '2021-07-15 14:16:47', '2021-07-15 14:16:47'),
	(385, 1, 93, 1, '2021-08-24 07:50:55', '2021-08-24 07:50:55'),
	(386, 2, 93, 0, '2021-08-24 07:50:55', '2021-08-24 07:50:55'),
	(387, 27, 93, 0, '2021-08-24 07:50:55', '2021-08-24 07:50:55'),
	(388, 29, 93, 0, '2021-08-24 07:50:55', '2021-08-24 07:50:55'),
	(389, 1, 94, 1, '2021-08-24 13:50:25', '2021-08-24 13:50:25'),
	(390, 2, 94, 0, '2021-08-24 13:50:25', '2021-08-24 13:50:25'),
	(391, 27, 94, 0, '2021-08-24 13:50:25', '2021-08-24 13:50:25'),
	(392, 29, 94, 0, '2021-08-24 13:50:25', '2021-08-24 13:50:25'),
	(393, 1, 95, 1, '2021-08-24 13:50:40', '2021-08-24 13:50:40'),
	(394, 2, 95, 0, '2021-08-24 13:50:40', '2021-08-24 13:50:40'),
	(395, 27, 95, 0, '2021-08-24 13:50:40', '2021-08-24 13:50:40'),
	(396, 29, 95, 0, '2021-08-24 13:50:40', '2021-08-24 13:50:40'),
	(397, 1, 96, 1, '2021-08-30 14:01:34', '2021-08-30 14:01:34'),
	(398, 2, 96, 0, '2021-08-30 14:01:34', '2021-08-30 14:01:34'),
	(399, 27, 96, 0, '2021-08-30 14:01:34', '2021-08-30 14:01:34'),
	(400, 29, 96, 0, '2021-08-30 14:01:34', '2021-08-30 14:01:34'),
	(401, 1, 97, 1, '2021-08-31 07:38:38', '2021-08-31 07:38:38'),
	(402, 2, 97, 0, '2021-08-31 07:38:38', '2021-08-31 07:38:38'),
	(403, 27, 97, 0, '2021-08-31 07:38:38', '2021-08-31 07:38:38'),
	(404, 29, 97, 0, '2021-08-31 07:38:38', '2021-08-31 07:38:38'),
	(405, 1, 98, 1, '2021-08-31 07:38:59', '2021-08-31 07:38:59'),
	(406, 2, 98, 0, '2021-08-31 07:38:59', '2021-08-31 07:38:59'),
	(407, 27, 98, 0, '2021-08-31 07:38:59', '2021-08-31 07:38:59'),
	(408, 29, 98, 0, '2021-08-31 07:38:59', '2021-08-31 07:38:59'),
	(409, 1, 99, 1, '2021-08-31 07:39:15', '2021-08-31 07:39:15'),
	(410, 2, 99, 0, '2021-08-31 07:39:15', '2021-08-31 07:39:15'),
	(411, 27, 99, 0, '2021-08-31 07:39:15', '2021-08-31 07:39:15'),
	(412, 29, 99, 0, '2021-08-31 07:39:15', '2021-08-31 07:39:15'),
	(413, 1, 100, 1, '2021-08-31 07:39:44', '2021-08-31 07:39:44'),
	(414, 2, 100, 0, '2021-08-31 07:39:44', '2021-08-31 07:39:44'),
	(415, 27, 100, 0, '2021-08-31 07:39:44', '2021-08-31 07:39:44'),
	(416, 29, 100, 0, '2021-08-31 07:39:44', '2021-08-31 07:39:44'),
	(417, 1, 101, 1, '2021-08-31 07:39:58', '2021-08-31 07:39:58'),
	(418, 2, 101, 0, '2021-08-31 07:39:58', '2021-08-31 07:39:58'),
	(419, 27, 101, 0, '2021-08-31 07:39:58', '2021-08-31 07:39:58'),
	(420, 29, 101, 0, '2021-08-31 07:39:58', '2021-08-31 07:39:58'),
	(421, 1, 102, 1, '2021-08-31 07:40:26', '2021-08-31 07:40:26'),
	(422, 2, 102, 0, '2021-08-31 07:40:26', '2021-08-31 07:40:26'),
	(423, 27, 102, 0, '2021-08-31 07:40:26', '2021-08-31 07:40:26'),
	(424, 29, 102, 0, '2021-08-31 07:40:26', '2021-08-31 07:40:26'),
	(425, 1, 103, 1, '2021-08-31 07:41:30', '2021-08-31 07:41:30'),
	(426, 2, 103, 0, '2021-08-31 07:41:30', '2021-08-31 07:41:30'),
	(427, 27, 103, 0, '2021-08-31 07:41:30', '2021-08-31 07:41:30'),
	(428, 29, 103, 0, '2021-08-31 07:41:30', '2021-08-31 07:41:30'),
	(429, 1, 104, 1, '2021-08-31 07:41:41', '2021-08-31 07:41:41'),
	(430, 2, 104, 0, '2021-08-31 07:41:41', '2021-08-31 07:41:41'),
	(431, 27, 104, 0, '2021-08-31 07:41:41', '2021-08-31 07:41:41'),
	(432, 29, 104, 0, '2021-08-31 07:41:41', '2021-08-31 07:41:41'),
	(433, 1, 105, 1, '2021-10-01 13:13:14', '2021-10-01 13:13:14'),
	(434, 2, 105, 0, '2021-10-01 13:13:14', '2021-10-01 13:13:14'),
	(435, 27, 105, 0, '2021-10-01 13:13:14', '2021-10-01 13:13:14'),
	(436, 29, 105, 0, '2021-10-01 13:13:14', '2021-10-01 13:13:14'),
	(437, 1, 106, 1, '2021-12-18 05:59:08', '2021-12-18 05:59:08'),
	(438, 2, 106, 0, '2021-12-18 05:59:08', '2021-12-18 05:59:08'),
	(439, 27, 106, 0, '2021-12-18 05:59:08', '2021-12-18 05:59:08'),
	(440, 29, 106, 0, '2021-12-18 05:59:08', '2021-12-18 05:59:08'),
	(441, 1, 107, 1, '2021-12-18 06:00:23', '2021-12-18 06:00:23'),
	(442, 2, 107, 0, '2021-12-18 06:00:23', '2021-12-18 06:00:23'),
	(443, 27, 107, 0, '2021-12-18 06:00:23', '2021-12-18 06:00:23'),
	(444, 29, 107, 0, '2021-12-18 06:00:23', '2021-12-18 06:00:23'),
	(445, 1, 108, 1, '2021-12-18 06:00:35', '2021-12-18 06:00:35'),
	(446, 2, 108, 0, '2021-12-18 06:00:35', '2021-12-18 06:00:35'),
	(447, 27, 108, 0, '2021-12-18 06:00:35', '2021-12-18 06:00:35'),
	(448, 29, 108, 0, '2021-12-18 06:00:35', '2021-12-18 06:00:35'),
	(449, 1, 109, 1, '2021-12-18 06:00:44', '2021-12-18 06:00:44'),
	(450, 2, 109, 0, '2021-12-18 06:00:44', '2021-12-18 06:00:44'),
	(451, 27, 109, 0, '2021-12-18 06:00:44', '2021-12-18 06:00:44'),
	(452, 29, 109, 0, '2021-12-18 06:00:44', '2021-12-18 06:00:44'),
	(453, 1, 110, 1, '2021-12-18 06:00:58', '2021-12-18 06:00:58'),
	(454, 2, 110, 0, '2021-12-18 06:00:58', '2021-12-18 06:00:58'),
	(455, 27, 110, 0, '2021-12-18 06:00:58', '2021-12-18 06:00:58'),
	(456, 29, 110, 0, '2021-12-18 06:00:58', '2021-12-18 06:00:58'),
	(457, 1, 111, 1, '2021-12-18 06:01:11', '2021-12-18 06:01:11'),
	(458, 2, 111, 0, '2021-12-18 06:01:11', '2021-12-18 06:01:11'),
	(459, 27, 111, 0, '2021-12-18 06:01:11', '2021-12-18 06:01:11'),
	(460, 29, 111, 0, '2021-12-18 06:01:11', '2021-12-18 06:01:11'),
	(461, 1, 112, 1, '2021-12-18 06:01:28', '2021-12-18 06:01:28'),
	(462, 2, 112, 0, '2021-12-18 06:01:28', '2021-12-18 06:01:28'),
	(463, 27, 112, 0, '2021-12-18 06:01:28', '2021-12-18 06:01:28'),
	(464, 29, 112, 0, '2021-12-18 06:01:28', '2021-12-18 06:01:28'),
	(465, 1, 113, 1, '2021-12-18 06:01:37', '2021-12-18 06:01:37'),
	(466, 2, 113, 0, '2021-12-18 06:01:37', '2021-12-18 06:01:37'),
	(467, 27, 113, 0, '2021-12-18 06:01:37', '2021-12-18 06:01:37'),
	(468, 29, 113, 0, '2021-12-18 06:01:37', '2021-12-18 06:01:37'),
	(469, 1, 114, 1, '2022-01-19 03:06:40', '2022-01-19 03:06:40'),
	(470, 2, 114, 0, '2022-01-19 03:06:40', '2022-01-19 03:06:40'),
	(471, 27, 114, 0, '2022-01-19 03:06:40', '2022-01-19 03:06:40'),
	(472, 29, 114, 0, '2022-01-19 03:06:40', '2022-01-19 03:06:40'),
	(473, 1, 115, 1, '2022-02-18 05:17:13', '2022-02-18 05:17:13'),
	(474, 2, 115, 0, '2022-02-18 05:17:13', '2022-02-18 05:17:13'),
	(475, 27, 115, 0, '2022-02-18 05:17:13', '2022-02-18 05:17:13'),
	(476, 29, 115, 0, '2022-02-18 05:17:13', '2022-02-18 05:17:13'),
	(477, 1, 116, 1, '2022-02-18 05:17:37', '2022-02-18 05:17:37'),
	(478, 2, 116, 0, '2022-02-18 05:17:37', '2022-02-18 05:17:37'),
	(479, 27, 116, 0, '2022-02-18 05:17:37', '2022-02-18 05:17:37'),
	(480, 29, 116, 0, '2022-02-18 05:17:37', '2022-02-18 05:17:37'),
	(481, 1, 117, 1, '2022-02-25 02:02:46', '2022-02-25 02:02:46'),
	(482, 2, 117, 0, '2022-02-25 02:02:46', '2022-02-25 02:02:46'),
	(483, 27, 117, 0, '2022-02-25 02:02:46', '2022-02-25 02:02:46'),
	(484, 29, 117, 0, '2022-02-25 02:02:46', '2022-02-25 02:02:46'),
	(485, 1, 118, 1, '2022-03-04 09:07:07', '2022-03-04 09:07:07'),
	(486, 2, 118, 0, '2022-03-04 09:07:07', '2022-03-04 09:07:07'),
	(487, 27, 118, 0, '2022-03-04 09:07:07', '2022-03-04 09:07:07'),
	(488, 29, 118, 0, '2022-03-04 09:07:07', '2022-03-04 09:07:07');
/*!40000 ALTER TABLE `user_group_permissions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
