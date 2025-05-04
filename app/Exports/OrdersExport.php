<?php

namespace App\Exports;

use App\Filters\DateRangeFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Repositories\Order\OrderRepository;
use App\Http\Resources\Order\OrderResourceForExport;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use ipinfo\ipinfo\IPinfoException;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\QueryBuilder\AllowedFilter;

class OrdersExport implements FromArray, WithHeadings
{
    use Exportable;

    public function __construct(public OrderRepository $repository)
    {
    }

    public function headingRow(): int
    {
        return 2;
    }

    /**
     * @return array
     *
     * @throws IPinfoException
     */
    public function array(): array
    {

        $filters = [
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('association_id'),
            AllowedFilter::partial('status'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('platform'),
            AllowedFilter::exact('customer_id'),
            AllowedFilter::exact('agent_id'),
            AllowedFilter::callback('customer_name', function (Builder $query, $value) {
                $query->whereHas('customer', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::callback('agent_name', function (Builder $query, $value) {
                $query->whereHas('agent', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::custom('date_range', new DateRangeFilter('orders.created_at')),
            AllowedFilter::custom('start_task_range', new DateRangeFilter('orders.start_task')),
        ];
        $orders = $this->repository->getAllData(
            Order::select([
                'orders.id',
                'countries.meta as country_meta',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'addresses.location_title',
                'agents.name as agent_name',
                'associations.meta as association_meta',
                'orders.status',
                'orders.type',
                'orders.weight',
                'orders.value',
                'orders.platform',
                'orders.failed_message',
                'orders.created_at',
                'orders.start_at',
                'orders.start_task',
                'orders.ends_at',
            ])->join('countries', 'orders.country_id', '=', 'countries.id')
                ->leftJoin('users as customers', 'orders.customer_id', '=', 'customers.id')
                ->leftJoin('addresses', 'orders.address_id', '=', 'addresses.id')
                ->leftJoin('users as agents', 'orders.agent_id', '=', 'agents.id')
                ->leftJoin('associations', 'orders.association_id', '=', 'associations.id'), $filters);
        $allOrders = [];
        $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();
        $language = AppHelper::getLanguageForMobile();

        foreach ($orders as $order) {
            $allOrders[] = new OrderResourceForExport($order, $settings, $language);
        }

        return $allOrders;
    }

    public function headings(): array
    {
        $language = AppHelper::getLanguageForMobile();
        if ($language == 'ar')
        return [
            'id',
            'البلد',
            'اسم العميل',
            'رقم العميل',
            'العنوان',
            'الوكيل',
            'الجمعية',
            'الحالة',
            'النوع',
            'الوزن',
            'القيمة',
            'المنصة',
            'رسالة الخطأ',
            'تاريخ الانشاء',
            'تاريخ البدء',
            'تاريخ بدء المهمة',
            'تاريخ الانتهاء',
        ];
        else
            return [
                'id',
                'country',
                'customer name',
                'customer phone',
                'address',
                'agent',
                'association',
                'status',
                'type',
                'weight',
                'value',
                'platform',
                'Failed message',
                'created at',
                'start at',
                'start task',
                'ends at',
            ];
    }
}
