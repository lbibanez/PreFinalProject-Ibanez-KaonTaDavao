@props(['eatery'])

@php
    $priceSymbol = match ($eatery->price_range) {
        'budget' => 'P',
        'mid' => 'PP',
        'splurge' => 'PPP',
        default => 'P',
    };
    $reviewCount = $eatery->reviews_count ?? 0;
    $avgRating = $eatery->reviews_avg_rating;
@endphp

<article class="bg-white rounded-xl border border-stone-200 shadow-sm p-5 flex flex-col justify-between gap-4">
    <div class="space-y-2.5">
        <div class="flex items-start justify-between gap-2">
            <div>
                <h3 class="text-lg font-bold text-stone-900 leading-snug">
                    <a href="{{ route('eateries.show', $eatery) }}" class="hover:text-emerald-700 transition">
                        {{ $eatery->name }}
                    </a>
                </h3>
                <p class="text-sm text-stone-600">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="text-emerald-700 font-medium hover:underline">
                        {{ $eatery->district->name }}
                    </a>
                    &middot;
                    <span class="font-semibold text-stone-800">{{ $priceSymbol }}</span>
                </p>
            </div>

            @unless ($eatery->is_open)
                <span class="shrink-0 inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                    Closed
                </span>
            @endunless
        </div>

        @if ($eatery->specialty)
            <p class="text-sm text-stone-600">
                <span class="font-medium text-stone-700">Specialty:</span> {{ $eatery->specialty }}
            </p>
        @endif

        <div class="flex flex-wrap gap-1.5 pt-1">
            @foreach ($eatery->features as $feature)
                <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                   class="inline-block rounded-full bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 text-xs font-medium text-emerald-800 hover:bg-emerald-100 transition">
                    {{ $feature->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="pt-3 border-t border-stone-100 flex items-center justify-between text-sm">
        @if ($reviewCount > 0 && $avgRating !== null)
            <div class="flex items-center gap-1.5">
                <x-rating :rating="$avgRating" />
                <span class="font-semibold text-stone-800">{{ number_format((float) $avgRating, 1) }}</span>
                <span class="text-stone-500">({{ $reviewCount }} {{ \Illuminate\Support\Str::plural('review', $reviewCount) }})</span>
            </div>
        @else
            <span class="text-stone-500 italic">No reviews yet</span>
        @endif

        <a href="{{ route('eateries.show', $eatery) }}" class="text-emerald-700 font-medium hover:underline">
            View &rarr;
        </a>
    </div>
</article>