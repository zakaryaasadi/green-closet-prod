<?php

namespace App\Http\API\V1\Requests\Partner;

use App\Enums\MediaType;
use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePartnerRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'name' => ['max:255'],
            'description' => ['max:255'],
            'meta' => ['required'],
            'image' => ['required', Rule::exists(MediaModel::class, 'id')->where('type', MediaType::IMAGE)],
            'url' => ['required', 'max:255', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
        ], $this->getValidateItem(['name', 'description'], 'translate', ['required', 'max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
