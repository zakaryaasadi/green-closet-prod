<?php

namespace App\Http\API\V1\Requests\Association;

use App\Enums\ActiveStatus;
use App\Enums\UserType;
use App\Models\Country;
use App\Models\MediaModel;
use App\Models\User;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAssociationRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'status' => ['required', Rule::in(ActiveStatus::getValues())],
            'priority' => ['required', 'integer'],
            'title' => ['max:255'],
            'description' => [''],
            'IBAN' => ['max:255'],
            'swift_code' => ['max:255'],
            'account_number' => ['max:255'],
            'url' => ['required', 'max:255'],
            'meta' => ['required'],
            'thumbnail' => ['required', Rule::exists(MediaModel::class, 'id')],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'user_id' => [Rule::exists(User::class, 'id')->where('type', UserType::ASSOCIATION)],
        ], $this->getValidateItem(['title', 'description'], 'translate', ['required']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
