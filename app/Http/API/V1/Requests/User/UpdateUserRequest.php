<?php

namespace App\Http\API\V1\Requests\User;

use App\Enums\UserType;
use App\Models\Association;
use App\Models\Country;
use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['max:255'],
            'association_id' => [Rule::exists(Association::class, 'id')],
            'team_id' => [Rule::exists(Team::class, 'id')],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'type' => [Rule::in(UserType::getValues())],
            'email' => ['max:255', 'email'],
            'phone' => [],
            'password' => ['min:6'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
