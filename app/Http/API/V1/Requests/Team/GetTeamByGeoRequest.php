<?php

namespace App\Http\API\V1\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class GetTeamByGeoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lat' => ['numeric', 'between:-90,90'],
            'lng' => ['numeric', 'between:-180,180'],
        ];
    }
}
