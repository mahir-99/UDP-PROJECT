<?php
declare(strict_types=1);

namespace EarthCycle\Database\Seeders;

use EarthCycle\Database\Connection;
use PDO;

/**
 * EarthCycle Composting Hardware & Equipment Database Seeder
 * 
 * Inserts the curated composting hardware items into MySQL.
 * 
 * @package EarthCycle\Database\Seeders
 */
class ProductSeeder
{
    public static function run(?PDO $pdo = null): int
    {
        $pdo = $pdo ?? Connection::getInstance();

        $pdo->exec("CREATE TABLE IF NOT EXISTS `products` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `category` VARCHAR(100) NOT NULL,
            `image` VARCHAR(255) NOT NULL,
            `description` TEXT NOT NULL,
            `highlight` VARCHAR(100) NOT NULL,
            `capacity` VARCHAR(100) NOT NULL,
            `seller` VARCHAR(100) NOT NULL,
            `buy_url` VARCHAR(500) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            INDEX `idx_prod_category` (`category`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $products = [
            [1, 'Bio-Enzyme Accelerated Terracotta Composter (3-Tier)', 'Terracotta Systems', 'assets/images/bin.jpg', 'Stackable terracotta clay pots with micro-porous aeration for balcony composting in Gujarat apartments.', 'Best for Balconies', '45 Liters', 'Daily Dump India', 'https://dailydump.org'],
            [2, 'Dual-Chamber Rotating Aerobic Compost Tumbler', 'Outdoor Tumblers', 'assets/images/tumbler.jpg', 'Heavy-duty UV-stabilized rotational composter with dual chambers for continuous compost harvesting.', 'Fast 4-Week Cycle', '160 Liters', 'TrustBasket India', 'https://trustbasket.com'],
            [3, 'Airtight Odor-Free Bokashi Indoor Fermentation Bucket', 'Kitchen Systems', 'assets/images/bokashi.jpg', 'Air-sealed anaerobic fermentation bucket with drainage spigot for nutrient-dense liquid compost tea extraction.', 'Odor-Free Indoor', '15 Liters', 'Bokashi India', 'https://bokashi.in'],
            [4, 'Long-Stem Stainless Steel Compost Thermometer (0-100°C)', 'Monitoring Tools', 'assets/images/thermometer.jpg', '20-inch dial probe thermometer for monitoring thermophilic heat levels inside the decomposing core.', 'Precision Sensor', '20-Inch Probe', 'AgriTools Gujarat', 'https://amazon.in'],
            [5, 'Spiral Ergonomic Compost Aerator & Turning Tool', 'Turning Hardware', 'assets/images/aerator.jpg', 'Corkscrew-design stainless steel auger for effortless core aeration without disturbing bin structure.', 'Zero Back Strain', '90 cm Shaft', 'Ugaoo Garden Care', 'https://ugaoo.com'],
            [6, 'Heavy-Duty Galvanized Wire Rotary Compost Sifter (1/4 Inch)', 'Harvesting Tools', 'assets/images/sifter.jpg', 'Durable steel mesh sieve for separating coarse woody carbon from mature black living humus soil.', 'Ultra-Fine Sieve', '40 cm Diameter', 'Kraft Seeds', 'https://kraftseeds.com'],
        ];

        $sql = "INSERT INTO `products` (`id`, `name`, `category`, `image`, `description`, `highlight`, `capacity`, `seller`, `buy_url`)
                VALUES (:id, :name, :cat, :img, :desc, :hi, :cap, :seller, :url)
                ON DUPLICATE KEY UPDATE
                    `name`=VALUES(`name`), `category`=VALUES(`category`),
                    `image`=VALUES(`image`), `description`=VALUES(`description`),
                    `highlight`=VALUES(`highlight`), `capacity`=VALUES(`capacity`),
                    `seller`=VALUES(`seller`), `buy_url`=VALUES(`buy_url`)";

        $stmt = $pdo->prepare($sql);
        $count = 0;
        foreach ($products as $p) {
            $stmt->execute([
                ':id'     => $p[0],
                ':name'   => $p[1],
                ':cat'    => $p[2],
                ':img'    => $p[3],
                ':desc'   => $p[4],
                ':hi'     => $p[5],
                ':cap'    => $p[6],
                ':seller' => $p[7],
                ':url'    => $p[8],
            ]);
            $count++;
        }

        return $count;
    }
}
