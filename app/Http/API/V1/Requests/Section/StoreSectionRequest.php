<?php

namespace App\Http\API\V1\Requests\Section;

use App\Enums\SectionType;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSectionRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        $countryRule = [Rule::exists(Country::class, 'id')];
        $languageRule = [Rule::exists(Language::class, 'id')];
        $pageRule = [Rule::exists(Page::class, 'id')];
        $sortRule = ['numeric', 'min:0'];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['type'])) {
                if ($request['type'] == SectionType::HOW_WE_WORK_MOBILE) {
                    $countryRule[] = 'required';
                    $languageRule[] = 'required';
                } else{
                    $pageRule[] = 'required';
                    $sortRule[] = 'required';
                }
            }
        }

        return [
            'type' => ['required', Rule::in(SectionType::getValues())],
            'sort' => $sortRule,
            'structure' => ['required'],
            'active' => ['boolean'],
            'page_id' => $pageRule,
            'country_id' => $countryRule,
            'language_id' => $languageRule,
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
