<?php

namespace App\Http\API\V1\Requests\News;

use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'title' => ['max:255'],
            'link' => ['required', 'max:255', 'regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
            'description' => ['max:255'],
            'thumbnail' => ['required', Rule::exists(MediaModel::class, 'id')],
            'display_order' => ['numeric'],
            'meta' => ['required'],
            'meta_tags' => ['nullable'],
            'meta_tags_arabic' => ['nullable'],
            'scripts' => [''],
            'scripts_arabic' => [''],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
        ], $this->getValidateItem(['title', 'description'], 'translate', ['required']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
