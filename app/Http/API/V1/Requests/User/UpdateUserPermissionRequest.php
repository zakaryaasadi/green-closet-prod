<?php

namespace App\Http\API\V1\Requests\User;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserPermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
        ];
    }
}
