<?php

namespace App\Http\API\V1\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['max:255'],
            'code' => ['max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
