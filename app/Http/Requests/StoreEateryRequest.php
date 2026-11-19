<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEateryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'unique:eateries,name'],
            'district_id' => ['required', 'exists:districts,id'],
            'address' => ['required', 'string', 'max:255'],
            'price_range' => ['required', Rule::in(['budget', 'mid', 'splurge'])],
            'specialty' => ['nullable', 'string', 'max:100'],
            'is_open' => ['nullable', 'boolean'],
            'permit_no' => [
                'required',
                'string',
                'regex:/^DVO-\d{4}-\d{4,5}$/',
                'unique:permits,permit_no',
            ],
            'expires_on' => ['required', 'date', 'after:today'],
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['integer', 'exists:features,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Kaon Ta Ibanez already lists an eatery with this name.',
            'features.required' => 'Pick at least one feature.',
            'features.min' => 'Pick at least one feature.',
            'permit_no.regex' => 'Permit number must look like DVO-2026-0415.',
            'expires_on.after' => 'The permit must not be expired.',
        ];
    }
}