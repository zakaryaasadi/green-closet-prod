<?php

namespace App\Http\API\V1\Requests\Page;

use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'mail' => ['required', 'max:255'],
            'message' => ['required', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
