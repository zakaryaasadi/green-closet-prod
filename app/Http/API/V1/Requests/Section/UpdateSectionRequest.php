<?php

namespace App\Http\API\V1\Requests\Section;

use App\Enums\SectionType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSectionRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'type' => [Rule::in(SectionType::getValues())],
            'sort' => ['numeric', 'min:0'],
            'structure' => ['nullable'],
            'active' => ['boolean'],
            'page_id' => [Rule::exists(Page::class, 'id')],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'language_id' => [Rule::exists(Language::class, 'id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
