<?php

namespace App\Http\API\V1\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class RelatedLocationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lat' => [],
            'lng' => [],
        ];
    }

    public function bodyParameters(): array
    {
        return [
//            'title' => [
//                'description' => 'The title of the post.',
//                'example' => 'My First Post',
//            ],
        ];
    }
}
