-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 10:33 AM
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
-- Database: `latestgtech_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_name` varchar(255) DEFAULT NULL,
  `agent_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `agent_name`, `agent_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FCagent', 'FCagent001', '1', '2025-07-02 08:31:28', '2025-07-02 08:31:28');

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
-- Table structure for table `deposit_transactions`
--

CREATE TABLE `deposit_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_code` varchar(255) DEFAULT NULL,
  `reference_id` varchar(255) DEFAULT NULL,
  `systemgenerated_TransId` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `net_amount` varchar(255) DEFAULT NULL,
  `mdr_fee_amount` varchar(255) DEFAULT NULL,
  `gateway_name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `Currency` varchar(255) DEFAULT NULL,
  `gateway_TransId` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT 'pending',
  `callback_url` varchar(255) DEFAULT NULL,
  `payment_channel` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `bank_code` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `request_data` longtext DEFAULT NULL,
  `payin_arr` longtext DEFAULT NULL,
  `response_data` longtext DEFAULT NULL,
  `agent_id` varchar(255) DEFAULT NULL,
  `merchant_id` varchar(255) DEFAULT NULL,
  `receipt_url` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposit_transactions`
--

INSERT INTO `deposit_transactions` (`id`, `merchant_code`, `reference_id`, `systemgenerated_TransId`, `amount`, `net_amount`, `mdr_fee_amount`, `gateway_name`, `customer_name`, `Currency`, `gateway_TransId`, `payment_status`, `callback_url`, `payment_channel`, `payment_method`, `product_id`, `bank_account_name`, `bank_code`, `bank_account_number`, `request_data`, `payin_arr`, `response_data`, `agent_id`, `merchant_id`, `receipt_url`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'FCmerchant001', 'GR202506-023', 'TR202507011326574908', '8032.00', '7923.568', '108.432', 'RichPay', 'K.EAKKACHAI POEMSATI 1 ROOM', 'THB', 'LMAJSG-1751351217947-20250701132657-bc0512', 'success', 'https://payment.implogix.com/api/r2p/payin/callbackURL', '18', 'QR Payment', '27', 'สุพรรษา ปั้นทอง', 'KBANK', '1448702118', '{\"method_name\":\"QR Payment\",\"e_comm_website\":\"https:\\/\\/payment.implogix.com\\/r2pPayin\",\"apiKey\":\"c48beec83f740331c0ff58\",\"secretKey\":\"Z0FBQUFBQm55WHJRYllhRGdjNXl5NjFvTDRLRHNhcElGamN3\",\"api_url\":\"https:\\/\\/service.richpay.io\\/api\\/v1\\/client\\/create_deposit\",\"secretToken\":\"dddddd\"}', '{\"status\":\"CREATED\",\"ref_id\":\"LMAJSG-1751351217947-20250701132657-bc0512\",\"dest_bank_code\":\"006\",\"dest_bank_acc_no\":\"0405560005688\",\"dest_bank_acc_name\":\"\\u0e1a\\u0e08. \\u0e1e\\u0e38\\u0e17\\u0e18\\u0e34\\u0e1e\\u0e31\\u0e0a\\u0e23 \\u0e04\\u0e2d\\u0e23\\u0e4c\\u0e1b\\u0e2d\\u0e23\\u0e4c\\u0e40\\u0e23\\u0e0a\\u0e31\\u0e48\\u0e19\",\"order_id\":\"TR202507011326574908\",\"amount\":8032,\"qr_image\":\"iVBORw0KGgoAAAANSUhEUgAAAXIAAAFyAQAAAADAX2ykAAACbElEQVR4nO2bSY7bMBBFX4UCvJSBPoCOIt+skZuJR\\/EBAkhLARJ+FiRtuY0MnSjqZlBcyLT4FgUUPmtw2cR7VvzyLhycd95555133vkf8ZZXA0wNMOUX951dDrTH+Z35XpI0ArFbgHaBfgQgSJL0yP9re5zfmZ+yQu11XI1oDRpaKb1Lwj7UHuf34Zs33xXPY9Kq9cPaiOlYe5w\\/gLdXSUQ7Jf1+uD3O\\/zFf9NsKmID+aiiev22EvW2BfDb7nf8tPpqZ2RnsQpC9Xk8q+dVaMukj7XF+Jz7JdKvQdjZoZ1PsZtPj2eez3\\/mfr+Rfg7AUiQZZtCDrr006gOllOcge5\\/flSdXt0Eqp6qVd0JB2+UDDnfts9jv\\/i5X9BqT+Rj8GSWNQcnIv6f5w\\/9bGZ\\/9KpWuVGlYjaKA4mXZx\\/dbJ3\\/wr3aVLP0LZhXxxu35r5Df+TUG4L1dzFnFyrfu3Ur74d8y3co61Y1A+Tbvg8bdyfjVoJZga9LWbTRqDzLrZchA+1h7nd+Fv\\/cmlIV7ConjGgJMMAmI6CabG6986+c39nPVbtFpisufPNfOU1PlW\\/+qeZJVI7PVvtfyTTG+x9kG6rt9K+Uf93lVbDvLy\\/LlSflv\\/bjx9L4eLk12\\/VfJPMuVN1PX4WzWf66N+AJheANZGsZuNNMTRLsD0sugYe5zfl9\\/E322veXycivX+8\\/\\/Cp67z1242s\\/OaWlfp18PhQ+xxfl\\/eLkCev7qeBNMpjWPZ5UPscf7v+Kf5SQDFbkFMq9FrNeI54PG3Sv45f4b815RcGoVNEu3xtzb+7fykHj+VH4vr13nnnXfeeef3478DLq4XJpjQHLMAAAAASUVORK5CYII=\",\"qr_image_link\":\"https:\\/\\/storage.googleapis.com\\/corp-richpay_richman_qr_data\\/006\\/LMAJSG-1751351217947-20250701132657-bc0512.png\",\"create_time\":\"2025-07-01T13:26:57.906176+07:00\",\"expire_time\":\"2025-07-01T13:41:57.906176+07:00\"}', '{\"type\":\"DEPOSIT\",\"status\":\"AUTO_SUCCESS\",\"status_desc\":\"DEPOSIT_MATCH\",\"amount\":8032,\"mdr_amount\":108.43,\"txn_ref_id\":\"LMAJSG-1751351217947-20250701132657-bc0512\",\"txn_ref_order_id\":\"TR202507011326574908\",\"txn_ref_bank_code\":\"004\",\"txn_ref_bank_acc_no\":\"1448702118\",\"txn_ref_bank_acc_name_th\":\"K.EAKKACHAI POEMSATI 1 ROOM\",\"txn_ref_bank_acc_name_en\":\"K.EAKKACHAI POEMSATI 1 ROOM\",\"txn_ref_user_id\":null,\"txn_ref1\":null,\"txn_ref2\":null,\"txn_timestamp\":\"2025-07-01T13:26:57.906176+07:00\",\"stm_timestamp\":\"2025-07-01T13:32:30.436627+07:00\",\"stm_bank_code\":\"006\",\"stm_bank_acc_no\":\"6438002332\",\"stm_bank_acc_name\":\"\\u0e1a\\u0e08. \\u0e1e\\u0e38\\u0e17\\u0e18\\u0e34\\u0e1e\\u0e31\\u0e0a\\u0e23 \\u0e04\\u0e2d\\u0e23\\u0e4c\\u0e1b\\u0e2d\\u0e23\\u0e4c\\u0e40\\u0e23\\u0e0a\\u0e31\\u0e48\\u0e19\",\"stm_desc\":\"\\u0e42\\u0e2d\\u0e19\\u0e40\\u0e07\\u0e34\\u0e19\\u0e40\\u0e02\\u0e49\\u0e32\\u0e1e\\u0e23\\u0e49\\u0e2d\\u0e21\\u0e40\\u0e1e\\u0e22\\u0e4c TR fr 004-1448702118 - (6436002332838683) 2025-07-01T13:27:30+07:00\",\"stm_ref_id\":\"KTB-SUCCESS-ONHHVY-1751351550407-20250701133230-da7c07\"}', '1', '1', 'https://storage.googleapis.com/corp-richpay_richman_qr_data/006/LMAJSG-1751351217947-20250701132657-bc0512.png', '147.50.108.8', '2025-07-03 08:52:52', '2025-07-02 08:52:52'),
(2, 'FCmerchant001', 'GR202506-023', 'TR202507011326574908', '8032.00', '7923.568', '108.432', 'RichPay', 'K.EAKKACHAI POEMSATI 1 ROOM', 'THB', 'LMAJSG-1751351217947-20250701132657-bc0512', 'success', 'https://payment.implogix.com/api/r2p/payin/callbackURL', '18', 'QR Payment', '27', 'สุพรรษา ปั้นทอง', 'KBANK', '1448702118', '{\"method_name\":\"QR Payment\",\"e_comm_website\":\"https:\\/\\/payment.implogix.com\\/r2pPayin\",\"apiKey\":\"c48beec83f740331c0ff58\",\"secretKey\":\"Z0FBQUFBQm55WHJRYllhRGdjNXl5NjFvTDRLRHNhcElGamN3\",\"api_url\":\"https:\\/\\/service.richpay.io\\/api\\/v1\\/client\\/create_deposit\",\"secretToken\":\"dddddd\"}', '{\"status\":\"CREATED\",\"ref_id\":\"LMAJSG-1751351217947-20250701132657-bc0512\",\"dest_bank_code\":\"006\",\"dest_bank_acc_no\":\"0405560005688\",\"dest_bank_acc_name\":\"\\u0e1a\\u0e08. \\u0e1e\\u0e38\\u0e17\\u0e18\\u0e34\\u0e1e\\u0e31\\u0e0a\\u0e23 \\u0e04\\u0e2d\\u0e23\\u0e4c\\u0e1b\\u0e2d\\u0e23\\u0e4c\\u0e40\\u0e23\\u0e0a\\u0e31\\u0e48\\u0e19\",\"order_id\":\"TR202507011326574908\",\"amount\":8032,\"qr_image\":\"iVBORw0KGgoAAAANSUhEUgAAAXIAAAFyAQAAAADAX2ykAAACbElEQVR4nO2bSY7bMBBFX4UCvJSBPoCOIt+skZuJR\\/EBAkhLARJ+FiRtuY0MnSjqZlBcyLT4FgUUPmtw2cR7VvzyLhycd95555133vkf8ZZXA0wNMOUX951dDrTH+Z35XpI0ArFbgHaBfgQgSJL0yP9re5zfmZ+yQu11XI1oDRpaKb1Lwj7UHuf34Zs33xXPY9Kq9cPaiOlYe5w\\/gLdXSUQ7Jf1+uD3O\\/zFf9NsKmID+aiiev22EvW2BfDb7nf8tPpqZ2RnsQpC9Xk8q+dVaMukj7XF+Jz7JdKvQdjZoZ1PsZtPj2eez3\\/mfr+Rfg7AUiQZZtCDrr006gOllOcge5\\/flSdXt0Eqp6qVd0JB2+UDDnfts9jv\\/i5X9BqT+Rj8GSWNQcnIv6f5w\\/9bGZ\\/9KpWuVGlYjaKA4mXZx\\/dbJ3\\/wr3aVLP0LZhXxxu35r5Df+TUG4L1dzFnFyrfu3Ur74d8y3co61Y1A+Tbvg8bdyfjVoJZga9LWbTRqDzLrZchA+1h7nd+Fv\\/cmlIV7ConjGgJMMAmI6CabG6986+c39nPVbtFpisufPNfOU1PlW\\/+qeZJVI7PVvtfyTTG+x9kG6rt9K+Uf93lVbDvLy\\/LlSflv\\/bjx9L4eLk12\\/VfJPMuVN1PX4WzWf66N+AJheANZGsZuNNMTRLsD0sugYe5zfl9\\/E322veXycivX+8\\/\\/Cp67z1242s\\/OaWlfp18PhQ+xxfl\\/eLkCev7qeBNMpjWPZ5UPscf7v+Kf5SQDFbkFMq9FrNeI54PG3Sv45f4b815RcGoVNEu3xtzb+7fykHj+VH4vr13nnnXfeeef3478DLq4XJpjQHLMAAAAASUVORK5CYII=\",\"qr_image_link\":\"https:\\/\\/storage.googleapis.com\\/corp-richpay_richman_qr_data\\/006\\/LMAJSG-1751351217947-20250701132657-bc0512.png\",\"create_time\":\"2025-07-01T13:26:57.906176+07:00\",\"expire_time\":\"2025-07-01T13:41:57.906176+07:00\"}', '{\"type\":\"DEPOSIT\",\"status\":\"AUTO_SUCCESS\",\"status_desc\":\"DEPOSIT_MATCH\",\"amount\":8032,\"mdr_amount\":108.43,\"txn_ref_id\":\"LMAJSG-1751351217947-20250701132657-bc0512\",\"txn_ref_order_id\":\"TR202507011326574908\",\"txn_ref_bank_code\":\"004\",\"txn_ref_bank_acc_no\":\"1448702118\",\"txn_ref_bank_acc_name_th\":\"K.EAKKACHAI POEMSATI 1 ROOM\",\"txn_ref_bank_acc_name_en\":\"K.EAKKACHAI POEMSATI 1 ROOM\",\"txn_ref_user_id\":null,\"txn_ref1\":null,\"txn_ref2\":null,\"txn_timestamp\":\"2025-07-01T13:26:57.906176+07:00\",\"stm_timestamp\":\"2025-07-01T13:32:30.436627+07:00\",\"stm_bank_code\":\"006\",\"stm_bank_acc_no\":\"6438002332\",\"stm_bank_acc_name\":\"\\u0e1a\\u0e08. \\u0e1e\\u0e38\\u0e17\\u0e18\\u0e34\\u0e1e\\u0e31\\u0e0a\\u0e23 \\u0e04\\u0e2d\\u0e23\\u0e4c\\u0e1b\\u0e2d\\u0e23\\u0e4c\\u0e40\\u0e23\\u0e0a\\u0e31\\u0e48\\u0e19\",\"stm_desc\":\"\\u0e42\\u0e2d\\u0e19\\u0e40\\u0e07\\u0e34\\u0e19\\u0e40\\u0e02\\u0e49\\u0e32\\u0e1e\\u0e23\\u0e49\\u0e2d\\u0e21\\u0e40\\u0e1e\\u0e22\\u0e4c TR fr 004-1448702118 - (6436002332838683) 2025-07-01T13:27:30+07:00\",\"stm_ref_id\":\"KTB-SUCCESS-ONHHVY-1751351550407-20250701133230-da7c07\"}', '1', '1', 'https://storage.googleapis.com/corp-richpay_richman_qr_data/006/LMAJSG-1751351217947-20250701132657-bc0512.png', '147.50.108.8', '2025-07-02 08:52:52', '2025-07-02 08:52:52');

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
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant_name` varchar(255) DEFAULT NULL,
  `merchant_code` varchar(255) DEFAULT NULL,
  `agent_id` varchar(255) DEFAULT NULL,
  `payment_urls` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `merchant_name`, `merchant_code`, `agent_id`, `payment_urls`, `status`, `created_at`, `updated_at`) VALUES
(1, 'FC department', 'FCmerchant001', '1', NULL, '1', '2025-07-02 08:32:14', '2025-07-02 08:32:14'),
(2, 'testmerchant', 'testmerchant005', '1', NULL, '1', '2025-07-02 10:44:37', '2025-07-02 10:44:37');

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
(4, '2025_06_30_105820_create_role_type_users_table', 2),
(5, '2025_07_02_082513_create_merchants_table', 3),
(6, '2025_07_02_082859_create_merchants_table', 4),
(7, '2025_07_02_082949_create_agents_table', 5),
(8, '2025_07_02_083730_create_deposit_transactions_table', 6),
(9, '2025_07_03_040431_create_withdraw_transactions_table', 7),
(10, '2025_07_03_081055_create_qrgeneraters_table', 8);

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
-- Table structure for table `qrgeneraters`
--

CREATE TABLE `qrgeneraters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `qr_img_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qrgeneraters`
--

