<?php

namespace App\Http\API\V1\Repositories\IP;


use App\Filters\CustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\IP;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class IPRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(IP $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('status'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'ip_address'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(IP::class, $filters, $sorts);
    }
}
