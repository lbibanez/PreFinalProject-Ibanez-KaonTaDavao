<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'name' => fake()->randomElement([
                'Chicken Tinola',
                'Pork Humba',
                'Beef Nilaga',
                'Fried Bangus',
                'Pinakbet',
                'Laing',
                'Bicol Express',
                'Halo-Halo',
                'Durian Shake',
                'Puto Maya at Sikwate',
            ]),
            'price' => fake()->randomFloat(2, 35, 250),
            'is_bestseller' => fake()->boolean(30),
        ];
    }
}