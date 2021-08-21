-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for camila_db
CREATE DATABASE IF NOT EXISTS `camila_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `camila_db`;

-- Dumping structure for table camila_db.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_referencia` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.clients: ~3 rows (approximately)
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`id`, `nombre`, `cedula`, `telefono_referencia`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(6, 'Juan Palotes', '42270681209', '8095645149', 1, 1, '2020-12-17 12:08:59', '2020-12-17 12:12:41', NULL, 'ce0080ca4092ee61ca0a54ed2ebc5886'),
	(7, 'Maria Montero', '15400947546', '8097857471', 1, NULL, '2020-12-17 12:12:29', '2020-12-17 12:12:45', '2020-12-17 12:12:45', '2bff8a690075de52e1c82e5f090c971e'),
	(8, 'Josue Alcantara', '40255957857', '1809457458', 1, NULL, '2020-12-18 00:09:22', '2020-12-18 00:09:22', NULL, 'fcb30a42d7b3061aa34dc3422b6f9081');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;

-- Dumping structure for table camila_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table camila_db.line_inventories
CREATE TABLE IF NOT EXISTS `line_inventories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supply_line_id` int(11) NOT NULL,
  `cantidad_existencia` int(11) DEFAULT NULL,
  `costo_total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.line_inventories: ~0 rows (approximately)
/*!40000 ALTER TABLE `line_inventories` DISABLE KEYS */;
INSERT INTO `line_inventories` (`id`, `tipo`, `supply_line_id`, `cantidad_existencia`, `costo_total`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(2, 'PREPAGO', 27, 2, 400.00, 1, NULL, '2020-12-17 18:52:20', '2020-12-17 19:39:46', NULL, '5ebb46222cc2106e7c4b984631237f72');
/*!40000 ALTER TABLE `line_inventories` ENABLE KEYS */;

-- Dumping structure for table camila_db.line_inventory_details
CREATE TABLE IF NOT EXISTS `line_inventory_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `line_inventory_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` decimal(11,2) NOT NULL,
  `tipo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_serie` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.line_inventory_details: ~2 rows (approximately)
