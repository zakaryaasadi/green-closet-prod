<?php

namespace App\Http\API\V1\Repositories\Activity;

use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Activity;
use App\Models\Container;
use App\Models\Order;
use App\Traits\ApiResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class ActivityRepository extends BaseRepository
{
    use  ApiResponse;

    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('causer_id'),
            AllowedFilter::exact('subject_id'),
            AllowedFilter::partial('description'),
            AllowedFilter::partial('subject_type'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('causer_id'),
            AllowedSort::field('description'),
        ];

        return parent::filter(Activity::class, $filters, $sorts);
    }

    public function getOrderLog(Order $order): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('causer_id'),
            AllowedFilter::exact('subject_id'),
            AllowedFilter::partial('description'),
            AllowedFilter::partial('subject_type'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('causer_id'),
            AllowedSort::field('description'),
        ];

        return parent::filter(Activity::forSubject($order), $filters, $sorts);
    }

    public function getContainerLog(Container $container): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('causer_id'),
            AllowedFilter::exact('subject_id'),
            AllowedFilter::partial('description'),
            AllowedFilter::partial('subject_type'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('causer_id'),
            AllowedSort::field('description'),
        ];

        return parent::filter(Activity::forSubject($container), $filters, $sorts);
    }
}
