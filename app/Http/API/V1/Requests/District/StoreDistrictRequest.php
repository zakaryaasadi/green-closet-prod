<?php

namespace App\Http\API\V1\Requests\District;

use App\Models\Country;
use App\Models\Province;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDistrictRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id'), 'required'],
            'province_id' => [Rule::exists(Province::class, 'id'), 'required'],
            'name' => ['max:255'],
            'meta' => ['required'],
        ], $this->getValidateItem(['name'], 'translate', ['required', 'max:255']));
    }
}
