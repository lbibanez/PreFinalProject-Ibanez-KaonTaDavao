<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EateryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company() . ' Eatery';

        return [
            'district_id' => fn () => District::inRandomOrder()->value('id') ?? District::create(['name' => fake()->unique()->city()])->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement([
                'Tinolang Manok',
                'Kinilaw na Tuna',
                'Sinuglaw',
                'Balbacua',
                'Bulalo',
                'Hinalang',
                'Pastil',
            ]),
            'is_open' => true,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}