<?php

namespace App\Http\API\V1\Requests\Country;

use App\Enums\ActiveStatus;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCountryRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'name' => ['max:255'],
            'meta' => ['required'],
            'status' => ['required', Rule::in(ActiveStatus::getValues())],
            'code' => ['required', 'unique:countries,code'],
        ], $this->getValidateItem(['name'], 'translate', ['required', 'max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
