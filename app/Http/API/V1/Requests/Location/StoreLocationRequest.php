<?php

namespace App\Http\API\V1\Requests\Location;

use App\Enums\UserType;
use App\Models\Country;
use App\Models\Province;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocationRequest extends FormRequest
{
    public function rules(): array
    {
        $request = request()->all();
        $team_id = '';
        if (isset($request)) {
            if (isset($request['team_id'])) {
                $team_id = $request['team_id'];
            }
        }

        return [
            'name' => ['required', 'max:255'],
            'color' => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?|gba?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            'area' => ['required'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'team_id' => ['required', Rule::exists(Team::class, 'id')],
            'agents_ids' => ['required'],
            'agents_ids.*' => [Rule::exists(User::class, 'id')
                ->where('type', UserType::AGENT)
                ->where('team_id', $team_id),],
            'area.*.lat' => ['required', 'numeric', 'between:-90,90'],
            'area.*.lng' => ['required', 'numeric', 'between:-180,180'],
        ];
    }
}
