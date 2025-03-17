/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 80300 (8.3.0)
 Source Host           : localhost:3306
 Source Schema         : ql_ns

 Target Server Type    : MySQL
 Target Server Version : 80300 (8.3.0)
 File Encoding         : 65001

 Date: 18/03/2025 00:29:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int NOT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES (1, 'percent_face_detect', '0.2', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (2, 'password_default', '1234567@8', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (3, 'break_time', '90', 0, NULL, '0000-00-00 00:00:00', NULL);

-- ----------------------------
-- Table structure for departments
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manager_id` bigint NULL DEFAULT NULL,
  `founding_at` date NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of departments
-- ----------------------------
INSERT INTO `departments` VALUES (1, 'Nhóm Dev', NULL, 0, 1, '2025-03-16 22:25:46', '2025-03-16 16:58:32', 1, '2025-03-16', '2', 'demoadmin.qlns@yopmail.com', NULL);
INSERT INTO `departments` VALUES (2, 'Phòng kinh doanh', NULL, 0, 1, '2025-03-16 22:25:46', '2025-03-16 16:54:02', 2, '2025-03-12', '1', 'demoadmin.qlns@yopmail.com', NULL);
INSERT INTO `departments` VALUES (3, 'Trần Văn Hoàn', NULL, 1, NULL, '2025-03-16 16:56:51', '2025-03-16 16:56:51', 1, '2025-03-11', '1', 'sgskdfm@yopmail.com', '0348053999');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
INSERT INTO `password_reset_tokens` VALUES ('sgskdfm@yopmail.com', '$2y$12$/Lx35kRK4aY1j29V/jdPPOkuYuOxdefJZM/y/KScrV7lEIVaS2F2K', '2025-03-16 11:46:17');
INSERT INTO `password_reset_tokens` VALUES ('demoadmin.qln222s@yopmail.com', '$2y$12$tVwNl7sBOJamVolwTTp71OviHhixU4eUJZKyK7KDzDokGEb6t5TYy', '2025-03-16 11:41:47');
INSERT INTO `password_reset_tokens` VALUES ('tranhoan.dz98@gmail.com', '$2y$12$ZO6H2eCEimoXQQdZVllTtu1OHIeNfv05xDasDCD9GYUioArYp/ZK6', '2025-03-16 11:54:56');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` int NULL DEFAULT NULL COMMENT '1:admin, 2:đại lý',
  `parent` int NULL DEFAULT NULL,
  `parent_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 501 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 'role_list', NULL, 1, 1, '2025-03-05 21:29:44', '2019-03-13 02:26:49', 'Danh sách vai trò', 2, 1, 'Quản lý vai trò');
INSERT INTO `permission` VALUES (2, 'role_create', NULL, 1, 1, '2025-03-05 21:28:08', '2019-03-19 03:50:42', 'Thêm mới vai trò', 2, 1, 'Quản lý vai trò');
INSERT INTO `permission` VALUES (3, 'role_update', NULL, 1, 1, '2025-03-05 21:28:20', '2019-03-13 02:26:49', 'Cập nhật vai trò', 2, 1, 'Quản lý vai trò');
INSERT INTO `permission` VALUES (4, 'role_delete', NULL, 1, 1, '2025-03-05 21:28:33', '2019-03-13 02:26:49', 'Xoá vai trò', 2, 1, 'Quản lý vai trò');
INSERT INTO `permission` VALUES (5, 'role_view', NULL, 1, 1, '2025-03-05 21:28:34', '2019-03-13 02:26:49', 'Xem vai trò', 2, 1, 'Quản lý vai trò');
INSERT INTO `permission` VALUES (6, 'user_list', NULL, 1, 1, '2025-03-05 21:29:50', '2019-03-13 02:26:49', 'Danh sách người dùng', 2, 2, 'Quản lý người dùng');
INSERT INTO `permission` VALUES (7, 'user_create', NULL, 1, 1, '2025-03-05 21:29:01', '2019-03-13 02:26:49', 'Thêm mới người dùng', 2, 2, 'Quản lý người dùng');
INSERT INTO `permission` VALUES (8, 'user_update', NULL, 1, 1, '2025-03-05 21:29:00', '2019-03-13 02:26:49', 'Cập nhật người dùng', 2, 2, 'Quản lý người dùng');
INSERT INTO `permission` VALUES (9, 'user_view', NULL, 1, 1, '2025-03-05 21:28:58', '2019-03-13 02:26:49', 'Xem người dùng', 2, 2, 'Quản lý người dùng');
INSERT INTO `permission` VALUES (10, 'user_delete', NULL, 1, 1, '2025-03-05 21:29:08', '2019-03-13 02:26:49', 'Xoá người dùng', 2, 2, 'Quản lý người dùng');

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of position
-- ----------------------------
INSERT INTO `position` VALUES (1, 'Nhân viên dev', 'đây là nhân viên dev', 1, 1, '2025-03-16 07:44:52', '2025-03-16 07:44:52');

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission`  (
  `permission_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES (1, 1);
INSERT INTO `role_permission` VALUES (2, 1);
INSERT INTO `role_permission` VALUES (3, 1);
INSERT INTO `role_permission` VALUES (4, 1);
INSERT INTO `role_permission` VALUES (5, 1);
INSERT INTO `role_permission` VALUES (6, 1);
INSERT INTO `role_permission` VALUES (7, 1);
INSERT INTO `role_permission` VALUES (8, 1);
INSERT INTO `role_permission` VALUES (9, 1);
INSERT INTO `role_permission` VALUES (10, 1);
INSERT INTO `role_permission` VALUES (6, 2);
INSERT INTO `role_permission` VALUES (7, 2);
INSERT INTO `role_permission` VALUES (8, 2);
INSERT INTO `role_permission` VALUES (9, 2);
INSERT INTO `role_permission` VALUES (10, 2);
INSERT INTO `role_permission` VALUES (1, 3);
INSERT INTO `role_permission` VALUES (2, 3);
INSERT INTO `role_permission` VALUES (3, 3);
INSERT INTO `role_permission` VALUES (4, 3);
INSERT INTO `role_permission` VALUES (5, 3);
INSERT INTO `role_permission` VALUES (1, 4);
INSERT INTO `role_permission` VALUES (2, 4);
INSERT INTO `role_permission` VALUES (3, 4);
INSERT INTO `role_permission` VALUES (4, 4);
INSERT INTO `role_permission` VALUES (5, 4);
INSERT INTO `role_permission` VALUES (1, 5);
INSERT INTO `role_permission` VALUES (2, 5);
INSERT INTO `role_permission` VALUES (3, 5);
INSERT INTO `role_permission` VALUES (4, 5);
INSERT INTO `role_permission` VALUES (5, 5);
INSERT INTO `role_permission` VALUES (6, 6);
INSERT INTO `role_permission` VALUES (7, 6);
INSERT INTO `role_permission` VALUES (8, 6);
INSERT INTO `role_permission` VALUES (9, 6);
INSERT INTO `role_permission` VALUES (10, 6);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` int NOT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin', NULL, 1, NULL, '2025-03-16 03:55:49', '2025-03-16 03:55:49');
INSERT INTO `roles` VALUES (5, 'ádasdsd', NULL, 1, NULL, '2025-03-16 17:27:34', '2025-03-16 17:27:34');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('GEmLSEKdbLsJFQRxhOQKcYtMAivhi2BnQdHmA2yx', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUHg5NlRKTnUxZUdSdEpTVVROUVJWbEFLMzVDa3U3ZkNwODE4d2s3ZyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vbG9jYWxob3N0L3FsLW5zL3B1YmxpYy9jaGFtLWNvbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6ImxvY2FsZSI7czoyOiJlbiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1742232519);

-- ----------------------------
-- Table structure for time_keepings
-- ----------------------------
DROP TABLE IF EXISTS `time_keepings`;
CREATE TABLE `time_keepings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `checkin` timestamp NOT NULL,
  `checkout` timestamp NULL DEFAULT NULL,
  `work_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `num_work_date` float NULL DEFAULT NULL,
  `work_late` float NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of time_keepings
-- ----------------------------
INSERT INTO `time_keepings` VALUES (1, 1, 1, 1, '2025-03-17 14:53:07', '2025-03-17 22:55:50', '2025-03-16 08:05:07', '2025-03-16 22:55:50', '13:20', 1, 5.12);
INSERT INTO `time_keepings` VALUES (2, 1, 1, 1, '2025-03-17 14:53:07', '2025-03-17 22:55:50', '2025-03-17 08:05:07', '2025-03-17 22:55:50', '13:20', 1, 5.12);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'mã nhân viên',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `face_descriptor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'thông tin kiểm tra faceid',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'số điện thoại',
  `position_id` bigint NULL DEFAULT NULL COMMENT 'chức vụ',
  `department_id` bigint NULL DEFAULT NULL COMMENT 'phòng ban',
  `manager_id` bigint NULL DEFAULT NULL COMMENT 'người quản lý',
  `role_id` bigint NULL DEFAULT NULL COMMENT 'vai trò',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'trạng thái\r\n(object) [\r\n                \"id\" => 1,\r\n                \"name\" => \'Đang làm việc\',\r\n            ],\r\n            (object)[\r\n                \"id\" => 2,\r\n                \"name\" => \'Hợp đồng đã chấm dứt\',\r\n            ],\r\n            (object)[\r\n                \"id\" => 3,\r\n                \"name\" => \'Tạm nghỉ\',\r\n            ],\r\n            (object)[\r\n                \"id\" => 4,\r\n                \"name\" => \'Thai sản\',\r\n            ],',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '(object)[\r\n                \"id\" => 1,\r\n                \"name\" => \'Admin\',\r\n            ],\r\n            (object)[\r\n                \"id\" => 2,\r\n                \"name\" => \'Cán bộ quản lý\',\r\n            ],\r\n            (object)[\r\n                \"id\" => 3,\r\n                \"name\" => \'Nhân viên\',\r\n            ]',
  `start_date` date NULL DEFAULT NULL COMMENT 'ngày bắt đầu làm việc',
  `work_time` time NULL DEFAULT NULL COMMENT 'Giờ làm việc',
  `identifier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'mã định danh',
  `person_tax_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'mã số thuế cá nhân',
  `date_of_issue` date NULL DEFAULT NULL COMMENT 'ngày cấp',
  `place_of_issue` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'nơi cấp',
  `date_of_birth` date NULL DEFAULT NULL COMMENT 'ngày sinh',
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Giới tính',
  `nationality` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Quốc tịch',
  `nation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Dân tộc',
  `current_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Địa chỉ hiện tại',
  `permanent_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Địa chỉ thường chú',
  `bank_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'tài khoản ngân hàng',
  `bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'ngân hàng',
  `bank_branch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'chi nhánh',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'CB213123', 'Trần Văn Hoàn', 'demoadmin.qlns@yopmail.com', NULL, '$2y$12$zbgMeFF3gB.k1W/f2p.NfuCdj8Df9ygcRiy02UZHuNhA1L8zQHvQi', 'uploads/WaZSpQ4w2Evi5KDXBxYIAa1l0Tu2SkcpNi7zHZFC.jpg', '[-0.12814876437187195,0.0935138463973999,-0.08937826007604599,-0.10347762703895569,-0.010279590263962746,-0.054726313799619675,-0.02800777554512024,-0.10420779883861542,0.1444721668958664,-0.015636160969734192,0.19856955111026764,-0.08244500309228897,-0.23686793446540833,-0.10188180208206177,-0.05891311913728714,0.20911867916584015,-0.26292741298675537,-0.17445598542690277,-0.059058018028736115,-0.021227868273854256,0.08412440121173859,-0.04095335677266121,-0.012882768176496029,0.11914993822574615,-0.08058375120162964,-0.3013167083263397,-0.10710937529802322,-0.0815734788775444,0.026697257533669472,-0.02225305140018463,0.007631676737219095,0.02784879505634308,-0.22703328728675842,-0.07657166570425034,0.05489426106214523,0.06641872972249985,-0.00764074781909585,-0.04946218803524971,0.20566526055335999,-0.03405815735459328,-0.1508273184299469,0.05869114026427269,0.10957064479589462,0.2847745716571808,0.1616836041212082,0.10268144309520721,-0.015184891410171986,-0.11220379173755646,0.049540016800165176,-0.1746833324432373,0.053799182176589966,0.17330524325370789,0.08792047202587128,0.09574289619922638,-0.02018085867166519,-0.11857958883047104,0.06647975742816925,0.09646983444690704,-0.17485593259334564,0.003483337350189686,0.06963484734296799,-0.04254002124071121,-0.002852505538612604,-0.08758619427680969,0.2808099091053009,0.06337922066450119,-0.1511719524860382,-0.1857268363237381,0.12711767852306366,-0.13241805136203766,-0.10908733308315277,0.0003617046168074012,-0.13933371007442474,-0.14504513144493103,-0.37428855895996094,0.05424874275922775,0.3670952320098877,0.09154132008552551,-0.1614442765712738,0.10180400311946869,-0.039695754647254944,-0.020691214129328728,0.11774706840515137,0.08692273497581482,-0.08065634220838547,-0.038993723690509796,-0.10317952185869217,0.003543234197422862,0.21796604990959167,-0.01914377696812153,-0.06693733483552933,0.15964561700820923,-0.00811802688986063,0.04638877511024475,0.013922828249633312,0.06107645481824875,-0.0356876477599144,0.04248714819550514,-0.13604113459587097,0.047491684556007385,0.036911167204380035,0.0188563484698534,-0.0019460208714008331,0.15201815962791443,-0.09273508936166763,0.05250556021928787,0.03492163494229317,0.0032521092798560858,-0.03573383018374443,0.0981329157948494,-0.1777881234884262,-0.11986203491687775,0.08308222889900208,-0.242197185754776,0.25366172194480896,0.1842600256204605,0.08486297726631165,0.05194833502173424,0.12429334223270416,0.0877145528793335,-0.005343571770936251,0.035291723906993866,-0.2085132747888565,-0.03413189947605133,0.14544308185577393,0.01735122874379158,0.12173832207918167,0.053928159177303314]', NULL, '2025-03-01 16:58:24', '2025-03-16 15:08:55', 0, 1, NULL, 2, 2, NULL, 1, '1', '1', NULL, '08:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, 'CBNV815021', 'Trần Văn Hoàn', 'sgskdfm@yopmail.com', NULL, '$2y$12$H194eD7p5Bw4smzNjT9hEuXHa6DyJafay0aUUyabrOaZtQMRYdnFe', NULL, NULL, NULL, '2025-03-16 16:04:59', '2025-03-16 16:49:52', 1, 1, '0348053999', 1, 1, 1, 1, '1', '1', '2025-05-07', '08:00:00', '123123123', '345435', '2025-05-15', NULL, '2025-05-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
