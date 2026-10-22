<?php
declare(strict_types=1);

namespace EarthCycle\Models;

/**
 * EarthCycle Gujarat Composting Facility Model
 * 
 * Represents a verified municipal bio-composting plant, decentralized drop-off station,
 * or community composting yard across Gujarat (Ahmedabad, Surat, Vadodara, Rajkot, etc.).
 * 
 * @package EarthCycle\Models
 */
class Center
{
    private int $id;
    private string $name;
    private string $type;
    private string $city;
    private string $address;
    private float $lat;
    private float $lng;
    private string $phone;
    private string $hours;
    private string $accepted;
    private string $capacity;
    private string $badge;
    private string $image;
    private string $status;
    private string $services;

    public function __construct(array $attributes = [])
    {
        $this->id = (int)($attributes['id'] ?? 0);
        $this->name = (string)($attributes['name'] ?? '');
        $this->type = (string)($attributes['type'] ?? 'Municipal Composting Facility');
        $this->city = (string)($attributes['city'] ?? 'Ahmedabad');
        $this->address = (string)($attributes['address'] ?? '');
        $this->lat = (float)($attributes['lat'] ?? $attributes['latitude'] ?? 0.0);
        $this->lng = (float)($attributes['lng'] ?? $attributes['longitude'] ?? 0.0);
        $this->phone = (string)($attributes['phone'] ?? '');
        $this->hours = (string)($attributes['hours'] ?? $attributes['operating_hours'] ?? '');
        $this->accepted = (string)($attributes['accepted'] ?? $attributes['accepted_waste'] ?? '');
        $this->capacity = (string)($attributes['capacity'] ?? '');
        $this->badge = (string)($attributes['badge'] ?? 'Verified Hub');
        $this->image = (string)($attributes['image'] ?? 'assets/images/bin.jpg');
        $this->status = (string)($attributes['status'] ?? 'Operational');
        $this->services = (string)($attributes['services'] ?? 'Drop-off station');
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getType(): string { return $this->type; }
    public function getCity(): string { return $this->city; }
    public function getAddress(): string { return $this->address; }
    public function getLat(): float { return $this->lat; }
    public function getLng(): float { return $this->lng; }
    public function getPhone(): string { return $this->phone; }
    public function getHours(): string { return $this->hours; }
    public function getAccepted(): string { return $this->accepted; }
    public function getCapacity(): string { return $this->capacity; }
    public function getBadge(): string { return $this->badge; }
    public function getImage(): string { return $this->image; }
    public function getStatus(): string { return $this->status; }
    public function getServices(): string { return $this->services; }

    /**
     * Compute Haversine distance in kilometers from given coordinate
     *
     * @param float $targetLat
     * @param float $targetLng
     * @return float Distance in kilometers rounded to 2 decimals
     */
    public function distanceTo(float $targetLat, float $targetLng): float
    {
        $earthRadiusKm = 6371.0;
        $dLat = deg2rad($targetLat - $this->lat);
        $dLng = deg2rad($targetLng - $this->lng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($this->lat)) * cos(deg2rad($targetLat)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadiusKm * $c, 2);
    }

    /**
     * Generate Google Maps directions URL
     *
     * @return string
     */
    public function getDirectionsUrl(): string
    {
        $dest = urlencode("{$this->name}, {$this->address}");
        return "https://www.google.com/maps/dir/?api=1&destination={$dest}";
    }

    /**
     * Convert model instance to associative array matching client expectations
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'type'     => $this->type,
            'city'     => $this->city,
            'address'  => $this->address,
            'lat'      => $this->lat,
            'lng'      => $this->lng,
            'phone'    => $this->phone,
            'hours'    => $this->hours,
            'accepted' => $this->accepted,
            'capacity' => $this->capacity,
            'badge'    => $this->badge,
            'image'    => $this->image,
            'status'   => $this->status,
            'services' => $this->services,
        ];
    }
}
