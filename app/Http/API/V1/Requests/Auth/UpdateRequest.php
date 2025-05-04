<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'name' => ['max:255'],
            'email' => ['max:255', 'email', 'unique:users'],
            'phone' => [Rule::unique('users', 'phone')],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
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
