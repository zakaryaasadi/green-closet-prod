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

class StoreContainerRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        $country_id = '';
        $province_id = '';
        $district_id = '';
        $neighborhood_id = '';
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['country_id']))
                $country_id = $request['country_id'];
            if (isset($request['province_id']))
                $province_id = $request['province_id'];
            if (isset($request['district_id']))
                $district_id = $request['district_id'];
            if (isset($request['neighborhood_id']))
                $neighborhood_id = $request['neighborhood_id'];
        }

        return [
            'code' => ['required', 'max:255'],
            'association_id' => ['nullable', Rule::exists(Association::class, 'id')],
            'team_id' => [Rule::exists(Team::class, 'id'), 'required'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'province_id' => ['required', Rule::exists(Province::class, 'id')
                ->where('country_id', $country_id), ],
            'district_id' => ['required', Rule::exists(District::class, 'id')
                ->where('province_id', $province_id), ],
            'neighborhood_id' => ['required', Rule::exists(Neighborhood::class, 'id')
                ->where('district_id', $district_id), ],
            'street_id' => ['required', Rule::exists(Street::class, 'id')
                ->where('neighborhood_id', $neighborhood_id), ],
            'discharge_shift' => ['required', Rule::in(DischargeShift::getValues())],
            'type' => ['required', Rule::in(ContainerType::getValues())],
            'status' => ['required', Rule::in(ContainerStatus::getValues())],
            'location.lat' => ['required', 'numeric', 'between:-90,90'],
            'location.lng' => ['required', 'numeric', 'between:-180,180'],
            'location_description' => ['required', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
