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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.actions: ~46 rows (approximately)
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
	(84, 'Batch Delete', 15, NULL, 1, '2021-07-07 12:55:12', '2021-07-07 12:55:12');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;

-- Dumping structure for table abpdb.batches
CREATE TABLE IF NOT EXISTS `batches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `batch_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `fees` double NOT NULL DEFAULT 0,
  `student_limit` tinyint(2) NOT NULL DEFAULT 0,
  `total_enrolled_student` tinyint(2) NOT NULL DEFAULT 0,
  `details` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `running_status` enum('Completed','Running','Upcoming') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Upcoming',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_batches_courses` (`course_id`),
  CONSTRAINT `FK_batches_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batches: ~0 rows (approximately)
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
INSERT INTO `batches` (`id`, `course_id`, `batch_name`, `start_date`, `end_date`, `fees`, `student_limit`, `total_enrolled_student`, `details`, `running_status`, `status`, `created_at`, `updated_at`) VALUES
	(1, 10, 'Batch001', '2021-10-01', '2021-09-30', 50000, 20, 0, NULL, 'Upcoming', 'Active', '2021-07-07 20:47:11', NULL);
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;

-- Dumping structure for table abpdb.batch_fees
CREATE TABLE IF NOT EXISTS `batch_fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` bigint(20) unsigned NOT NULL,
  `plan_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_installment` tinyint(2) NOT NULL DEFAULT 1,
  `installment_duration` tinyint(2) NOT NULL DEFAULT 0,
  `payable_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `payment_type` enum('Installment','Onetime') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Onetime',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_batch_fees_batches` (`batch_id`),
  CONSTRAINT `FK_batch_fees_batches` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_fees: ~2 rows (approximately)
