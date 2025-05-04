<?php

namespace App\Http\API\V1\Requests\Blog;

use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'title' => ['max:255'],
            'image' => [Rule::exists(MediaModel::class, 'id')],
            'description' => ['max:255'],
            'meta' => [''],
            'meta_tags' => ['nullable'],
            'meta_tags_arabic' => ['nullable'],
            'country_id' => [Rule::exists(Country::class, 'id')],
        ], $this->getValidateItem(['title', 'description'], 'translate', []));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
