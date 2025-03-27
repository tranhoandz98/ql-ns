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

 Date: 28/03/2025 00:20:35
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
INSERT INTO `cache` VALUES ('quan_ly_nhan_su_cache_sgskdfm@yopmail.com|::1:timer', 'i:1742828130;', 1742828130);
INSERT INTO `cache` VALUES ('quan_ly_nhan_su_cache_sgskdfm@yopmail.com|::1', 'i:1;', 1742828130);

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
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES (1, 'percent_face_detect', '0.2', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (2, 'password_default', '1234567@8', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (3, 'break_time', '90', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (4, 'day_off_default', '12', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (5, 'default_lunch_money', '30000', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (6, 'union_dues', '50000', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (7, 'bhxh_percent', '0.08', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (8, 'bhyt_percent', '0.015', 0, NULL, '0000-00-00 00:00:00', NULL);
INSERT INTO `config` VALUES (9, 'bhtn_percent', '0.01', 0, NULL, '0000-00-00 00:00:00', NULL);

-- ----------------------------
-- Table structure for day_offs
-- ----------------------------
DROP TABLE IF EXISTS `day_offs`;
CREATE TABLE `day_offs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `half_day` int NULL DEFAULT NULL,
  `num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `handover_recipient` int NULL DEFAULT NULL,
  `handover_date` date NULL DEFAULT NULL,
  `session` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of day_offs
-- ----------------------------
INSERT INTO `day_offs` VALUES (9, 'OFF277679', 1, NULL, '2025-03-25 23:12:18', '2025-03-25 23:12:18', 1, 'on_leave', '2025-03-27 08:00:00', '2025-03-27 12:00:00', 1, '0.5', 'DRAFT', NULL, NULL, NULL, 'morning');
INSERT INTO `day_offs` VALUES (8, 'OFF641794', 1, 1, '2025-03-23 18:31:36', '2025-03-23 18:42:03', 1, 'on_leave', '2025-03-25 08:00:00', '2025-03-25 17:30:00', NULL, '1', 'DONE', NULL, NULL, NULL, 'morning');

-- ----------------------------
-- Table structure for day_offs_user
-- ----------------------------
DROP TABLE IF EXISTS `day_offs_user`;
CREATE TABLE `day_offs_user`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `num` float NULL DEFAULT NULL,
  `remaining_leave` float NULL DEFAULT NULL,
  `start_at` date NULL DEFAULT NULL,
  `end_at` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of day_offs_user
-- ----------------------------
INSERT INTO `day_offs_user` VALUES (1, 1, 1, '2025-03-23 15:59:35', '2025-03-25 23:12:18', 1, 12, 10.5, '2025-03-23', NULL);
INSERT INTO `day_offs_user` VALUES (2, 1, NULL, '2025-03-23 19:06:23', '2025-03-23 19:06:23', 2, 12, 12, '2025-01-01', '2025-12-31');

-- ----------------------------
-- Table structure for departments
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
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
-- Table structure for kpi
-- ----------------------------
DROP TABLE IF EXISTS `kpi`;
CREATE TABLE `kpi`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `num` float NULL DEFAULT NULL,
  `start_at` date NULL DEFAULT NULL,
  `end_at` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kpi
-- ----------------------------
INSERT INTO `kpi` VALUES (2, 'KPI055837', 1, 1, '2025-03-24 00:38:34', '2025-03-24 00:55:02', 'WAIT_MANAGER', 1, NULL, 'kpi thang 3', NULL, 100, '2025-03-01', '2025-03-31');

-- ----------------------------
-- Table structure for kpi_details
-- ----------------------------
DROP TABLE IF EXISTS `kpi_details`;
CREATE TABLE `kpi_details`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kpi_id` int NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ratio` float NULL DEFAULT NULL,
  `target` float NULL DEFAULT NULL,
  `staff_evaluation` float NULL DEFAULT NULL,
  `assessment_manager` float NULL DEFAULT NULL,
  `manager_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kpi_details
-- ----------------------------
INSERT INTO `kpi_details` VALUES (1, 1, NULL, '2025-03-24 00:09:13', '2025-03-24 00:09:13', 1, 'muc tieu 1', 5, 100, 5, 5, 'y kien vv');
INSERT INTO `kpi_details` VALUES (2, 1, NULL, '2025-03-24 00:09:13', '2025-03-24 00:09:13', 1, 'muc tieu 2', 10, 100, 10, 10, 'y kien 2');
INSERT INTO `kpi_details` VALUES (3, 1, NULL, '2025-03-24 00:38:34', '2025-03-24 00:38:34', 2, 'muc tieu 1', 50, NULL, 40, 40, NULL);
INSERT INTO `kpi_details` VALUES (4, 1, NULL, '2025-03-24 00:38:34', '2025-03-24 00:38:34', 2, 'muc tieu 2', 50, NULL, 60, 60, NULL);

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
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint NULL DEFAULT NULL,
  `is_read` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES (2, 'Yêu cầu tăng ca mới', 'Bạn có một yêu cầu tăng ca mới cần duyệt từ Trần Văn Hoàn (Mã: OT835326)', 1, 1, '2025-03-22 20:43:40', '2025-03-23 13:20:22', 1, 'UNREAD', 'http://localhost/ql-ns/public/overtimes/6', 'overtime_approval', 'danger');
INSERT INTO `notifications` VALUES (3, 'Yêu cầu tăng ca đã được duyệt', 'Yêu cầu tăng ca của bạn đã được duyệt (Mã: OT835326)', 1, 1, '2025-03-23 00:32:51', '2025-03-23 13:26:54', 1, 'READ', 'http://localhost/ql-ns/public/overtimes/6', 'overtime_approval', 'success');
INSERT INTO `notifications` VALUES (6, 'Yêu cầu ngày nghỉ đã được duyệt', 'Yêu cầu ngày nghỉ của bạn đã được duyệt (Mã: OFF641794)', 1, 1, '2025-03-23 18:42:03', '2025-03-23 18:45:47', 1, 'READ', 'http://localhost/ql-ns/public/day_offs/8', 'day_off', 'success');
INSERT INTO `notifications` VALUES (5, 'Yêu cầu ngày nghỉ', 'Bạn có một yêu cầu ngày nghỉ cần duyệt từ Trần Văn Hoàn (Mã: OFF641794)', 1, 1, '2025-03-23 18:41:45', '2025-03-23 18:41:56', 1, 'READ', 'http://localhost/ql-ns/public/day_offs/8', 'day_off', 'warning');
INSERT INTO `notifications` VALUES (7, 'Yêu cầu ngày nghỉ', 'Bạn có một yêu cầu ngày nghỉ cần duyệt từ Trần Văn Hoàn (Mã: KPI055837)', 1, NULL, '2025-03-24 00:55:02', '2025-03-24 00:55:02', 1, 'UNREAD', 'http://localhost/ql-ns/public/kpi/2', 'day_off', 'warning');

-- ----------------------------
-- Table structure for overtimes
-- ----------------------------
DROP TABLE IF EXISTS `overtimes`;
CREATE TABLE `overtimes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint NULL DEFAULT NULL COMMENT 'id nhân viên',
  `expected_start` timestamp NULL DEFAULT NULL COMMENT 'bắt đầu dự kiến',
  `expected_end` timestamp NULL DEFAULT NULL COMMENT 'kết thúc dự kiến',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'case DAY_OF_THE_WEEK = \'DAY_OF_THE_WEEK\';\r\n    case DAY_OFF = \'DAY_OFF\';\r\n    case HOLIDAY = \'HOLIDAY\';',
  `actual_start` timestamp NULL DEFAULT NULL COMMENT 'bắt đầu thực tế',
  `actual_end` timestamp NULL DEFAULT NULL COMMENT 'kết thúc thực tế',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'nội dung công việc',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'trạng thái',
  `work_results` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'kết quả làm việc',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'ghi chú',
  `expected_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `actual_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of overtimes
-- ----------------------------
INSERT INTO `overtimes` VALUES (1, 'OT1212', 0, 1, '2025-03-16 22:25:46', '2025-03-23 00:41:06', 1, '2025-03-16 00:00:00', '2025-03-21 23:00:00', 'DAY_OF_THE_WEEK', NULL, NULL, NULL, 'REJECT', NULL, NULL, NULL, NULL);
INSERT INTO `overtimes` VALUES (2, 'OT1', 0, 1, '2025-03-16 22:25:46', '2025-03-16 16:54:02', 2, '2025-03-12 00:00:00', '2025-03-21 23:00:00', 'DAY_OF_THE_WEEK', NULL, NULL, NULL, 'DONE', NULL, NULL, NULL, NULL);
INSERT INTO `overtimes` VALUES (3, 'OT2', 1, NULL, '2025-03-16 16:56:51', '2025-03-16 16:56:51', 1, '2025-03-11 00:00:00', '2025-03-21 23:00:00', 'DAY_OFF', NULL, NULL, NULL, 'REJECT', NULL, NULL, NULL, NULL);
INSERT INTO `overtimes` VALUES (4, 'OT3', 1, NULL, '2025-03-21 23:45:20', '2025-03-21 23:45:20', 1, '2025-03-21 20:00:00', '2025-03-21 23:00:00', 'HOLIDAY', NULL, NULL, 'nd', 'DRAFT', 'gg', 'vvv', '2', NULL);
INSERT INTO `overtimes` VALUES (5, 'OT964776', 1, 1, '2025-03-22 11:57:32', '2025-03-22 12:03:02', 1, '2025-03-22 16:00:00', '2025-03-22 20:00:00', 'DAY_OF_THE_WEEK', '2025-03-22 16:00:00', '2025-03-22 21:00:00', 'nd', 'DRAFT', 'kq', 'note', '4', NULL);
INSERT INTO `overtimes` VALUES (6, 'OT835326', 1, 1, '2025-03-22 18:24:21', '2025-03-23 12:47:51', 1, '2025-03-22 13:00:00', '2025-03-22 18:00:00', 'DAY_OF_THE_WEEK', '2025-03-22 13:00:00', '2025-03-22 18:00:00', 'noi dung abbbnn\r\nbnkn', 'WAIT_MANAGER', 'kqqq', 'notee', '5', '5');

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
INSERT INTO `permission` VALUES (11, 'position_list', NULL, 1, 1, '2025-03-23 00:48:54', '2019-03-13 02:26:49', 'Danh sách chức vụ', 2, 3, 'Quản lý chức vụ');
INSERT INTO `permission` VALUES (12, 'position_create', NULL, 1, 1, '2025-03-23 00:49:10', '2019-03-13 02:26:49', 'Thêm mới chức vụ', 2, 3, 'Quản lý chức vụ');
INSERT INTO `permission` VALUES (13, 'position_update', NULL, 1, 1, '2025-03-23 00:49:15', '2019-03-13 02:26:49', 'Cập nhật chức vụ', 2, 3, 'Quản lý chức vụ');
INSERT INTO `permission` VALUES (14, 'position_view', NULL, 1, 1, '2025-03-23 00:49:19', '2019-03-13 02:26:49', 'Xem chức vụ', 2, 3, 'Quản lý chức vụ');
INSERT INTO `permission` VALUES (15, 'position_delete', NULL, 1, 1, '2025-03-23 00:49:23', '2019-03-13 02:26:49', 'Xoá chức vụ', 2, 3, 'Quản lý chức vụ');
INSERT INTO `permission` VALUES (16, 'department_list', NULL, 1, 1, '2025-03-23 00:51:09', '2019-03-13 02:26:49', 'Danh sách phòng ban', 2, 4, 'Quản lý phòng ban');
INSERT INTO `permission` VALUES (17, 'department_create', NULL, 1, 1, '2025-03-23 00:51:35', '2019-03-13 02:26:49', 'Thêm mới phòng ban', 2, 4, 'Quản lý phòng ban');
INSERT INTO `permission` VALUES (18, 'department_update', NULL, 1, 1, '2025-03-23 00:51:25', '2019-03-13 02:26:49', 'Cập nhật phòng ban', 2, 4, 'Quản lý phòng ban');
INSERT INTO `permission` VALUES (19, 'department_view', NULL, 1, 1, '2025-03-23 00:51:30', '2019-03-13 02:26:49', 'Xem phòng ban', 2, 4, 'Quản lý phòng ban');
INSERT INTO `permission` VALUES (20, 'department_delete', NULL, 1, 1, '2025-03-23 00:51:34', '2019-03-13 02:26:49', 'Xoá phòng ban', 2, 4, 'Quản lý phòng ban');
INSERT INTO `permission` VALUES (21, 'timekeeping_list', NULL, 1, 1, '2025-03-23 00:54:58', '2019-03-13 02:26:49', 'Danh sách chấm công', 2, 5, 'Quản lý chấm công');
INSERT INTO `permission` VALUES (22, 'timekeeping_create', NULL, 1, 1, '2025-03-23 00:54:58', '2019-03-13 02:26:49', 'Thêm mới chấm công', 2, 5, 'Quản lý chấm công');
INSERT INTO `permission` VALUES (23, 'timekeeping_update', NULL, 1, 1, '2025-03-23 00:54:58', '2019-03-13 02:26:49', 'Cập nhật chấm công', 2, 5, 'Quản lý chấm công');
INSERT INTO `permission` VALUES (24, 'timekeeping_delete', NULL, 1, 1, '2025-03-23 00:54:58', '2019-03-13 02:26:49', 'Xoá chấm công', 2, 5, 'Quản lý chấm công');
INSERT INTO `permission` VALUES (25, 'overtime_list', NULL, 1, 1, '2025-03-23 00:57:29', '2019-03-13 02:26:49', 'Danh sách tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (26, 'overtime_create', NULL, 1, 1, '2025-03-23 00:57:46', '2019-03-13 02:26:49', 'Thêm mới tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (27, 'overtime_update', NULL, 1, 1, '2025-03-23 00:57:53', '2019-03-13 02:26:49', 'Cập nhật tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (28, 'overtime_view', NULL, 1, 1, '2025-03-23 00:58:00', '2019-03-13 02:26:49', 'Xem tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (29, 'overtime_delete', NULL, 1, 1, '2025-03-23 00:58:05', '2019-03-13 02:26:49', 'Xoá tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (30, 'overtime_send', NULL, 1, 1, '2025-03-23 00:58:10', '2019-03-13 02:26:49', 'Gửi tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (31, 'overtime_approve', NULL, 1, 1, '2025-03-23 00:58:20', '2019-03-13 02:26:49', 'Duyệt tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (32, 'overtime_reject', NULL, 1, 1, '2025-03-23 00:58:24', '2019-03-13 02:26:49', 'Từ chối tăng ca', 2, 6, 'Quản lý tăng ca');
INSERT INTO `permission` VALUES (33, 'day_off_list', NULL, 1, 1, '2025-03-23 14:13:42', '2019-03-13 02:26:49', 'Danh sách ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (34, 'day_off_create', NULL, 1, 1, '2025-03-23 14:13:58', '2019-03-13 02:26:49', 'Thêm mới ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (35, 'day_off_update', NULL, 1, 1, '2025-03-23 14:14:02', '2019-03-13 02:26:49', 'Cập nhật ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (36, 'day_off_view', NULL, 1, 1, '2025-03-23 14:14:09', '2019-03-13 02:26:49', 'Xem ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (37, 'day_off_delete', NULL, 1, 1, '2025-03-23 14:14:14', '2019-03-13 02:26:49', 'Xoá ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (38, 'day_off_send', NULL, 1, 1, '2025-03-23 14:14:18', '2019-03-13 02:26:49', 'Gửi ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (39, 'day_off_approve', NULL, 1, 1, '2025-03-23 14:14:23', '2019-03-13 02:26:49', 'Duyệt ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (40, 'day_off_reject', NULL, 1, 1, '2025-03-23 14:14:27', '2019-03-13 02:26:49', 'Từ chối ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (41, 'day_off_allocation', NULL, 1, 1, '2025-03-23 19:01:54', '2019-03-13 02:26:49', 'Cấp phát ngày nghỉ', 2, 7, 'Quản lý ngày nghỉ');
INSERT INTO `permission` VALUES (42, 'kpi_list', NULL, 1, 1, '2025-03-25 00:33:43', '2019-03-13 02:26:49', 'Danh sách KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (43, 'kpi_create', NULL, 1, 1, '2025-03-23 21:18:27', '2019-03-13 02:26:49', 'Thêm mới KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (44, 'kpi_update', NULL, 1, 1, '2025-03-23 21:18:34', '2019-03-13 02:26:49', 'Cập nhật KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (45, 'kpi_view', NULL, 1, 1, '2025-03-23 21:18:41', '2019-03-13 02:26:49', 'Xem KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (46, 'kpi_delete', NULL, 1, 1, '2025-03-23 21:18:47', '2019-03-13 02:26:49', 'Xoá KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (47, 'kpi_send', NULL, 1, 1, '2025-03-23 21:18:54', '2019-03-13 02:26:49', 'Gửi KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (48, 'kpi_approve', NULL, 1, 1, '2025-03-23 21:19:08', '2019-03-13 02:26:49', 'Duyệt KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (49, 'kpi_reject', NULL, 1, 1, '2025-03-23 21:19:15', '2019-03-13 02:26:49', 'Từ chối KPI', 2, 8, 'Quản lý KPI');
INSERT INTO `permission` VALUES (50, 'salary_list', NULL, 1, 1, '2025-03-25 00:33:52', '2019-03-13 02:26:49', 'Danh sách lương', 2, 9, 'Quản lý lương');
INSERT INTO `permission` VALUES (51, 'salary_create', NULL, 1, 1, '2025-03-24 23:47:55', '2019-03-13 02:26:49', 'Thêm mới lương', 2, 9, 'Quản lý lương');
INSERT INTO `permission` VALUES (52, 'salary_update', NULL, 1, 1, '2025-03-24 23:48:03', '2019-03-13 02:26:49', 'Cập nhật lương', 2, 9, 'Quản lý lương');
INSERT INTO `permission` VALUES (53, 'salary_delete', NULL, 1, 1, '2025-03-24 23:48:29', '2019-03-13 02:26:49', 'Xoá lương', 2, 9, 'Quản lý lương');
INSERT INTO `permission` VALUES (54, 'salary_approve', NULL, 1, 1, '2025-03-24 23:48:34', '2019-03-13 02:26:49', 'Duyệt lương', 2, 9, 'Quản lý lương');

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
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
INSERT INTO `role_permission` VALUES (1, 7);
INSERT INTO `role_permission` VALUES (2, 7);
INSERT INTO `role_permission` VALUES (3, 7);
INSERT INTO `role_permission` VALUES (4, 7);
INSERT INTO `role_permission` VALUES (5, 7);
INSERT INTO `role_permission` VALUES (6, 7);
INSERT INTO `role_permission` VALUES (7, 7);
INSERT INTO `role_permission` VALUES (8, 7);
INSERT INTO `role_permission` VALUES (9, 7);
INSERT INTO `role_permission` VALUES (10, 7);
INSERT INTO `role_permission` VALUES (11, 7);
INSERT INTO `role_permission` VALUES (12, 7);
INSERT INTO `role_permission` VALUES (13, 7);
INSERT INTO `role_permission` VALUES (14, 7);
INSERT INTO `role_permission` VALUES (15, 7);
INSERT INTO `role_permission` VALUES (16, 7);
INSERT INTO `role_permission` VALUES (17, 7);
INSERT INTO `role_permission` VALUES (18, 7);
INSERT INTO `role_permission` VALUES (19, 7);
INSERT INTO `role_permission` VALUES (20, 7);
INSERT INTO `role_permission` VALUES (1, 8);
INSERT INTO `role_permission` VALUES (2, 8);
INSERT INTO `role_permission` VALUES (3, 8);
INSERT INTO `role_permission` VALUES (4, 8);
INSERT INTO `role_permission` VALUES (5, 8);
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
INSERT INTO `role_permission` VALUES (11, 1);
INSERT INTO `role_permission` VALUES (12, 1);
INSERT INTO `role_permission` VALUES (13, 1);
INSERT INTO `role_permission` VALUES (14, 1);
INSERT INTO `role_permission` VALUES (15, 1);
INSERT INTO `role_permission` VALUES (16, 1);
INSERT INTO `role_permission` VALUES (17, 1);
INSERT INTO `role_permission` VALUES (18, 1);
INSERT INTO `role_permission` VALUES (19, 1);
INSERT INTO `role_permission` VALUES (20, 1);
INSERT INTO `role_permission` VALUES (21, 1);
INSERT INTO `role_permission` VALUES (22, 1);
INSERT INTO `role_permission` VALUES (23, 1);
INSERT INTO `role_permission` VALUES (24, 1);
INSERT INTO `role_permission` VALUES (25, 1);
INSERT INTO `role_permission` VALUES (26, 1);
INSERT INTO `role_permission` VALUES (27, 1);
INSERT INTO `role_permission` VALUES (28, 1);
INSERT INTO `role_permission` VALUES (29, 1);
INSERT INTO `role_permission` VALUES (30, 1);
INSERT INTO `role_permission` VALUES (31, 1);
INSERT INTO `role_permission` VALUES (32, 1);
INSERT INTO `role_permission` VALUES (33, 1);
INSERT INTO `role_permission` VALUES (34, 1);
INSERT INTO `role_permission` VALUES (35, 1);
INSERT INTO `role_permission` VALUES (36, 1);
INSERT INTO `role_permission` VALUES (37, 1);
INSERT INTO `role_permission` VALUES (38, 1);
INSERT INTO `role_permission` VALUES (39, 1);
INSERT INTO `role_permission` VALUES (40, 1);
INSERT INTO `role_permission` VALUES (41, 1);
INSERT INTO `role_permission` VALUES (42, 1);
INSERT INTO `role_permission` VALUES (43, 1);
INSERT INTO `role_permission` VALUES (44, 1);
INSERT INTO `role_permission` VALUES (45, 1);
INSERT INTO `role_permission` VALUES (46, 1);
INSERT INTO `role_permission` VALUES (47, 1);
INSERT INTO `role_permission` VALUES (48, 1);
INSERT INTO `role_permission` VALUES (49, 1);
INSERT INTO `role_permission` VALUES (50, 1);
INSERT INTO `role_permission` VALUES (51, 1);
INSERT INTO `role_permission` VALUES (52, 1);
INSERT INTO `role_permission` VALUES (53, 1);
INSERT INTO `role_permission` VALUES (54, 1);

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
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin', NULL, 1, NULL, '2025-03-16 03:55:49', '2025-03-16 03:55:49');
INSERT INTO `roles` VALUES (5, 'ádasdsd', NULL, 1, NULL, '2025-03-16 17:27:34', '2025-03-16 17:27:34');
INSERT INTO `roles` VALUES (7, 'test x', NULL, 1, NULL, '2025-03-23 11:29:14', '2025-03-23 11:29:14');
INSERT INTO `roles` VALUES (8, 'xxx', 'xxx', 1, NULL, '2025-03-23 11:35:16', '2025-03-23 11:35:16');

-- ----------------------------
-- Table structure for salary
-- ----------------------------
DROP TABLE IF EXISTS `salary`;
CREATE TABLE `salary`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_id` bigint NULL DEFAULT NULL,
  `start_at` date NULL DEFAULT NULL,
  `end_at` date NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `approve_by` bigint NULL DEFAULT NULL,
  `num` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of salary
-- ----------------------------
INSERT INTO `salary` VALUES (1, 'SAL776137', 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Phiếu lương của Trần Văn Hoàn cho tháng 03/25', 1, '2025-03-01', '2025-03-31', 'DRAFT', NULL, NULL);

-- ----------------------------
-- Table structure for salary_calculate
-- ----------------------------
DROP TABLE IF EXISTS `salary_calculate`;
CREATE TABLE `salary_calculate`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary_id` bigint NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `total` float NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'cộng hay trừ',
  `id_salary_details` bigint NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of salary_calculate
-- ----------------------------
INSERT INTO `salary_calculate` VALUES (1, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương đóng BHXH CBNV', 'LCSHS', 5000000, NULL, NULL, 'Cơ sở');
INSERT INTO `salary_calculate` VALUES (2, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương thỏa thuận CBNV', 'LTTNV', 10000000, NULL, NULL, 'Hệ số lương cơ bản');
INSERT INTO `salary_calculate` VALUES (3, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương cơ bản thỏa thuận CBNV (Hệ số)', 'LTTCBNVHS', 10000000, NULL, NULL, 'Hệ số lương cơ bản');
INSERT INTO `salary_calculate` VALUES (4, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương KPI thỏa thuận CBNV (Hệ số)', 'LKPITTNV', NULL, NULL, NULL, 'Hệ số lương cơ bản');
INSERT INTO `salary_calculate` VALUES (5, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương cơ bản thực tế CBNV (Hệ số)', 'LTTCBNVHS', 2119050, 'ADD', NULL, 'Cơ sở');
INSERT INTO `salary_calculate` VALUES (6, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương KPI thực tế CBNV (Hệ số)', 'LKPITTNV', NULL, 'ADD', NULL, 'Cơ sở');
INSERT INTO `salary_calculate` VALUES (7, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Phụ cấp tiền ăn CBNV', 'PCA', 133500, 'ADD', NULL, 'Phụ cấp');
INSERT INTO `salary_calculate` VALUES (8, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Truy thu', 'TT', 0, 'SUB', NULL, 'Giảm trừ');
INSERT INTO `salary_calculate` VALUES (9, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Truy lĩnh', 'TL', 0, 'ADD', NULL, 'Phụ cấp');
INSERT INTO `salary_calculate` VALUES (10, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Lương OT 200%', 'OT200', 297619, 'ADD', NULL, 'Cơ sở');
INSERT INTO `salary_calculate` VALUES (11, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Lương phép CBNV', 'LPNV032021', 714286, 'ADD', NULL, 'Hệ số lương cơ bản');
INSERT INTO `salary_calculate` VALUES (12, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', '	Tổng thu nhập CBNV', 'TTNNV032021', 3264450, NULL, NULL, 'Tổng');
INSERT INTO `salary_calculate` VALUES (13, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Bảo hiểm xã hội CBNV', 'BHXHNV', 400000, 'SUB', NULL, 'Giảm trừ');
INSERT INTO `salary_calculate` VALUES (14, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Bảo hiểm y tế CBNV', 'BHYTNV', 75000, 'SUB', NULL, 'Giảm trừ');
INSERT INTO `salary_calculate` VALUES (15, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Bảo hiểm thất nghiệp CBNV', 'BHTNNV', 50000, 'SUB', NULL, 'Giảm trừ');
INSERT INTO `salary_calculate` VALUES (16, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Thu nhập chịu thuế CBNV (Hệ số)', 'TNCTNV2022HS', 2739450, NULL, NULL, 'Tính thuế thu nhập cá nhân');
INSERT INTO `salary_calculate` VALUES (17, 1, 1, NULL, '2025-03-27 22:59:17', '2025-03-27 22:59:17', 'Thu nhập tính thuế CBNV (Hệ số)', 'TNTTNV032021HS', 0, NULL, NULL, 'Tính thuế thu nhập cá nhân');
INSERT INTO `salary_calculate` VALUES (18, 1, 1, NULL, '2025-03-27 22:59:17', '2025-03-27 22:59:17', '	Thuế thu nhập cá nhân CBNV (Hệ số)', 'TNCNNV032021HS', 0, 'SUB', NULL, 'Giảm trừ');
INSERT INTO `salary_calculate` VALUES (19, 1, 1, NULL, '2025-03-27 22:59:17', '2025-03-27 22:59:17', 'Phí công đoàn CBNV', 'PCDNV', 50000, 'SUB', NULL, 'Giảm trừ');
INSERT INTO `salary_calculate` VALUES (20, 1, 1, NULL, '2025-03-27 22:59:17', '2025-03-27 22:59:17', '	Lương Thực Lĩnh CBNV (Hệ số)', 'NETNVHS', 2939450, NULL, NULL, 'Lợi nhuận ròng');

-- ----------------------------
-- Table structure for salary_details
-- ----------------------------
DROP TABLE IF EXISTS `salary_details`;
CREATE TABLE `salary_details`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary_id` bigint NULL DEFAULT NULL,
  `created_by` bigint NULL DEFAULT NULL,
  `updated_by` bigint NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `num_day` float NULL DEFAULT NULL,
  `num_hours` float NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of salary_details
-- ----------------------------
INSERT INTO `salary_details` VALUES (1, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Ngày công tiêu chuẩn', 'STANDARD_WORKDAY', 21, NULL);
INSERT INTO `salary_details` VALUES (2, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Ngày công thực', 'WORK100', 4.45, NULL);
INSERT INTO `salary_details` VALUES (3, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Công ăn', 'LUNCH', 4.45, NULL);
INSERT INTO `salary_details` VALUES (4, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Ngày nghỉ phép', 'OFFDAY100', 1.5, NULL);
INSERT INTO `salary_details` VALUES (5, 1, 1, NULL, '2025-03-27 22:59:16', '2025-03-27 22:59:16', 'Tăng ca', 'WORK200', 5, NULL);

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
INSERT INTO `sessions` VALUES ('Edv11IURiUgttV8jM8TGktQf4hatIPhB3H10iK3S', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibnRCbjdyZElROFhlRWhhMTRPU0ZBa2dTWkNCWm1qRW82V0x1cld3ciI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vbG9jYWxob3N0L3FsLW5zL3B1YmxpYy9zYWxhcnkvMS9lZGl0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoidmkiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1743095202);

-- ----------------------------
-- Table structure for timekeeping
-- ----------------------------
DROP TABLE IF EXISTS `timekeeping`;
CREATE TABLE `timekeeping`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NULL DEFAULT NULL,
  `created_by` int NOT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `checkin` timestamp NULL DEFAULT NULL,
  `checkout` timestamp NULL DEFAULT NULL,
  `work_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `num_work_date` float NULL DEFAULT NULL,
  `work_late` float NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of timekeeping
-- ----------------------------
INSERT INTO `timekeeping` VALUES (1, 1, 1, 1, '2025-03-17 14:53:07', '2025-03-17 22:55:50', '2025-03-16 08:05:07', '2025-03-16 22:55:50', '13:20', 1, 5.12);
INSERT INTO `timekeeping` VALUES (2, 1, 1, 1, '2025-03-17 14:53:07', '2025-03-17 22:55:50', '2025-03-17 08:05:07', '2025-03-17 22:55:50', '13:20', 1, 5.12);
INSERT INTO `timekeeping` VALUES (3, 1, 1, 1, '2025-03-19 00:24:50', '2025-03-19 00:27:46', '2025-03-19 00:24:50', '2025-03-19 00:27:46', '00:02', 0.01, 0);
INSERT INTO `timekeeping` VALUES (5, 1, 1, NULL, '2025-03-21 00:51:48', '2025-03-21 00:51:48', '2025-03-21 07:00:00', '2025-03-21 12:00:00', '03:30', 0.44, 0);
INSERT INTO `timekeeping` VALUES (6, 2, 1, NULL, '2025-03-21 00:54:29', '2025-03-21 00:54:29', '2025-03-21 07:00:00', '2025-03-21 12:00:00', '03:30', 0.44, 0);
INSERT INTO `timekeeping` VALUES (7, 2, 1, NULL, '2025-03-21 19:17:08', '2025-03-21 19:17:08', '2025-02-05 20:00:00', '2025-02-05 12:00:00', '-8:00', -1, 720);
INSERT INTO `timekeeping` VALUES (8, 1, 1, NULL, '2025-03-21 19:20:43', '2025-03-21 19:20:43', '2025-03-22 12:00:00', '2025-03-27 12:00:00', '118:30', 1, 240);
INSERT INTO `timekeeping` VALUES (9, 1, 1, NULL, '2025-03-21 19:20:54', '2025-03-21 19:20:54', '2025-03-25 12:00:00', '2025-03-26 12:00:00', '22:30', 1, 240);
INSERT INTO `timekeeping` VALUES (10, 1, 1, NULL, '2025-03-21 19:25:47', '2025-03-21 19:25:47', '2025-03-26 12:00:00', '2025-03-26 12:00:00', '00:00', 0, 240);

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
  `unread_notification` int NULL DEFAULT NULL,
  `salary` int NULL DEFAULT NULL,
  `salary_kpi` int NULL DEFAULT NULL,
  `salary_insurance` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'CB213123', 'Trần Văn Hoàn', 'demoadmin.qlns@yopmail.com', NULL, '$2y$12$zbgMeFF3gB.k1W/f2p.NfuCdj8Df9ygcRiy02UZHuNhA1L8zQHvQi', 'uploads/WaZSpQ4w2Evi5KDXBxYIAa1l0Tu2SkcpNi7zHZFC.jpg', '[-0.12814876437187195,0.0935138463973999,-0.08937826007604599,-0.10347762703895569,-0.010279590263962746,-0.054726313799619675,-0.02800777554512024,-0.10420779883861542,0.1444721668958664,-0.015636160969734192,0.19856955111026764,-0.08244500309228897,-0.23686793446540833,-0.10188180208206177,-0.05891311913728714,0.20911867916584015,-0.26292741298675537,-0.17445598542690277,-0.059058018028736115,-0.021227868273854256,0.08412440121173859,-0.04095335677266121,-0.012882768176496029,0.11914993822574615,-0.08058375120162964,-0.3013167083263397,-0.10710937529802322,-0.0815734788775444,0.026697257533669472,-0.02225305140018463,0.007631676737219095,0.02784879505634308,-0.22703328728675842,-0.07657166570425034,0.05489426106214523,0.06641872972249985,-0.00764074781909585,-0.04946218803524971,0.20566526055335999,-0.03405815735459328,-0.1508273184299469,0.05869114026427269,0.10957064479589462,0.2847745716571808,0.1616836041212082,0.10268144309520721,-0.015184891410171986,-0.11220379173755646,0.049540016800165176,-0.1746833324432373,0.053799182176589966,0.17330524325370789,0.08792047202587128,0.09574289619922638,-0.02018085867166519,-0.11857958883047104,0.06647975742816925,0.09646983444690704,-0.17485593259334564,0.003483337350189686,0.06963484734296799,-0.04254002124071121,-0.002852505538612604,-0.08758619427680969,0.2808099091053009,0.06337922066450119,-0.1511719524860382,-0.1857268363237381,0.12711767852306366,-0.13241805136203766,-0.10908733308315277,0.0003617046168074012,-0.13933371007442474,-0.14504513144493103,-0.37428855895996094,0.05424874275922775,0.3670952320098877,0.09154132008552551,-0.1614442765712738,0.10180400311946869,-0.039695754647254944,-0.020691214129328728,0.11774706840515137,0.08692273497581482,-0.08065634220838547,-0.038993723690509796,-0.10317952185869217,0.003543234197422862,0.21796604990959167,-0.01914377696812153,-0.06693733483552933,0.15964561700820923,-0.00811802688986063,0.04638877511024475,0.013922828249633312,0.06107645481824875,-0.0356876477599144,0.04248714819550514,-0.13604113459587097,0.047491684556007385,0.036911167204380035,0.0188563484698534,-0.0019460208714008331,0.15201815962791443,-0.09273508936166763,0.05250556021928787,0.03492163494229317,0.0032521092798560858,-0.03573383018374443,0.0981329157948494,-0.1777881234884262,-0.11986203491687775,0.08308222889900208,-0.242197185754776,0.25366172194480896,0.1842600256204605,0.08486297726631165,0.05194833502173424,0.12429334223270416,0.0877145528793335,-0.005343571770936251,0.035291723906993866,-0.2085132747888565,-0.03413189947605133,0.14544308185577393,0.01735122874379158,0.12173832207918167,0.053928159177303314]', NULL, '2025-03-01 16:58:24', '2025-03-24 23:32:38', 0, 1, NULL, 1, 2, 3, 1, '1', '3', NULL, '08:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 10000000, NULL, 5000000);
INSERT INTO `users` VALUES (2, 'CBNV815021', 'Trần Văn Hoàn', 'sgskdfm@yopmail.com', NULL, '$2y$12$H194eD7p5Bw4smzNjT9hEuXHa6DyJafay0aUUyabrOaZtQMRYdnFe', NULL, NULL, NULL, '2025-03-16 16:04:59', '2025-03-24 23:43:55', 1, 1, '0348053999', 1, 2, 1, 1, '1', '1', '2025-05-07', '08:00:00', '123123123', '345435', '2025-05-15', NULL, '2025-05-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000000, 500, 5000000);
INSERT INTO `users` VALUES (3, 'CBNV874815', 'Quan ly Hoan', 'ql-demoadmin.qlns@yopmail.com', NULL, '$2y$12$B0wopqQvAcsp2dp.yU5toulz20JU1O2N0hs0/HR93ilUnmasefFg.', NULL, NULL, NULL, '2025-03-24 21:55:13', '2025-03-24 21:59:09', 1, 1, NULL, 1, 2, NULL, 1, '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
