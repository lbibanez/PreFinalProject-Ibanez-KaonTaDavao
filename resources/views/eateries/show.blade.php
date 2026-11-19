@extends('layouts.app')

@section('content')
    @php
        $priceSymbol = match ($eatery->price_range) {
            'budget' => 'P',
            'mid' => 'PP',
            'splurge' => 'PPP',
            default => 'P',
        };
    @endphp

    <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm mb-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-2xl sm:text-3xl font-bold text-stone-900">{{ $eatery->name }}</h1>
                    @if ($eatery->is_open)
                        <span class="rounded-full bg-emerald-100 px-3 py-0.5 text-xs font-semibold text-emerald-800">Open</span>
                    @else
                        <span class="rounded-full bg-red-100 px-3 py-0.5 text-xs font-semibold text-red-700">Closed</span>
                    @endif
                </div>

                <p class="text-sm text-stone-600">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="font-semibold text-emerald-700 hover:underline">
                        {{ $eatery->district->name }}
                    </a>
                    &middot; {{ $eatery->address }}
                    &middot; <span class="font-semibold text-stone-800">{{ $priceSymbol }}</span>
                </p>

                @if ($eatery->specialty)
                    <p class="text-sm text-stone-700">
                        <span class="font-semibold">Specialty:</span> {{ $eatery->specialty }}
                    </p>
                @endif

                <div class="flex flex-wrap gap-1.5 pt-2">
                    @foreach ($eatery->features as $feature)
                        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                           class="inline-block rounded-full bg-emerald-50 border border-emerald-200 px-3 py-0.5 text-xs font-medium text-emerald-800 hover:bg-emerald-100 transition">
                            {{ $feature->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('eateries.edit', $eatery) }}"
                   class="rounded-lg border border-stone-300 bg-white px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 transition">
                    Edit
                </a>

                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}"
                      onsubmit="return confirm('Delete this eatery and all its records?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if ($eatery->permit)
            <div class="mt-6 rounded-lg border border-stone-200 bg-stone-50 p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wide text-stone-500">Business Permit</span>
                    <p class="text-sm font-semibold text-stone-900">
                        Permit No: {{ $eatery->permit->permit_no }}
                    </p>
                </div>
                <div class="text-sm">
                    <span class="text-stone-600">Expires on: {{ $eatery->permit->expires_on->format('Y-m-d') }}</span>
                    @if ($eatery->permit->expires_on->isBefore(today()))
                        <span class="ml-2 font-bold text-red-600">Permit expired</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-1 bg-white rounded-xl border border-stone-200 p-6 shadow-sm h-fit">
            <h2 class="text-lg font-bold text-stone-900 mb-4">Dishes</h2>

            @if ($eatery->dishes->isEmpty())
                <p class="text-sm text-stone-500">No dishes listed yet.</p>
            @else
                <ul class="divide-y divide-stone-100">
                    @foreach ($eatery->dishes as $dish)
                        <li class="py-3 flex items-center justify-between gap-2">
                            <div>
                                <p class="text-sm font-semibold text-stone-900">{{ $dish->name }}</p>
                                @if ($dish->is_bestseller)
                                    <span class="inline-block mt-0.5 rounded bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">
                                        Bestseller
                                    </span>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-emerald-800">
                                ₱{{ number_format((float) $dish->price, 2) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-stone-900 mb-4">Write a Review</h2>

                @if ($eatery->is_open)
                    @if ($errors->any())
                        <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800">
                            <p class="font-semibold mb-1">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-stone-700 mb-1">Reviewer</label>
                            <select id="user_id" name="user_id" class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                                <option value="">Select your name...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="rating" class="block text-sm font-medium text-stone-700 mb-1">Rating (1 to 5)</label>
                            <select id="rating" name="rating" class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                                <option value="">Select rating...</option>
                                @for ($r = 5; $r >= 1; $r--)
                                    <option value="{{ $r }}" @selected(old('rating') == $r)>
                                        {{ $r }} {{ \Illuminate\Support\Str::plural('Star', $r) }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="body" class="block text-sm font-medium text-stone-700 mb-1">Your Review</label>
                            <textarea id="body" name="body" rows="3" placeholder="Share your experience..."
                                      class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition">
                            Post Review
                        </button>
                    </form>
                @else
                    <p class="rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm font-medium text-amber-900">
                        This eatery is closed. Reviews are paused.
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-stone-900 mb-4">
                    Reviews ({{ $eatery->reviews->count() }})
                </h2>

                @if ($eatery->reviews->isEmpty())
                    <p class="text-sm text-stone-500">No reviews yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($eatery->reviews as $review)
                            <div class="border-b border-stone-100 pb-4 last:border-b-0 last:pb-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-emerald-700 hover:underline text-sm">
                                            {{ $review->user->name }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <x-rating :rating="$review->rating" />
                                            <span class="text-xs text-stone-500">
                                                {{ $review->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                                <p class="mt-2 text-sm text-stone-700">{{ $review->body }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection