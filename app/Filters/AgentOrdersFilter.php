<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class AgentOrdersFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (is_array($value)) {
            $value = implode(' ', $value);
        }
        $query->WhereHas('customer', function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%')
            ->orWhere('phone', 'like', '%' . $value . '%');
        })->orWhere('id', '=', $value)
        ->where('agent_id', '=', \Auth::id());

        return $query;
    }
}
