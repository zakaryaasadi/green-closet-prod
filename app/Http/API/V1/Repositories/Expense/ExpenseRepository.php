<?php

namespace App\Http\API\V1\Repositories\Expense;

use App\Filters\DateRangeFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Association;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class ExpenseRepository extends BaseRepository
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('association_id'),
            AllowedFilter::exact('status'),
            AllowedFilter::callback('country_id', function (Builder $query, $value) {
                $query->whereHas('association', function ($query) use ($value) {
                    return $query->where('country_id', '=', $value);
                });
            }),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('status'),
            AllowedSort::field('value'),
            AllowedSort::field('weight'),
            AllowedSort::field('date'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Expense::class, $filters, $sorts);
    }

    public function indexAssociationExpenses(Association $association): PaginatedData
    {
        $expenses = Expense::whereAssociationId($association->id);
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('containers_count'),
            AllowedFilter::partial('orders_count'),
            AllowedFilter::partial('orders_weight'),
            AllowedFilter::partial('containers_weight'),
            AllowedFilter::partial('weight'),
            AllowedFilter::partial('value'),
            AllowedFilter::exact('status'),
            AllowedFilter::custom('date_range', new DateRangeFilter('created_at')),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('value'),
            AllowedSort::field('weight'),
            AllowedSort::field('date'),
            AllowedSort::field('containers_count'),
            AllowedSort::field('orders_count'),
            AllowedSort::field('orders_weight'),
            AllowedSort::field('containers_weight'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($expenses, $filters, $sorts);
    }
}
