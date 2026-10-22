<?php
declare(strict_types=1);

namespace EarthCycle\Services;

/**
 * EarthCycle Indigenous Microorganism & Bio-Culture Accelerator Service
 * 
 * Implements traditional Gujarat microbial formulas (Jeevamrutha, Chhas inoculants,
 * and Bokashi lactic acid fermentations) in pure Core PHP.
 * 
 * @package EarthCycle\Services
 */
class MicrobeCultureService
{
    /**
     * Compute dilution recipe for traditional buttermilk (chhas) bio-accelerator
     *
     * @param float $pileVolumeLiters
     * @return array
     */
    public static function calculateChhasRecipe(float $pileVolumeLiters = 50.0): array
    {
        $vol = max(10.0, min(1000.0, $pileVolumeLiters));
        $sourButtermilkLiters = round($vol * 0.02, 2); // 2% volume
        $waterLiters = round($sourButtermilkLiters * 10.0, 2); // 1:10 dilution
        $jaggeryGrams = round($sourButtermilkLiters * 50.0); // 50g jaggery per liter buttermilk

        return [
            'culture_name'     => 'Fermented Sour Buttermilk (Desi Chhas) Inoculant',
            'pile_volume'      => "{$vol} Liters",
            'ingredients'      => [
                'sour_buttermilk' => "{$sourButtermilkLiters} Liters (sour, unpasteurized)",
                'dilution_water'  => "{$waterLiters} Liters (chlorine-free)",
                'organic_jaggery' => "{$jaggeryGrams} Grams (microbial food substrate)",
            ],
            'fermentation_hrs' => 24,
            'application'      => 'Sprinkle evenly across green layers when turning the pile.',
            'scientific_role'  => 'Introduces robust Lactobacillus acidophilus cultures to suppress pathogenic putrefaction.',
        ];
    }

    /**
     * Compute Bokashi Bran Inoculation Dosage
     *
     * @param float $freshGreensKg
     * @return array
     */
    public static function calculateBokashiDosage(float $freshGreensKg = 2.0): array
    {
        $kg = max(0.5, min(50.0, $freshGreensKg));
        $tablespoons = max(1, (int)round($kg * 1.5));
        $grams = $tablespoons * 15;

        return [
            'method'          => 'Airtight Anaerobic Bokashi Fermentation',
            'fresh_greens'    => "{$kg} kg",
            'bran_dosage'     => "{$tablespoons} tablespoons ({$grams}g) of inoculated Bokashi bran",
            'frequency'       => 'Sprinkle over every fresh addition; compress to expel air pockets.',
            'ferment_period'  => '14 days sealed, followed by 14 days soil integration.',
        ];
    }
}
