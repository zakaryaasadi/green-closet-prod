<?php

namespace App\Http\API\V1\Requests\User;

use App\Enums\UserType;
use App\Models\Association;
use App\Models\Country;
use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        $typeRules = ['numeric', Rule::in(UserType::getValues())];
        $emailRules = ['max:255', 'email'];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['type'])) {
                if ($request['type'] == UserType::ASSOCIATION) {
                    $emailRules = array_merge($emailRules, ['required']);
                }
            }
        }

        return [
            'name' => ['required', 'max:255'],
            'team_id' => [Rule::exists(Team::class, 'id')],
            'association_id' => [Rule::exists(Association::class, 'id')],
            'type' => $typeRules,
            'email' => $emailRules,
            'phone' => ['required'],
            'password' => ['min:6'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'country_id' => [Rule::exists(Country::class, 'id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
