<?php

namespace App\Http\Requests;

use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['max:255'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'province' => ['max:255'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'lat' => ['numeric', 'between:-90,90'],
            'lng' => ['numeric', 'between:-180,180'],
        ];
    }
}
