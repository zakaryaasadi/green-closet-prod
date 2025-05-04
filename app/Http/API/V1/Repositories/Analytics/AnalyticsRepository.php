<?php

namespace App\Http\API\V1\Repositories\Analytics;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\UserType;
use App\Helpers\AppHelper;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Analytics;
use App\Models\Association;
use App\Models\Container;
use App\Models\ContainerDetails;
use App\Models\Country;
use App\Models\District;
use App\Models\Item;
use App\Models\Location;
use App\Models\Message;
use App\Models\Neighborhood;
use App\Models\Order;
use App\Models\Province;
use App\Models\Setting;
use App\Models\Street;
use App\Models\Target;
use App\Models\Team;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\Language\TranslateHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class AnalyticsRepository extends BaseRepository
{
    use  ApiResponse, TranslateHelper;

    public function __construct(Analytics $model)
    {
        parent::__construct($model);
    }

    public function failedOrdersReport($data): JsonResponse
    {
        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $orders = Order::query()
            ->where('status', '=', OrderStatus::FAILED)
            ->when(isset($data['country_id']), function ($query) use ($data) {
                return $query->where('country_id', $data['country_id']);
            })
            ->when(isset($data['province_id']), function ($query) use ($data) {
                return $query->where('province_id', $data['province_id']);
            })
            ->when(isset($data['district_id']), function ($query) use ($data) {
                return $query->where('district_id', $data['district_id']);
            })
            ->when(isset($data['neighborhood_id']), function ($query) use ($data) {
                return $query->where('neighborhood_id', $data['neighborhood_id']);
            })
            ->when(isset($data['street_id']), function ($query) use ($data) {
                return $query->where('street_id', $data['street_id']);
            })
            ->when(isset($data['association_id']), function ($query) use ($data) {
                return $query->where('association_id', $data['association_id']);
            })
            ->when(isset($data['team_id']), function ($query) use ($data) {
                return $query->where('team_id', $data['team_id']);
            })
            ->when(isset($data['start_date']), function ($query) use ($data, $column) {
                return $query->whereDate($column, '>=', $data['start_date']);
            })
            ->when(isset($data['end_date']), function ($query) use ($data, $column) {
                return $query->whereDate($column, '<=', $data['end_date']);
            });

        $messages = Message::query()
            ->whereIn('type', [MessageType::FAILED_MESSAGE, MessageType::CANCEL_MESSAGE])
            ->when(isset($data['country_id']), function ($query) use ($data) {
                return $query->where('country_id', $data['country_id']);
            })->get();

        $ordersCount = $orders->clone()->count();
        $result = [];
        foreach($messages as $message) {
            $result[] = [
                'message_id' => $message->id,
                'message_content' => $message->content,
                'order_counts' => $messageOrderCount = $orders->clone()->where('message_id', '=', $message->id)->count(),
                'rate' => $ordersCount == 0 ? 0 : round(($messageOrderCount / $ordersCount) * 100, 3),
            ];
        }

        $result[] = [
            'message_id' => 0,
            'message_content' => 'Other',
            'order_counts' => $messageOrderCount = $orders->clone()->whereNull('message_id')->count(),
            'rate' => $ordersCount == 0 ? 0 : round(($messageOrderCount / $ordersCount) * 100, 3),
        ];

        return $this->response('success', $result);
    }

    public function analyticsOrdersStatus(Collection $data): JsonResponse
    {
        $countryId = $data->get('country_id');
        $orders = Order::whereCountryId($countryId);

        $column = 'created_at';
        if ($data->has('date_type') && $data->get('date_type') != null)
            $column = $data->get('date_type');

        if ($data->has('start_date')) {
            $orders = $orders->whereDate($column, '>=', $data->get('start_date'));
        }
        if ($data->has('end_date')) {
            $orders = $orders->whereDate($column, '<=', $data->get('end_date'));
        }

        $ordersRes = [
            'total' => $orders->clone()->count(),

            'created' => $orders->clone()->where('status', '=', OrderStatus::CREATED)->count(),

            'assigned' => $orders->clone()->where('status', '=', OrderStatus::ASSIGNED)->count(),

            'accepted' => $orders->clone()->where('status', '=', OrderStatus::ACCEPTED)->count(),

            'declined' => $orders->clone()->where('status', '=', OrderStatus::DECLINE)->count(),

            'delivering' => $orders->clone()->where('status', '=', OrderStatus::DELIVERING)->count(),

            'canceled' => $orders->clone()->where('status', '=', OrderStatus::CANCEL)->count(),

            'failed' => $orders->clone()->where('status', '=', OrderStatus::FAILED)->count(),

            'successful' => $orders->clone()->where('status', '=', OrderStatus::SUCCESSFUL)->count(),

        ];

        $result = [
            'orders' => $ordersRes,
        ];

        return $this->response('success', $result);

    }

    public function analytics(Collection $data): JsonResponse
    {

        $today = Carbon::today();
        $countryId = $data->get('country_id');

        if ($countryId) {
            $orders = Order::whereCountryId($countryId);
            $users = User::whereCountryId($countryId);
            $containers = Container::whereCountryId($countryId);
        } else {
            $orders = Order::select();
            $users = User::select();
            $containers = Container::select();
        }

        $column = 'created_at';
        if ($data->has('date_type') && $data->get('date_type') != null)
            $column = $data->get('date_type');

        if ($data->has('start_date') && $data->has('end_date')) {
            $orders = $orders->whereDate($column, '>=', $data->get('start_date'))->whereDate($column, '<=', $data->get('end_date'));
        } elseif ($data->has('start_date')) {
            $orders = $orders->whereDate($column, '>=', $data->get('start_date'));
        } elseif ($data->has('end_date')) {
            $orders = $orders->whereDate($column, '<=', $data->get('end_date'));
        } else {
            $orders = $orders->whereDate($column, $today);
        }

        $orders = $orders->get();
        $ordersRes = [
            'total' => $orders->count(),
            'assigned' => $orders->where('status', '=', OrderStatus::ASSIGNED)->count(),
            'created' => $orders->where('status', '=', OrderStatus::CREATED)->count(),
            'accepted' => $orders->where('status', '=', OrderStatus::ACCEPTED)->count(),
            'declined' => $orders->where('status', '=', OrderStatus::DECLINE)->count(),
            'delivering' => $orders->where('status', '=', OrderStatus::DELIVERING)->count(),
            'canceled' => $orders->where('status', '=', OrderStatus::CANCEL)->count(),
            'failed' => $orders->where('status', '=', OrderStatus::FAILED)->count(),
            'successful' => $orders->where('status', '=', OrderStatus::SUCCESSFUL)->count(),
            'postponed' => $orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED])->count(),
        ];

        $containers = $containers->get();
        $containersStatusRes = [
            'total' => $containers->count(),
            'on_the_field' => $containers->where('status', '=', ContainerStatus::ON_THE_FIELD)->count(),
            'hanging' => $containers->where('status', '=', ContainerStatus::HANGING)->count(),
            'in_the_warehouse' => $containers->where('status', '=',
                ContainerStatus::IN_THE_WAREHOUSE)->count(),
            'in_maintenance' => $containers->where('status', '=', ContainerStatus::IN_MAINTENANCE)->count(),
            'scrap' => $containers->where('status', '=', ContainerStatus::SCRAP)->count(),
        ];

        $containersTypeRes = [
            'total' => $containers->count(),
            'clothes' => $containers->where('type', '=', ContainerType::CLOTHES)->count(),
            'shoes' => $containers->where('type', '=', ContainerType::SHOES)->count(),
            'plastic' => $containers->where('type', '=', ContainerType::PLASTIC)->count(),
            'glass' => $containers->where('type', '=', ContainerType::GLASS)->count(),
        ];

        $users = $users->get();
        $usersRes = [
            'total' => $users->count(),
            'clients' => $users->where('type', '=', UserType::CLIENT)->count(),
            'admins' => $users->where('type', '=', UserType::ADMIN)->count(),
            'agents' => $users->where('type', '=', UserType::AGENT)->count(),
            'associations' => $users->where('type', '=', UserType::ASSOCIATION)->count(),
        ];

        $result = [
            'users' => $usersRes,
            'orders' => $ordersRes,
            'containers_status' => $containersStatusRes,
            'containers_types' => $containersTypeRes,
        ];

        return $this->response('success', $result);

    }

    public function analyticsContainersDetails(Collection $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();

        $countryId = $data->get('country_id');
        $per_page = request('per_page') ?? 15;
        $areas = Province::whereCountryId($countryId)->paginate($per_page);
        $column = 'province_id';
        $emptyContainers = 0;
        $containersWeight = 0;
        $containerCount = 0;
        $containerResult = [];

        if ($data->has('neighborhood_id'))
            $areas = Street::whereNeighborhoodId($data->get('neighborhood_id'))->paginate($per_page);

        elseif ($data->has('district_id'))
            $areas = Neighborhood::whereDistrictId($data->get('district_id'))->paginate($per_page);

        elseif ($data->has('province_id'))
            $areas = District::whereProvinceId($data->get('province_id'))->paginate($per_page);

        foreach ($areas as $area) {
            $containersInThisArea = Container::where($column, '=', $area->id);

            if ($data->has('neighborhood_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $data->get('neighborhood_id'))
                    ->where('street_id', '=', $area->id);

            elseif ($data->has('district_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $area->id);

            elseif ($data->has('province_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))->where('district_id', '=', $area->id);

            if ($containersInThisArea) {
                $containerCount = $containersInThisArea->count();
                $containersInThisArea = $containersInThisArea->get();
                foreach ($containersInThisArea as $container) {
                    if ($data->has('start_date') and $data->get('end_date'))
                        $container = $container->details()->whereBetween('date', [$data->get('start_date'), $data->get('end_date')])->get();
                    elseif ($data->has('start_date'))
                        $container = $container->details()->where('date', '>=', $data->get('start_date'))->get();
                    elseif ($data->has('end_date'))
                        $container = $container->details()->where('date', '<=', $data->get('end_date'))->get();
                    else
                        $container = $container->details()->get();

                    $weight = $container->sum('weight');
                    if ($weight != 0)
                        $emptyContainers += 1;
                    $containersWeight += $weight;
                }
            }
            $reach_rate = 0;
            $wight_rate = 0;
            if ($containerCount > 0)
                $reach_rate = $emptyContainers / $containerCount;

            if ($emptyContainers > 0)
                $wight_rate = $containersWeight / $emptyContainers;

            $containerResult[] = [
                'area' => [
                    'id' => $area->id,
                    'name' => $this->getTranslateValue($locale, $area->meta, 'name', $area->name),
                ],
                'total_containers' => $containerCount,
                'empty_containers' => $emptyContainers,
                'containers_weight' => $containersWeight,
                'reach_rate' => $reach_rate,
                'wight_rate' => $wight_rate,
            ];
            $containersWeight = 0;
            $emptyContainers = 0;
        }

        return $this->response('success', $containerResult, ['pagination' => [
            'total' => $areas->total(),
            'per_page' => $areas->perPage(),
            'count' => count($areas->items()),
            'current_page' => $areas->currentPage(),
        ]]);
    }

    public function analyticsContainersUnloading(array $data): JsonResponse
    {
        $countryId = null;
        $provinceId = null;
        $districtId = null;
        $neighborhoodId = null;
        $streetId = null;
        $teamId = null;
        $agentId = null;
        $associationId = null;
        $startDate = null;
        $endDate = null;
        $code = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        if (array_key_exists('code', $data)) {
            $code = $data['code'];
        }
        if (array_key_exists('province_id', $data)) {
            $provinceId = $data['province_id'];
        }
        if (array_key_exists('district_id', $data)) {
            $districtId = $data['district_id'];
        }
        if (array_key_exists('neighborhood_id', $data)) {
            $neighborhoodId = $data['neighborhood_id'];
        }
        if (array_key_exists('street_id', $data)) {
            $streetId = $data['street_id'];
        }
        if (array_key_exists('agent_id', $data)) {
            $agentId = $data['agent_id'];
        }
        if (array_key_exists('team_id', $data)) {
            $teamId = $data['team_id'];
        }
        if (array_key_exists('association_id', $data)) {
            $associationId = $data['association_id'];
        }
        if (array_key_exists('association_id', $data)) {
            $associationId = $data['association_id'];
        }
        if (array_key_exists('start_date', $data)) {
            $startDate = $data['start_date'];
        }
        if (array_key_exists('end_date', $data)) {
            $endDate = $data['end_date'];
        }

        $query = ContainerDetails::query()->with(['container' => function ($query) use (
            $countryId, $associationId, $streetId, $provinceId,
            $teamId, $neighborhoodId, $districtId, $code
        ) {
            return $query->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            })->when($provinceId != null, function ($query) use ($provinceId) {
                return $query->where('province_id', $provinceId);
            })->when($districtId != null, function ($query) use ($districtId) {
                return $query->where('district_id', $districtId);
            })->when($neighborhoodId != null, function ($query) use ($neighborhoodId) {
                return $query->where('neighborhood_id', $neighborhoodId);
            })->when($streetId != null, function ($query) use ($streetId) {
                return $query->where('street_id', $streetId);
            })->when($associationId != null, function ($query) use ($associationId) {
                return $query->where('association_id', $associationId);
            })->when($teamId != null, function ($query) use ($teamId) {
                return $query->where('team_id', $teamId);
            })->when($code != null, function ($query) use ($code) {
                return $query->where('code', 'like', '%' . $code . '%');
            });
        }])->with('agent')->when($startDate != null, function ($query) use ($startDate) {
            return $query->where('date', '>=', $startDate);
        })->when($endDate != null, function ($query) use ($endDate) {
            return $query->where('date', '<=', $endDate);
        })->when($agentId != null, function ($query) use ($agentId) {
            return $query->where('agent_id', $agentId);
        })->orderByDesc('date');

        $allData = [];
        foreach ($query->get() as $containerDetails) {
            if ($containerDetails->container != null) {
                $allData[] = [
                    'id' => $containerDetails->container['id'],
                    'code' => $containerDetails->container['code'],
                    'agent' => $containerDetails->agent['name'],
                    'weight' => $containerDetails['weight'],
                    'value' => $containerDetails['value'],
                    'date' => $containerDetails['date'],
                ];
            }
        }

        return $this->response('success', $allData);


    }

    public function analyticsContainersStatus(Collection $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = $data->get('country_id');
        $areas = Province::whereCountryId($countryId)->get();
        $column = 'province_id';
        $containerResult = [];

        if ($data->has('neighborhood_id'))
            $areas = Street::whereNeighborhoodId($data->get('neighborhood_id'))->get();

        elseif ($data->has('district_id'))
            $areas = Neighborhood::whereDistrictId($data->get('district_id'))->get();

        elseif ($data->has('province_id'))
            $areas = District::whereProvinceId($data->get('province_id'))->get();

        foreach ($areas as $area) {
            $containersInThisArea = Container::where($column, '=', $area->id);

            if ($data->has('neighborhood_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $data->get('neighborhood_id'))
                    ->where('street_id', '=', $area->id);

            elseif ($data->has('district_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $area->id);

            elseif ($data->has('province_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))->where('district_id', '=', $area->id);

            $containerResult[] = [
                'id' => $area->id,
                'name' => $this->getTranslateValue($locale, $area->meta, 'name', $area->name),
                'containers' => [
                    [
                        'key' => 'total',
                        'value' => $containersInThisArea->clone()->count(),
                    ],
                    [
                        'key' => 'on_the_field',
                        'value' => $containersInThisArea->clone()->where('status', '=', ContainerStatus::ON_THE_FIELD)->count(),
                    ],
                    [
                        'key' => 'hanging',
                        'value' => $containersInThisArea->clone()->where('status', '=', ContainerStatus::HANGING)->count(),
                    ],
                    [
                        'key' => 'in_the_warehouse',
                        'value' => $containersInThisArea->clone()->where('status', '=', ContainerStatus::IN_THE_WAREHOUSE)->count(),
                    ],
                    [
                        'key' => 'in_maintenance',
                        'value' => $containersInThisArea->clone()->where('status', '=', ContainerStatus::IN_MAINTENANCE)->count(),
                    ],
                    [
                        'key' => 'scrap',
                        'value' => $containersInThisArea->clone()->where('status', '=', ContainerStatus::SCRAP)->count(),
                    ],
                ],
            ];

        }


        return $this->response('success', $containerResult);
    }

    public function analyticsContainersType(Collection $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = $data->get('country_id');
        $areas = Province::whereCountryId($countryId)->get();
        $column = 'province_id';
        $containerResult = [];

        if ($data->has('neighborhood_id'))
            $areas = Street::whereNeighborhoodId($data->get('neighborhood_id'))->get();

        elseif ($data->has('district_id'))
            $areas = Neighborhood::whereDistrictId($data->get('district_id'))->get();

        elseif ($data->has('province_id'))
            $areas = District::whereProvinceId($data->get('province_id'))->get();

        foreach ($areas as $area) {
            $containersInThisArea = Container::where($column, '=', $area->id);

            if ($data->has('neighborhood_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $data->get('neighborhood_id'))
                    ->where('street_id', '=', $area->id);

            elseif ($data->has('district_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $area->id);

            elseif ($data->has('province_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))->where('district_id', '=', $area->id);


            $containerResult[] = [
                'id' => $area->id,
                'name' => $this->getTranslateValue($locale, $area->meta, 'name', $area->name),
                'containers' => [
                    [
                        'key' => 'total',
                        'value' => $containersInThisArea->clone()->count(),
                    ],
                    [
                        'key' => 'clothes',
                        'value' => $containersInThisArea->clone()->where('type', '=', ContainerType::CLOTHES)->count(),
                    ],
                    [
                        'key' => 'shoes',
                        'value' => $containersInThisArea->clone()->where('type', '=', ContainerType::SHOES)->count(),
                    ],
                    [
                        'key' => 'plastic',
                        'value' => $containersInThisArea->clone()->where('type', '=', ContainerType::PLASTIC)->count(),
                    ],
                    [
                        'key' => 'glass',
                        'value' => $containersInThisArea->clone()->where('type', '=', ContainerType::GLASS)->count(),
                    ],
                ],
            ];
        }

        return $this->response('success', $containerResult);
    }

    public function numberOfContainersForEachAssociation(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();

        $countryId = $data['country_id'];

        $containerResult = [];

        $kiswaContainers = Container::whereAssociationId(null)
            ->where('country_id', $countryId)->count();

        $containerResult[] = [
            'association' => 'Kiswa Company',
            'containers_count' => $kiswaContainers,
        ];

        $associations = Association::whereCountryId($countryId)->get();

        foreach ($associations as $association) {
            $containers = Container::whereAssociationId($association->id)
                ->where('country_id', $countryId);

            if ($containers->get()) {
                if (array_key_exists('status', $data)) {
                    $containers = $containers->where('status', $data['status']);
                }
                if (array_key_exists('type', $data)) {
                    $containers = $containers->where('type', $data['type']);
                }
                if (array_key_exists('discharge_shift', $data)) {
                    $containers = $containers->where('discharge_shift', $data['discharge_shift']);
                }

                if ($containers->count() > 0) {
                    $containerResult[] = [
                        'association' => $this->getTranslateValue($locale, $association->meta, 'title', $association->title),
                        'containers_count' => $containers->count(),
                    ];
                }
            }
        }

        return $this->response('success', $containerResult);

    }

    public function analyticsContainersNotVisited(Collection $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = $data->get('country_id');
        $areas = Province::whereCountryId($countryId)->get();
        $column = 'province_id';
        $containerResult = [];
        $notVisitedContainers = 0;

        if ($data->has('neighborhood_id'))
            $areas = Street::whereNeighborhoodId($data->get('neighborhood_id'))->get();

        elseif ($data->has('district_id'))
            $areas = Neighborhood::whereDistrictId($data->get('district_id'))->get();

        elseif ($data->has('province_id'))
            $areas = District::whereProvinceId($data->get('province_id'))->get();

        foreach ($areas as $area) {

            $containersInThisArea = Container::where($column, '=', $area->id);

            if ($data->has('neighborhood_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $data->get('neighborhood_id'))
                    ->where('street_id', '=', $area->id);

            elseif ($data->has('district_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))
                    ->where('district_id', '=', $data->get('district_id'))
                    ->where('neighborhood_id', '=', $area->id);

            elseif ($data->has('province_id'))
                $containersInThisArea = Container::whereProvinceId($data->get('province_id'))->where('district_id', '=', $area->id);


            if ($containersInThisArea) {
                $containersInThisArea = $containersInThisArea->get();
                foreach ($containersInThisArea as $container) {
                    if ($data->has('start_date') and $data->get('end_date'))
                        $container = $container->details()->whereBetween('date', [$data->get('start_date'), $data->get('end_date')])->get();
                    elseif ($data->has('start_date'))
                        $container = $container->details()->where('date', '>=', $data->get('start_date'))->get();
                    elseif ($data->has('end_date'))
                        $container = $container->details()->where('date', '<=', $data->get('end_date'))->get();
                    else
                        $container = $container->details()->get();

                    $weight = $container->sum('weight');
                    if ($weight == 0)
                        $notVisitedContainers += 1;
                }
            }

            $containerResult[] = [
                'area' => [
                    'id' => $area->id,
                    'name' => $this->getTranslateValue($locale, $area->meta, 'name', $area->name),

                ],
                'not_visited' => $notVisitedContainers,
            ];
            $notVisitedContainers = 0;
        }

        return $this->response('success', $containerResult);
    }

    public function analyticsContainersWeighs(array $data): JsonResponse
    {
        $countryId = $data['country_id'];

        $query = Container::query()
            ->join('container_details', 'container_details.container_id', '=', 'containers.id')
            ->where('containers.country_id', $countryId);


        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('container_details.date', [$data['start_date'], $data['end_date'] . " 23:59"]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('container_details.date', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('container_details.date', '<=', $data['end_date']. " 23:59");
        }

        $query->groupBy('containers.id')
                ->select('containers.id', 'containers.code', \DB::raw('sum(container_details.weight) as weight'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $allItems[] = [
                'id' => $item['id'],
                'code' => $item['code'],
                'weight' => $item['weight'],
            ];
        }

        return $this->response('success', $allItems);


    }

    public function analyticsContainersWeightByTeams(array $data): JsonResponse
    {
        $countryId = $data['country_id'];
        $locale = AppHelper::getLanguageForMobile();


        $query = Team::query()
            ->join('users', 'teams.id', '=', 'users.team_id')
            ->join('container_details', 'container_details.agent_id', '=', 'users.id')
            ->where('users.type', UserType::AGENT)
            ->where('teams.country_id', $countryId);

        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('container_details.date', [$data['start_date'], $data['end_date']]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('container_details.date', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('container_details.date', '<=', $data['end_date']);
        }
        $query->groupBy('teams.id')
            ->select('teams.id', 'teams.name', 'teams.meta as meta', \DB::raw('sum(container_details.weight) as weight'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $allItems[] = [
                'name' => $this->getTranslateValue($locale, $item['meta'], 'name', $item['name']),
                'weight' => $item['weight'],
                'id' => $item['id'],
            ];
        }

        return $this->response('success', $allItems);
    }

    public function analyticsWeightOrdersForItems(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = $data['country_id'];

        $query = Item::query()
            ->join('item_orders', 'item_orders.item_id', '=', 'items.id')
            ->join('orders', 'item_orders.order_id', '=', 'orders.id')
            ->where('orders.status', OrderStatus::SUCCESSFUL)
            ->where('orders.country_id', $countryId);

        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('orders.ends_at', [$data['start_date'], $data['end_date']]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('orders.ends_at', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('orders.ends_at', '<=', $data['end_date']);
        }
        $query->groupBy('items.id')
            ->select('items.id', 'items.title', 'items.meta as meta', \DB::raw('sum(item_orders.weight) as weight'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $allItems[] = [
                'name' => $this->getTranslateValue($locale, $item['meta'], 'title', $item['title']),
                'weight' => $item['weight'],
                'id' => $item['weight'],
            ];
        }

        return $this->response('success', $allItems);
    }

    public function analyticsNumberOfOrdersForItems(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = $data['country_id'];

        $query = Item::query()
            ->join('item_orders', 'item_orders.item_id', '=', 'items.id')
            ->join('orders', 'item_orders.order_id', '=', 'orders.id')
            ->where('orders.status', OrderStatus::SUCCESSFUL)
            ->where('orders.country_id', $countryId);

        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('orders.ends_at', [$data['start_date'], $data['end_date']]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('orders.ends_at', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('orders.ends_at', '<=', $data['end_date']);
        }
        $query->groupBy('items.id')
            ->select('items.id', 'items.title', 'items.meta as meta', \DB::raw('count(*) as count'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $allItems[] = [
                'name' => $this->getTranslateValue($locale, $item['meta'], 'title', $item['title']),
                'count' => $item['count'],
                'id' => $item['id'],
            ];
        }

        return $this->response('success', $allItems);
    }

    public function analyticsOrdersWeightByTeams(array $data): JsonResponse
    {
        $countryId = $data['country_id'];
        $locale = AppHelper::getLanguageForMobile();
        $query = Team::query()
            ->join('users', 'teams.id', '=', 'users.team_id')
            ->join('orders', 'orders.agent_id', '=', 'users.id')
            ->where('users.type', UserType::AGENT)
            ->where('orders.status', OrderStatus::SUCCESSFUL)
            ->where('teams.country_id', $countryId);

        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('orders.ends_at', [$data['start_date'], $data['end_date']]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('orders.ends_at', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('orders.ends_at', '<=', $data['end_date']);
        }
        $query->groupBy('teams.id')
            ->select('teams.id', 'teams.name', 'teams.meta as meta', \DB::raw('sum(orders.weight) as weight'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $allItems[] = [
                'name' => $this->getTranslateValue($locale, $item['meta'], 'name', $item['name']),
                'weight' => $item['weight'],
                'id' => $item['id'],
            ];
        }

        return $this->response('success', $allItems);
    }

    public function dailyReport(array $data): JsonResponse
    {
        $containersUpLimit = 0;
        $containersDownLimit = 0;

        $emptiedContainers = 0;
        $emptyContainers = 0;
        $containersWeight = 0;

        $today = Carbon::now()->toDateString();

        if (array_key_exists('country_id', $data)) {
            $orders = Order::whereCountryId($data['country_id'])->whereRaw('DATE(created_at) = ?', [$today]);
            $containers = Container::whereCountryId($data['country_id'])->get();
            $settings = Setting::whereCountryId($data['country_id'])->first();
            $newUsers = User::where(['type' => UserType::CLIENT, 'country_id' => $data['country_id']])
                ->whereRaw('DATE(created_at) = ?', [$today]);
        } else {
            $containers = Container::all();
            $orders = Order::whereRaw('DATE(created_at) = ?', [$today]);
            $settings = Setting::whereCountryId(null)->first();
            $newUsers = User::whereType(UserType::CLIENT)->whereRaw('DATE(created_at) = ?', [$today]);
        }
        if (!$settings) {
            $settings = Setting::whereCountryId(null)->first();
        }
        foreach ($containers as $container) {
            $containerDetails = $container->details()->whereDate('date', $today)->get();
            if ($containerDetails->count() > 0) {
                $visitCount = $containerDetails->count();
                $weight = $containerDetails->sum('weight');
                $containersWeight = +$containersWeight + $weight;
                if ($weight > 0) {
                    if (($weight / $visitCount) > 0) {
                        $emptiedContainers = $emptiedContainers + 1;
                    } else {
                        $emptyContainers = $emptyContainers + 1;
                    }
                }
                if ($weight > $settings->container_limit) {
                    $containersUpLimit = $containersUpLimit + 1;
                } else {
                    $containersDownLimit = $containersDownLimit + 1;
                }
            }
        }
        $result = [
            'containers_up_limit' => $containersUpLimit,
            'containers_down_limit' => $containersDownLimit,
            'emptied_containers' => $emptiedContainers,
            'empty_containers' => $emptyContainers,
            'containers_weight' => $containersWeight,
            'total_orders' => $orders->clone()->count(),
            'new_users' => $newUsers->clone()->count(),
            'orders_weight' => $orders->sum('weight'),
            'active_containers' => $containers->where('status', '=', ContainerStatus::ON_THE_FIELD)->count(),
        ];

        return $this->response('success', $result);
    }

    public function dailyReportOrders(array $data): JsonResponse
    {
        $totalOrders = 0;
        $locale = AppHelper::getLanguageForMobile();
        $res = [];
        $today = Carbon::now()->toDateString();
        if (array_key_exists('country_id', $data)) {
            $provinces = Province::whereCountryId($data['country_id'])->get();
        } else {
            $provinces = Province::all();
        }
        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        foreach ($provinces as $province) {
            $orders = $province->orders();
            if ($orders->count() > 0) {
                $ordersCount = 0;
                if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data))
                    $ordersResult = $orders->whereDate($column, '>=', $data['start_date'])->whereDate($column, '<=', $data['end_date'])->get();
                elseif (array_key_exists('start_date', $data)) {
                    $ordersResult = $orders->whereDate($column, '>=', $data['start_date'])->get();
                } elseif (array_key_exists('end_date', $data))
                    $ordersResult = $orders->whereDate($column, '<=', $data['end_date'])->get();
                else
                    $ordersResult = $orders->whereDate($column, $today)->get();

                $ordersCount = $ordersCount + $ordersResult->count();
                $totalOrders = $totalOrders + $ordersCount;
                $res[] = [
                    'province_name' => $this->getTranslateValue($locale, $province->meta, 'name', $province->name),
                    'orders_count' => $ordersCount,
                ];
            }
        }
        $data = [
            'total_orders' => $totalOrders,
            'orders' => $res,
        ];

        return $this->response('success', $data);
    }

    public function dailyReportContainers(array $data): JsonResponse
    {
        $totalWeight = 0;
        $locale = AppHelper::getLanguageForMobile();
        $today = Carbon::now()->toDateString();
        $countryId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }

        $query = Province::query()
            ->join('containers', 'provinces.id', '=', 'containers.province_id')
            ->join('container_details', 'container_details.container_id', '=', 'containers.id')
            ->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('provinces.country_id', $countryId);
            });

        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('container_details.date', [$data['start_date'], $data['end_date']]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('container_details.date', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('container_details.date', '<=', $data['end_date']);
        } else
            $query->whereDate('container_details.date', '=', $today);

        $query->groupBy('provinces.id')
            ->select('provinces.name', 'provinces.meta as meta',
                \DB::raw('sum(container_details.weight) as weight'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $totalWeight = $totalWeight + $item['weight'];
            $allItems[] = [
                'province_name' => $this->getTranslateValue($locale, $item['meta'], 'name', $item['name']),
                'weight' => $item['weight'],
            ];
        }
        $res = [
            'total_weight' => $totalWeight,
            'containers' => $allItems,
        ];

        return $this->response('success', $res);
    }

    public function bestContainers(array $data): JsonResponse
    {
        $today = Carbon::now()->toDateString();
        $countryId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        $query = Container::query();
        $query->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('country_id', $countryId);
        });
        $query->join('container_details', 'containers.id', '=', 'container_details.container_id');

        $startDate = $endDate = null;

        if (array_key_exists('province_id', $data)) {
            $query->where('containers.province_id', '=', $data['province_id']);
        }
        if (array_key_exists('start_date', $data)) {
            $startDate = $data['start_date'];
            $query->where('container_details.date', '>=', $startDate);
        }
        if (array_key_exists('end_date', $data)) {
            $endDate = $data['end_date'];
            $query->where('container_details.date', '<=', $endDate);
        }
        if ($startDate == null && $endDate == null) {
            $query->whereDate('container_details.date', $today);
        }
        $query->groupBy('container_details.container_id')
            ->select('containers.code',
                \DB::raw('sum(container_details.weight) / count(container_details.id) as value'));

        $data = $query->get();
        $topTen = $data->sortByDesc('value')->take(10);
        $lastTen = $data->sortBy('value')->take(10);


        $res = [
            'top_ten_containers' => $topTen,
            'last_ten_containers' => $lastTen->values()->all(),
        ];

        return $this->response('success', $res);
    }

    public function dailyReportContainersCount(array $data): JsonResponse
    {
        $totalWeight = 0;
        $locale = AppHelper::getLanguageForMobile();
        $today = Carbon::now()->toDateString();
        $countryId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        $query = Province::query()
            ->join('containers', 'provinces.id', '=', 'containers.province_id')
            ->join('container_details', 'container_details.container_id', '=', 'containers.id')
            ->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('provinces.country_id', $countryId);
            });

        if (array_key_exists('start_date', $data) and array_key_exists('end_date', $data)) {
            $query->whereBetween('container_details.date', [$data['start_date'], $data['end_date']]);
        } elseif (array_key_exists('start_date', $data)) {
            $query->where('container_details.date', '>=', $data['start_date']);
        } elseif (array_key_exists('end_date', $data)) {
            $query->where('container_details.date', '<=', $data['end_date']);
        } else
            $query->whereDate('container_details.date', '=', $today);

        $query->groupBy('containers.province_id')
            ->select('provinces.name', 'provinces.meta as meta',
                \DB::raw('count(container_details.container_id) as count'));

        $allItems = [];
        $items = $query->get();
        foreach ($items as $item) {
            $totalWeight = $totalWeight + $item['count'];
            $allItems[] = [
                'province_name' => $this->getTranslateValue($locale, $item['meta'], 'name', $item['name']),
                'count' => $item['count'],
            ];
        }
        $res = [
            'total_count' => $totalWeight,
            'containers' => $allItems,
        ];

        return $this->response('success', $res);
    }

    public function analyticsAgents(Collection $data): JsonResponse
    {

        $totalDonationOrder = 0;
        $totalRecyclingOrder = 0;
        $totalContainerWeight = 0;
        $totalWeight = 0;
        $totalWeightTarget = 0;
        $totalOrderTarget = 0;
        $totalOrderAccessRate = 0;
        $totalWeightAccessRate = 0;
        $totalSuccessfulOrder = 0;
        $totalSuccessfulOrderRate = 0;
        $totalCanceledOrder = 0;
        $totalCanceledOrderRate = 0;
        $totalPostponedOrder = 0;
        $totalPostponedOrderRate = 0;
        $totalOrderCount = 0;
        $totalUnloadingContainerCount = 0;

        $weightTarget = 0;
        $orderTarget = 0;
        $agentAnalytics = [];

        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $total = [];
        if ($data->has('country_id')) {
            $agents = User::where(['country_id' => $data->get('country_id'), 'type' => UserType::AGENT])->get();
            $weightTarget = Target::whereCountryId($data->get('country_id'));
            $orderTarget = Target::whereCountryId($data->get('country_id'));
        } else {
            $agents = User::whereType(UserType::AGENT)->get();
            $weightTarget = Target::where(['country_id' => Setting::where(['country_id' => null])->first()->default_country_id]);
            $orderTarget = Target::where(['country_id' => Setting::where(['country_id' => null])->first()->default_country_id]);
        }


        //Orders and containers
        if ($data->has('start_date') && $data->has('end_date')) {
            $start_date = Carbon::parse($data->get('start_date'));
            $end_date = Carbon::parse($data->get('end_date'));
            $weightTarget = $weightTarget
                ->where('month', '>=', $start_date->month)
                ->where('month', '<=', $end_date->month)
                ->sum('weight_target');
            $orderTarget = $orderTarget
                ->where('month', '>=', $start_date->month)
                ->where('month', '<=', $end_date->month)
                ->sum('orders_count');
            foreach ($agents as $agent) {
                $totalAgentWeight = 0;
                $ordersCount = 0;
                $ordersSuccessfulCount = 0;
                $ordersCanceledCount = 0;
                $access_rate_to_order_target = 0;
                $access_rate_to_weight_target = 0;
                $ordersPostponedCount = 0;
                $OrdersSuccessRatio = 0;
                $OrdersCanceledRatio = 0;
                $OrdersPostponedRatio = 0;
                $ordersTotalWeight = 0;
                $ordersRecyclingTotalWeight = 0;
                $ordersDonationTotalWeight = 0;
                $containersWeight = 0;
                $containerUnloadingCount = 0;
                if ($agent->agentOrders()->count() > 0) {
                    $orderRange = $agent->agentOrders()
                        ->whereDate($column, '>=', $data->get('start_date'))
                        ->whereDate($column, '<=', $data->get('end_date'));

                    if ($data->has('province_id'))
                        $orderRange = $orderRange->where('province_id', '=', $data->get('province_id'));
                    $ordersCount = $orderRange->clone()->count();
                    $ordersSuccessfulCount = $orderRange->clone()
                        ->where('status', '=', OrderStatus::SUCCESSFUL)->count();
                    $ordersCanceledCount = $orderRange->clone()
                        ->whereIn('status', [OrderStatus::FAILED, OrderStatus::CANCEL])->count();
                    $ordersPostponedCount = $orderRange->clone()
                        ->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED])->count();
                    $OrdersSuccessRatio = 0;
                    $OrdersCanceledRatio = 0;
                    $OrdersPostponedRatio = 0;
                    if ($ordersCount != 0) {
                        $OrdersSuccessRatio = round(($ordersSuccessfulCount / $ordersCount) * 100, 1);
                        $OrdersCanceledRatio = round(($ordersCanceledCount / $ordersCount) * 100, 1);
                        $OrdersPostponedRatio = round(($ordersPostponedCount / $ordersCount) * 100, 1);
                    }
                    $ordersTotalWeight = $orderRange->clone()
                        ->sum('weight');
                    $ordersRecyclingTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::RECYCLING)->sum('weight');
                    $ordersDonationTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::DONATION)->sum('weight');
                }
                if ($agent->containerDetails()->count() > 0) {
                    if ($data->has('province_id')) {
                        $containersWeight = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->whereBetween('date', [$data->get('start_date'), $data->get('end_date')])
                            ->sum('weight');
                        $containerUnloadingCount = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->whereBetween('date', [$data->get('start_date'), $data->get('end_date')])
                            ->count();
                    } else {
                        $containersWeight = $agent->containerDetails()
                            ->whereBetween('date', [$data->get('start_date'), $data->get('end_date')])
                            ->sum('weight');
                        $containerUnloadingCount = $agent->containerDetails()
                            ->whereBetween('date', [$data->get('start_date'), $data->get('end_date')])
                            ->count();
                    }
                }

                $totalAgentWeight = $containersWeight + $ordersTotalWeight;

                if ($orderTarget > 0)
                    $access_rate_to_order_target = round(($ordersSuccessfulCount / $orderTarget) * 100, 1);

                if ($weightTarget > 0)
                    $access_rate_to_weight_target = round(($totalAgentWeight / $weightTarget) * 100, 1);

                $agentAnalytics[] = [
                    'agent_id' => $agent->id,
                    'agent_name' => $agent->name,
                    'total_weight' => $totalAgentWeight,
                    'total_orders_count' => $ordersCount,
                    'orders_successful_count' => $ordersSuccessfulCount,
                    'orders_canceled_count' => $ordersCanceledCount,
                    'orders_postponed_count' => $ordersPostponedCount,
                    'orders_successful_ratio' => $OrdersSuccessRatio . '%',
                    'orders_canceled_ratio' => $OrdersCanceledRatio . '%',
                    'orders_postponed_ratio' => $OrdersPostponedRatio . '%',
                    'total_orders_weight' => $ordersTotalWeight,
                    'total_recycling_orders_weight' => $ordersRecyclingTotalWeight,
                    'total_donation_orders_weight' => $ordersDonationTotalWeight,
                    'total_containers_weight' => $containersWeight,
                    'total_containers_unloading_count' => $containerUnloadingCount,
                    'order_target' => $orderTarget,
                    'weight_target' => $weightTarget,
                    'access_rate_to_order_target' => $access_rate_to_order_target . '%',
                    'access_rate_to_weight_target' => $access_rate_to_weight_target . '%',
                ];

                $totalRecyclingOrder += $ordersRecyclingTotalWeight;
                $totalDonationOrder += $ordersDonationTotalWeight;
                $totalContainerWeight += $containersWeight;
                $totalWeight += $totalAgentWeight;
                $totalWeightTarget += $weightTarget;
                $totalOrderTarget += $orderTarget;
                $totalOrderAccessRate += $access_rate_to_order_target;
                $totalWeightAccessRate += $access_rate_to_weight_target;
                $totalSuccessfulOrder += $ordersSuccessfulCount;
                $totalCanceledOrder += $ordersCanceledCount;
                $totalPostponedOrder += $ordersPostponedCount;
                $totalOrderCount += $ordersCount;
                $totalUnloadingContainerCount += $containerUnloadingCount;
            }

            if ($totalOrderCount > 0) {
                $totalSuccessfulOrderRate = round(($totalSuccessfulOrder / $totalOrderCount) * 100, 1);
                $totalCanceledOrderRate = round(($totalCanceledOrder / $totalOrderCount) * 100, 1);
                $totalPostponedOrderRate = round(($totalPostponedOrder / $totalOrderCount) * 100, 1);
            }


            $total = [
                'total_recycling_order' => $totalRecyclingOrder,
                'total_donation_order' => $totalDonationOrder,
                'total_container_weight' => $totalContainerWeight,
                'total_weight' => $totalWeight,
                'total_weight_target' => $totalWeightTarget,
                'total_order_target' => $totalOrderTarget,
                'total_order_target_access_rate' => $totalOrderAccessRate . '%',
                'total_order_weight_access_rate' => $totalWeightAccessRate . '%',
                'total_successful_order' => $totalSuccessfulOrder,
                'total_successful_order_rate' => $totalSuccessfulOrderRate . '%',
                'total_canceled_order' => $totalCanceledOrder,
                'total_canceled_order_rate' => $totalCanceledOrderRate . '%',
                'total_postponed_order' => $totalPostponedOrder,
                'total_postponed_order_rate' => $totalPostponedOrderRate . '%',
                'total_order_count' => $totalOrderCount,
                'total_unloading_container_count' => $totalUnloadingContainerCount,
            ];
        } elseif ($data->has('start_date')) {
            $start_date = Carbon::parse($data->get('start_date'));
            $weightTarget = $weightTarget
                ->where('month', '>=', $start_date->month)
                ->sum('weight_target');
            $orderTarget = $orderTarget
                ->where('month', '>=', $start_date->month)
                ->sum('orders_count');
            foreach ($agents as $agent) {
                $totalAgentWeight = 0;
                $ordersCount = 0;
                $ordersSuccessfulCount = 0;
                $ordersCanceledCount = 0;
                $access_rate_to_order_target = 0;
                $access_rate_to_weight_target = 0;
                $ordersPostponedCount = 0;
                $OrdersSuccessRatio = 0;
                $OrdersCanceledRatio = 0;
                $OrdersPostponedRatio = 0;
                $ordersTotalWeight = 0;
                $ordersRecyclingTotalWeight = 0;
                $ordersDonationTotalWeight = 0;
                $containersWeight = 0;
                $containerUnloadingCount = 0;
                if ($agent->agentOrders()->count() > 0) {
                    $orderRange = $agent->agentOrders()
                        ->whereDate($column, '>=', $data->get('start_date'));
                    if ($data->has('province_id'))
                        $orderRange = $orderRange->where('province_id', '=', $data->get('province_id'));
                    $ordersCount = $orderRange->clone()->count();
                    $ordersSuccessfulCount = $orderRange->clone()
                        ->where('status', '=', OrderStatus::SUCCESSFUL)->count();
                    $ordersCanceledCount = $orderRange->clone()
                        ->whereIn('status', [OrderStatus::FAILED, OrderStatus::CANCEL])->count();
                    $ordersPostponedCount = $orderRange->clone()
                        ->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED])->count();
                    $OrdersSuccessRatio = 0;
                    $OrdersCanceledRatio = 0;
                    $OrdersPostponedRatio = 0;
                    if ($ordersCount != 0) {
                        $OrdersSuccessRatio = round(($ordersSuccessfulCount / $ordersCount) * 100, 1);
                        $OrdersCanceledRatio = round(($ordersCanceledCount / $ordersCount) * 100, 1);
                        $OrdersPostponedRatio = round(($ordersPostponedCount / $ordersCount) * 100, 1);
                    }
                    $ordersTotalWeight = $orderRange->clone()
                        ->sum('weight');
                    $ordersRecyclingTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::RECYCLING)->sum('weight');
                    $ordersDonationTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::DONATION)->sum('weight');
                }
                if ($agent->containerDetails()->count() > 0) {
                    if ($data->has('province_id')) {
                        $containersWeight = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->where('date', '>=', $data->get('start_date'))
                            ->sum('weight');

                        $containerUnloadingCount = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->where('date', '>=', $data->get('start_date'))
                            ->count();
                    } else {
                        $containersWeight = $agent->containerDetails()
                            ->where('date', '>=', $data->get('start_date'))
                            ->sum('weight');
                        $containerUnloadingCount = $agent->containerDetails()
                            ->where('date', '>=', $data->get('start_date'))
                            ->count();
                    }
                }
                $totalAgentWeight = $containersWeight + $ordersTotalWeight;
                if ($orderTarget > 0)
                    $access_rate_to_order_target = round(($ordersSuccessfulCount / $orderTarget) * 100, 1);

                if ($weightTarget > 0)
                    $access_rate_to_weight_target = round(($totalAgentWeight / $weightTarget) * 100, 1);

                $agentAnalytics[] = [
                    'agent_id' => $agent->id,
                    'agent_name' => $agent->name,
                    'total_weight' => $totalAgentWeight,
                    'total_orders_count' => $ordersCount,
                    'orders_successful_count' => $ordersSuccessfulCount,
                    'orders_canceled_count' => $ordersCanceledCount,
                    'orders_postponed_count' => $ordersPostponedCount,
                    'orders_successful_ratio' => $OrdersSuccessRatio . '%',
                    'orders_canceled_ratio' => $OrdersCanceledRatio . '%',
                    'orders_postponed_ratio' => $OrdersPostponedRatio . '%',
                    'total_orders_weight' => $ordersTotalWeight,
                    'total_recycling_orders_weight' => $ordersRecyclingTotalWeight,
                    'total_donation_orders_weight' => $ordersDonationTotalWeight,
                    'total_containers_weight' => $containersWeight,
                    'total_containers_unloading_count' => $containerUnloadingCount,
                    'order_target' => $orderTarget,
                    'weight_target' => $weightTarget,
                    'access_rate_to_order_target' => $access_rate_to_order_target . '%',
                    'access_rate_to_weight_target' => $access_rate_to_weight_target . '%',
                ];

                $totalRecyclingOrder += $ordersRecyclingTotalWeight;
                $totalDonationOrder += $ordersDonationTotalWeight;
                $totalContainerWeight += $containersWeight;
                $totalWeight += $totalAgentWeight;
                $totalWeightTarget += $weightTarget;
                $totalOrderTarget += $orderTarget;
                $totalOrderAccessRate += $access_rate_to_order_target;
                $totalWeightAccessRate += $access_rate_to_weight_target;
                $totalSuccessfulOrder += $ordersSuccessfulCount;
                $totalCanceledOrder += $ordersCanceledCount;
                $totalPostponedOrder += $ordersPostponedCount;
                $totalOrderCount += $ordersCount;
                $totalUnloadingContainerCount += $containerUnloadingCount;
            }
            if ($totalOrderCount > 0) {
                $totalSuccessfulOrderRate = round(($totalSuccessfulOrder / $totalOrderCount) * 100, 1);
                $totalCanceledOrderRate = round(($totalCanceledOrder / $totalOrderCount) * 100, 1);
                $totalPostponedOrderRate = round(($totalPostponedOrder / $totalOrderCount) * 100, 1);
            }

            $total = [
                'total_recycling_order' => $totalRecyclingOrder,
                'total_donation_order' => $totalDonationOrder,
                'total_container_weight' => $totalContainerWeight,
                'total_weight' => $totalWeight,
                'total_weight_target' => $totalWeightTarget,
                'total_order_target' => $totalOrderTarget,
                'total_order_target_access_rate' => $totalOrderAccessRate . '%',
                'total_order_weight_access_rate' => $totalWeightAccessRate . '%',
                'total_successful_order' => $totalSuccessfulOrder,
                'total_successful_order_rate' => $totalSuccessfulOrderRate . '%',
                'total_canceled_order' => $totalCanceledOrder,
                'total_canceled_order_rate' => $totalCanceledOrderRate . '%',
                'total_postponed_order' => $totalPostponedOrder,
                'total_postponed_order_rate' => $totalPostponedOrderRate . '%',
                'total_order_count' => $totalOrderCount,
                'total_unloading_container_count' => $totalUnloadingContainerCount,
            ];
        } elseif ($data->has('end_date')) {
            $end_date = Carbon::parse($data->get('end_date'));
            $weightTarget = $weightTarget
                ->where('month', '<=', $end_date->month)
                ->sum('weight_target');
            $orderTarget = $orderTarget
                ->where('month', '<=', $end_date->month)
                ->sum('orders_count');
            foreach ($agents as $agent) {
                $totalAgentWeight = 0;
                $ordersCount = 0;
                $ordersSuccessfulCount = 0;
                $ordersCanceledCount = 0;
                $access_rate_to_order_target = 0;
                $access_rate_to_weight_target = 0;
                $ordersPostponedCount = 0;
                $OrdersSuccessRatio = 0;
                $OrdersCanceledRatio = 0;
                $OrdersPostponedRatio = 0;
                $ordersTotalWeight = 0;
                $ordersRecyclingTotalWeight = 0;
                $ordersDonationTotalWeight = 0;
                $containersWeight = 0;
                $containerUnloadingCount = 0;
                if ($agent->agentOrders()->count() > 0) {
                    $orderRange = $agent->agentOrders()
                        ->whereDate($column, '<=', $data->get('end_date'));
                    if ($data->has('province_id'))
                        $orderRange = $orderRange->where('province_id', '=', $data->get('province_id'));
                    $ordersCount = $orderRange->clone()->count();
                    $ordersSuccessfulCount = $orderRange->clone()
                        ->where('status', '=', OrderStatus::SUCCESSFUL)->count();
                    $ordersCanceledCount = $orderRange->clone()
                        ->whereIn('status', [OrderStatus::FAILED, OrderStatus::CANCEL])->count();
                    $ordersPostponedCount = $orderRange->clone()
                        ->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED])->count();
                    $OrdersSuccessRatio = 0;
                    $OrdersCanceledRatio = 0;
                    $OrdersPostponedRatio = 0;
                    if ($ordersCount != 0) {
                        $OrdersSuccessRatio = round(($ordersSuccessfulCount / $ordersCount) * 100, 1);
                        $OrdersCanceledRatio = round(($ordersCanceledCount / $ordersCount) * 100, 1);
                        $OrdersPostponedRatio = round(($ordersPostponedCount / $ordersCount) * 100, 1);
                    }
                    $ordersTotalWeight = $orderRange->clone()
                        ->sum('weight');
                    $ordersRecyclingTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::RECYCLING)->sum('weight');
                    $ordersDonationTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::DONATION)->sum('weight');
                }
                if ($agent->containerDetails()->count() > 0) {
                    if ($data->has('province_id')) {
                        $containersWeight = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->where('date', '<=', $data->get('end_date'))
                            ->sum('weight');
                        $containerUnloadingCount = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->where('date', '<=', $data->get('end_date'))
                            ->count();
                    } else {
                        $containersWeight = $agent->containerDetails()
                            ->where('date', '<=', $data->get('end_date'))
                            ->sum('weight');
                        $containerUnloadingCount = $agent->containerDetails()
                            ->where('date', '<=', $data->get('end_date'))
                            ->count();
                    }
                }
                $totalAgentWeight = $containersWeight + $ordersTotalWeight;
                if ($orderTarget > 0)
                    $access_rate_to_order_target = round(($ordersSuccessfulCount / $orderTarget) * 100, 1);

                if ($weightTarget > 0)
                    $access_rate_to_weight_target = round(($totalAgentWeight / $weightTarget) * 100, 1);

                $agentAnalytics[] = [
                    'agent_id' => $agent->id,
                    'agent_name' => $agent->name,
                    'total_weight' => $totalAgentWeight,
                    'total_orders_count' => $ordersCount,
                    'orders_successful_count' => $ordersSuccessfulCount,
                    'orders_canceled_count' => $ordersCanceledCount,
                    'orders_postponed_count' => $ordersPostponedCount,
                    'orders_successful_ratio' => $OrdersSuccessRatio . '%',
                    'orders_canceled_ratio' => $OrdersCanceledRatio . '%',
                    'orders_postponed_ratio' => $OrdersPostponedRatio . '%',
                    'total_orders_weight' => $ordersTotalWeight,
                    'total_recycling_orders_weight' => $ordersRecyclingTotalWeight,
                    'total_donation_orders_weight' => $ordersDonationTotalWeight,
                    'total_containers_weight' => $containersWeight,
                    'total_containers_unloading_count' => $containerUnloadingCount,
                    'order_target' => $orderTarget,
                    'weight_target' => $weightTarget,
                    'access_rate_to_order_target' => $access_rate_to_order_target . '%',
                    'access_rate_to_weight_target' => $access_rate_to_weight_target . '%',
                ];

                $totalRecyclingOrder += $ordersRecyclingTotalWeight;
                $totalDonationOrder += $ordersDonationTotalWeight;
                $totalContainerWeight += $containersWeight;
                $totalWeight += $totalAgentWeight;
                $totalWeightTarget += $weightTarget;
                $totalOrderTarget += $orderTarget;
                $totalOrderAccessRate += $access_rate_to_order_target;
                $totalWeightAccessRate += $access_rate_to_weight_target;
                $totalSuccessfulOrder += $ordersSuccessfulCount;
                $totalCanceledOrder += $ordersCanceledCount;
                $totalPostponedOrder += $ordersPostponedCount;
                $totalOrderCount += $ordersCount;
                $totalUnloadingContainerCount += $containerUnloadingCount;
            }
            if ($totalOrderCount > 0) {
                $totalSuccessfulOrderRate = round(($totalSuccessfulOrder / $totalOrderCount) * 100, 1);
                $totalCanceledOrderRate = round(($totalCanceledOrder / $totalOrderCount) * 100, 1);
                $totalPostponedOrderRate = round(($totalPostponedOrder / $totalOrderCount) * 100, 1);
            }



            $total = [
                'total_recycling_order' => $totalRecyclingOrder,
                'total_donation_order' => $totalDonationOrder,
                'total_container_weight' => $totalContainerWeight,
                'total_weight' => $totalWeight,
                'total_weight_target' => $totalWeightTarget,
                'total_order_target' => $totalOrderTarget,
                'total_order_target_access_rate' => $totalOrderAccessRate . '%',
                'total_order_weight_access_rate' => $totalWeightAccessRate . '%',
                'total_successful_order' => $totalSuccessfulOrder,
                'total_successful_order_rate' => $totalSuccessfulOrderRate . '%',
                'total_canceled_order' => $totalCanceledOrder,
                'total_canceled_order_rate' => $totalCanceledOrderRate . '%',
                'total_postponed_order' => $totalPostponedOrder,
                'total_postponed_order_rate' => $totalPostponedOrderRate . '%',
                'total_order_count' => $totalOrderCount,
                'total_unloading_container_count' => $totalUnloadingContainerCount,
            ];
        } else {
            $weightTarget = $weightTarget->where('month', '=', Carbon::now()->month)->first()?->weight_target;
            $orderTarget = $orderTarget->where('month', '=', Carbon::now()->month)->first()?->orders_count;
            foreach ($agents as $agent) {
                $totalAgentWeight = 0;
                $access_rate_to_order_target = 0;
                $access_rate_to_weight_target = 0;
                $ordersCount = 0;
                $ordersSuccessfulCount = 0;
                $ordersCanceledCount = 0;
                $ordersPostponedCount = 0;
                $OrdersSuccessRatio = 0;
                $OrdersCanceledRatio = 0;
                $OrdersPostponedRatio = 0;
                $ordersTotalWeight = 0;
                $ordersRecyclingTotalWeight = 0;
                $ordersDonationTotalWeight = 0;
                $containersWeight = 0;
                $containerUnloadingCount = 0;
                if ($agent->agentOrders()->count() > 0) {
                    $orderRange = $agent->agentOrders();
                    if ($data->has('province_id'))
                        $orderRange = $orderRange->where('province_id', '=', $data->get('province_id'));
                    $ordersCount = $orderRange->clone()->count();
                    $ordersSuccessfulCount = $orderRange->clone()
                        ->where('status', '=', OrderStatus::SUCCESSFUL)->count();
                    $ordersCanceledCount = $orderRange->clone()
                        ->whereIn('status', [OrderStatus::FAILED, OrderStatus::CANCEL])->count();
                    $ordersPostponedCount = $orderRange->clone()
                        ->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED])->count();
                    $OrdersSuccessRatio = 0;
                    $OrdersCanceledRatio = 0;
                    $OrdersPostponedRatio = 0;
                    if ($ordersCount > 0) {
                        $OrdersSuccessRatio = round(($ordersSuccessfulCount / $ordersCount) * 100, 1);
                        $OrdersCanceledRatio = round(($ordersCanceledCount / $ordersCount) * 100, 1);
                        $OrdersPostponedRatio = round(($ordersPostponedCount / $ordersCount) * 100, 1);
                    }
                    $ordersTotalWeight = $orderRange->clone()
                        ->sum('weight');
                    $ordersRecyclingTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::RECYCLING)->sum('weight');
                    $ordersDonationTotalWeight = $orderRange->clone()
                        ->where('type', '=', OrderType::DONATION)->sum('weight');
                }

                if ($agent->containerDetails()->count() > 0) {
                    if ($data->has('province_id')) {
                        $containersWeight = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->sum('weight');

                        $containerUnloadingCount = $agent->containerDetails()
                            ->whereHas('container', function (Builder $query) use ($data) {
                                $query->where('province_id', '=', $data->get('province_id'));
                            })
                            ->count();
                    } else {
                        $containersWeight = $agent->containerDetails()->sum('weight');
                        $containerUnloadingCount = $agent->containerDetails()->count();
                    }
                }
                $totalAgentWeight = $containersWeight + $ordersTotalWeight;
                if ($orderTarget > 0)
                    $access_rate_to_order_target = round(($ordersSuccessfulCount / $orderTarget) * 100, 1);

                if ($weightTarget > 0)
                    $access_rate_to_weight_target = round(($totalAgentWeight / $weightTarget) * 100, 1);

                $agentAnalytics[] = [
                    'agent_id' => $agent->id,
                    'agent_name' => $agent->name,
                    'total_weight' => $totalAgentWeight,
                    'total_orders_count' => $ordersCount,
                    'orders_successful_count' => $ordersSuccessfulCount,
                    'orders_canceled_count' => $ordersCanceledCount,
                    'orders_postponed_count' => $ordersPostponedCount,
                    'orders_successful_ratio' => $OrdersSuccessRatio . '%',
                    'orders_canceled_ratio' => $OrdersCanceledRatio . '%',
                    'orders_postponed_ratio' => $OrdersPostponedRatio . '%',
                    'total_orders_weight' => $ordersTotalWeight,
                    'total_recycling_orders_weight' => $ordersRecyclingTotalWeight,
                    'total_donation_orders_weight' => $ordersDonationTotalWeight,
                    'total_containers_weight' => $containersWeight,
                    'total_containers_unloading_count' => $containerUnloadingCount,
                    'order_target' => $orderTarget,
                    'weight_target' => $weightTarget,
                    'access_rate_to_order_target' => $access_rate_to_order_target . '%',
                    'access_rate_to_weight_target' => $access_rate_to_weight_target . '%',
                ];

                $totalRecyclingOrder += $ordersRecyclingTotalWeight;
                $totalDonationOrder += $ordersDonationTotalWeight;
                $totalContainerWeight += $containersWeight;
                $totalWeight += $totalAgentWeight;
                $totalWeightTarget += $weightTarget;
                $totalOrderTarget += $orderTarget;
                $totalOrderAccessRate += $access_rate_to_order_target;
                $totalWeightAccessRate += $access_rate_to_weight_target;
                $totalSuccessfulOrder += $ordersSuccessfulCount;
                $totalCanceledOrder += $ordersCanceledCount;
                $totalPostponedOrder += $ordersPostponedCount;
                $totalOrderCount += $ordersCount;
                $totalUnloadingContainerCount += $containerUnloadingCount;
            }

            if ($totalOrderCount > 0) {
                $totalSuccessfulOrderRate = round(($totalSuccessfulOrder / $totalOrderCount) * 100, 1);
                $totalCanceledOrderRate = round(($totalCanceledOrder / $totalOrderCount) * 100, 1);
                $totalPostponedOrderRate = round(($totalPostponedOrder / $totalOrderCount) * 100, 1);
            }


            $total = [
                'total_recycling_order' => $totalRecyclingOrder,
                'total_donation_order' => $totalDonationOrder,
                'total_container_weight' => $totalContainerWeight,
                'total_weight' => $totalWeight,
                'total_weight_target' => $totalWeightTarget,
                'total_order_target' => $totalOrderTarget,
                'total_order_target_access_rate' => $totalOrderAccessRate . '%',
                'total_order_weight_access_rate' => $totalWeightAccessRate . '%',
                'total_successful_order' => $totalSuccessfulOrder,
                'total_successful_order_rate' => $totalSuccessfulOrderRate . '%',
                'total_canceled_order' => $totalCanceledOrder,
                'total_canceled_order_rate' => $totalCanceledOrderRate . '%',
                'total_postponed_order' => $totalPostponedOrder,
                'total_postponed_order_rate' => $totalPostponedOrderRate . '%',
                'total_order_count' => $totalOrderCount,
                'total_unloading_container_count' => $totalUnloadingContainerCount,
            ];
        }

        $allAgentAnalytics = [
            'agents' => $agentAnalytics,
            'total' => $total,
        ];

        return $this->response('success', $allAgentAnalytics);
    }

    public function dailyAgentsReport(array $data): JsonResponse
    {
        $today = Carbon::now()->toDateString();
        $countryId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        $query = User::query()->with(['containerDetails' => function ($query) use ($data, $today, $countryId) {
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
                $query->where('container_details.date', '>=', $startDate);
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
                $query->where('container_details.date', '<=', $endDate);
            }
            if ($startDate == null && $endDate == null) {
                $query->whereDate('container_details.date', $today);
            }

            return $query->when($countryId != null, function ($query) use ($countryId) {
                return $query->whereHas('container', function ($query) use ($countryId) {
                    return $query->where('country_id', $countryId);
                });
            })->groupBy('container_details.agent_id')->select('*', \DB::raw('count(distinct container_details.container_id) as count,
             sum(container_details.weight) as total'));

        }])->with(['agentOrders' => function ($query) use ($data, $today, $countryId) {
            $startDate = $endDate = null;

            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
                $query->where('orders.ends_at', '>=', $startDate);
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
                $query->where('orders.ends_at', '<=', $endDate);
            }
            if ($startDate == null && $endDate == null) {
                $query->whereDate('orders.ends_at', $today);
            }

            return $query->where('orders.status', '=', OrderStatus::SUCCESSFUL)
                ->when($countryId != null, function ($query) use ($countryId) {
                    return $query->where('country_id', $countryId);
                })->groupBy('orders.agent_id')->select('*', \DB::raw('count(distinct orders.id) as count'));

        }])->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('country_id', $countryId);
        })->where('type', UserType::AGENT);

        $totalOrders = 0;
        $totalContainersCount = 0;
        $totalContainersWeight = 0;
        $agents = [];
        $items = $query->get();
        foreach ($items as $item) {
            $orders = 0;
            $containersCount = 0;
            $containersWeight = 0;


            if (count($item->containerDetails) > 0) {
                $containersCount = $item->containerDetails[0]->count;
                $totalContainersCount = $totalContainersCount + $containersCount;
            }
            if (count($item->containerDetails) > 0) {
                $containersWeight = $item->containerDetails[0]->total;
                $totalContainersWeight = $totalContainersWeight + $containersWeight;

            }
            if (count($item->agentOrders) > 0) {
                $orders = $item->agentOrders[0]->count;
                $totalOrders = $totalOrders + $orders;
            }

            $agents[] = [
                'agent_name' => $item['name'],
                'containers_count' => $containersCount,
                'containers_weight' => $containersWeight,
                'orders_count' => $orders,
            ];
        }
        $res = [
            'agents' => $agents,
            'total' => [
                'total_containers_count' => $totalContainersCount,
                'total_containers_weight' => $totalContainersWeight,
                'total_orders' => $totalOrders,
            ],
        ];

        return $this->response('success', $res);

    }

    public function countriesReport(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = null;
        $associationId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        if (array_key_exists('association_id', $data)) {
            $associationId = $data['association_id'];
        }
        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $provinceId = null;
        if (array_key_exists('province_id', $data)) {
            $provinceId = $data['province_id'];
        }
        $query = Country::query()->with(['orders' => function ($query) use ($data, $countryId, $provinceId, $associationId, $column) {
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
                $query->whereDate("orders.$column", '>=', $startDate);
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
                $query->whereDate("orders.$column", '<=', $endDate);
            }
            $query->when($provinceId != null, function ($query) use ($provinceId) {
                return $query->where('province_id', $provinceId);
            });

            $query->when($associationId != null, function ($query) use ($associationId) {
                return $query->where('association_id', $associationId);
            });

            return $query->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            });

        }])->with(['containers' => function ($query) use ($countryId, $provinceId, $associationId) {
            $query->when($provinceId != null, function ($query) use ($provinceId) {
                return $query->where('province_id', $provinceId);
            });
            $query->when($associationId != null, function ($query) use ($associationId) {
                return $query->where('association_id', $associationId);
            });

            $query->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            });

            return $query;
        }])->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('id', $countryId);
        });

        //for all countries
        // orders
        $totalOrders = 0;
        $successfulOrders = 0;
        $postponedOrders = 0;
        $cancelOrders = 0;
        $totalWeightRecycling = 0;
        $totalWeightDonation = 0;
        $successfulOrdersRatio = 0;
        $postponedOrdersRatio = 0;
        $cancelOrdersRatio = 0;
        //containers
        $totalContainers = 0;
        $totalUnloadingContainers = 0;
        $totalWeightContainers = 0;


        $countriesRes = [];

        $countries = $query->get();
        foreach ($countries as $country) {
            //orders
            $totalOrdersCountry = 0;
            $successfulOrdersCountry = 0;
            $cancelOrdersCountry = 0;
            $postponedOrdersCountry = 0;
            $successfulOrdersCountryRatio = 0;
            $postponedOrdersCountryRatio = 0;
            $cancelOrdersCountryRatio = 0;

            $successful = $country->orders->where('status', OrderStatus::SUCCESSFUL);
            if ($successful) {
                $successfulOrdersCountry = count($successful);
                $successfulOrders = $successfulOrders + $successfulOrdersCountry;
            }
            $postponed = $country->orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED]);
            if ($postponed) {
                $postponedOrdersCountry = count($postponed);
                $postponedOrders = $postponedOrders + $postponedOrdersCountry;
            }
            $canceled = $country->orders->whereIn('status', [OrderStatus::CANCEL, OrderStatus::FAILED]);
            if ($canceled) {
                $cancelOrdersCountry = count($canceled);
                $cancelOrders = $cancelOrders + $cancelOrdersCountry;
            }
            if ($country->orders) {
                $totalOrdersCountry = count($country->orders);
                $totalOrders = $totalOrders + $totalOrdersCountry;
            }
            $totalWeightRecyclingForCountry = $country->orders->where('type', OrderType::RECYCLING)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');
            $totalWeightDonationForCountry = $country->orders->where('type', OrderType::DONATION)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');

            $totalWeightRecycling = $totalWeightRecycling + $totalWeightRecyclingForCountry;
            $totalWeightDonation = $totalWeightDonation + $totalWeightDonationForCountry;

            if ($totalOrdersCountry != 0) {
                $successfulOrdersCountryRatio = round(($successfulOrdersCountry / $totalOrdersCountry) * 100, 1);
                $postponedOrdersCountryRatio = round(($postponedOrdersCountry / $totalOrdersCountry) * 100, 1);
                $cancelOrdersCountryRatio = round(($cancelOrdersCountry / $totalOrdersCountry) * 100, 1);
            }

            //containers

            $totalContainersCountry = 0;
            $totalUnloadingContainersCountry = 0;
            $totalWeightContainersCountry = 0;

            if ($country->containers) {
                $totalContainersCountry = count($country->containers);
                $totalContainers = $totalContainers + $totalContainersCountry;
            }
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
            }
            $containers = ContainerDetails::whereIn('container_id', $country->containers->pluck('id'))
                ->when($startDate != null, function ($query) use ($startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($endDate != null, function ($query) use ($endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->where('weight', '>', 0);

            $totalUnloadingContainersCountry = $containers->groupBy('container_id')->count();
            $totalWeightContainersCountry = $containers->sum('weight');


            $totalUnloadingContainers = $totalUnloadingContainers + $totalUnloadingContainersCountry;
            $totalWeightContainers = $totalWeightContainers + $totalWeightContainersCountry;

            $countriesRes[] = [
                'country_name' => $this->getTranslateValue($locale, $country['meta'], 'name', $country['name']),
                'total_orders' => $totalOrdersCountry,
                'successful_orders' => $successfulOrdersCountry,
                'successful_orders_ratio' => $successfulOrdersCountryRatio . '%',
                'postponed_orders' => $postponedOrdersCountry,
                'postponed_orders_ratio' => $postponedOrdersCountryRatio . '%',
                'cancel_orders' => $cancelOrdersCountry,
                'cancel_orders_ratio' => $cancelOrdersCountryRatio . '%',
                'total_weight_recycling' => $totalWeightRecyclingForCountry,
                'total_weight_donation' => $totalWeightDonationForCountry,
                'total_containers' => $totalContainersCountry,
                'total_unloading_containers' => $totalUnloadingContainersCountry,
                'total_weight_containers' => $totalWeightContainersCountry,
                'total_weight' => $totalWeightContainersCountry + $totalWeightRecyclingForCountry + $totalWeightDonationForCountry,
            ];
        }
        if ($totalOrders != 0) {
            $successfulOrdersRatio = round(($successfulOrders / $totalOrders) * 100, 1);
            $postponedOrdersRatio = round(($postponedOrders / $totalOrders) * 100, 1);
            $cancelOrdersRatio = round(($cancelOrders / $totalOrders) * 100, 1);
        }


        $total = [
            'countries' => $countriesRes,
            'total' => [
                'total_orders' => $totalOrders,
                'successful_orders' => $successfulOrders,
                'successful_orders_ratio' => $successfulOrdersRatio . '%',
                'postponed_orders' => $postponedOrders,
                'postponed_orders_ratio' => $postponedOrdersRatio . '%',
                'cancel_orders' => $cancelOrders,
                'cancel_orders_ratio' => $cancelOrdersRatio . '%',
                'total_weight_recycling' => $totalWeightRecycling,
                'total_weight_donation' => $totalWeightDonation,
                'total_containers' => $totalContainers,
                'total_unloading_containers' => $totalUnloadingContainers,
                'total_weight_containers' => $totalWeightContainers,
                'total_weight' => $totalWeightContainers + $totalWeightDonation + $totalWeightRecycling,
            ],
        ];

        return $this->response('success', $total);

    }

    public function provincesReport(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = null;
        $associationId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        if (array_key_exists('association_id', $data)) {
            $associationId = $data['association_id'];
        }
        $provinceId = null;
        if (array_key_exists('province_id', $data)) {
            $provinceId = $data['province_id'];
        }
        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $query = Province::query()->with(['orders' => function ($query) use ($data, $countryId, $associationId, $column) {
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
                $query->whereDate("orders.$column", '>=', $startDate);
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
                $query->whereDate("orders.$column", '<=', $endDate);
            }
            $query->when($associationId != null, function ($query) use ($associationId) {
                return $query->where('association_id', $associationId);
            });

            return $query->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            });

        }])->with(['containers' => function ($query) use ($countryId, $associationId) {
            $query->when($associationId != null, function ($query) use ($associationId) {
                return $query->where('association_id', $associationId);
            });
            $query->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            });

            return $query;
        }])->with(['country'])->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('country_id', $countryId);
        })->when($provinceId != null, function ($query) use ($provinceId) {
            return $query->where('id', $provinceId);
        });

        //for all countries
        // orders
        $totalOrders = 0;
        $successfulOrders = 0;
        $postponedOrders = 0;
        $cancelOrders = 0;
        $totalWeightRecycling = 0;
        $totalWeightDonation = 0;
        $successfulOrdersRatio = 0;
        $postponedOrdersRatio = 0;
        $cancelOrdersRatio = 0;
        //containers
        $totalContainers = 0;
        $totalUnloadingContainers = 0;
        $totalWeightContainers = 0;

        $countriesRes = [];

        $countries = $query->get();
        foreach ($countries as $country) {
            //orders
            $totalOrdersCountry = 0;
            $successfulOrdersCountry = 0;
            $cancelOrdersCountry = 0;
            $postponedOrdersCountry = 0;
            $successfulOrdersCountryRatio = 0;
            $postponedOrdersCountryRatio = 0;
            $cancelOrdersCountryRatio = 0;

            $successful = $country->orders->where('status', OrderStatus::SUCCESSFUL);
            if ($successful) {
                $successfulOrdersCountry = count($successful);
                $successfulOrders = $successfulOrders + $successfulOrdersCountry;
            }
            $postponed = $country->orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED]);
            if ($postponed) {
                $postponedOrdersCountry = count($postponed);
                $postponedOrders = $postponedOrders + $postponedOrdersCountry;
            }
            $canceled = $country->orders->whereIn('status', [OrderStatus::CANCEL, OrderStatus::FAILED]);
            if ($canceled) {
                $cancelOrdersCountry = count($canceled);
                $cancelOrders = $cancelOrders + $cancelOrdersCountry;
            }
            if ($country->orders) {
                $totalOrdersCountry = count($country->orders);
                $totalOrders = $totalOrders + $totalOrdersCountry;
            }
            $totalWeightRecyclingForCountry = $country->orders->where('type', OrderType::RECYCLING)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');
            $totalWeightDonationForCountry = $country->orders->where('type', OrderType::DONATION)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');

            $totalWeightRecycling = $totalWeightRecycling + $totalWeightRecyclingForCountry;
            $totalWeightDonation = $totalWeightDonation + $totalWeightDonationForCountry;

            if ($totalOrdersCountry != 0) {
                $successfulOrdersCountryRatio = round(($successfulOrdersCountry / $totalOrdersCountry) * 100, 1);
                $postponedOrdersCountryRatio = round(($postponedOrdersCountry / $totalOrdersCountry) * 100, 1);
                $cancelOrdersCountryRatio = round(($cancelOrdersCountry / $totalOrdersCountry) * 100, 1);
            }

            //containers

            $totalContainersCountry = 0;
            $totalUnloadingContainersCountry = 0;
            $totalWeightContainersCountry = 0;

            if ($country->containers) {
                $totalContainersCountry = count($country->containers);
                $totalContainers = $totalContainers + $totalContainersCountry;
            }
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
            }
            $containers = ContainerDetails::whereIn('container_id', $country->containers->pluck('id'))
                ->when($startDate != null, function ($query) use ($startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($endDate != null, function ($query) use ($endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->where('weight', '>', 0);

            $totalUnloadingContainersCountry = $containers->groupBy('container_id')->count();
            $totalWeightContainersCountry = $containers->sum('weight');


            $totalUnloadingContainers = $totalUnloadingContainers + $totalUnloadingContainersCountry;
            $totalWeightContainers = $totalWeightContainers + $totalWeightContainersCountry;

            $countriesRes[] = [
                'province_name' => $this->getTranslateValue($locale, $country['meta'], 'name', $country['name']),
                'country_name' => $this->getTranslateValue($locale, $country->country['meta'], 'name', $country->country['name']),
                'total_orders' => $totalOrdersCountry,
                'successful_orders' => $successfulOrdersCountry,
                'successful_orders_ratio' => $successfulOrdersCountryRatio . '%',
                'postponed_orders' => $postponedOrdersCountry,
                'postponed_orders_ratio' => $postponedOrdersCountryRatio . '%',
                'cancel_orders' => $cancelOrdersCountry,
                'cancel_orders_ratio' => $cancelOrdersCountryRatio . '%',
                'total_weight_recycling' => $totalWeightRecyclingForCountry,
                'total_weight_donation' => $totalWeightDonationForCountry,
                'total_containers' => $totalContainersCountry,
                'total_unloading_containers' => $totalUnloadingContainersCountry,
                'total_weight_containers' => $totalWeightContainersCountry,
                'total_weight' => $totalWeightContainersCountry + $totalWeightRecyclingForCountry + $totalWeightDonationForCountry,
            ];
        }
        if ($totalOrders != 0) {
            $successfulOrdersRatio = round(($successfulOrders / $totalOrders) * 100, 1);
            $postponedOrdersRatio = round(($postponedOrders / $totalOrders) * 100, 1);
            $cancelOrdersRatio = round(($cancelOrders / $totalOrders) * 100, 1);
        }


        $total = [
            'provinces' => $countriesRes,
            'total' => [
                'total_orders' => $totalOrders,
                'successful_orders' => $successfulOrders,
                'successful_orders_ratio' => $successfulOrdersRatio . '%',
                'postponed_orders' => $postponedOrders,
                'postponed_orders_ratio' => $postponedOrdersRatio . '%',
                'cancel_orders' => $cancelOrders,
                'cancel_orders_ratio' => $cancelOrdersRatio . '%',
                'total_weight_recycling' => $totalWeightRecycling,
                'total_weight_donation' => $totalWeightDonation,
                'total_containers' => $totalContainers,
                'total_unloading_containers' => $totalUnloadingContainers,
                'total_weight_containers' => $totalWeightContainers,
                'total_weight' => $totalWeightContainers + $totalWeightDonation + $totalWeightRecycling,
            ],
        ];

        return $this->response('success', $total);

    }

    public function associationsReport(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = null;
        $associationId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        if (array_key_exists('association_id', $data)) {
            $associationId = $data['association_id'];
        }

        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $query = Association::query()
            ->with(['country'])
            ->when($countryId != null, function ($query) use ($countryId) {
                return $query->where('country_id', $countryId);
            })
            ->with(['orders' => function ($query) use ($data, $countryId, $associationId, $column) {
                $startDate = $endDate = null;
                if (array_key_exists('start_date', $data)) {
                    $startDate = $data['start_date'];
                    $query->whereDate("orders.$column", '>=', $startDate);
                }
                if (array_key_exists('end_date', $data)) {
                    $endDate = $data['end_date'];
                    $query->whereDate("orders.$column", '<=', $endDate);
                }
                $query->when($associationId != null, function ($query) use ($associationId) {
                    return $query->where('association_id', $associationId);
                });

                return $query->when($countryId != null, function ($query) use ($countryId) {
                    return $query->where('country_id', $countryId);
                });
            }])->with(['containers' => function ($query) use ($countryId, $associationId) {
                $query->when($associationId != null, function ($query) use ($associationId) {
                    return $query->where('association_id', $associationId);
                });
                $query->when($countryId != null, function ($query) use ($countryId) {
                    return $query->where('country_id', $countryId);
                });

                return $query;
            }])->when($associationId != null, function ($query) use ($associationId) {
                return $query->where('id', $associationId);
            });


        $kiswaReport = Country::query()->with(['orders' => function ($query) use ($data, $column) {
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
                $query->whereDate("orders.$column", '>=', $startDate);
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
                $query->whereDate("orders.$column", '<=', $endDate);
            }

            return $query->where('association_id', null);

        }])->with(['containers' => function ($query) {
            return $query->where('association_id', null);
        }])->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('id', $countryId);
        });


        //for all countries
        // orders
        $totalOrders = 0;
        $successfulOrders = 0;
        $postponedOrders = 0;
        $cancelOrders = 0;
        $totalWeightRecycling = 0;
        $totalWeightDonation = 0;
        $successfulOrdersRatio = 0;
        $postponedOrdersRatio = 0;
        $cancelOrdersRatio = 0;
        //containers
        $totalContainers = 0;
        $totalUnloadingContainers = 0;
        $totalWeightContainers = 0;

        $countriesRes = [];

        $countries = $query->get();
        foreach ($countries as $country) {
            //orders
            $totalOrdersCountry = 0;
            $successfulOrdersCountry = 0;
            $cancelOrdersCountry = 0;
            $postponedOrdersCountry = 0;
            $successfulOrdersCountryRatio = 0;
            $postponedOrdersCountryRatio = 0;
            $cancelOrdersCountryRatio = 0;

            $successful = $country->orders->where('status', OrderStatus::SUCCESSFUL);
            if ($successful) {
                $successfulOrdersCountry = count($successful);
                $successfulOrders = $successfulOrders + $successfulOrdersCountry;
            }
            $postponed = $country->orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED]);
            if ($postponed) {
                $postponedOrdersCountry = count($postponed);
                $postponedOrders = $postponedOrders + $postponedOrdersCountry;
            }
            $canceled = $country->orders->whereIn('status', [OrderStatus::CANCEL, OrderStatus::FAILED]);
            if ($canceled) {
                $cancelOrdersCountry = count($canceled);
                $cancelOrders = $cancelOrders + $cancelOrdersCountry;
            }
            if ($country->orders) {
                $totalOrdersCountry = count($country->orders);
                $totalOrders = $totalOrders + $totalOrdersCountry;
            }
            $totalWeightRecyclingForCountry = $country->orders->where('type', OrderType::RECYCLING)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');
            $totalWeightDonationForCountry = $country->orders->where('type', OrderType::DONATION)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');

            $totalWeightRecycling = $totalWeightRecycling + $totalWeightRecyclingForCountry;
            $totalWeightDonation = $totalWeightDonation + $totalWeightDonationForCountry;

            if ($totalOrdersCountry != 0) {
                $successfulOrdersCountryRatio = round(($successfulOrdersCountry / $totalOrdersCountry) * 100, 1);
                $postponedOrdersCountryRatio = round(($postponedOrdersCountry / $totalOrdersCountry) * 100, 1);
                $cancelOrdersCountryRatio = round(($cancelOrdersCountry / $totalOrdersCountry) * 100, 1);
            }

            //containers

            $totalContainersCountry = 0;
            $totalUnloadingContainersCountry = 0;
            $totalWeightContainersCountry = 0;

            if ($country->containers) {
                $totalContainersCountry = count($country->containers);
                $totalContainers = $totalContainers + $totalContainersCountry;
            }
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
            }
            $containers = ContainerDetails::whereIn('container_id', $country->containers->pluck('id'))
                ->when($startDate != null, function ($query) use ($startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($endDate != null, function ($query) use ($endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->where('weight', '>', 0);

            $totalUnloadingContainersCountry = $containers->groupBy('container_id')->count();
            $totalWeightContainersCountry = $containers->sum('weight');


            $totalUnloadingContainers = $totalUnloadingContainers + $totalUnloadingContainersCountry;
            $totalWeightContainers = $totalWeightContainers + $totalWeightContainersCountry;

            $countriesRes[] = [
                'association_name' => $this->getTranslateValue($locale, $country['meta'], 'title', $country['title']),
                'country_name' => $this->getTranslateValue($locale, $country->country['meta'], 'name', $country->country['name']),
                'total_orders' => $totalOrdersCountry,
                'successful_orders' => $successfulOrdersCountry,
                'successful_orders_ratio' => $successfulOrdersCountryRatio . '%',
                'postponed_orders' => $postponedOrdersCountry,
                'postponed_orders_ratio' => $postponedOrdersCountryRatio . '%',
                'cancel_orders' => $cancelOrdersCountry,
                'cancel_orders_ratio' => $cancelOrdersCountryRatio . '%',
                'total_weight_recycling' => $totalWeightRecyclingForCountry,
                'total_weight_donation' => $totalWeightDonationForCountry,
                'total_containers' => $totalContainersCountry,
                'total_unloading_containers' => $totalUnloadingContainersCountry,
                'total_weight_containers' => $totalWeightContainersCountry,
                'total_weight' => $totalWeightContainersCountry + $totalWeightRecyclingForCountry + $totalWeightDonationForCountry,
            ];
        }


        $kiswaCompanies = $kiswaReport->get();
        foreach ($kiswaCompanies as $kiswa) {
            //orders
            $totalOrdersCountry = 0;
            $successfulOrdersCountry = 0;
            $cancelOrdersCountry = 0;
            $postponedOrdersCountry = 0;
            $successfulOrdersCountryRatio = 0;
            $postponedOrdersCountryRatio = 0;
            $cancelOrdersCountryRatio = 0;

            $successful = $kiswa->orders->where('status', OrderStatus::SUCCESSFUL);
            if ($successful) {
                $successfulOrdersCountry = count($successful);
                $successfulOrders = $successfulOrders + $successfulOrdersCountry;
            }
            $postponed = $kiswa->orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED]);
            if ($postponed) {
                $postponedOrdersCountry = count($postponed);
                $postponedOrders = $postponedOrders + $postponedOrdersCountry;
            }
            $canceled = $kiswa->orders->whereIn('status', [OrderStatus::CANCEL, OrderStatus::FAILED]);
            if ($canceled) {
                $cancelOrdersCountry = count($canceled);
                $cancelOrders = $cancelOrders + $cancelOrdersCountry;
            }
            if ($kiswa->orders) {
                $totalOrdersCountry = count($kiswa->orders);
                $totalOrders = $totalOrders + $totalOrdersCountry;
            }
            $totalWeightRecyclingForCountry = $kiswa->orders->where('type', OrderType::RECYCLING)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');
            $totalWeightDonationForCountry = $kiswa->orders->where('type', OrderType::DONATION)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');

            $totalWeightRecycling = $totalWeightRecycling + $totalWeightRecyclingForCountry;
            $totalWeightDonation = $totalWeightDonation + $totalWeightDonationForCountry;

            if ($totalOrdersCountry != 0) {
                $successfulOrdersCountryRatio = round(($successfulOrdersCountry / $totalOrdersCountry) * 100, 1);
                $postponedOrdersCountryRatio = round(($postponedOrdersCountry / $totalOrdersCountry) * 100, 1);
                $cancelOrdersCountryRatio = round(($cancelOrdersCountry / $totalOrdersCountry) * 100, 1);
            }

            //containers

            $totalContainersCountry = 0;
            $totalUnloadingContainersCountry = 0;
            $totalWeightContainersCountry = 0;

            if ($kiswa->containers) {
                $totalContainersCountry = count($kiswa->containers);
                $totalContainers = $totalContainers + $totalContainersCountry;
            }
            $startDate = $endDate = null;
            if (array_key_exists('start_date', $data)) {
                $startDate = $data['start_date'];
            }
            if (array_key_exists('end_date', $data)) {
                $endDate = $data['end_date'];
            }
            $containers = ContainerDetails::whereIn('container_id', $kiswa->containers->pluck('id'))
                ->when($startDate != null, function ($query) use ($startDate) {
                    return $query->where('date', '>=', $startDate);
                })
                ->when($endDate != null, function ($query) use ($endDate) {
                    return $query->where('date', '<=', $endDate);
                })
                ->where('weight', '>', 0);

            $totalUnloadingContainersCountry = $containers->groupBy('container_id')->count();
            $totalWeightContainersCountry = $containers->sum('weight');


            $totalUnloadingContainers = $totalUnloadingContainers + $totalUnloadingContainersCountry;
            $totalWeightContainers = $totalWeightContainers + $totalWeightContainersCountry;

            $countriesRes[] = [
                'association_name' => $this->getTranslateKiswa($locale) . '-' . $this->getTranslateValue($locale, $kiswa['meta'], 'name', $kiswa['name']),
                'country_name' => $this->getTranslateValue($locale, $kiswa['meta'], 'name', $kiswa['name']),
                'total_orders' => $totalOrdersCountry,
                'successful_orders' => $successfulOrdersCountry,
                'successful_orders_ratio' => $successfulOrdersCountryRatio . '%',
                'postponed_orders' => $postponedOrdersCountry,
                'postponed_orders_ratio' => $postponedOrdersCountryRatio . '%',
                'cancel_orders' => $cancelOrdersCountry,
                'cancel_orders_ratio' => $cancelOrdersCountryRatio . '%',
                'total_weight_recycling' => $totalWeightRecyclingForCountry,
                'total_weight_donation' => $totalWeightDonationForCountry,
                'total_containers' => $totalContainersCountry,
                'total_unloading_containers' => $totalUnloadingContainersCountry,
                'total_weight_containers' => $totalWeightContainersCountry,
                'total_weight' => $totalWeightContainersCountry + $totalWeightRecyclingForCountry + $totalWeightDonationForCountry,
            ];
        }


        if ($totalOrders != 0) {
            $successfulOrdersRatio = round(($successfulOrders / $totalOrders) * 100, 1);
            $postponedOrdersRatio = round(($postponedOrders / $totalOrders) * 100, 1);
            $cancelOrdersRatio = round(($cancelOrders / $totalOrders) * 100, 1);
        }


        $total = [
            'associations' => $countriesRes,
            'total' => [
                'total_orders' => $totalOrders,
                'successful_orders' => $successfulOrders,
                'successful_orders_ratio' => $successfulOrdersRatio . '%',
                'postponed_orders' => $postponedOrders,
                'postponed_orders_ratio' => $postponedOrdersRatio . '%',
                'cancel_orders' => $cancelOrders,
                'cancel_orders_ratio' => $cancelOrdersRatio . '%',
                'total_weight_recycling' => $totalWeightRecycling,
                'total_weight_donation' => $totalWeightDonation,
                'total_containers' => $totalContainers,
                'total_unloading_containers' => $totalUnloadingContainers,
                'total_weight_containers' => $totalWeightContainers,
                'total_weight' => $totalWeightContainers + $totalWeightDonation + $totalWeightRecycling,
            ],
        ];

        return $this->response('success', $total);

    }

    public function usersReport(array $data): JsonResponse
    {
        $locale = AppHelper::getLanguageForMobile();
        $countryId = null;
        $userId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        if (array_key_exists('user_id', $data)) {
            $userId = $data['user_id'];
        }
        $startDate = $endDate = null;
        if (array_key_exists('start_date', $data)) {
            $startDate = $data['start_date'];
        }
        if (array_key_exists('end_date', $data)) {
            $endDate = $data['end_date'];
        }
        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $usersQuery = User::query()->with(['orders' => function ($query) use ($startDate, $endDate, $column) {
            return $query->when($startDate != null, function ($query) use ($startDate, $column) {
                return $query->whereDate($column, '>=', $startDate);
            })->when($endDate != null, function ($query) use ($endDate, $column) {
                return $query->whereDate($column, '<=', $endDate);
            });
        }])->with(['country'])->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('country_id', $countryId);
        })->when($userId != null, function ($query) use ($userId) {
            return $query->where('id', $userId);
        })->where('type', UserType::CLIENT);

        $users = $usersQuery->get();
        // orders
        $totalOrders = 0;
        $successfulOrders = 0;
        $postponedOrders = 0;
        $cancelOrders = 0;
        $totalWeightRecycling = 0;
        $totalWeightDonation = 0;
        $successfulOrdersRatio = 0;
        $postponedOrdersRatio = 0;
        $cancelOrdersRatio = 0;

        $usersRes = [];

        foreach ($users as $user) {
            //orders
            $totalOrdersUser = 0;
            $successfulOrdersUser = 0;
            $cancelOrdersUser = 0;
            $postponedOrdersUser = 0;
            $successfulOrdersUserRatio = 0;
            $postponedOrdersUserRatio = 0;
            $cancelOrdersUserRatio = 0;

            $successful = $user->orders->where('status', OrderStatus::SUCCESSFUL);
            if ($successful) {
                $successfulOrdersUser = count($successful);
                $successfulOrders = $successfulOrders + $successfulOrdersUser;
            }
            $postponed = $user->orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED]);
            if ($postponed) {
                $postponedOrdersUser = count($postponed);
                $postponedOrders = $postponedOrders + $postponedOrdersUser;
            }
            $canceled = $user->orders->whereIn('status', [OrderStatus::CANCEL, OrderStatus::FAILED]);
            if ($canceled) {
                $cancelOrdersUser = count($canceled);
                $cancelOrders = $cancelOrders + $cancelOrdersUser;
            }
            if ($user->orders) {
                $totalOrdersUser = count($user->orders);
                $totalOrders = $totalOrders + $totalOrdersUser;
            }
            $totalWeightRecyclingForUser = $user->orders->where('type', OrderType::RECYCLING)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');
            $totalWeightDonationForUser = $user->orders->where('type', OrderType::DONATION)->where('status', OrderStatus::SUCCESSFUL)->sum('weight');

            $totalWeightRecycling = $totalWeightRecycling + $totalWeightRecyclingForUser;
            $totalWeightDonation = $totalWeightDonation + $totalWeightDonationForUser;

            if ($totalOrdersUser != 0) {
                $successfulOrdersUserRatio = round(($successfulOrdersUser / $totalOrdersUser) * 100, 1);
                $postponedOrdersUserRatio = round(($postponedOrdersUser / $totalOrdersUser) * 100, 1);
                $cancelOrdersUserRatio = round(($cancelOrdersUser / $totalOrdersUser) * 100, 1);
            }

            $usersRes[] = [
                'user_name' => $user['name'],
                'country_name' => $this->getTranslateValue($locale, $user->country['meta'], 'name', $user->country['name']),
                'total_orders' => $totalOrdersUser,
                'successful_orders' => $successfulOrdersUser,
                'successful_orders_ratio' => $successfulOrdersUserRatio . '%',
                'postponed_orders' => $postponedOrdersUser,
                'postponed_orders_ratio' => $postponedOrdersUserRatio . '%',
                'cancel_orders' => $cancelOrdersUser,
                'cancel_orders_ratio' => $cancelOrdersUserRatio . '%',
                'total_weight_recycling' => $totalWeightRecyclingForUser,
                'total_weight_donation' => $totalWeightDonationForUser,
                'total_weight' => $totalWeightRecyclingForUser + $totalWeightDonationForUser,
            ];
        }
        if ($totalOrders != 0) {
            $successfulOrdersRatio = round(($successfulOrders / $totalOrders) * 100, 1);
            $postponedOrdersRatio = round(($postponedOrders / $totalOrders) * 100, 1);
            $cancelOrdersRatio = round(($cancelOrders / $totalOrders) * 100, 1);
        }


        $total = [
            'users' => $usersRes,
            'total' => [
                'total_orders' => $totalOrders,
                'successful_orders' => $successfulOrders,
                'successful_orders_ratio' => $successfulOrdersRatio . '%',
                'postponed_orders' => $postponedOrders,
                'postponed_orders_ratio' => $postponedOrdersRatio . '%',
                'cancel_orders' => $cancelOrders,
                'cancel_orders_ratio' => $cancelOrdersRatio . '%',
                'total_weight_recycling' => $totalWeightRecycling,
                'total_weight_donation' => $totalWeightDonation,
                'total_weight' => $totalWeightDonation + $totalWeightRecycling,
            ],
        ];

        return $this->response('success', $total);

    }

    public function getLocationsReport(array $data): JsonResponse
    {

        $locale = AppHelper::getLanguageForMobile();
        $countryId = null;
        $associationId = null;
        if (array_key_exists('country_id', $data)) {
            $countryId = $data['country_id'];
        }
        $startDate = $endDate = null;
        if (array_key_exists('start_date', $data)) {
            $startDate = $data['start_date'];
        }
        if (array_key_exists('end_date', $data)) {
            $endDate = $data['end_date'];
        }
        $locationId = null;
        if (array_key_exists('location_id', $data)) {
            $locationId = $data['location_id'];
        }

        $column = 'created_at';
        if (isset($data['date_type']))
            $column = $data['date_type'];

        $queryLocations = Location::query()->with(['province' => function ($query) use ($startDate, $endDate, $column) {
            $query->with(['orders' => function ($query) use ($startDate, $endDate, $column) {
                $query->when($endDate != null, function ($query) use ($endDate, $column) {
                    return $query->whereDate($column, '<=', $endDate);
                });
                $query->when($startDate != null, function ($query) use ($startDate, $column) {
                    return $query->whereDate($column, '>=', $startDate);
                });

                return $query;
            }]);

            return $query;
        }])->with(['country'])->when($countryId != null, function ($query) use ($countryId) {
            return $query->where('country_id', $countryId);
        })->when($locationId != null, function ($query) use ($locationId) {
            return $query->where('id', $locationId);
        });


        $locationsResult = [];
        $locations = $queryLocations->get();

        $totalOrders = 0;
        $totalWeightRecycling = 0;
        $totalWeightDonation = 0;

        $totalSuccessfulOrder = 0;
        $successfulOrdersRatio = 0;
        $postponedOrders = 0;
        $postponedOrdersRatio = 0;
        $cancelOrdersRatio = 0;
        $cancelOrders = 0;
        $totalContainers = 0;
        $totalUnloadingContainersCountry = 0;
        $totalWeightContainersCountry = 0;


        foreach ($locations as $location) {
            if ($location->province_id) {
                $totalContainer = 0;
                $totalUnloadingContainersCountry = 0;
                $totalWeightContainersCountry = 0;

                $allContainers = Container::whereProvinceId($location->province_id)->get();
                $totalContainers = $allContainers->count();

                $containersDetails = ContainerDetails::whereIn('container_id', $allContainers->pluck('id'))
                    ->when($startDate != null, function ($query) use ($startDate) {
                        return $query->where('date', '>=', $startDate);
                    })
                    ->when($endDate != null, function ($query) use ($endDate) {
                        return $query->where('date', '<=', $endDate);
                    })
                    ->where('weight', '>', 0);
                $totalUnloadingContainersCountry = $containersDetails->groupBy('container_id')->count();
                $totalWeightContainersCountry = $containersDetails->sum('weight');

            }
            if ($location->province) {
                $totalOrders = 0;
                $totalWeightRecycling = 0;
                $totalWeightDonation = 0;
                $totalSuccessfulOrder = 0;
                $successfulOrdersRatio = 0;
                $postponedOrders = 0;
                $postponedOrdersRatio = 0;
                $cancelOrdersRatio = 0;
                $cancelOrders = 0;

                if ($location->province->orders && $location->province->orders->count() > 0) {
                    $totalOrders = $totalOrders + $location->province->orders->count();
                    $totalWeightRecycling = $totalWeightRecycling + $location->province->orders->where('type', OrderType::RECYCLING)->sum('weight');
                    $totalWeightDonation = $totalWeightDonation + $location->province->orders->where('type', OrderType::DONATION)->sum('weight');
                    $totalSuccessfulOrder = $totalSuccessfulOrder + $location->province->orders->where('status', OrderStatus::SUCCESSFUL)->count();
                    $postponedOrders = $postponedOrders + $location->province->orders->whereNotIn('status', [OrderStatus::SUCCESSFUL, OrderStatus::FAILED])->count();
                    $cancelOrders = $cancelOrders + $location->province->orders->whereIn('status', [OrderStatus::CANCEL, OrderStatus::FAILED])->count();
                }
            }

            if ($totalOrders != 0) {
                $successfulOrdersRatio = round(($totalSuccessfulOrder / $totalOrders) * 100, 1);
                $postponedOrdersRatio = round(($postponedOrders / $totalOrders) * 100, 1);
                $cancelOrdersRatio = round(($cancelOrders / $totalOrders) * 100, 1);
            }

            $locationsResult[] = [
                'area_name' => $location['name'],
                'country_name' => $this->getTranslateValue($locale, $location->country['meta'], 'name', $location->country['name']),
                'total_orders' => $totalOrders,
                'successful_orders' => $totalSuccessfulOrder,
                'successful_orders_ratio' => $successfulOrdersRatio . '%',
                'postponed_orders' => $postponedOrders,
                'postponed_orders_ratio' => $postponedOrdersRatio . '%',
                'cancel_orders' => $cancelOrders,
                'cancel_orders_ratio' => $cancelOrdersRatio . '%',
                'total_weight_recycling' => $totalWeightRecycling,
                'total_weight_donation' => $totalWeightDonation,
                'total_containers' => $totalContainers,
                'total_unloading_containers' => $totalUnloadingContainersCountry,
                'total_weight_containers' => $totalWeightContainersCountry,
                'total_weight' => $totalWeightContainersCountry + $totalWeightRecycling + $totalWeightDonation,
            ];
        }

        $totalOrders = 0;
        $successfulOrders = 0;
        $successfulOrdersRatio = 0;
        $postponedOrders = 0;
        $postponedOrdersRatio = 0;
        $cancelOrders = 0;
        $cancelOrdersRatio = 0;
        $totalWeightRecycling = 0;
        $totalWeightDonation = 0;
        $totalContainers = 0;
        $totalUnloadingContainers = 0;
        $totalWeightContainers = 0;
        foreach ($locationsResult as $item) {
            $totalOrders = $totalOrders + $item['total_orders'];
            $successfulOrders = $successfulOrders + $item['successful_orders'];
            $postponedOrders = $postponedOrders + $item['postponed_orders'];
            $cancelOrders = $cancelOrders + $item['cancel_orders'];
            $totalWeightRecycling = $totalWeightRecycling + $item['total_weight_recycling'];
            $totalWeightDonation = $totalWeightDonation + $item['total_weight_donation'];
            $totalContainers = $totalContainers + $item['total_containers'];
            $totalUnloadingContainers = $totalUnloadingContainers + $item['total_unloading_containers'];
            $totalWeightContainers = $totalWeightContainers + $item['total_weight_containers'];
        }

        if ($totalOrders != 0) {
            $successfulOrdersRatio = round(($successfulOrders / $totalOrders) * 100, 1);
            $postponedOrdersRatio = round(($postponedOrders / $totalOrders) * 100, 1);
            $cancelOrdersRatio = round(($cancelOrders / $totalOrders) * 100, 1);
        }
        $total = [
            'total_orders' => $totalOrders,
            'successful_orders' => $successfulOrders,
            'successful_orders_ratio' => $successfulOrdersRatio . '%',
            'postponed_orders' => $postponedOrders,
            'postponed_orders_ratio' => $postponedOrdersRatio . '%',
            'cancel_orders' => $cancelOrders,
            'cancel_orders_ratio' => $cancelOrdersRatio . '%',
            'total_weight_recycling' => $totalWeightRecycling,
            'total_weight_donation' => $totalWeightDonation,
            'total_containers' => $totalContainers,
            'total_unloading_containers' => $totalUnloadingContainers,
            'total_weight_containers' => $totalWeightContainers,
            'total_weight' => $totalWeightContainers + $totalWeightDonation + $totalWeightRecycling,
        ];

        $res = [
            'locations' => $locationsResult,
            'total' => $total,
        ];

        return $this->response('success', $res);
    }
}

