@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-xl border border-stone-200 p-6 sm:p-8 shadow-sm">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-stone-900">Edit {{ $eatery->name }}</h1>
            <p class="text-sm text-stone-600">Update eatery details, features, or business permit information.</p>
        </div>

        <form method="POST" action="{{ route('eateries.update', $eatery) }}">
            @csrf
            @method('PUT')

            @include('eateries._form', ['eatery' => $eatery, 'submitLabel' => 'Update Eatery'])
        </form>
    </div>
@endsection