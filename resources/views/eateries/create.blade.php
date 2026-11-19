@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl border border-stone-200 p-6 sm:p-8 shadow-sm">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-stone-900">Add New Eatery</h1>
            <p class="text-sm text-stone-600">Register a Davao City carinderia or eatery and its business permit.</p>
        </div>

        <form method="POST" action="{{ route('eateries.store') }}">
            @csrf

            @include('eateries._form', ['submitLabel' => 'Save Eatery'])
        </form>
    </div>
@endsection