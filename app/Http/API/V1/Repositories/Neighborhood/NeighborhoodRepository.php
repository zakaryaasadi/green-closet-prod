<?php

namespace App\Http\API\V1\Repositories\Neighborhood;

use App\Filters\CountryCustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Neighborhood;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class NeighborhoodRepository extends BaseRepository
{
    public function __construct(Neighborhood $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('district_id'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name'], ['name'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('district_id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Neighborhood::class, $filters, $sorts);
    }
}
