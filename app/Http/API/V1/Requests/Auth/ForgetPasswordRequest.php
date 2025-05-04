<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => 'required',
            'password' => ['required', 'min:6'],
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
