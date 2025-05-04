<?php

namespace App\Http\API\V1\Requests\MediaModel;

use App\Enums\MediaType;
use App\Models\MediaModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadManyMediaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'images_ids' => ['required'],
            'images_ids.*' => [Rule::exists(MediaModel::class, 'id')->where('type', MediaType::IMAGE)],
        ];
    }
}
