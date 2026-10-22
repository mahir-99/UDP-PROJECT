<?php
declare(strict_types=1);

namespace EarthCycle\Repositories;

use EarthCycle\Database\Connection;
use EarthCycle\Models\Center;
use Throwable;

/**
 * EarthCycle Facility Center Repository
 * 
 * Manages access to the 12 Gujarat municipal and community composting hubs,
 * with database persistence and memory fallback.
 * 
 * @package EarthCycle\Repositories
 */
class CenterRepository
{
    private array $bundledCenters;

    public function __construct(array $bundledCenters = [])
    {
        $this->bundledCenters = $bundledCenters;
    }

    /**
     * Retrieve all active centers, merging database rows with bundled fallbacks
     *
     * @return Center[]
     */
    public function all(): array
    {
        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->query('SELECT * FROM centers ORDER BY id ASC');
            $rows = $stmt->fetchAll();

            if (!$rows) {
                return $this->getBundledAsModels();
            }

            $byId = [];
            foreach ($this->bundledCenters as $c) {
                $byId[(int)$c['id']] = $c;
            }

            $results = [];
            foreach ($rows as $row) {
                // Keep Gujarat coverage
                if (!in_array($row['city'], ['Ahmedabad','Surat','Vadodara','Rajkot','Gandhinagar','Bhavnagar','Navsari'], true)) {
                    continue;
                }

                $id = (int)$row['id'];
                $base = $byId[$id] ?? [
                    'badge'  => 'Community Hub',
                    'image'  => 'assets/images/bin.jpg',
                    'status' => 'Operational',
                ];

                $merged = array_merge($base, [
                    'id'       => $id,
                    'name'     => (string)$row['name'],
                    'type'     => (string)$row['type'],
                    'city'     => (string)$row['city'],
                    'address'  => (string)$row['address'],
                    'lat'      => (float)$row['latitude'],
                    'lng'      => (float)$row['longitude'],
                    'phone'    => (string)($row['phone'] ?? ''),
                    'hours'    => (string)($row['operating_hours'] ?? ''),
                    'accepted' => (string)($row['accepted_waste'] ?? ''),
                    'capacity' => (string)($row['capacity'] ?? ''),
                ]);

                $results[] = new Center($merged);
            }

            return !empty($results) ? $results : $this->getBundledAsModels();
        } catch (Throwable $e) {
            error_log('CenterRepository using bundled fallback: ' . $e->getMessage());
            return $this->getBundledAsModels();
        }
    }

    /**
     * Retrieve centers as client-ready arrays
     *
     * @return array[]
     */
    public function allAsArrays(): array
    {
        return array_map(static fn(Center $c) => $c->toArray(), $this->all());
    }

    /**
     * Find a center by ID
     *
     * @param int $id
     * @return Center|null
     */
    public function findById(int $id): ?Center
    {
        foreach ($this->all() as $center) {
            if ($center->getId() === $id) {
                return $center;
            }
        }
        return null;
    }

    /**
     * Filter centers by city name
     *
     * @param string $city City name or 'All'
     * @return Center[]
     */
    public function findByCity(string $city): array
    {
        if ($city === 'All' || $city === '') {
            return $this->all();
        }

        return array_values(array_filter(
            $this->all(),
            static fn(Center $c) => strcasecmp($c->getCity(), $city) === 0
        ));
    }

    /**
     * Search centers by keyword in name, address, city, or accepted materials
     *
     * @param string $keyword
     * @param string $city
     * @return Center[]
     */
    public function search(string $keyword, string $city = 'All'): array
    {
        $q = strtolower(trim($keyword));
        $centers = $this->findByCity($city);

        if ($q === '') {
            return $centers;
        }

        return array_values(array_filter($centers, static function (Center $c) use ($q) {
            $haystack = strtolower($c->getName() . ' ' . $c->getAddress() . ' ' . $c->getCity() . ' ' . $c->getAccepted());
            return strpos($haystack, $q) !== false;
        }));
    }

    /**
     * Find nearest facilities to given GPS coordinates
     *
     * @param float $lat
     * @param float $lng
     * @param int $limit
     * @return array Array of ['center' => Center, 'distance_km' => float]
     */
    public function findNearest(float $lat, float $lng, int $limit = 3): array
    {
        $list = [];
        foreach ($this->all() as $center) {
            $dist = $center->distanceTo($lat, $lng);
            $list[] = [
                'center'      => $center,
                'distance_km' => $dist,
            ];
        }

        usort($list, static fn($a, $b) => $a['distance_km'] <=> $b['distance_km']);
        return array_slice($list, 0, $limit);
    }

    /**
     * Count facilities grouped by city
     *
     * @return array Associative array of city => count
     */
    public function getCountsByCity(): array
    {
        $counts = [];
        foreach ($this->all() as $center) {
            $city = $center->getCity();
            $counts[$city] = ($counts[$city] ?? 0) + 1;
        }
        return $counts;
    }

    /**
     * Convert bundled fallback array into Model instances
     *
     * @return Center[]
     */
    private function getBundledAsModels(): array
    {
        return array_map(static fn(array $item) => new Center($item), $this->bundledCenters);
    }
}
