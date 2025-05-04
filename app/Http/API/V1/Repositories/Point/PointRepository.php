<?php

namespace App\Http\API\V1\Repositories\Point;

use App\Enums\PointStatus;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\Point\SimplePointResource;
use App\Models\Point;
use Illuminate\Database\Eloquent\Model;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class PointRepository extends BaseRepository
{
    public function __construct(Point $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::exact('order_id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('used'),
            AllowedFilter::partial('status'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('count'),
            AllowedSort::field('ends_at'),
        ];

        return parent::filter(Point::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexCustomerPoints(): PaginatedData
    {
        $clientCountry = AppHelper::getCoutnryForMobile();
        $points = \Auth::user()->points()->where('country_id', '=', $clientCountry->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('order_id'),
            AllowedFilter::exact('used'),
            AllowedFilter::partial('count'),
            AllowedFilter::partial('status'),
            AllowedFilter::partial('ends_at'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('count'),
            AllowedSort::field('ends_at'),
        ];

        return parent::filter($points, $filters, $sorts);
    }

    public function storePoint($data): Model
    {
        $data['status'] = PointStatus::ACTIVE;
        $data['used'] = false;

        return parent::store($data);
    }

    /**
     * @throws IPinfoException
     */
    public function getLastActivePoint(): ?SimplePointResource
    {
        $clientCountry = AppHelper::getCoutnryForMobile();
        $user = \Auth::user();
        $lastPoint = null;
        if ($user->points()->where('country_id', $clientCountry->id)->count() > 0)
            $lastPoint = new SimplePointResource($user->points()->where('country_id', '=', $clientCountry->id)->where(['status' => PointStatus::ACTIVE])->orderByDesc('id')->first());

        return $lastPoint;
    }
}
