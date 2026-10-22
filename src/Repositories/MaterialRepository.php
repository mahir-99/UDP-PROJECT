<?php
declare(strict_types=1);

namespace EarthCycle\Repositories;

use EarthCycle\Models\Material;

/**
 * EarthCycle Organic Materials Repository
 * 
 * Provides access and filtering for the 18 organic composting materials,
 * covering Greens (Nitrogen), Browns (Carbon), and Prohibited items.
 * 
 * @package EarthCycle\Repositories
 */
class MaterialRepository
{
    private array $materials;

    public function __construct(array $materials = [])
    {
        $this->materials = $materials;
    }

    /**
     * Get all materials as Model instances
     *
     * @return Material[]
     */
    public function all(): array
    {
        return array_map(static fn(array $m) => new Material($m), $this->materials);
    }

    /**
     * Filter materials by type (Green, Brown, Prohibited)
     *
     * @param string $type
     * @return Material[]
     */
    public function findByType(string $type): array
    {
        if ($type === 'All' || $type === '') {
            return $this->all();
        }

        return array_values(array_filter(
            $this->all(),
            static fn(Material $m) => strcasecmp($m->getType(), $type) === 0
        ));
    }

    /**
     * Search materials by query string
     *
     * @param string $query
     * @param string $type
     * @return Material[]
     */
    public function search(string $query, string $type = 'All'): array
    {
        $q = strtolower(trim($query));
        $list = $this->findByType($type);

        if ($q === '') {
            return $list;
        }

        return array_values(array_filter($list, static function (Material $m) use ($q) {
            $haystack = strtolower($m->getName() . ' ' . $m->getDesc() . ' ' . $m->getTip());
            return strpos($haystack, $q) !== false;
        }));
    }

    /**
     * Count items in each category
     *
     * @return array
     */
    public function getCategoryCounts(): array
    {
        $counts = ['Green' => 0, 'Brown' => 0, 'Prohibited' => 0];
        foreach ($this->all() as $m) {
            $t = $m->getType();
            if (isset($counts[$t])) {
                $counts[$t]++;
            }
        }
        return $counts;
    }
}
