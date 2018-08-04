-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2018 at 06:24 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `archive_aop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_persian_ci NOT NULL,
  `description` text COLLATE utf32_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'فرمان', 'بدون شرح');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_persian_ci NOT NULL,
  `description` text COLLATE utf32_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`) VALUES
(1, 'اداره امور', 'بدون شرح');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL COMMENT 'document number',
  `subject` varchar(255) COLLATE utf32_persian_ci NOT NULL,
  `date` varchar(20) COLLATE utf32_persian_ci NOT NULL COMMENT 'document date',
  `total_pages` int(11) NOT NULL,
  `edition` int(11) NOT NULL DEFAULT '1',
  `block` enum('01','02','03','04') COLLATE utf32_persian_ci DEFAULT NULL,
  `section` enum('A','B','C','D','E','F','G','H','I','J') COLLATE utf32_persian_ci DEFAULT NULL,
  `row` varchar(10) COLLATE utf32_persian_ci DEFAULT NULL,
  `cabinet_side` enum('A','B') COLLATE utf32_persian_ci DEFAULT NULL,
  `cabinet_row` int(11) DEFAULT NULL,
  `cabinet_column` int(11) DEFAULT NULL,
  `label` varchar(30) COLLATE utf32_persian_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 -> new, 1->accepted, 2->rejected,3->stocked',
  `remarks` text COLLATE utf32_persian_ci,
  `created_at` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `updated_at` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `approve_reject_auth` int(11) DEFAULT NULL,
  `stocked_by` int(11) DEFAULT NULL,
  `stock_updated_by` int(11) DEFAULT NULL,
  `stock_updated_date` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `approved_at` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `rejected_at` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `stocked_date` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
  `description` text COLLATE utf32_persian_ci COMMENT 'zama yam',
  `countries` text COLLATE utf32_persian_ci,
  `document_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `number`, `subject`, `date`, `total_pages`, `edition`, `block`, `section`, `row`, `cabinet_side`, `cabinet_row`, `cabinet_column`, `label`, `status`, `remarks`, `created_at`, `updated_at`, `department_id`, `category_id`, `created_by`, `updated_by`, `approve_reject_auth`, `stocked_by`, `stock_updated_by`, `stock_updated_date`, `approved_at`, `rejected_at`, `stocked_date`, `receiver`, `description`, `countries`, `document_language_id`) VALUES
(1, 4, 'تست', '1397-03-13', 3, 9, '01', 'D', '03', 'B', 2, 6, '01-D-03-B-02-06-D9', 3, 'تست', '1397-03-13 08:08:57', '1397-03-13 08:13:26', 1, 1, 8, 8, 8, 8, 8, '1397-03-13 08:30:35', '1397-03-13 08:13:58', '1397-03-13 08:10:34', '1397-03-13 08:17:42', '4', 'تست', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `document_enquiry`
--

CREATE TABLE `document_enquiry` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `enquiry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `document_enquiry`
--

INSERT INTO `document_enquiry` (`id`, `document_id`, `enquiry_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `document_language`
--

CREATE TABLE `document_language` (
  `id` int(11) NOT NULL,
  `language_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_language`
--

INSERT INTO `document_language` (`id`, `language_name`) VALUES
(1, 'پشتو'),
(2, 'دری');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `enquiry_number` int(11) NOT NULL,
  `approval_authority` varchar(255) COLLATE utf32_persian_ci NOT NULL,
  `request_date` varchar(20) COLLATE utf32_persian_ci NOT NULL,
  `expected_return_date` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `return_date` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `returned` int(11) DEFAULT '0' COMMENT '0->not returned, 1->returned',
  `original` int(11) DEFAULT NULL COMMENT '0->copy,1->original,2->information',
  `information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci,
  `remarks` text COLLATE utf32_persian_ci,
  `file_path` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
  `department_id` int(11) NOT NULL COMMENT 'requesting department ',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `received_by` int(11) DEFAULT NULL,
  `created_at` varchar(30) COLLATE utf32_persian_ci DEFAULT NULL,
  `updated_at` varchar(30) COLLATE utf32_persian_ci DEFAULT NULL,
  `received_at` varchar(30) COLLATE utf32_persian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `enquiry_number`, `approval_authority`, `request_date`, `expected_return_date`, `return_date`, `returned`, `original`, `information`, `remarks`, `file_path`, `department_id`, `created_by`, `updated_by`, `received_by`, `created_at`, `updated_at`, `received_at`) VALUES
