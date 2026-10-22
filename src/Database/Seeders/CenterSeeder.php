<?php
declare(strict_types=1);

namespace EarthCycle\Database\Seeders;

use EarthCycle\Database\Connection;
use PDO;

/**
 * EarthCycle Gujarat Composting Centers Database Seeder
 * 
 * Inserts the 12 verified municipal composting plants and community drop-off yards
 * with idempotent ON DUPLICATE KEY UPDATE logic.
 * 
 * @package EarthCycle\Database\Seeders
 */
class CenterSeeder
{
    public static function run(?PDO $pdo = null): int
    {
        $pdo = $pdo ?? Connection::getInstance();

        $centers = [
            [
                'id'        => 1,
                'name'      => 'AMC Central Bio-Composting Plant',
                'type'      => 'Municipal Composting Facility',
                'city'      => 'Ahmedabad',
                'address'   => 'Pirana Solid Waste Treatment Complex, Near Behrampura, Ahmedabad, Gujarat 380022',
                'latitude'  => 22.98184,
                'longitude' => 72.58332,
                'phone'     => '+91 79 2539 1811',
                'hours'     => 'Mon - Sat: 08:00 AM - 05:00 PM',
                'accepted'  => 'Vegetable mandi waste, kitchen wet waste, horticulture branches',
                'capacity'  => '300 TPD',
                'services'  => 'Municipal Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 2,
                'name'      => 'Sabarmati Eco Community Compost Yard',
                'type'      => 'Community Composting Center',
                'city'      => 'Ahmedabad',
                'address'   => 'Near Riverfront Park East, Subhash Bridge Approach, Sabarmati, Ahmedabad, Gujarat 380027',
                'latitude'  => 23.07221,
                'longitude' => 72.58554,
                'phone'     => '+91 79 2755 0412',
                'hours'     => 'Mon - Sun: 07:00 AM - 07:00 PM',
                'accepted'  => 'Household kitchen scraps, dry leaves, coconut coir, compost bin overflow',
                'capacity'  => '15 TPD',
                'services'  => 'Free Culture Dist.',
                'status'    => 'Active',
            ],
            [
                'id'        => 3,
                'name'      => 'Vastrapur Urban Bio-Resource Hub',
                'type'      => 'Organic Waste Drop-off',
                'city'      => 'Ahmedabad',
                'address'   => 'Opposite Vastrapur Lake Garden Gate 2, Vastrapur, Ahmedabad, Gujarat 380015',
                'latitude'  => 23.03602,
                'longitude' => 72.52985,
                'phone'     => '+91 98250 14820',
                'hours'     => 'Tue - Sun: 08:00 AM - 06:00 PM',
                'accepted'  => 'Fruit peels, vegetable scraps, shredded garden leaves',
                'capacity'  => '8 TPD',
                'services'  => 'Urban Yard',
                'status'    => 'Active',
            ],
            [
                'id'        => 4,
                'name'      => 'SMC Bhestan Integrated Waste Processing Plant',
                'type'      => 'Municipal Composting Facility',
                'city'      => 'Surat',
                'address'   => 'Bhestan Solid Waste Processing Zone, Dindoli-Bhestan Canal Road, Surat, Gujarat 395023',
                'latitude'  => 21.13524,
                'longitude' => 72.82736,
                'phone'     => '+91 261 242 3751',
                'hours'     => 'Mon - Sat: 08:30 AM - 05:30 PM',
                'accepted'  => 'Segregated wet municipal waste, wholesale grain & mandi organic waste',
                'capacity'  => '250 TPD',
                'services'  => 'Municipal Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 5,
                'name'      => 'Adajan Community Green Composting Station',
                'type'      => 'Community Composting Center',
                'city'      => 'Surat',
                'address'   => 'Anand Mahal Road, Near Community Hall, Adajan, Surat, Gujarat 395009',
                'latitude'  => 21.19692,
                'longitude' => 72.79331,
                'phone'     => '+91 261 278 9910',
                'hours'     => 'Mon - Sun: 07:30 AM - 06:30 PM',
                'accepted'  => 'Residential kitchen waste, garden grass cuttings, dry leaf litter',
                'capacity'  => '12 TPD',
                'services'  => 'Residential Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 6,
                'name'      => 'Vadodara Municipal Atladara Bio-Processing Site',
                'type'      => 'Municipal Composting Facility',
                'city'      => 'Vadodara',
                'address'   => 'Atladara Waste Processing Complex, Padra Road, Vadodara, Gujarat 390012',
                'latitude'  => 22.27083,
                'longitude' => 73.15582,
                'phone'     => '+91 265 243 3116',
                'hours'     => 'Mon - Sat: 09:00 AM - 05:00 PM',
                'accepted'  => 'Bulk wet organic waste, market vegetable remains, tree pruning debris',
                'capacity'  => '200 TPD',
                'services'  => 'Municipal Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 7,
                'name'      => 'Sayaji Baug Botanical Composting Yard',
                'type'      => 'Community Composting Center',
                'city'      => 'Vadodara',
                'address'   => 'Sayaji Baug Garden Campus, Dak Bungalow Road, Vadodara, Gujarat 390001',
                'latitude'  => 22.31295,
                'longitude' => 73.18942,
                'phone'     => '+91 265 279 5522',
                'hours'     => 'Daily: 07:00 AM - 06:00 PM',
                'accepted'  => 'Dry leaves, temple flowers, pruned park branches, fruit peels',
                'capacity'  => '10 TPD',
                'services'  => 'Botanical Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 8,
                'name'      => 'Rajkot Municipal Corporation Aji Bio-Compost Yard',
                'type'      => 'Municipal Composting Facility',
                'city'      => 'Rajkot',
                'address'   => 'Near Aji Dam Industrial Zone, Bhavnagar Highway, Rajkot, Gujarat 360003',
                'latitude'  => 22.2612,
                'longitude' => 70.81974,
                'phone'     => '+91 281 222 1730',
                'hours'     => 'Mon - Sat: 08:30 AM - 05:00 PM',
                'accepted'  => 'City wet waste, vegetable market surplus, agricultural trimmings',
                'capacity'  => '180 TPD',
                'services'  => 'Municipal Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 9,
                'name'      => 'Race Course Community Eco-Compost Project',
                'type'      => 'Community Composting Center',
                'city'      => 'Rajkot',
                'address'   => 'Race Course Ring Road, Near Children Traffic Park, Rajkot, Gujarat 360001',
                'latitude'  => 22.29821,
                'longitude' => 70.79373,
                'phone'     => '+91 281 245 8820',
                'hours'     => 'Mon - Sun: 07:00 AM - 07:00 PM',
                'accepted'  => 'Domestic kitchen greens, lawn trimmings, coffee grounds and tea leaves',
                'capacity'  => '6 TPD',
                'services'  => 'Park Center',
                'status'    => 'Active',
            ],
            [
                'id'        => 10,
                'name'      => 'Gandhinagar Green Capital Sector 28 Facility',
                'type'      => 'Municipal Composting Facility',
                'city'      => 'Gandhinagar',
                'address'   => 'Sector 28 GIDC Waste Management Zone, Gandhinagar, Gujarat 382028',
                'latitude'  => 23.25991,
                'longitude' => 72.65692,
                'phone'     => '+91 79 2322 0440',
                'hours'     => 'Mon - Sat: 09:00 AM - 05:00 PM',
                'accepted'  => 'Institutional cafeteria scraps, government garden leaves, green trimmings',
                'capacity'  => '120 TPD',
                'services'  => 'Capital Eco Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 11,
                'name'      => 'Nari Road Bio-Compost Treatment Facility',
                'type'      => 'Municipal Composting Facility',
                'city'      => 'Bhavnagar',
                'address'   => 'Nari Road Solid Waste Yard, Near Ring Road, Bhavnagar, Gujarat 364004',
                'latitude'  => 21.78502,
                'longitude' => 72.13801,
                'phone'     => '+91 278 242 4811',
                'hours'     => 'Mon - Sat: 09:00 AM - 05:00 PM',
                'accepted'  => 'Segregated residential food waste, vegetable cutting waste',
                'capacity'  => '90 TPD',
                'services'  => 'Municipal Hub',
                'status'    => 'Active',
            ],
            [
                'id'        => 12,
                'name'      => 'Navsari Krishi Vigyan Composting Center',
                'type'      => 'Community Composting Center',
                'city'      => 'Navsari',
                'address'   => 'Navsari Agricultural University Campus, Eru Char Rasta, Navsari, Gujarat 396450',
                'latitude'  => 20.92745,
                'longitude' => 72.90562,
                'phone'     => '+91 2637 282 771',
                'hours'     => 'Mon - Sat: 09:00 AM - 05:00 PM',
                'accepted'  => 'Farm crop residues, cow dung slurry, household food scraps',
                'capacity'  => '25 TPD',
                'services'  => 'Agri University',
                'status'    => 'Active',
            ],
        ];

        $sql = "INSERT INTO `centers` (`id`,`name`,`type`,`city`,`address`,`latitude`,`longitude`,`phone`,`operating_hours`,`accepted_waste`,`capacity`,`services`,`status`)
                VALUES (:id, :name, :type, :city, :address, :lat, :lng, :phone, :hours, :accepted, :capacity, :services, :status)
                ON DUPLICATE KEY UPDATE
                    `name`=VALUES(`name`), `type`=VALUES(`type`), `city`=VALUES(`city`),
                    `address`=VALUES(`address`), `latitude`=VALUES(`latitude`), `longitude`=VALUES(`longitude`),
                    `phone`=VALUES(`phone`), `operating_hours`=VALUES(`operating_hours`),
                    `accepted_waste`=VALUES(`accepted_waste`), `capacity`=VALUES(`capacity`),
                    `services`=VALUES(`services`), `status`=VALUES(`status`)";

        $stmt = $pdo->prepare($sql);
        $count = 0;

        foreach ($centers as $c) {
            $stmt->execute([
                ':id'       => $c['id'],
                ':name'     => $c['name'],
                ':type'     => $c['type'],
                ':city'     => $c['city'],
                ':address'  => $c['address'],
                ':lat'      => $c['latitude'],
                ':lng'      => $c['longitude'],
                ':phone'    => $c['phone'],
                ':hours'    => $c['hours'],
                ':accepted' => $c['accepted'],
                ':capacity' => $c['capacity'],
                ':services' => $c['services'],
                ':status'   => $c['status'],
            ]);
            $count++;
        }

        return $count;
    }
}
