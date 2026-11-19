@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-stone-900">Davao City Districts</h1>
        <p class="text-sm text-stone-600">Select a district to browse its carinderias and eateries.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($districts as $district)
            <a href="{{ route('districts.show', $district) }}"
               class="block bg-white rounded-xl border border-stone-200 p-6 shadow-sm hover:border-emerald-500 transition">
                <h2 class="text-lg font-bold text-stone-900">{{ $district->name }}</h2>
                <p class="mt-1 text-sm text-emerald-700 font-medium">
                    {{ $district->eateries_count }} {{ \Illuminate\Support\Str::plural('eatery', $district->eateries_count) }}
                </p>
            </a>
        @endforeach
    </div>
@endsection