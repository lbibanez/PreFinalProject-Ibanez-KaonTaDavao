@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-stone-900">Davao Eateries</h1>
            <p class="text-sm text-stone-600">Ordered A&ndash;Z, 6 eateries per page.</p>
        </div>
        <a href="{{ route('eateries.create') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition">
            + Add Eatery
        </a>
    </div>

    <form method="GET" action="{{ route('eateries.index') }}" class="bg-white rounded-xl border border-stone-200 p-4 mb-6 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="q" class="block text-xs font-semibold uppercase tracking-wide text-stone-600 mb-1">Search Name / Specialty</label>
                <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="e.g. Tinola or Ibanez"
                       class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            </div>

            <div>
                <label for="district" class="block text-xs font-semibold uppercase tracking-wide text-stone-600 mb-1">District</label>
                <select id="district" name="district" class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                    <option value="">All Districts</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" @selected(request('district') == $district->id)>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="feature" class="block text-xs font-semibold uppercase tracking-wide text-stone-600 mb-1">Feature</label>
                <select id="feature" name="feature" class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                    <option value="">All Features</option>
                    @foreach ($features as $feature)
                        <option value="{{ $feature->name }}" @selected(request('feature') === $feature->name)>
                            {{ $feature->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition">
                    Filter
                </button>
                <a href="{{ route('eateries.index') }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50 transition">
                    Reset
                </a>
            </div>
        </div>
    </form>

    @if ($eateries->isEmpty())
        <div class="bg-white rounded-xl border border-stone-200 p-8 text-center text-stone-600">
            No eateries match your filters.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $eateries->links() }}
        </div>
    @endif
@endsection