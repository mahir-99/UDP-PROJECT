<?php
declare(strict_types=1);

namespace EarthCycle\Repositories;

use EarthCycle\Models\Product;

/**
 * EarthCycle Equipment & Hardware Repository
 * 
 * Manages access to vetted composting bins, aerators, sifters, and thermometers.
 * 
 * @package EarthCycle\Repositories
 */
class ProductRepository
{
    private array $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    /**
     * Get all products as Model instances
     *
     * @return Product[]
     */
    public function all(): array
    {
        return array_map(static fn(array $p) => new Product($p), $this->products);
    }

    /**
     * Find product by ID
     *
     * @param int $id
     * @return Product|null
     */
    public function findById(int $id): ?Product
    {
        foreach ($this->all() as $prod) {
            if ($prod->getId() === $id) {
                return $prod;
            }
        }
        return null;
    }

    /**
     * Filter by category
     *
     * @param string $category
     * @return Product[]
     */
    public function findByCategory(string $category): array
    {
        return array_values(array_filter(
            $this->all(),
            static fn(Product $p) => strcasecmp($p->getCategory(), $category) === 0
        ));
    }
}
