<?php
// app/Http/Requests/StoreBrandDiscoveryRequest.php

namespace App\Http\Requests;

use App\Models\BrandDiscovery;
use Illuminate\Foundation\Http\FormRequest;

class StoreBrandDiscoveryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'client_token'      => ['nullable', 'string', 'max:255'],
            'name'              => ['required', 'string', 'max:255'],
            'brand_name'        => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'industry'          => ['nullable', 'string', 'max:255'],
            'brand_description' => ['nullable', 'string', 'max:500'],
            'existing_brand'    => ['nullable', 'string', 'max:255'],

            'persona'   => ['nullable', 'string', 'max:2000'],
            'age_min'   => ['nullable', 'integer', 'min:0', 'max:100'],
            'age_max'   => ['nullable', 'integer', 'min:0', 'max:100', 'gte:age_min'],
            'profile'   => ['nullable', 'array'],
            'profile.*' => ['string', 'max:255'],

            'colour'        => ['nullable', 'array'],
            'colour.*'      => ['string', 'max:255'],
            'typography'    => ['nullable', 'array'],
            'typography.*'  => ['string', 'max:255'],
            'touchpoints'   => ['nullable', 'array'],
            'touchpoints.*' => ['string', 'max:255'],

            'competitors'     => ['nullable', 'string', 'max:1000'],
            'differentiator'  => ['nullable', 'string', 'max:1000'],
            'admired'         => ['nullable', 'string', 'max:1000'],

            'five_year'      => ['nullable', 'string', 'max:2000'],
            'urgency'        => ['nullable', 'string', 'max:255'],
            'anything_else'  => ['nullable', 'string', 'max:3000'],
        ];

        // The 16 trait_* sliders are scalar keys, not an array, so they need explicit rules
        foreach (BrandDiscovery::TRAIT_KEYS as $key) {
            $rules[$key] = ['nullable', 'integer', 'between:-3,3'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Please tell us your name.',
            'brand_name.required' => 'Please tell us the brand or business name.',
            'email.required'      => 'We need an email to follow up.',
            'email.email'         => 'That email address doesn\'t look right.',
        ];
    }
}
