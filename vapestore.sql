-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2026 at 06:16 PM
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
  `published_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, 'test', 'tset', 'uploads/brands/1777935112_Logo-1.png', 1);

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
(3, NULL, 'test name', 'test-name', 'uploads/collections/1777680095_ChatGPTImageMay1202609_56_00PM.png', 'test eetse t stest setse&nbsp;', 'test', 'tset', 1),
(4, 3, 'testt collection ', 'testt-collection', 'uploads/collections/1777930412_150827453_btzq9g.png', 'testtt testsete set etset', 'test', 'tsetesset', 1);

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
  `type` enum('percentage','fixed_amount') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_uses` int(11) DEFAULT NULL,
  `uses_count` int(11) DEFAULT 0,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, 10, 15, 'initial_stock', '2026-05-04 17:51:40'),
(11, 11, 15, 'initial_stock', '2026-05-04 17:51:40'),
(12, 12, 15, 'initial_stock', '2026-05-04 17:51:40'),
(13, 13, 15, 'initial_stock', '2026-05-04 17:51:40'),
(19, 19, 15, 'initial_stock', '2026-05-04 18:56:55'),
(24, 26, 35, 'initial_stock', '2026-05-04 22:54:36');

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
(2, 'Main menu', 'main_menu');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `link_type` enum('collection','brand','custom_url','mega_menu_column','promo_banner') NOT NULL,
  `link_value` varchar(255) DEFAULT NULL,
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
(10, 2, 9, 'New arrivals', 'custom_url', '', NULL, NULL, 0);

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
(2, 'Provacty', 'test', 'Privacy Policy | The Perfect Vape', 'read about Privacy and terms of theperfectvape.com', 1);

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
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `name`, `custom_url`, `short_desc`, `long_desc`, `base_price`, `status`, `tags`, `seo_title`, `seo_description`, `created_at`, `updated_at`) VALUES
(5, NULL, 'T-shirt', 't-shirt', NULL, '', 15000.00, 'draft', '', 'yrdy', 'yryrdy', '2026-05-04 16:13:05', '2026-05-04 16:13:05'),
(6, NULL, 'AuraGlow LED Touch Night Lamp', 'auraglow-led-touch-night-lamp', NULL, '', 14.99, 'draft', '', 'AuraGlow LED Touch Night Lamp', 'Portable rechargeable LED touch lamp with adjustable brightness levels. Perfect for bedside tables, study desks, and room decor. Modern minimalist design with soft ambient lighting.', '2026-05-04 17:24:07', '2026-05-04 17:24:07'),
(7, NULL, 'FlexFit Smart Hydration Water Bottle', 'flexfit-smart', NULL, 'Stay hydrated smarter with the FlexFit Smart Water Bottle. Designed with a built-in LED reminder system, this bottle alerts you when it\'s time to drink water. Its sleek design, durable material, and temperature retention make it perfect for gym, office, or travel use.', 12.99, 'published', '', 'FlexFit Smart Hydration Water Bottle test', 'Stay hydrated smarter with the FlexFit Smart Water Bottle. Designed with a built-in LED reminder system, this bottle alerts you when it\'s time to drink water. Its sleek design, durable material, and temperature retention make it perfect for gym, office, or travel use.', '2026-05-04 17:51:40', '2026-05-04 18:28:06'),
(11, NULL, 'test name', 'test-name', NULL, 'testetetsetes', 15.00, 'draft', 'water bottle smart bottle', '', '', '2026-05-04 18:56:55', '2026-05-04 19:05:42'),
(16, 2, 'test', 'test', 'test', 'test', 34245.00, 'draft', '', '', '', '2026-05-04 22:54:36', '2026-05-04 22:54:36');

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
(16, 3),
(16, 4);

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
(2, 5, NULL, '/uploads/products/1777911185_includes_uploads_private_attachments_Zain.png', 0),
(3, 7, NULL, 'uploads/products/1777917100_61i+x6jhVcL._AC_UF894,1000_QL80_.jpg', 0),
(4, 7, NULL, 'uploads/products/1777919233_150827453_btzq9g.png', 0),
(12, 11, NULL, 'uploads/products/1777921015_logo_4.png', 0),
(18, 16, NULL, 'uploads/products/1777935276_logo_4.png', 0);

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
  `flavor` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `nicotine_strength` varchar(50) DEFAULT NULL,
  `puff_count` int(11) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `variant_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `price`, `stock_quantity`, `flavor`, `size`, `nicotine_strength`, `puff_count`, `is_default`, `variant_name`) VALUES
(4, 5, '1232345-black', 15000.00, 123, NULL, NULL, NULL, NULL, 0, 'black'),
(5, 5, '1232345-blue', 15000.00, 123, NULL, NULL, NULL, NULL, 0, 'blue'),
(6, 6, 'AGL-001-black-large', 14.99, 15, NULL, NULL, NULL, NULL, 0, 'Black / Large'),
(7, 6, 'AGL-001-black-small', 14.99, 15, NULL, NULL, NULL, NULL, 0, 'Black / Small'),
(8, 6, 'AGL-001-white-large', 14.99, 15, NULL, NULL, NULL, NULL, 0, 'White / Large'),
(9, 6, 'AGL-001-white-small', 14.99, 15, NULL, NULL, NULL, NULL, 0, 'White / Small'),
(10, 7, 'AGL-0012324-black-500ml', 12.99, 15, NULL, NULL, NULL, NULL, 0, 'Black / 500ml'),
(11, 7, 'AGL-0012324-black-750ml', 12.99, 15, NULL, NULL, NULL, NULL, 0, 'Black / 750ml'),
(12, 7, 'AGL-0012324-blue-500ml', 12.99, 15, NULL, NULL, NULL, NULL, 0, 'Blue / 500ml'),
(13, 7, 'AGL-0012324-blue-750ml', 12.99, 15, NULL, NULL, NULL, NULL, 0, 'Blue / 750ml'),
(19, 11, 'AGL-001sdfw-test12', 15.00, 15, NULL, NULL, NULL, NULL, 0, 'test12'),
(26, 16, 'test', 34245.00, 35, NULL, NULL, NULL, NULL, 1, NULL);

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
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ui_sections`
--

