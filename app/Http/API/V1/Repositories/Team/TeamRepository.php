<?php

namespace App\Http\API\V1\Repositories\Team;

use App\Filters\CustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\Team\TeamWithCustomAgentsResource;
use App\Models\Location;
use App\Models\Order;
use App\Models\Team;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point as GeometryPoint;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class TeamRepository extends BaseRepository
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CustomFilter(['name'], ['name'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('country_id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Team::class, $filters, $sorts);
    }

    public function indexTeamAgents(Team $team): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('email'),
            AllowedFilter::partial('phone'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'email', 'phone'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('description'),
        ];

        return $this->filter($team->agents(), $filters, $sorts);
    }

    public function storeTeam(Collection $data): Team
    {
        $team = new Team($data->all());
        $team->save();
        $team->refresh();
        if($data->has('agents_ids'))
            foreach ($data->get('agents_ids') as $id)
                $team->agents()->save(User::whereId($id)->first());

        return $team;
    }

    public function updateTeam(Team $team, Collection $data): \Illuminate\Database\Eloquent\Model
    {
        $team = $this->updateWithMeta($team, $data->all());
        if ($data->has('agents_ids')) {
            $team->agents()->update(['team_id' => null]);
            $team->agents()->update(['location_id' => null]);
            foreach ($data->get('agents_ids') as $id)
                $team->agents()->save(User::whereId($id)->first());
        }

        return $team;
    }

    public function getTeamByGeo($data, Order $order): array
    {
        if (isset($data['lat']) && isset($data['lng']))
        {
            $lat = $data['lat'];
            $lng = $data['lng'];
        }
        else {
            $location = $order->location;
            $lat = $location->getLat();
            $lng = $location->getLng();
        }
        $locations = Location::contains('area', new GeometryPoint($lat, $lng))->get();
        $teams = [];
        foreach ($locations as $location)
            $teams[] = new TeamWithCustomAgentsResource($location->team, $location->id);

        return $teams;
    }
}
