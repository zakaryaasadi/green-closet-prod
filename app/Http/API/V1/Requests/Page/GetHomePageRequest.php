<?php

namespace App\Http\API\V1\Requests\Page;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetHomePageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', Rule::exists(User::class, 'id')],
        ];
    }
}
