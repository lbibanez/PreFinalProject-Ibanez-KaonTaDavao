<header class="bg-emerald-800 text-white shadow">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight hover:text-amber-200 transition">
            Kaon Ta! Davao Ibanez's Food Guide
        </a>

        <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-200 {{ request()->routeIs('home') ? 'underline underline-offset-4 text-amber-200' : '' }}">
                Home
            </a>
            <a href="{{ route('eateries.index') }}" class="hover:text-amber-200 {{ request()->routeIs('eateries.index') ? 'underline underline-offset-4 text-amber-200' : '' }}">
                Eateries
            </a>
            <a href="{{ route('districts.index') }}" class="hover:text-amber-200 {{ request()->routeIs('districts.*') ? 'underline underline-offset-4 text-amber-200' : '' }}">
                Districts
            </a>
            <a href="{{ route('eateries.create') }}" class="bg-amber-400 text-stone-900 font-semibold px-3 py-1.5 rounded hover:bg-amber-300 transition">
                + Add Eatery
            </a>
        </nav>
    </div>
</header>