<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class DateRangeFilter implements Filter
{
    protected string $column;

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value[0] != '' && $value[1] != '')
            return $query->whereDate($this->column, '>=', Carbon::createFromFormat('Y-m-d', $value[0]))
                ->whereDate($this->column, '<=', Carbon::createFromFormat('Y-m-d', $value[1]));
        elseif ($value[0] != '')
            return $query->whereDate($this->column, '>=', Carbon::createFromFormat('Y-m-d', $value[0]));
        elseif ($value[1] != '')
            return $query->whereDate($this->column, '<=', Carbon::createFromFormat('Y-m-d', $value[1]));
    }
}
