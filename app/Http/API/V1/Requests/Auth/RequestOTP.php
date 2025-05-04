<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RequestOTP extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
        ];
    }
}
