-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 07:42 PM
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
(1, 3, 'test', 'test', NULL, 'uploads/media/1778022071_1777679489_includes_uploads_private_attachments_Zain.webp', 'test', '2026-05-06 20:04:14', 'yrdy', 'yrdy', 1),
(2, 3, 'etetete', 'etetete', NULL, 'uploads/media/1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'test', '2026-05-07 14:29:43', 'stsetse', 'tsetet', 0);

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
(7, 4, 'E-liquids', 'e-liquids', 'uploads/media/1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', '                        <div id=\"shopify-section-template--20159880593620__custom-content\" class=\"shopify-section\" style=\"box-sizing: inherit; color: rgba(18, 18, 18, 0.75); font-family: Assistant, sans-serif; font-size: 16px; letter-spacing: 0.6px;\"><div class=\"collection-custom-content\" style=\"box-sizing: inherit; margin: 30px 0px;\"><h2 style=\"box-sizing: inherit; letter-spacing: 0.6px; color: rgb(18, 18, 18); line-height: 1.3; word-break: break-word; font-size: 28px; max-width: 1400px; margin: 0px auto;\">Buy Vape Juice Online| Premium Electronic Cigarette Juice– SkullVaping</h2><p style=\"box-sizing: inherit; color: rgb(85, 85, 85); max-width: 1400px; margin: 0px auto;\">If you are looking for the best vape juice online, you’ve landed at the right place. At SkullVaping, we specialize in providing premium vape juice, flavorful vape liquids, and electronic cigarette juice that deliver rich taste, smooth clouds, and consistent draws, making you extremely satisfied.With a wide variety of blends and strengths to choose from, our online vape juice shop is trusted by many vapers across the USA. Whether you’re chasing clouds, craving bold vape juice flavors, or looking for a reliable e juice store, SkullVaping is your go-to destination.</p></div></div>                    ', 'e-liquid', 'Discover for the #1 vape juice online? At SkullVaping, we offer premium box mod vape juice and electronic cigarette juice from a trusted vape juice online store. Shop quality flavors today!', 1),
(8, NULL, 'dsfsdfg', 'dsfsdfg', 'uploads/media/1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'sdgsfdgfdg', '', '', 1);

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
(65, 80, 433, 'initial_stock', '2026-05-07 17:13:42');

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
(22, '1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'WhatsApp Image 2026-05-06 at 1.26.09 AM.jpeg', 'uploads/media/1778174450_WhatsAppImage2026-05-06at12609AM.webp', 'image/webp', 33146, '768x1024', '2026-05-07 17:20:50');

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
  `image_url` varchar(255) DEFAULT NULL,
  `css_class` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `title`, `link_type`, `link_value`, `image_url`, `css_class`, `sort_order`) VALUES
(5, 2, NULL, 'disposible', 'collection', '', NULL, NULL, 0),
(6, 2, 5, 'Home', 'custom_url', '', NULL, NULL, 0),
(7, 2, 6, 'yrdyrdy', 'custom_url', '', NULL, NULL, 0),
(8, 2, NULL, 'Shop', 'custom_url', '', NULL, NULL, 1),
(9, 2, 8, 'all products', 'custom_url', '', NULL, NULL, 0),
(10, 2, 9, 'New arrivals', 'custom_url', '', NULL, NULL, 0),
(11, 3, NULL, 'Footer Text', 'text_block', '<h1>You Have To Be Over 18</h1><h1>To Purchase</h1><p>Vape kits might contain nicotine, which is addictive. These vaping devices are designed for individuals aged 18 or above. They are unsuitable for people who are allergic/sensitive to nicotine, pregnant or breastfeeding women, those with unstable heart conditions, and individuals who should avoid nicotine for medical reasons, as they could pose health risks. Make sure to keep vape kits or disposable vapes out of the reach of children.</p>', NULL, NULL, 0),
(12, 3, NULL, 'Quick Links', '', '#', NULL, NULL, 1),
(13, 3, 12, 'Contact Us', 'custom_url', '/contnact', NULL, NULL, 0),
(14, 3, 12, 'My Account', 'custom_url', '/', NULL, NULL, 1),
(15, 3, 12, 'Wishlist', 'custom_url', 'Wishlist', NULL, NULL, 2),
(16, 3, 12, 'Vaping Blogs', 'custom_url', 'Vaping Blogs', NULL, NULL, 3),
(17, 3, NULL, 'Policies', '', '#', NULL, NULL, 2),
(18, 3, 17, 'Shipping Policy', 'page', '/pages/privacy', NULL, NULL, 0),
(19, 3, 17, 'Refund Policy', 'page', '/pages/privacy', NULL, NULL, 1),
(20, 3, 17, 'Refund Policy', 'custom_url', 'Refund Policy', NULL, NULL, 2),
(21, 4, NULL, 'test', 'custom_url', 'test', NULL, NULL, 0),
(22, 4, 21, 'test', 'page', '/pages/privacy', NULL, NULL, 0);

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

INSERT INTO `products` (`id`, `brand_id`, `name`, `custom_url`, `short_desc`, `long_desc`, `base_price`, `status`, `tags`, `option_names`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(5, NULL, 'T-shirt', 't-shirt', '', '', 15000.00, 'published', '', NULL, 'yrdy', 'yryrdy', '2026-05-04 16:13:05', '2026-05-05 18:54:37'),
(6, NULL, 'AuraGlow LED Touch Night Lamp', 'auraglow-led-touch-night-lamp', '', '', 14.99, 'published', '', NULL, 'AuraGlow LED Touch Night Lamp', 'Portable rechargeable LED touch lamp with adjustable brightness levels. Perfect for bedside tables, study desks, and room decor. Modern minimalist design with soft ambient lighting.', '2026-05-04 17:24:07', '2026-05-05 18:54:22'),
(21, NULL, 'Box Package', 'test', 'Box Package Box Package', 'Box Package&nbsp;Box Package&nbsp;Box Package', 50.00, 'draft', '', '[\"color\",\"Mgs\",\"Puffs\"]', '', 'test', '2026-05-06 17:38:50', '2026-05-06 17:40:46'),
(22, NULL, 'sdfsdfs', 'sdfsdfs', 'dfsdfs', 'dfsdf', 49.99, 'draft', '', '[\"test\",\"test\"]', NULL, '', '2026-05-06 17:55:15', '2026-05-06 17:55:15'),
(23, NULL, 'test', 'test-1', 'stsets', 'tgsdgfd', 35.00, 'draft', 'test,tetet,tetetet,etetet,e,tet,y,ws,sdg,dgf,sdf', NULL, '', '', '2026-05-06 17:59:06', '2026-05-06 18:02:59'),
(25, 3, 'testsgdf', 'testtet', 'gdfgsdg', 'sdgfgdfgfg', 34.99, 'draft', 'water bottle,smart bottle', '[\"est\"]', NULL, 'testset', '2026-05-07 17:13:42', '2026-05-07 17:13:42');

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
(6, 3),
(21, 3),
(22, 3),
(23, 3),
(23, 4),
(25, 7);

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
(25, 22, NULL, 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 0),
(26, 22, NULL, 'uploads/media/1778022070_1777921015_logo_4.webp', 1),
(27, 22, NULL, 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 2),
(28, 22, NULL, 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 3),
(29, 22, NULL, 'uploads/media/1778022070_1777921015_logo_4.webp', 4),
(30, 22, NULL, 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 5),
(31, 23, NULL, 'uploads/media/1778021916_1777917100_61ix6jhVcL_AC_UF8941000_QL80_.webp', 0),
(32, 23, NULL, 'uploads/media/1778022070_1777919233_150827453_btzq9g.webp', 1),
(33, 23, NULL, 'uploads/media/1778019780_Gemini_Generated_Image_f4t5yof4t5yof4t5.webp', 2),
(37, 25, NULL, 'uploads/media/1778025324_Screenshot2025-11-11230254.webp', 0),
(38, 25, NULL, 'uploads/media/1778025129_Screenshot2025-11-12024730.webp', 1),
(39, 25, NULL, 'uploads/media/1778025129_Screenshot2025-11-12024753.webp', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0,
  `variant_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `price`, `stock_quantity`, `is_default`, `variant_name`) VALUES
(4, 5, '1232345-black', 15000.00, 123, 0, 'black'),
(5, 5, '1232345-blue', 15000.00, 123, 0, 'blue'),
(6, 6, 'AGL-001-black-large', 14.99, 15, 0, 'Black / Large'),
(7, 6, 'AGL-001-black-small', 14.99, 15, 0, 'Black / Small'),
(8, 6, 'AGL-001-white-large', 14.99, 15, 0, 'White / Large'),
(9, 6, 'AGL-001-white-small', 14.99, 15, 0, 'White / Small'),
(47, 21, 'SKU-21-black-12mg-100', 50.00, 10, 0, 'black / 12mg / 100'),
(48, 21, 'SKU-21-black-12mg-500', 50.00, 10, 0, 'black / 12mg / 500'),
(49, 21, 'SKU-21-black-12mg-1000', 50.00, 10, 0, 'black / 12mg / 1000'),
(50, 21, 'SKU-21-black-16mg-100', 50.00, 10, 0, 'black / 16mg / 100'),
(51, 21, 'SKU-21-black-16mg-500', 50.00, 10, 0, 'black / 16mg / 500'),
(52, 21, 'SKU-21-black-16mg-1000', 50.00, 10, 0, 'black / 16mg / 1000'),
(53, 21, 'SKU-21-black-20mg-100', 50.00, 10, 0, 'black / 20mg / 100'),
(54, 21, 'SKU-21-black-20mg-500', 50.00, 10, 0, 'black / 20mg / 500'),
(55, 21, 'SKU-21-black-20mg-1000', 50.00, 10, 0, 'black / 20mg / 1000'),
(56, 21, 'SKU-21-blue-12mg-100', 50.00, 10, 0, 'Blue / 12mg / 100'),
(57, 21, 'SKU-21-blue-12mg-500', 50.00, 10, 0, 'Blue / 12mg / 500'),
(58, 21, 'SKU-21-blue-12mg-1000', 50.00, 10, 0, 'Blue / 12mg / 1000'),
(59, 21, 'SKU-21-blue-16mg-100', 50.00, 10, 0, 'Blue / 16mg / 100'),
(60, 21, 'SKU-21-blue-16mg-500', 50.00, 10, 0, 'Blue / 16mg / 500'),
(61, 21, 'SKU-21-blue-16mg-1000', 50.00, 10, 0, 'Blue / 16mg / 1000'),
(62, 21, 'SKU-21-blue-20mg-100', 50.00, 10, 0, 'Blue / 20mg / 100'),
(63, 21, 'SKU-21-blue-20mg-500', 50.00, 10, 0, 'Blue / 20mg / 500'),
(64, 21, 'SKU-21-blue-20mg-1000', 50.00, 10, 0, 'Blue / 20mg / 1000'),
(65, 21, 'SKU-21-white-12mg-100', 50.00, 10, 0, 'White / 12mg / 100'),
(66, 21, 'SKU-21-white-12mg-500', 50.00, 10, 0, 'White / 12mg / 500'),
(67, 21, 'SKU-21-white-12mg-1000', 50.00, 10, 0, 'White / 12mg / 1000'),
(68, 21, 'SKU-21-white-16mg-100', 50.00, 10, 0, 'White / 16mg / 100'),
(69, 21, 'SKU-21-white-16mg-500', 50.00, 10, 0, 'White / 16mg / 500'),
(70, 21, 'SKU-21-white-16mg-1000', 50.00, 10, 0, 'White / 16mg / 1000'),
(71, 21, 'SKU-21-white-20mg-100', 50.00, 10, 0, 'White / 20mg / 100'),
(72, 21, 'SKU-21-white-20mg-500', 50.00, 10, 0, 'White / 20mg / 500'),
(73, 21, 'SKU-21-white-20mg-1000', 50.00, 10, 0, 'White / 20mg / 1000'),
(74, 22, 'SKU-22-test', 49.99, 49, 0, 'test'),
(75, 22, 'SKU-22-tes', 49.99, 49, 0, 'tes'),
(79, 25, 'SKU-25-test', 34.99, 433, 0, 'test'),
(80, 25, 'SKU-25-tset', 34.99, 433, 0, 'tset');

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
(5, 'global_home', NULL, 'hero_slider', NULL, NULL, NULL, 1, 1),
(6, 'global_home', NULL, 'promo_grid', NULL, NULL, NULL, 0, 1),
(7, 'global_home', NULL, 'feature_highlight', NULL, NULL, NULL, 2, 1),
(8, 'global_home', NULL, 'brand_story', NULL, NULL, NULL, 3, 1),
(10, 'global_home', NULL, 'collection_grid', 'New arrilval', NULL, NULL, 4, 1),
(13, 'blog', 1, 'rich_text', NULL, NULL, NULL, 0, 1),
(14, 'blog', 1, 'product_embed', NULL, NULL, NULL, 1, 1),
(15, 'blog', 1, 'rich_text', NULL, NULL, NULL, 2, 1),
(18, 'page', 5, 'rich_text', NULL, NULL, NULL, 0, 1),
(19, 'page', 6, 'rich_text', NULL, NULL, NULL, 0, 1),
(20, 'global_home', NULL, 'collection_grid', 'test', 'etset', 'test', 5, 1),
(21, 'collection', 1, 'rich_text', NULL, NULL, NULL, 0, 1),
(22, 'collection', 7, 'rich_text', NULL, NULL, NULL, 0, 1),
(23, 'collection', 7, 'faq', NULL, NULL, NULL, 1, 1);

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
(9, 5, NULL, NULL, 'Experience Vaping Elevated to Art', 'Explore our curated collection of elite e-liquids...', 'assets/image/carousel-1.jpg', NULL, 'Shop New', '#', 0),
(10, 7, NULL, NULL, 'Redefining the Art of Vaping', 'At The Perfect Vape, we believe that vaping is more than just an alternative...', 'assets/product/product-7.jpg', NULL, 'Discover More', '#', 0),
(11, 5, NULL, NULL, 'asfsa', 'fasfasfsaf', 'asfasf', NULL, 'sdfsdfsdfsd', 'safsdf', 1),
(12, 7, NULL, NULL, 'fdgdfgdfg', 'dfhfdg', 'dfgdg', NULL, 'fdgfdg', 'dfgfdg', 1),
(13, 8, NULL, NULL, 'yey', 'dghrghfd', 'ryrhy', NULL, NULL, 'yhreyhryh', 0),
(15, 6, NULL, NULL, 'sdfsd', 'fsdfsdf', 'sdfsdf', NULL, NULL, 'sdfsdf', 0),
(20, 10, 7, 'product', NULL, NULL, NULL, NULL, NULL, 'product/7', 0),
(21, 10, 11, 'product', NULL, NULL, NULL, NULL, NULL, 'product/11', 1),
(22, 10, 5, 'product', NULL, NULL, NULL, NULL, NULL, 'product/5', 2),
(23, 10, 6, 'product', NULL, NULL, NULL, NULL, NULL, 'product/6', 3),
(24, 10, 16, 'product', NULL, NULL, NULL, NULL, NULL, 'product/16', 4),
(37, 13, NULL, NULL, 'testt', 'tsetset et sersdfsd estg ef regteg', NULL, NULL, NULL, NULL, 0),
(38, 14, 23, 'product', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(39, 15, NULL, NULL, '', 'testegdgdgfh', NULL, NULL, NULL, NULL, 0),
(45, 18, NULL, NULL, 'tsetse', 'testset', NULL, NULL, NULL, NULL, 0),
(46, 2, NULL, NULL, 'Privacy Policy', 'testettsetestset', NULL, NULL, NULL, NULL, 0),
(47, 19, NULL, NULL, 'sdgsdgsd', 'gsdgsdgdfg', NULL, NULL, NULL, NULL, 0),
(48, 20, 5, 'product', NULL, NULL, NULL, NULL, NULL, 'product/5', 0),
(49, 20, 6, 'product', NULL, NULL, NULL, NULL, NULL, 'product/6', 1),
(50, 20, 25, 'product', NULL, NULL, NULL, NULL, NULL, 'product/25', 2),
(51, 20, 21, 'product', NULL, NULL, NULL, NULL, NULL, 'product/21', 3),
(52, 20, 22, 'product', NULL, NULL, NULL, NULL, NULL, 'product/22', 4),
(53, 20, 23, 'product', NULL, NULL, NULL, NULL, NULL, 'product/23', 5),
(54, 21, NULL, NULL, 'testset', 'setseteste', NULL, NULL, NULL, NULL, 0),
(55, 22, NULL, NULL, 'testset', 'tsetsetset', NULL, NULL, NULL, NULL, 0),
(56, 23, NULL, NULL, 'testset', 'setsetset', NULL, NULL, NULL, NULL, 0);

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
  ADD KEY `fk_blog_posts_author` (`author_id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `idx_menu_items_parent_id` (`parent_id`);

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
  ADD KEY `idx_products_status` (`status`);

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
  ADD KEY `fk_reviews_user` (`user_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_variants_sku` (`sku`),
  ADD KEY `idx_variants_product_id` (`product_id`);

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
  ADD KEY `idx_ui_sections_entity` (`entity_type`,`entity_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ui_sections`
--
ALTER TABLE `ui_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ui_section_items`
--
ALTER TABLE `ui_section_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
