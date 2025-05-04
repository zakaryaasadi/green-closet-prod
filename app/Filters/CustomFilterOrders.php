<?php

namespace App\Filters;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomFilterOrders implements Filter
{
    public function __construct()
    {
    }

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        $languages = Language::getActive();

        $query->whereHas('agent', function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        })->orWhereHas('customer', function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        })->orWhereHas('association', function ($query) use ($value, $languages) {
            $query->where(function ($query) use ($value, $languages) {
                foreach ($languages as $language) {
                    $query->orWhere('meta->translate->title_' . $language->code, 'like', "%$value%");
                }
            });


        });

        return $query;
    }
}
