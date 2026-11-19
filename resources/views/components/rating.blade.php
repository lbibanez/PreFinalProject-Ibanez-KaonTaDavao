@props(['rating' => 0])

@php
    $rounded = (int) round((float) $rating);
@endphp

<span class="inline-flex items-center text-amber-500" aria-label="{{ number_format((float) $rating, 1) }} out of 5 stars">
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $rounded)
            <span>&#9733;</span>
        @else
            <span class="text-stone-300">&#9733;</span>
        @endif
    @endfor
</span>