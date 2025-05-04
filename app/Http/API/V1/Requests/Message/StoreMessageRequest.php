<?php

namespace App\Http\API\V1\Requests\Message;

use App\Enums\MessageType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'max:255'],
            'language_id' => ['required', Rule::exists(Language::class, 'id')],
            'type' => ['required', Rule::in(MessageType::getValues())],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
