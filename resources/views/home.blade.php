@extends('layouts.app')

@section('content')
    <section class="mb-10">
        <div class="bg-white rounded-xl border border-stone-200 p-6 sm:p-8 shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-bold text-stone-900">
                Discover Davao City's Best Carinderias &amp; Eateries
            </h1>
            <p class="mt-2 text-stone-600 max-w-2xl">
                Browse local favorites by district, check business permits and specialties, and read honest reviews from Davao residents.
            </p>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-lg bg-emerald-50 border border-emerald-200 p-4">
                    <div class="text-2xl font-bold text-emerald-900">{{ $eateryCount }}</div>
                    <div class="text-sm font-medium text-emerald-700">Eateries Listed</div>
                </div>
                <div class="rounded-lg bg-amber-50 border border-amber-200 p-4">
                    <div class="text-2xl font-bold text-amber-900">{{ $districtCount }}</div>
                    <div class="text-sm font-medium text-amber-700">Davao Districts</div>
                </div>
                <div class="rounded-lg bg-stone-100 border border-stone-200 p-4">
                    <div class="text-2xl font-bold text-stone-900">{{ $reviewCount }}</div>
                    <div class="text-sm font-medium text-stone-600">Resident Reviews</div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-stone-900">Top Rated</h2>
            <a href="{{ route('eateries.index') }}" class="text-sm font-medium text-emerald-700 hover:underline">
                Browse all eateries &rarr;
            </a>
        </div>

        @if ($topEateries->isEmpty())
            <p class="text-stone-600 bg-white rounded-xl border border-stone-200 p-6">
                No rated eateries yet.
            </p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($topEateries as $eatery)
                    <x-eatery-card :eatery="$eatery" />
                @endforeach
            </div>
        @endif
    </section>
@endsection