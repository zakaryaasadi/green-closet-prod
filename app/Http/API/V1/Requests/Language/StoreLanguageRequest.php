<?php

namespace App\Http\API\V1\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