/*!40000 ALTER TABLE `line_inventory_details` DISABLE KEYS */;
INSERT INTO `line_inventory_details` (`id`, `line_inventory_id`, `cantidad`, `costo`, `tipo`, `numero_serie`, `orden_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(1, 2, 1, 200.00, 'E', '5HR4QZGd', NULL, 1, NULL, '2020-12-17 19:36:04', '2020-12-17 19:36:04', NULL, '765c7793da719dfa35b5c778588a8720'),
	(2, 2, 1, 200.00, 'E', 'w4PbiaEJ', NULL, 1, NULL, '2020-12-17 19:39:46', '2020-12-17 19:39:46', NULL, 'e6fd4fe5ea88ced36831e1ff100e7ae7');
/*!40000 ALTER TABLE `line_inventory_details` ENABLE KEYS */;

-- Dumping structure for table camila_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.migrations: ~0 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table camila_db.oauth_access_tokens
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

-- Dumping data for table camila_db.oauth_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- Dumping structure for table camila_db.oauth_auth_codes
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

-- Dumping data for table camila_db.oauth_auth_codes: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- Dumping structure for table camila_db.oauth_clients
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.oauth_clients: ~2 rows (approximately)
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Laravel Personal Access Client', 'teZXKj1QPy5dyCmQtyMr6m4s57YJO7zTGGF8I5zf', NULL, 'http://localhost', 1, 0, 0, '2020-08-20 22:15:50', '2020-08-20 22:15:50'),
	(2, NULL, 'Laravel Password Grant Client', 'sBReA3uW6bLbN7u5XdwYa9rycO6KvD3QoRWs5BrP', 'users', 'http://localhost', 0, 1, 0, '2020-08-20 22:15:50', '2020-08-20 22:15:50');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- Dumping structure for table camila_db.oauth_personal_access_clients
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.oauth_personal_access_clients: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2020-08-20 22:15:50', '2020-08-20 22:15:50');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- Dumping structure for table camila_db.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.oauth_refresh_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- Dumping structure for table camila_db.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `monto_total` decimal(11,2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.orders: ~0 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `status_id`, `client_id`, `monto_total`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(5, 7, 6, 250.00, 1, NULL, '2020-12-18 01:09:22', '2020-12-18 16:39:57', NULL, '8abf80bcf2c801c7a2595f4e2309f0f7');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table camila_db.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suplidor` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `tipo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.order_items: ~11 rows (approximately)
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `nombre`, `suplidor`, `cantidad`, `tipo`, `precio`, `key_id`, `created_at`, `deleted_at`, `updated_at`) VALUES
	(1, 5, 27, 'PREPAGO', '', 1, 'L', 0.00, '89d7bb1065d936e67e18a78a48ccb0f5', '2020-12-18 15:24:30', '2020-12-18 16:03:37', '2020-12-18 16:03:37'),
	(2, 5, 21, 'lumia 4 - 1234', '', 1, 'C', 0.00, 'cafb010745ce8987d499156e40637cf8', '2020-12-18 15:41:27', '2020-12-18 16:03:41', '2020-12-18 16:03:41'),
	(3, 5, 27, 'PREPAGO - Claro', '', 1, 'L', 0.00, '7632e4400a3f26cae0b3b0721de8d320', '2020-12-18 15:43:30', '2020-12-18 16:03:45', '2020-12-18 16:03:45'),
	(4, 5, 21, 'lumia 4 - 1234', '', 1, 'C', 5500.00, 'eb93245c9e475806b9251a84468b3386', '2020-12-18 15:59:33', '2020-12-18 16:15:18', '2020-12-18 16:15:18'),
	(5, 5, 27, 'PREPAGO - Claro', 'Claro', 1, 'L', 250.00, '1b651139e1e3c7ad1dca65440649f22a', '2020-12-18 16:15:36', '2020-12-18 16:29:26', '2020-12-18 16:29:26'),
	(6, 5, 21, 'lumia 4 - 1234', 'Nokia', 1, 'C', 250.00, '400daec77c6d6a74bf88aa8ac8244859', '2020-12-18 16:16:47', '2020-12-18 16:29:22', '2020-12-18 16:29:22'),
	(7, 5, 21, 'lumia 4 - 1234', 'Nokia', 1, 'C', 200.00, 'a2249ff3fd560a2eee63e31fb27219e0', '2020-12-18 16:30:58', '2020-12-18 16:31:29', '2020-12-18 16:31:29'),
	(8, 5, 27, 'PREPAGO - Claro', 'Claro', 1, 'L', 300.00, '623e7fbad282c6519ce707096c9ab7e6', '2020-12-18 16:31:18', '2020-12-18 16:32:23', '2020-12-18 16:32:23'),
	(9, 5, 27, 'PREPAGO - Claro', 'Claro', 1, 'L', 2000.00, 'e6cbf2f32c011fdc7739c14a0209901a', '2020-12-18 16:32:48', '2020-12-18 16:33:01', '2020-12-18 16:33:01'),
	(10, 5, 27, 'PREPAGO - Claro', 'Claro', 1, 'L', 250.00, 'cd573e6c7868a6ae2faf0245b92748c6', '2020-12-18 16:35:16', NULL, '2020-12-18 16:35:16'),
	(11, 5, 21, 'lumia 4 - 1234', 'Nokia', 1, 'C', 2000.00, '4a3884128c2a0bcfbb07742cc970efb1', '2020-12-18 16:39:50', '2020-12-18 16:39:57', '2020-12-18 16:39:57');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

-- Dumping structure for table camila_db.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table camila_db.phone_inventories
CREATE TABLE IF NOT EXISTS `phone_inventories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supply_id` int(11) NOT NULL,
  `cantidad_existencia` int(11) DEFAULT NULL,
  `costo_total` decimal(11,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.phone_inventories: ~0 rows (approximately)
/*!40000 ALTER TABLE `phone_inventories` DISABLE KEYS */;
INSERT INTO `phone_inventories` (`id`, `nombre`, `supply_id`, `cantidad_existencia`, `costo_total`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(19, 'lumia 4 - lumia 4', 21, 1, 500.00, 1, NULL, '2020-12-17 14:49:07', '2020-12-17 15:52:48', NULL, '3a6348ed57f3dca66023a89f9f3c60a5');
/*!40000 ALTER TABLE `phone_inventories` ENABLE KEYS */;

-- Dumping structure for table camila_db.phone_inventory_details
CREATE TABLE IF NOT EXISTS `phone_inventory_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone_inventory_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` decimal(11,2) NOT NULL,
  `tipo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imei` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.phone_inventory_details: ~0 rows (approximately)
/*!40000 ALTER TABLE `phone_inventory_details` DISABLE KEYS */;
INSERT INTO `phone_inventory_details` (`id`, `phone_inventory_id`, `cantidad`, `costo`, `tipo`, `imei`, `orden_id`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(55, 19, 1, 500.00, 'E', '540917012100303', NULL, 1, NULL, '2020-12-17 15:47:34', '2020-12-17 15:47:34', NULL, 'ea1f57f35165080090bf20cc571f8222'),
	(56, 19, 1, 358.36, 'E', '018437679212328', NULL, 1, NULL, '2020-12-17 15:51:57', '2020-12-17 15:52:48', '2020-12-17 15:52:48', '6822d3d9ae4fd91a685ca8f61cdf161b');
/*!40000 ALTER TABLE `phone_inventory_details` ENABLE KEYS */;

-- Dumping structure for table camila_db.statuses
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.statuses: ~2 rows (approximately)
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` (`id`, `nombre`, `code`, `default`, `activo`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(7, 'Creada', 'creada', 'si', 'si', 1, NULL, NULL, NULL, NULL, '202cb962ac59075b964b07152d234b70');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;

-- Dumping structure for table camila_db.suplidores
CREATE TABLE IF NOT EXISTS `suplidores` (
  `COL 1` int(2) DEFAULT NULL,
  `COL 2` varchar(31) DEFAULT NULL,
  `COL 3` varchar(32) DEFAULT NULL,
  `COL 4` varchar(29) DEFAULT NULL,
  `COL 5` varchar(16) DEFAULT NULL,
  `COL 6` varchar(16) DEFAULT NULL,
  `COL 7` varchar(28) DEFAULT NULL,
  `COL 8` varchar(40) DEFAULT NULL,
  `COL 9` varchar(3) DEFAULT NULL,
  `COL 10` varchar(41) DEFAULT NULL,
  `COL 11` varchar(2) DEFAULT NULL,
  `COL 12` varchar(10) DEFAULT NULL,
  `COL 13` int(1) DEFAULT NULL,
  `COL 14` varchar(15) DEFAULT NULL,
  `COL 15` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table camila_db.suplidores: ~0 rows (approximately)
/*!40000 ALTER TABLE `suplidores` DISABLE KEYS */;
/*!40000 ALTER TABLE `suplidores` ENABLE KEYS */;

-- Dumping structure for table camila_db.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enlace` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.suppliers: ~2 rows (approximately)
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` (`id`, `empresa`, `correo`, `telefono`, `enlace`, `activo`, `comentario`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(20, 'Nokia', 'vendedor@nokia.com', '1 (809) 243-5565', 'www.nokiard.com.do', 'si', 'un comentario', 1, 1, '2020-12-17 12:49:03', '2020-12-17 12:49:24', NULL, '2594524b1bff4327c7b71602ba514d65'),
	(21, 'Claro', 'ventas@claro.com.do', '1 (809) 844-5544', 'claro.com.do', 'si', 'un comentario', 1, NULL, '2020-12-17 16:50:28', '2020-12-17 16:50:28', NULL, '9d0b0fb4abf2e85cb54cdd44b60224df');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;

-- Dumping structure for table camila_db.supplies
CREATE TABLE IF NOT EXISTS `supplies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `suplidor` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.supplies: ~4 rows (approximately)
/*!40000 ALTER TABLE `supplies` DISABLE KEYS */;
INSERT INTO `supplies` (`id`, `nombre`, `supplier_id`, `suplidor`, `modelo`, `activo`, `comentario`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(18, 'lumia', 20, 'Nokia', '1234', 'si', 'la descripcion', 1, NULL, '2020-12-17 14:17:31', '2020-12-17 14:29:27', '2020-12-17 14:29:27', '002bdbf995ae51e573bd3634f3431c93'),
	(19, 'lumia 2', 20, 'Nokia', '1234', 'si', 'sadasdadadasdads', 1, NULL, '2020-12-17 14:45:26', '2020-12-17 14:49:12', '2020-12-17 14:49:12', '7b7312b79604f6ef65008030952f204b'),
	(20, 'lumia 3', 20, 'Nokia', '1234', 'si', 'sadasdadadasdads', 1, NULL, '2020-12-17 14:46:48', '2020-12-17 14:49:15', '2020-12-17 14:49:15', 'cef2e0fef0237894df9f19cdb3e425cf'),
	(21, 'lumia 4', 20, 'Nokia', '1234', 'si', 'sadasdadadasdads', 1, NULL, '2020-12-17 14:49:07', '2020-12-17 14:49:07', NULL, '3a6348ed57f3dca66023a89f9f3c60a5');
/*!40000 ALTER TABLE `supplies` ENABLE KEYS */;

-- Dumping structure for table camila_db.supply_lines
CREATE TABLE IF NOT EXISTS `supply_lines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `suplidor` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `key_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.supply_lines: ~6 rows (approximately)
/*!40000 ALTER TABLE `supply_lines` DISABLE KEYS */;
INSERT INTO `supply_lines` (`id`, `tipo`, `supplier_id`, `suplidor`, `activo`, `comentario`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `key_id`) VALUES
	(22, 'PREPAGO', 21, 'Claro', 'si', 'una linea prepago', 1, NULL, '2020-12-17 17:17:01', '2020-12-17 18:39:07', '2020-12-17 18:39:07', 'bb8ef7545b3b7b37335124a9c74c7e02'),
	(23, 'PREPAGO', 21, 'Claro', 'si', 'linea telefonica prepago', 1, NULL, '2020-12-17 18:40:54', '2020-12-17 18:51:50', '2020-12-17 18:51:50', '5bb0946ca589124ff4b6011507fe6bfd'),
	(24, 'PREPAGO', 21, 'Claro', 'si', 'linea telefonica prepago', 1, NULL, '2020-12-17 18:41:52', '2020-12-17 18:51:44', '2020-12-17 18:51:44', '058dc736ad854c66b5e513a2f30044bb'),
	(25, 'PREPAGO', 21, 'Claro', 'si', 'linea telefonica prepago', 1, NULL, '2020-12-17 18:42:52', '2020-12-17 18:51:40', '2020-12-17 18:51:40', '297f7763b93ab76c4545bd814015c391'),
	(26, 'PREPAGO', 21, 'Claro', 'si', 'linea telefonica prepago', 1, NULL, '2020-12-17 18:51:12', '2020-12-17 18:51:37', '2020-12-17 18:51:37', 'a4eb186ee9f2fea3be09bb0b243709f1'),
	(27, 'PREPAGO', 21, 'Claro', 'si', 'Una linea prepago', 1, NULL, '2020-12-17 18:52:20', '2020-12-17 18:52:20', NULL, '5ebb46222cc2106e7c4b984631237f72');
/*!40000 ALTER TABLE `supply_lines` ENABLE KEYS */;

-- Dumping structure for table camila_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table camila_db.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@camila.do', NULL, '$2y$10$O9FCxKKFHSTJ47XDAQk2.uQdm05nPkt6mTMQZ9K7PUnwAQUVpScIC', NULL, '2020-08-13 15:03:46', '2020-08-13 15:03:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
