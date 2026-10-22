-- =====================================================================
-- EarthCycle Living Soil Network Gujarat — Analytical SQL Queries
-- Useful for academic defense, evaluators, and system reporting
-- =====================================================================

USE `composting_db`;

-- 1. Total Daily Processing Capacity grouped by Gujarat Municipal Area
SELECT 
    `city`,
    COUNT(`id`) AS `total_hubs`,
    GROUP_CONCAT(`name` ORDER BY `id` SEPARATOR ', ') AS `facility_names`
FROM `centers`
WHERE `status` = 'Active'
GROUP BY `city`
ORDER BY `total_hubs` DESC;

-- 2. Average Citizen Rating and Feedback Submission Count by Category
SELECT 
    `category`,
    COUNT(`id`) AS `submission_count`,
    ROUND(AVG(`rating`), 2) AS `average_rating`,
    MIN(`rating`) AS `min_rating`,
    MAX(`rating`) AS `max_rating`
FROM `feedback`
GROUP BY `category`
ORDER BY `average_rating` DESC;

-- 3. City-Wise Citizen Participation Matrix
SELECT 
    `city`,
    COUNT(`id`) AS `total_reports`,
    ROUND(AVG(`rating`), 1) AS `city_avg_rating`
FROM `feedback`
GROUP BY `city`
ORDER BY `total_reports` DESC;

-- 4. Organic Composting Materials Count by Biological Classification
SELECT 
    `type` AS `biological_type`,
    COUNT(`id`) AS `material_count`
FROM `materials`
GROUP BY `type`
ORDER BY `material_count` DESC;

-- 5. Fast-Decomposing Nitrogen Greens for Quick Soil Enrichment
SELECT 
    `name`,
    `cn_ratio`,
    `decomposition_speed`,
    `pro_tip`
FROM `materials`
WHERE `type` = 'Green' AND `decomposition_speed` LIKE '%Fast%'
ORDER BY `name` ASC;

-- 6. High-Carbon Browns for Odor Mitigation & Monsoon Moisture Buffering
SELECT 
    `name`,
    `cn_ratio`,
    `decomposition_speed`,
    `pro_tip`
FROM `materials`
WHERE `type` = 'Brown'
ORDER BY `id` ASC;

-- 7. Municipal Composting Hubs with Phone Helplines for Public Inquiries
SELECT 
    `name`,
    `city`,
    `phone`,
    `operating_hours`
FROM `centers`
WHERE `phone` IS NOT NULL AND `phone` != ''
ORDER BY `city` ASC, `name` ASC;
