<?php

namespace App\Http\API\V1\Requests\Street;

use App\Models\Country;
use App\Models\Neighborhood;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStreetRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        return array_merge([
            'country_id' => [Rule::exists(Country::class, 'id')],
            'neighborhood_id' => [Rule::exists(Neighborhood::class, 'id')],
            'name' => ['max:255'],
            'meta' => [''],
        ], $this->getValidateItem(['name'], 'translate', ['max:255']));
    }
}
