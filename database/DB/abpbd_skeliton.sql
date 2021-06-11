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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.actions: ~22 rows (approximately)
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
	(38, 'Learner Management', 19, 19, 1, '2021-03-23 18:40:39', '2021-03-23 18:40:39'),
	(39, 'Learner Entry', 19, NULL, 1, '2021-03-23 18:41:06', '2021-03-23 18:41:06'),
	(40, 'Learner Update', 19, NULL, 1, '2021-03-23 18:41:15', '2021-03-23 18:41:15'),
	(41, 'Learner Delete', 19, NULL, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;

-- Dumping structure for table abpdb.learners
CREATE TABLE IF NOT EXISTS `learners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `user_profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.learners: ~4 rows (approximately)
/*!40000 ALTER TABLE `learners` DISABLE KEYS */;
INSERT INTO `learners` (`id`, `first_name`, `last_name`, `email`, `contact_no`, `address`, `nid_no`, `date_of_birth`, `user_profile_image`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
	(2, 'Momit', 'Hasan', 'momit.litu@gmail.com', '01980340482', 'dhaka', '1231231', '2021-04-13', '1616534295.jpg', NULL, 'Active', NULL, '2021-03-23 21:18:15'),
	(5, 'Muniff', 'Hasann', 'momit.lssitu@gmail.com', '0198034', 'agrabad, chitagong', '454554', '2021-04-13', '1616534286.jpg', 'fdg dfgdfgdfgdg', 'Active', '2021-03-23 20:16:57', '2021-03-23 21:18:06'),
	(6, 'Litu', 'Hasan', 'momfgit@bils.com', '01980340482', 'sdf gdfgdfgdfbg hg hgh', '1231231', '2021-04-13', '', 'dfgdfgdfgdfgdfgdfgdfg', 'Active', '2021-03-23 21:48:35', '2021-03-23 21:48:35'),
	(8, 'Zarif', 'Hasan', 'zarif@gmail.com', '054384854151', 'vd dffdgdfg', '4546654', '2021-04-13', '', NULL, 'Inactive', '2021-04-17 17:38:42', '2021-04-20 10:56:16');
/*!40000 ALTER TABLE `learners` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.menus: ~11 rows (approximately)
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
	(19, 'Students', 'Students', 'student', 0, 3, 'pe-7s-add-user', 1, '2021-03-23 18:40:06', '2021-03-23 18:40:06'),
	(22, 'Dashboard', 'Dashboard', '', 0, NULL, NULL, 1, '2021-04-10 15:52:11', '2021-04-10 15:52:11');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;

-- Dumping structure for table abpdb.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.migrations: ~0 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
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
  `type` enum('Admin','Center') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `login_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:logged-in,0:Not logged in',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_profile_image`, `contact_no`, `remarks`, `student_id`, `status`, `type`, `login_status`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Momit', 'Hasan', 'momit@technolife.ee', '1616308888.jpg', '5555555555', 'erwerer', NULL, 1, 'Admin', 0, '$2y$10$mIW4VQ9btgEIsWKD6AnDeOD8ysMvPIQ7JQXFDmnYr35NpvXKlpHv2', NULL, 'DjMgP4X79N71SZ8s', '2021-06-07 12:50:15', '2021-06-10 16:26:28');
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

-- Dumping data for table abpdb.user_groups: ~3 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_group_members: ~3 rows (approximately)
/*!40000 ALTER TABLE `user_group_members` DISABLE KEYS */;
INSERT INTO `user_group_members` (`id`, `user_id`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, NULL, NULL),
	(4, 1, 2, 0, '2020-04-10 13:35:07', '2020-04-10 13:35:07'),
	(5, 1, 27, 0, '2020-04-13 05:59:15', '2020-04-13 05:59:15');
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
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table abpdb.user_group_permissions: ~48 rows (approximately)
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
	(119, 27, 41, 1, '2021-03-23 18:41:24', '2021-03-23 18:41:24');
/*!40000 ALTER TABLE `user_group_permissions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
