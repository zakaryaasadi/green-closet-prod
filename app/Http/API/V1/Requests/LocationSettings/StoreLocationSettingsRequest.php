<?php

namespace App\Http\API\V1\Requests\LocationSettings;

use App\Models\Country;
use App\Models\Language;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocationSettingsRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'structure' => ['required'],
            'scripts' => ['nullable'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'language_id' => ['required', Rule::exists(Language::class, 'id')],
            'slug' => ['required'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
