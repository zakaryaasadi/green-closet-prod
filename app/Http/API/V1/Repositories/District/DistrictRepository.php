<?php

namespace App\Http\API\V1\Repositories\District;

use App\Filters\CountryCustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\District;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class DistrictRepository extends BaseRepository
{
    public function __construct(District $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('province_id'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name'], ['name'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('province_id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(District::class, $filters, $sorts);
    }
}