(1, 1, 'تست', '1397-03-07', '1397-03-17', '1397-03-14', 1, 1, NULL, 'تست', 'uploads/enquiries/1.jpg', 1, 8, NULL, 8, '1397-03-13 08:37:30', NULL, '1397-03-13 08:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `table_name` varchar(20) COLLATE utf32_persian_ci NOT NULL,
  `table_id` int(11) NOT NULL,
  `activity` varchar(255) COLLATE utf32_persian_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(20) COLLATE utf32_persian_ci NOT NULL,
  `time` varchar(10) COLLATE utf32_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `table_name`, `table_id`, `activity`, `user_id`, `date`, `time`) VALUES
(1, 'notices', 1, 'ایجاد اطلاعیه جدید', 8, '1397-03-09', '11:11:47'),
(2, 'roles', 2, 'تصحیح نقش', 8, '1397-03-12', '08:30:30'),
(3, 'roles', 2, 'تصحیح نقش', 8, '1397-03-12', '08:30:48'),
(4, 'users', 2, 'دادن صلاحیت به نقش', 8, '1397-03-12', '08:33:02'),
(5, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:08:05'),
(6, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:08:11'),
(7, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:08:29'),
(8, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:08:33'),
(9, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:10:31'),
(10, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:11:03'),
(11, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:14:09'),
(12, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:14:27'),
(13, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:14:32'),
(14, 'users', 6, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:15:14'),
(15, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:16:01'),
(16, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:16:07'),
(17, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:17:11'),
(18, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:17:35'),
(19, 'users', 7, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:18:09'),
(20, 'users', 6, 'کاربر موفقانه فعال گردید', 8, '1397-03-12', '09:18:18'),
(21, 'users', 7, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:18:31'),
(22, 'users', 8, 'کاربر موفقانه غیر فعال گردید', 8, '1397-03-12', '09:18:35'),
(23, 'departments', 1, 'ایجاد مرجع جدید', 8, '1397-03-13', '08:05:21'),
(24, 'languages', 1, 'ایجاد لسان جدید', 8, '1397-03-13', '08:07:23'),
(25, 'languages', 2, 'ایجاد لسان جدید', 8, '1397-03-13', '08:07:34'),
(26, 'documents', 1, 'درج سند', 8, '1397-03-13', '08:08:57'),
(27, 'documents', 1, 'رد سند', 8, '1397-03-13', '08:10:34'),
(28, 'uploads', 1, 'حذف فایل سند', 8, '1397-03-13', '08:13:17'),
(29, 'documents', 1, 'تصحیح سند درج شده', 8, '1397-03-13', '08:13:27'),
(30, 'documents', 1, 'تایید سند', 8, '1397-03-13', '08:13:58'),
(31, 'documents', 1, 'جابجایی سند', 8, '1397-03-13', '08:17:43'),
(32, 'documents', 1, 'تصحیح جابجایی سند', 8, '1397-03-13', '08:30:35'),
(33, 'enquiry', 1, 'درج درخواستی', 8, '1397-03-13', '08:37:31'),
(34, 'enquiry', 1, 'بازگشت سند', 8, '1397-03-13', '08:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_04_08_100710_create_permission_tables', 2),
(4, '2018_04_14_053953_create_notifications_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES
(2, 2, 'App\\User'),
(2, 6, 'App\\User'),
(2, 7, 'App\\User'),
(2, 8, 'App\\User'),
(3, 3, 'App\\User'),
(3, 7, 'App\\User'),
(3, 8, 'App\\User'),
(4, 4, 'App\\User'),
(4, 7, 'App\\User'),
(4, 8, 'App\\User'),
(5, 5, 'App\\User'),
(5, 7, 'App\\User'),
(5, 8, 'App\\User'),
(6, 1, 'App\\User'),
(6, 7, 'App\\User'),
(6, 8, 'App\\User');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'if 0 show 1 hide',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cleaning up the Order related docs', '<p>test</p>', 0, '2018-05-30 06:41:47', '2018-05-30 06:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` int(10) UNSIGNED NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_id`, `notifiable_type`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('cc9e5c02-3313-4859-8ad5-8f1d5cc5a8d3', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":1,\"notification\":\"\\u062a\\u0633\\u062a\",\"rejected_by\":8,\"notification_type\":\"document\",\"alert_type\":\"danger\"}', NULL, '2018-06-03 03:40:35', '2018-06-03 03:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` varchar(255) CHARACTER SET utf16 COLLATE utf16_persian_ci DEFAULT NULL,
  `menu` int(11) DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `translation`, `menu`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'add_document', 'اضافه نمودن سند', 0, 'web', '2018-04-09 00:31:52', '2018-04-09 00:31:52'),
(3, 'approve_document', 'تاییدی سند', 0, 'web', '2018-04-09 00:32:01', '2018-04-09 00:32:01'),
(4, 'stockable_document', 'جابجایی سند', 0, 'web', '2018-04-09 00:32:08', '2018-04-09 07:32:00'),
(5, 'enquire_document', 'درخواستی سند', 2, 'web', '2018-04-09 00:37:07', '2018-04-09 00:37:07'),
(6, 'show_saved_documents', 'نمایش سند ثبت شده', 1, 'web', '2018-04-09 01:53:21', '2018-04-09 01:53:21'),
(7, 'edit_saved_document', 'تصحیح سند ثبت شده', 1, 'web', '2018-04-09 01:56:19', '2018-04-09 01:56:19'),
(8, 'show_approvable_documents', 'نمایش اسناد قابل تایید', 1, 'web', '2018-04-09 02:00:49', '2018-04-09 02:00:49'),
(9, 'show_rejected_documents', 'نمایش اسناد رد شده', 1, 'web', '2018-04-09 02:21:30', '2018-04-09 02:21:30'),
(10, 'edit_rejected_document', 'تصحیح سند رد شده', 1, 'web', '2018-04-09 02:24:24', '2018-04-09 02:24:24'),
(11, 'issue_enquiry', 'درج درخواستی', 2, 'web', '2018-04-10 01:44:55', '2018-04-10 01:44:55'),
(12, 'show_enquiries', 'نمایش درخواستی', 2, 'web', '2018-04-10 01:45:05', '2018-04-10 01:45:05'),
(13, 'show_all_enquiries', 'نمایش همه درخواستی ها', 2, 'web', '2018-04-10 01:45:14', '2018-04-10 01:45:14'),
(14, 'show_completed_documents', 'نمایش اسناد تکمیل شده', 1, 'web', '2018-04-10 02:36:21', '2018-04-10 02:36:21'),
(15, 'undo_approval', 'لغو تاییدی', 1, 'web', '2018-04-10 06:41:44', '2018-04-10 06:41:44'),
(16, 'add_order', NULL, NULL, 'web', '2018-04-21 23:59:07', '2018-04-22 00:12:20'),
(17, 'edit_enquiry', 'تصحیح درخواستی', 2, 'web', '2018-05-30 04:59:15', '2018-05-30 04:59:15');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translation` varchar(255) CHARACTER SET utf16 COLLATE utf16_persian_ci DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `translation`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'entry', 'کارمند ثبت', 'web', '2018-04-09 00:32:24', '2018-04-09 00:36:20'),
(3, 'approval', 'کارمند تاییدی', 'web', '2018-04-09 00:36:12', '2018-04-09 00:36:12'),
(4, 'stock', 'کارمند جابجایی سند', 'web', '2018-04-09 00:36:27', '2018-04-09 00:36:27'),
(5, 'enquiry', 'کارمند درخواستی', 'web', '2018-04-09 00:37:16', '2018-04-09 00:37:16'),
(6, 'admin', 'ادمین', 'web', '2018-04-09 00:37:49', '2018-04-09 00:37:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 2),
(2, 6),
(3, 3),
(3, 6),
(4, 4),
(4, 6),
(5, 5),
(5, 6),
(6, 2),
(6, 6),
(7, 2),
(8, 3),
(8, 6),
(9, 2),
(9, 3),
(9, 6),
(10, 2),
(11, 5),
(12, 5),
(13, 5),
(13, 6),
(14, 4),
(14, 6),
(15, 3),
(17, 5);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `file_path` varchar(255) COLLATE utf32_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `document_id`, `file_path`) VALUES
(2, 1, 'uploads/1/1_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0->disable,1->active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `type`) VALUES
(1, 'test@test.com', 'test@test.com', '$2y$10$rUcfiECyfAO1lvbcUWpbQerekHr64or2wWqAPx6XibFDkh5A49Z96', 'Gf8KJhtNLWadPqKD03TNSg94z9TKbFOkw1uFcb7W0tNoC6xAc6E0H80ptngu', '2018-03-03 05:50:30', '2018-05-07 06:56:33', ''),
(2, 'entry', 'entry@test.com', '$2y$10$LHOI3d8/d.H3xZI5M8L3VOYrr1I8MPrQ7KEPpU/Up3rFoY/YCxETq', 'jYWmP0pT08ewXU44jiOa4uCr6ewmquzJGyvRbUm4xO0qsydW4JlnzsXjkgbx', '2018-04-09 00:43:06', '2018-04-24 23:40:49', '1'),
(3, 'approve', 'approve@test.com', '$2y$10$p4HofoqvgThS5UYqDoXz8urQgbIcxbKitUf4UGYAlwcDd.GzDA2bK', 'xcnzayAU5vf121EYlqBSVTgd73oMCqbFBsHYI9gwECcmPPlbN1C9VABiIzeB', '2018-04-09 01:19:29', '2018-05-07 07:18:46', ''),
(4, 'stock', 'stock@test.com', '$2y$10$aUZrDkUgPKjPbbzEPvcKTOChHzse7D5bMmpwwDDdjmdPBKpNG8wFO', 'W3tOPcCGisBkbYRzKPL2IZcl1Q5TOZDh6j5OJx7PObEECr0Jj7M3kLAwjfhN', '2018-04-09 01:25:39', '2018-04-09 01:25:39', ''),
(5, 'enquiry', 'enquiry@test.com', '$2y$10$hKFErRtQJ8xCRSbvEnOdKOyWaBY7wMwCtSrMLSLiyGdcbCUKZCSve', 'uhkqPVYQfkKASjmkIV82gWpuuwaA8gRKLcArysKe0MFF5bO03xggc2R7PVKu', '2018-04-10 01:41:09', '2018-04-10 01:41:09', ''),
(6, 'farman', 'farman@test.com', '$2y$10$hsqbYIxXJkzxOU8CHJROLuLUvhkwk7glUSKmLc9Y9.EF2UuOJcDiC', 'of28oWT74DqFhLdI5tN0hUHdyyebtRLpPLgsITiZmTAjex8mFbbQVs6OZNsQ', '2018-04-21 23:49:29', '2018-06-02 04:48:18', '1'),
(7, 'root', 'root@test.com', '$2y$10$Olal8yTG2e8gc8v7eo3QLuPUufTe3vLs4BJj0QIgZhOMqJrrmzMbq', NULL, '2018-05-05 05:31:50', '2018-06-02 04:48:31', '0'),
(8, 'admin_user', 'admin_user@test.com', '$2y$10$m5yjCa7lYROw94Hm4.6.Ju1/TAUq5RqBfdo.y2NLpQY81jqcIiwzS', 'CsEfQnrNtXpDwOlHkEfwLtHiE459svzLbRWUfObu7wv39QHn3ZMLgJFbNwfK', '2018-05-05 05:53:46', '2018-06-02 04:48:35', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_enquiry`
--
ALTER TABLE `document_enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_language`
--
ALTER TABLE `document_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document_enquiry`
--
ALTER TABLE `document_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document_language`
--
ALTER TABLE `document_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
