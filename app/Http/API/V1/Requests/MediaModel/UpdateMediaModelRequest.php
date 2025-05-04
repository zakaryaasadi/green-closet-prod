<?php

namespace App\Http\API\V1\Requests\MediaModel;

use App\Enums\MediaType;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaModelRequest extends FormRequest
{
    public function rules(): array
    {
        $rulesMedia = [];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['type'])) {
                if ($request['type'] == MediaType::IMAGE) {
                    $rulesMedia[] = 'image';
                    $rulesMedia[] = 'max:5120';
                } elseif ($request['type'] == MediaType::VIDEO) {
                    $rulesMedia[] = 'video';
                    $rulesMedia[] = 'max:20000';
                }
            }
        }

        return [
            'media' => $rulesMedia,
            'tag' => ['max:255'],
            'type' => [Rule::in(MediaType::getValues())],
            'country_id' => [Rule::exists(Country::class, 'id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [
        ];
    }
}
