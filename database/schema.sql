-- =====================================================================
-- EarthCycle Living Soil Network Gujarat — Database Schema
-- Version: 2.0.0
-- Compatible with MySQL 8.0+ and MariaDB 10.4+ (XAMPP / Production)
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `composting_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `composting_db`;

-- ---------------------------------------------------------------------
-- Table: centers
-- Master directory of municipal composting facilities and community drop-off stations
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `centers`;
CREATE TABLE `centers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'Official center or plant name',
  `type` VARCHAR(100) NOT NULL COMMENT 'Facility classification (Municipal/Community)',
  `city` VARCHAR(100) NOT NULL COMMENT 'Gujarat municipal corporation area',
  `address` VARCHAR(500) NOT NULL COMMENT 'Full postal street address',
  `latitude` DECIMAL(10, 7) NOT NULL COMMENT 'GPS Latitude coordinate for Google Maps',
  `longitude` DECIMAL(10, 7) NOT NULL COMMENT 'GPS Longitude coordinate for Google Maps',
  `phone` VARCHAR(50) DEFAULT NULL COMMENT 'Official municipal helpline phone',
  `email` VARCHAR(100) DEFAULT NULL COMMENT 'Administrative contact email',
  `operating_hours` VARCHAR(100) DEFAULT NULL COMMENT 'Public citizen drop-off timings',
  `accepted_waste` TEXT DEFAULT NULL COMMENT 'Comma-separated accepted organic waste streams',
  `capacity` VARCHAR(100) DEFAULT NULL COMMENT 'Daily waste processing capacity in Tonnes Per Day (TPD)',
  `services` TEXT DEFAULT NULL COMMENT 'Free culture distribution, weighbridge, shredding',
  `status` VARCHAR(100) NOT NULL DEFAULT 'Active' COMMENT 'Operational status',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_centers_city` (`city`),
  INDEX `idx_centers_type` (`type`),
  INDEX `idx_centers_coords` (`latitude`, `longitude`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: feedback
-- Persistent citizen reviews, facility status updates and guide reports
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL COMMENT 'Citizen full name',
  `email` VARCHAR(150) NOT NULL COMMENT 'Contact email (masked on public feed)',
  `city` VARCHAR(100) NOT NULL COMMENT 'Gujarat city origin',
  `rating` TINYINT(4) NOT NULL DEFAULT 5 COMMENT 'Star rating 1 to 5',
  `category` VARCHAR(100) NOT NULL DEFAULT 'General Suggestion' COMMENT 'Feedback classification',
  `message` TEXT NOT NULL COMMENT 'Detailed citizen review content',
  `status` VARCHAR(50) NOT NULL DEFAULT 'Approved' COMMENT 'Moderation status',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_feedback_rating` (`rating`),
  INDEX `idx_feedback_city` (`city`),
  INDEX `idx_feedback_category` (`category`),
  INDEX `idx_feedback_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Table: materials
-- Index of compostable greens, browns, and prohibited waste items
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL COMMENT 'Organic material name',
  `type` ENUM('Green', 'Brown', 'Prohibited') NOT NULL COMMENT 'Carbon/Nitrogen category',
  `cn_ratio` VARCHAR(50) NOT NULL COMMENT 'Carbon to Nitrogen chemical ratio',
  `decomposition_speed` VARCHAR(50) NOT NULL COMMENT 'Typical breakdown timeframe',
  `description` TEXT NOT NULL COMMENT 'Common source items',
  `pro_tip` TEXT NOT NULL COMMENT 'Preparation guidance for home composters',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_materials_name` (`name`),
  INDEX `idx_materials_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- View: v_city_capacity_summary
-- Aggregated waste processing capacity by Gujarat city
-- ---------------------------------------------------------------------
CREATE OR REPLACE VIEW `v_city_capacity_summary` AS
SELECT 
    `city`,
    COUNT(`id`) AS `total_facilities`,
    GROUP_CONCAT(`name` SEPARATOR ' | ') AS `facility_list`
FROM `centers`
WHERE `status` = 'Active'
GROUP BY `city`
ORDER BY `total_facilities` DESC;

SET FOREIGN_KEY_CHECKS = 1;
