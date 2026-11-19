@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-stone-900">{{ $district->name }}</h1>
        <p class="mt-1 text-sm font-medium text-stone-600">
            {{ $reviewCount }} {{ \Illuminate\Support\Str::plural('review', $reviewCount) }} in {{ $district->name }}
        </p>
    </div>

    @if ($eateries->isEmpty())
        <div class="bg-white rounded-xl border border-stone-200 p-8 text-center text-stone-600">
            No eateries listed in {{ $district->name }} yet.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection