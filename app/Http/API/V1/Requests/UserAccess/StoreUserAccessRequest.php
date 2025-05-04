<?php

namespace App\Http\API\V1\Requests\UserAccess;

use App\Enums\UserType;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserAccessRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists(User::class, 'id')->where('type', UserType::ADMIN)],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'role_id' => ['required', Rule::exists(Role::class, 'id')],
        ];
    }
}
