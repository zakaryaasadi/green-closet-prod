<?php

namespace App\Filters;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomFilterContainers implements Filter
{
    public function __construct()
    {
    }

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $languages = Language::getActive();

        $query->whereHas('association', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->title_' . $language->code, 'like', "%$value%");
                }
            });
        })->orWhereHas('team', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->name_' . $language->code, 'like', "%$value%");
                }
            });
        })->orWhereHas('province', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->name_' . $language->code, 'like', "%$value%");
                }
            });
        })->orWhereHas('district', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->name_' . $language->code, 'like', "%$value%");
                }
            });
        })->orWhereHas('neighborhood', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->name_' . $language->code, 'like', "%$value%");
                }
            });
        })->orWhereHas('street', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->name_' . $language->code, 'like', "%$value%");
                }
            });
        })->orWhere('location_description', 'like', "%$value%");

        return $query;
    }
}
