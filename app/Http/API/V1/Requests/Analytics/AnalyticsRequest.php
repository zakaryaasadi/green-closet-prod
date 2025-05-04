<?php

namespace App\Http\API\V1\Requests\Analytics;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use App\Enums\DischargeShift;
use App\Models\Association;
use App\Models\Country;
use App\Models\District;
use App\Models\Location;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use App\Models\Team;
use App\Models\User;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnalyticsRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        $endDataValidate = ['date_format:Y-m-d'];
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['start_date']))
                $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
        }

        return [
            'country_id' => [Rule::exists(Country::class, 'id')],
            'user_id' => [Rule::exists(User::class, 'id')],
            'location_id' => [Rule::exists(Location::class, 'id')],
            'association_id' => [Rule::exists(Association::class, 'id')],
            'team_id' => [Rule::exists(Team::class, 'id')],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'district_id' => [Rule::exists(District::class, 'id')],
            'neighborhood_id' => [Rule::exists(Neighborhood::class, 'id')],
            'street_id' => [Rule::exists(Street::class, 'id')],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => $endDataValidate,
            'status' => [Rule::in(ContainerStatus::getValues())],
            'type' => [Rule::in(ContainerType::getValues())],
            'discharge_shift' => [Rule::in(DischargeShift::getValues())],
            'code' => ['max:255'],
            'date_type' => ['in:created_at,start_task'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
