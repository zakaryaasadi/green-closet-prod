<?php

namespace App\Http\API\V1\Requests\MediaModel;

use App\Enums\MediaType;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaModelRequest extends FormRequest
{
    public function rules(): array
    {
        $rulesMedia = ['required'];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['type'])) {
                if ($request['type'] == MediaType::IMAGE) {
                    $rulesMedia[] = 'image';
                    $rulesMedia[] = 'max:5120';
                } elseif ($request['type'] == MediaType::VIDEO) {
                    $rulesMedia[] = 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,
                    video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi';
                    $rulesMedia[] = 'max:20000';
                }
            }
        }

        return [
            'media' => $rulesMedia,
            'tag' => ['required', 'max:255'],
            'type' => ['required', Rule::in(MediaType::getValues())],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
        ];
    }
}
