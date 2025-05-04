<?php

namespace App\Http\API\V1\Requests\IP;

use App\Enums\IpStatus;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIpRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return [
            'title' => ['max:255'],
            'ip_address' => ['required', 'max:255', 'ip'],
            'status' => [Rule::in(IpStatus::getValues())],
        ];
    }
}
