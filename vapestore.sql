-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2026 at 06:58 PM
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
-- Database: `vapestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`) VALUES
(3, 'test test eset   setsd gdgd gdfg', 'test-test-eset---setsd-gdgd-gdfg'),
(4, 'warwar', 'warwarwarw');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `custom_url_path` varchar(255) NOT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `featured_image_url` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `custom_url_path`, `author_id`, `featured_image_url`, `excerpt`, `published_at`, `meta_title`, `meta_desc`, `is_active`) VALUES
(1, 4, 'Best Disposable Vapes to Buy Right Now (2026)', 'best-disposable-vapes-to-buy-right-now-2026', NULL, 'uploads/media/1778521935_branding.webp', 'test', '2026-05-06 20:04:14', 'Best Disposable Vapes to Buy Right Now 2026', 'Discover the top disposable vaping devices for 2026. Learn what to look for, compare leading options, explore flavor trends, and choose a device that fits your lifestyle with confidence.', 1),
(2, 3, 'etetete', 'etetete', NULL, 'uploads/media/1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'test', '2026-05-07 14:29:43', 'stsetse', 'tsetet', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo_url`, `is_active`) VALUES
(2, 'test', 'tset', 'uploads/media/1778022073_1777935112_Logo-1.webp', 1),
(3, 'sfsdf', 'sdgsdg', 'uploads/media/1778022073_1777935112_Logo-1.webp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `custom_url_path` varchar(255) NOT NULL COMMENT 'Deep SEO routing path',
  `header_image_url` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `parent_id`, `name`, `custom_url_path`, `header_image_url`, `short_description`, `meta_title`, `meta_desc`, `is_active`) VALUES
(3, NULL, 'test name', 'test-name', 'uploads/media/1778022072_1777680095_ChatGPTImageMay1202609_56_00PM.webp', 'test eetse t stest setse&nbsp;', 'test', 'tset', 1),
(4, 3, 'testt collection ', 'testt-collection', 'uploads/media/1778022072_1777930412_150827453_btzq9g.webp', 'testtt testsete set etset', 'test', 'tsetesset', 1),
(7, 4, 'E-liquids', 'hayati/e-liquids-vape', 'uploads/media/1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', '                        <div id=\"shopify-section-template--20159880593620__custom-content\" class=\"shopify-section\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\"><div class=\"collection-custom-content\" style=\"box-sizing: inherit; margin: 30px 0px;\"><h2 style=\"box-sizing: inherit; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 28px; max-width: 1400px; margin: 0px auto;\">Buy Vape Juice Online| Premium Electronic Cigarette Juice– SkullVaping</h2><p style=\"box-sizing: inherit; color: rgb(85, 85, 85); max-width: 1400px; margin: 0px auto;\">If you are looking for the best vape juice online, you’ve landed at the right place. At SkullVaping, we specialize in providing premium vape juice, flavorful vape liquids, and electronic cigarette juice that deliver rich taste, smooth clouds, and consistent draws, making you extremely satisfied.With a wide variety of blends and strengths to choose from, our online vape juice shop is trusted by many vapers across the USA. Whether you’re chasing clouds, craving bold vape juice flavors, or looking for a reliable e juice store, SkullVaping is your go-to destination.</p></div></div>                    ', 'e-liquid', 'Discover for the #1 vape juice online? At SkullVaping, we offer premium box mod vape juice and electronic cigarette juice from a trusted vape juice online store. Shop quality flavors today!', 1),
(8, NULL, 'dsfsdfg', 'dsfsdfg', 'uploads/media/1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'sdgsfdgfdg', '', '', 1),
(9, NULL, 'DISPOSABLES', 'disposables', '', '<h1 class=\"collection-title\" style=\"font-size: 36px; line-height: 1.2; font-family: Audiowide, sans-serif; color: rgb(0, 0, 0); text-transform: uppercase;\">Premium Vape Collection</h1><p class=\"collection-description\" style=\"margin: 0px; font-size: medium; color: rgb(102, 102, 102); line-height: 1.6; font-family: Inter, sans-serif;\">Explore our curated selection of high-end vaping devices, artisan e-liquids, and essential accessories. Whether you\'re a beginner or a cloud-chasing veteran, we have the perfect gear for your lifestyle.</p>', 'Premium Vape Collection', 'Explore our curated selection of high-end vaping devices, artisan e-liquids, and essential accessories. Whether you\'re a beginner or a cloud-chasing veteran, we have the perfect gear for your lifestyle.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` enum('percentage','fixed_amount','free_shipping') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_uses` int(11) DEFAULT NULL,
  `uses_count` int(11) DEFAULT 0,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order_amount`, `max_uses`, `uses_count`, `start_date`, `end_date`, `is_active`) VALUES
(1, '88OR50I1', 'percentage', 24.00, NULL, 10, 0, '2026-05-06 19:00:00', '2026-05-08 19:00:00', 1),
(2, '51M06OPN', 'fixed_amount', 50.00, NULL, NULL, 0, '2026-05-06 19:00:00', '2026-05-08 19:00:00', 1),
(3, 'TEST', 'percentage', 34.00, NULL, NULL, 0, '2026-05-06 19:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_logs`
--

CREATE TABLE `inventory_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `change_amount` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL COMMENT 'restock, order_sale, return, adjustment',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_logs`
--

INSERT INTO `inventory_logs` (`id`, `variant_id`, `change_amount`, `reason`, `created_at`) VALUES
(4, 4, 123, 'initial_stock', '2026-05-04 16:13:05'),
(5, 5, 123, 'initial_stock', '2026-05-04 16:13:05'),
(6, 6, 15, 'initial_stock', '2026-05-04 17:24:07'),
(7, 7, 15, 'initial_stock', '2026-05-04 17:24:07'),
(8, 8, 15, 'initial_stock', '2026-05-04 17:24:07'),
(9, 9, 15, 'initial_stock', '2026-05-04 17:24:07'),
(32, 47, 10, 'manual_update', '2026-05-06 17:52:03'),
(33, 48, 10, 'manual_update', '2026-05-06 17:52:03'),
(34, 49, 10, 'manual_update', '2026-05-06 17:52:03'),
(35, 50, 10, 'manual_update', '2026-05-06 17:52:03'),
(36, 51, 10, 'manual_update', '2026-05-06 17:52:03'),
(37, 52, 10, 'manual_update', '2026-05-06 17:52:03'),
(38, 53, 10, 'manual_update', '2026-05-06 17:52:03'),
(39, 54, 10, 'manual_update', '2026-05-06 17:52:03'),
(40, 55, 10, 'manual_update', '2026-05-06 17:52:03'),
(41, 56, 10, 'manual_update', '2026-05-06 17:52:03'),
(42, 57, 10, 'manual_update', '2026-05-06 17:52:03'),
(43, 58, 10, 'manual_update', '2026-05-06 17:52:03'),
(44, 59, 10, 'manual_update', '2026-05-06 17:52:03'),
(45, 60, 10, 'manual_update', '2026-05-06 17:52:03'),
(46, 61, 10, 'manual_update', '2026-05-06 17:52:03'),
(47, 62, 10, 'manual_update', '2026-05-06 17:52:03'),
(48, 63, 10, 'manual_update', '2026-05-06 17:52:03'),
(49, 64, 10, 'manual_update', '2026-05-06 17:52:03'),
(50, 65, 10, 'manual_update', '2026-05-06 17:52:03'),
(51, 66, 10, 'manual_update', '2026-05-06 17:52:03'),
(52, 67, 10, 'manual_update', '2026-05-06 17:52:03'),
(53, 68, 10, 'manual_update', '2026-05-06 17:52:03'),
(54, 69, 10, 'manual_update', '2026-05-06 17:52:03'),
(55, 70, 10, 'manual_update', '2026-05-06 17:52:03'),
(56, 71, 10, 'manual_update', '2026-05-06 17:52:03'),
(57, 72, 10, 'manual_update', '2026-05-06 17:52:03'),
(58, 73, 10, 'manual_update', '2026-05-06 17:52:03'),
(59, 74, 49, 'initial_stock', '2026-05-06 17:55:15'),
(60, 75, 49, 'initial_stock', '2026-05-06 17:55:15'),
(64, 79, 433, 'initial_stock', '2026-05-07 17:13:42'),
(65, 80, 433, 'initial_stock', '2026-05-07 17:13:42'),
(66, 81, 15, 'initial_stock', '2026-05-12 18:32:53'),
(67, 82, 15, 'initial_stock', '2026-05-12 18:32:53'),
(68, 83, 15, 'initial_stock', '2026-05-12 18:32:53'),
(69, 84, 15, 'initial_stock', '2026-05-12 18:32:53'),
(70, 85, 15, 'initial_stock', '2026-05-12 18:32:53'),
(71, 86, 15, 'initial_stock', '2026-05-12 18:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `dimensions` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `filename`, `original_name`, `file_path`, `file_type`, `file_size`, `dimensions`, `created_at`) VALUES
(1, '1778019776_Gemini_Generated_Image_vphke4vphke4vphk.webp', 'Gemini_Generated_Image_vphke4vphke4vphk.png', 'uploads/media/1778019776_Gemini_Generated_Image_vphke4vphke4vphk.webp', 'image/webp', 106006, '2816x1536', '2026-05-05 22:22:57'),
(2, '1778019777_Gemini_Generated_Image_1ih1zd1ih1zd1ih1.webp', 'Gemini_Generated_Image_1ih1zd1ih1zd1ih1.png', 'uploads/media/1778019777_Gemini_Generated_Image_1ih1zd1ih1zd1ih1.webp', 'image/webp', 111132, '2816x1536', '2026-05-05 22:22:58'),
(3, '1778019779_Gemini_Generated_Image_f4t5yof4t5yof4t5-clean.webp', 'Gemini_Generated_Image_f4t5yof4t5yof4t5-clean.png', 'uploads/media/1778019779_Gemini_Generated_Image_f4t5yof4t5yof4t5-clean.webp', 'image/webp', 309604, '2848x1500', '2026-05-05 22:23:00'),
(4, '1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', 'Gemini_Generated_Image_f4t5yof4t5yof4t5.png', 'uploads/media/1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', 'image/webp', 309826, '2848x1500', '2026-05-05 22:23:01'),
(5, '1778019781_logo_4.webp', 'logo_4.png', 'uploads/media/1778019781_logo_4.webp', 'image/webp', 48518, '1254x1254', '2026-05-05 22:23:01'),
(7, '1778019782_Logo-1.webp', 'Logo-1.png', 'uploads/media/1778019782_Logo-1.webp', 'image/webp', 27630, '998x891', '2026-05-05 22:23:02'),
(8, '1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', '1777917100_61i+x6jhVcL._AC_UF894,1000_QL80_.jpg', 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 'image/webp', 35962, '894x894', '2026-05-05 22:58:36'),
(9, '1778022070_1777919233_150827453_btzq9g.webp', '1777919233_150827453_btzq9g.png', 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 'image/webp', 16930, '460x460', '2026-05-05 23:01:10'),
(10, '1778022070_1777921015_logo_4.webp', '1777921015_logo_4.png', 'uploads/media/1778022070_1777921015_logo_4.webp', 'image/webp', 50946, '1254x1254', '2026-05-05 23:01:10'),
(11, '1778022071_1777935276_logo_4.webp', '1777935276_logo_4.png', 'uploads/media/1778022071_1777935276_logo_4.webp', 'image/webp', 50946, '1254x1254', '2026-05-05 23:01:11'),
(12, '1778022071_1777679489_includes_uploads_private_attachments_Zain.webp', '1777679489_includes_uploads_private_attachments_Zain.png', 'uploads/media/1778022071_1777679489_includes_uploads_private_attachments_Zain.webp', 'image/webp', 118422, '1254x1254', '2026-05-05 23:01:12'),
(13, '1778022072_1777680095_ChatGPTImageMay1202609_56_00PM.webp', '1777680095_ChatGPTImageMay1202609_56_00PM.png', 'uploads/media/1778022072_1777680095_ChatGPTImageMay1202609_56_00PM.webp', 'image/webp', 186230, '1254x1254', '2026-05-05 23:01:12'),
(14, '1778022072_1777930412_150827453_btzq9g.webp', '1777930412_150827453_btzq9g.png', 'uploads/media/1778022072_1777930412_150827453_btzq9g.webp', 'image/webp', 16930, '460x460', '2026-05-05 23:01:12'),
(15, '1778022072_1777933964_Logo-1.webp', '1777933964_Logo-1.png', 'uploads/media/1778022072_1777933964_Logo-1.webp', 'image/webp', 29502, '998x891', '2026-05-05 23:01:13'),
(16, '1778022073_1777935112_Logo-1.webp', '1777935112_Logo-1.png', 'uploads/media/1778022073_1777935112_Logo-1.webp', 'image/webp', 29502, '998x891', '2026-05-05 23:01:13'),
(17, '1778025087_Screenshot2025-11-10141604.webp', 'Screenshot 2025-11-10 141604.png', 'uploads/media/1778025087_Screenshot2025-11-10141604.webp', 'image/webp', 32678, '789x591', '2026-05-05 23:51:27'),
(18, '1778025129_Screenshot2025-11-12024730.webp', 'Screenshot 2025-11-12 024730.png', 'uploads/media/1778025129_Screenshot2025-11-12024730.webp', 'image/webp', 23180, '1340x470', '2026-05-05 23:52:09'),
(19, '1778025129_Screenshot2025-11-12024753.webp', 'Screenshot 2025-11-12 024753.png', 'uploads/media/1778025129_Screenshot2025-11-12024753.webp', 'image/webp', 12426, '592x527', '2026-05-05 23:52:09'),
(20, '1778025324_Screenshot2025-11-11230254.webp', 'Screenshot 2025-11-11 230254.png', 'uploads/media/1778025324_Screenshot2025-11-11230254.webp', 'image/webp', 34538, '557x311', '2026-05-05 23:55:24'),
(21, '1778025343_Screenshot2025-11-11041521.webp', 'Screenshot 2025-11-11 041521.png', 'uploads/media/1778025343_Screenshot2025-11-11041521.webp', 'image/webp', 22624, '1445x428', '2026-05-05 23:55:43'),
(22, '1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'WhatsApp Image 2026-05-06 at 1.26.09 AM.jpeg', 'uploads/media/1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'image/webp', 33146, '768x1024', '2026-05-07 17:20:50'),
(23, '1778179982_WhatsAppImage2026-05-06at12609AM.webp', 'WhatsApp Image 2026-05-06 at 1.26.09 AM.jpeg', 'uploads/media/1778179982_WhatsAppImage2026-05-06at12609AM.webp', 'image/webp', 33146, '768x1024', '2026-05-07 18:53:02'),
(24, '1778194136_carousel-1.webp', 'carousel-1.jpg', 'uploads/media/1778194136_carousel-1.webp', 'image/webp', 51636, '1410x531', '2026-05-07 22:48:57'),
(25, '1778194137_carousel-2.webp', 'carousel-2.jpg', 'uploads/media/1778194137_carousel-2.webp', 'image/webp', 67294, '1411x330', '2026-05-07 22:48:57'),
(26, '1778194137_carousel-3.webp', 'carousel-3.webp', 'uploads/media/1778194137_carousel-3.webp', 'image/webp', 93924, '2540x1120', '2026-05-07 22:48:58'),
(27, '1778194138_vape-hero-bg.webp', 'vape-hero-bg.png', 'uploads/media/1778194138_vape-hero-bg.webp', 'image/webp', 39004, '1024x555', '2026-05-07 22:48:58'),
(28, '1778197030_smoke_bg.webp', 'smoke_bg.png', 'uploads/media/1778197030_smoke_bg.webp', 'image/webp', 102248, '1024x1024', '2026-05-07 23:37:10'),
(29, '1778521935_branding.webp', 'branding.jpg', 'uploads/media/1778521935_branding.webp', 'image/webp', 222050, '2432x3648', '2026-05-11 17:52:17'),
(30, '1778521937_Logos-01.webp', 'Logos-01.png', 'uploads/media/1778521937_Logos-01.webp', 'image/webp', 2776, '185x131', '2026-05-11 17:52:17'),
(31, '1778521937_Logos-02.webp', 'Logos-02.png', 'uploads/media/1778521937_Logos-02.webp', 'image/webp', 4522, '207x130', '2026-05-11 17:52:17'),
(32, '1778521937_Logos-03.webp', 'Logos-03.png', 'uploads/media/1778521937_Logos-03.webp', 'image/webp', 4738, '184x130', '2026-05-11 17:52:17'),
(33, '1778521937_Logos-04.webp', 'Logos-04.png', 'uploads/media/1778521937_Logos-04.webp', 'image/webp', 1686, '183x131', '2026-05-11 17:52:17'),
(34, '1778521937_Logos-05.webp', 'Logos-05.png', 'uploads/media/1778521937_Logos-05.webp', 'image/webp', 1512, '225x107', '2026-05-11 17:52:18'),
(35, '1778521938_Logos-06.webp', 'Logos-06.png', 'uploads/media/1778521938_Logos-06.webp', 'image/webp', 2660, '336x57', '2026-05-11 17:52:18'),
(36, '1778521938_Logos-07.webp', 'Logos-07.png', 'uploads/media/1778521938_Logos-07.webp', 'image/webp', 2812, '188x145', '2026-05-11 17:52:18'),
(37, '1778521938_Logos-08.webp', 'Logos-08.png', 'uploads/media/1778521938_Logos-08.webp', 'image/webp', 2018, '197x79', '2026-05-11 17:52:18'),
(38, '1778521938_Logos-09.webp', 'Logos-09.png', 'uploads/media/1778521938_Logos-09.webp', 'image/webp', 1612, '282x69', '2026-05-11 17:52:18'),
(39, '1778521938_Logos-10.webp', 'Logos-10.png', 'uploads/media/1778521938_Logos-10.webp', 'image/webp', 2356, '132x133', '2026-05-11 17:52:18'),
(40, '1778522148_theperfectvape.webp', 'theperfectvape.png', 'uploads/media/1778522148_theperfectvape.webp', 'image/webp', 6422, '117x108', '2026-05-11 17:55:48'),
(41, '1778624908_ThePerfectVape-FinalLogo.webp', 'ThePerfectVape-FinalLogo.png', 'uploads/media/1778624908_ThePerfectVape-FinalLogo.webp', 'image/webp', 208388, '1750x1750', '2026-05-12 22:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL COMMENT 'e.g. header_main, footer_links'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `location`) VALUES
(2, 'Main menu', 'main_menu'),
(3, 'Footer Menu', 'footer_menu'),
(4, 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `link_type` enum('collection','brand','page','custom_url','mega_menu_column','promo_banner','text_block','newsletter','html') NOT NULL,
  `link_value` text DEFAULT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `css_class` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `title`, `link_type`, `link_value`, `entity_id`, `image_url`, `css_class`, `sort_order`) VALUES
(21, 4, NULL, 'test', 'custom_url', 'test', NULL, NULL, NULL, 0),
(22, 4, 21, 'test', 'page', '/pages/privacy', NULL, NULL, NULL, 0),
(203, 3, NULL, 'You Have To Be Over 18 To Purchase', 'text_block', '<p>Vape kits might contain nicotine, which is addictive. These vaping devices are designed for individuals aged 18 or above. They are unsuitable for people who are allergic/sensitive to nicotine, pregnant or breastfeeding women, those with unstable heart conditions, and individuals who should avoid nicotine for medical reasons, as they could pose health risks. Make sure to keep vape kits or disposable vapes out of the reach of children.</p>', NULL, NULL, NULL, 0),
(204, 3, NULL, 'Quick Links', '', '#', NULL, NULL, NULL, 1),
(205, 3, 204, 'Contact Us', 'custom_url', '/contnact', NULL, NULL, NULL, 0),
(206, 3, 204, 'My Account', 'custom_url', '/', NULL, NULL, NULL, 1),
(207, 3, 204, 'Wishlist', 'custom_url', 'Wishlist', NULL, NULL, NULL, 2),
(208, 3, 204, 'Vaping Blogs', 'custom_url', 'Vaping Blogs', NULL, NULL, NULL, 3),
(209, 3, NULL, 'Policies', '', '#', NULL, NULL, NULL, 2),
(210, 3, 209, 'Shipping Policy', 'page', '/pages/privacy', NULL, NULL, NULL, 0),
(211, 3, 209, 'Refund Policy', 'page', '/pages/privacy', NULL, NULL, NULL, 1),
(212, 3, 209, 'Refund Policy', 'custom_url', 'Refund Policy', NULL, NULL, NULL, 2),
(213, 3, 209, 'Terms & Conditions', 'page', '/pages/privacy', NULL, NULL, NULL, 3),
(214, 3, NULL, 'Contact Us', '', '#', NULL, NULL, NULL, 3),
(215, 3, 214, 'info@theperfectvape.com', 'custom_url', 'info@theperfectvape.com', NULL, NULL, NULL, 0),
(216, 3, 214, '+44 20 7123 4567', 'custom_url', '+44 20 7123 4567', NULL, NULL, NULL, 1),
(217, 3, 214, '15 St Oswald\'s Street, Liverpool, L13 5SA', '', '#', NULL, NULL, NULL, 2),
(218, 3, NULL, 'test', 'promo_banner', '', NULL, 'http://localhost/vapestore-UI/assets/footer/branding.jpg', NULL, 4),
(248, 2, NULL, 'Home', 'custom_url', '/', NULL, NULL, NULL, 0),
(249, 2, NULL, 'Shop', '', '#', NULL, NULL, NULL, 1),
(250, 2, 249, 'All Products', 'collection', '/collections', NULL, NULL, NULL, 0),
(251, 2, 249, 'New arrivals', 'collection', '/collections/test-name', NULL, NULL, NULL, 1),
(252, 2, 249, 'Best seller', 'collection', '/collections/dsfsdfg', NULL, NULL, NULL, 2),
(253, 2, NULL, ' Disposables', 'mega_menu_column', '', NULL, NULL, NULL, 2),
(254, 2, 253, 'By Brand', '', '#', NULL, NULL, NULL, 0),
(255, 2, 254, 'Geek Bar', 'brand', '/brands/tset', NULL, NULL, NULL, 0),
(256, 2, 254, 'Hayati', 'brand', '/brands/tset', NULL, NULL, NULL, 1),
(257, 2, 254, 'Gold Bar', 'brand', '/brands/tset', NULL, NULL, NULL, 2),
(258, 2, 254, 'Crystal', 'brand', '/brands/sdgsdg', NULL, NULL, NULL, 3),
(259, 2, 253, 'By Puff Count', '', '#', NULL, NULL, NULL, 1),
(260, 2, 259, '600 Puffs', 'custom_url', 'tetset', NULL, NULL, NULL, 0),
(261, 2, 259, '4000 Puffs', 'custom_url', 'sfwqrfdg', NULL, NULL, NULL, 1),
(262, 2, 259, '10000+ Puffs', 'collection', '/collections/e-liquids', NULL, NULL, NULL, 2),
(263, 2, 259, 'Nicotine Free', 'custom_url', 'sgfg', NULL, NULL, NULL, 3),
(264, 2, 253, 'Trending Now', '', '#', NULL, NULL, NULL, 2),
(265, 2, 264, 'Hayati Pro Max', 'collection', '/collection/hayati/e-liquids', 7, NULL, NULL, 0),
(266, 2, 264, 'Geek Bar Meloso', 'custom_url', 'dgfdg', NULL, NULL, NULL, 1),
(267, 2, 264, 'SKE Crystal 600', 'custom_url', 'dfdgfg', NULL, NULL, NULL, 2),
(268, 2, 264, 'IVG 2400 Edition', 'custom_url', 'etgrgrgt', NULL, NULL, NULL, 3),
(269, 2, 253, 'New deal XYZ', 'promo_banner', 'http://localhost/vapestore-UI/collection', NULL, 'http://localhost/vapestore/uploads/media/1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', NULL, 3),
(270, 2, NULL, 'Nicotine Pouches', 'collection', '/collections/testt-collection', NULL, NULL, NULL, 3),
(271, 2, NULL, 'Resources', '', '#', NULL, NULL, NULL, 4),
(272, 2, 271, 'Our Blog', 'page', '/page/test', NULL, NULL, NULL, 0),
(273, 2, 271, 'Contact Us ', 'page', '/pages/test', NULL, NULL, NULL, 1),
(274, 2, 271, 'Shipping Policy', 'page', '/pages/privacy', NULL, NULL, NULL, 2),
(275, 2, 271, ' Track Order', 'custom_url', 'sdsd', NULL, NULL, NULL, 3),
(276, 2, 271, ' FAQs', 'custom_url', 'sdsd', NULL, NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `coupon_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `shipping_status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_carrier` varchar(100) DEFAULT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `custom_url_path` varchar(255) NOT NULL COMMENT 'e.g. /privacy-policy',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `custom_url_path`, `meta_title`, `meta_desc`, `is_active`) VALUES
(1, 'privacy', 'privacy', 'Privacy Policy', 'testing ', 1),
(4, 'test', 'test', 'test', 'tset', 1),
(5, 'wetwetwetwet', 'wetwetwetwet', 'test', 'setset', 1),
(6, 'dfsdfdvfgf', 'dfsdfdvfgf', 'tyrgytr', 'yhdhg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `custom_url` varchar(255) NOT NULL COMMENT 'For deep SEO paths',
  `short_desc` text DEFAULT NULL,
  `long_desc` longtext DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `tags` text DEFAULT NULL,
  `option_names` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `name`, `custom_url`, `short_desc`, `long_desc`, `base_price`, `compare_price`, `status`, `tags`, `option_names`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(5, NULL, 'T-shirt', 't-shirt', '', '', 15000.00, NULL, 'published', '', '[\"Option 1\"]', 'yrdy', 'yryrdy', '2026-05-04 16:13:05', '2026-05-11 18:39:51'),
(6, NULL, 'AuraGlow LED Touch Night Lamp', 'auraglow-led-touch-night-lamp', '', '', 14.99, NULL, 'published', '', '[\"Option 1\",\"Option 2\"]', 'AuraGlow LED Touch Night Lamp', 'Portable rechargeable LED touch lamp with adjustable brightness levels. Perfect for bedside tables, study desks, and room decor. Modern minimalist design with soft ambient lighting.', '2026-05-04 17:24:07', '2026-05-11 18:39:45'),
(21, NULL, 'Box Package', 'test', 'Box Package Box Package', 'Box Package&nbsp;Box Package&nbsp;Box Package', 50.00, NULL, 'published', '', '[\"color\",\"Mgs\",\"Puffs\"]', '', 'test', '2026-05-06 17:38:50', '2026-05-08 00:03:10'),
(22, NULL, 'sdfsdfs', 'sdfsdfs', 'dfsdfs', 'dfsdf', 49.99, NULL, 'published', '', '[\"test\"]', '', '', '2026-05-06 17:55:15', '2026-05-08 00:03:18'),
(23, NULL, 'test', 'test-1', 'stsets', 'tgsdgfd', 35.00, NULL, 'published', 'test,tetet,tetetet,etetet,e,tet,y,ws,sdg,dgf,sdf', NULL, '', '', '2026-05-06 17:59:06', '2026-05-08 00:03:25'),
(25, 3, 'testsgdf', 'testtet', 'gdfgsdg', 'sdgfgdfgfg', 34.99, 36.99, 'published', 'new,water bottle,smart bottle', '[\"est\"]', '', 'testset', '2026-05-07 17:13:42', '2026-05-11 22:03:23'),
(26, 2, 'Short Sleeves T-Shirt', 'short-sleeves-t-shirt', 'testing short description of Short Sleeves T-Shirt', 'testing Long description of Short Sleeves T-Shirt , testing Long description of Short Sleeves T-Shirt&nbsp;', 49.99, 59.99, 'published', '', '[\"color\",\"Fabric\"]', '', 'testing short description of Short Sleeves T-Shirt', '2026-05-12 18:32:53', '2026-05-12 18:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_collections`
--

CREATE TABLE `product_collections` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `collection_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_collections`
--

INSERT INTO `product_collections` (`product_id`, `collection_id`) VALUES
(5, 3),
(5, 9),
(6, 3),
(6, 9),
(21, 3),
(21, 9),
(22, 3),
(22, 9),
(23, 3),
(23, 4),
(23, 9),
(25, 7),
(25, 9),
(26, 7),
(26, 9);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `variant_id`, `image_url`, `sort_order`) VALUES
(22, 21, NULL, 'uploads/media/1778025343_Screenshot2025-11-11041521.webp', 0),
(23, 21, NULL, 'uploads/media/1778025324_Screenshot2025-11-11230254.webp', 1),
(24, 21, NULL, 'uploads/media/1778025129_Screenshot2025-11-12024730.webp', 2),
(25, 22, NULL, 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 1),
(26, 22, NULL, 'uploads/media/1778022070_1777921015_logo_4.webp', 3),
(27, 22, NULL, 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 5),
(28, 22, NULL, 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 1),
(29, 22, NULL, 'uploads/media/1778022070_1777921015_logo_4.webp', 3),
(30, 22, NULL, 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 5),
(31, 23, NULL, 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 0),
(32, 23, NULL, 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 1),
(33, 23, NULL, 'uploads/media/1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', 2),
(37, 25, NULL, 'uploads/media/1778025324_Screenshot2025-11-11230254.webp', 0),
(38, 25, NULL, 'uploads/media/1778025129_Screenshot2025-11-12024730.webp', 1),
(39, 25, NULL, 'uploads/media/1778025129_Screenshot2025-11-12024753.webp', 2),
(40, 26, NULL, 'uploads/media/1778194137_carousel-3.webp', 3),
(41, 26, NULL, 'uploads/media/1778194138_vape-hero-bg.webp', 4),
(42, 26, NULL, 'uploads/media/1778194137_carousel-2.webp', 5),
(43, 26, NULL, 'uploads/media/1778194137_carousel-3.webp', 3),
(44, 26, NULL, 'uploads/media/1778194138_vape-hero-bg.webp', 4),
(45, 26, NULL, 'uploads/media/1778194137_carousel-2.webp', 5);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `customer_name`, `user_id`, `rating`, `title`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 25, 'test', NULL, 3, 'tset', 'test', 'approved', '2026-05-12 00:01:42', '2026-05-12 21:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0,
  `variant_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `price`, `compare_price`, `stock_quantity`, `is_default`, `variant_name`) VALUES
(4, 5, '1232345-black', 15000.00, NULL, 123, 0, 'black'),
(5, 5, '1232345-blue', 15000.00, NULL, 123, 0, 'blue'),
(6, 6, 'AGL-001-black-large', 14.99, NULL, 15, 0, 'Black / Large'),
(7, 6, 'AGL-001-black-small', 14.99, NULL, 15, 0, 'Black / Small'),
(8, 6, 'AGL-001-white-large', 14.99, NULL, 15, 0, 'White / Large'),
(9, 6, 'AGL-001-white-small', 14.99, NULL, 15, 0, 'White / Small'),
(47, 21, 'SKU-21-black-12mg-100', 50.00, NULL, 10, 0, 'black / 12mg / 100'),
(48, 21, 'SKU-21-black-12mg-500', 50.00, NULL, 10, 0, 'black / 12mg / 500'),
(49, 21, 'SKU-21-black-12mg-1000', 50.00, NULL, 10, 0, 'black / 12mg / 1000'),
(50, 21, 'SKU-21-black-16mg-100', 50.00, NULL, 10, 0, 'black / 16mg / 100'),
(51, 21, 'SKU-21-black-16mg-500', 50.00, NULL, 10, 0, 'black / 16mg / 500'),
(52, 21, 'SKU-21-black-16mg-1000', 50.00, NULL, 10, 0, 'black / 16mg / 1000'),
(53, 21, 'SKU-21-black-20mg-100', 50.00, NULL, 10, 0, 'black / 20mg / 100'),
(54, 21, 'SKU-21-black-20mg-500', 50.00, NULL, 10, 0, 'black / 20mg / 500'),
(55, 21, 'SKU-21-black-20mg-1000', 50.00, NULL, 10, 0, 'black / 20mg / 1000'),
(56, 21, 'SKU-21-blue-12mg-100', 50.00, NULL, 10, 0, 'Blue / 12mg / 100'),
(57, 21, 'SKU-21-blue-12mg-500', 50.00, NULL, 10, 0, 'Blue / 12mg / 500'),
(58, 21, 'SKU-21-blue-12mg-1000', 50.00, NULL, 10, 0, 'Blue / 12mg / 1000'),
(59, 21, 'SKU-21-blue-16mg-100', 50.00, NULL, 10, 0, 'Blue / 16mg / 100'),
(60, 21, 'SKU-21-blue-16mg-500', 50.00, NULL, 10, 0, 'Blue / 16mg / 500'),
(61, 21, 'SKU-21-blue-16mg-1000', 50.00, NULL, 10, 0, 'Blue / 16mg / 1000'),
(62, 21, 'SKU-21-blue-20mg-100', 50.00, NULL, 10, 0, 'Blue / 20mg / 100'),
(63, 21, 'SKU-21-blue-20mg-500', 50.00, NULL, 10, 0, 'Blue / 20mg / 500'),
(64, 21, 'SKU-21-blue-20mg-1000', 50.00, NULL, 10, 0, 'Blue / 20mg / 1000'),
(65, 21, 'SKU-21-white-12mg-100', 50.00, NULL, 10, 0, 'White / 12mg / 100'),
(66, 21, 'SKU-21-white-12mg-500', 50.00, NULL, 10, 0, 'White / 12mg / 500'),
(67, 21, 'SKU-21-white-12mg-1000', 50.00, NULL, 10, 0, 'White / 12mg / 1000'),
(68, 21, 'SKU-21-white-16mg-100', 50.00, NULL, 10, 0, 'White / 16mg / 100'),
(69, 21, 'SKU-21-white-16mg-500', 50.00, NULL, 10, 0, 'White / 16mg / 500'),
(70, 21, 'SKU-21-white-16mg-1000', 50.00, NULL, 10, 0, 'White / 16mg / 1000'),
(71, 21, 'SKU-21-white-20mg-100', 50.00, NULL, 10, 0, 'White / 20mg / 100'),
(72, 21, 'SKU-21-white-20mg-500', 50.00, NULL, 10, 0, 'White / 20mg / 500'),
(73, 21, 'SKU-21-white-20mg-1000', 50.00, NULL, 10, 0, 'White / 20mg / 1000'),
(74, 22, 'SKU-22-test', 49.99, NULL, 49, 0, 'test'),
(75, 22, 'SKU-22-tes', 49.99, NULL, 49, 0, 'tes'),
(79, 25, 'SKU-25-test', 34.99, 36.99, 433, 0, 'test'),
(80, 25, 'SKU-25-tset', 34.99, 36.99, 433, 0, 'tset'),
(81, 26, 'SKU-26-black-old', 49.99, 59.99, 15, 0, 'black / old'),
(82, 26, 'SKU-26-black-new', 49.99, 59.99, 15, 0, 'black / New'),
(83, 26, 'SKU-26-blue-old', 49.99, 59.99, 15, 0, 'Blue / old'),
(84, 26, 'SKU-26-blue-new', 49.99, 59.99, 15, 0, 'Blue / New'),
(85, 26, 'SKU-26-white-old', 49.99, 59.99, 15, 0, 'White / old'),
(86, 26, 'SKU-26-white-new', 49.99, 59.99, 15, 0, 'White / New');

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'store_name', 'The Perfect Vape'),
(2, 'store_email', 'info@theperfectvape.com'),
(3, 'store_phone', '+44 20 7123 4567'),
(4, 'store_address', '15 St Oswald\'s Street, Liverpool, L13 5SA'),
(5, 'footer_copyright', '© 2026 The Perfect Vape. All Rights Reserved.'),
(6, 'seo_home_title', 'The Perfect Vape | Premium Vaping Supplies'),
(7, 'seo_home_desc', 'Find the best vapes, e-liquids, and accessories at The Perfect Vape. Fast shipping and premium quality guaranteed.'),
(8, 'store_currency', 'USD'),
(9, 'store_weight_unit', 'kg'),
(10, 'payment_logo_1', 'http://localhost/vapestore/uploads/media/1778521937_Logos-04.webp'),
(11, 'payment_logo_2', 'http://localhost/vapestore/uploads/media/1778521937_Logos-03.webp'),
(12, 'payment_logo_3', 'http://localhost/vapestore/uploads/media/1778521937_Logos-02.webp'),
(13, 'payment_logo_4', 'http://localhost/vapestore/uploads/media/1778521937_Logos-01.webp'),
(14, 'payment_logo_5', 'http://localhost/vapestore/uploads/media/1778521938_Logos-10.webp'),
(15, 'payment_logo_6', 'http://localhost/vapestore/uploads/media/1778521938_Logos-09.webp'),
(16, 'payment_logo_7', 'http://localhost/vapestore/uploads/media/1778521938_Logos-08.webp'),
(17, 'payment_logo_8', 'http://localhost/vapestore/uploads/media/1778521938_Logos-07.webp'),
(18, 'store_logo', 'http://localhost/vapestore/uploads/media/1778624908_ThePerfectVape-FinalLogo.webp'),
(19, 'store_favicon', 'http://localhost/vapestore/uploads/media/1778624908_ThePerfectVape-FinalLogo.webp'),
(20, 'csrf_token', '8e8225ace0343cacfe285b34bd3b3ffc9a3518165c6cd8b9b41a9a7356852f45');

-- --------------------------------------------------------

--
-- Table structure for table `ui_sections`
--

CREATE TABLE `ui_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entity_type` varchar(50) NOT NULL COMMENT 'page, collection, post, global_home',
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(50) NOT NULL COMMENT 'rich_text, hero_banner, bento_grid, video_block',
  `title` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ui_sections`
--

INSERT INTO `ui_sections` (`id`, `entity_type`, `entity_id`, `type`, `title`, `button_text`, `button_url`, `sort_order`, `is_active`) VALUES
(1, 'collection', 3, 'bento_grid', NULL, NULL, NULL, 0, 1),
(2, 'page', 1, 'rich_text', NULL, NULL, NULL, 0, 1),
(4, 'page', 2, 'rich_text', NULL, NULL, NULL, 0, 1),
(5, 'global_home', NULL, 'hero_slider', '', '', '', 1, 1),
(6, 'global_home', NULL, 'promo_grid', '', '', '', 0, 1),
(7, 'global_home', NULL, 'feature_highlight', '', '', '', 2, 1),
(8, 'global_home', NULL, 'brand_story', '', '', '', 3, 1),
(13, 'blog', 1, 'rich_text', NULL, NULL, NULL, 0, 1),
(14, 'blog', 1, 'product_embed', NULL, NULL, NULL, 1, 1),
(15, 'blog', 1, 'rich_text', NULL, NULL, NULL, 2, 1),
(18, 'page', 5, 'rich_text', NULL, NULL, NULL, 0, 1),
(19, 'page', 6, 'rich_text', NULL, NULL, NULL, 0, 1),
(22, 'collection', 7, 'rich_text', NULL, NULL, NULL, 0, 1),
(23, 'collection', 7, 'faq', '', NULL, NULL, 1, 1),
(24, 'global_home', NULL, 'collection_grid', 'Featured Products', 'shop all', 'collection/all', 4, 1),
(25, 'global_home', NULL, 'collection_grid', 'New Arrivals', 'shop all', 'collection/all', 5, 1),
(26, 'global_home', NULL, 'faq', 'Frequently Asked Questions', '', '', 6, 1),
(27, 'global_home', NULL, 'collection_grid', 'Best seller', 'view all', 'collection/all', 7, 1),
(29, 'global_home', NULL, 'categories_grid', '', '', '', 8, 1),
(30, 'global_home', NULL, 'brands_swiper', '', '', '', 9, 1),
(31, 'global_home', NULL, 'testimonials', 'What Our Customers Say', '', '', 10, 1),
(32, 'collection', 9, 'smoke_section', NULL, NULL, NULL, 0, 1),
(33, 'collection', 9, 'offer_section', NULL, NULL, NULL, 1, 1),
(34, 'collection', 9, 'bento_grid', NULL, NULL, NULL, 2, 1),
(35, 'blog', 1, 'product_embed', NULL, NULL, NULL, 3, 1),
(36, 'page', 4, 'rich_text', NULL, NULL, NULL, 0, 1),
(37, 'product', 26, 'smoke_section', NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ui_section_items`
--

CREATE TABLE `ui_section_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `button_text` varchar(100) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ui_section_items`
--

INSERT INTO `ui_section_items` (`id`, `section_id`, `entity_id`, `entity_type`, `title`, `content`, `image_url`, `video_url`, `button_text`, `button_url`, `sort_order`) VALUES
(3, 1, NULL, NULL, 'test', 'tesgfdgfhfgjhfghfghdgfgfdg', 'https://m.media-amazon.com/images/I/61i+x6jhVcL._AC_UF894,1000_QL80_.jpg', NULL, 'advance', NULL, 0),
(8, 4, NULL, NULL, 'Privacy Policy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe magnam dolore dicta deleniti. Aperiam magnam dolorum molestias sit sunt aliquid explicabo quo nisi. Sit esse impedit officiis perspiciatis a veniam expedita perferendis id porro corporis eos rem, et ipsum est necessitatibus deleniti maiores? Enim, veniam omnis nihil magnam eligendi molestiae maxime, commodi iusto ullam consectetur, delectus culpa tenetur odit laboriosam amet nesciunt! Esse rerum quidem, saepe, minus placeat dignissimos amet doloremque vitae aspernatur voluptas tenetur repellat sed iusto deserunt at dicta similique nulla eaque maxime ad ipsum molestiae eum quisquam! Alias, officiis porro. Suscipit deleniti optio praesentium odit doloremque delectus quisquam animi pariatur nostrum tenetur cum, exercitationem officia tempora numquam sequi! Nobis neque, accusamus doloremque et alias impedit voluptate iusto inventore amet sed iste id dolores explicabo praesentium omnis eligendi distinctio enim laudantium molestiae autem cumque dignissimos facilis necessitatibus. Repellendus aut iste magni laborum odit saepe possimus officiis dicta in tempore molestias, beatae culpa vel unde, placeat expedita sapiente omnis eligendi accusamus ipsum harum eum rerum autem quasi. Molestiae doloremque nemo mollitia quisquam voluptates ullam est? Expedita odit quo qui totam obcaecati autem saepe sed cum sit illo rerum sint at aut aliquid vel, quos doloribus libero corporis consequatur laboriosam officiis! Qui, harum quasi. Illo in provident atque dolor consequatur illum eveniet minus, delectus optio quisquam fuga quo? Saepe obcaecati vitae fugit vel eius repellat alias? Eligendi asperiores pariatur nam ducimus perferendis. Ipsam, cupiditate minus veniam ducimus perspiciatis alias blanditiis delectus, vero in cum accusantium sapiente quo id fuga ullam odio perferendis magnam tempore rerum sed mollitia laborum tempora repellat. Enim, autem error a molestiae nisi ut dignissimos, dolorem sequi saepe ab praesentium et. Non tempore autem quis error commodi facilis reiciendis modi, nam, id dignissimos omnis quas tenetur dolore ab odit! Rem, soluta nulla ullam ipsam cumque nihil eaque doloremque, laborum architecto doloribus deserunt. Omnis, officiis. Temporibus iste quod veritatis officiis vel eius suscipit nisi tempora. Alias temporibus possimus, molestiae rem modi sint! Ab reiciendis minima magnam, ipsam sit, quisquam alias perspiciatis ullam voluptate blanditiis modi dolore similique labore beatae assumenda qui, dolor illo quae corrupti odio nostrum officia saepe accusantium nulla. Placeat quisquam quam asperiores iure quod cum, possimus autem, in consectetur cumque voluptate non atque corporis odio maxime sed quaerat porro. Unde, dignissimos ab! Ipsa dicta quas non qui vel temporibus voluptates nemo quos mollitia? Temporibus quo praesentium nostrum iure? Porro dolorum, corporis ipsam dignissimos ratione, accusamus deserunt mollitia voluptatem adipisci ea molestias aliquam? Eaque ea facilis repudiandae, nemo quisquam accusamus expedita! Veniam labore tenetur animi amet laboriosam officia blanditiis sint est doloremque fuga. Explicabo itaque pariatur doloremque fuga reprehenderit delectus error officiis id. Officiis quo facere sequi deserunt nostrum ab blanditiis debitis repudiandae repellat, aut vel exercitationem voluptatibus laudantium molestias nihil eum, omnis id fuga nisi asperiores? Itaque quis aliquid quisquam, optio recusandae impedit magnam numquam, praesentium ut molestiae eveniet blanditiis quae voluptas tempore doloremque perspiciatis nemo aperiam ab rem earum aliquam, culpa beatae! Optio accusamus magni neque architecto accusantium aliquam delectus, cum temporibus ea voluptatum.', NULL, NULL, NULL, NULL, 0),
(9, 5, NULL, NULL, 'Experience Vaping Elevated to Art', 'Explore our curated collection of elite e-liquids...', 'http://localhost/vapestore/uploads/media/1778194137_carousel-3.webp', NULL, 'Shop New', '#', 0),
(10, 7, NULL, NULL, 'Redefining the Art of Vaping', 'At The Perfect Vape, we believe that vaping is more than just an alternative—it\'s a lifestyle. Our curated selection of premium devices and artisan e-liquids are crafted for those who demand excellence in every puff.\n\nAt The Perfect Vape, we believe that vaping is more than just an alternative—it\'s a lifestyle. Our curated selection of premium devices and artisan e-liquids are crafted for those who demand excellence in every puff.\n', 'http://localhost/vapestore/uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', NULL, 'Discover More', '#', 0),
(11, 5, NULL, NULL, 'asfsa', 'fasfasfsaf', 'http://localhost/vapestore/uploads/media/1778194138_vape-hero-bg.webp', NULL, 'sdfsdfsdfsd', 'safsdf', 1),
(13, 8, NULL, NULL, 'The Essence of Pure Vaping', 'Discover the philosophy behind The Perfect Vape. We are dedicated to bringing you the most sophisticated vaping experiences by combining cutting-edge technology with the finest artisanal blends. Every product in our collection is handpicked to ensure it meets our rigorous standards for quality and performance. Our journey began with a simple mission: to elevate the vaping community by providing access to world-class hardware and exclusive e-liquids that were previously hard to find. Today, we stand as a beacon for enthusiasts who value precision, flavor, and style. From sub-ohm powerhouses to elegant pod systems, we cater to every level of vaper with unparalleled expertise and customer support.', 'http://localhost/vapestore/uploads/media/1778197030_smoke_bg.webp', NULL, NULL, '', 0),
(15, 6, NULL, NULL, 'test', 'testset ste setse testse t', 'http://localhost/vapestore/uploads/media/1778194137_carousel-2.webp', NULL, NULL, 'sdfsdf', 0),
(56, 23, NULL, NULL, 'testset', 'setsetset', NULL, NULL, NULL, NULL, 0),
(57, 6, NULL, NULL, 'test', 'testset sete ste stest t', 'http://localhost/vapestore/uploads/media/1778019779_Gemini_Generated_Image_f4t5yof4t5yof4t5-clean.webp', NULL, NULL, 'sdfsdf', 1),
(58, 24, 21, 'product', NULL, NULL, NULL, NULL, NULL, 'product/21', 0),
(59, 24, 22, 'product', NULL, NULL, NULL, NULL, NULL, 'product/22', 1),
(60, 24, 23, 'product', NULL, NULL, NULL, NULL, NULL, 'product/23', 2),
(61, 24, 25, 'product', NULL, NULL, NULL, NULL, NULL, 'product/25', 3),
(62, 24, 6, 'product', NULL, NULL, NULL, NULL, NULL, 'product/6', 4),
(63, 24, 5, 'product', NULL, NULL, NULL, NULL, NULL, 'product/5', 5),
(64, 25, 5, 'product', NULL, NULL, NULL, NULL, NULL, 'product/5', 0),
(65, 25, 6, 'product', NULL, NULL, NULL, NULL, NULL, 'product/6', 1),
(66, 25, 21, 'product', NULL, NULL, NULL, NULL, NULL, 'product/21', 2),
(67, 25, 22, 'product', NULL, NULL, NULL, NULL, NULL, 'product/22', 3),
(68, 25, 23, 'product', NULL, NULL, NULL, NULL, NULL, 'product/23', 4),
(69, 25, 25, 'product', NULL, NULL, NULL, NULL, NULL, 'product/25', 5),
(70, 26, NULL, NULL, 'Minimum Age', 'You must be at least 18 years old to purchase any vaping products from our store. We perform age verification on all orders to ensure compliance with local laws.', NULL, NULL, NULL, NULL, 0),
(71, 26, NULL, NULL, 'Track Order', 'Once your order is shipped, you will receive an email with a tracking number and a link to the courier\'s website to monitor your delivery progress.', NULL, NULL, NULL, NULL, 1),
(72, 27, 23, 'product', NULL, NULL, NULL, NULL, NULL, 'product/23', 0),
(73, 27, 25, 'product', NULL, NULL, NULL, NULL, NULL, 'product/25', 1),
(74, 27, 6, 'product', NULL, NULL, NULL, NULL, NULL, 'product/6', 2),
(75, 27, 5, 'product', NULL, NULL, NULL, NULL, NULL, 'product/5', 3),
(76, 27, 21, 'product', NULL, NULL, NULL, NULL, NULL, 'product/21', 4),
(77, 27, 22, 'product', NULL, NULL, NULL, NULL, NULL, 'product/22', 5),
(82, 29, NULL, NULL, 'Accessories', 'Browse the best brands and flavours', 'http://localhost/vapestore-UI/assets/image/4.jpg', NULL, NULL, '#', 0),
(83, 29, NULL, NULL, 'Shop Tanks', 'Browse the best brands and flavours', 'http://localhost/vapestore-UI/assets/image/3.jpg', NULL, NULL, '#', 1),
(84, 29, NULL, NULL, 'Shop E-Liquids', 'Browse the best brands and flavours', 'http://localhost/vapestore-UI/assets/image/1.jpg', NULL, NULL, '#', 2),
(85, 29, NULL, NULL, 'Shop Coils', 'Browse the best brands and flavours', 'http://localhost/vapestore-UI/assets/image/1.jpg', NULL, NULL, '#', 3),
(86, 30, NULL, NULL, '', '', 'http://localhost/vapestore-UI/assets/image/slideshow-6.png', NULL, NULL, '', 0),
(87, 30, NULL, NULL, '', '', 'http://localhost/vapestore-UI/assets/image/slideshow-1.png', NULL, NULL, '', 1),
(88, 30, NULL, NULL, '', '', 'http://localhost/vapestore-UI/assets/image/slideshow-2.png', NULL, NULL, '', 2),
(89, 30, NULL, NULL, '', '', 'http://localhost/vapestore-UI/assets/image/slideshow-3.png', NULL, NULL, '', 3),
(90, 30, NULL, NULL, '', '', 'http://localhost/vapestore-UI/assets/image/slideshow-4.png', NULL, NULL, '', 4),
(91, 31, NULL, NULL, 'James Wilson', '\"The quality of the e-liquids here is unmatched. I\'ve tried many stores, but the flavor profiles and smooth delivery from The Perfect Vape are on another level.\"', 'http://localhost/vapestore-UI/assets/image/testimonial-5.jpg', NULL, '3 stars', '#', 0),
(93, 33, NULL, NULL, 'Premium Selection', 'Fresh, creative concepts that transform ordinary vaping into extraordinary experiences with our hand-picked hardware.', 'lucide-box', NULL, NULL, NULL, 0),
(94, 33, NULL, NULL, 'Expert Guidance', 'Tailored solutions that reflect your unique style and personality, guided by our industry experts.', 'lucide-zap', NULL, NULL, NULL, 1),
(95, 33, NULL, NULL, 'Global Logistics', 'From checkout to your doorstep, we handle every detail of your delivery with precision and speed.', 'lucide-truck', NULL, NULL, NULL, 2),
(96, 33, NULL, NULL, 'Certified Quality', 'Exceptional craftsmanship and attention to detail in every product, backed by our 100% authenticity guarantee.', 'lucide-shield-check', NULL, NULL, NULL, 3),
(97, 34, NULL, NULL, 'High-Power Box Mods', 'Experience maximum cloud production and unrivaled battery life for all-day vaping. Our premium selection of advanced high-power box mods is engineered to deliver peak performance.', 'http://localhost/vapestore/uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', NULL, NULL, NULL, 0),
(98, 34, NULL, NULL, 'Nic Salts', 'Experience maximum cloud praoduction and unrivaled battery life for all-day vaping. Our premium selection of advanced high-power box mods is engineered to deliver peak performance.', 'http://localhost/vapestore/uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', NULL, NULL, NULL, 1),
(99, 34, NULL, NULL, 'Sleek Pods', 'Experience maximum cloud praoduction and unrivaled battery life for all-day vaping. Our premium selection of advanced high-power box mods is engineered to deliver peak performance.', 'http://localhost/vapestore/uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', NULL, NULL, NULL, 2),
(100, 34, NULL, NULL, 'Sleek Pods Test', 'Experience maximum cloud praoduction and unrivaled battery life for all-day vaping. Our premium selection of advanced high-power box mods is engineered to deliver peak performance.', 'http://localhost/vapestore/uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', NULL, NULL, NULL, 3),
(101, 32, NULL, NULL, 'Explore Our Premium Collections', 'Welcome to the ultimate vaping destination. At The Perfect Vape, our collections are meticulously curated to bring you industry-leading devices, mouth-watering e-liquids, and essential accessories. Whether you are searching for your first starter kit or upgrading to a high-performance mod, our extensive catalog is designed to deliver satisfaction. We partner with top global brands like Geek Bar, Hayati, and Gold Bar to ensure that every puff you take is backed by quality and innovation. Our diverse range includes everything from convenient disposable vapes and sleek pod systems to premium nicotine salts and robust sub-ohm tanks. Dive into our collections today and experience unparalleled flavor profiles, massive cloud production, and reliable performance tailored precisely to your vaping lifestyle.', NULL, NULL, NULL, NULL, 0),
(136, 13, NULL, NULL, '', '<p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">In 2026, disposable vapes have become really popular for all the right reasons. They are convenient, portable, and specially designed for individuals who want an uncomplicated vaping experience. These vapes do not require any kind of maintenance, like changing batteries or e-liquids.</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">This blog will help make your decision easier by breaking down the most important factors when purchasing a disposable vape.</p><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px;\">Why Are Disposable Vapes Dominating in 2026?</h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">The rapid growth of vaping technology has transformed disposable devices from short-lived, compact options into large, powerful, and long-lasting devices. This progress has also enabled newer vapes to have more puffs, better coils, increased airflow, and consistent flavor throughout their life.</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">The following are the main reasons that people are choosing disposable vapes:</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>No need to carry a charging cable or button</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>No need to refill or worry about leaking</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>Simple and easy-to-use options for frequent users</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>Reliable performance from beginning to end</p><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px;\">Essential Factors to Consider Before Making a Purchase</h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">It is important to know the factors that differentiate a good vaping device from an average one.</p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\">Puff Count That Matches Your Needs</h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">Devices can have a wide range of puff counts. For heavy users, they should be looking towards having high puff counts available. Smaller devices with an average puff count are considered better for light users.</p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\">Nicotine Strength and Smoothness</h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">While everyone gets their nicotine differently, some devices produce smoother deliveries as compared to those that feel harsh.</p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\">Consistency of the Flavor</h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">An excellent device will taste identical on both day 1 and day 10. If a device produces a burnt or bland taste, it is because of poor coil design.</p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\">Airflow and Draw</h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">Some users prefer a tight, narrow draw, while other users like a greater amount of air flow. Newer disposable device manufacturers are creating products that will function to provide both experiences.</p><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px;\">Best Disposable Vaping Products to Purchase in 2026</h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">These are two standouts this year in terms of durability, taste quality, and overall satisfaction.</p>', NULL, NULL, NULL, NULL, 0),
(137, 14, 23, 'product', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(138, 15, NULL, NULL, '', '<h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">In 2026, disposable vapes have become really popular for all the right reasons. They are convenient, portable, and specially designed for individuals who want an uncomplicated vaping experience. These vapes do not require any kind of maintenance, like changing batteries or e-liquids.</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">This blog will help make your decision easier by breaking down the most important factors when purchasing a disposable vape.</p></h3><h2 style=\"box-sizing: inherit; font-weight: 400; font-size: 24px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Why Are Disposable Vapes Dominating in 2026?</h2><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">The rapid growth of vaping technology has transformed disposable devices from short-lived, compact options into large, powerful, and long-lasting devices. This progress has also enabled newer vapes to have more puffs, better coils, increased airflow, and consistent flavor throughout their life.</p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">The following are the main reasons that people are choosing disposable vapes:</p><p class=\"MsoNormal\" style=\"margin: 0px 0px 15px 0.5in; box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>No need to carry a charging cable or button</p><p class=\"MsoNormal\" style=\"margin: 0px 0px 15px 0.5in; box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>No need to refill or worry about leaking</p><p class=\"MsoNormal\" style=\"margin: 0px 0px 15px 0.5in; box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>Simple and easy-to-use options for frequent users</p><p class=\"MsoNormal\" style=\"margin: 0px 0px 15px 0.5in; box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>Reliable performance from beginning to end</p></h3><h2 style=\"box-sizing: inherit; font-weight: 400; font-size: 24px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Essential Factors to Consider Before Making a Purchase</h2><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">It is important to know the factors that differentiate a good vaping device from an average one.</p></h3><h3 style=\"box-sizing: inherit; font-weight: 400; font-size: 18px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Puff Count That Matches Your Needs</h3><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">Devices can have a wide range of puff counts. For heavy users, they should be looking towards having high puff counts available. Smaller devices with an average puff count are considered better for light users.</p></h3><h3 style=\"box-sizing: inherit; font-weight: 400; font-size: 18px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Nicotine Strength and Smoothness</h3><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">While everyone gets their nicotine differently, some devices produce smoother deliveries as compared to those that feel harsh.</p></h3><h3 style=\"box-sizing: inherit; font-weight: 400; font-size: 18px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Consistency of the Flavor</h3><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">An excellent device will taste identical on both day 1 and day 10. If a device produces a burnt or bland taste, it is because of poor coil design.</p></h3><h3 style=\"box-sizing: inherit; font-weight: 400; font-size: 18px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Airflow and Draw</h3><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">Some users prefer a tight, narrow draw, while other users like a greater amount of air flow. Newer disposable device manufacturers are creating products that will function to provide both experiences.</p></h3><h2 style=\"box-sizing: inherit; font-weight: 400; font-size: 24px; font-family: Assistant, sans-serif; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word;\">Best Disposable Vaping Products to Purchase in 2026</h2><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px;\"><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-size: 16px; letter-spacing: 0.6px;\">These are two standouts this year in terms of durability, taste quality, and overall satisfaction.</p></h3>', NULL, NULL, NULL, NULL, 0),
(139, 35, 25, 'product', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(140, 19, NULL, NULL, 'sdgsdgsd', 'gsdgsdgdfg', NULL, NULL, NULL, NULL, 0),
(141, 2, NULL, NULL, 'Privacy Policy', 'testettsetestset', NULL, NULL, NULL, NULL, 0),
(142, 18, NULL, NULL, 'tsetse', 'testset', NULL, NULL, NULL, NULL, 0);
INSERT INTO `ui_section_items` (`id`, `section_id`, `entity_id`, `entity_type`, `title`, `content`, `image_url`, `video_url`, `button_text`, `button_url`, `sort_order`) VALUES
(144, 36, NULL, NULL, 'Privacy policy', '<span style=\"color: rgb(0, 0, 0); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">At&nbsp;</span><b style=\"box-sizing: inherit; color: rgb(0, 0, 0); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">Skull Vaping</b><span style=\"color: rgb(0, 0, 0); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\">, we are committed to protecting and respecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, make purchases, and interact with our services. Please read this policy carefully to understand our views and practices regarding your personal data.</span><div><span style=\"color: rgb(0, 0, 0); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\"><br></span></div><div><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">1. Information We Collect</span></b></span></h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">We may collect the following information to provide you with a better experience and service:</span></p><h4 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 15px; break-after: auto; margin: 12pt 0in 2pt;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 11pt; line-height: 16.8667px;\">Personal Data</span></b></span></h4><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 12pt 0in 0.0001pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Contact Information</span></b><span style=\"box-sizing: inherit;\">: Name, email address, shipping address, and phone number.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Account Information</span></b><span style=\"box-sizing: inherit;\">: Username and password for registering an account.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 0in 0in 12pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Payment Information</span></b><span style=\"box-sizing: inherit;\">: Credit/debit card numbers and billing information (securely processed by third-party payment processors).</span></span></p><h4 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 15px; break-after: auto; margin: 12pt 0in 2pt;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 11pt; line-height: 16.8667px;\">Non-Personal Data</span></b></span></h4><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 12pt 0in 0.0001pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Technical Data</span></b><span style=\"box-sizing: inherit;\">: IP address, browser type, device type, and usage data, including page interactions and browsing history.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 0in 0in 12pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Cookies and Tracking Technologies</span></b><span style=\"box-sizing: inherit;\">: To enhance your experience and improve our services, we use cookies, pixels, and other tracking technologies to collect information about your browsing behavior.</span></span></p><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">2. How We Use Your Information</span></b></span></h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">We use your data to provide and improve our services, personalize your experience, and communicate with you:</span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 12pt 0in 0.0001pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Order Processing</span></b><span style=\"box-sizing: inherit;\">: To process and deliver your purchases, including confirming your order, payment, shipping, and handling returns or refunds.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Customer Support</span></b><span style=\"box-sizing: inherit;\">: To provide customer service, resolve disputes, and answer inquiries.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Marketing and Promotions</span></b><span style=\"box-sizing: inherit;\">: To send promotional offers, updates, newsletters, and special deals (with your consent).</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Website Optimization</span></b><span style=\"box-sizing: inherit;\">: To analyze website performance, fix errors, and enhance the user experience.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 0in 0in 12pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Legal Obligations</span></b><span style=\"box-sizing: inherit;\">: To comply with any legal or regulatory requirements.</span></span></p><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">3. How We Share Your Information</span></b></span></h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">We do not sell, rent, or trade your personal information to third parties. However, we may share your information in the following circumstances:</span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 12pt 0in 0.0001pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Service Providers</span></b><span style=\"box-sizing: inherit;\">: We may share your data with third-party service providers who assist in fulfilling orders, processing payments, providing customer support, and marketing. These third parties are required to keep your information confidential and use it solely for the purpose of providing their services.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Legal Compliance</span></b><span style=\"box-sizing: inherit;\">: We may disclose your information if required to do so by law or in response to valid requests by public authorities (e.g., a court or government agency).</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 0in 0in 12pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Business Transfers</span></b><span style=\"box-sizing: inherit;\">: If Skull Vaping undergoes a merger, acquisition, or asset sale, your information may be transferred as part of the transaction. We will notify you of any such change and provide options regarding your data.</span></span></p><h2 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 24px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">4. Data Security</span></b></span></h2><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">We implement industry-standard security measures to protect your personal information from unauthorized access, alteration, or destruction. These include encryption of sensitive data (such as payment information), regular system updates, and restricted access to personal information.</span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">However, no method of transmission over the Internet or method of electronic storage is 100% secure, so we cannot guarantee absolute security.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">5. Your Rights</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">You have certain rights regarding your personal data under data protection laws. These include:</span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 12pt 0in 0.0001pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Right to Access</span></b><span style=\"box-sizing: inherit;\">: You may request details of the personal information we hold about you.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Right to Rectification</span></b><span style=\"box-sizing: inherit;\">: You may request corrections to any inaccurate or incomplete information.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Right to Erasure</span></b><span style=\"box-sizing: inherit;\">: You may request the deletion of your personal data under certain circumstances.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Right to Withdraw Consent</span></b><span style=\"box-sizing: inherit;\">: Where we rely on your consent for processing, you can withdraw it at any time.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 0in 0in 12pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">Right to Object</span></b><span style=\"box-sizing: inherit;\">: You may object to the processing of your personal data for direct marketing purposes or other legitimate interests.</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">To exercise any of these rights, please contact us using the contact details provided below.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">6. Cookies and Tracking Technologies</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">Cookies are small files stored on your device that help us improve your experience. We use cookies to:</span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 12pt 0in 0.0001pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><span style=\"box-sizing: inherit;\">Remember your login details and preferences</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin-left: 0.5in; text-indent: -0.25in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><span style=\"box-sizing: inherit;\">Track your browsing habits on our website</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; text-indent: -0.25in; margin: 0in 0in 12pt 0.5in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><span style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">●<span style=\"box-sizing: inherit; font-style: normal; font-variant: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span><span style=\"box-sizing: inherit;\">Analyze traffic and performance for improvements</span></span></p><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">You can modify your cookie settings or block them through your browser settings. However, disabling cookies may affect your ability to use certain features of our website.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">7. Third-Party Links</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">Our website may contain links to third-party websites, such as social media platforms or payment processors. We do not control these websites and are not responsible for their privacy practices. We encourage you to review the privacy policies of any third-party sites you visit.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">8. Children’s Privacy</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">Our services are not intended for children under the age of 18. We do not knowingly collect personal information from individuals under 18. If we become aware that we have collected such information, we will take steps to delete it.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">9. International Data Transfers</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">If you are accessing our website from outside the United States, please be aware that your information may be transferred, stored, and processed in the U.S. or other countries. By using our services, you consent to such transfers, which will be carried out in accordance with this Privacy Policy and relevant data protection laws.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">10. Changes to This Privacy Policy</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated effective date. We encourage you to review this policy periodically to stay informed about how we are protecting your information.</span></p><h3 style=\"box-sizing: inherit; font-family: Assistant, sans-serif; font-weight: 400; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 18px; margin-top: 14pt; break-after: auto;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 13pt; line-height: 19.9333px;\">11. Contact Us</span></b></span></h3><p class=\"MsoNormal\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px; margin: 12pt 0in;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\">If you have any questions, concerns, or requests regarding your personal information or this Privacy Policy, please contact us at:</span></p><p style=\"box-sizing: inherit; margin-bottom: 0px; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\"><span style=\"box-sizing: inherit; color: rgb(0, 0, 0);\"><b style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit; font-size: 11pt; line-height: 16.8667px; font-family: Arial, sans-serif;\"><br style=\"box-sizing: inherit;\"></span></b><span style=\"box-sizing: inherit; font-size: 11pt; line-height: 16.8667px; font-family: Arial, sans-serif;\">Email: orders@skullvaping.com</span></span></p></div>', NULL, NULL, NULL, NULL, 0),
(146, 37, NULL, NULL, 'The Essence of Pure Vaping', 'Discover the philosophy behind The Perfect Vape. We are dedicated to bringing you the most sophisticated vaping experiences by combining cutting-edge technology with the finest artisanal blends. Every product in our collection is handpicked to ensure it meets our rigorous standards for quality and performance. Our journey began with a simple mission: to elevate the vaping community by providing access to world-class hardware and exclusive e-liquids that were previously hard to find. Today, we stand as a beacon for enthusiasts who value precision, flavor, and style. From sub-ohm powerhouses to elegant pod systems, we cater to every level of vaper with unparalleled expertise and customer support.', NULL, NULL, NULL, NULL, 0),
(147, 22, NULL, NULL, 'testset', 'tsetsetset', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `first_name`, `last_name`, `email`, `password_hash`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Super', 'Admin', 'admin@theperfectvape.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-05-01 20:48:41', '2026-05-01 20:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_type` enum('billing','shipping') NOT NULL DEFAULT 'shipping',
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_blogcat_slug` (`slug`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_blog_posts_url` (`custom_url_path`),
  ADD KEY `idx_blog_posts_category` (`category_id`),
  ADD KEY `fk_blog_posts_author` (`author_id`),
  ADD KEY `idx_blog_published_active` (`is_active`,`published_at`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_brands_slug` (`slug`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_collections_url` (`custom_url_path`),
  ADD KEY `idx_collections_parent` (`parent_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_coupons_code` (`code`);

--
-- Indexes for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inventory_variant` (`variant_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_media_created_at` (`created_at`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_menus_location` (`location`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_menu_items_menu_id` (`menu_id`),
  ADD KEY `idx_menu_items_parent_id` (`parent_id`),
  ADD KEY `idx_menu_items_sort` (`menu_id`,`sort_order`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_orders_number` (`order_number`),
  ADD KEY `idx_orders_user_id` (`user_id`),
  ADD KEY `idx_orders_payment_status` (`payment_status`),
  ADD KEY `idx_orders_shipping_status` (`shipping_status`),
  ADD KEY `fk_orders_coupon` (`coupon_id`),
  ADD KEY `fk_orders_shipping_addr` (`shipping_address_id`),
  ADD KEY `fk_orders_billing_addr` (`billing_address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_oi_order_id` (`order_id`),
  ADD KEY `idx_oi_product_id` (`product_id`),
  ADD KEY `fk_oi_variant` (`variant_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_pages_url` (`custom_url_path`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_products_custom_url` (`custom_url`),
  ADD KEY `idx_products_brand_id` (`brand_id`),
  ADD KEY `idx_products_status` (`status`),
  ADD KEY `idx_products_brand_status` (`brand_id`,`status`),
  ADD KEY `idx_products_price` (`base_price`),
  ADD KEY `idx_products_created` (`created_at`);
ALTER TABLE `products` ADD FULLTEXT KEY `idx_fulltext_products` (`name`,`short_desc`,`tags`);

--
-- Indexes for table `product_collections`
--
ALTER TABLE `product_collections`
  ADD PRIMARY KEY (`product_id`,`collection_id`),
  ADD KEY `idx_pc_collection_id` (`collection_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_images_product_id` (`product_id`),
  ADD KEY `idx_images_variant_id` (`variant_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reviews_product_id` (`product_id`),
  ADD KEY `idx_reviews_status` (`status`),
  ADD KEY `idx_reviews_prod_status` (`product_id`,`status`),
  ADD KEY `fk_reviews_user` (`user_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_variants_sku` (`sku`),
  ADD KEY `idx_variants_product_id` (`product_id`),
  ADD KEY `idx_variants_product_stock` (`product_id`,`stock_quantity`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_refunds_order` (`order_id`),
  ADD KEY `fk_refunds_user` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_settings_key` (`key`);

--
-- Indexes for table `ui_sections`
--
ALTER TABLE `ui_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ui_sections_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_ui_sections_sort` (`sort_order`);

--
-- Indexes for table `ui_section_items`
--
ALTER TABLE `ui_section_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_section_items_section_id` (`section_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_users_email` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_addresses_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ui_sections`
--
ALTER TABLE `ui_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ui_section_items`
--
ALTER TABLE `ui_section_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `fk_blog_posts_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_blog_posts_category` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `collections`
--
ALTER TABLE `collections`
  ADD CONSTRAINT `fk_collections_parent` FOREIGN KEY (`parent_id`) REFERENCES `collections` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  ADD CONSTRAINT `fk_inventory_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `fk_menu_items_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_menu_items_parent` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_billing_addr` FOREIGN KEY (`billing_address_id`) REFERENCES `user_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_shipping_addr` FOREIGN KEY (`shipping_address_id`) REFERENCES `user_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_oi_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_oi_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_oi_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_collections`
--
ALTER TABLE `product_collections`
  ADD CONSTRAINT `fk_pc_collection` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pc_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_images_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_images_variant` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `fk_variants_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD CONSTRAINT `fk_refunds_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_refunds_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ui_section_items`
--
ALTER TABLE `ui_section_items`
  ADD CONSTRAINT `fk_section_items_section` FOREIGN KEY (`section_id`) REFERENCES `ui_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `fk_user_addresses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
