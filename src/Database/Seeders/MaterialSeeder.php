<?php
declare(strict_types=1);

namespace EarthCycle\Database\Seeders;

use EarthCycle\Database\Connection;
use PDO;

/**
 * EarthCycle Organic Composting Materials Database Seeder
 * 
 * Inserts the 18 organic composting materials into the database.
 * 
 * @package EarthCycle\Database\Seeders
 */
class MaterialSeeder
{
    public static function run(?PDO $pdo = null): int
    {
        $pdo = $pdo ?? Connection::getInstance();

        // Create table if not exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS `materials` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(150) NOT NULL,
            `type` ENUM('Green', 'Brown', 'Prohibited') NOT NULL,
            `cn_ratio` VARCHAR(50) NOT NULL,
            `decomposition_speed` VARCHAR(50) NOT NULL,
            `description` TEXT NOT NULL,
            `pro_tip` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uniq_mat_name` (`name`),
            INDEX `idx_mat_type` (`type`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $materials = [
            ['Fruit & Vegetable Peels', 'Green', '15:1 – 20:1', 'Fast (1-2 wks)', 'Kitchen scraps, gourd rinds, tomato skins, coriander stems.', 'Chop large rinds into 1-inch squares for 3x faster microbial digestion.'],
            ['Used Tea Leaves & Coffee Grounds', 'Green', '20:1', 'Fast (1-2 wks)', 'Chai patti residue and brewed ground coffee rich in available nitrogen.', 'Rinse milky tea grounds thoroughly with water before adding to compost.'],
            ['Fresh Lawn Trimmings & Garden Greens', 'Green', '18:1 – 22:1', 'Fast (3-5 days)', 'Lawn mower grass clippings and green weed shoots before seed formation.', 'Spread thin; thick wet grass clumps compact and turn anaerobic in 48 hours.'],
            ['Crushed Eggshells', 'Green', 'Mineral Buffer', 'Slow (6-8 wks)', 'Calcium carbonate mineral buffer from domestic kitchens.', 'Pound into fine powder using mortar and pestle to neutralize organic acidity.'],
            ['Stale Bread & Roti Crusts', 'Green', '25:1', 'Moderate (2 wks)', 'Leftover dry whole wheat chapatis, rotis, and preservative-free bread crusts.', 'Tear into small flakes and bury at the center of the pile away from flies.'],
            ['Overripe Pulses & Soaked Dal Residue', 'Green', '12:1', 'Fast (4-7 days)', 'Protein-rich legume rinsings, sprout discards, boiled dal residue.', 'Use in small quantities; high nitrogen requires immediate 3x brown cover.'],
            ['Dry Fallen Neem & Peepal Leaves', 'Brown', '40:1 – 60:1', 'Moderate (3-5 wks)', 'Crisp dry leaves gathered from Gujarat municipal sidewalks and garden terraces.', 'Crush by hand before layering; neem acts as a natural biological insect repellent.'],
            ['Shredded Corrugated Cardboard', 'Brown', '350:1', 'Moderate (4-6 wks)', 'Unprinted delivery cardboard, egg cartons, and brown grocery paper bags.', 'Soak in bucket for 5 minutes then shred into strips for ideal air pocket pockets.'],
            ['Coconut Coir & Husk Dust', 'Brown', '100:1', 'Moderate (4 wks)', 'Coir fibers and pith from fresh coconut water vendors across Gujarat.', 'Excellent moisture accumulator; maintains 50% humidity during 44°C summer.'],
            ['Clean Untreated Wood Sawdust', 'Brown', '400:1', 'Slow (8-12 wks)', 'Fine shavings from untreated carpenter wood (no varnish or laminates).', 'Sprinkle lightly; dense wood dust compacts into water-repellent layers if clotted.'],
            ['Dry Sugarcane Bagasse', 'Brown', '150:1', 'Moderate (4-6 wks)', 'Pressed cane stalks from roadside juice vendors, fibrous and porous.', 'Cut into 3-inch pieces; provides unmatched aeration structural integrity.'],
            ['Wood Ashes from Firewood Chulhas', 'Brown', '25:1 (Alkaline)', 'Instant dissolve', 'Cold wood ash rich in potassium and potash nutrients.', 'Use sparsely (max 1 cup per 20L compost) to avoid spiking pH above 8.5.'],
            ['Dairy, Paneer & Cheese Residues', 'Prohibited', 'Harmful', 'Putrefies', 'Milk cream, ghee remnants, curd runoff, and processed cheese cubes.', 'Rancid butterfats coat organic matter, block oxygen, and attract rodents.'],
            ['Cooked Meat, Fish & Bones', 'Prohibited', 'Severe Vector', 'Putrefies', 'Animal bones, chicken skin, fish viscera, and tallow gravy.', 'Causes virulent putrefactive odors, maggot infestations, and health risks.'],
            ['Pet Waste (Dog & Cat Feces)', 'Prohibited', 'Bio-Hazard', 'Pathogenic', 'Animal excrement containing Toxoplasma gondii parasites and pathogens.', 'Dangerous pathogens survive typical backyard temperatures; never put in garden compost.'],
            ['Plastic, Foils & Glossy Prints', 'Prohibited', 'Non-biodegradable', 'Permanent', 'Synthetic courier envelopes, plastic laminates, and shiny magazines.', 'Microplastics poison living soil food webs and release toxic chemical plasticizers.'],
            ['Diseased Plants & Blight Vines', 'Prohibited', 'Spore Carrier', 'Infectious', 'Tomato plants infected with fungal blight, powdery mildew, or viral leaf curl.', 'Fungal spores survive in compost and will reinfect subsequent crop seasons.'],
            ['Chemically Treated or Painted Wood', 'Prohibited', 'Toxic Chemicals', 'Leaches Toxins', 'Plywood scraps, pressure-treated lumber with copper/arsenic, oil painted wood.', 'Heavy metals and chemical binders kill aerobic bacteria and worms.'],
        ];

        $sql = "INSERT INTO `materials` (`name`, `type`, `cn_ratio`, `decomposition_speed`, `description`, `pro_tip`)
                VALUES (:name, :type, :cn, :speed, :desc, :tip)
                ON DUPLICATE KEY UPDATE
                    `type`=VALUES(`type`), `cn_ratio`=VALUES(`cn_ratio`),
                    `decomposition_speed`=VALUES(`decomposition_speed`),
                    `description`=VALUES(`description`), `pro_tip`=VALUES(`pro_tip`)";

        $stmt = $pdo->prepare($sql);
        $count = 0;
        foreach ($materials as $m) {
            $stmt->execute([
                ':name'  => $m[0],
                ':type'  => $m[1],
                ':cn'    => $m[2],
                ':speed' => $m[3],
                ':desc'  => $m[4],
                ':tip'   => $m[5],
            ]);
            $count++;
        }

        return $count;
    }
}
