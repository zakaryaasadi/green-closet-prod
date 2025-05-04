<?php

namespace App\Http\API\V1\Requests\Page;

use App\Models\Country;
use App\Models\Language;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'title' => ['max:255'],
            'is_home' => ['boolean'],
            'default_page_title' => ['max:255'],
            'slug' => ['max:255'],
            'meta_tags' => [''],
            'meta_tags_arabic' => [''],
            'custom_styles' => [''],
            'custom_scripts' => [''],
            'custom_scripts_arabic' => [''],
            'meta' => ['nullable'],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'language_id' => [Rule::exists(Language::class, 'id')],
        ], $this->getValidateItem(['title'], 'translate', ['max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
