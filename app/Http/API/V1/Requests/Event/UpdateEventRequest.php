<?php

namespace App\Http\API\V1\Requests\Event;

use App\Models\Country;
use App\Models\MediaModel;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'title' => ['max:255'],
            'description' => ['max:255'],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'date' => ['date_format:Y-m-d H:i', 'after_or_equal:' . date('Y-m-d H:i')],
            'meta' => [''],
            'thumbnail' => [Rule::exists(MediaModel::class, 'id')],
        ], $this->getValidateItem(['title', 'description'], 'translate', []));
    }
}
