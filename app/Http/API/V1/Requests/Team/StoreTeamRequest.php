<?php

namespace App\Http\API\V1\Requests\Team;

use App\Enums\UserType;
use App\Models\Country;
use App\Models\User;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'name' => ['max:128'],
            'meta' => ['required'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'agents_ids' => [''],
            'agents_ids.*' => [Rule::exists(User::class, 'id')->where('type', UserType::AGENT)],
        ], $this->getValidateItem(['name'], 'translate', ['required', 'max:128']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
