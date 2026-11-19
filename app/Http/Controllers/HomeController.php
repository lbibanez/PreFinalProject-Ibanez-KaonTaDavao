<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Review;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $eateryCount = Eatery::count();
        $districtCount = District::count();
        $reviewCount = Review::count();

        $topEateries = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->has('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->take(3)
            ->get();

        return view('home', compact(
            'eateryCount',
            'districtCount',
            'reviewCount',
            'topEateries'
        ));
    }
}