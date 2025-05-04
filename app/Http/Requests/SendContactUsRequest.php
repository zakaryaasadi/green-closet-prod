<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => ['max:255'],
            'name' => ['max:255'],
            'email' => ['max:255', 'email'],
            'details' => ['max:255'],
            'g-recaptcha-response' => 'recaptcha',
        ];
    }
}
