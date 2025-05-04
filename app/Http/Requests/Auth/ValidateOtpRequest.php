<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ValidateOtpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'min:6'],
        ];
    }
}
