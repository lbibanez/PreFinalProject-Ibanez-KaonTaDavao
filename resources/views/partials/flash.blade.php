@if (session('success'))
    <div class="mb-6 rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-900 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif