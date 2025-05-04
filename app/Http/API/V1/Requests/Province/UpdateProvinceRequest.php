<?php

namespace App\Http\API\V1\Requests\Province;

use App\Models\Country;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProvinceRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id')],
            'name' => ['max:255'],
            'meta' => [''],
        ], $this->getValidateItem(['name'], 'translate', ['max:255']));
    }
}
