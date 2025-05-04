<?php

namespace App\Http\API\V1\Requests\Page;

use App\Models\Country;
use App\Models\Language;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'is_home' => ['required', 'boolean'],
            'default_page_title' => ['required', 'max:255'],
            'slug' => ['required', 'max:255'],
            'meta_tags' => ['nullable'],
            'meta_tags_arabic' => ['nullable'],
            'custom_styles' => [''],
            'custom_scripts' => [''],
            'custom_scripts_arabic' => [''],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'language_id' => ['required', Rule::exists(Language::class, 'id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
