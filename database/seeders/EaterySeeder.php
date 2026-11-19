<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        $poblacion = District::where('name', 'Poblacion')->firstOrFail();
        $districts = District::all();
        $features = Feature::all();

        // 1. Hand-made eatery
        $myEateryName = 'Carinderia ni Ibanez';
        $myEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $myEateryName,
            'slug' => Str::slug($myEateryName),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $myFeatureIds = Feature::whereIn('name', ['Suki ni Ibanez', 'Budget Meal'])
            ->pluck('id')
            ->all();
        $myEatery->features()->sync($myFeatureIds);

        $myEatery->permit()->create([
            'permit_no' => 'DVO-2026-0505',
            'expires_on' => '2027-05-05',
        ]);

        $myEatery->dishes()->createMany([
            [
                'name' => 'Tinolang Manok',
                'price' => 85.00,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Kinilaw na Tuna',
                'price' => 120.00,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Durian Shake',
                'price' => 75.00,
                'is_bestseller' => false,
            ],
        ]);

        // 2. 14 Factory eateries (11 open, 3 closed)
        $openEateries = Eatery::factory()
            ->count(11)
            ->create([
                'district_id' => fn () => $districts->random()->id,
            ]);

        $closedEateries = Eatery::factory()
            ->count(3)
            ->closed()
            ->create([
                'district_id' => fn () => $districts->random()->id,
            ]);

        $factoryEateries = $openEateries->concat($closedEateries);

        $factoryEateries->each(function (Eatery $eatery, int $index) use ($features) {
            // Ensure at least one factory permit is already expired
            if ($index === 0) {
                Permit::factory()->create([
                    'eatery_id' => $eatery->id,
                    'expires_on' => now()->subMonths(2)->format('Y-m-d'),
                ]);
            } else {
                Permit::factory()->create([
                    'eatery_id' => $eatery->id,
                ]);
            }

            Dish::factory()
                ->count(rand(2, 5))
                ->create([
                    'eatery_id' => $eatery->id,
                ]);

            $randomFeatureIds = $features->random(rand(1, 3))->pluck('id')->all();
            $eatery->features()->attach($randomFeatureIds);
        });
    }
}