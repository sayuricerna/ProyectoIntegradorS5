-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2025 at 03:59 PM
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
-- Database: `ecommercepi`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `zip` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `cedula`, `phone`, `address`, `city`, `province`, `country`, `reference`, `zip`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 23, 'Sayuri Cerna', '1759026535', '0980277855', 'santo domingo', 'santo domingo', 'SANTO DOMINGO', 'Ecuador', 'SANTO DOMINGO RR', '230105', '0', 1, '2025-07-24 16:54:04', '2025-07-24 16:54:04'),
(3, 24, 'JKUAN JUAN', '11212134', '5555555555', 'santo domingo', 'SANTO DOMINGO', 'santo domingo de los tsachilas', 'Ecuador', 'LO', '222222', '0', 1, '2025-07-24 17:11:09', '2025-07-24 17:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Fossil', 'fossil', '1753355120.png', '2025-07-24 16:05:20', '2025-07-24 16:05:20'),
(2, 'SwinRoom', 'swinroom', '1753355150.png', '2025-07-24 16:05:50', '2025-07-24 16:05:50'),
(3, 'Diesel', 'diesel', '1753355159.png', '2025-07-24 16:05:59', '2025-07-24 16:05:59'),
(4, 'TommyHilfiger', 'tommyhilfiger', '1753355167.png', '2025-07-24 16:06:07', '2025-07-24 16:06:07'),
(5, 'Rolex', 'rolex', '1753355181.png', '2025-07-24 16:06:21', '2025-07-24 16:06:21');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Bufandas', 'bufandas', '1753354645.png', NULL, '2025-07-24 15:57:27', '2025-07-24 15:57:27'),
(2, 'Camisetas', 'camisetas', '1753354669.png', NULL, '2025-07-24 15:57:49', '2025-07-24 15:57:49'),
(3, 'Shorts', 'shorts', '1753354679.png', NULL, '2025-07-24 15:57:59', '2025-07-24 15:57:59'),
(4, 'Pantalones', 'pantalones', '1753354693.png', NULL, '2025-07-24 15:58:13', '2025-07-24 15:58:13'),
(5, 'Chompas', 'chompas', '1753354704.png', NULL, '2025-07-24 15:58:24', '2025-07-24 15:58:24'),
(6, 'Bolsos', 'bolsos', '1753354716.png', NULL, '2025-07-24 15:58:36', '2025-07-24 15:58:36'),
(7, 'Gafas', 'gafas', '1753354727.png', NULL, '2025-07-24 15:58:47', '2025-07-24 15:58:47'),
(8, 'Gorras', 'gorras', '1753354737.png', NULL, '2025-07-24 15:58:57', '2025-07-24 15:58:57'),
(9, 'Medias', 'medias', '1753354746.png', NULL, '2025-07-24 15:59:06', '2025-07-24 15:59:06'),
(10, 'Zapatos', 'zapatos', '1753354756.png', NULL, '2025-07-24 15:59:16', '2025-07-24 15:59:16'),
(11, 'Cadenas', 'cadenas', '1753354767.png', NULL, '2025-07-24 15:59:27', '2025-07-24 15:59:27'),
(12, 'Pulseras', 'pulseras', '1753354780.png', NULL, '2025-07-24 15:59:40', '2025-07-24 15:59:40'),
(13, 'Conjuntos', 'conjuntos', '1753354793.png', NULL, '2025-07-24 15:59:53', '2025-07-24 15:59:53'),
(14, 'Relojes', 'relojes', '1753354805.png', NULL, '2025-07-24 16:00:05', '2025-07-24 16:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_email` varchar(255) NOT NULL,
  `client_cedula` varchar(255) NOT NULL,
  `client_phone` varchar(255) NOT NULL,
  `client_address` text NOT NULL,
  `client_city` varchar(255) NOT NULL,
  `client_province` varchar(255) NOT NULL,
  `client_country` varchar(255) NOT NULL,
  `client_zip` varchar(255) NOT NULL,
  `client_reference` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `subtotal` decimal(12,2) NOT NULL,
  `tax_amount` decimal(12,2) NOT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `pdf_path` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `issue_date`, `due_date`, `user_id`, `order_id`, `client_name`, `client_email`, `client_cedula`, `client_phone`, `client_address`, `client_city`, `client_province`, `client_country`, `client_zip`, `client_reference`, `payment_method`, `payment_status`, `subtotal`, `tax_amount`, `discount_amount`, `shipping_amount`, `total_amount`, `items`, `pdf_path`, `notes`, `terms`, `created_at`, `updated_at`) VALUES
