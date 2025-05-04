<?php

namespace App\Http\API\V1\Requests\Association;

use App\Enums\ActiveStatus;
use App\Models\Country;
use App\Models\MediaModel;
use App\Models\User;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssociationRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'status' => [Rule::in(ActiveStatus::getValues())],
            'priority' => ['integer'],
            'title' => ['max:255'],
            'description' => [],
            'IBAN' => ['max:255'],
            'swift_code' => ['max:255'],
            'account_number' => ['max:255'],
            'meta' => [''],
            'url' => ['max:255'],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'user_id' => [Rule::exists(User::class, 'id')],
            'thumbnail' => [Rule::exists(MediaModel::class, 'id')],
        ], $this->getValidateItem(['title', 'description'], 'translate', []));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
