<?php

namespace App\Http\API\V1\Repositories\Province;

use App\Filters\CountryCustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Province;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class ProvinceRepository extends BaseRepository
{
    public function __construct(Province $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name'], ['name'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Province::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexProvincesForClient(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $provinces = Province::whereCountryId($country->id);
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name'], ['name'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($provinces, $filters, $sorts);
    }
}
