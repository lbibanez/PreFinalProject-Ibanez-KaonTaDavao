@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-stone-900">{{ $user->name }}</h1>
        <p class="mt-1 text-sm font-medium text-stone-600">
            {{ $reviews->count() }} {{ \Illuminate\Support\Str::plural('review', $reviews->count()) }} written
        </p>
    </div>

    @if ($reviews->isEmpty())
        <div class="bg-white rounded-xl border border-stone-200 p-8 text-center text-stone-600">
            No reviews written yet.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($reviews as $review)
                <article class="bg-white rounded-xl border border-stone-200 p-5 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <a href="{{ route('eateries.show', $review->eatery) }}" class="text-base font-bold text-emerald-700 hover:underline">
                            {{ $review->eatery->name }}
                        </a>
                        <div class="flex items-center gap-2">
                            <x-rating :rating="$review->rating" />
                            <span class="text-xs text-stone-500">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <p class="mt-2 text-sm text-stone-700">{{ $review->body }}</p>
                </article>
            @endforeach
        </div>
    @endif
@endsection