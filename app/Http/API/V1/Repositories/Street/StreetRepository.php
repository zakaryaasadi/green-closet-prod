<?php

namespace App\Http\API\V1\Repositories\Street;

use App\Filters\CountryCustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Street;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class StreetRepository extends BaseRepository
{
    public function __construct(Street $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('neighborhood_id'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name'], ['name'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('neighborhood_id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Street::class, $filters, $sorts);
    }
}
