<?php

namespace App\Http\API\V1\Requests\Address;

use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'location.title' => ['max:255'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'location.province' => ['max:255'],
            'location.lat' => ['numeric', 'between:-90,90'],
            'location.lng' => ['numeric', 'between:-180,180'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
//            'title' => [
//                'description' => 'The title of the post.',
//                'example' => 'My First Post',
//            ],
        ];
    }
}
