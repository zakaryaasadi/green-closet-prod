<?php

namespace App\Http\API\V1\Requests\Auth;

use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'phone' => ['required'],
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'location.title' => ['required', 'max:255'],
            'location.province' => ['required', 'max:255'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'location.lat' => ['required', 'numeric', 'between:-90,90'],
            'location.lng' => ['required', 'numeric', 'between:-180,180'],
            'udid' => [],
            'fcm_token' => [],
        ];
    }

    public function bodyParameters(): array
    {
        return [
        ];
    }
}
