<?php
declare(strict_types=1);

namespace EarthCycle\Tests;

use EarthCycle\Services\ValidationService;

class ValidationTest
{
    public static function run(): array
    {
        $tests = 0;
        $passed = 0;

        // Test 1: Valid form data passes
        $tests++;
        $validData = [
            'name'     => 'Amit Shah',
            'email'    => 'amit@example.com',
            'city'     => 'Ahmedabad',
            'rating'   => 5,
            'category' => 'Home Compost Experience',
            'message'  => 'Great balcony compost setup in Vastrapur!',
        ];
        $val = ValidationService::make($validData)
            ->required('name')
            ->email('email')
            ->stringLength('name', 2, 100)
            ->integerRange('rating', 1, 5);

        if ($val->passes()) {
            $passed++;
        }

        // Test 2: Invalid email fails
        $tests++;
        $invalidEmail = ['email' => 'not-an-email'];
        $valFail = ValidationService::make($invalidEmail)->email('email');
        if ($valFail->fails()) {
            $passed++;
        }

        // Test 3: Rating range check
        $tests++;
        $outOfRange = ['rating' => 10];
        $valRange = ValidationService::make($outOfRange)->integerRange('rating', 1, 5);
        if ($valRange->fails()) {
            $passed++;
        }

        return ['name' => 'ValidationTest', 'tests' => $tests, 'passed' => $passed];
    }
}
