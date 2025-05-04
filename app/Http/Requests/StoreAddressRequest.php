<?php

namespace App\Http\Requests;

use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'province' => ['required', 'max:255'],
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
        ];
    }
}