(2, 'FACT-20250724-00001', '2025-07-24', NULL, 23, 2, 'Sayuri Cerna', 'user@user.com', '1759026535', '0980277855', 'santo domingo', 'santo domingo', 'SANTO DOMINGO', 'Ecuador', '230105', NULL, 'tranference', 'pending', 42.00, 6.30, 0.00, 0.00, 48.30, '[{\"name\":\"Camisetas en estilo boxyfit\",\"quantity\":1,\"price\":\"20.00\",\"sku\":\"CA006\",\"description\":\"NEWWW\\u203c\\ufe0f\\r\\nCamisetas en estilo boxyfit est\\u00e1n elaboradas con telas de s\\u00faper calidad, su peso aprox es de 300g\",\"unit_price\":20},{\"name\":\"Camisetas tipo polo con textura\",\"quantity\":1,\"price\":\"22.00\",\"sku\":\"CA005\",\"description\":\"NEWWW\\u2668\\ufe0f\\r\\nCamisetas tipo polo con textura, llegan con un estilo sofisticado muy apegado a la l\\u00ednea Old Money \\ud83e\\udd84\\r\\nTallas: S M y L corte regular\",\"unit_price\":22}]', 'invoices/invoice_FACT-20250724-00001.pdf', NULL, NULL, '2025-07-24 16:54:04', '2025-07-24 16:54:04'),
(3, 'FACT-20250724-00002', '2025-07-24', NULL, 23, 3, 'Sayuri Cerna', 'user@user.com', '1759026535', '0980277855', 'santo domingo', 'santo domingo', 'SANTO DOMINGO', 'Ecuador', '230105', NULL, 'stripe', 'pending', 43.00, 6.45, 0.00, 0.00, 49.45, '[{\"name\":\"Camiseta Lana del Rey\",\"quantity\":1,\"price\":\"19.00\",\"sku\":\"CA004\",\"description\":\"Camiseta Lana del Rey personalizado\",\"unit_price\":19},{\"name\":\"Cargo pants oversize\",\"quantity\":1,\"price\":\"24.00\",\"sku\":\"PA005\",\"description\":\"RESTOCK\\u203c\\ufe0f\\r\\nCargo pants oversize \\ud83e\\udd84\\r\\nTallas: 28 30 32 34 y 36 \\ud83d\\udd25\",\"unit_price\":24}]', 'invoices/invoice_FACT-20250724-00002.pdf', NULL, NULL, '2025-07-24 16:55:16', '2025-07-24 16:55:16'),
(4, 'FACT-20250724-00003', '2025-07-24', NULL, 24, 4, 'JKUAN JUAN', 'user2@gmail.com', '11212134', '5555555555', 'santo domingo', 'SANTO DOMINGO', 'santo domingo de los tsachilas', 'Ecuador', '222222', NULL, 'tranference', 'pending', 62.00, 9.30, 0.00, 0.00, 71.30, '[{\"name\":\"Camisetas en estilo boxyfit\",\"quantity\":2,\"price\":\"20.00\",\"sku\":\"CA006\",\"description\":\"NEWWW\\u203c\\ufe0f\\r\\nCamisetas en estilo boxyfit est\\u00e1n elaboradas con telas de s\\u00faper calidad, su peso aprox es de 300g\",\"unit_price\":10},{\"name\":\"Camisetas tipo polo con textura\",\"quantity\":1,\"price\":\"22.00\",\"sku\":\"CA005\",\"description\":\"NEWWW\\u2668\\ufe0f\\r\\nCamisetas tipo polo con textura, llegan con un estilo sofisticado muy apegado a la l\\u00ednea Old Money \\ud83e\\udd84\\r\\nTallas: S M y L corte regular\",\"unit_price\":22}]', 'invoices/invoice_FACT-20250724-00003.pdf', NULL, NULL, '2025-07-24 17:11:09', '2025-07-24 17:11:09'),
(5, 'FACT-20250724-00004', '2025-07-24', NULL, 24, 5, 'JKUAN JUAN', 'user2@gmail.com', '11212134', '5555555555', 'santo domingo', 'SANTO DOMINGO', 'santo domingo de los tsachilas', 'Ecuador', '222222', NULL, 'stripe', 'pending', 48.00, 7.20, 0.00, 0.00, 55.20, '[{\"name\":\"Pantalones anchos tipo cargo\",\"quantity\":2,\"price\":\"24.00\",\"sku\":\"PA004\",\"description\":\"NEWWW\\u2668\\ufe0f\\r\\nPantalones anchos tipo cargo.\\r\\nTallas: 28 30 32 34 y 36\",\"unit_price\":12}]', 'invoices/invoice_FACT-20250724-00004.pdf', NULL, NULL, '2025-07-24 17:11:58', '2025-07-24 17:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_04_185931_create_brands_table', 1),
(5, '2025_07_07_010007_create_categories_table', 1),
(6, '2025_07_07_200958_create_products_table', 1),
(7, '2025_07_13_191856_create_orders_table', 1),
(8, '2025_07_13_191905_create_order_items_table', 1),
(9, '2025_07_13_191919_create_addresses_table', 1),
(10, '2025_07_13_191934_create_transactions_table', 1),
(11, '2025_07_13_224546_make_mobile_nullable_in_users_table', 1),
(12, '2025_07_22_034206_create_invoices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cedula` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home',
  `status` enum('ordered','delivered','canceled') NOT NULL DEFAULT 'ordered',
  `is_shipping_different` tinyint(1) NOT NULL DEFAULT 0,
  `delivered_date` date DEFAULT NULL,
  `canceled_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `discount`, `tax`, `total`, `name`, `cedula`, `phone`, `address`, `city`, `province`, `country`, `reference`, `zip`, `type`, `status`, `is_shipping_different`, `delivered_date`, `canceled_date`, `created_at`, `updated_at`) VALUES
(2, 23, 42.00, 0.00, 6.30, 48.30, 'Sayuri Cerna', '1759026535', '0980277855', 'santo domingo', 'santo domingo', 'SANTO DOMINGO', 'Ecuador', 'SANTO DOMINGO RR', '230105', 'home', 'ordered', 0, NULL, NULL, '2025-07-24 16:54:04', '2025-07-24 16:54:04'),
(3, 23, 43.00, 0.00, 6.45, 49.45, 'Sayuri Cerna', '1759026535', '0980277855', 'santo domingo', 'santo domingo', 'SANTO DOMINGO', 'Ecuador', 'SANTO DOMINGO RR', '230105', 'home', 'delivered', 0, '2025-07-24', NULL, '2025-07-24 16:55:09', '2025-07-24 17:03:42'),
(4, 24, 62.00, 0.00, 9.30, 71.30, 'JKUAN JUAN', '11212134', '5555555555', 'santo domingo', 'SANTO DOMINGO', 'santo domingo de los tsachilas', 'Ecuador', 'LO', '222222', 'home', 'ordered', 0, NULL, NULL, '2025-07-24 17:11:09', '2025-07-24 17:11:09'),
(5, 24, 48.00, 0.00, 7.20, 55.20, 'JKUAN JUAN', '11212134', '5555555555', 'santo domingo', 'SANTO DOMINGO', 'santo domingo de los tsachilas', 'Ecuador', 'LO', '222222', 'home', 'delivered', 0, '2025-07-24', NULL, '2025-07-24 17:11:56', '2025-07-24 17:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `options` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `product_id`, `order_id`, `price`, `quantity`, `options`, `status`, `created_at`, `updated_at`) VALUES
(3, 14, 2, 20.00, 1, NULL, 0, '2025-07-24 16:54:04', '2025-07-24 16:54:04'),
(4, 12, 2, 22.00, 1, NULL, 0, '2025-07-24 16:54:04', '2025-07-24 16:54:04'),
(5, 11, 3, 19.00, 1, NULL, 0, '2025-07-24 16:55:09', '2025-07-24 16:55:09'),
(6, 10, 3, 24.00, 1, NULL, 0, '2025-07-24 16:55:09', '2025-07-24 16:55:09'),
(7, 14, 4, 20.00, 2, NULL, 0, '2025-07-24 17:11:09', '2025-07-24 17:11:09'),
(8, 12, 4, 22.00, 1, NULL, 0, '2025-07-24 17:11:09', '2025-07-24 17:11:09'),
(9, 9, 5, 24.00, 2, NULL, 0, '2025-07-24 17:11:56', '2025-07-24 17:11:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `regular_price` decimal(8,2) NOT NULL,
  `sale_price` decimal(8,2) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `stock_status` enum('instock','outofstock') NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `short_description`, `description`, `regular_price`, `sale_price`, `sku`, `stock_status`, `featured`, `quantity`, `image`, `images`, `category_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(1, 'Camisas estilo Old money', 'camisas-estilo-old-money', 'RESTOCK♨️\r\nCamisas estilo Old money, corte oversize, con textura 🦄', 'RESTOCK♨️\r\nCamisas estilo Old money, corte oversize, con textura 🦄', 20.00, 19.00, 'CA001', 'instock', 0, 5, '1753355491.png', '', 2, 2, '2025-07-24 16:11:32', '2025-07-24 16:11:32'),
(2, 'Camisetas Messi vintage', 'camisetas-messi-vintage', 'RESTOCK♨️\r\nCamisetas Messi vintage, tallas: XS S M L oversize', 'RESTOCK♨️\r\nCamisetas Messi vintage, tallas: XS S M L oversize', 20.00, 19.00, 'CA002', 'instock', 0, 10, '1753355547.png', '', 2, 2, '2025-07-24 16:12:28', '2025-07-24 16:12:28'),
(3, 'Pantalonetas en estilo oversize', 'pantalonetas-en-estilo-oversize', 'RESTOCK♨️\r\nPantalonetas en estilo oversize ♨️', 'RESTOCK♨️\r\nPantalonetas en estilo oversize ♨️', 21.00, 20.00, 'SH001', 'instock', 0, 4, '1753355609.png', '', 3, 2, '2025-07-24 16:13:30', '2025-07-24 16:13:30'),
(4, 'Calentadores en estilo oversize', 'calentadores-en-estilo-oversize', 'RESTOCK♨️\r\nCalentadores en estilo oversize, material flecce en algodón perchado, tallas: XS S M L oversize', 'RESTOCK♨️\r\nCalentadores en estilo oversize, material flecce en algodón perchado, tallas: XS S M L oversize', 16.00, 15.00, 'PA001', 'instock', 0, 10, '1753355679.png', '', 4, 2, '2025-07-24 16:14:39', '2025-07-24 16:14:50'),
(5, 'Pantalones en corte widleg', 'pantalones-en-corte-widleg', 'RESTOCK♨️\r\nPantalones en corte widleg, tienen un corte angosto en la cintura y amplio, tres colores.', 'RESTOCK♨️\r\nPantalones en corte widleg, tienen un corte angosto en la cintura y amplio, tres colores.', 25.00, 24.00, 'PA002', 'instock', 0, 7, '1753355796.png', '', 4, 2, '2025-07-24 16:16:36', '2025-07-24 16:16:36'),
(6, 'Pantalones corte mom jean', 'pantalones-corte-mom-jean', 'RESTOCK♨️\r\nPantalones corte mom jean,', 'RESTOCK♨️\r\nPantalones corte mom jean,', 25.00, 24.00, 'PA003', 'instock', 0, 15, '1753355867.png', '', 4, 2, '2025-07-24 16:17:47', '2025-07-24 16:17:47'),
(7, 'Hoodies boxy fit con cierre', 'hoodies-boxy-fit-con-cierre', 'NEWWW♨️\r\nHoodies boxy fit con cierre 🦄\r\nTallas: XS S M L oversize boxyfit ‼️', 'NEWWW♨️\r\nHoodies boxy fit con cierre 🦄\r\nTallas: XS S M L oversize boxyfit ‼️', 21.00, 200.00, 'CH001', 'instock', 0, 11, '1753355945.png', '', 5, 2, '2025-07-24 16:19:05', '2025-07-24 16:19:05'),
(8, 'Camisetas con textura', 'camisetas-con-textura', 'NEWWW‼️\r\nCamisetas con textura en estilo Old money, tallas disponibles S M y L oversize.', 'NEWWW‼️\r\nCamisetas con textura en estilo Old money, tallas disponibles S M y L oversize.', 24.00, 23.00, 'CA003', 'instock', 0, 12, '1753356024.png', '', 2, 2, '2025-07-24 16:20:25', '2025-07-24 16:20:25'),
(9, 'Pantalones anchos tipo cargo', 'pantalones-anchos-tipo-cargo', 'NEWWW♨️\r\nPantalones anchos tipo cargo.\r\nTallas: 28 30 32 34 y 36', 'NEWWW♨️\r\nPantalones anchos tipo cargo.\r\nTallas: 28 30 32 34 y 36', 25.00, 24.00, 'PA004', 'instock', 0, 16, '1753356085.png', '', 4, 2, '2025-07-24 16:21:26', '2025-07-24 16:21:26'),
(10, 'Cargo pants oversize', 'cargo-pants-oversize', 'RESTOCK‼️\r\nCargo pants oversize 🦄\r\nTallas: 28 30 32 34 y 36 🔥', 'RESTOCK‼️\r\nCargo pants oversize 🦄\r\nTallas: 28 30 32 34 y 36 🔥', 25.00, 24.00, 'PA005', 'instock', 0, 9, '1753356153.png', '', 4, 2, '2025-07-24 16:22:33', '2025-07-24 16:22:33'),
(11, 'Camiseta Lana del Rey', 'camiseta-lana-del-rey', 'Camiseta Lana del Rey personalizado', 'Camiseta Lana del Rey personalizado', 20.00, 19.00, 'CA004', 'instock', 0, 6, '1753356245.png', '', 2, 2, '2025-07-24 16:24:05', '2025-07-24 16:24:05'),
(12, 'Camisetas tipo polo con textura', 'camisetas-tipo-polo-con-textura', 'NEWWW♨️\r\nCamisetas tipo polo con textura, llegan con un estilo sofisticado muy apegado a la línea Old Money 🦄\r\nTallas: S M y L corte regular', 'NEWWW♨️\r\nCamisetas tipo polo con textura, llegan con un estilo sofisticado muy apegado a la línea Old Money 🦄\r\nTallas: S M y L corte regular', 23.00, 22.00, 'CA005', 'instock', 0, 19, '1753356310.png', '', 2, 2, '2025-07-24 16:25:11', '2025-07-24 16:25:11'),
(13, 'sunglasses MARCO TRANSPARENTE', 'sunglasses-marco-transparente', 'NEWWW‼️\r\nLos sunglasses que te hacen falta para este verano🦄', 'NEWWW‼️\r\nLos sunglasses que te hacen falta para este verano🦄', 15.00, 14.00, 'GA001', 'instock', 1, 2, '1753356401.png', '', 7, 2, '2025-07-24 16:26:41', '2025-07-24 16:52:27'),
(14, 'Camisetas en estilo boxyfit', 'camisetas-en-estilo-boxyfit', 'NEWWW‼️\r\nCamisetas en estilo boxyfit están elaboradas con telas de súper calidad, su peso aprox es de 300g', 'NEWWW‼️\r\nCamisetas en estilo boxyfit están elaboradas con telas de súper calidad, su peso aprox es de 300g lo que hace que el está tenga una buena caída, las prendas en corte boxy siguen siendo tendencia para este 2025, qué esperas para obtener la tuya?🔥\r\nTallas: S M y L', 21.00, 20.00, 'CA006', 'instock', 1, 13, '1753356533.png', '', 2, 2, '2025-07-24 16:28:53', '2025-07-24 16:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1jGQHujEWMGx5dDPsi4xzT146kuXVYHMNixQ6tZl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0hmaDdpQmV4WndvZjhLRm83T1FDM01mZUdnRngwaFl4Q3hsejB2UCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1753359290),
('1YmkF6AfkjxbVVTH5D6IfSR4ibEcXSRsLELovfCr', NULL, '192.168.1.7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSldWRUVINjd1MDA2cFFYaWVQakI0WXcyTTJlSTNJS2dOVzdYYVdEayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly8xOTIuMTY4LjEuNzo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1753363577),
('7z2w3pOBspcHGkHOjyeUFwg4tbktbwB724B5QlNy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWtVZHZ2OHpaWFNPb2Vxb1V3bXVWVmVmTTBpRFFGNXU2MmZZUDVnaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fX0=', 1753365538),
('NN5Q9aBD8Ub0qEGfXxmKF8LA7xorxbl8dc7bjlFQ', 25, '192.168.1.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR1pBMEJ5Qk1oMVJYOUVob01qNXRxQkdGYnpZc1l1OXpzVml6WDhYRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly8xOTIuMTY4LjEuNzo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjU7fQ==', 1753363742);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `mode` enum('stripe','tranference') NOT NULL,
  `status` enum('pending','approved','declined','refunded') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `user_id`, `order_id`, `mode`, `status`, `created_at`, `updated_at`) VALUES
(2, NULL, 23, 2, 'tranference', 'pending', '2025-07-24 16:54:04', '2025-07-24 16:54:04'),
(3, 'pi_3RoNksDCtM4kZKLk153TXXX9', 23, 3, 'stripe', 'approved', '2025-07-24 16:55:16', '2025-07-24 16:55:16'),
(4, NULL, 24, 4, 'tranference', 'pending', '2025-07-24 17:11:09', '2025-07-24 17:11:09'),
(5, 'pi_3RoO17DCtM4kZKLk1hPFcxTm', 24, 5, 'stripe', 'approved', '2025-07-24 17:11:58', '2025-07-24 17:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `utype` varchar(255) NOT NULL DEFAULT 'USR' COMMENT 'ADM para administrador USR para usuario',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `password`, `utype`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ADMINISTRADOR', 'admin@admin.com', '1234567891', NULL, '$2y$12$Ha4e.7CLBjuuO2D6QoBMGebzgq6zVjsiOl3AlBF8kNxKrIyOSbJg2', 'ADM', NULL, '2025-07-24 15:06:46', '2025-07-24 15:06:46'),
(3, 'Gabriela Torres', 'gabriela.torres@mail.com', '0987456123', NULL, '$2y$12$0JhZcPuwP0YDR8gF6SaB4eoZXWguB.whC151.OrGsUueq0SgWlpTu', 'USR', NULL, '2025-07-24 15:16:36', '2025-07-24 15:16:36'),
(23, 'usuario', 'user@user.com', '1212121212', NULL, '$2y$12$BiDtD72V4abb1ubnOcVKN.qa0IjVhrWZoVCDcO.AYUAX3q1ot6EW6', 'USR', NULL, '2025-07-24 16:50:30', '2025-07-24 16:50:30'),
(24, 'user2', 'user2@gmail.com', '7766554422', NULL, '$2y$12$bxlGNtaHVxGYO/PDKYU3QegrDq6i8nayC4HHpwswg7lax6nw/Yclm', 'USR', NULL, '2025-07-24 17:07:31', '2025-07-24 17:07:31'),
(25, 'Usuario56', 'user@outlook.com', '0980275555', NULL, '$2y$12$g8dYgLJIBUWy.tbO9HL3rOlXIpuWajTdjAfQuEvd5Wopft7icogSy', 'USR', NULL, '2025-07-24 18:28:14', '2025-07-24 18:28:14'),
(26, 'usuario77', 'usuario77@gmail.com', '4567890123', NULL, '$2y$12$laVCI8uDZR0DMRiX907gIeEUtfOi6QEhbriWKwh4mESf8P0nZE6ge', 'USR', NULL, '2025-07-24 18:42:17', '2025-07-24 18:42:17'),
(27, 'Enrique Vasquez', 'vasenrique@gmail.com', '0986926654', NULL, '$2y$12$Lhrvzj9vBLZj9siUgBd40u4Ix.nSsa4AcKBj1Dk4baMY42FHjU87.', 'USR', NULL, '2025-07-24 18:43:50', '2025-07-24 18:43:50'),
(28, 'Agusti Garcia', 'agusg@gmail.com', '0986926651', NULL, '$2y$12$FNQsNQEGcKbSb1YRqeJTluvN.JcVe8gTcPI7T3sSmxC354ezTxNRi', 'USR', NULL, '2025-07-24 18:44:50', '2025-07-24 18:44:50'),
(29, 'carlos villegas', 'carlitos@gmail.com', '0986926652', NULL, '$2y$12$PbpHpR3ATOo0d5ktq1ECh.Bk/UZ1R6QIDbp/lGpUucFmae1KWfm/C', 'USR', NULL, '2025-07-24 18:47:55', '2025-07-24 18:47:55'),
(30, 'roberto flores', 'robertofff@gmail.com', '0986926653', NULL, '$2y$12$8iA657Hcgbk6Vsri37fPZugm7zz7eLqPOZPnUlc4cvxccRJR4fzyK', 'USR', NULL, '2025-07-24 18:48:57', '2025-07-24 18:48:57'),
(31, 'mercedes garcia', 'mercedesgg@gmail.com', '0986926655', NULL, '$2y$12$VY6yR0BEjIIVo6mF791OXemxKh/rg0uORFtpKHAfrFP5gr2pOTGGC', 'USR', NULL, '2025-07-24 18:49:49', '2025-07-24 18:49:49'),
(32, 'maria gomez', 'marygz@gmail.com', '0986926656', NULL, '$2y$12$LdZKy2P8RZOj4NmNNFMzaeXOS0ggpOaAh7/6P9Hd1dfjJw.yGbOwC', 'USR', NULL, '2025-07-24 18:52:17', '2025-07-24 18:52:17'),
(33, 'martin valente', 'martinnn@gmail.com', '0986926657', NULL, '$2y$12$fcY93h/I17mmj8Y36ozQouSQEBZ.i/QNw1sbletaFcXR0ybooNqri', 'USR', NULL, '2025-07-24 18:53:33', '2025-07-24 18:53:33'),
(34, 'angely flores', 'angieflores@gmail.com', '0986926658', NULL, '$2y$12$3LsfXL5N5DZbk.p7CcjhaO.ymUpAXkoAVdW0z9grfKJeU2HZyJJTG', 'USR', NULL, '2025-07-24 18:54:27', '2025-07-24 18:54:27'),
(35, 'wilthon baque', 'wilthonbaque@gmail.com', '0986000001', NULL, '$2y$12$L83di6f1rai3GGqPe0zBF.Z/J/riv0ZvisCnoyhd3NZGfHZZiTb3K', 'USR', NULL, '2025-07-24 18:55:48', '2025-07-24 18:55:48'),
(36, 'michael castro', 'michaelcastro@gmail.com', '0986000002', NULL, '$2y$12$hpLZDQcjOzmEPYUrDcSNtOxOGx7E4T9OLFaJjV77m1pwKuyl2m0sC', 'USR', NULL, '2025-07-24 18:56:28', '2025-07-24 18:56:28'),
(37, 'sayuri cerna', 'sayuricerna@gmail.com', '0986000003', NULL, '$2y$12$bCeZWy3RQeNyCWE7P8YZyut9uxvsa8yp1Jl1Kzs/9CCvVajcejDzC', 'USR', NULL, '2025-07-24 18:57:06', '2025-07-24 18:57:06'),
(38, 'roger medina', 'roger@gmail.com', '0986000004', NULL, '$2y$12$6TIT2fSiqQJZLBrCrzEclOzxF2pih8y.ehZeR7VhVdNuei0Z1wTpi', 'USR', NULL, '2025-07-24 18:58:07', '2025-07-24 18:58:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `addresses_cedula_unique` (`cedula`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_user_id_foreign` (`user_id`),
  ADD KEY `invoices_order_id_foreign` (`order_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_order_id_foreign` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
