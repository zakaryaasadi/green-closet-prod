<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'exists:users,phone'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
//            'title' => [
//                'description' => 'The title of the post.',
//                'example' => 'My First Post',
//            ],
        ];
    }
}
