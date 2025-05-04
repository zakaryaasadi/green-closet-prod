<?php

namespace App\Http\API\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'image'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
