<?php

namespace App\Http\API\V1\Requests\LocationSettings;

use App\Models\Country;
use App\Models\Language;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationSettingsRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'structure' => [''],
            'scripts' => [''],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'language_id' => [Rule::exists(Language::class, 'id')],
            'slug' => [''],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
