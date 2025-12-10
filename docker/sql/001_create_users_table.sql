-- Migration: create users table
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  UNIQUE KEY `uniq_email` (`email`)
  UNIQUE KEY `uniq_username` (`username`),
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
CREATE TABLE `users` (

-- Run this in Adminer (SQL tab) or via your migration runner