/*!40000 ALTER TABLE `batch_fees` DISABLE KEYS */;
INSERT INTO `batch_fees` (`id`, `batch_id`, `plan_name`, `total_installment`, `installment_duration`, `payable_amount`, `payment_type`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, '', 1, 0, 50000.00, 'Onetime', 'Active', NULL, NULL),
	(2, 1, '', 3, 4, 54.00, 'Installment', 'Active', NULL, NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.batch_fees_details: ~0 rows (approximately)
/*!40000 ALTER TABLE `batch_fees_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `batch_fees_details` ENABLE KEYS */;

-- Dumping structure for table abpdb.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.courses: ~3 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` (`id`, `level_id`, `code`, `title`, `short_name`, `trainers`, `accredited_by`, `awarder_by`, `programme_duration`, `course_cover_image`, `semester_no`, `semester_details`, `assessment`, `grading_system`, `course_profile_image`, `objective`, `requirements`, `experience_required`, `youtube_video_link`, `tqt`, `glh`, `total_credit_hour`, `registration_fees`, `status`, `study_mode`, `created_at`, `updated_at`) VALUES
	(9, 1, 'Q2021001', 'PGDHRM', '', NULL, NULL, NULL, NULL, NULL, 1, '1', '1', '1', NULL, '', '', '', '', 600, 0, 30, 500.00, 'Active', 'Online', '2021-06-22 13:19:12', '2021-07-05 12:52:54'),
	(10, 1, 'PGDFinance', 'PGDFinance', '', NULL, NULL, NULL, NULL, NULL, 1, '1', '1', '1', NULL, '', '', '', '', 340, 0, 30, 20.00, 'Active', 'Online', '2021-07-05 12:53:43', '2021-07-05 12:53:51'),
	(12, 12, '100001', 'Asssasasa as asdas dsdasd asd d HH', 'ASD', 'Trainers HH', '<p>Accredited HH</p>', 'Awarder HH', '4-12 Months HH', NULL, 4, '<p>Semester Details HH</p>', '<p>Assesment HH</p>', '<p>Grading System HH</p>', '1625568790.jpg', '<p>HHHHHHHHHHHHHHHHHHHH DD</p>', '<p>Requirements HH</p>', '<p>Experience Required HH</p>', 'youtube HH', 340, 70, 70, 20.00, 'Active', 'Campus', '2021-07-06 09:48:11', '2021-07-07 12:43:33');
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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.courses_units: ~6 rows (approximately)
/*!40000 ALTER TABLE `courses_units` DISABLE KEYS */;
INSERT INTO `courses_units` (`id`, `unit_id`, `course_id`, `status`, `type`, `created_at`, `updated_at`) VALUES
	(47, 23, 9, 'Active', 'Optional', '2021-07-05 12:52:54', '2021-07-05 12:52:54'),
	(48, 24, 9, 'Active', 'Optional', '2021-07-05 12:52:54', '2021-07-05 12:52:54'),
	(51, 23, 10, 'Active', 'Optional', '2021-07-05 12:53:51', '2021-07-05 12:53:51'),
	(52, 24, 10, 'Active', 'Optional', '2021-07-05 12:53:51', '2021-07-05 12:53:51'),
	(75, 23, 12, 'Active', 'Optional', '2021-07-07 12:43:33', '2021-07-07 12:43:33'),
	(76, 24, 12, 'Active', 'Optional', '2021-07-07 12:43:33', '2021-07-07 12:43:33');
/*!40000 ALTER TABLE `courses_units` ENABLE KEYS */;

-- Dumping structure for table abpdb.expenses
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `expense_head_id` bigint(20) DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('Due','Partial','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Due',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.expenses: ~3 rows (approximately)
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` (`id`, `expense_head_id`, `amount`, `details`, `attachment`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1500.00, 'Electric bill for the month of June 2021', 'assets/images/expense/1625575679.png', 'Paid', 'Active', '2021-07-06 12:47:59', '2021-07-06 12:47:59'),
	(2, 2, 650.00, 'sdasdsd', 'green.png1625585896.png', 'Paid', 'Active', '2021-07-06 15:38:16', '2021-07-06 15:38:16'),
	(6, 3, 102.00, 'ss', '1625728575.jpg', 'Paid', 'Active', '2021-07-06 15:48:06', '2021-07-08 07:16:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.expense_heads: ~3 rows (approximately)
/*!40000 ALTER TABLE `expense_heads` DISABLE KEYS */;
INSERT INTO `expense_heads` (`id`, `expense_head_name`, `expense_category_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Monthly Electric bill', 2, 'Active', '2021-07-06 12:41:47', '2021-07-06 12:58:21'),
	(2, 'Monthly Gas Bill', 3, 'Active', '2021-07-06 12:43:20', '2021-07-06 12:58:18'),
	(3, 'Electric repair bill', 2, 'Active', '2021-07-06 12:43:43', '2021-07-06 12:58:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.expnese_categories: ~3 rows (approximately)
/*!40000 ALTER TABLE `expnese_categories` DISABLE KEYS */;
INSERT INTO `expnese_categories` (`id`, `category_name`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'BILL', NULL, 'Active', NULL, NULL),
	(2, 'Electric Bill', 1, 'Active', '2021-07-06 12:32:51', '2021-07-06 13:00:31'),
	(3, 'Gas Bill', 1, 'Active', '2021-07-06 12:33:07', '2021-07-06 12:54:52');
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.menus: ~19 rows (approximately)
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`id`, `module_name`, `menu_title`, `menu_url`, `parent_id`, `serial_no`, `menu_icon_class`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'Users', 'Users', '', 0, 6, 'pe-7s-users', 1, NULL, NULL),
	(5, 'Users', 'Admin Users', 'user/admin/admin-user-management?type=Admin', 4, 1, NULL, 1, NULL, NULL),
	(6, 'Users', 'Center Users', 'user/admin/admin-user-management?type=Center', 4, 2, NULL, 1, NULL, NULL),
	(7, 'Cpanel', 'Control Panel', '', 0, 8, 'pe-7s-tools', 1, NULL, NULL),
	(8, 'Settings', 'General Setting', 'settings/general/general-setting', 11, 1, NULL, 1, NULL, NULL),
	(9, 'Cpanel', 'Menus/Moduls', 'cp/module/manage-module', 7, 2, NULL, 1, NULL, NULL),
	(10, 'Cpanel', 'Actions', 'cp/web-action/web-action-management', 7, 3, NULL, 1, NULL, NULL),
	(11, 'Settings', 'Settings', '', 0, 7, 'pe-7s-settings', 1, NULL, NULL),
	(14, 'Settings', 'User Groups', 'settings/admin/admin-group-management', 11, 2, NULL, 1, '2020-04-10 10:58:01', '2020-04-10 10:58:01'),
	(15, 'Courses', 'Courses', '', 0, 1, 'pe-7s-notebook', 1, '2021-03-21 06:57:45', '2021-03-21 06:57:45'),
	(17, 'Courses', 'Courses', 'course', 15, 2, NULL, 1, '2021-03-21 07:05:46', '2021-03-21 07:05:46'),
	(18, 'Units', 'Units', 'unit', 15, 3, NULL, 1, '2021-03-21 07:06:31', '2021-03-21 07:06:31'),
	(19, 'Students', 'Students', 'student', 0, 2, 'pe-7s-add-user', 1, '2021-03-23 18:40:06', '2021-03-23 18:40:06'),
	(22, 'Dashboard', 'Dashboard', '', 0, NULL, NULL, 1, '2021-04-10 15:52:11', '2021-04-10 15:52:11'),
	(28, 'Expenses', 'Expenses', '', 0, 4, 'pe-7s-cash', 1, '2021-06-12 07:35:56', '2021-06-12 07:35:56'),
	(29, 'Expense Category', 'Expense Category', 'expense/expense-category', 28, 3, NULL, 1, '2021-06-12 07:42:11', '2021-06-12 07:43:50'),
	(33, 'Expense Head', 'Expense Head', 'expense/expense-head', 28, 2, NULL, 1, '2021-07-06 12:20:14', '2021-07-06 12:20:14'),
	(34, 'Expenses', 'Expenses', 'expense/expense', 28, 1, NULL, 1, '2021-07-06 12:20:27', '2021-07-06 12:20:27'),
	(35, 'Batches', 'Batches', 'batch', 15, 1, NULL, 1, '2021-07-07 12:53:58', '2021-07-07 12:53:58');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Dumping structure for table abpdb.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.migrations: ~5 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(8, '2016_06_01_000001_create_oauth_auth_codes_table', 8),
	(9, '2016_06_01_000002_create_oauth_access_tokens_table', 8),
	(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 8),
	(11, '2016_06_01_000004_create_oauth_clients_table', 8),
	(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 8),
	(29, '2021_06_12_074741_create_expnese_categories_table', 9);
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

-- Dumping data for table abpdb.notifications: ~12 rows (approximately)
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('210d4701-7e56-4176-9fcd-8d978d3c4756', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{"Type":"Success","Message":"A new registration request waiting for approval from BOGURA HUB"}', '2021-04-10 04:54:23', '2021-04-05 18:08:27', '2021-04-10 04:54:23'),
	('353044f9-4cfd-4cc0-a94e-58a08e2b622d', 'App\\Notifications\\CertificateClaim', 'App\\User', 1, '{"Type":"Success","Message":"1 new certificate has been claimed by BOGURA HUB"}', '2021-04-10 02:12:14', '2021-04-06 06:41:31', '2021-04-10 02:12:14'),
	('45077fe1-b57a-4c21-aaef-3a2f9379318f', 'App\\Notifications\\RegistrationRequest', 'App\\User', 6, '{"type":"Success","Message":"Registration #2104000023 has been approved by Edupro"}', '2021-04-15 18:42:47', '2021-04-15 18:42:08', '2021-04-15 18:42:47'),
	('57b8abbe-cba1-46bc-8bdd-a3b7fa4f8199', 'App\\Notifications\\CertificateClaim', 'App\\User', 6, '{"Type":"Success","Message":" Certificate has been provided for Momit Hasan"}', '2021-04-17 10:29:47', '2021-04-15 18:45:32', '2021-04-17 10:29:47'),
	('5987468f-c6e7-40a3-9ee4-c166493a4cd9', 'App\\Notifications\\CertificateClaim', 'App\\User', 6, '{"Type":"Success","Message":" Certificate has been provided for Muniff Hasann"}', '2021-04-10 05:47:45', '2021-04-06 07:02:07', '2021-04-10 05:47:45'),
	('67714df6-a72c-4da4-a94e-cb7023edd3cb', 'App\\Notifications\\RegistrationRequest', 'App\\User', 6, '{"Type":"Success","Message":"Registration #2104000020 has been approved by Edupro"}', '2021-04-10 05:47:45', '2021-04-05 18:31:39', '2021-04-10 05:47:45'),
	('685dd847-5376-4950-944b-ab2fccbac413', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{"Type":"Success","Message":"A new registration request waiting for approval from BOGURA HUB"}', '2021-04-10 02:12:14', '2021-04-05 18:18:33', '2021-04-10 02:12:14'),
	('73c94e6b-e46f-4391-8339-83b6368218c7', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{"type":"Success","Message":"A new registration request waiting for approval from BOGURA HUB"}', '2021-04-15 18:37:52', '2021-04-15 18:37:20', '2021-04-15 18:37:52'),
	('a493dcc1-29fb-40f4-86fc-bb40b618e4d8', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{"Type":"Success","Message":"A new registration request waiting for approval from BOGURA HUB"}', '2021-04-10 02:08:43', '2021-04-05 18:31:17', '2021-04-10 02:08:43'),
	('c0cb0510-9802-41af-b367-56c4920a45a6', 'App\\Notifications\\CertificateClaim', 'App\\User', 1, '{"Type":"Success","Message":"1 new certificate has been claimed by BOGURA HUB"}', '2021-04-10 05:01:33', '2021-04-06 06:39:38', '2021-04-10 05:01:33'),
	('ccfbf903-f49c-4176-a1a4-9f2f7abd4d68', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{"Type":"Success","Message":"A new registration request waiting for approval"}', '2021-04-10 02:08:43', '2021-04-05 18:04:18', '2021-04-10 02:08:43'),
	('fe685c13-b00f-40b4-aa0f-c817fbff3c58', 'App\\Notifications\\CertificateClaim', 'App\\User', 1, '{"Type":"Success","Message":"2 new certificate has been claimed by BOGURA HUB"}', '2021-04-15 18:43:22', '2021-04-15 18:43:06', '2021-04-15 18:43:22');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;

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

-- Dumping structure for table abpdb.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `company_name`, `short_name`, `site_name`, `admin_email`, `admin_mobile`, `site_url`, `admin_url`, `logo`, `address`, `created_at`, `updated_at`) VALUES
	(1, 'ABP BD', 'ABP', 'ABPBD', 'admin@abpbd.com', '45455', NULL, NULL, 'logo-inverse.png', 'sdfsd f, sdf sdf', NULL, '2021-06-08 06:20:17');
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
  `date_of_birth` date NOT NULL,
  `user_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `study_mode` enum('Online','Campus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Online',
  `type` enum('Enrolled','Non-enrolled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Non-enrolled',
  `current_emplyment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_qualification` enum('Masters bachelor','Others') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Masters bachelor',
  `how_know` enum('From a Trainee of ABP','From FaceBook','By google search',' From office colleague','From Email','Other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'From a Trainee of ABP',
  `passing_year` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `contact_no` (`contact_no`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.students: ~2 rows (approximately)
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` (`id`, `name`, `student_no`, `email`, `contact_no`, `emergency_contact`, `address`, `nid_no`, `date_of_birth`, `user_profile_image`, `remarks`, `status`, `study_mode`, `type`, `current_emplyment`, `last_qualification`, `how_know`, `passing_year`, `created_at`, `updated_at`) VALUES
	(21, 'Muniff', '00500006', 'munif@gmail.com', '6546468', '', 'dhaka', '123313131231', '2021-06-25', '', 'sdr fsfsfsdff', 'Active', 'Online', 'Non-enrolled', NULL, 'Masters bachelor', 'From a Trainee of ABP', NULL, '2021-06-21 09:46:55', '2021-06-21 10:02:27'),
	(28, 'Muntakim hasan', '00500007', 'muntakim@gmail.com', '8646485', '78764453', 'dhaka', '6497846', '2021-07-28', '1625479466.jpg', ' sdf hfsdj fhsdkfh sdnfhkl sdf', 'Active', 'Online', 'Non-enrolled', NULL, 'Masters bachelor', 'From a Trainee of ABP', '2000-05-14', '2021-07-05 07:24:16', '2021-07-05 10:04:26');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

-- Dumping structure for table abpdb.student_documents
CREATE TABLE IF NOT EXISTS `student_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table abpdb.student_documents: ~6 rows (approximately)
/*!40000 ALTER TABLE `student_documents` DISABLE KEYS */;
INSERT INTO `student_documents` (`id`, `student_id`, `document_name`, `type`) VALUES
	(5, 28, 'avatar-1.jpg1625469856.jpg', 'jpg'),
	(9, 28, 'avatar-3.jpg1625481872.jpg', 'jpg'),
	(18, 28, 'avatar-1.jpg1625724018.jpg', 'jpg'),
	(19, 28, 'avatar-2.jpg1625724018.jpg', 'jpg'),
	(20, 28, 'bg_3.png1625724018.png', 'png'),
	(21, 28, 'bg_4.png1625724018.png', 'png');
/*!40000 ALTER TABLE `student_documents` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.units: ~2 rows (approximately)
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` (`id`, `unit_code`, `name`, `glh`, `credit_hour`, `tut`, `assessment_type`, `status`, `created_at`, `updated_at`) VALUES
	(23, 'EPU 170457', 'Unit name 1', '40', 10, 100, 'Internal', 'Active', '2021-06-22 07:24:17', '2021-06-22 07:28:15'),
	(24, 'EPU 170458', 'Unit Name 2', '30', 10, 200, 'Internal', 'Active', '2021-06-22 07:48:57', '2021-06-22 07:48:57');
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_profile_image`, `contact_no`, `remarks`, `student_id`, `status`, `type`, `login_status`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Momit', 'Hasan', 'momit@technolife.ee', '1616308888.jpg', '74645564654', NULL, NULL, 1, 'Admin', 0, '$2y$10$mIW4VQ9btgEIsWKD6AnDeOD8ysMvPIQ7JQXFDmnYr35NpvXKlpHv2', NULL, 'SMtmLpUM16y4huaPsaUd9rfMSjot9MMq1TW5jbBvQiMFslalsf39p22pq0nd', '2021-06-07 12:50:15', '2021-07-08 05:38:08'),
	(23, 'Muniff', 'Hasannn', 'munif@gmail.com', NULL, '6546468', 'sdr fsfsfsdff', 21, 0, 'Student', 0, '$2y$10$QQmSPi5wO7aCRjyxbu.6je640APp9Y7.McASuZrhyFmQPpWorDTIu', NULL, NULL, '2021-06-21 09:46:55', '2021-06-21 10:02:27'),
	(24, 'Muntakim hasan', NULL, 'muntakim@gmail.com', '1625479466.jpg', '8646485', 'sdf hfsdj fhsdkfh sdnfhkl sdf', 28, 0, 'Student', 0, '$2y$10$UGgEOhSogRTdSwF9ymuwGu1QIXybBNS2akRAfQKK0AABANMJBXQsS', NULL, NULL, '2021-07-05 07:24:16', '2021-07-08 06:00:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_groups: ~4 rows (approximately)
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` (`id`, `group_name`, `type`, `status`, `editable`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 1, 1, 0, NULL, NULL),
	(2, 'Admin', 1, 1, 1, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(27, 'Student', 2, 1, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_group_members: ~6 rows (approximately)
/*!40000 ALTER TABLE `user_group_members` DISABLE KEYS */;
INSERT INTO `user_group_members` (`id`, `user_id`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, NULL, NULL),
	(4, 1, 2, 0, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(5, 1, 27, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(23, 23, 27, 1, '2021-06-21 09:46:55', '2021-06-21 09:46:55'),
	(24, 24, 27, 1, '2021-07-05 07:24:16', '2021-07-05 07:24:16');
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
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_group_permissions: ~109 rows (approximately)
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
	(306, 27, 84, 0, '2021-07-07 12:55:12', '2021-07-07 12:55:12');
/*!40000 ALTER TABLE `user_group_permissions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
