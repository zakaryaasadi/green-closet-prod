<?php

namespace App\Http\API\V1\Requests\District;

use App\Models\Country;
use App\Models\Province;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDistrictRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id')],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'name' => ['max:255'],
            'meta' => [''],
        ], $this->getValidateItem(['name'], 'translate', ['max:255']));
    }
}
