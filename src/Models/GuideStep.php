<?php
declare(strict_types=1);

namespace EarthCycle\Models;

/**
 * EarthCycle Masterclass Guide Step Model
 * 
 * Represents one of the 6 phases of composting mastery.
 * 
 * @package EarthCycle\Models
 */
class GuideStep
{
    private int $id;
    private string $title;
    private string $category;
    private string $icon;
    private string $duration;
    private string $temp;
    private string $cn;
    private string $summary;

    public function __construct(array $attributes = [])
    {
        $this->id = (int)($attributes['id'] ?? 1);
        $this->title = (string)($attributes['title'] ?? '');
        $this->category = (string)($attributes['category'] ?? 'Phase 01');
        $this->icon = (string)($attributes['icon'] ?? 'box');
        $this->duration = (string)($attributes['duration'] ?? 'Week 1');
        $this->temp = (string)($attributes['temp'] ?? '25-35°C');
        $this->cn = (string)($attributes['cn'] ?? '2:1 Dry:Wet');
        $this->summary = (string)($attributes['summary'] ?? '');
    }

    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getCategory(): string { return $this->category; }
    public function getIcon(): string { return $this->icon; }
    public function getDuration(): string { return $this->duration; }
    public function getTemp(): string { return $this->temp; }
    public function getCn(): string { return $this->cn; }
    public function getSummary(): string { return $this->summary; }

    public function toArray(): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'category' => $this->category,
            'icon'     => $this->icon,
            'duration' => $this->duration,
            'temp'     => $this->temp,
            'cn'       => $this->cn,
            'summary'  => $this->summary,
        ];
    }
}
