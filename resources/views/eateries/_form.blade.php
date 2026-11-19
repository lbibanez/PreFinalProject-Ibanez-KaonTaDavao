@php
    $eatery = $eatery ?? null;

    $selectedFeatures = old('features');
    if (! is_array($selectedFeatures)) {
        $selectedFeatures = $eatery ? $eatery->features->pluck('id')->all() : [];
    }

    $isOpenChecked = old('_token') !== null
        ? (bool) old('is_open')
        : ($eatery ? (bool) $eatery->is_open : true);
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-semibold mb-1">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-5">
    <div>
        <label for="name" class="block text-sm font-semibold text-stone-700 mb-1">Eatery Name</label>
        <input type="text" id="name" name="name"
               value="{{ old('name', $eatery?->name) }}"
               placeholder="e.g. Carinderia ni Ibanez"
               class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('name')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="district_id" class="block text-sm font-semibold text-stone-700 mb-1">District</label>
            <select id="district_id" name="district_id"
                    class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">Select a district...</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}"
                        @selected((string) old('district_id', $eatery?->district_id) === (string) $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
            @error('district_id')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price_range" class="block text-sm font-semibold text-stone-700 mb-1">Price Range</label>
            <select id="price_range" name="price_range"
                    class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">Select price tier...</option>
                <option value="budget" @selected(old('price_range', $eatery?->price_range) === 'budget')>Budget (P)</option>
                <option value="mid" @selected(old('price_range', $eatery?->price_range) === 'mid')>Mid-Range (PP)</option>
                <option value="splurge" @selected(old('price_range', $eatery?->price_range) === 'splurge')>Splurge (PPP)</option>
            </select>
            @error('price_range')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="address" class="block text-sm font-semibold text-stone-700 mb-1">Address</label>
        <input type="text" id="address" name="address"
               value="{{ old('address', $eatery?->address) }}"
               placeholder="e.g. San Pedro St., Poblacion, Davao City"
               class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('address')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="specialty" class="block text-sm font-semibold text-stone-700 mb-1">Specialty (Optional)</label>
        <input type="text" id="specialty" name="specialty"
               value="{{ old('specialty', $eatery?->specialty) }}"
               placeholder="e.g. Tinolang Manok"
               class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('specialty')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-1">
        <label class="inline-flex items-center gap-2 text-sm font-semibold text-stone-700 cursor-pointer">
            <input type="checkbox" name="is_open" value="1"
                   @checked($isOpenChecked)
                   class="rounded border-stone-300 text-emerald-700 focus:ring-emerald-600">
            <span>Currently Open for Customers</span>
        </label>
        @error('is_open')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="border-t border-stone-200 pt-5">
        <span class="block text-sm font-semibold text-stone-700 mb-2">Features (Pick at least one)</span>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
            @foreach ($features as $feature)
                <label class="flex items-center gap-2 rounded-lg border border-stone-200 px-3 py-2 text-sm text-stone-700 hover:bg-stone-50 cursor-pointer">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(in_array($feature->id, $selectedFeatures))
                           class="rounded border-stone-300 text-emerald-700 focus:ring-emerald-600">
                    <span>{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
        @error('features.*')
            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="border-t border-stone-200 pt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="permit_no" class="block text-sm font-semibold text-stone-700 mb-1">Business Permit Number</label>
            <input type="text" id="permit_no" name="permit_no"
                   value="{{ old('permit_no', $eatery?->permit?->permit_no) }}"
                   placeholder="DVO-2026-0415"
                   class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('permit_no')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="expires_on" class="block text-sm font-semibold text-stone-700 mb-1">Permit Expiry Date</label>
            <input type="date" id="expires_on" name="expires_on"
                   value="{{ old('expires_on', $eatery?->permit?->expires_on?->format('Y-m-d')) }}"
                   class="w-full rounded-lg border-stone-300 text-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('expires_on')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="pt-4 flex items-center gap-3">
        <button type="submit"
                class="rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800 transition">
            {{ $submitLabel }}
        </button>
        <a href="{{ $eatery ? route('eateries.show', $eatery) : route('eateries.index') }}"
           class="rounded-lg border border-stone-300 px-4 py-2.5 text-sm font-medium text-stone-700 hover:bg-stone-50 transition">
            Cancel
        </a>
    </div>
</div>