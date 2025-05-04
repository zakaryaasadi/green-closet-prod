<?php

namespace App\Http\API\V1\Repositories\Container;

use App\Enums\ContainerStatus;
use App\Enums\PaymentStatus;
use App\Filters\CustomFilterContainers;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\Container\ContainerResourceForReport;
use App\Http\Resources\Container\SimpleContainerResource;
use App\Models\Container;
use App\Models\ContainerDetails;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Point as GeometryPoint;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Log;
use Mpdf\MpdfException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class ContainerRepository extends BaseRepository
{
    use  ApiResponse;

    public function __construct(Container $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('association_id'),
            AllowedFilter::callback('association_name', function (Builder $query, $value) {
                $query->whereHas('association', function ($query) use ($value) {
                    return $query->where('title', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('team_id'),
            AllowedFilter::callback('team_name', function (Builder $query, $value) {
                $query->whereHas('team', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('province_id'),
            AllowedFilter::callback('province_name', function (Builder $query, $value) {
                $query->whereHas('province', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('district_id'),
            AllowedFilter::callback('district_name', function (Builder $query, $value) {
                $query->whereHas('district', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('neighborhood_id'),
            AllowedFilter::callback('neighborhood_name', function (Builder $query, $value) {
                $query->whereHas('neighborhood', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('street_id'),
            AllowedFilter::callback('street_name', function (Builder $query, $value) {
                $query->whereHas('street', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('type'),
            AllowedFilter::exact('discharge_shift'),
            AllowedFilter::partial('code'),
            AllowedFilter::custom('search', new CustomFilterContainers()),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('code'),
            AllowedSort::field('association_id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('province_id'),
            AllowedSort::field('district_id'),
            AllowedSort::field('neighborhood_id'),
            AllowedSort::field('street_id'),
            AllowedSort::field('status'),
            AllowedSort::field('type'),
            AllowedSort::field('created_at'),
            AllowedSort::field('discharge_shift'),
        ];

        return parent::filter(Container::class, $filters, $sorts);

    }

    public function indexAgentContainers($data): PaginatedData
    {
        $team = \Auth::user()->team;
        if (isset($data['lat']) && isset($data['lng'])) {
            $point = new GeometryPoint($data['lat'], $data['lng']);
            $containers = Container::orderByDistance('location', $point)
                ->where('team_id', '=', $team?->id);
        }
        else
            $containers = Container::whereTeamId($team?->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('type'),
            AllowedFilter::exact('association_id'),
            AllowedFilter::partial('code'),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('association_id'),
            AllowedSort::field('code'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($containers, $filters, $sorts);
    }

    public function storeContainer(Collection $data): Container
    {
        $container = new Container($data->all());
        $location = $data->get('location');
        $point = new Point($location['lat'], $location['lng']);
        $container->location = $point;
        $container->save();
        $container->refresh();

        return $container;
    }

    public function updateContainer(Container $container, Collection $data): Container
    {
        $container->fill($data->all());
        if ($data->has('location')) {
            $location = $data->get('location');
            $point = new Point($location['lat'], $location['lng']);
            $container->location = $point;
        }
        $container->save();
        $container->refresh();

        return $container;
    }

    public function indexNearbyContainers($data): array
    {
        $point = new GeometryPoint($data['lat'], $data['lng']);
        $team = \Auth::user()->team;
        $containers = Container::orderByDistance('location', $point)->where('team_id', '=', $team?->id)
            ->where('status', '=', ContainerStatus::ON_THE_FIELD)
            ->take(10)->get();
        $allContainers = [];
        foreach ($containers as $container) {
            $allContainers[] = new SimpleContainerResource($container);
        }

        return $allContainers;
    }

    public function storeContainerDetails($data, $byAgent = true): ContainerDetails
    {
        $containerDetails = new ContainerDetails();
        $containerDetails->fill($data);
        
        if($byAgent){
            $containerDetails->date = Carbon::now('UTC');
            $containerDetails->agent_id = \Auth::id();
        }
        if ($containerDetails->container->association_id) {
            // $containerValue = Setting::where(['country_id' => \Auth::user()->country_id])->first()?->container_value;
            $containerValue = Setting::where(['country_id' => $containerDetails->container->country_id])->first()?->container_value;
            $value = $containerValue ?? Setting::where(['country_id' => null])->first()->container_value;
            $containerDetails->value = $containerDetails->weight * $value;
            $containerDetails->status = PaymentStatus::UNPAID;
        }
        $containerDetails->save();
        $containerDetails->refresh();

        return $containerDetails;
    }

    public function updateContainerDetails($data, ContainerDetails $containerDetails): ContainerDetails
    {
        $containerDetails->fill($data);
        if (array_key_exists('agent_id', $data)) {
            $containerDetails->agent_id = $data['agent_id'];
        }
        $containerDetails->save();
        $containerDetails->refresh();

        return $containerDetails;
    }

    public function getPdfReport(): Collection|array
    {
        $filters = [
            AllowedFilter::exact('association_id'),
            AllowedFilter::exact('team_id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('province_id'),
            AllowedFilter::exact('district_id'),
            AllowedFilter::exact('neighborhood_id'),
            AllowedFilter::exact('street_id'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('type'),
            AllowedFilter::exact('discharge_shift'),
        ];

        $containers = $this->getAllData(Container::class, $filters);
        $allContainers = [];

        foreach ($containers as $container) {
            $allContainers[] = new ContainerResourceForReport($container);
        }

        return $allContainers;
    }

    /**
     * @throws MpdfException
     */
    public function generatePdf($containers): ?string
    {
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path('tempdir'),
            'mode' => 'utf-8',
            'format' => 'A3-L',
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $language_code = request()->header('language');
        $html = view('pdf.containers-report')->with([
            'containers' => $containers,
            'lang' => $language_code,
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('containers-report.pdf', 'D');
    }

    public function getContainerDetails(array $data, Container $container): \Illuminate\Database\Eloquent\Collection
    {
        $agentId = null;
        if (array_key_exists('agent_id', $data)) {
            $agentId = $data['agent_id'];
        }
        $startDate = $endDate = null;
        if (array_key_exists('start_date', $data)) {
            $startDate = $data['start_date'];
        }
        if (array_key_exists('end_date', $data)) {
            $endDate = $data['end_date'];
        }
        $query = $container->containerDetails()->when($agentId != null, function ($query) use ($agentId) {
            return $query->where('agent_id', $agentId);
        })->when($startDate != null, function ($query) use ($startDate) {
            return $query->where('date', '>=', $startDate);
        })->when($endDate != null, function ($query) use ($endDate) {
            return $query->where('date', '<=', $endDate);
        })->orderByDesc('date');

        return $query->get();
    }
}
