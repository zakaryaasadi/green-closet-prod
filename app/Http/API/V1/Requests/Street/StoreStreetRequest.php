<?php

namespace App\Http\API\V1\Requests\Street;

use App\Models\Country;
use App\Models\Neighborhood;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStreetRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id'), 'required'],
            'neighborhood_id' => [Rule::exists(Neighborhood::class, 'id'), 'required'],
            'name' => ['max:255'],
            'meta' => ['required'],
        ], $this->getValidateItem(['name'], 'translate', ['required', 'max:255']));
    }
}
