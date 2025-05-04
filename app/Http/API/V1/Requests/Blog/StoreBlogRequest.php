<?php

namespace App\Http\API\V1\Requests\Blog;

use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBlogRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'title' => ['max:255'],
            'description' => ['max:255'],
            'image' => ['required', Rule::exists(MediaModel::class, 'id')],
            'meta' => ['required'],
            'meta_tags' => ['nullable'],
            'meta_tags_arabic' => ['nullable'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
        ], $this->getValidateItem(['title', 'description'], 'translate', ['required']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
