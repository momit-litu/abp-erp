-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2021 at 07:19 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` bigint(20) NOT NULL,
  `activity_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` bigint(20) NOT NULL DEFAULT 0,
  `is_menu` bigint(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actions`
--

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
(12, 'General Setting Management', 11, 8, 1, '2020-04-09 08:26:07', '2020-04-09 19:28:49'),
(15, 'General Setting Update', 11, NULL, 1, '2020-04-09 18:50:37', '2020-04-09 19:28:54'),
(16, 'Group Management', 11, 14, 1, '2020-04-10 04:54:39', '2020-04-10 04:59:51'),
(17, 'User Group Entry', 11, NULL, 1, '2020-04-10 04:55:22', '2020-04-10 04:55:22'),
(18, 'User Group Update', 11, NULL, 1, '2020-04-10 04:55:36', '2020-04-10 04:55:36'),
(19, 'User Group Delete', 11, NULL, 1, '2020-04-10 04:56:36', '2020-04-10 04:56:36'),
(20, 'Assign Group Permission', 11, NULL, 1, '2020-04-10 05:26:19', '2020-04-10 05:26:19'),
(21, 'Unit Management', 15, 18, 1, '2021-03-21 01:07:10', '2021-03-21 01:07:10'),
(22, 'Unit Entry', 15, NULL, 1, '2021-03-21 01:07:44', '2021-03-21 01:07:44'),
(23, 'Unit Update', 15, NULL, 1, '2021-03-21 01:08:00', '2021-03-21 01:08:00'),
(24, 'Unit Delete', 15, NULL, 1, '2021-03-21 01:08:10', '2021-03-21 01:08:10'),
(25, 'Qualification Management', 15, 17, 1, '2021-03-21 12:26:56', '2021-03-21 12:26:56'),
(26, 'Qualification Entry', 15, NULL, 1, '2021-03-21 12:27:14', '2021-03-21 12:27:14'),
(27, 'Qualification Update', 15, NULL, 1, '2021-03-21 12:27:27', '2021-03-21 12:27:27'),
(28, 'Qualification Delete', 15, NULL, 1, '2021-03-21 12:27:34', '2021-03-21 12:27:34'),
(38, 'Student Management', 19, 19, 1, '2021-03-23 12:40:39', '2021-03-23 12:40:39'),
(39, 'Student Entry', 19, NULL, 1, '2021-03-23 12:41:06', '2021-03-23 12:41:06'),
(40, 'Student Update', 19, NULL, 1, '2021-03-23 12:41:15', '2021-03-23 12:41:15'),
(41, 'Student Delete', 19, NULL, 1, '2021-03-23 12:41:24', '2021-03-23 12:41:24'),
(66, 'Expense Category Management', 28, 29, 1, '2021-06-12 01:42:36', '2021-06-12 01:42:36'),
(67, 'Expense Category Entry', 28, NULL, 1, '2021-06-12 02:22:03', '2021-06-12 02:22:03'),
(68, 'Expense Category Update', 28, NULL, 1, '2021-06-12 02:23:18', '2021-06-12 02:23:18'),
(69, 'Expense Category Delete', 28, NULL, 1, '2021-06-12 02:23:28', '2021-06-12 02:23:28'),
(73, 'Expense Head Management', 28, 33, 1, '2021-06-29 01:32:58', '2021-06-29 01:32:58'),
(74, 'Expense Head Entry', 28, NULL, 1, '2021-06-29 06:00:06', '2021-06-30 01:27:29'),
(75, 'Expense Head Update', 28, NULL, 1, '2021-06-29 06:03:46', '2021-06-29 06:03:46'),
(76, 'Expense Head Delete', 28, NULL, 1, '2021-06-29 06:04:09', '2021-06-29 06:04:09'),
(77, 'Expense Detail Management', 28, 34, 1, '2021-06-30 23:03:49', '2021-06-30 23:03:49'),
(78, 'Expenses Detail Entry', 28, NULL, 1, '2021-06-30 23:04:19', '2021-06-30 23:04:19'),
(79, 'Expense Detail Update', 28, NULL, 1, '2021-06-30 23:04:40', '2021-06-30 23:04:40'),
(80, 'Expense Detail Delete', 28, NULL, 1, '2021-06-30 23:04:58', '2021-06-30 23:04:58');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_head_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('Due','Partial','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Due',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_head_id`, `amount`, `details`, `attachment`, `payment_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2000, 'ANy', '1625483022.png', 'Partial', 'Inactive', NULL, '2021-07-05 05:03:42'),
(11, 3, 333, 'sdf', '1625481798.png', 'Partial', 'Inactive', '2021-07-03 22:22:39', '2021-07-05 04:43:18'),
(12, 2, 55, 'df', '1625485042.png', 'Partial', 'Inactive', '2021-07-04 05:58:44', '2021-07-05 05:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `expense_heads`
--

CREATE TABLE `expense_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_head_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_category_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_heads`
--

INSERT INTO `expense_heads` (`id`, `expense_head_name`, `expense_category_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Today our bad day', 1, 'Inactive', '2021-06-30 04:34:59', '2021-06-30 05:03:06'),
(3, 'asdf', 1, 'Inactive', '2021-06-30 04:52:15', '2021-06-30 04:52:15'),
(8, 'ddd', 1, 'Inactive', '2021-07-03 22:16:02', '2021-07-03 22:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `expnese_categories`
--

CREATE TABLE `expnese_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expnese_categories`
--

INSERT INTO `expnese_categories` (`id`, `category_name`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BILL', NULL, 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `levels`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) NOT NULL,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'value:0 if the menu is itself a parent otherwise anyother parent id',
  `serial_no` int(11) DEFAULT NULL,
  `menu_icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `module_name`, `menu_title`, `menu_url`, `parent_id`, `serial_no`, `menu_icon_class`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Users', 'Users', '', 0, 6, 'pe-7s-users', 1, NULL, NULL),
(5, 'Users', 'Admin Users', 'user/admin/admin-user-management?type=Admin', 4, 1, NULL, 1, NULL, NULL),
(6, 'Users', 'Center Users', 'user/admin/admin-user-management?type=Center', 4, 2, NULL, 1, NULL, NULL),
(7, 'Cpanel', 'Control Panel', '', 0, 8, 'pe-7s-tools', 1, NULL, NULL),
(8, 'Settings', 'General Setting', 'settings/general/general-setting', 11, 1, NULL, 1, NULL, NULL),
(9, 'Cpanel', 'Menus/Moduls', 'cp/module/manage-module', 7, 2, NULL, 1, NULL, NULL),
(10, 'Cpanel', 'Actions', 'cp/web-action/web-action-management', 7, 3, NULL, 1, NULL, NULL),
(11, 'Settings', 'Settings', '', 0, 7, 'pe-7s-settings', 1, NULL, NULL),
(14, 'Settings', 'User Groups', 'settings/admin/admin-group-management', 11, 2, NULL, 1, '2020-04-10 04:58:01', '2020-04-10 04:58:01'),
(15, 'Qualifications', 'Qualifications', '', 0, 1, 'pe-7s-notebook', 1, '2021-03-21 00:57:45', '2021-03-21 00:57:45'),
(17, 'Qualifications', 'Qualifications', 'qualification', 15, 1, NULL, 1, '2021-03-21 01:05:46', '2021-03-21 01:05:46'),
(18, 'Units', 'Units', 'unit', 15, 2, NULL, 1, '2021-03-21 01:06:31', '2021-03-21 01:06:31'),
(19, 'Students', 'Students', 'student', 0, 2, 'pe-7s-add-user', 1, '2021-03-23 12:40:06', '2021-03-23 12:40:06'),
(22, 'Dashboard', 'Dashboard', '', 0, NULL, NULL, 1, '2021-04-10 09:52:11', '2021-04-10 09:52:11'),
(28, 'Expenses', 'Expenses', '', 0, 4, 'pe-7s-cash', 1, '2021-06-12 01:35:56', '2021-06-12 01:35:56'),
(29, 'Expense Category', 'Expense Category', 'expense/expense-category', 28, NULL, NULL, 1, '2021-06-12 01:42:11', '2021-06-12 01:43:50'),
(33, 'Expense Head', 'Expense Head', 'expense/expense-head', 28, NULL, NULL, 1, '2021-06-29 01:29:44', '2021-06-29 01:29:44'),
(34, 'Expense Detail', 'Expense Detail', 'expense/expense-detail', 28, NULL, NULL, 1, '2021-06-30 23:02:02', '2021-06-30 23:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2016_06_01_000001_create_oauth_auth_codes_table', 8),
(9, '2016_06_01_000002_create_oauth_access_tokens_table', 8),
(10, '2016_06_01_000003_create_oauth_refresh_tokens_table', 8),
(11, '2016_06_01_000004_create_oauth_clients_table', 8),
(12, '2016_06_01_000005_create_oauth_personal_access_clients_table', 8),
(29, '2021_06_12_074741_create_expnese_categories_table', 9),
(30, '2021_06_29_112645_create_expense_heads_table', 10),
(31, '2021_07_01_044553_create_expenses_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('210d4701-7e56-4176-9fcd-8d978d3c4756', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"A new registration request waiting for approval from BOGURA HUB\"}', '2021-04-09 22:54:23', '2021-04-05 12:08:27', '2021-04-09 22:54:23'),
('353044f9-4cfd-4cc0-a94e-58a08e2b622d', 'App\\Notifications\\CertificateClaim', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"1 new certificate has been claimed by BOGURA HUB\"}', '2021-04-09 20:12:14', '2021-04-06 00:41:31', '2021-04-09 20:12:14'),
('45077fe1-b57a-4c21-aaef-3a2f9379318f', 'App\\Notifications\\RegistrationRequest', 'App\\User', 6, '{\"type\":\"Success\",\"Message\":\"Registration #2104000023 has been approved by Edupro\"}', '2021-04-15 12:42:47', '2021-04-15 12:42:08', '2021-04-15 12:42:47'),
('57b8abbe-cba1-46bc-8bdd-a3b7fa4f8199', 'App\\Notifications\\CertificateClaim', 'App\\User', 6, '{\"Type\":\"Success\",\"Message\":\" Certificate has been provided for Momit Hasan\"}', '2021-04-17 04:29:47', '2021-04-15 12:45:32', '2021-04-17 04:29:47'),
('5987468f-c6e7-40a3-9ee4-c166493a4cd9', 'App\\Notifications\\CertificateClaim', 'App\\User', 6, '{\"Type\":\"Success\",\"Message\":\" Certificate has been provided for Muniff Hasann\"}', '2021-04-09 23:47:45', '2021-04-06 01:02:07', '2021-04-09 23:47:45'),
('67714df6-a72c-4da4-a94e-cb7023edd3cb', 'App\\Notifications\\RegistrationRequest', 'App\\User', 6, '{\"Type\":\"Success\",\"Message\":\"Registration #2104000020 has been approved by Edupro\"}', '2021-04-09 23:47:45', '2021-04-05 12:31:39', '2021-04-09 23:47:45'),
('685dd847-5376-4950-944b-ab2fccbac413', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"A new registration request waiting for approval from BOGURA HUB\"}', '2021-04-09 20:12:14', '2021-04-05 12:18:33', '2021-04-09 20:12:14'),
('73c94e6b-e46f-4391-8339-83b6368218c7', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{\"type\":\"Success\",\"Message\":\"A new registration request waiting for approval from BOGURA HUB\"}', '2021-04-15 12:37:52', '2021-04-15 12:37:20', '2021-04-15 12:37:52'),
('a493dcc1-29fb-40f4-86fc-bb40b618e4d8', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"A new registration request waiting for approval from BOGURA HUB\"}', '2021-04-09 20:08:43', '2021-04-05 12:31:17', '2021-04-09 20:08:43'),
('c0cb0510-9802-41af-b367-56c4920a45a6', 'App\\Notifications\\CertificateClaim', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"1 new certificate has been claimed by BOGURA HUB\"}', '2021-04-09 23:01:33', '2021-04-06 00:39:38', '2021-04-09 23:01:33'),
('ccfbf903-f49c-4176-a1a4-9f2f7abd4d68', 'App\\Notifications\\RegistrationRequest', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"A new registration request waiting for approval\"}', '2021-04-09 20:08:43', '2021-04-05 12:04:18', '2021-04-09 20:08:43'),
('fe685c13-b00f-40b4-aa0f-c817fbff3c58', 'App\\Notifications\\CertificateClaim', 'App\\User', 1, '{\"Type\":\"Success\",\"Message\":\"2 new certificate has been claimed by BOGURA HUB\"}', '2021-04-15 12:43:22', '2021-04-15 12:43:06', '2021-04-15 12:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

CREATE TABLE `qualifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tqt` int(11) NOT NULL,
  `total_credit_hour` int(11) NOT NULL,
  `registration_fees` double(8,2) NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `level_id`, `code`, `title`, `tqt`, `total_credit_hour`, `registration_fees`, `status`, `created_at`, `updated_at`) VALUES
(9, 1, 'Q2021001', 'PGDHRM', 600, 30, 500.00, 'Active', '2021-06-22 07:19:12', '2021-06-22 08:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `qualification_units`
--

CREATE TABLE `qualification_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `qualification_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `type` enum('Optional','Mandatory') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Optional',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qualification_units`
--

INSERT INTO `qualification_units` (`id`, `unit_id`, `qualification_id`, `status`, `type`, `created_at`, `updated_at`) VALUES
(42, 23, 9, 'Active', 'Optional', '2021-06-22 08:21:13', '2021-06-22 08:21:13'),
(43, 24, 9, 'Active', 'Optional', '2021-06-22 08:21:13', '2021-06-22 08:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `short_name`, `site_name`, `admin_email`, `admin_mobile`, `site_url`, `admin_url`, `logo`, `address`, `created_at`, `updated_at`) VALUES
(1, 'ABP BD', 'ABP', 'ABPBD', 'admin@abpbd.com', '45455', NULL, NULL, 'logo-inverse.png', 'sdfsd f, sdf sdf', NULL, '2021-06-08 00:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `email`, `contact_no`, `address`, `nid_no`, `date_of_birth`, `user_profile_image`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(21, 'Muniff', 'Hasannn', 'munif@gmail.com', '6546468', 'dhaka', '123313131231', '2021-06-25', '', 'sdr fsfsfsdff', 'Active', '2021-06-21 03:46:55', '2021-06-21 04:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `glh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_hour` int(11) NOT NULL,
  `tut` int(11) NOT NULL,
  `assessment_type` enum('Internal','External') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Internal',
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_code`, `name`, `glh`, `credit_hour`, `tut`, `assessment_type`, `status`, `created_at`, `updated_at`) VALUES
(23, 'EPU 170457', 'Unit name 1', '40', 10, 100, 'Internal', 'Active', '2021-06-22 01:24:17', '2021-06-22 01:28:15'),
(24, 'EPU 170458', 'Unit Name 2', '30', 10, 200, 'Internal', 'Active', '2021-06-22 01:48:57', '2021-06-22 01:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_profile_image`, `contact_no`, `remarks`, `student_id`, `status`, `type`, `login_status`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Momit', 'Hasan', 'momit@technolife.ee', '1616308888.jpg', '5555555555', 'erwerer', NULL, 1, 'Admin', 0, '$2y$10$mIW4VQ9btgEIsWKD6AnDeOD8ysMvPIQ7JQXFDmnYr35NpvXKlpHv2', NULL, 'PzZ7WR6QhSrlR4CuuJh529vcDAm7Rf4L0tiKbDDMvEhtRpxn4W8CqOeE3nNg', '2021-06-07 06:50:15', '2021-07-05 03:19:11'),
(23, 'Muniff', 'Hasannn', 'munif@gmail.com', NULL, '6546468', 'sdr fsfsfsdff', 21, 0, 'Student', 0, '$2y$10$QQmSPi5wO7aCRjyxbu.6je640APp9Y7.McASuZrhyFmQPpWorDTIu', NULL, NULL, '2021-06-21 03:46:55', '2021-06-21 04:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` bigint(20) NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Admin User, 2: client User',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,0:in-active',
  `editable` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:yes,0:no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `type`, `status`, `editable`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, 1, 0, NULL, NULL),
(2, 'Admin', 1, 1, 1, '2020-04-10 07:35:07', '2020-04-10 07:35:07'),
(27, 'Student', 2, 1, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_members`
--

CREATE TABLE `user_group_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_group_members`
--

INSERT INTO `user_group_members` (`id`, `user_id`, `group_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL),
(4, 1, 2, 0, '2020-04-10 07:35:07', '2020-04-10 07:35:07'),
(5, 1, 27, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(23, 23, 27, 1, '2021-06-21 03:46:55', '2021-06-21 03:46:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permissions`
--

CREATE TABLE `user_group_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) NOT NULL DEFAULT 0,
  `action_id` bigint(20) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1:active,0:in-active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_group_permissions`
--

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
(12, 1, 12, 1, '2020-04-09 08:26:07', '2020-04-09 08:26:07'),
(15, 1, 15, 1, '2020-04-09 18:50:37', '2020-04-09 18:50:37'),
(16, 1, 16, 1, '2020-04-10 04:54:39', '2020-04-10 04:54:39'),
(17, 1, 17, 1, '2020-04-10 04:55:22', '2020-04-10 04:55:22'),
(18, 1, 18, 1, '2020-04-10 04:55:36', '2020-04-10 04:55:36'),
(19, 1, 19, 1, '2020-04-10 04:56:36', '2020-04-10 04:56:36'),
(20, 1, 20, 1, '2020-04-10 05:26:19', '2020-04-10 05:26:19'),
(39, 27, 1, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(40, 27, 2, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(41, 27, 3, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(42, 27, 4, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(43, 27, 5, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(44, 27, 6, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(45, 27, 7, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(46, 27, 8, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(47, 27, 9, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(48, 27, 10, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(49, 27, 11, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(50, 27, 12, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(51, 27, 15, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(52, 27, 16, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(53, 27, 17, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(54, 27, 18, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(55, 27, 19, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(56, 27, 20, 0, '2020-04-12 23:59:15', '2020-04-12 23:59:15'),
(57, 1, 21, 1, '2021-03-21 01:07:10', '2021-03-21 01:07:10'),
(58, 2, 21, 0, '2021-03-21 01:07:10', '2021-03-21 01:07:10'),
(59, 27, 21, 0, '2021-03-21 01:07:10', '2021-03-21 01:07:10'),
(60, 1, 22, 1, '2021-03-21 01:07:44', '2021-03-21 01:07:44'),
(61, 2, 22, 0, '2021-03-21 01:07:44', '2021-03-21 01:07:44'),
(62, 27, 22, 0, '2021-03-21 01:07:44', '2021-03-21 01:07:44'),
(63, 1, 23, 1, '2021-03-21 01:08:00', '2021-03-21 01:08:00'),
(64, 2, 23, 0, '2021-03-21 01:08:00', '2021-03-21 01:08:00'),
(65, 27, 23, 0, '2021-03-21 01:08:00', '2021-03-21 01:08:00'),
(66, 1, 24, 1, '2021-03-21 01:08:10', '2021-03-21 01:08:10'),
(67, 2, 24, 0, '2021-03-21 01:08:10', '2021-03-21 01:08:10'),
(68, 27, 24, 0, '2021-03-21 01:08:10', '2021-03-21 01:08:10'),
(69, 1, 25, 1, '2021-03-21 12:26:56', '2021-03-21 12:26:56'),
(70, 2, 25, 0, '2021-03-21 12:26:56', '2021-03-21 12:26:56'),
(71, 27, 25, 0, '2021-03-21 12:26:56', '2021-03-21 12:26:56'),
(72, 1, 26, 1, '2021-03-21 12:27:14', '2021-03-21 12:27:14'),
(73, 2, 26, 0, '2021-03-21 12:27:14', '2021-03-21 12:27:14'),
(74, 27, 26, 0, '2021-03-21 12:27:14', '2021-03-21 12:27:14'),
(75, 1, 27, 1, '2021-03-21 12:27:27', '2021-03-21 12:27:27'),
(76, 2, 27, 0, '2021-03-21 12:27:27', '2021-03-21 12:27:27'),
(77, 27, 27, 0, '2021-03-21 12:27:27', '2021-03-21 12:27:27'),
(78, 1, 28, 1, '2021-03-21 12:27:34', '2021-03-21 12:27:34'),
(79, 2, 28, 0, '2021-03-21 12:27:34', '2021-03-21 12:27:34'),
(80, 27, 28, 0, '2021-03-21 12:27:34', '2021-03-21 12:27:34'),
(108, 1, 38, 1, '2021-03-23 12:40:39', '2021-03-23 12:40:39'),
(109, 2, 38, 0, '2021-03-23 12:40:39', '2021-03-23 12:40:39'),
(110, 27, 38, 1, '2021-03-23 12:40:39', '2021-03-23 12:40:39'),
(111, 1, 39, 1, '2021-03-23 12:41:06', '2021-03-23 12:41:06'),
(112, 2, 39, 0, '2021-03-23 12:41:06', '2021-03-23 12:41:06'),
(113, 27, 39, 1, '2021-03-23 12:41:06', '2021-03-23 12:41:06'),
(114, 1, 40, 1, '2021-03-23 12:41:15', '2021-03-23 12:41:15'),
(115, 2, 40, 0, '2021-03-23 12:41:15', '2021-03-23 12:41:15'),
(116, 27, 40, 1, '2021-03-23 12:41:15', '2021-03-23 12:41:15'),
(117, 1, 41, 1, '2021-03-23 12:41:24', '2021-03-23 12:41:24'),
(118, 2, 41, 0, '2021-03-23 12:41:24', '2021-03-23 12:41:24'),
(119, 27, 41, 1, '2021-03-23 12:41:24', '2021-03-23 12:41:24'),
(250, 1, 66, 1, '2021-06-12 01:42:36', '2021-06-12 01:42:36'),
(251, 2, 66, 0, '2021-06-12 01:42:36', '2021-06-12 01:42:36'),
(252, 27, 66, 0, '2021-06-12 01:42:36', '2021-06-12 01:42:36'),
(253, 1, 67, 1, '2021-06-12 02:22:03', '2021-06-12 02:22:03'),
(254, 2, 67, 0, '2021-06-12 02:22:03', '2021-06-12 02:22:03'),
(255, 27, 67, 0, '2021-06-12 02:22:03', '2021-06-12 02:22:03'),
(256, 1, 68, 1, '2021-06-12 02:23:18', '2021-06-12 02:23:18'),
(257, 2, 68, 0, '2021-06-12 02:23:18', '2021-06-12 02:23:18'),
(258, 27, 68, 0, '2021-06-12 02:23:18', '2021-06-12 02:23:18'),
(259, 1, 69, 1, '2021-06-12 02:23:28', '2021-06-12 02:23:28'),
(260, 2, 69, 0, '2021-06-12 02:23:28', '2021-06-12 02:23:28'),
(261, 27, 69, 0, '2021-06-12 02:23:28', '2021-06-12 02:23:28'),
(271, 1, 73, 1, '2021-06-29 01:32:58', '2021-06-29 01:32:58'),
(272, 2, 73, 0, '2021-06-29 01:32:58', '2021-06-29 01:32:58'),
(273, 27, 73, 0, '2021-06-29 01:32:58', '2021-06-29 01:32:58'),
(274, 1, 74, 1, '2021-06-29 06:00:06', '2021-06-29 06:00:06'),
(275, 2, 74, 0, '2021-06-29 06:00:06', '2021-06-29 06:00:06'),
(276, 27, 74, 0, '2021-06-29 06:00:06', '2021-06-29 06:00:06'),
(277, 1, 75, 1, '2021-06-29 06:03:46', '2021-06-29 06:03:46'),
(278, 2, 75, 0, '2021-06-29 06:03:46', '2021-06-29 06:03:46'),
(279, 27, 75, 0, '2021-06-29 06:03:46', '2021-06-29 06:03:46'),
(280, 1, 76, 1, '2021-06-29 06:04:09', '2021-06-29 06:04:09'),
(281, 2, 76, 0, '2021-06-29 06:04:09', '2021-06-29 06:04:09'),
(282, 27, 76, 0, '2021-06-29 06:04:09', '2021-06-29 06:04:09'),
(283, 1, 77, 1, '2021-06-30 23:03:49', '2021-06-30 23:03:49'),
(284, 2, 77, 0, '2021-06-30 23:03:49', '2021-06-30 23:03:49'),
(285, 27, 77, 0, '2021-06-30 23:03:49', '2021-06-30 23:03:49'),
(286, 1, 78, 1, '2021-06-30 23:04:19', '2021-06-30 23:04:19'),
(287, 2, 78, 0, '2021-06-30 23:04:19', '2021-06-30 23:04:19'),
(288, 27, 78, 0, '2021-06-30 23:04:19', '2021-06-30 23:04:19'),
(289, 1, 79, 1, '2021-06-30 23:04:40', '2021-06-30 23:04:40'),
(290, 2, 79, 0, '2021-06-30 23:04:40', '2021-06-30 23:04:40'),
(291, 27, 79, 0, '2021-06-30 23:04:40', '2021-06-30 23:04:40'),
(292, 1, 80, 1, '2021-06-30 23:04:58', '2021-06-30 23:04:58'),
(293, 2, 80, 0, '2021-06-30 23:04:58', '2021-06-30 23:04:58'),
(294, 27, 80, 0, '2021-06-30 23:04:58', '2021-06-30 23:04:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_actions_menus` (`module_id`),
  ADD KEY `FK_actions_menus_2` (`is_menu`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_heads`
--
ALTER TABLE `expense_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expnese_categories`
--
ALTER TABLE `expnese_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualifications_level_id_foreign` (`level_id`);

--
-- Indexes for table `qualification_units`
--
ALTER TABLE `qualification_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qualification_units_unit_id_foreign` (`unit_id`),
  ADD KEY `qualification_units_qualification_id_foreign` (`qualification_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group_members`
--
ALTER TABLE `user_group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_group_members_users` (`user_id`),
  ADD KEY `FK_user_group_members_user_groups` (`group_id`);

--
-- Indexes for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_group_permissions_user_groups` (`group_id`),
  ADD KEY `FK_user_group_permissions_actions` (`action_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expense_heads`
--
ALTER TABLE `expense_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expnese_categories`
--
ALTER TABLE `expnese_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualifications`
--
ALTER TABLE `qualifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `qualification_units`
--
ALTER TABLE `qualification_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_group_members`
--
ALTER TABLE `user_group_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `FK_actions_menus` FOREIGN KEY (`module_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `FK_actions_menus_2` FOREIGN KEY (`is_menu`) REFERENCES `menus` (`id`);

--
-- Constraints for table `qualifications`
--
ALTER TABLE `qualifications`
  ADD CONSTRAINT `qualifications_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);

--
-- Constraints for table `qualification_units`
--
ALTER TABLE `qualification_units`
  ADD CONSTRAINT `qualification_units_qualification_id_foreign` FOREIGN KEY (`qualification_id`) REFERENCES `qualifications` (`id`),
  ADD CONSTRAINT `qualification_units_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `user_group_members`
--
ALTER TABLE `user_group_members`
  ADD CONSTRAINT `FK_user_group_members_user_groups` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`),
  ADD CONSTRAINT `FK_user_group_members_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_group_permissions`
--
ALTER TABLE `user_group_permissions`
  ADD CONSTRAINT `FK_user_group_permissions_actions` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `FK_user_group_permissions_user_groups` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
