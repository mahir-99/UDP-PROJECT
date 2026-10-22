<?php
declare(strict_types=1);

namespace EarthCycle\Models;

/**
 * EarthCycle Organic Material Model
 * 
 * Represents an organic composting input classified into Green (Nitrogen),
 * Brown (Carbon), or Prohibited, complete with C:N ratios and decomposition behavior.
 * 
 * @package EarthCycle\Models
 */
class Material
{
    private string $name;
    private string $type; // 'Green', 'Brown', or 'Prohibited'
    private string $cn;
    private string $speed;
    private string $desc;
    private string $tip;

    public function __construct(array $attributes = [])
    {
        $this->name = (string)($attributes['name'] ?? '');
        $this->type = (string)($attributes['type'] ?? 'Green');
        $this->cn = (string)($attributes['cn'] ?? '20:1');
        $this->speed = (string)($attributes['speed'] ?? 'Fast');
        $this->desc = (string)($attributes['desc'] ?? '');
        $this->tip = (string)($attributes['tip'] ?? '');
    }

    public function getName(): string { return $this->name; }
    public function getType(): string { return $this->type; }
    public function getCn(): string { return $this->cn; }
    public function getSpeed(): string { return $this->speed; }
    public function getDesc(): string { return $this->desc; }
    public function getTip(): string { return $this->tip; }

    public function isGreen(): bool { return $this->type === 'Green'; }
    public function isBrown(): bool { return $this->type === 'Brown'; }
    public function isProhibited(): bool { return $this->type === 'Prohibited'; }

    /**
     * Parse numerical carbon-to-nitrogen ratio
     * e.g., "30:1" returns 30.0
     *
     * @return float
     */
    public function getCarbonRatio(): float
    {
        if (preg_match('/^(\d+)/', $this->cn, $matches)) {
            return (float)$matches[1];
        }
        return 25.0;
    }

    public function toArray(): array
    {
        return [
            'name'  => $this->name,
            'type'  => $this->type,
            'cn'    => $this->cn,
            'speed' => $this->speed,
            'desc'  => $this->desc,
            'tip'   => $this->tip,
        ];
    }
}
