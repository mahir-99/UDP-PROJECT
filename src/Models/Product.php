<?php
declare(strict_types=1);

namespace EarthCycle\Models;

/**
 * EarthCycle Composting Hardware & Supply Model
 * 
 * Represents curated composting gear tested for Gujarat's environmental conditions.
 * 
 * @package EarthCycle\Models
 */
class Product
{
    private int $id;
    private string $name;
    private string $category;
    private string $image;
    private string $description;
    private string $highlight;
    private string $capacity;
    private string $seller;
    private string $buyUrl;

    public function __construct(array $attributes = [])
    {
        $this->id = (int)($attributes['id'] ?? 0);
        $this->name = (string)($attributes['name'] ?? '');
        $this->category = (string)($attributes['category'] ?? 'Equipment');
        $this->image = (string)($attributes['image'] ?? 'assets/images/bin.jpg');
        $this->description = (string)($attributes['description'] ?? '');
        $this->highlight = (string)($attributes['highlight'] ?? 'Tested');
        $this->capacity = (string)($attributes['capacity'] ?? '');
        $this->seller = (string)($attributes['seller'] ?? 'Verified Seller');
        $this->buyUrl = (string)($attributes['buyUrl'] ?? '#');
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getCategory(): string { return $this->category; }
    public function getImage(): string { return $this->image; }
    public function getDescription(): string { return $this->description; }
    public function getHighlight(): string { return $this->highlight; }
    public function getCapacity(): string { return $this->capacity; }
    public function getSeller(): string { return $this->seller; }
    public function getBuyUrl(): string { return $this->buyUrl; }

    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'category'    => $this->category,
            'image'       => $this->image,
            'description' => $this->description,
            'highlight'   => $this->highlight,
            'capacity'    => $this->capacity,
            'seller'      => $this->seller,
            'buyUrl'      => $this->buyUrl,
        ];
    }
}
