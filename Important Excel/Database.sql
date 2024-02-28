-- Adminer 4.8.1 MySQL 8.0.29 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `lecture_id` bigint unsigned NOT NULL,
  `latitude` double(8,2) NOT NULL,
  `longitude` double(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `attendances_student_id_foreign` (`student_id`),
  KEY `attendances_lecture_id_foreign` (`lecture_id`),
  CONSTRAINT `attendances_lecture_id_foreign` FOREIGN KEY (`lecture_id`) REFERENCES `lectures` (`id`),
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `attendances` (`id`, `student_id`, `lecture_id`, `latitude`, `longitude`, `created_at`) VALUES
(322,	653,	9,	62.75,	154.14,	'2024-02-22 07:16:24'),
(323,	653,	14,	62.75,	154.14,	'2024-02-23 04:37:03'),
(324,	653,	14,	62.75,	154.14,	'2024-02-23 04:37:19');

DROP TABLE IF EXISTS `department_types`;
CREATE TABLE `department_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_type_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `department_types_department_type_name_unique` (`department_type_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `department_types` (`id`, `department_type_name`) VALUES
(1,	'Institute Of Technology');

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_type_id` bigint unsigned NOT NULL,
  `department_code` int NOT NULL,
  `department_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_department_code_unique` (`department_code`),
  UNIQUE KEY `departments_department_name_unique` (`department_name`),
  KEY `departments_department_type_id_foreign` (`department_type_id`),
  CONSTRAINT `departments_department_type_id_foreign` FOREIGN KEY (`department_type_id`) REFERENCES `department_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `departments` (`id`, `department_type_id`, `department_code`, `department_name`) VALUES
(1,	1,	16,	'Information Technology'),
(2,	1,	7,	'Computer Engineering'),
(3,	1,	9,	'Electrical Engineering'),
(4,	1,	1,	'Aeranotical Engineering');

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE `divisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `division_name` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `current_sem` bigint unsigned NOT NULL,
  `admission_year` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisions_division_name_department_id_admission_year_unique` (`division_name`,`department_id`,`admission_year`),
  KEY `divisions_department_id_foreign` (`department_id`),
  CONSTRAINT `divisions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `chk_div_sem` CHECK (((`current_sem` >= 1) and (`current_sem` <= 8))),
  CONSTRAINT `chk_division_sem` CHECK (((`current_sem` >= 1) and (`current_sem` <= 8)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `divisions` (`id`, `division_name`, `department_id`, `current_sem`, `admission_year`, `created_at`, `updated_at`) VALUES
(1,	'A',	1,	4,	2022,	NULL,	NULL);

DROP TABLE IF EXISTS `faculties`;
CREATE TABLE `faculties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` bigint NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faculties_email_unique` (`email`),
  UNIQUE KEY `faculties_short_name_unique` (`short_name`),
  UNIQUE KEY `faculties_phone_number_unique` (`phone_number`),
  KEY `faculties_department_id_foreign` (`department_id`),
  CONSTRAINT `faculties_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faculties` (`id`, `first_name`, `last_name`, `middle_name`, `email`, `short_name`, `phone_number`, `department_id`, `password`, `created_at`, `updated_at`) VALUES
(5,	'B',	'B',	'P',	'bbp@gmail.com',	'BBP',	1234567890,	1,	'$2y$10$TK1zhFm03IeDsbJelqGKAuU.zsniUIOkjZRHwFgo88G9ZnaECJg6i',	'2024-02-22 00:16:20',	'2024-02-22 00:16:20'),
(7,	'P',	'N',	'R',	'pnr@gmail.com',	'PNR',	987654321,	1,	'$2y$10$PmQhv6BXeJtx1DgS6J4OnOTOjcFVspXQ6QwomAtv2HzVCQIM0SGyq',	'2024-02-22 00:16:57',	'2024-02-22 00:16:57'),
(8,	'S',	'A',	'S',	'sas@gmail.com',	'SAS',	9876543210,	1,	'$2y$10$FcYrcAdoaD4otT0HTp4FmOVckV7ZsxCiKutBi/en7c.ufYpxSJkEe',	'2024-02-22 00:17:27',	'2024-02-22 00:17:27'),
(9,	'J',	'B',	'C',	'jbc@gmail.com',	'JBC',	8765432109,	1,	'$2y$10$v5xqDUGk21Mp9tdpsKH3X.vFdqLGO8po.a6Odu.vSQ9OL4wZUN2Yi',	'2024-02-22 00:17:55',	'2024-02-22 00:17:55'),
(10,	'M',	'B',	'P',	'mbp@gmail.com',	'MBP',	7654321098,	1,	'$2y$10$Ohgx0dt6ybtaE3Wj/S1fgudozjmGHqMVXbtKXREFUZR0xKxycJxY2',	'2024-02-22 00:18:30',	'2024-02-22 00:18:30'),
(11,	'A',	'C',	'P',	'acp@gmail.com',	'ACP',	6543210987,	1,	'$2y$10$N2150a5ABlnS9GfeqqrluO9Im3.txZj8dv2xHyuj5N2X54LjQpLhG',	'2024-02-22 00:18:56',	'2024-02-22 00:18:56'),
(12,	'P',	'R',	'P',	'prp@gmail.com',	'PRP',	5432109876,	1,	'$2y$10$7HOlF/5soflNfs9csJJamOudmzn3R/gVQ.W1VgEgZe9MUMbYMgS2.',	'2024-02-22 00:19:34',	'2024-02-22 00:19:34'),
(13,	'J',	'S',	'P',	'jsp@gmail.com',	'JSP',	4321098765,	1,	'$2y$10$WCX8s2Nsx49aRe9F9mWrD..UWacDzEffWJ3z3nV8tEwXuKz9MLKQW',	'2024-02-22 00:20:05',	'2024-02-22 00:20:05'),
(15,	'ME',	'_',	'JAY',	'me_jay@gmail.com',	'ME_JAY',	6321098765,	1,	'$2y$10$tyGB0gQAO1tL/if4g94caevTljY0WEXYGOEO8Ru/1UTf6OYlDO2UW',	'2024-02-22 00:21:03',	'2024-02-22 00:21:03'),
(16,	'S',	'J',	'P',	'sjp@gmail.com',	'SJP',	3210987654,	1,	'$2y$10$0qm8/RvlWh31I4IcGWdHVuFyKrJrY.ZK.oWFCKDm7p5khr7Hj7TWu',	'2024-02-22 00:21:46',	'2024-02-22 00:21:46'),
(17,	'A',	'J',	'P',	'ajp@gmail.com',	'AJP',	2109876543,	1,	'$2y$10$fuNe4uq1/4j3JwxE0Y8VqOcqXqoa.4rMiNIkK8Ml74ItcC1RatfJO',	'2024-02-22 00:22:14',	'2024-02-22 00:22:14'),
(18,	'J',	'T',	'P',	'jtp@gmail.com',	'JTP',	1098765432,	1,	'$2y$10$Acs/mvMA.PJiLtCiZLOlN.yjA8A.fYrVksRh9fXjPg1yKze48DW5u',	'2024-02-22 00:22:46',	'2024-02-22 00:22:46'),
(19,	'V',	'F',	'G',	'vf@gmail.com',	'VF',	9876543234,	1,	'$2y$10$Es1wVXzgdMIKSDvt7dmsHedpCA2pazWa87WTvx/WmYolj958kQKy6',	'2024-02-22 00:23:17',	'2024-02-22 00:23:17'),
(20,	'S',	'B',	'C',	'sbc@gmail.com',	'SBC',	654321234567,	1,	'$2y$10$YlGyZmpWA9xLkRDm/MgPl.TJgz7s0Bk23.KO7SUZ0zE87v2eyukk.',	'2024-02-22 00:23:48',	'2024-02-22 00:23:48'),
(21,	'FAKE',	'FAKE',	'FAKE',	'fake@gmail.com',	'FAKE',	7637673673,	1,	'1',	NULL,	NULL);

DROP TABLE IF EXISTS `faculty_lecturers`;
CREATE TABLE `faculty_lecturers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `time_table_id` bigint unsigned NOT NULL,
  `faculty_id` bigint unsigned NOT NULL,
  `lab_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faculty_lecturers_time_table_id_foreign` (`time_table_id`),
  KEY `faculty_lecturers_faculty_id_foreign` (`faculty_id`),
  CONSTRAINT `faculty_lecturers_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`),
  CONSTRAINT `faculty_lecturers_time_table_id_foreign` FOREIGN KEY (`time_table_id`) REFERENCES `time_tables` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faculty_lecturers` (`id`, `time_table_id`, `faculty_id`, `lab_name`, `created_at`, `updated_at`) VALUES
(524,	416,	5,	'A1',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(525,	416,	7,	'A2',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(526,	416,	8,	'A3',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(527,	417,	8,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(528,	418,	9,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(529,	419,	10,	'A1',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(530,	419,	11,	'A2',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(531,	419,	9,	'A3',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(532,	420,	8,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(533,	421,	12,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(534,	422,	13,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(535,	423,	9,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(536,	424,	12,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(537,	425,	15,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(538,	426,	13,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(539,	427,	12,	'A1',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(540,	427,	16,	'A2',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(541,	427,	17,	'A3',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(542,	428,	18,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(543,	429,	19,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(544,	430,	20,	NULL,	'2024-02-22 01:26:48',	'2024-02-22 01:26:48');

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `lectures`;
CREATE TABLE `lectures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `time_table_id` bigint unsigned NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `holiday_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_lecture` date NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lectures_slug_unique` (`slug`),
  KEY `lectures_time_table_id_foreign` (`time_table_id`),
  CONSTRAINT `lectures_time_table_id_foreign` FOREIGN KEY (`time_table_id`) REFERENCES `time_tables` (`id`),
  CONSTRAINT `check_end_time_greater_than_start_time_for_lecture` CHECK ((`end_time` > `start_time`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `lectures` (`id`, `time_table_id`, `start_time`, `end_time`, `holiday_reason`, `date_of_lecture`, `slug`, `otp`, `created_at`, `updated_at`, `is_open`) VALUES
(9,	424,	'13:00:00',	'15:00:00',	NULL,	'2024-02-22',	'784gAGrNfJUYtOGMbhvM0ykt8sv30iNwHxc6OxMXFlz1XOCtDV',	872523,	'2024-02-22 01:38:54',	'2024-02-22 10:54:17',	0),
(10,	425,	'15:00:00',	'16:00:00',	NULL,	'2024-02-22',	'gpRSUJ7EvhOoJOfp1ZszLYMuVhR3glofMTXUpftBtYJZFNmh50',	917327,	'2024-02-22 01:38:54',	'2024-02-22 01:38:54',	0),
(11,	426,	'16:00:00',	'17:00:00',	NULL,	'2024-02-22',	'0DbLWFx6EoJI7FTdPukU1ScLZP4fRIPxq13ywJcZcRkpL6nhX4',	774696,	'2024-02-22 01:38:54',	'2024-02-22 01:38:54',	0),
(14,	427,	'09:30:00',	'12:30:00',	NULL,	'2024-02-23',	'E9MPpgOhkmqMNmvm02lGwHI4GLC6UiOcQNkL69U7c7COuYlEXa',	579913,	'2024-02-22 22:30:19',	'2024-02-22 23:16:46',	0),
(15,	428,	'13:00:00',	'15:00:00',	NULL,	'2024-02-23',	'BObAeuq6Ak7FxFsoQEyD0mt7BB3vIDcMsaopwRehE2iDSPEXgC',	250913,	'2024-02-22 22:30:19',	'2024-02-22 22:30:19',	0),
(16,	429,	'15:00:00',	'16:00:00',	NULL,	'2024-02-23',	'nrd8ZwfFjF87y1HCifr7GIEpG5wLfsP0wmJivZVc73Xips8cYg',	878594,	'2024-02-22 22:30:19',	'2024-02-22 22:30:19',	0),
(17,	430,	'16:00:00',	'17:00:00',	NULL,	'2024-02-23',	'fLKHMyYqgPCKJ9OuBWjmbqyz5WCIz8Wp27pOSQgUuQA3Otetri',	422566,	'2024-02-22 22:30:19',	'2024-02-22 22:30:19',	0);

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1),
(3,	'2019_08_19_000000_create_failed_jobs_table',	1),
(4,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(5,	'2023_10_18_192527_create_department_types_table',	2),
(6,	'2023_10_18_192437_create_departments_table',	3),
(9,	'2023_10_19_181904_create_subjects_table',	5),
(15,	'2023_11_22_171427_create_divisions_table',	6),
(16,	'2023_10_18_192008_create_students_table',	7),
(25,	'2023_11_21_170835_create_faculties_table',	13),
(27,	'2023_11_23_080219_create_time_tables_table',	14),
(28,	'2023_11_25_054804_create_lectures_table',	15),
(29,	'2023_11_23_080111_create_attendances_table',	16),
(30,	'2023_12_04_063526_create_faculty_lecturers_table',	17);

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `enrollment_no` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `admission_year` year NOT NULL,
  `student_type` int NOT NULL COMMENT '1 => Regular,2 => D2D',
  `division_id` bigint unsigned NOT NULL,
  `temporary_id` int DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_email_unique` (`email`),
  UNIQUE KEY `students_phone_number_unique` (`phone_number`),
  KEY `students_department_id_foreign` (`department_id`),
  KEY `students_division_id_foreign` (`division_id`),
  CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `students_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `students` (`id`, `enrollment_no`, `first_name`, `last_name`, `middle_name`, `email`, `phone_number`, `department_id`, `admission_year`, `student_type`, `division_id`, `temporary_id`, `password`, `created_at`, `updated_at`) VALUES
(653,	'230283116001',	'Amelie',	'Macejkovic',	'Leone',	'230283116001@ldce.ac.in',	'+1.248.451.2046',	1,	'2022',	1,	1,	2580,	'$2y$10$oTftSF3uoC3QyLzP/PEp5OoM.CmlvEEs/DtQAaG25ePGdX.Gb3YTa',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(654,	'230283116002',	'Enola',	'Wolf',	'Virgil',	'230283116002@ldce.ac.in',	'562.634.3647',	1,	'2022',	1,	1,	4711,	'$2y$10$8xhyWJP20cpEeUv6pFt2L.aQR.xFqRx2tjpW0Zl3dA5NPHHqxwrCu',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(655,	'230283116003',	'Finn',	'Ratke',	'Murphy',	'230283116003@ldce.ac.in',	'205-530-2106',	1,	'2022',	1,	1,	9870,	'$2y$10$79pBM6/xaMO1OAHf8zeO5u10e7Lq/FeoBWTSWZDPEHiq/tvkgDIhC',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(656,	'230283116004',	'Tevin',	'Keeling',	'Omer',	'230283116004@ldce.ac.in',	'+12349216163',	1,	'2022',	1,	1,	4878,	'$2y$10$URrkd2hIGR7hHR6p/fS/eO0LH2yZPjmHZzVj/XKT8IeE8nJHNUlRW',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(657,	'230283116005',	'Esther',	'Hoeger',	'Alfredo',	'230283116005@ldce.ac.in',	'534-722-8697',	1,	'2022',	1,	1,	8261,	'$2y$10$hk/2VmUwyY6trAnSfw8.ceSe/MqR52ldNG7ZUYAlX1fIdaVUiY.QS',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(658,	'230283116006',	'Irma',	'Breitenberg',	'Favian',	'230283116006@ldce.ac.in',	'(619) 675-1114',	1,	'2022',	1,	1,	8520,	'$2y$10$C.nPHBYuAjDnDlq5/j9a1uQs5PXwMtAxMMfAiBHmjp3WqcE7MIVVa',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(659,	'230283116007',	'Cecile',	'Kassulke',	'Coty',	'230283116007@ldce.ac.in',	'+1.770.937.8227',	1,	'2022',	1,	1,	4131,	'$2y$10$nZyM7d2YFOn.2Q5HdSdG5uabuh8qTDf6T1UKBqdU8m8q27APXVKwi',	'2024-02-22 01:44:33',	'2024-02-22 01:44:33'),
(660,	'230283116008',	'Dan',	'Casper',	'General',	'230283116008@ldce.ac.in',	'(540) 817-2340',	1,	'2022',	1,	1,	1472,	'$2y$10$kkVWVzXUWmR6C.A.ZCwt2O0bh9esLC010jbEqCFPSzGrYYkhv06Ru',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(661,	'230283116009',	'Aglae',	'Pollich',	'Jorge',	'230283116009@ldce.ac.in',	'(878) 406-5950',	1,	'2022',	1,	1,	7771,	'$2y$10$l6NnuhwWnTy9QccJdmcefu4he4W46f//3aNqq0NoxIehbclZ8qg1S',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(662,	'230283116010',	'Loyal',	'Stanton',	'Cristopher',	'230283116010@ldce.ac.in',	'+1-817-924-3849',	1,	'2022',	1,	1,	2558,	'$2y$10$eU0SNoRWKrw9/MonM/XO3uPG4ZW0v083iG2w/qQqzWjYXhVDVFqxG',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(663,	'230283116011',	'Nyasia',	'Pacocha',	'Owen',	'230283116011@ldce.ac.in',	'520-803-1576',	1,	'2022',	1,	1,	6045,	'$2y$10$ng2AMAajdM/wPnq6b54i8uJPSYQ6L.Zu/v.A.MZZOIFK1p3CcrWwG',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(664,	'230283116012',	'Haylie',	'Boyer',	'Nicklaus',	'230283116012@ldce.ac.in',	'(754) 541-0671',	1,	'2022',	1,	1,	3316,	'$2y$10$hrZKIDvWyykJc6GmbfSl2OAcrgGJREF9yI6Offsk2zMpefTIKvOOC',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(665,	'230283116013',	'Brennan',	'Schowalter',	'Diamond',	'230283116013@ldce.ac.in',	'201-461-8076',	1,	'2022',	1,	1,	1601,	'$2y$10$YPn7XBMxt3S2ua6YVwE.DeWYCLMos0B5av7VhAv.ByckA2MRp4o1a',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(666,	'230283116014',	'Kirsten',	'Deckow',	'Reid',	'230283116014@ldce.ac.in',	'910.578.7380',	1,	'2022',	1,	1,	4198,	'$2y$10$iyLIlv/W9Ye6kW.vgaVFGOkz8k8cyk9cKvGA2.OWKEcmpw5LeEkFe',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(667,	'230283116015',	'Floy',	'Hirthe',	'Anastacio',	'230283116015@ldce.ac.in',	'+1-430-429-0402',	1,	'2022',	1,	1,	4908,	'$2y$10$MUZzQLe2rhfRf15Vztp1.OCguO4PNvmRuI7vtsoar/T8N7UoYlcYq',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(668,	'230283116016',	'Dorcas',	'Braun',	'Woodrow',	'230283116016@ldce.ac.in',	'+1.657.644.9291',	1,	'2022',	1,	1,	1151,	'$2y$10$6Zz1WqEzTnLAmNG0LZc4B.6zxa4E9jo4E3p.yefX1/N0h5LfhSWeS',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(669,	'230283116017',	'Agustina',	'Bogisich',	'Brannon',	'230283116017@ldce.ac.in',	'+1-234-579-4106',	1,	'2022',	1,	1,	9880,	'$2y$10$Y2jJACQYY7PiIcyL1HdBouE3gmd2uPyOBc0SB0E5nIIN9OqPcz/lm',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(670,	'230283116018',	'Twila',	'Kirlin',	'Hollis',	'230283116018@ldce.ac.in',	'559.841.3283',	1,	'2022',	1,	1,	8940,	'$2y$10$17zTilFFKYLXMcbDq54DXOpzPpjejzcYR5OlixWAFanbFWEyyfkQC',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(671,	'230283116019',	'Amparo',	'McKenzie',	'Drake',	'230283116019@ldce.ac.in',	'629.993.8404',	1,	'2022',	1,	1,	9478,	'$2y$10$1DsioKlkhuYJAt20YOtzeezeADaFe.dT1nypu7NOM3ieQ1/uLP1OW',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(672,	'230283116020',	'Odell',	'Okuneva',	'Milton',	'230283116020@ldce.ac.in',	'1-484-731-5585',	1,	'2022',	1,	1,	6475,	'$2y$10$XvqwpM50lyn5TOTOnBoXf.FQQiw.kK7pLAWVdn.yfhovCLmLdN31G',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(673,	'230283116021',	'Alexandre',	'O\'Keefe',	'Morris',	'230283116021@ldce.ac.in',	'+1.410.899.9923',	1,	'2022',	1,	1,	3590,	'$2y$10$FKkCjBKFf7XrbY6JWfdzseDiPZOxNUHLApwH7CGAQqM3dea0ypT86',	'2024-02-22 01:44:34',	'2024-02-22 01:44:34'),
(674,	'230283116022',	'Darrell',	'Gorczany',	'Ibrahim',	'230283116022@ldce.ac.in',	'+1 (463) 299-2525',	1,	'2022',	1,	1,	9233,	'$2y$10$qZYV4fmwjSjHRv3RpVUrfOqi.qF4siE.EnfOi2xd7RgQM7Dr9g6tS',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(675,	'230283116023',	'Ted',	'Stehr',	'Reinhold',	'230283116023@ldce.ac.in',	'608.438.2384',	1,	'2022',	1,	1,	445,	'$2y$10$NKotjoAV6ZLbS73rL1WbC.mB0zRO8K/JaVCLIwvBTcaRLOYY7YC1G',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(676,	'230283116024',	'Nathaniel',	'Steuber',	'Dagmar',	'230283116024@ldce.ac.in',	'+1 (870) 410-2265',	1,	'2022',	1,	1,	3080,	'$2y$10$bcQPC26vIvJo4xeNN.R4m.NWsdDTyqH2JXk4q0pOdPQ.2sfD8gRbS',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(677,	'230283116025',	'Myra',	'Volkman',	'Andres',	'230283116025@ldce.ac.in',	'+1-985-645-7704',	1,	'2022',	1,	1,	1958,	'$2y$10$E5jVd7efVx8i1p.yUnKSAe4l1.srwU/3qqiOmKEr9R6uDrVXwez4e',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(678,	'230283116026',	'Wilfredo',	'Jakubowski',	'Jay',	'230283116026@ldce.ac.in',	'(850) 813-4554',	1,	'2022',	1,	1,	9551,	'$2y$10$CMvQJoi7g08I39KsSCel.OvXqVDa/4IVS3IdPbs/P7uMbg2DFJbSu',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(679,	'230283116027',	'Zion',	'Harber',	'Cedrick',	'230283116027@ldce.ac.in',	'907-665-4253',	1,	'2022',	1,	1,	282,	'$2y$10$it8pYy4aYbPFWCG7s/VvvusTbyIrlJz4mzwz88KhFyA/tNijcyu8.',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(680,	'230283116028',	'Felicia',	'Bradtke',	'Maxwell',	'230283116028@ldce.ac.in',	'847.777.5656',	1,	'2022',	1,	1,	2258,	'$2y$10$8GPoR45kKp4x1brNfq8q2uOX5x57WyDHFh0ySkM3hkCsA05R9YJny',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(681,	'230283116029',	'Thalia',	'Wolff',	'Joaquin',	'230283116029@ldce.ac.in',	'+1-269-401-8872',	1,	'2022',	1,	1,	3728,	'$2y$10$2NiakMkGsLthpxmOrf1oe.kFLEHebJYP.broC8jvUaJGGYPnMv506',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(682,	'230283116030',	'Alanis',	'Herzog',	'Henri',	'230283116030@ldce.ac.in',	'+1-530-951-1197',	1,	'2022',	1,	1,	151,	'$2y$10$qnfOhpqbuxQp9k6np.D1YO/PBpD3CRm78cfupT4Di/tyzkhSPzn0u',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(683,	'230283116031',	'Kirsten',	'VonRueden',	'Jarret',	'230283116031@ldce.ac.in',	'1-320-792-7403',	1,	'2022',	1,	1,	5962,	'$2y$10$yXW6Q06J.r5q9/cFhaZqPeqRagyaqYKbRcelWdS1LtMAmrf6xNoGS',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(684,	'230283116032',	'Brittany',	'Vandervort',	'Narciso',	'230283116032@ldce.ac.in',	'559.406.6457',	1,	'2022',	1,	1,	2100,	'$2y$10$q//lHspDlDcL6jgyvlQqQuSWNw/26CXzWzq2PbPL11TNQih0OFDu6',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(685,	'230283116033',	'Camilla',	'Nienow',	'Isidro',	'230283116033@ldce.ac.in',	'850.204.4480',	1,	'2022',	1,	1,	7194,	'$2y$10$cPsKIVWFuO9yl7PK.lZtfOoHF.2NOsyYAII/CoGjpMQqKSG4h2RIS',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(686,	'230283116034',	'Ashley',	'Gottlieb',	'Gianni',	'230283116034@ldce.ac.in',	'1-470-837-7599',	1,	'2022',	1,	1,	4375,	'$2y$10$4MboFf4TqjztIZLWAxvB6OgN.L6G3sNvstwe1Gah.1DdYSrXwzvFi',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(687,	'230283116035',	'Rosalinda',	'Block',	'Sheldon',	'230283116035@ldce.ac.in',	'1-463-809-9163',	1,	'2022',	1,	1,	2614,	'$2y$10$4YRXZG8c85o3BpvH3eqywuJ6rbrn49L6iIneSBGzwdkKULejsiiui',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(688,	'230283116036',	'Moises',	'Lynch',	'Hillard',	'230283116036@ldce.ac.in',	'414-600-4956',	1,	'2022',	1,	1,	6728,	'$2y$10$ubs0/A/U2VwM/H1F7S3bw.PwJTiuobQTMgHz90PE9eZ1R.uyTNwR6',	'2024-02-22 01:44:35',	'2024-02-22 01:44:35'),
(689,	'230283116037',	'Wilford',	'Ondricka',	'Marcelino',	'230283116037@ldce.ac.in',	'1-908-684-9314',	1,	'2022',	1,	1,	7373,	'$2y$10$OBVIakkapUqllBtmGewmqe5/rjddcfHaaBjIPYLW.PtxPFWsDCek.',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(690,	'230283116038',	'Lily',	'Gaylord',	'Leonel',	'230283116038@ldce.ac.in',	'743.283.2285',	1,	'2022',	1,	1,	6927,	'$2y$10$0tcFIlitzaVGCjLAnIS/f.Ucw0jZk/Ba1uzD2P2O5gAcW3awu4D1W',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(691,	'230283116039',	'Adele',	'Lynch',	'Holden',	'230283116039@ldce.ac.in',	'1-505-856-4626',	1,	'2022',	1,	1,	3041,	'$2y$10$0cA9YvaDDINw4BmXq.QBReJwr/2fdS4Okmr.gIPFt/CH3QmTR40qi',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(692,	'230283116040',	'Polly',	'Barton',	'Keeley',	'230283116040@ldce.ac.in',	'1-480-786-7938',	1,	'2022',	1,	1,	6936,	'$2y$10$P.BY7ai51sN5mWIVBnOhMOSjtqEGwqnIk38sRNXsjbzdrrLvP3VhK',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(693,	'230283116041',	'Hannah',	'Satterfield',	'Jadon',	'230283116041@ldce.ac.in',	'+1.754.771.8306',	1,	'2022',	1,	1,	9757,	'$2y$10$yQm4qWDkIlH0YD3qLzCdOOlpF2Li/EEa33pNxwwTUVQtTW0/Yy2ae',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(694,	'230283116042',	'Jazmin',	'Metz',	'Reagan',	'230283116042@ldce.ac.in',	'+17377254332',	1,	'2022',	1,	1,	5167,	'$2y$10$LOHDP2btOXjHigX9K9MhMOsTZ0Vo9C13WFgVyawtOjb2ru8jaK1MC',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(695,	'230283116043',	'Rahul',	'Lynch',	'Lyric',	'230283116043@ldce.ac.in',	'651-993-7474',	1,	'2022',	1,	1,	7327,	'$2y$10$/5lH8kvaVALOOwwDZ9rsNepHhJUg8lrJqzVvDhDNKRUgAKB/O.CN6',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(696,	'230283116044',	'Norval',	'Gislason',	'Miller',	'230283116044@ldce.ac.in',	'1-478-400-5502',	1,	'2022',	1,	1,	7215,	'$2y$10$eb4giQuW5YaPZmK9qHdfXOatG0tVR0VrKL6j20OkdNEaLcL29zbvO',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(697,	'230283116045',	'Jude',	'Shields',	'Arno',	'230283116045@ldce.ac.in',	'239-754-9149',	1,	'2022',	1,	1,	4651,	'$2y$10$NWhN1Bu9WL7wNtoX1wyxrOnd7OdhXVCgnaWAT1PZjpHwz.6fzTxAa',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(698,	'230283116046',	'Joaquin',	'Ferry',	'Presley',	'230283116046@ldce.ac.in',	'463-687-9118',	1,	'2022',	1,	1,	373,	'$2y$10$mbrCtKCc3uz/telUu3IAJeht/I12c0NL0kh54vSxuDYmEyrjI6NjG',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(699,	'230283116047',	'Etha',	'Kunze',	'Reilly',	'230283116047@ldce.ac.in',	'(712) 882-9980',	1,	'2022',	1,	1,	2724,	'$2y$10$iOpLc1JpbUg82IWNuv6HF.xuhPH70ksefQnRhHEBRQurK4dj4oj0S',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(700,	'230283116048',	'Corene',	'Collier',	'Juston',	'230283116048@ldce.ac.in',	'+1.772.720.1353',	1,	'2022',	1,	1,	259,	'$2y$10$jRzxEpDF.2.KH1tD9tqyS.bbM9ZcUv9Glrq56olktjv82OXYq3s3S',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(701,	'230283116049',	'Cyrus',	'Lebsack',	'Dane',	'230283116049@ldce.ac.in',	'440-478-0096',	1,	'2022',	1,	1,	6175,	'$2y$10$hF5DpAw8BWzGmqFiHfPh0ufxpo.NviY.ZOj1IlKK50EpU2YzdRB.a',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(702,	'230283116050',	'Mikayla',	'Beer',	'Vernon',	'230283116050@ldce.ac.in',	'+1 (239) 680-3124',	1,	'2022',	1,	1,	5343,	'$2y$10$3OXkglHLnHIDh1By3YJVye0lcah4kWuWdITT6P0DpsXQpPWq7Pkzy',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(703,	'230283116051',	'Brendon',	'Windler',	'Hermann',	'230283116051@ldce.ac.in',	'239.913.7268',	1,	'2022',	1,	1,	236,	'$2y$10$5.M/pcQFS/f8WIHoMw7ga.zFRTs4xI2rwto4.EYaK1m1eFOLdmDzi',	'2024-02-22 01:44:36',	'2024-02-22 01:44:36'),
(704,	'230283116052',	'Megane',	'Wintheiser',	'Osvaldo',	'230283116052@ldce.ac.in',	'1-779-855-6564',	1,	'2022',	1,	1,	7247,	'$2y$10$r/.ROI5zyxHkU3Az2jXMF.bQbkbFDozbkO93PGA0muGsIs/XefVFi',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(705,	'230283116053',	'Anjali',	'Von',	'Cortez',	'230283116053@ldce.ac.in',	'858.576.3174',	1,	'2022',	1,	1,	6698,	'$2y$10$aKK1RdcciUSC1/m3n3NV.OOb1kS4r.zmp7HulD.Y.YY4vBL6x7uyG',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(706,	'230283116054',	'Lea',	'Kulas',	'Monserrat',	'230283116054@ldce.ac.in',	'936.314.6009',	1,	'2022',	1,	1,	4012,	'$2y$10$LjwAiJo5cVxkDJ9fBEx2WOusxQgI7toKWW2aEKNtVTFUZXKJtq7Iy',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(707,	'230283116055',	'Emely',	'Carroll',	'Rhiannon',	'230283116055@ldce.ac.in',	'512-324-3605',	1,	'2022',	1,	1,	3453,	'$2y$10$qFvkuoq3OoTIyBxValDL8uWk4GFjks5Za2II0gu8ZmfTNjcC6aC8m',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(708,	'230283116056',	'Imogene',	'Walker',	'Alexzander',	'230283116056@ldce.ac.in',	'838.449.0195',	1,	'2022',	1,	1,	744,	'$2y$10$01XU00zClLMaWwTNehkUTul/yJx5bCinCfTYb9dg05ZkuXY97SOrW',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(709,	'230283116057',	'Jasmin',	'Swaniawski',	'Ben',	'230283116057@ldce.ac.in',	'+1-747-615-5713',	1,	'2022',	1,	1,	1401,	'$2y$10$44ISmD8XKP7mEyMkjhlomeHX3sd/eo9X9sqA/TTxHqWE0umEbavEa',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(710,	'230283116058',	'Theresa',	'Corwin',	'Lonny',	'230283116058@ldce.ac.in',	'681-325-8768',	1,	'2022',	1,	1,	1326,	'$2y$10$q6ftywn.yH4Whi.zsnaThuCgE5SJeYuWvvf3ptvsCobyAAZrkn0z.',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(711,	'230283116059',	'Freda',	'Casper',	'Francesco',	'230283116059@ldce.ac.in',	'+1-718-717-8910',	1,	'2022',	1,	1,	9507,	'$2y$10$.VQg8VxlfE3gRq7OoT/rWeYz2gxFiHEKwubTmLcQ25TrlmfS/TZGC',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37'),
(712,	'230283116060',	'Johnathon',	'Fisher',	'Freeman',	'230283116060@ldce.ac.in',	'+1.325.594.1268',	1,	'2022',	1,	1,	9128,	'$2y$10$oz5XmP6loVoessQtf3H6devk1ReiXpgMQ8OFRa0nkW5WFnj9KF6nm',	'2024-02-22 01:44:37',	'2024-02-22 01:44:37');

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` int NOT NULL,
  `sem` int NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_department_id_foreign` (`department_id`),
  CONSTRAINT `subjects_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `subjects` (`id`, `name`, `short_name`, `code`, `sem`, `department_id`, `created_at`, `updated_at`) VALUES
(12,	'Computer Organization & Architecture',	'COA',	3140707,	4,	1,	'2024-02-22 00:07:37',	'2024-02-22 00:07:37'),
(13,	'Object Oriented Programming -I',	'OOP-I',	3140705,	4,	1,	'2024-02-22 00:08:16',	'2024-02-22 00:08:16'),
(14,	'Discrete Mathematics',	'DM',	3140708,	4,	1,	'2024-02-22 00:08:46',	'2024-02-22 00:08:46'),
(15,	'Operating System and Virtualization',	'OS',	3141601,	4,	1,	'2024-02-22 00:09:12',	'2024-02-22 00:09:12'),
(16,	'Principles of Economics and Management',	'PEM',	3140709,	4,	1,	'2024-02-22 00:09:39',	'2024-02-22 00:09:39');

DROP TABLE IF EXISTS `time_tables`;
CREATE TABLE `time_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `division_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `sem` int NOT NULL,
  `weekday` smallint NOT NULL COMMENT '1 => Monday,2 => Tuesday,3 => Wednesday,4 => Thursday,5 => Friday,6 => Saturday,7 => Sunday',
  `is_lab` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => Lecture,1 => Lab',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `term_start_date` date NOT NULL,
  `term_end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_tables_division_id_foreign` (`division_id`),
  KEY `time_tables_subject_id_foreign` (`subject_id`),
  CONSTRAINT `time_tables_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`),
  CONSTRAINT `time_tables_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  CONSTRAINT `check_end_time_greater_than_start_time` CHECK ((`end_time` > `start_time`)),
  CONSTRAINT `CHK_Day` CHECK (((`weekday` >= 1) and (`weekday` <= 7))),
  CONSTRAINT `CHK_Sem` CHECK (((`weekday` >= 1) and (`weekday` <= 8)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `time_tables` (`id`, `division_id`, `subject_id`, `sem`, `weekday`, `is_lab`, `start_time`, `end_time`, `term_start_date`, `term_end_date`, `created_at`, `updated_at`) VALUES
(416,	1,	13,	4,	1,	1,	'10:30:00',	'12:30:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(417,	1,	13,	4,	1,	0,	'13:00:00',	'15:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(418,	1,	12,	4,	1,	0,	'15:00:00',	'16:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(419,	1,	12,	4,	2,	1,	'10:30:00',	'12:30:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(420,	1,	13,	4,	2,	0,	'13:00:00',	'15:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(421,	1,	15,	4,	2,	0,	'15:00:00',	'17:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(422,	1,	14,	4,	3,	0,	'10:30:00',	'12:30:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(423,	1,	12,	4,	3,	0,	'13:00:00',	'15:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(424,	1,	15,	4,	4,	0,	'13:00:00',	'15:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(425,	1,	16,	4,	4,	0,	'15:00:00',	'16:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(426,	1,	14,	4,	4,	0,	'16:00:00',	'17:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(427,	1,	15,	4,	5,	1,	'10:30:00',	'12:30:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(428,	1,	16,	4,	5,	0,	'13:00:00',	'15:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(429,	1,	14,	4,	5,	0,	'15:00:00',	'16:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48'),
(430,	1,	14,	4,	5,	0,	'16:00:00',	'17:00:00',	'2024-02-01',	'2024-05-25',	'2024-02-22 01:26:48',	'2024-02-22 01:26:48');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin@admin.com',	'$2y$10$AegEa7m4dD3nefZNRH2gQe2aQ3.pA96MY5p3rISpaFMezTvLT.SrS',	NULL,	NULL);

-- 2024-02-23 05:50:02
