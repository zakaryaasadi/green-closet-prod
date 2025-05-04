<?php

namespace App\Http\API\V1\Requests\Address;

use App\Models\Province;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [Rule::exists(User::class, 'id')],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'location.title' => ['max:255'],
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
