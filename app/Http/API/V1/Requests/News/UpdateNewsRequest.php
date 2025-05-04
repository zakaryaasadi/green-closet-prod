<?php

namespace App\Http\API\V1\Requests\News;

use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'title' => ['max:255'],
            'link' => ['max:255', 'regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
            'thumbnail' => [Rule::exists(MediaModel::class, 'id')],
            'description' => ['max:255'],
            'meta' => [''],
            'scripts' => [''],
            'meta_tags' => ['nullable'],
            'meta_tags_arabic' => ['nullable'],
            'scripts_arabic' => [''],
            'display_order' => ['numeric'],
            'country_id' => [Rule::exists(Country::class, 'id')],
        ], $this->getValidateItem(['title', 'description'], 'translate', []));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
