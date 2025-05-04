<?php

namespace App\Http\API\V1\Requests\Container;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use App\Enums\DischargeShift;
use App\Models\Association;
use App\Models\Country;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use App\Models\Team;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContainerRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'code' => ['max:255'],
            'association_id' => [Rule::exists(Association::class, 'id')],
            'team_id' => [Rule::exists(Team::class, 'id')],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'district_id' => [Rule::exists(District::class, 'id')],
            'neighborhood_id' => [Rule::exists(Neighborhood::class, 'id')],
            'street_id' => [Rule::exists(Street::class, 'id')],
            'discharge_shift' => [Rule::in(DischargeShift::getValues())],
            'type' => [Rule::in(ContainerType::getValues())],
            'status' => [Rule::in(ContainerStatus::getValues())],
            'location.lat' => ['numeric', 'between:-90,90'],
            'location.lng' => ['numeric', 'between:-180,180'],
            'location_description' => ['max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
