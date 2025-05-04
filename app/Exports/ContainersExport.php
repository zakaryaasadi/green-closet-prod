<?php

namespace App\Exports;

use App\Http\API\V1\Repositories\Container\ContainerRepository;
use App\Http\Resources\Container\ContainerResourceForReport;
use App\Models\Container;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\QueryBuilder\AllowedFilter;

class ContainersExport implements FromArray, WithHeadings
{
    use Exportable;

    public function __construct(public ContainerRepository $repository)
    {
    }

    public function headingRow(): int
    {
        return 2;
    }

    /**
     * @return array
     */
    public function array(): array
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
        $containers = $this->repository->getAllData(Container::class, $filters);
        $allContainers = [];

        foreach ($containers as $container) {
            $allContainers[] = new ContainerResourceForReport($container);
        }

        return $allContainers;
    }

    public function headings(): array
    {
        return [
            'Id',
            'code',
            'association',
            'team',
            'country',
            'province',
            'district',
            'neighborhood',
            'street',
            'discharge_shift',
            'type',
            'weight',
            'status',
        ];
    }
}
