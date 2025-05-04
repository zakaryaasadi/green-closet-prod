<?php

namespace App\Http\API\V1\Requests\Location;

use App\Enums\UserType;
use App\Models\Province;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
{
    public function rules(): array
    {
        $request = request()->all();
        $team_id = '';
        $agentsRule[] = '';
        if (isset($request)) {
            if (isset($request['agents_ids'])) {
                $teamRule[] = 'required';
            }
            if (isset($request['team_id'])) {
                $team_id = $request['team_id'];
            }
        }

        $teamRule[] = Rule::exists(Team::class, 'id');

        return [
            'name' => ['max:255', 'unique:locations'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'color' => ['regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?|gba?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            'area' => [''],
            'team_id' => $teamRule,
            'agents_ids' => $agentsRule,
            'agents_ids.*' => [Rule::exists(User::class, 'id')
                ->where('type', UserType::AGENT)
                ->where('team_id', $team_id),],
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
