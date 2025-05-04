<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class PhoneCustomFilter implements Filter
{
    public function __construct()
    {
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        return $query->where('phone', 'like', "%$value");
    }
}
