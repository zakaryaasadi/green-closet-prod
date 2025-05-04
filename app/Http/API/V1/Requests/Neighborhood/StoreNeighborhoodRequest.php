<?php

namespace App\Http\API\V1\Requests\Neighborhood;

use App\Models\Country;
use App\Models\District;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNeighborhoodRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id'), 'required'],
            'district_id' => [Rule::exists(District::class, 'id'), 'required'],
            'name' => ['max:255'],
            'meta' => ['required'],
        ], $this->getValidateItem(['name'], 'translate', ['required', 'max:255']));
    }
}
