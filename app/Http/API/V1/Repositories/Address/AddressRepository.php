<?php

namespace App\Http\API\V1\Repositories\Address;

use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Address;
use App\Models\Location;
use App\Traits\ApiResponse;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class AddressRepository extends BaseRepository
{
    use  ApiResponse;

    public function __construct(Address $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::partial('location'),
            AllowedFilter::partial('location_title'),
            AllowedFilter::partial('location_province'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('default'),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('user_id'),
            AllowedSort::field('location'),
            AllowedSort::field('location_title'),
            AllowedSort::field('location_province'),
            AllowedSort::field('type'),
            AllowedSort::field('default'),
        ];

        return parent::filter(Address::with(['user', 'province']), $filters, $sorts);

    }

    /**
     * @throws IPinfoException
     */
    public function indexUserAddress(): PaginatedData
    {
        $clientCountry = AppHelper::getCoutnryForMobile();

        $user = Auth::user();

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('location'),
            AllowedFilter::partial('location_title'),
            AllowedFilter::partial('location_province'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('default'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('location'),
            AllowedSort::field('location_title'),
            AllowedSort::field('location_province'),
            AllowedSort::field('type'),
            AllowedSort::field('default'),
        ];
        $addresses = $user->addresses()->where('country_id', $clientCountry->id);

        return parent::filter($addresses, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function storeAddress(Collection $data, $user_id): Address
    {
        $clientCountry = AppHelper::getCoutnryForMobile();

        $address = new Address();
        $address->fill($data->all());
        $location = $data->get('location');
        $address->user_id = $user_id;
        $address->country_id = $clientCountry->id;

        $point = new Point($location['lat'], $location['lng']);
        $address->location = $point;

        $address->location_title = $location['title'];
        $address->province_id = $data->get('province_id');
        $address->location_province = $location['province'];

        $address->save();
        $address->refresh();

        return $address;
    }

    public function updateAddress(Address $address, $data): Address
    {
        $address->fill($data->all());
        if ($data->has('location')) {
            $location = $data->get('location');
            if (array_key_exists('lat', $location) and array_key_exists('lng', $location)) {
                $point = new Point($location['lat'], $location['lng']);
                $address->location = $point;
            }

            if (array_key_exists('title', $location))
                $address->location_title = $location['title'];

            if (array_key_exists('province', $location))
                $address->location_province = $location['province'];
        }

        if ($data->has('user_id'))
            $address->user_id = $data->get('user_id');

        if ($data->has('province_id'))
            $address->province_id = $data->get('province_id');

        $address->save();
        $address->refresh();

        return $address;
    }

    public function checkPointLocation($location_id, $point): bool
    {
        $count = Location::find($location_id)->contains('area', $point)->count();

        return $count > 0;
    }
}
