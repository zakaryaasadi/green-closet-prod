<?php

namespace App\Http\API\V1\Requests\Item;

use App\Enums\MediaType;
use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id')],
            'title' => ['max:255'],
            'price_per_kg' => ['numeric'],
            'image' => [Rule::exists(MediaModel::class, 'id')->where('type', MediaType::IMAGE)],
            'meta' => [''],
        ], $this->getValidateItem(['title'], 'translate', ['max:255']));
    }
}
