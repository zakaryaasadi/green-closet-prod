<?php

namespace App\Http\API\V1\Repositories\Target;


use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Target;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class TargetRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(Target $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Target::class, $filters, $sorts);
    }
}
