<?php
declare(strict_types=1);

namespace EarthCycle\Repositories;

use EarthCycle\Models\GuideStep;

/**
 * EarthCycle Masterclass Guide Repository
 * 
 * Manages access to the 6 phases of composting instructions.
 * 
 * @package EarthCycle\Repositories
 */
class GuideRepository
{
    private array $steps;

    public function __construct(array $steps = [])
    {
        $this->steps = $steps;
    }

    /**
     * Get all guide phases
     *
     * @return GuideStep[]
     */
    public function all(): array
    {
        return array_map(static fn(array $s) => new GuideStep($s), $this->steps);
    }

    /**
     * Find specific step by number (1 to 6)
     *
     * @param int $stepNumber
     * @return GuideStep|null
     */
    public function getStep(int $stepNumber): ?GuideStep
    {
        foreach ($this->all() as $step) {
            if ($step->getId() === $stepNumber) {
                return $step;
            }
        }
        return null;
    }
}
