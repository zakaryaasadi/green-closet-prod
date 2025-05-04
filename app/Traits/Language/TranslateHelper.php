<?php

namespace App\Traits\Language;

use Exception;

trait TranslateHelper
{
    public function getTranslateValue($locale, $meta, $value, $default)
    {
        try {
            $translate = $meta['translate'];
            $key = $value . '_' . $locale;

            return $translate[$key];
        } catch (Exception $e) {
        }

        return $default;
    }

    public function getTranslateKiswa($locale): string
    {
        if ($locale == 'en')
            return 'Recycle';
        else return 'تدوير';
    }
}
