<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Soil Microbial Ecology & Biochemistry Service
 * 
 * Documents microbial biological succession (Psychrophilic 10-20°C,
 * Mesophilic 20-40°C, and Thermophilic 40-65°C) and humic acid synthesis.
 * 
 * @package EarthCycle\Services
 */
class SoilBiologyService
{
    /**
     * Get thermal succession stage details based on internal pile temperature
     *
     * @param float $temperatureCelsius
     * @return array
     */
    public static function getMicrobialStage(float $temperatureCelsius): array
    {
        $temp = round($temperatureCelsius, 1);

        if ($temp < 20.0) {
            return [
                'stage'            => 'Psychrophilic Phase (Initial Colonization)',
                'temp_range'       => '10°C – 20°C',
                'dominant_species' => 'Cold-tolerant bacteria and pioneer molds.',
                'activity'         => 'Slow metabolic breakdown of simple soluble sugars and amino acids.',
                'sanitization'     => 'Minimal pathogen destruction.',
                'action_advice'    => 'Add nitrogen catalysts (green cuttings, tea grounds) to accelerate microbial multiplication.',
            ];
        }

        if ($temp <= 40.0) {
            return [
                'stage'            => 'Mesophilic Phase (Rapid Multiplication)',
                'temp_range'       => '20°C – 40°C',
                'dominant_species' => 'Pseudomonas, Bacillus, and fungal decomposers.',
                'activity'         => 'Intense microbial digestion generating metabolic heat; organic acids lower pH temporarily to 5.5-6.0.',
                'sanitization'     => 'Moderate pathogen neutralization underway.',
                'action_advice'    => 'Ensure adequate oxygen; rapid aerobic respiration consumes oxygen within 48 hours.',
            ];
        }

        if ($temp <= 65.0) {
            return [
                'stage'            => 'Thermophilic Phase (Sanitization & Lignin Digestion)',
                'temp_range'       => '40°C – 65°C',
                'dominant_species' => 'Thermus, Bacillus stearothermophilus, and Actinomycetes.',
                'activity'         => 'Breakdown of tough cellulose, hemicellulose, and proteins. pH rises to slightly alkaline 7.5-8.0.',
                'sanitization'     => 'Complete destruction of weed seeds, insect larvae, and human/plant pathogens (E. coli, Salmonella).',
                'action_advice'    => 'Maintain for at least 3-5 days. If temperature exceeds 68°C, turn immediately to avoid killing beneficial thermophiles.',
            ];
        }

        return [
            'stage'            => 'Hyper-Thermal Stress Range',
            'temp_range'       => '> 65°C',
            'dominant_species' => 'Extremophiles only.',
            'activity'         => 'Beneficial microbes risk sterilization from excessive metabolic heat.',
            'sanitization'     => 'Complete sterilizing heat.',
            'action_advice'    => 'Turn and aerate the pile immediately; incorporate ambient air to cool core to 55°C.',
        ];
    }

    /**
     * Physical indicators that living compost is fully cured and ready to harvest
     *
     * @return array
     */
    public static function getCuringIndicators(): array
    {
        return [
            'color'         => 'Deep chocolate brown or rich black gold with crumbly forest-floor texture.',
            'odor'          => 'Sweet, earthy petrichor scent (smell of first rain on dry Gujarati soil), caused by Geosmin.',
            'temperature'   => 'Core temperature permanently stabilizes within 5°C of ambient outdoor temperature.',
            'particle_size' => 'Original food scraps and identifiable leaf structures have completely vanished into uniform humus.',
            'ph_level'      => 'Neutral to slightly alkaline pH between 6.8 and 7.5.',
            'germination'   => 'Cress seed bio-assay: seeds germinate happily in sample without leaf burn or stunted roots.',
        ];
    }
}
