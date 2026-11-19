<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $tita = User::where('email', 'tita.ibanez@kaonta.test')->firstOrFail();
        $myEatery = Eatery::where('slug', 'carinderia-ni-ibanez')->firstOrFail();

        // Tita's exact 5-star review
        Review::create([
            'eatery_id' => $myEatery->id,
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Ibanez.',
        ]);

        // At least 2 more reviews on Carinderia ni Ibanez (total >= 3)
        Review::factory()
            ->count(3)
            ->create([
                'eatery_id' => $myEatery->id,
                'user_id' => fn () => $users->where('id', '!=', $tita->id)->random()->id,
            ]);

        // Other open eateries get 0-6 reviews; closed eateries get none
        Eatery::where('is_open', true)
            ->where('id', '!=', $myEatery->id)
            ->get()
            ->each(function (Eatery $eatery) use ($users) {
                $count = rand(0, 6);
                if ($count > 0) {
                    Review::factory()
                        ->count($count)
                        ->create([
                            'eatery_id' => $eatery->id,
                            'user_id' => fn () => $users->random()->id,
                        ]);
                }
            });
    }
}