INSERT INTO `qrgeneraters` (`id`, `customer_name`, `amount`, `invoice_number`, `qr_img_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'fdghf', '444', 'cfgfc54', 'http://127.0.0.1:8000/fc/r2pdeposit/NDQ0/Y2ZnZmM1NA==/ZmRnaGY=', 1, '2025-07-03 02:47:25', '2025-07-03 02:47:25'),
(2, 'dfgf', '4543', 'fcgdr34', 'http://127.0.0.1:8000/fc/r2pdeposit/NDU0Mw==/ZmNnZHIzNA==/ZGZnZg==', 1, '2025-07-03 02:48:18', '2025-07-03 02:48:18'),
(3, 'dfgfdg', '54646', 'bfcg', 'http://127.0.0.1:8000/fc/r2pdeposit/NTQ2NDY=/YmZjZw==/ZGZnZmRn', 1, '2025-07-03 02:49:10', '2025-07-03 02:49:10'),
(4, 'dfgfdg', '54646', 'bfcg', 'http://127.0.0.1:8000/fc/r2pdeposit/NTQ2NDY=/YmZjZw==/ZGZnZmRn', 1, '2025-07-03 02:49:35', '2025-07-03 02:49:35'),
(5, 'dfgfdg', '54646', 'bfcg', 'http://127.0.0.1:8000/fc/r2pdeposit/NTQ2NDY=/YmZjZw==/ZGZnZmRn', 1, '2025-07-03 02:49:38', '2025-07-03 02:49:38'),
(6, 'dfgfdg', '54646', 'bfcg', 'http://127.0.0.1:8000/fc/r2pdeposit/NTQ2NDY=/YmZjZw==/ZGZnZmRn', 1, '2025-07-03 02:57:07', '2025-07-03 02:57:07'),
(7, 'dgopal', '34234', 'fhfh', 'http://127.0.0.1:8000/fc/r2pdeposit/MzQyMzQ=/ZmhmaA==/ZGdvcGFs', 1, '2025-07-03 02:57:33', '2025-07-03 02:57:33'),
(8, 'gdfgh', '43', '453453', 'http://127.0.0.1:8000/fc/r2pdeposit/NDM=/NDUzNDUz/Z2RmZ2g=', 1, '2025-07-03 02:59:47', '2025-07-03 02:59:47'),
(9, 'gffdgh', '43534', 'thfh', 'http://127.0.0.1:8000/fc/r2pdeposit/NDM1MzQ=/dGhmaA==/Z2ZmZGdo', 1, '2025-07-03 03:01:40', '2025-07-03 03:01:40'),
(10, 'fgdfd', '5454', 'fdgdfgb65', 'http://127.0.0.1:8000/fc/r2pdeposit/NTQ1NA==/ZmRnZGZnYjY1/ZmdkZmQ=', 1, '2025-07-03 04:47:59', '2025-07-03 04:47:59'),
(11, 'gggg', '333', 'gchfghf', 'http://127.0.0.1:8000/fc/r2pdeposit/MzMz/Z2NoZmdoZg==/Z2dnZw==', 1, '2025-07-03 21:14:36', '2025-07-03 21:14:36'),
(12, 'Gopal', '2000', 'cgdfg45fg', 'http://127.0.0.1:8000/fc/r2pdeposit/MjAwMA==/Y2dkZmc0NWZn/R29wYWw=', 1, '2025-07-04 00:11:08', '2025-07-04 00:11:08'),
(13, 'Khun  mon', '9999', 'jnhfgd7jd-jhfs', 'http://127.0.0.1:8000/fc/r2pdeposit/OTk5OQ==/am5oZmdkN2pkLWpoZnM=/S2h1biAgbW9u', 1, '2025-07-04 00:37:31', '2025-07-04 00:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_type_users`
--

CREATE TABLE `role_type_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_type_users`
--

INSERT INTO `role_type_users` (`id`, `role_type`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', NULL, NULL),
(2, 'Admin', NULL, NULL),
(3, 'Agent', NULL, NULL),
(4, 'Merchant', NULL, NULL);

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
('KvVWhcpYzDTIyd0bLSVvWvLmN0iq6rIo0Izps1AW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmJyYWhPMGVKRUVNdEw1Y1ZJeTRvS1lYamJBek84blJRRlJ6b1NrTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYy9yMnBkZXBvc2l0L09UazVPUT09L2FtNW9abWRrTjJwa0xXcG9abk09L1MyaDFiaUFnYlc5dSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751614653),
('yHu4E58INRwlaoUBq9RWNJPOAWHwWlNtYVXXjne6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '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', 1751613924);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `mobile_number`, `email`, `avatar`, `merchant_id`, `agent_id`, `status`, `role_id`, `role_name`, `url`, `email_verified_at`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'adminGtech855', '9876543211', 'adminGtech855@gmail.com', NULL, NULL, NULL, 'active', 1, 'Admin', NULL, NULL, 'cGFzc3dvcmQ=', NULL, NULL, '2025-07-01 06:47:19', '2025-07-01 06:47:19'),
(2, 'FC department', 'FCmerchant001', '9876543299', 'fcmerchant@gmail.com', NULL, 1, 1, 'active', 4, 'Merchant', NULL, NULL, 'cGFzc3dvcmQ=', NULL, NULL, '2025-07-01 06:47:19', '2025-07-01 06:47:19'),
(3, 'test', 'testmerchant005', NULL, NULL, NULL, 2, 1, NULL, 4, 'Merchant', NULL, NULL, 'cGFzc3dvcmQ=', NULL, NULL, '2025-07-02 10:43:18', '2025-07-02 10:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_transactions`
--

CREATE TABLE `withdraw_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gateway_TransId` varchar(255) DEFAULT NULL,
  `systemgenerated_TransId` varchar(255) DEFAULT NULL,
  `reference_id` varchar(255) DEFAULT NULL,
  `gateway_name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `callback_url` longtext DEFAULT NULL,
  `Currency` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `net_amount` varchar(255) DEFAULT NULL,
  `mdr_fee_amount` varchar(255) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `merchant_code` varchar(255) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `payment_channel` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `api_response` longtext DEFAULT NULL,
  `customer_bank_name` varchar(255) DEFAULT NULL,
  `bank_code` varchar(255) DEFAULT NULL,
  `customer_account_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdraw_transactions`
--

INSERT INTO `withdraw_transactions` (`id`, `gateway_TransId`, `systemgenerated_TransId`, `reference_id`, `gateway_name`, `customer_name`, `callback_url`, `Currency`, `total`, `net_amount`, `mdr_fee_amount`, `merchant_id`, `merchant_code`, `agent_id`, `product_id`, `payment_channel`, `payment_method`, `message`, `api_response`, `customer_bank_name`, `bank_code`, `customer_account_number`, `status`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'XRYFPV-1745907683586-20250429132123-26f3ed', 'TR202504291321237890', 'GZTRN1745907682B3M', 'RichPay', 'gopal', 'https://payment.implogix.com/api/r2p/payout/callbackURL', 'THB', '1000', '1010', '10', 1, 'FCmerchant001', 1, '28', '19', 'QR Payment', 'processing', '{\"type\":\"WITHDRAW\",\"status\":\"FAILED\",\"status_desc\":\"EXCEPTION\",\"amount\":1000,\"mdr_amount\":0,\"txn_ref_id\":\"XRYFPV-1745907683586-20250429132123-26f3ed\",\"txn_ref_order_id\":\"TR202504291321237890\",\"txn_ref_bank_code\":\"014\",\"txn_ref_bank_acc_no\":\"4681279393\",\"txn_ref_bank_acc_name_th\":\"\\u0e1a\\u0e23\\u0e34\\u0e29\\u0e31\\u0e17 \\u0e40\\u0e2d\\u0e47\\u0e21\\u0e41\\u0e2d\\u0e19\\u0e14\\u0e4c\\u0e0a\\u0e31\\u0e22 \\u0e2d\\u0e34\\u0e21-\\u0e40\\u0e2d\\u0e4a\\u0e01\\u0e0b\\u0e4c \\u0e01\\u0e39\\u0e4a\\u0e14 \\u0e01\\u0e23\\u0e38\\u0e4a\\u0e1b \\u0e08\\u0e33\\u0e01\\u0e31\\u0e14\",\"txn_ref_bank_acc_name_en\":\"\\u0e1a\\u0e23\\u0e34\\u0e29\\u0e31\\u0e17 \\u0e40\\u0e2d\\u0e47\\u0e21\\u0e41\\u0e2d\\u0e19\\u0e14\\u0e4c\\u0e0a\\u0e31\\u0e22 \\u0e2d\\u0e34\\u0e21-\\u0e40\\u0e2d\\u0e4a\\u0e01\\u0e0b\\u0e4c \\u0e01\\u0e39\\u0e4a\\u0e14 \\u0e01\\u0e23\\u0e38\\u0e4a\\u0e1b \\u0e08\\u0e33\\u0e01\\u0e31\\u0e14\",\"txn_ref_user_id\":null,\"txn_ref1\":null,\"txn_ref2\":null,\"txn_timestamp\":\"2025-04-29T13:21:23.586691+07:00\",\"stm_timestamp\":\"1970-01-01T07:00:00+07:00\",\"stm_bank_code\":\"KTB\",\"stm_bank_acc_no\":\"1234567890\",\"stm_bank_acc_name\":\"gopal\",\"stm_desc\":\"Exception(\'\\u0e01\\u0e23\\u0e38\\u0e13\\u0e32\\u0e42\\u0e2b\\u0e25\\u0e14\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e19\\u0e35\\u0e49\\u0e2d\\u0e35\\u0e01\\u0e04\\u0e23\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e49\\u0e27\\u0e25\\u0e2d\\u0e07\\u0e43\\u0e2b\\u0e21\\u0e48\')\",\"stm_ref_id\":null}', 'gopal', 'KTB', '1234567890', 'success', '103.146.44.34', '2025-07-03 04:27:25', '2025-07-03 04:27:25'),
(2, 'XRYFPV-1745907683586-20250429132123-26f3ed', 'TR202504291321237890', 'GZTRN1745907682B3M', 'RichPay', 'gopal', 'https://payment.implogix.com/api/r2p/payout/callbackURL', 'THB', '1000', '1010', '10', 1, 'FCmerchant001', 1, '28', '19', 'QR Payment', 'processing', '{\"type\":\"WITHDRAW\",\"status\":\"FAILED\",\"status_desc\":\"EXCEPTION\",\"amount\":1000,\"mdr_amount\":0,\"txn_ref_id\":\"XRYFPV-1745907683586-20250429132123-26f3ed\",\"txn_ref_order_id\":\"TR202504291321237890\",\"txn_ref_bank_code\":\"014\",\"txn_ref_bank_acc_no\":\"4681279393\",\"txn_ref_bank_acc_name_th\":\"\\u0e1a\\u0e23\\u0e34\\u0e29\\u0e31\\u0e17 \\u0e40\\u0e2d\\u0e47\\u0e21\\u0e41\\u0e2d\\u0e19\\u0e14\\u0e4c\\u0e0a\\u0e31\\u0e22 \\u0e2d\\u0e34\\u0e21-\\u0e40\\u0e2d\\u0e4a\\u0e01\\u0e0b\\u0e4c \\u0e01\\u0e39\\u0e4a\\u0e14 \\u0e01\\u0e23\\u0e38\\u0e4a\\u0e1b \\u0e08\\u0e33\\u0e01\\u0e31\\u0e14\",\"txn_ref_bank_acc_name_en\":\"\\u0e1a\\u0e23\\u0e34\\u0e29\\u0e31\\u0e17 \\u0e40\\u0e2d\\u0e47\\u0e21\\u0e41\\u0e2d\\u0e19\\u0e14\\u0e4c\\u0e0a\\u0e31\\u0e22 \\u0e2d\\u0e34\\u0e21-\\u0e40\\u0e2d\\u0e4a\\u0e01\\u0e0b\\u0e4c \\u0e01\\u0e39\\u0e4a\\u0e14 \\u0e01\\u0e23\\u0e38\\u0e4a\\u0e1b \\u0e08\\u0e33\\u0e01\\u0e31\\u0e14\",\"txn_ref_user_id\":null,\"txn_ref1\":null,\"txn_ref2\":null,\"txn_timestamp\":\"2025-04-29T13:21:23.586691+07:00\",\"stm_timestamp\":\"1970-01-01T07:00:00+07:00\",\"stm_bank_code\":\"KTB\",\"stm_bank_acc_no\":\"1234567890\",\"stm_bank_acc_name\":\"gopal\",\"stm_desc\":\"Exception(\'\\u0e01\\u0e23\\u0e38\\u0e13\\u0e32\\u0e42\\u0e2b\\u0e25\\u0e14\\u0e2b\\u0e19\\u0e49\\u0e32\\u0e19\\u0e35\\u0e49\\u0e2d\\u0e35\\u0e01\\u0e04\\u0e23\\u0e31\\u0e49\\u0e07\\u0e41\\u0e25\\u0e49\\u0e27\\u0e25\\u0e2d\\u0e07\\u0e43\\u0e2b\\u0e21\\u0e48\')\",\"stm_ref_id\":null}', 'gopal', 'KTB', '1234567890', 'success', '103.146.44.34', '2025-07-03 04:27:25', '2025-07-03 04:27:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `deposit_transactions`
--
ALTER TABLE `deposit_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `qrgeneraters`
--
ALTER TABLE `qrgeneraters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_type_users`
--
ALTER TABLE `role_type_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_transactions`
--
ALTER TABLE `withdraw_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit_transactions`
--
ALTER TABLE `deposit_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `qrgeneraters`
--
ALTER TABLE `qrgeneraters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `role_type_users`
--
ALTER TABLE `role_type_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdraw_transactions`
--
ALTER TABLE `withdraw_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
