<?php

namespace App\Http\API\V1\Requests\Partner;

use App\Enums\MediaType;
use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePartnerRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'name' => ['max:255'],
            'description' => ['max:255'],
            'url' => ['max:255', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'image' => [Rule::exists(MediaModel::class, 'id')->where('type', MediaType::IMAGE)],
            'meta' => [''],
            'country_id' => [Rule::exists(Country::class, 'id')],
        ], $this->getValidateItem(['name', 'description'], 'translate', ['max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
