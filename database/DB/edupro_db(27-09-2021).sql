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

-- Dumping structure for table edupro.actions
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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.actions: ~47 rows (approximately)
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
	(25, 'Qualification Management', 15, 17, 1, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(26, 'Qualification Entry', 15, NULL, 1, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(27, 'Qualification Update', 15, NULL, 1, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(28, 'Qualification Delete', 15, NULL, 1, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(29, 'Center Management', 16, 16, 1, '2021-03-23 05:00:11', '2021-03-23 05:00:11'),
	(30, 'Center Entry', 16, NULL, 1, '2021-03-23 05:00:25', '2021-03-23 05:00:25'),
	(31, 'Center Update', 16, NULL, 1, '2021-03-23 05:00:32', '2021-03-23 05:00:32'),
	(32, 'Center Delete', 16, NULL, 1, '2021-03-23 05:00:39', '2021-03-23 05:00:39'),
	(34, 'Center User Management', 4, 6, 1, '2021-03-23 14:31:42', '2021-03-23 14:31:42'),
	(35, 'Center User Entry', 4, NULL, 1, '2021-03-23 14:32:49', '2021-03-23 14:32:49'),
	(36, 'Center User update', 4, NULL, 1, '2021-03-23 14:32:57', '2021-03-23 14:32:57'),
	(37, 'Center User Delete', 4, NULL, 1, '2021-03-23 14:33:06', '2021-03-23 14:33:06'),
	(38, 'Learner Management', 19, 19, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(39, 'Learner Entry', 19, NULL, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(40, 'Learner Update', 19, NULL, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(41, 'Learner Delete', 19, NULL, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(42, 'Learner Update (registration comple)', 19, NULL, 1, '2021-03-23 18:42:00', '2021-03-23 18:42:00'),
	(43, 'Registration management', 20, 20, 1, '2021-03-24 16:39:06', '2021-03-24 16:39:06'),
	(44, 'Registration Entry', 20, NULL, 1, '2021-03-24 16:39:28', '2021-03-24 16:39:28'),
	(45, 'Registration Update', 20, NULL, 1, '2021-03-24 16:39:34', '2021-03-24 16:39:34'),
	(46, 'Registration Delete', 20, NULL, 1, '2021-03-24 16:39:42', '2021-03-24 16:39:42'),
	(47, 'qualification View', 17, NULL, 1, '2021-03-24 20:58:34', '2021-03-24 20:58:34'),
	(48, 'Transcript View', 20, NULL, 1, '2021-03-25 13:07:56', '2021-03-25 13:07:56'),
	(50, 'Transcript Entry', 20, NULL, 1, '2021-03-26 10:04:05', '2021-03-26 10:04:05'),
	(51, 'Claim Cirtificate', 20, NULL, 1, '2021-03-26 17:44:54', '2021-03-26 17:44:54'),
	(52, 'Cirtificate Management', 21, 21, 1, '2021-03-26 18:47:46', '2021-03-26 18:47:46'),
	(53, 'Cirtificate Entry', 21, NULL, 1, '2021-03-26 18:47:59', '2021-03-26 18:47:59');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;

-- Dumping structure for table edupro.centers
CREATE TABLE IF NOT EXISTS `centers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proprietor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liaison_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liaison_office_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agreed_minimum_invoice` double(8,2) NOT NULL,
  `date_of_approval` date DEFAULT NULL,
  `date_of_review` date DEFAULT NULL,
  `approval_status` enum('Pending','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `registration_fees` double(8,2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.centers: ~2 rows (approximately)
/*!40000 ALTER TABLE `centers` DISABLE KEYS */;
INSERT INTO `centers` (`id`, `code`, `name`, `short_name`, `address`, `proprietor_name`, `mobile_no`, `liaison_office`, `liaison_office_address`, `email`, `agreed_minimum_invoice`, `date_of_approval`, `date_of_review`, `approval_status`, `registration_fees`, `status`, `created_at`, `updated_at`) VALUES
	(5, '00001', 'BOGURA HUB', 'BOG', 'bogra', 'Momit', '01980340482', 'Dhaka', 'mdpur, Dhaka', 'momit.litu@gmail.com', 12000.00, '2021-03-23', '2021-03-21', 'Pending', 0.00, 'Active', '2021-03-23 09:46:38', '2021-03-23 17:28:47');
/*!40000 ALTER TABLE `centers` ENABLE KEYS */;

-- Dumping structure for table edupro.center_qualifications
CREATE TABLE IF NOT EXISTS `center_qualifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `center_id` bigint(20) unsigned NOT NULL,
  `qualification_id` bigint(20) unsigned NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `center_qualifications_center_id_foreign` (`center_id`),
  KEY `center_qualifications_qualification_id_foreign` (`qualification_id`),
  CONSTRAINT `center_qualifications_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`),
  CONSTRAINT `center_qualifications_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `qualifications` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.center_qualifications: ~2 rows (approximately)
/*!40000 ALTER TABLE `center_qualifications` DISABLE KEYS */;
INSERT INTO `center_qualifications` (`id`, `center_id`, `qualification_id`, `status`, `created_at`, `updated_at`) VALUES
	(45, 5, 1, 'Active', '2021-03-23 17:28:47', '2021-03-23 17:28:47'),
	(46, 5, 3, 'Active', '2021-03-23 17:28:47', '2021-03-23 17:28:47');
/*!40000 ALTER TABLE `center_qualifications` ENABLE KEYS */;

-- Dumping structure for table edupro.learners
CREATE TABLE IF NOT EXISTS `learners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `center_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `learners_center_id_foreign` (`center_id`),
  CONSTRAINT `learners_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.learners: ~3 rows (approximately)
/*!40000 ALTER TABLE `learners` DISABLE KEYS */;
INSERT INTO `learners` (`id`, `first_name`, `last_name`, `email`, `contact_no`, `address`, `nid_no`, `user_profile_image`, `remarks`, `status`, `created_at`, `updated_at`, `center_id`) VALUES
	(2, 'Momit', 'Hasan', 'momit.litu@gmail.com', '01980340482', 'dhaka', '1231231', '1616534295.jpg', NULL, 'Active', NULL, '2021-03-23 21:18:15', 5),
	(5, 'Muniff', 'Hasann', 'momit.lssitu@gmail.com', '0198034', 'agrabad, chitagong', '454554', '1616534286.jpg', 'fdg dfgdfgdfgdg', 'Active', '2021-03-23 20:16:57', '2021-03-23 21:18:06', 5),
	(6, 'Litu', 'Hasan', 'momfgit@bils.com', '01980340482', 'sdf gdfgdfgdfbg hg hgh', '1231231', '', 'dfgdfgdfgdfgdfgdfgdfg', 'Active', '2021-03-23 21:48:35', '2021-03-23 21:48:35', 5);
/*!40000 ALTER TABLE `learners` ENABLE KEYS */;

-- Dumping structure for table edupro.learner_results
CREATE TABLE IF NOT EXISTS `learner_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_learner_id` bigint(20) unsigned NOT NULL,
  `unit_id` bigint(20) unsigned NOT NULL,
  `result` enum('NA','F','P','M','D') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NA' COMMENT 'NA:Not Available,F:failed, P:pass, M:marit, D:Distinction',
  `passed` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `learner_results_registration_learner_id_foreign` (`registration_learner_id`),
  KEY `learner_results_unit_id_foreign` (`unit_id`),
  CONSTRAINT `learner_results_registration_learner_id_foreign` FOREIGN KEY (`registration_learner_id`) REFERENCES `registration_learners` (`id`),
  CONSTRAINT `learner_results_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.learner_results: ~27 rows (approximately)
/*!40000 ALTER TABLE `learner_results` DISABLE KEYS */;
INSERT INTO `learner_results` (`id`, `registration_learner_id`, `unit_id`, `result`, `passed`, `created_at`, `updated_at`) VALUES
	(10, 1, 1, 'NA', 'No', '2021-03-26 08:12:33', '2021-03-26 08:12:33'),
	(11, 1, 2, 'NA', 'No', '2021-03-26 08:12:33', '2021-03-26 08:12:33'),
	(12, 2, 1, 'NA', 'No', '2021-03-26 08:12:33', '2021-03-26 08:12:33'),
	(13, 2, 2, 'NA', 'No', '2021-03-26 08:12:33', '2021-03-26 08:12:33'),
	(14, 3, 1, 'NA', 'No', '2021-03-26 08:12:33', '2021-03-26 08:12:33'),
	(15, 3, 2, 'NA', 'No', '2021-03-26 08:12:33', '2021-03-26 08:12:33'),
	(16, 17, 11, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:29:56'),
	(17, 17, 12, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:37:34'),
	(18, 17, 13, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:37:34'),
	(19, 17, 14, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:37:34'),
	(20, 17, 15, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:37:34'),
	(21, 17, 16, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:37:34'),
	(22, 17, 17, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 14:37:34'),
	(23, 18, 11, 'NA', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(24, 18, 12, 'NA', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(25, 18, 13, 'NA', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(26, 18, 14, 'NA', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(27, 18, 15, 'NA', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(28, 18, 16, 'NA', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(29, 18, 17, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:24:34'),
	(30, 19, 11, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(31, 19, 12, 'P', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(32, 19, 13, 'M', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(33, 19, 14, 'F', 'No', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(34, 19, 15, 'M', 'Yes', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(35, 19, 16, 'F', 'No', '2021-03-26 09:38:06', '2021-03-26 18:17:43'),
	(36, 19, 17, 'F', 'No', '2021-03-26 09:38:06', '2021-03-26 18:27:36');
/*!40000 ALTER TABLE `learner_results` ENABLE KEYS */;

-- Dumping structure for table edupro.levels
CREATE TABLE IF NOT EXISTS `levels` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table edupro.levels: ~12 rows (approximately)
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
INSERT INTO `levels` (`id`, `name`) VALUES
	(1, '01'),
	(2, '02'),
	(3, '03'),
	(4, '04'),
	(5, '05'),
	(6, '06'),
	(7, '07'),
	(8, '08'),
	(9, '09'),
	(10, '10'),
	(11, '11'),
	(12, '12');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;

-- Dumping structure for table edupro.menus
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.menus: ~14 rows (approximately)
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` (`id`, `module_name`, `menu_title`, `menu_url`, `parent_id`, `serial_no`, `menu_icon_class`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'Users', 'Users', '', 0, 6, 'clip-users ', 1, NULL, NULL),
	(5, 'Users', 'Admin Users', 'user/admin/admin-user-management?type=Admin', 4, 1, NULL, 1, NULL, NULL),
	(6, 'Users', 'Center Users', 'user/admin/admin-user-management?type=Center', 4, 2, NULL, 1, NULL, NULL),
	(7, 'Cpanel', 'Control Panel', '', 0, 8, 'clip-settings', 1, NULL, NULL),
	(8, 'Settings', 'General Setting', 'settings/general/general-setting', 11, 1, NULL, 1, NULL, NULL),
	(9, 'Cpanel', 'Menus/Moduls', 'cp/module/manage-module', 7, 2, NULL, 1, NULL, NULL),
	(10, 'Cpanel', 'Actions', 'cp/web-action/web-action-management', 7, 3, NULL, 1, NULL, NULL),
	(11, 'Settings', 'Settings', '', 0, 7, 'clip-wrench-2', 1, NULL, NULL),
	(14, 'Settings', 'User Groups', 'settings/admin/admin-group-management', 11, 2, NULL, 1, '2020-04-10 10:58:01', '2020-04-10 10:58:01'),
	(15, 'Qualifications', 'Qualifications', '', 0, 2, 'clip-book', 1, '2021-03-21 06:57:45', '2021-03-21 06:57:45'),
	(16, 'Centers', 'Centers', 'center', 0, 1, 'clip-spinner-3 ', 1, '2021-03-21 07:02:17', '2021-03-21 07:02:17'),
	(17, 'Qualifications', 'Qualifications', 'qualification', 15, 1, NULL, 1, '2021-03-21 07:05:46', '2021-03-21 07:05:46'),
	(18, 'Units', 'Units', 'unit', 15, 2, NULL, 1, '2021-03-21 07:06:31', '2021-03-21 07:06:31'),
	(19, 'Learners', 'Learners', 'learner', 0, 3, 'clip-users-2', 1, '2021-03-23 18:40:06', '2021-03-23 18:40:06'),
	(20, 'Registration', 'Registration', 'registration', 0, 4, 'clip-map', 1, '2021-03-24 16:36:13', '2021-03-24 16:36:13'),
	(21, 'Cirtificates', 'Cirtificates', 'cirtificate', 0, 5, 'clip-target', 1, '2021-03-26 18:47:22', '2021-03-26 18:47:22');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Dumping structure for table edupro.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.migrations: ~22 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2020_04_07_073247_adminuser', 1),
	(2, '2020_04_07_092133_settings', 2),
	(3, '2020_04_07_101343_menus', 3),
	(4, '2020_04_08_064731_actions', 4),
	(5, '2020_04_08_070604_user_groups', 5),
	(6, '2020_04_08_071239_user_group_members', 6),
	(7, '2020_04_08_071654_user_group_permissions', 7),
	(8, '2016_06_01_000001_create_oauth_auth_codes_table', 8),
	(9, '2016_06_01_000002_create_oauth_access_tokens_table', 8),
	(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 8),
	(11, '2016_06_01_000004_create_oauth_clients_table', 8),
	(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 8),
	(13, '2021_03_21_073934_create_units_table', 9),
	(14, '2021_03_21_165920_create_level_table', 10),
	(15, '2021_03_21_171152_create_qualifications_table', 11),
	(16, '2021_03_21_173906_create_qualification_units_table', 12),
	(17, '2021_03_23_043034_create_centers_table', 13),
	(18, '2021_03_23_044522_create_center_qualifications_table', 14),
	(20, '2021_03_23_184805_create_learners_table', 15),
	(21, '2021_03_24_164359_create_registrations_table', 16),
	(24, '2021_03_24_174402_create_registration_learners_table', 17),
	(25, '2021_03_25_132315_create_learner_results_table', 17);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table edupro.oauth_access_tokens
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

-- Dumping data for table edupro.oauth_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- Dumping structure for table edupro.oauth_auth_codes
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

-- Dumping data for table edupro.oauth_auth_codes: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- Dumping structure for table edupro.oauth_clients
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

-- Dumping data for table edupro.oauth_clients: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- Dumping structure for table edupro.oauth_personal_access_clients
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.oauth_personal_access_clients: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- Dumping structure for table edupro.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.oauth_refresh_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- Dumping structure for table edupro.qualifications
CREATE TABLE IF NOT EXISTS `qualifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tqt` int(11) NOT NULL,
  `registration_fees` double(8,2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualifications_level_id_foreign` (`level_id`),
  CONSTRAINT `qualifications_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.qualifications: ~4 rows (approximately)
/*!40000 ALTER TABLE `qualifications` DISABLE KEYS */;
INSERT INTO `qualifications` (`id`, `level_id`, `code`, `title`, `tqt`, `registration_fees`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, '0001', 'qualification title 01', 120, 2000.00, 'Active', NULL, NULL),
	(2, 6, '0002', 'sfsd sdf sd kuhsduhof oshjdoif jsdfoiusdhf', 150, 8550.00, 'Active', '2021-03-21 19:32:35', '2021-03-21 19:32:35'),
	(3, 12, '0003', '3rd qualification', 55, 444.00, 'Active', '2021-03-21 22:03:52', '2021-03-25 14:33:35'),
	(4, 1, '0004', 'Higher Diploma in IT', 200, 50.00, 'Active', '2021-03-26 09:31:24', '2021-03-26 09:31:24');
/*!40000 ALTER TABLE `qualifications` ENABLE KEYS */;

-- Dumping structure for table edupro.qualification_units
CREATE TABLE IF NOT EXISTS `qualification_units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` bigint(20) unsigned NOT NULL,
  `qualification_id` bigint(20) unsigned NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `type` enum('Optional','Mandatory') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Optional',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_units_unit_id_foreign` (`unit_id`),
  KEY `qualification_units_qualification_id_foreign` (`qualification_id`),
  CONSTRAINT `qualification_units_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `qualifications` (`id`),
  CONSTRAINT `qualification_units_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.qualification_units: ~10 rows (approximately)
/*!40000 ALTER TABLE `qualification_units` DISABLE KEYS */;
INSERT INTO `qualification_units` (`id`, `unit_id`, `qualification_id`, `status`, `type`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Active', 'Optional', NULL, NULL),
	(13, 1, 3, 'Active', 'Mandatory', '2021-03-25 14:33:35', '2021-03-25 14:33:35'),
	(14, 2, 3, 'Active', 'Optional', '2021-03-25 14:33:35', '2021-03-25 14:33:35'),
	(15, 11, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24'),
	(16, 12, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24'),
	(17, 13, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24'),
	(18, 14, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24'),
	(19, 15, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24'),
	(20, 16, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24'),
	(21, 17, 4, 'Active', 'Optional', '2021-03-26 09:31:24', '2021-03-26 09:31:24');
/*!40000 ALTER TABLE `qualification_units` ENABLE KEYS */;

-- Dumping structure for table edupro.registrations
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_fees` double(8,2) NOT NULL,
  `fees_paid_amount` double(8,2) NOT NULL,
  `center_registration_date` char(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT curdate(),
  `ep_registration_date` date DEFAULT NULL,
  `result_claim_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `approval_status` enum('Initiated','Requested','Approved','Rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Initiated',
  `payment_status` enum('Due','Paid','Partial') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Due',
  `remarks` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `center_id` bigint(20) unsigned NOT NULL,
  `qualification_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_center_id_foreign` (`center_id`),
  KEY `registrations_qualification_id_foreign` (`qualification_id`),
  CONSTRAINT `registrations_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`),
  CONSTRAINT `registrations_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `qualifications` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.registrations: ~4 rows (approximately)
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
INSERT INTO `registrations` (`id`, `registration_no`, `invoice_no`, `registration_fees`, `fees_paid_amount`, `center_registration_date`, `ep_registration_date`, `result_claim_date`, `status`, `approval_status`, `payment_status`, `remarks`, `created_at`, `updated_at`, `center_id`, `qualification_id`) VALUES
	(1, '00001', '', 0.00, 0.00, '2021-03-25', NULL, NULL, 'Active', 'Initiated', 'Due', '', NULL, NULL, 5, 1),
	(8, '2103000002', 'INV-000009', 2000.00, 0.00, '2021-03-25', '2021-03-26', NULL, 'Active', 'Approved', 'Due', NULL, '2021-03-24 21:07:30', '2021-03-26 08:12:33', 5, 3),
	(18, '2103000009', NULL, 444.00, 0.00, '2021-03-25', NULL, NULL, 'Active', 'Initiated', 'Due', NULL, '2021-03-25 14:27:07', '2021-03-25 14:27:07', 5, 3),
	(19, '2103000019', 'INV-000020', 50.00, 0.00, '2021-03-26', '2021-03-26', '2021-03-26', 'Active', 'Approved', 'Due', NULL, '2021-03-26 09:32:47', '2021-03-26 18:32:26', 5, 4);
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;

-- Dumping structure for table edupro.registration_learners
CREATE TABLE IF NOT EXISTS `registration_learners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `learner_id` bigint(20) unsigned NOT NULL,
  `registration_id` bigint(20) unsigned NOT NULL,
  `pass_status` enum('No Result','Pass','Fail') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No Result',
  `cirtificate_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_printd` enum('No','Yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registration_learners_learner_id_foreign` (`learner_id`),
  KEY `registration_learners_registration_id_foreign` (`registration_id`),
  CONSTRAINT `registration_learners_learner_id_foreign` FOREIGN KEY (`learner_id`) REFERENCES `learners` (`id`),
  CONSTRAINT `registration_learners_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.registration_learners: ~5 rows (approximately)
/*!40000 ALTER TABLE `registration_learners` DISABLE KEYS */;
INSERT INTO `registration_learners` (`id`, `learner_id`, `registration_id`, `pass_status`, `cirtificate_no`, `is_printd`, `created_at`, `updated_at`) VALUES
	(1, 2, 8, 'No Result', '', 'No', NULL, NULL),
	(2, 5, 8, 'No Result', '', 'No', NULL, NULL),
	(3, 6, 8, 'No Result', '', 'No', NULL, NULL),
	(15, 2, 18, 'No Result', '', 'No', '2021-03-25 14:27:07', '2021-03-25 14:27:07'),
	(16, 5, 18, 'No Result', '', 'No', '2021-03-25 14:27:07', '2021-03-25 14:27:07'),
	(17, 2, 19, 'Pass', '', 'No', NULL, '2021-03-26 18:24:13'),
	(18, 5, 19, 'No Result', '', 'No', NULL, '2021-03-26 18:27:11'),
	(19, 6, 19, 'Fail', '', 'No', NULL, '2021-03-26 18:27:36');
/*!40000 ALTER TABLE `registration_learners` ENABLE KEYS */;

-- Dumping structure for table edupro.settings
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

-- Dumping data for table edupro.settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `company_name`, `short_name`, `site_name`, `admin_email`, `admin_mobile`, `site_url`, `admin_url`, `logo`, `address`, `created_at`, `updated_at`) VALUES
	(1, 'Edupro', 'Edupro', 'Edupro', 'admin@edupro.com', '45455', NULL, NULL, '', 'sdfsd f, sdf sdf', NULL, '2021-03-21 06:35:17');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table edupro.units
CREATE TABLE IF NOT EXISTS `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `glh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assessment_type` enum('Internal','External') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Internal',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.units: ~9 rows (approximately)
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` (`id`, `unit_code`, `name`, `glh`, `assessment_type`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'EPU 17022', 'EP Level 3 Diploma in Executive Englishkkk', '220', 'External', 'Active', '2021-03-21 14:33:27', '2021-03-21 18:20:11'),
	(2, 'EPU 1703', 'EP Level 4 Diploma in Executive English', '120', 'Internal', 'Active', '2021-03-21 14:41:20', '2021-03-22 15:48:14'),
	(11, 'EPU 1704', 'Unit name 1', '100', 'Internal', 'Active', '2021-03-26 09:26:20', '2021-03-26 09:26:20'),
	(12, 'EPU 1705', 'Unit name 2', '100', 'Internal', 'Active', '2021-03-26 09:26:34', '2021-03-26 09:26:34'),
	(13, 'EPU 1706', 'Unit name 3', '100', 'Internal', 'Active', '2021-03-26 09:26:48', '2021-03-26 09:26:48'),
	(14, 'EPU 1707', 'Unit name 4', '100', 'Internal', 'Active', '2021-03-26 09:27:04', '2021-03-26 09:27:04'),
	(15, 'EPU 1708', 'Unit name 5', '100', 'Internal', 'Active', '2021-03-26 09:27:30', '2021-03-26 09:27:36'),
	(16, 'EPU 1709', 'Unit name 6', '100', 'Internal', 'Active', '2021-03-26 09:28:18', '2021-03-26 09:28:18'),
	(17, 'EPU 1710', 'Unit name 7', '100', 'Internal', 'Active', '2021-03-26 09:28:39', '2021-03-26 09:28:39');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;

-- Dumping structure for table edupro.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_id` bigint(20) DEFAULT NULL COMMENT 'when a user is under a client then client id will set here',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `type` enum('Admin','Center') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `login_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:logged-in,0:Not logged in',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_profile_image`, `contact_no`, `remarks`, `center_id`, `status`, `type`, `login_status`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Momit', 'Hasan', 'momit@technolife.ee', '1616308888.jpg', '5555555555', 'erwerer', NULL, 1, 'Admin', 0, '$2y$10$mIW4VQ9btgEIsWKD6AnDeOD8ysMvPIQ7JQXFDmnYr35NpvXKlpHv2', NULL, NULL, NULL, '2021-03-26 17:39:20'),
	(2, 'Munif', 'Hasan', 'munif@gmail.com', NULL, '4564545455', NULL, NULL, 1, 'Admin', 0, '$2y$10$XkFQKU413WR7aGUChL0myePrC4iCsXG4H/DvHu6uprbWBjq56rgYm', NULL, NULL, NULL, '2020-04-13 09:10:35'),
	(3, 'Litu', 'Hasan', 'litu@technolife.ee', NULL, '35434445', 'somethig remarks', NULL, 1, 'Admin', 0, '$2y$10$9DZdKoECmuP3B3LrKgmWZu4Gh/g/5/uAjItEobvN03gvpsXw22Lxy', NULL, NULL, '2020-04-09 06:25:14', '2020-04-10 01:24:39'),
	(6, 'BOG', 'RA', 'momit.litu@gmail.com', NULL, '01980340482', 'cssdfsdfsdfdsf', 5, 1, 'Center', 0, '$2y$10$KwCQx44G9IAnA1JcCgkVoeKCkLWdXrJ0YxlbGoMRkVP0y//VzTJKW', NULL, NULL, '2021-03-23 09:46:38', '2021-03-26 17:07:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table edupro.user_groups
CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Admin User, 2: client User',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `editable` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:yes,0:no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.user_groups: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` (`id`, `group_name`, `type`, `status`, `editable`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 1, 1, 0, NULL, NULL),
	(2, 'Admin', 1, 1, 1, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(27, 'Center Admin', 2, 1, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;

-- Dumping structure for table edupro.user_group_members
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.user_group_members: ~6 rows (approximately)
/*!40000 ALTER TABLE `user_group_members` DISABLE KEYS */;
INSERT INTO `user_group_members` (`id`, `user_id`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, NULL, NULL),
	(4, 1, 2, 0, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(5, 1, 27, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(6, 2, 27, 1, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(7, 3, 27, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15'),
	(8, 6, 27, 1, '2021-03-23 09:46:38', '2021-03-23 09:46:38');
/*!40000 ALTER TABLE `user_group_members` ENABLE KEYS */;

-- Dumping structure for table edupro.user_group_permissions
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
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table edupro.user_group_permissions: ~123 rows (approximately)
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
	(58, 2, 21, 0, '2021-03-21 07:07:10', '2021-03-21 07:07:10'),
	(59, 27, 21, 0, '2021-03-21 07:07:10', '2021-03-21 07:07:10'),
	(60, 1, 22, 1, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(61, 2, 22, 0, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(62, 27, 22, 0, '2021-03-21 07:07:44', '2021-03-21 07:07:44'),
	(63, 1, 23, 1, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(64, 2, 23, 0, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(65, 27, 23, 0, '2021-03-21 07:08:00', '2021-03-21 07:08:00'),
	(66, 1, 24, 1, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(67, 2, 24, 0, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(68, 27, 24, 0, '2021-03-21 07:08:10', '2021-03-21 07:08:10'),
	(69, 1, 25, 1, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(70, 2, 25, 0, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(71, 27, 25, 0, '2021-03-21 18:26:56', '2021-03-21 18:26:56'),
	(72, 1, 26, 1, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(73, 2, 26, 0, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(74, 27, 26, 0, '2021-03-21 18:27:14', '2021-03-21 18:27:14'),
	(75, 1, 27, 1, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(76, 2, 27, 0, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(77, 27, 27, 0, '2021-03-21 18:27:27', '2021-03-21 18:27:27'),
	(78, 1, 28, 1, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(79, 2, 28, 0, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(80, 27, 28, 0, '2021-03-21 18:27:34', '2021-03-21 18:27:34'),
	(81, 1, 29, 1, '2021-03-23 05:00:11', '2021-03-23 05:00:11'),
	(82, 2, 29, 0, '2021-03-23 05:00:11', '2021-03-23 05:00:11'),
	(83, 27, 29, 0, '2021-03-23 05:00:11', '2021-03-23 05:00:11'),
	(84, 1, 30, 1, '2021-03-23 05:00:25', '2021-03-23 05:00:25'),
	(85, 2, 30, 0, '2021-03-23 05:00:25', '2021-03-23 05:00:25'),
	(86, 27, 30, 0, '2021-03-23 05:00:25', '2021-03-23 05:00:25'),
	(87, 1, 31, 1, '2021-03-23 05:00:32', '2021-03-23 05:00:32'),
	(88, 2, 31, 0, '2021-03-23 05:00:32', '2021-03-23 05:00:32'),
	(89, 27, 31, 0, '2021-03-23 05:00:32', '2021-03-23 05:00:32'),
	(90, 1, 32, 1, '2021-03-23 05:00:39', '2021-03-23 05:00:39'),
	(91, 2, 32, 0, '2021-03-23 05:00:39', '2021-03-23 05:00:39'),
	(92, 27, 32, 0, '2021-03-23 05:00:39', '2021-03-23 05:00:39'),
	(96, 1, 34, 1, '2021-03-23 14:31:42', '2021-03-23 14:31:42'),
	(97, 2, 34, 0, '2021-03-23 14:31:42', '2021-03-23 14:31:42'),
	(98, 27, 34, 0, '2021-03-23 14:31:42', '2021-03-23 14:31:42'),
	(99, 1, 35, 1, '2021-03-23 14:32:49', '2021-03-23 14:32:49'),
	(100, 2, 35, 0, '2021-03-23 14:32:49', '2021-03-23 14:32:49'),
	(101, 27, 35, 0, '2021-03-23 14:32:49', '2021-03-23 14:32:49'),
	(102, 1, 36, 1, '2021-03-23 14:32:57', '2021-03-23 14:32:57'),
	(103, 2, 36, 0, '2021-03-23 14:32:57', '2021-03-23 14:32:57'),
	(104, 27, 36, 0, '2021-03-23 14:32:57', '2021-03-23 14:32:57'),
	(105, 1, 37, 1, '2021-03-23 14:33:06', '2021-03-23 14:33:06'),
	(106, 2, 37, 0, '2021-03-23 14:33:06', '2021-03-23 14:33:06'),
	(107, 27, 37, 0, '2021-03-23 14:33:06', '2021-03-23 14:33:06'),
	(108, 1, 38, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(109, 2, 38, 0, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(110, 27, 38, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(111, 1, 39, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(112, 2, 39, 0, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(113, 27, 39, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(114, 1, 40, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(115, 2, 40, 0, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(116, 27, 40, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(117, 1, 41, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(118, 2, 41, 0, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(119, 27, 41, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24'),
	(120, 1, 42, 1, '2021-03-23 18:42:00', '2021-03-23 18:42:00'),
	(121, 2, 42, 0, '2021-03-23 18:42:00', '2021-03-23 18:42:00'),
	(122, 27, 42, 0, '2021-03-23 18:42:00', '2021-03-23 18:42:00'),
	(123, 1, 43, 1, '2021-03-24 16:39:06', '2021-03-24 16:39:06'),
	(124, 2, 43, 0, '2021-03-24 16:39:06', '2021-03-24 16:39:06'),
	(125, 27, 43, 1, '2021-03-24 16:39:06', '2021-03-24 16:39:06'),
	(126, 1, 44, 0, '2021-03-24 16:39:28', '2021-03-24 16:39:28'),
	(127, 2, 44, 0, '2021-03-24 16:39:28', '2021-03-24 16:39:28'),
	(128, 27, 44, 1, '2021-03-24 16:39:28', '2021-03-24 16:39:28'),
	(129, 1, 45, 1, '2021-03-24 16:39:34', '2021-03-24 16:39:34'),
	(130, 2, 45, 0, '2021-03-24 16:39:34', '2021-03-24 16:39:34'),
	(131, 27, 45, 1, '2021-03-24 16:39:34', '2021-03-24 16:39:34'),
	(132, 1, 46, 0, '2021-03-24 16:39:42', '2021-03-24 16:39:42'),
	(133, 2, 46, 0, '2021-03-24 16:39:42', '2021-03-24 16:39:42'),
	(134, 27, 46, 1, '2021-03-24 16:39:42', '2021-03-24 16:39:42'),
	(135, 1, 47, 1, '2021-03-24 20:58:34', '2021-03-24 20:58:34'),
	(136, 2, 47, 0, '2021-03-24 20:58:34', '2021-03-24 20:58:34'),
	(137, 27, 47, 1, '2021-03-24 20:58:34', '2021-03-24 20:58:34'),
	(138, 1, 48, 1, '2021-03-25 13:07:56', '2021-03-25 13:07:56'),
	(139, 2, 48, 0, '2021-03-25 13:07:56', '2021-03-25 13:07:56'),
	(140, 27, 48, 1, '2021-03-25 13:07:56', '2021-03-25 13:07:56'),
	(141, 1, 50, 0, '2021-03-26 10:04:05', '2021-03-26 10:04:05'),
	(142, 2, 50, 0, '2021-03-26 10:04:05', '2021-03-26 10:04:05'),
	(143, 27, 50, 1, '2021-03-26 10:04:05', '2021-03-26 10:04:05'),
	(144, 1, 51, 0, '2021-03-26 17:44:54', '2021-03-26 17:44:54'),
	(145, 2, 51, 0, '2021-03-26 17:44:54', '2021-03-26 17:44:54'),
	(146, 27, 51, 1, '2021-03-26 17:44:54', '2021-03-26 17:44:54'),
	(147, 1, 52, 1, '2021-03-26 18:47:46', '2021-03-26 18:47:46'),
	(148, 2, 52, 0, '2021-03-26 18:47:46', '2021-03-26 18:47:46'),
	(149, 27, 52, 1, '2021-03-26 18:47:46', '2021-03-26 18:47:46'),
	(150, 1, 53, 1, '2021-03-26 18:47:59', '2021-03-26 18:47:59'),
	(151, 2, 53, 0, '2021-03-26 18:47:59', '2021-03-26 18:47:59'),
	(152, 27, 53, 0, '2021-03-26 18:47:59', '2021-03-26 18:47:59');
/*!40000 ALTER TABLE `user_group_permissions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
