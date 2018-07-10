-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2018 at 09:17 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.0.27

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
  `receiver` varchar(255) COLLATE utf32_persian_ci DEFAULT NULL,
  `description` text COLLATE utf32_persian_ci COMMENT 'zama yam',
  `document_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_persian_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `number`, `subject`, `date`, `total_pages`, `edition`, `block`, `section`, `row`, `cabinet_side`, `cabinet_row`, `cabinet_column`, `label`, `status`, `remarks`, `created_at`, `updated_at`, `department_id`, `category_id`, `created_by`, `updated_by`, `approve_reject_auth`, `stocked_by`, `stock_updated_by`, `stock_updated_date`, `approved_at`, `rejected_at`, `stocked_date`, `stock_edit_request_date`, `stock_edit_request_by`, `stock_edit_request_remarks`, `stock_edit_request_approve`, `stock_edit_request_reject_remarks`, `stock_edit_request_approve_by`, `stock_edit_request_approve_date`, `receiver`, `description`, `document_language_id`) VALUES
(26, 1, 'حکم ریاست جمهوری', '1397-02-15', 2, 6, '01', 'D', '3', 'A', 3, 2, '01-D-3-A-03-2-D6', 3, 'تعداد صفحات غلط است', '1397-02-15 14:36:41', '1397-02-15 15:38:18', 2, 8, 8, 8, 8, 8, 8, '1397-02-15 16:41:52', '1397-02-18 08:37:10', '1397-02-15 15:37:52', '1397-02-18 09:24:55', '1397-02-15 16:14:15', 8, 'شماره الماری غلط است', 1, NULL, NULL, NULL, '', '', 10),
(27, 1, 'حکم ریاست جمهوری', '1397-02-15', 2, 7, '02', 'H', '3', 'B', 1, 23, '02-H-3-B-03-23-D7', 3, 're', '1397-02-15 14:36:41', '1397-02-15 15:38:18', 2, 8, 8, 8, 8, 8, NULL, NULL, '1397-02-18 09:45:43', '1397-02-18 09:42:51', '1397-02-18 09:46:05', '1397-02-17 14:25:11', 8, 'sdf', 1, NULL, NULL, '1397-02-22 14:38:15', '', '', 10),
(28, 11, 'test1', '1397-02-01', 4, 9, '01', 'A', NULL, 'A', 2, 2, '01-A-A-02-2-9', 3, NULL, '1397-02-18 08:35:56', NULL, 3, 9, 8, NULL, 8, 8, 8, '1397-02-18 09:23:18', '1397-02-18 08:37:40', NULL, '1397-02-18 08:44:57', '1397-02-18 09:13:59', 8, 'test 1', 1, NULL, NULL, '1397-02-18 09:14:50', '', '', 9),
(29, 2, 'test2', '1397-02-01', 3, 5, '01', 'A', NULL, 'A', 1, 4, '01-A-56-A-01-4-D5', 3, 'rejected for test', '1397-02-18 08:36:40', '1397-02-18 09:09:43', 2, 10, 8, 8, 8, 8, NULL, NULL, '1397-02-18 09:10:35', '1397-02-18 08:39:38', '1397-02-18 09:11:01', '1397-02-18 09:12:17', 8, 'cabinet number is wrong', 2, 'file is crashed', NULL, '1397-02-18 09:12:55', '', '', 10),
(30, 4, 'تست', '1397-02-04', 4, 7, '04', 'F', NULL, 'B', 4, 23, '04-F-4-B-04-23-D7', 3, NULL, '1397-02-18 09:31:09', NULL, 3, 9, 8, NULL, 8, 8, NULL, NULL, '1397-02-18 09:31:21', NULL, '1397-02-18 09:31:45', '1397-02-18 09:32:41', 8, 'for test', 2, 'test', NULL, '1397-02-18 14:28:28', '', '', 11),
(31, 1, 'تست', '1397-02-03', 2, 2, '02', 'C', '07', 'A', 1, 6, '02-C-07-A-01-06-D2', 3, NULL, '1397-02-22 14:25:11', NULL, 2, 11, 8, NULL, 8, 8, NULL, NULL, '1397-02-22 14:25:56', NULL, '1397-02-22 14:27:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 10),
(32, 34, 'فف', '1397-02-04', 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'sdaf', '1397-02-25 09:00:51', NULL, 2, 7, 8, NULL, 8, NULL, NULL, NULL, NULL, '1397-02-25 10:02:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 11),
(33, 56, 'فثسف', '1397-02-15', 3, 6, '03', 'F', '45', 'B', 2, 54432, '03-F-45-B-02-54432-D6', 3, NULL, '1397-02-25 09:38:37', '1397-02-25 10:02:14', 3, 8, 8, 8, 8, 8, NULL, NULL, '1397-02-25 10:44:48', NULL, '1397-02-25 14:52:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1aop', 'سند1', 11),
(34, 4544, 'آزمایشی', '1397-02-23', 4, 6, '04', 'I', '44', 'A', 2, 4444, '04-I-44-A-02-4444-D6', 3, NULL, '1397-02-25 14:31:42', NULL, 3, 9, 8, NULL, 8, 8, NULL, NULL, '1397-02-25 14:31:56', NULL, '1397-02-25 14:33:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ریاست دفتر', 'اسنا بسیار قدیمی می باشد', 9);

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
(1, 26, 1),
(2, 26, 2),
(3, 27, 2),
(4, 30, 3),
(5, 26, 3),
(6, 30, 4),
(7, 31, 5),
(8, 29, 5);

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
(1, 34, 'ریاست جمهوری', '1397-02-15', NULL, NULL, 0, 0, NULL, 'uploads/enquiries/1.jpg', 1, 8, NULL, NULL, '1397-02-15 16:43:38', NULL, NULL),
(2, 222, 'ریاست جمهوری', '1397-02-15', '1397-02-19', '1397-02-16', 1, 1, 'درست', 'uploads/enquiries/2.jpg', 2, 8, 8, 8, '1397-02-15 16:45:39', '1397-02-15 16:47:46', '1397-02-15 16:48:20'),
(3, 34, 'abc', '1397-02-02', '1397-02-19', '1397-02-10', 1, 1, 'test', 'uploads/enquiries/3.jpg', 1, 8, NULL, 8, '1397-02-18 13:49:32', NULL, '1397-02-18 13:50:20'),
(4, 54, '45', '1397-02-02', '1397-02-19', '1397-02-19', 1, 1, 'kk', 'uploads/enquiries/4.jpg', 1, 8, NULL, 8, '1397-02-18 14:03:51', NULL, '1397-02-18 14:08:16'),
(5, 67, 'تست', '1397-02-09', '1397-02-03', NULL, 0, 1, NULL, 'uploads/enquiries/5.jpg', 3, 8, NULL, NULL, '1397-02-22 14:36:38', NULL, NULL);

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
(7, 2, 'App\\User'),
(7, 6, 'App\\User'),
(8, 7, 'App\\User'),
(8, 8, 'App\\User'),
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
(1, 'اطلاعیه جدید آفتاب رایانه در خصوص تامین موجودی ها', 'با سلام خدمت همه کاربران آفتاب رایانه ، نمی دانیم جه حکمتی است که هر وقت تلاش می کنیم تا خبر خوبی را اعلام کنیم ، خبر های خوبمان تحت شعاع مسایلی قرار می گیرند که موجب می شود اولویت هایمان تغییر کند و خبر های خوبمان ، بماند برای بعد!به هر حال از خداوند همیشه و در همه حال سپاسگذاریم ، با اینکه از ایتدای سال جاری تا کنون فقط موفق شده ایم یک بار نسبت به ترخیص کالا از گمرک اقدام نماییم ، اما به لطف خداوند همچنان با تمام توان در خدمت دوستان و همراهان گرامی ایستاده ایم. با اینکه قصد نگران کردنتان را نداریم و همیشه سعی می کنیم مسایل و مشکلات را در سکوت حل و فصل نماییم ، اما با توجه به طولانی شدن مشکلات جاری توضیح بعضی از موارد ضروری می باشد:1- با توجه به تغییرات روال ترخیص کالا از گمرکات کشور و همچنین اعلام سیاست های ارزی جدید و پیچ و تاب برداشتن قوانین ،عملا نه برای ما ، بلکه برای بسیاری از وارد کنندگان ، امکان ترخیص کالا از گمرکات کشور تا لحظه نگارش این مطلب وجود ندارد و در بهترین شرایط ممکن است تا دو هفته آینده نیز همین وضعیت ادامه پیدا کند.', 0, '2018-05-08 07:55:01', '2018-05-08 07:55:01'),
(2, 'اطلاعیه اشتراک در ورکشاپ ارتقای ظرفیت برای مسئولان ارشد پوهنتون های دولتی', '<span><b>در مورد برنامه همان گونه که در پلان </b>استراتیژیک ملی تحصیلات عالی آمده است، تحصیلات عالی یکی از محرک های کلیدی رشد اقتصادی است، در پلان استراتیژیک ملی تحصیلات عالی،روی تحصیلات عالی با کیفیت به عنوان \"کلید دستیابی به انکشاف ملی و رفاه شهروندان\" تاکید شده است.برنامه آموزش پیشرفته رهبری پوهنتون ها در افغانستان (AULiA)به عنوان بخشی از استراتیژی جامع ملی می تواند نقش مهمی در انکشاف کشور بازی نماید. هدف اصلی این برنامه تقویت رهبری استراتیژیک مسئولان ارشد در سطوح تصمیم گیری پوهنتونهای کشور می باشد، تا از تجارب و مهارت های آنان بتوان در اولویت های انکشاف ملی کشور استفاده نمود. این برنامه در نظر دارد تا تصمیم گیرندگان اصلی پوهنتون ها را با درک پالیسی و اجرای پالیسی برای تطبیق اهداف پالیسی های ملی تحصیلات عالی آماده نماید تا با استفاده از تقویت اجراآت با کیفیت و حصول اطمینان از اجراآت، تغییرات مثبت در تقویت پوهنتون های کشور به میان آید. به صورت مشخص، برنامه آموزشیAULiA روی دو محور اساسی طراحی شده است، که اهداف هر دو محور از نگاه اهمیت با هم برابر هستند.</span>', 1, '2018-05-13 04:16:03', '2018-05-13 04:16:03'),
(3, 'test', '<ul><li>Ahmad</li><li>mahmod</li><li>ali</li><li>wasi</li></ul><br>', 1, '2018-05-13 04:16:02', '2018-05-13 04:16:02');

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
('0cd41a22-b857-4b5f-9c11-967a12fcd5d7', 'App\\Notifications\\EnquiryDeadlineReaches', 1, 'App\\User', '{\"enquiry_id\":null,\"notification\":\"\\u062a\\u0627\\u0631\\u06cc\\u062e \\u0628\\u0631\\u06af\\u0634\\u062a \\u0633\\u0646\\u062f \\u06f1\\u06f9 \\u062b\\u0648\\u0631 \\u06f1\\u06f3\\u06f9\\u06f7 \\u0645\\u06cc\\u0628\\u0627\\u0634\\u062f.\"}', NULL, '2018-05-08 09:50:05', '2018-05-08 09:50:05'),
('4deca5ff-7204-47d5-abb5-67a3672db24d', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":26,\"notification\":\"\\u062a\\u0639\\u062f\\u0627\\u062f \\u0635\\u0641\\u062d\\u0627\\u062a \\u063a\\u0644\\u0637 \\u0627\\u0633\\u062a\",\"rejected_by\":8}', NULL, '2018-05-05 11:07:52', '2018-05-05 11:07:52'),
('5554c059-193d-4c8c-b9e0-45e9b7919b43', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":26,\"notification\":\"\\u0644\\u0633\\u0627\\u0646 \\u0633\\u0646\\u062f \\u063a\\u0644\\u0637 \\u0627\\u0633\\u062a\",\"rejected_by\":8}', NULL, '2018-05-05 10:49:29', '2018-05-05 10:49:29'),
('589d5e14-1a32-4f15-822f-3881c022eb75', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":30,\"status\":\"accepted\",\"notification\":\"\'for test\' \\u0631\\u062f \\u0634\\u062f!\'\"}', NULL, '2018-05-12 10:00:13', '2018-05-12 10:00:13'),
('662f3783-eaa0-4989-bb6a-5ef8f8ff7e27', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":27,\"status\":\"accepted\",\"notification\":\"\'sdf\' \\u067e\\u0630\\u06cc\\u0631\\u0641\\u062a\\u0647 \\u0634\\u062f!\'\"}', NULL, '2018-05-15 05:35:28', '2018-05-15 05:35:28'),
('7fd04c8b-4e20-46b9-93b9-c3b0fb740d43', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":29,\"notification\":\"rejected for test\",\"rejected_by\":8}', NULL, '2018-05-08 04:09:39', '2018-05-08 04:09:39'),
('82854991-235c-42dc-9285-b68494296f82', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":28,\"status\":\"accepted\",\"notification\":\"\'test 1\' \\u067e\\u0630\\u06cc\\u0631\\u0641\\u062a\\u0647 \\u0634\\u062f!\'\"}', NULL, '2018-05-08 04:44:54', '2018-05-08 04:44:54'),
('857ba38f-7dc8-4aef-a8bc-aff8c33dea60', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":26,\"notification\":\"\\u062a\\u0627\\u0631\\u06cc\\u062e \\u0627\\u0634\\u062a\\u0628\\u0627\\u0647 \\u0627\\u0633\\u062a\",\"rejected_by\":8}', NULL, '2018-05-05 10:07:54', '2018-05-05 10:07:54'),
('93cde1f5-66f3-4d6f-80a8-4d101a24b775', 'App\\Notifications\\EnquiryDeadlineReaches', 1, 'App\\User', '{\"enquiry_id\":null,\"notification\":\"\\u062a\\u0627\\u0631\\u06cc\\u062e \\u0628\\u0631\\u06af\\u0634\\u062a \\u0633\\u0646\\u062f \\u06f1\\u06f9 \\u062b\\u0648\\u0631 \\u06f1\\u06f3\\u06f9\\u06f7 \\u0645\\u06cc\\u0628\\u0627\\u0634\\u062f.\"}', NULL, '2018-05-08 09:50:05', '2018-05-08 09:50:05'),
('bdaee99c-d2f2-4b6f-9eb0-17b2097aa113', 'App\\Notifications\\EnquiryDeadlineReaches', 1, 'App\\User', '{\"enquiry_id\":null,\"notification\":\"\\u062a\\u0627\\u0631\\u06cc\\u062e \\u0628\\u0631\\u06af\\u0634\\u062a \\u0633\\u0646\\u062f \\u06f1\\u06f9 \\u062b\\u0648\\u0631 \\u06f1\\u06f3\\u06f9\\u06f7 \\u0645\\u06cc\\u0628\\u0627\\u0634\\u062f.\"}', NULL, '2018-05-08 09:50:05', '2018-05-08 09:50:05'),
('c6d2a816-7e5f-4e2b-826c-b332270c3316', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":32,\"notification\":\"sdaf\",\"rejected_by\":8}', NULL, '2018-05-15 05:32:38', '2018-05-15 05:32:38'),
('cd650b86-1af6-458e-95b9-3a58925c6d86', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":26,\"status\":\"accepted\",\"notification\":\"\'\\u0634\\u0645\\u0627\\u0631\\u0647 \\u0627\\u0644\\u0645\\u0627\\u0631\\u06cc \\u063a\\u0644\\u0637 \\u0627\\u0633\\u062a\' \\u067e\\u0630\\u06cc\\u0631\\u0641\\u062a\\u0647 \\u0634\\u062f!\'\"}', NULL, '2018-05-05 11:47:35', '2018-05-05 11:47:35'),
('e03d58a3-d387-4e0c-b1f1-7571cf25ffba', 'App\\Notifications\\RequestStatus', 8, 'App\\User', '{\"request_document_id\":29,\"status\":\"accepted\",\"notification\":\"\'cabinet number is wrong\' \\u0631\\u062f \\u0634\\u062f!\'\"}', NULL, '2018-05-08 04:43:06', '2018-05-08 04:43:06'),
('f1a6e4c3-3f97-4747-a854-ad61d04e92d0', 'App\\Notifications\\DocumentRejected', 8, 'App\\User', '{\"document_id\":27,\"notification\":\"re\",\"rejected_by\":8}', NULL, '2018-05-08 05:12:51', '2018-05-08 05:12:51');

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
(16, 'add_order', NULL, NULL, 'web', '2018-04-21 23:59:07', '2018-04-22 00:12:20');

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
(7, 'order', NULL, 'web', '2018-04-21 23:44:57', '2018-04-21 23:54:54'),
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
(15, 3);

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
(58, 26, 'uploads/8/26_1.jpg'),
(59, 28, 'uploads/9/28_1.jpg'),
(60, 28, 'uploads/9/28_2.png'),
(61, 29, 'uploads/10/29_1.jpg'),
(62, 30, 'uploads/9/30_1.jpg'),
(63, 31, 'uploads/11/31_1.png'),
(64, 32, 'uploads/7/32_1.jpg'),
(65, 33, 'uploads/8/33_1.jpg'),
(66, 34, 'uploads/9/34_1.jpg'),
(67, 34, 'uploads/9/34_2.jpg'),
(68, 34, 'uploads/9/34_3.jpg');

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
(1, 'test', 'test@test.com', '$2y$10$TydRg07YYqPU/1RUo0ZZhewrlHHZ6PMKgk0zY58zA.7lSBZQ3DN8i', 'jNDArAgOk40gOGc10B7CSoxBBToMm56a4YvvjEup9AKnSUy54Crp6M5DrYC4', '2018-03-03 05:50:30', '2018-03-03 05:50:30'),
(2, 'entry', 'entry@test.com', '$2y$10$LHOI3d8/d.H3xZI5M8L3VOYrr1I8MPrQ7KEPpU/Up3rFoY/YCxETq', '7WiEU7ipeTpHvSZJVabiUmy1AZOxdCLpF5PY3pG7xTvd5Y8J6iWmM8WnyhFk', '2018-04-09 00:43:06', '2018-04-24 23:40:49'),
(3, 'approve', 'approve@test.com', '$2y$10$Z875D7MB4CNuZlj0hLVq8uSCo9/mzbY.LbRlnQLPOwJvKxAwlyuIq', 'PJkGmpMXxMvJiDQ0HVwviOMJJZgm35BPwGIPInNPdXIhsiXBo00diQeB1mU8', '2018-04-09 01:19:29', '2018-04-09 01:19:29'),
(4, 'stock', 'stock@test.com', '$2y$10$aUZrDkUgPKjPbbzEPvcKTOChHzse7D5bMmpwwDDdjmdPBKpNG8wFO', '1o0xJ6ORJOb6Kk5w4ojRqoQ4gLOpf1gNyAgGEHAJ5FLbDjH1NwWgVV8vEBJK', '2018-04-09 01:25:39', '2018-04-09 01:25:39'),
(5, 'enquiry', 'enquiry@test.com', '$2y$10$hKFErRtQJ8xCRSbvEnOdKOyWaBY7wMwCtSrMLSLiyGdcbCUKZCSve', 'uhkqPVYQfkKASjmkIV82gWpuuwaA8gRKLcArysKe0MFF5bO03xggc2R7PVKu', '2018-04-10 01:41:09', '2018-04-10 01:41:09'),
(6, 'farman', 'farman@test.com', '$2y$10$hsqbYIxXJkzxOU8CHJROLuLUvhkwk7glUSKmLc9Y9.EF2UuOJcDiC', 'KIJ61IKsttyCwnBWGUXIHcTU0ZC5z1aYxvKwFJH7lJnKaCiTeyVBv5w8wgZo', '2018-04-21 23:49:29', '2018-04-30 05:34:48'),
(7, 'root', 'root@test.com', '$2y$10$Olal8yTG2e8gc8v7eo3QLuPUufTe3vLs4BJj0QIgZhOMqJrrmzMbq', NULL, '2018-05-05 05:31:50', '2018-05-05 05:48:31'),
(8, 'admin_user', 'admin_user@test.com', '$2y$10$IS5BmAP7SHxHazo/Q6DyveLXpyZdobkXbHNwq0ig9Zecfsq8LbfSG', 'iBY5R3KP9P4EL2oiEbZUcprep9yeWPilyXjDv0Sw8fUS2eoRYFTFsvfEhxcq', '2018-05-05 05:53:46', '2018-05-05 07:27:47');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `document_enquiry`
--
ALTER TABLE `document_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `document_language`
--
ALTER TABLE `document_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