INSERT INTO `ui_sections` (`id`, `entity_type`, `entity_id`, `type`, `sort_order`, `is_active`) VALUES
(1, 'collection', 3, 'bento_grid', 0, 1),
(2, 'page', 1, 'rich_text', 0, 1),
(4, 'page', 2, 'rich_text', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ui_section_items`
--

CREATE TABLE `ui_section_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `ui_section_items` (`id`, `section_id`, `title`, `content`, `image_url`, `video_url`, `button_text`, `button_url`, `sort_order`) VALUES
(3, 1, 'test', 'tesgfdgfhfgjhfghfghdgfgfdg', 'https://m.media-amazon.com/images/I/61i+x6jhVcL._AC_UF894,1000_QL80_.jpg', NULL, 'advance', NULL, 0),
(7, 2, 'Privacy Policy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe magnam dolore dicta deleniti. Aperiam magnam dolorum molestias sit sunt aliquid explicabo quo nisi. Sit esse impedit officiis perspiciatis a veniam expedita perferendis id porro corporis eos rem, et ipsum est necessitatibus deleniti maiores? Enim, veniam omnis nihil magnam eligendi molestiae maxime, commodi iusto ullam consectetur, delectus culpa tenetur odit laboriosam amet nesciunt! Esse rerum quidem, saepe, minus placeat dignissimos amet doloremque vitae aspernatur voluptas tenetur repellat sed iusto deserunt at dicta similique nulla eaque maxime ad ipsum molestiae eum quisquam! Alias, officiis porro. Suscipit deleniti optio praesentium odit doloremque delectus quisquam animi pariatur nostrum tenetur cum, exercitationem officia tempora numquam sequi! Nobis neque, accusamus doloremque et alias impedit voluptate iusto inventore amet sed iste id dolores explicabo praesentium omnis eligendi distinctio enim laudantium molestiae autem cumque dignissimos facilis necessitatibus. Repellendus aut iste magni laborum odit saepe possimus officiis dicta in tempore molestias, beatae culpa vel unde, placeat expedita sapiente omnis eligendi accusamus ipsum harum eum rerum autem quasi. Molestiae doloremque nemo mollitia quisquam voluptates ullam est? Expedita odit quo qui totam obcaecati autem saepe sed cum sit illo rerum sint at aut aliquid vel, quos doloribus libero corporis consequatur laboriosam officiis! Qui, harum quasi. Illo in provident atque dolor consequatur illum eveniet minus, delectus optio quisquam fuga quo? Saepe obcaecati vitae fugit vel eius repellat alias? Eligendi asperiores pariatur nam ducimus perferendis. Ipsam, cupiditate minus veniam ducimus perspiciatis alias blanditiis delectus, vero in cum accusantium sapiente quo id fuga ullam odio perferendis magnam tempore rerum sed mollitia laborum tempora repellat. Enim, autem error a molestiae nisi ut dignissimos, dolorem sequi saepe ab praesentium et. Non tempore autem quis error commodi facilis reiciendis modi, nam, id dignissimos omnis quas tenetur dolore ab odit! Rem, soluta nulla ullam ipsam cumque nihil eaque doloremque, laborum architecto doloribus deserunt. Omnis, officiis. Temporibus iste quod veritatis officiis vel eius suscipit nisi tempora. Alias temporibus possimus, molestiae rem modi sint! Ab reiciendis minima magnam, ipsam sit, quisquam alias perspiciatis ullam voluptate blanditiis modi dolore similique labore beatae assumenda qui, dolor illo quae corrupti odio nostrum officia saepe accusantium nulla. Placeat quisquam quam asperiores iure quod cum, possimus autem, in consectetur cumque voluptate non atque corporis odio maxime sed quaerat porro. Unde, dignissimos ab! Ipsa dicta quas non qui vel temporibus voluptates nemo quos mollitia? Temporibus quo praesentium nostrum iure? Porro dolorum, corporis ipsam dignissimos ratione, accusamus deserunt mollitia voluptatem adipisci ea molestias aliquam? Eaque ea facilis repudiandae, nemo quisquam accusamus expedita! Veniam labore tenetur animi amet laboriosam officia blanditiis sint est doloremque fuga. Explicabo itaque pariatur doloremque fuga reprehenderit delectus error officiis id. Officiis quo facere sequi deserunt nostrum ab blanditiis debitis repudiandae repellat, aut vel exercitationem voluptatibus laudantium molestias nihil eum, omnis id fuga nisi asperiores? Itaque quis aliquid quisquam, optio recusandae impedit magnam numquam, praesentium ut molestiae eveniet blanditiis quae voluptas tempore doloremque perspiciatis nemo aperiam ab rem earum aliquam, culpa beatae! Optio accusamus magni neque architecto accusantium aliquam delectus, cum temporibus ea voluptatum.', NULL, NULL, NULL, NULL, 0),
(8, 4, 'Privacy Policy', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe magnam dolore dicta deleniti. Aperiam magnam dolorum molestias sit sunt aliquid explicabo quo nisi. Sit esse impedit officiis perspiciatis a veniam expedita perferendis id porro corporis eos rem, et ipsum est necessitatibus deleniti maiores? Enim, veniam omnis nihil magnam eligendi molestiae maxime, commodi iusto ullam consectetur, delectus culpa tenetur odit laboriosam amet nesciunt! Esse rerum quidem, saepe, minus placeat dignissimos amet doloremque vitae aspernatur voluptas tenetur repellat sed iusto deserunt at dicta similique nulla eaque maxime ad ipsum molestiae eum quisquam! Alias, officiis porro. Suscipit deleniti optio praesentium odit doloremque delectus quisquam animi pariatur nostrum tenetur cum, exercitationem officia tempora numquam sequi! Nobis neque, accusamus doloremque et alias impedit voluptate iusto inventore amet sed iste id dolores explicabo praesentium omnis eligendi distinctio enim laudantium molestiae autem cumque dignissimos facilis necessitatibus. Repellendus aut iste magni laborum odit saepe possimus officiis dicta in tempore molestias, beatae culpa vel unde, placeat expedita sapiente omnis eligendi accusamus ipsum harum eum rerum autem quasi. Molestiae doloremque nemo mollitia quisquam voluptates ullam est? Expedita odit quo qui totam obcaecati autem saepe sed cum sit illo rerum sint at aut aliquid vel, quos doloribus libero corporis consequatur laboriosam officiis! Qui, harum quasi. Illo in provident atque dolor consequatur illum eveniet minus, delectus optio quisquam fuga quo? Saepe obcaecati vitae fugit vel eius repellat alias? Eligendi asperiores pariatur nam ducimus perferendis. Ipsam, cupiditate minus veniam ducimus perspiciatis alias blanditiis delectus, vero in cum accusantium sapiente quo id fuga ullam odio perferendis magnam tempore rerum sed mollitia laborum tempora repellat. Enim, autem error a molestiae nisi ut dignissimos, dolorem sequi saepe ab praesentium et. Non tempore autem quis error commodi facilis reiciendis modi, nam, id dignissimos omnis quas tenetur dolore ab odit! Rem, soluta nulla ullam ipsam cumque nihil eaque doloremque, laborum architecto doloribus deserunt. Omnis, officiis. Temporibus iste quod veritatis officiis vel eius suscipit nisi tempora. Alias temporibus possimus, molestiae rem modi sint! Ab reiciendis minima magnam, ipsam sit, quisquam alias perspiciatis ullam voluptate blanditiis modi dolore similique labore beatae assumenda qui, dolor illo quae corrupti odio nostrum officia saepe accusantium nulla. Placeat quisquam quam asperiores iure quod cum, possimus autem, in consectetur cumque voluptate non atque corporis odio maxime sed quaerat porro. Unde, dignissimos ab! Ipsa dicta quas non qui vel temporibus voluptates nemo quos mollitia? Temporibus quo praesentium nostrum iure? Porro dolorum, corporis ipsam dignissimos ratione, accusamus deserunt mollitia voluptatem adipisci ea molestias aliquam? Eaque ea facilis repudiandae, nemo quisquam accusamus expedita! Veniam labore tenetur animi amet laboriosam officia blanditiis sint est doloremque fuga. Explicabo itaque pariatur doloremque fuga reprehenderit delectus error officiis id. Officiis quo facere sequi deserunt nostrum ab blanditiis debitis repudiandae repellat, aut vel exercitationem voluptatibus laudantium molestias nihil eum, omnis id fuga nisi asperiores? Itaque quis aliquid quisquam, optio recusandae impedit magnam numquam, praesentium ut molestiae eveniet blanditiis quae voluptas tempore doloremque perspiciatis nemo aperiam ab rem earum aliquam, culpa beatae! Optio accusamus magni neque architecto accusantium aliquam delectus, cum temporibus ea voluptatum.', NULL, NULL, NULL, NULL, 0);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_logs`
--
ALTER TABLE `inventory_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ui_section_items`
--
ALTER TABLE `ui_section_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
