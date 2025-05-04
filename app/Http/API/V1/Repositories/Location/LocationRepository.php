<?php

namespace App\Http\API\V1\Repositories\Location;

use App\Filters\CountryCustomFilter;
use App\Helpers\SpatialHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class LocationRepository extends BaseRepository
{
    public function __construct(Location $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('team_id'),
            AllowedFilter::callback('team_name', function (Builder $query, $value) {
                $query->whereHas('team', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('name'),
            AllowedFilter::exact('color'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name', 'color'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Location::class, $filters, $sorts);
    }

    public function storeLocation(Collection $data): Location
    {
        $location = Location::create($data->all());
        $polygon = SpatialHelper::getPolygon($data->get('area'));
        $location->area = $polygon;
        $location->save();
        $location->refresh();
        if ($data->has('agents_ids'))
            foreach ($data->get('agents_ids') as $id)
                $location->agents()->save(User::whereId($id)->first());

        return $location;
    }

    public function updateLocation(Location $location, Collection $data): Location
    {
        $location->fill($data->all());
        if ($data->has('area')) {
            $polygon = SpatialHelper::getPolygon($data->get('area'));
            $location->area = $polygon;
            $location->save();
            $location->refresh();
        }
        if ($data->has('agents_ids')) {
            $location->agents()->update(['location_id' => null]);
            foreach ($data->get('agents_ids') as $id)
                $location->agents()->save(User::whereId($id)->first());
        }

        return $location;
    }
}
