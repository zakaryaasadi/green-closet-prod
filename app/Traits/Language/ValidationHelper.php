<?php

namespace App\Traits\Language;

use App\Models\Language;

trait ValidationHelper
{
    public function getValidateItem($values, $field, $rules): array
    {
        $result = [];
        $languages = Language::getActive();
        foreach ($languages as $language) {
            foreach ($values as $value) {
                $result["meta.{$field}.{$value}_{$language->code}"] = $rules;
            }
        }

        return $result;

    }
}
