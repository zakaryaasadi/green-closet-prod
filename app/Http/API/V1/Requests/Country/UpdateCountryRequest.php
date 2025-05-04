<?php

namespace App\Http\API\V1\Requests\Country;

use App\Enums\ActiveStatus;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'name' => ['max:255'],
            'code' => ['unique:countries,code,'],
            'status' => [Rule::in(ActiveStatus::getValues())],
        ], $this->getValidateItem(['name'], 'translate', ['max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
