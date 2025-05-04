<?php

namespace App\Http\API\V1\Requests\Message;

use App\Enums\MessageType;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['max:255'],
            'language_id' => [Rule::exists(Language::class, 'id')],
            'type' => [Rule::in(MessageType::getValues())],
            'country_id' => [Rule::exists(Country::class, 'id')],
        ];
    }
}
