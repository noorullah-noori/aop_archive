-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 09, 2018 at 09:13 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `archive`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_persian_ci NOT NULL,
  `name_en` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
  `description` text COLLATE utf32_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `name_en`, `description`) VALUES
(7, 'فرامین', 'faramin', NULL),
(8, 'احکام', 'ahkam', NULL),
(9, 'هدایت نامه ها', 'hedayat_nama_ha', NULL),
(10, 'مصوبات', 'musawebat', NULL),
(11, 'قوانین', 'qawanin', NULL),
(12, 'طرزالعمل ها', 'tarzul_amal_ha', NULL),
(13, 'مقرره ها', 'muqarara_ha', NULL),
(14, 'اساس نامه ها', 'asas_nama_ha', NULL),
(15, 'معاهدات', 'muahedat', NULL),
(16, 'تفاهم نامه و یاداشت تفاهم نامه ها', 'tafahum_nama_wa_yadasht_tafahum_nama_ha', NULL),
(17, 'پرتوکول ها', 'protocol_ha', NULL),
(18, 'میثاق ها', 'misaq_ha', NULL),
(19, 'مکاتب', 'makatib', NULL),
(20, 'کتب شاهی', 'kutub_e_shahi', NULL),
(21, 'اسناد ملکیت ها', 'asnad_e_melkiat_ha', NULL);

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
(1, 'اداره امور', 'ندارد'),
(2, 'ریاست دفتر', 'جمهوری اسلامی افغانستان'),
(3, 'کمیسیون مستقل انتخابات', 'توضیحات ندارد');

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
  `stock_edit_request_date` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `stock_edit_request_by` int(11) DEFAULT NULL,
  `stock_edit_request_remarks` text COLLATE utf32_persian_ci,
  `stock_edit_request_approve` int(2) DEFAULT NULL COMMENT '0->requested,1->approve,2->reject',
  `stock_edit_request_reject_remarks` text COLLATE utf32_persian_ci,
  `stock_edit_request_approve_by` int(11) DEFAULT NULL,
  `stock_edit_request_approve_date` varchar(20) COLLATE utf32_persian_ci DEFAULT NULL,
  `document_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `number`, `subject`, `date`, `total_pages`, `edition`, `block`, `section`, `row`, `cabinet_side`, `cabinet_row`, `cabinet_column`, `label`, `status`, `remarks`, `created_at`, `updated_at`, `department_id`, `category_id`, `created_by`, `updated_by`, `approve_reject_auth`, `stocked_by`, `stock_updated_by`, `stock_updated_date`, `approved_at`, `rejected_at`, `stocked_date`, `stock_edit_request_date`, `stock_edit_request_by`, `stock_edit_request_remarks`, `stock_edit_request_approve`, `stock_edit_request_reject_remarks`, `stock_edit_request_approve_by`, `stock_edit_request_approve_date`, `document_language_id`) VALUES
(29, 5, 'فرمان ریاست جمهوری', '1397-02-19', 4, 9, '01', 'B', '03', 'A', 2, 3, '01-B-03-A-02-03-D9', 3, 'لسان سند غلط است', '1397-02-19 10:39:35', '1397-02-19 10:47:38', 2, 7, 9, 8, 8, 8, 8, '1397-02-19 11:03:54', '1397-02-19 10:47:53', '1397-02-19 10:47:13', '1397-02-19 10:49:34', '1397-02-19 11:03:33', 8, 'تست', 1, NULL, NULL, '1397-02-19 11:03:45', 10),
(30, 3, 'فرمان شاهی', '1397-02-20', 3, 9, '01', 'D', '03', 'A', NULL, 3, '01-D-A-02-3-9', 3, NULL, '1397-02-19 10:53:23', NULL, 1, 7, 8, NULL, 8, 8, 8, '1397-02-19 11:00:09', '1397-02-19 10:53:37', NULL, '1397-02-19 10:53:56', '1397-02-19 10:54:39', 8, 'شماره الماری غلط است لطفا اجازه تصحیح اعطا فرمایید', 1, NULL, NULL, '1397-02-19 10:55:10', 10);

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
(1, 30, 1),
(2, 29, 1);

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
(9, 'پشتو'),
(10, 'دری'),
(11, 'انگلیسی');

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
  `original` int(11) DEFAULT NULL COMMENT '0->copy,1->original',
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

INSERT INTO `enquiries` (`id`, `enquiry_number`, `approval_authority`, `request_date`, `expected_return_date`, `return_date`, `returned`, `original`, `remarks`, `file_path`, `department_id`, `created_by`, `updated_by`, `received_by`, `created_at`, `updated_at`, `received_at`) VALUES
(1, 234, 'ریاست جمهوری', '1397-02-19', '1397-02-18', '1397-02-01', 1, 1, 'صحیح', 'uploads/enquiries/1.jpg', 3, 8, 8, 8, '1397-02-19 11:07:27', '1397-02-19 11:10:45', '1397-02-19 11:10:57');

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
(2, 6, 'App\\User'),
(2, 7, 'App\\User'),
(2, 8, 'App\\User'),
(2, 9, 'App\\User'),
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
(6, 8, 'App\\User'),
(8, 6, 'App\\User'),
(8, 7, 'App\\User'),
(8, 8, 'App\\User'),
(8, 9, 'App\\User'),
(9, 6, 'App\\User'),
(9, 7, 'App\\User'),
(9, 8, 'App\\User'),
(10, 7, 'App\\User'),
(10, 8, 'App\\User'),
(11, 7, 'App\\User'),
(11, 8, 'App\\User'),
(12, 7, 'App\\User'),
(12, 8, 'App\\User'),
(13, 7, 'App\\User'),
(13, 8, 'App\\User'),
(14, 7, 'App\\User'),
(14, 8, 'App\\User'),
(15, 7, 'App\\User'),
(15, 8, 'App\\User'),
(16, 7, 'App\\User'),
(16, 8, 'App\\User'),
(17, 7, 'App\\User'),
(17, 8, 'App\\User'),
(18, 7, 'App\\User'),
(18, 8, 'App\\User'),
(19, 7, 'App\\User'),
(19, 8, 'App\\User'),
(20, 7, 'App\\User'),
(20, 8, 'App\\User'),
(21, 7, 'App\\User'),
(21, 8, 'App\\User'),
(22, 7, 'App\\User'),
(22, 8, 'App\\User');

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
(1, 'اطلاعیه اول', '<p>بازی زولا یک بازی اکشن اول شخص آنلاین است که بازیکنان با&nbsp;<a href=\"http://account.zula.ir/pages/new-iran?utm_source=p30download&amp;utm_medium=static&amp;utm_campaign=March\" target=\"_blank\" rel=\"noopener\">ثبت نام و فعال سازی اکانت خود در بازی زولا</a>&nbsp;می توانند آن را به صورت&nbsp;<a href=\"http://account.zula.ir/pages/new-iran?utm_source=p30download&amp;utm_medium=static&amp;utm_campaign=March\" target=\"_blank\" rel=\"noopener\">رایگان دانلود</a>&nbsp;و بازی کنند، گیم پلی اصلی بازی زولا شبیه بازیهای رقابتی معروف مثل کانتر است که شما در قالب دو تیم در مقابل هم رقابت می کنید، تیمی که بتوانند بیشترین امتیاز یا تمام افراد تیم مقابل را شکست دهد برنده مسابقه خواهد شد، بازی زولا مخصوص سیستم عامل ویندوز است و به صورت دوره ای مسابقات کشوری برای این بازی به صورت آنلاین برگزار می شود.<br />این بازی کاملا فارسی، به صورت رایگان خدمت شما ارایه می گردد.</p>', 0, '2018-05-09 06:45:42', '2018-05-09 06:45:42');

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
('0f76b70c-31fd-4f50-b4b4-2e505a95f00b', 'App\\Notifications\\DocumentRejected', 9, 'App\\User', '{\"document_id\":29,\"notification\":\"\\u0644\\u0633\\u0627\\u0646 \\u0633\\u0646\\u062f \\u063a\\u0644\\u0637 \\u0627\\u0633\\u062a\",\"rejected_by\":8}', NULL, '2018-05-09 06:15:21', '2018-05-09 06:15:21'),
('7ada46c3-fcb6-4611-b48d-de3db66ad018', 'App\\Notifications\\DocumentRejected', 9, 'App\\User', '{\"document_id\":29,\"notification\":\"\\u0644\\u0633\\u0627\\u0646 \\u0633\\u0646\\u062f \\u063a\\u0644\\u0637 \\u0627\\u0633\\u062a\",\"rejected_by\":8}', NULL, '2018-05-09 06:17:13', '2018-05-09 06:17:13'),
('bf3cdb23-fc99-492a-8823-b5ce7842297b', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":29,\"status\":\"accepted\",\"notification\":\"\'\\u062a\\u0633\\u062a\' \\u067e\\u0630\\u06cc\\u0631\\u0641\\u062a\\u0647 \\u0634\\u062f!\'\"}', NULL, '2018-05-09 06:33:50', '2018-05-09 06:33:50'),
('f670d1af-48d6-4f1b-82f5-03c4052bb2ff', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":30,\"status\":\"accepted\",\"notification\":\"\'\\u0634\\u0645\\u0627\\u0631\\u0647 \\u0627\\u0644\\u0645\\u0627\\u0631\\u06cc \\u063a\\u0644\\u0637 \\u0627\\u0633\\u062a \\u0644\\u0637\\u0641\\u0627 \\u0627\\u062c\\u0627\\u0632\\u0647 \\u062a\\u0635\\u062d\\u06cc\\u062d \\u0627\\u0639\\u0637\\u0627 \\u0641\\u0631\\u0645\\u0627\\u06cc\\u06cc\\u062f\' \\u067e\\u0630\\u06cc\\u0631\\u0641\\u062a\\u0647 \\u0634\\u062f!\'\"}', NULL, '2018-05-09 06:25:15', '2018-05-09 06:25:15');

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
(17, 'show_stocked_edit_status', 'وضعیت تصحیح جابجایی سند', NULL, 'web', '2018-05-09 05:52:54', '2018-05-09 05:52:54');

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
(6, 'admin', 'ادمین', 'web', '2018-04-09 00:37:49', '2018-04-09 00:37:49'),
(8, 'faramin', 'فرامین', 'web', '2018-04-08 20:02:24', '2018-04-08 20:02:24'),
(9, 'ahkam', 'احکام', 'web', '2018-04-09 20:02:24', '2018-04-09 20:02:24'),
(10, 'hedayat_nama_ha', 'هدایت نامه ها', 'web', '2018-04-10 20:02:24', '2018-04-10 20:02:24'),
(11, 'musawebat', 'مصوبات', 'web', '2018-04-11 20:02:24', '2018-04-11 20:02:24'),
(12, 'qawanin', 'قوانین', 'web', '2018-04-12 20:02:24', '2018-04-12 20:02:24'),
(13, 'tarzul_amal_ha', 'طرزالعمل ها', 'web', '2018-04-13 20:02:24', '2018-04-13 20:02:24'),
(14, 'muqarara_ha', 'مقرره ها', 'web', '2018-04-14 20:02:24', '2018-04-14 20:02:24'),
(15, 'asas_nama_ha', 'اساس نامه ها', 'web', '2018-04-15 20:02:24', '2018-04-15 20:02:24'),
(16, 'muahedat', 'معاهدات', 'web', '2018-04-16 20:02:24', '2018-04-16 20:02:24'),
(17, 'tafahum_nama_wa_yadasht_tafahum_nama_ha', 'تفاهم نامه و یاداشت تفاهم نامه ها', 'web', '2018-04-17 20:02:24', '2018-04-17 20:02:24'),
(18, 'protocol_ha', 'پرتوکول ها', 'web', '2018-04-18 20:02:24', '2018-04-18 20:02:24'),
(19, 'misaq_ha', 'میثاق ها', 'web', '2018-04-19 20:02:24', '2018-04-19 20:02:24'),
(20, 'makatib', 'مکاتب', 'web', '2018-04-20 20:02:24', '2018-04-20 20:02:24'),
(21, 'kutub_e_shahi', 'کتب شاهی', 'web', '2018-04-21 20:02:24', '2018-04-21 20:02:24'),
(22, 'asnad_e_melkiat_ha', 'اسناد ملکیت ها', 'web', '2018-04-22 20:02:24', '2018-04-22 20:02:24');

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
(2, 6),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(3, 3),
(3, 6),
(4, 4),
(4, 6),
(5, 5),
(5, 6),
(6, 6),
(6, 8),
(6, 9),
(6, 10),
(6, 11),
(6, 12),
(6, 13),
(6, 14),
(6, 15),
(6, 16),
(6, 17),
(6, 18),
(6, 19),
(6, 20),
(6, 21),
(6, 22),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 12),
(7, 13),
(7, 14),
(7, 15),
(7, 16),
(7, 17),
(7, 18),
(7, 19),
(7, 20),
(7, 21),
(7, 22),
(8, 3),
(8, 6),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(8, 13),
(8, 14),
(8, 15),
(8, 16),
(8, 17),
(8, 18),
(8, 19),
(8, 20),
(8, 21),
(8, 22),
(9, 3),
(9, 6),
(9, 8),
(9, 9),
(9, 10),
(9, 11),
(9, 12),
(9, 13),
(9, 14),
(9, 15),
(9, 16),
(9, 17),
(9, 18),
(9, 19),
(9, 20),
(9, 21),
(9, 22),
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 16),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(10, 21),
(10, 22),
(11, 5),
(12, 5),
(13, 5),
(13, 6),
(14, 4),
(14, 6),
(15, 3),
(17, 4),
(17, 6);

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
(2, 29, 'uploads/7/29_1.jpg'),
(3, 29, 'uploads/7/29_2.jpg'),
(4, 30, 'uploads/7/30_1.jpg'),
(5, 30, 'uploads/7/30_2.jpg');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test@test.com', '$2y$10$TydRg07YYqPU/1RUo0ZZhewrlHHZ6PMKgk0zY58zA.7lSBZQ3DN8i', 'ZEzyIGbZHGZW5QrV68aPx6Y9EMAWdze1b7UqmjgsXKc9DcvM39LFEMkfO5mF', '2018-03-03 05:50:30', '2018-03-03 05:50:30'),
(2, 'entry', 'entry@test.com', '$2y$10$LHOI3d8/d.H3xZI5M8L3VOYrr1I8MPrQ7KEPpU/Up3rFoY/YCxETq', '11QcMEmyej6QdRdhLt5SCXSQO9ZR9eN7zgsbrMok3vas4qqEbojy8lVqYtwT', '2018-04-09 00:43:06', '2018-04-24 23:40:49'),
(3, 'approve', 'approve@test.com', '$2y$10$Z875D7MB4CNuZlj0hLVq8uSCo9/mzbY.LbRlnQLPOwJvKxAwlyuIq', 'yOtyDXxzQARUKjac6LzR5joi185uE2rmKfblLCApDm5pbkvTIxCe1Tks6yoI', '2018-04-09 01:19:29', '2018-04-09 01:19:29'),
(4, 'stock', 'stock@test.com', '$2y$10$Zz54VejyaEGKfFBqm3AyleHJR.DPbCH6y1mDDCZkuB43I6l4ZFeNG', '4NqlANfWV3OzpxeyQSTmRsJkLPnOksrImMgfPbkJXDCIvhlHqKkgSGqVoUPX', '2018-04-09 01:25:39', '2018-05-09 06:06:32'),
(5, 'enquiry', 'enquiry@test.com', '$2y$10$hKFErRtQJ8xCRSbvEnOdKOyWaBY7wMwCtSrMLSLiyGdcbCUKZCSve', 'uhkqPVYQfkKASjmkIV82gWpuuwaA8gRKLcArysKe0MFF5bO03xggc2R7PVKu', '2018-04-10 01:41:09', '2018-04-10 01:41:09'),
(8, 'admin_user', 'admin_user@test.com', '$2y$10$zjTzoCsQ27kKUiPaHAZTg.Krk0Q4p09Fs3jlvrI2GqnhpZh3Bs.JG', 'hM7ayjmeXsYcf1D4mlgF56it386MJAfBfyb2SnGtVSAaKSYNXcft5pFhjyyc', '2018-05-05 05:53:46', '2018-05-09 06:14:23'),
(9, 'farman', 'farman@test.com', '$2y$10$NrCGjOySKAuXFDTSBDAsdepk3yKNUUKZ2o1n0JD/c12b/Fw56mWNq', 'dNWM6ZrFVhX38cr4U8FmhiIKfisb1nht1u57D7xrRofm29RusZpF4yGKWr74', '2018-05-09 06:08:01', '2018-05-09 06:08:01');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `document_enquiry`
--
ALTER TABLE `document_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document_language`
--
ALTER TABLE `document_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
