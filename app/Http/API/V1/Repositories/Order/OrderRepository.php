<?php

namespace App\Http\API\V1\Repositories\Order;

use App\Enums\DaysEnum;
use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PointStatus;
use App\Enums\UserType;
use App\Events\Agent as AgentEvents;
use App\Events\Customer as CustomerEvents;
use App\Filters\AgentOrdersFilter;
use App\Filters\CustomFilterOrders;
use App\Filters\DateRangeFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderResourceForExport;
use App\Http\Resources\Order\SimpleOrderResource;
use App\Models\Address;
use App\Models\Association;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\ItemOrders;
use App\Models\Location;
use App\Models\Message;
use App\Models\Order;
use App\Models\Point;
use App\Models\Province;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\FcmNotification;
use App\Traits\FileManagement;
use App\Traits\SmsService;
use Carbon\Carbon;
use Exception;
use Grimzy\LaravelMysqlSpatial\Types\Point as GeometryPoint;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use ipinfo\ipinfo\IPinfoException;
use Mpdf\MpdfException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Illuminate\Support\Facades\Http;

class OrderRepository extends BaseRepository
{
    use ApiResponse, FcmNotification, FileManagement;

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('association_id'),
            AllowedFilter::exact('message_id'),
            AllowedFilter::exact('agent_id'),
            AllowedFilter::callback('agent_name', function (Builder $query, $value) {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }

                return $query->whereHas('agent', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('customer_id'),
            AllowedFilter::callback('customer_name', function (Builder $query, $value) {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }

                return $query->whereHas('customer', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::callback('customer_phone', function (Builder $query, $value) {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }

                return $query->whereHas('customer', function ($query) use ($value) {
                    return $query->where('phone', 'like', '%' . $value . '%')
                                    ->orWhere('phone', 'like', '%' . str_replace(' ', '', $value) . '%');
                });
            }),
            AllowedFilter::callback('association_name', function (Builder $query, $value) {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }

                return $query->whereHas('association', function ($query) use ($value) {
                    return $query->where('title', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('weight'),
            AllowedFilter::exact('type'),
            AllowedFilter::partial('platform'),
            AllowedFilter::partial('created_at'),
            AllowedFilter::partial('start_task'),
            AllowedFilter::custom('date_range', new DateRangeFilter('created_at')),
            AllowedFilter::custom('start_task_range', new DateRangeFilter('start_task')),
            AllowedFilter::custom('search', new CustomFilterOrders()),

        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('start_at'),
            AllowedSort::field('ends_at'),
            AllowedSort::field('created_at'),
            AllowedSort::field('start_task'),
            AllowedSort::field('customer_id'),
            AllowedSort::field('agent_id'),
            AllowedSort::field('status'),
            AllowedSort::field('association_id'),
            AllowedSort::field('weight'),
            AllowedSort::field('type'),
            AllowedSort::field('platform'),
        ];

        return parent::filter(Order::query()->with(['agent', 'customer', 'association', 'country', 'address']), $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexCustomerOrder(): PaginatedData
    {
        $clientCountry = AppHelper::getCoutnryForMobile();
        $orders = \Auth::user()->orders()->where('country_id', $clientCountry->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('agent_id'),
            AllowedFilter::exact('status'),
            AllowedFilter::partial('weight'),
            AllowedFilter::exact('type'),
            AllowedFilter::partial('start_at'),
            AllowedFilter::partial('ends_at'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
            AllowedSort::field('weight'),
            AllowedSort::field('ends_at'),
            AllowedSort::field('start_at'),

        ];

        return parent::filter($orders->with(['agent', 'customer', 'association', 'country', 'address']), $filters, $sorts);
    }

    public function indexAgentOrder($data): PaginatedData
    {
        if (isset($data['lat']) && isset($data['lng'])) {
            $point = new GeometryPoint($data['lat'], $data['lng']);
            $orders = Order::orderByDistance('location', $point)
                ->where('agent_id', '=', \Auth::id());
        } else
            $orders = \Auth::user()->agentOrders();

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('status'),
            AllowedFilter::partial('weight'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('start_at'),
            AllowedFilter::partial('start_task'),
            AllowedFilter::partial('ends_at'),
            AllowedFilter::custom('search', new AgentOrdersFilter()),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
            AllowedSort::field('weight'),
            AllowedSort::field('ends_at'),
            AllowedSort::field('start_at'),
            AllowedSort::field('start_task'),
        ];

        return parent::filter($orders->with(['country', 'customer', 'agent', 'association', 'address']), $filters, $sorts);
    }

    public function getAgentOrderCount($data): array
    {
        $order = Order::query()->where('agent_id', '=', \Auth::id());

        if (isset($data['start_task'])) {
            $order->where('start_task', 'like', '%' . $data['start_task'] . '%');
        } else {
            $order->where('start_task', 'like', '%' . Carbon::today('UTC') . '%');
        }

        return [
            'assigned' => $order->clone()->where('status', '=', OrderStatus::ASSIGNED)->count(),
            'successful' => $order->clone()->where('status', '=', OrderStatus::SUCCESSFUL)->count(),
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderAccepted(Order $model): Model
    {
        return $this->updateStatus($model, OrderStatus::ACCEPTED);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderAssigned(Order $model): Order
    {
        return $this->updateStatus($model, OrderStatus::ASSIGNED);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderPostponed(Order $model): Order
    {
        return $this->updateStatus($model, OrderStatus::POSTPONED);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderCanceled(Order $model): Model
    {
        return $this->updateStatus($model, OrderStatus::CANCEL);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderSuccessful(Order $model): Model
    {
        return $this->updateStatus($model, OrderStatus::SUCCESSFUL);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderDelivering(Order $model): Model
    {
        return $this->updateStatus($model, OrderStatus::DELIVERING);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderFailed(Order $model): Model
    {
        return $this->updateStatus($model, OrderStatus::FAILED);
    }

    /**
     * @throws GuzzleException
     */
    public function makeOrderDeclined(Order $model): Model
    {
        return $this->updateStatus($model, OrderStatus::DECLINE);
    }

    public function storeOrder(Collection $data): JsonResponse
    {
        $user = null;
        if ($data->get('phone')) {
            $user = User::where('phone', $data->get('phone'))->first();
        }

        if (!is_null($user) and $user->type != UserType::CLIENT)
            return $this->responseMessage(__("You can't add order to this user"), 422);

        if ($user == null) {
            $user = new User();
            $user->name = $data->get('name');
            $user->phone = $data->get('phone');
            $user->type = UserType::CLIENT;
            $user->country_id = $data->get('country_id');
            $user->save();
            $user->refresh();
        }

        if ($this->checkActiveOrders($user, $data))
            return $this->responseMessage('You already have an active order', 403);


        $order = new Order();
        $order->country_id = $data->get('country_id') ?? $user->country_id;
        $order->customer_id = $user->id;
        $order->type = $data->get('type');
        $order->association_id = $data->get('association_id');
        $order->status = OrderStatus::CREATED;
        $order->platform = $data->get('platform');

        if ($data->has('address_id')) {
            $address = Address::whereId($data->get('address_id'))->first();
            $order->address_id = $address->id;
            $order->province_id = $address->province_id;
            $point = new GeometryPoint($address->location->getLat(), $address->location->getLng());
            $order->location = $point;
        } else {
            $address = new Address();
            $address->province_id = $data->get('province_id');
            $address->user_id = $user->id;
            $location = $data->get('location');
            $address->location_title = $location['title'];
            $point = new GeometryPoint($location['lat'], $location['lng']);
            $order->location = $point;
            $address->location = $point;

            if ($data->has('building'))
                $address->building = $data->get('building');

            if ($data->has('floor_number'))
                $address->floor_number = $data->get('floor_number');

            if ($data->has('apartment_number'))
                $address->apartment_number = $data->get('apartment_number');

            $address->save();
            $address->refresh();

            $order->address_id = $address->id;
            $order->province_id = $address->province_id;
        }

        $autoAssign = Setting::where(['country_id' => $order->country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($autoAssign->auto_assign == 1) {
            $this->orderAutoAssign($order);
        }
        $order->save();
        $order->refresh();
        CustomerEvents\OrderStatusChangedEvent::dispatch($order);


//        try {
//            AdminEvents\OrderStatusChangedEvent::dispatch($order);
//        } catch (Exception $e) {
//        }

        return $this->showOne($order, OrderResource::class, __('The order added successfully'));
    }

    /**
     * @throws MpdfException
     * @throws IPinfoException
     * @throws GuzzleException
     */
    public function updateOrder(array $data, Order $order): Order
    {
        $order->fill($data);

        $country_id = $order->country_id;
        $settings = Setting::where(['country_id' => $country_id])->first();
        if ($settings == null) {
            $settings = Setting::where(['country_id' => null])->first();
        }
        if (isset($data['name'])) {
            $customer = $order->customer;
            $customer->update(['name' => $data['name']]);
            $customer->refresh();
        }
        if (isset($data['phone'])) {
            $customer = $order->customer;
            $customer->update(['phone' => $data['phone']]);
            $customer->refresh();
        }
        if (isset($data['type'])) {
            if ($data['type'] == OrderType::RECYCLING) {
                $order->association_id = null;
            }
        }

        if (isset($data['building']) && $order->address) {
            $address = $order->address;
            $address->update(['building' => $data['building']]);
            $address->refresh();
        }

        if (isset($data['floor_number']) && $order->address) {
            $address = $order->address;
            $address->update(['floor_number' => $data['floor_number']]);
            $address->refresh();
        }

        if (isset($data['apartment_number']) && $order->address) {
            $address = $order->address;
            $address->update(['apartment_number' => $data['apartment_number']]);
            $address->refresh();
        }

        if (isset($data['province_id']) && $order->address) {
            $address = $order->address;
            $address->update(['province_id' => $data['province_id']]);
            $address->refresh();
            $order->province_id = $data['province_id'];
        }
        if (isset($data['location']) && $order->address) {
            $location = $data['location'];
            $point = new GeometryPoint($location['lat'], $location['lng']);
            $order->location = $point;
            $address = $order->address;
            $address->update(['location' => $point]);
            $address->refresh();
        }

        if (isset($data['start_task'])) {
            $order->start_task = $data['start_task'];
        }

        if (isset($data['weight'])) {
            $weight = $data['weight'];
            $order->weight = $weight;

            $order->save();
            $order->refresh();

            if ($order->status == OrderStatus::SUCCESSFUL) {
                $orderPoints = Point::whereOrderId($order->id)->first();
                if ($orderPoints == null) {
                    $this->putOrderPoints($order, $settings);
                } else {
                    $points = 0;
                    $calculatePoints = $settings->calculate_points;
                    if ($calculatePoints) {
                        $points = $settings->points_per_order;
                    } else {
                        $pointCount = $settings->point_count;
                        $points = $pointCount * $order->weight;
                    }
                    if ($points > 0) {
                        $orderPoints->update([
                            'count' => $points,
                            'ends_at' => Carbon::now('UTC')->addDays($settings->point_expire),
                            'status' => PointStatus::ACTIVE,
                            'used' => false,
                        ]);
                        echo $orderPoints->id;
                        $orderPoints->save();
                        $orderPoints->refresh();
                    }
                }
            }
        }

        if (isset($data['status'])) {
            $order = $this->updateStatus($order, $data['status']);
        }

        if ($order->status == OrderStatus::SUCCESSFUL) {
            $weight = 0;
            $value = 0;
            $itemData = [];
            if (isset($data['items'])) {
                $items = collect($data['items']);
                foreach ($items as $item) {
                    $item = collect($item);
                    $itemData[$item->get('id')] = ['weight' => $item->get('weight')];
                    $weight += $item->get('weight');
                    $value += Item::whereId($item->get('id'))->first()->price_per_kg * $item->get('weight');
                }
                $order->items()->attach($itemData);
                $order->weight = $weight;
                $order->value = $value;
            }
            $order->ends_at = Carbon::now('UTC');
            $order->total_time = gmdate('H:i:s', Carbon::now()->diffInSeconds($order->start_at));
            $order->payment_status = PaymentStatus::UNPAID;
            if ($order->type == OrderType::RECYCLING) {
                if ($order->agent?->agentSettings != null) {
                    if ($order->agent->agentSettings->budget >= $value) {
                        $order->agent->agentSettings->budget = $order->agent->agentSettings->budget - $order->value;
                        $order->agent->agentSettings->save();
                        $order->agent->agentSettings->refresh();
                        $order->payment_remaining = $order->agent_payment - $order->value;
                        $order->payment_status = PaymentStatus::PAID;
                    }
                }
            }
            $order->save();
            $order->refresh();
            if ($order->customer)
                CustomerEvents\OrderStatusChangedEvent::dispatch($order);
            if ($order->agent)
                AgentEvents\OrderStatusChangedEvent::dispatch($order);

            $this->generateInvoice($order);
        }

        if ($order->platform != 'Mobile Application')
            CustomerEvents\OrderStatusChangedSendSmsEvent::dispatch($order);


        $order->save();
        $order->refresh();

        return $order;
    }

    /**
     * @throws IPinfoException
     */
    public function storeCustomerOrder($data): Order
    {
        $clientCountry = AppHelper::getCoutnryForMobile();
        $user = \Auth::user();
        $order = new Order();
        $order->fill($data);
        $order->customer_id = $user->id;
        $order->country_id = $clientCountry->id;
        $order->status = OrderStatus::CREATED;
        $order->platform = 'Mobile Application';
        $address = Address::find($data['address_id']);
        $location = $address->location;
        $order->province_id = $address->province_id;
        $order->location = new GeometryPoint($location->getLat(), $location->getLng());

        $autoAssign = Setting::where(['country_id' => $order->country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($autoAssign->auto_assign == 1) {
            $this->orderAutoAssign($order);
        }
        $order->save();
        $order->refresh();

        try {
            CustomerEvents\OrderStatusChangedEvent::dispatch($order);

        } catch (Exception $e) {
        }

//        try {
//            AdminEvents\OrderStatusChangedEvent::dispatch($order);
//        } catch (Exception $e) {
//        }


        return $order;
    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function updateStatus(Order $order, $status): Order
    {
        $itemData = [];
        $weight = 0;
        $value = 0;
        switch ($status) {

            case OrderStatus::ASSIGNED:
                if (request()->filled('start_task'))
                    $order->start_task = request('start_task');
                if (request()->filled('agent_id'))
                    $order->agent_id = request('agent_id');
                break;

            case OrderStatus::POSTPONED:
                if (request('start_task') != null) {
                    $UTC = Carbon::parse(request('start_task'), 'UTC');
                    $order->start_task = $UTC;
                }

                if (request('message') != null)
                    $order->failed_message = request('message');
                if (request('message_id') != null) {
                    $order->message_id = request('message_id');
                    $order->failed_message = Message::whereId(request('message_id'))->first()->content;
                }
                break;

            case OrderStatus::CANCEL:
            case OrderStatus::FAILED:
                if (request('message') != null)
                    $order->failed_message = request('message');
                if (request('message_id') != null) {
                    $order->message_id = request('message_id');
                    $order->failed_message = Message::whereId(request('message_id'))?->first()?->content ?? '';
                }
                break;

            case OrderStatus::DELIVERING:
                $order->start_at = Carbon::now('UTC');
                break;

            case OrderStatus::SUCCESSFUL:
                $country_id = $order->country_id;
                $settings = Setting::where(['country_id' => $country_id])->first();
                if ($settings == null) {
                    $settings = Setting::where(['country_id', null])->first();
                }

                if (request('start_task') != null) {
                    $UTC = Carbon::parse(request('start_task'), 'UTC');
                    $order->start_task = $UTC;
                }

                //Order Items
                $items = collect(request('items'));
                foreach ($items as $item) {
                    $item = collect($item);
                    $itemData[$item->get('id')] = ['weight' => $item->get('weight')];
                    $weight += $item->get('weight');
                    $value += Item::whereId($item->get('id'))->first()->price_per_kg * $item->get('weight');
                }
                $order->items()->attach($itemData);
                $order->weight = $weight;
                $order->image = $this->getImage();
                $order->value = $value;
                $order->ends_at = Carbon::now('UTC');
                $order->total_time = gmdate('H:i:s', Carbon::now()->diffInSeconds($order->start_at));
                $order->payment_status = PaymentStatus::UNPAID;
                if ($order->type == OrderType::RECYCLING) {
                    if (request('agent_payment') != null) {
                        $order->agent_payment = request('agent_payment');
                        if ($order->agent?->agentSettings != null) {
                            $order->agent->agentSettings->budget = $order->agent->agentSettings->budget - $order->agent_payment;
                            $order->agent->agentSettings->save();
                            $order->agent->agentSettings->refresh();
                            $order->payment_remaining = $order->agent_payment - $order->value;
                            $order->payment_status = PaymentStatus::PAID;
                        }
                    }
                }
                $this->putOrderPoints($order, $settings);
                break;
        }
        $order->status = $status;
        $order->save();
        $order->refresh();
        if ($order->customer)
            CustomerEvents\OrderStatusChangedEvent::dispatch($order);
        if ($order->agent)
            AgentEvents\OrderStatusChangedEvent::dispatch($order);

        if ($order->status == OrderStatus::SUCCESSFUL)
            $this->generateInvoice($order);

        if ($order->platform != 'Mobile Application')
            CustomerEvents\OrderStatusChangedSendSmsEvent::dispatch($order);

        return $order;
    }

    /**
     * @throws MpdfException
     * @throws IPinfoException
     * @throws GuzzleException
     */
    public function updateOrderItems(Order $order, array $data): JsonResponse
    {
        $itemData = [];
        $weight = 0;
        $value = 0;
        $items = collect($data['items']);
        foreach ($items as $item) {
            $item = collect($item);
            $itemData[$item->get('id')] = ['weight' => $item->get('weight')];
            $weight += $item->get('weight');
            $value += Item::whereId($item->get('id'))->first()->price_per_kg * $item->get('weight');
        }
        ItemOrders::whereOrderId($order->id)->delete();
        $order->items()->sync($itemData);
        $order->weight = $weight;
        $order->value = $value;
        $order->save();
        $order->refresh();
        $this->generateInvoice($order);

        return $this->responseMessage(__('Order items updated successfully'));
    }

    public function indexNearbyOrders($data): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('status'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('start_task'),
            AllowedFilter::partial('created_at'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
            AllowedSort::field('start_task'),
        ];

        $point = new GeometryPoint($data['lat'], $data['lng']);
        $orders = Order::orderByDistance('location', $point)
            ->where('agent_id', '=', \Auth::id());

        return parent::filter($orders, $filters, $sorts);

    }

    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    public function updateManyOrders(Collection $data)
    {
        foreach ($data->get('orders_ids') as $id) {
            $order = Order::whereId($id)->first();
            if ($data->has('status')) {
                $this->updateStatus($order, $data->get('status'));
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected function getImage()
    {
        if (request()->has('image')) {
            $file = request()->file('image');

            return $this->createFile($file, null, null, Order::getDisk());
        }

        return null;
    }

    public function deleteManyOrders(Collection $data)
    {
        foreach ($data->get('orders_ids') as $id)
            Order::whereId($id)?->delete();
    }

    /**
     * @throws IPinfoException
     */
    public function getPdfReport(): Collection|array
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('association_id'),
            AllowedFilter::exact('agent_id'),
            AllowedFilter::callback('agent_name', function (Builder $query, $value) {
                $query->whereHas('agent', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('customer_id'),
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
            AllowedFilter::partial('status'),
            AllowedFilter::partial('type'),
            AllowedFilter::partial('platform'),
            AllowedFilter::custom('date_range', new DateRangeFilter('created_at')),
        ];

        $orders = $this->getAllData(Order::with(['agent', 'customer', 'association', 'country', 'address']), $filters);
        $allOrders = [];

        $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();
        $language = AppHelper::getLanguageForMobile();

        foreach ($orders as $order) {
            $allOrders[] = new OrderResourceForExport($order, $settings, $language);
        }

        return $allOrders;
    }

    /**
     * @throws MpdfException
     */
    public function generatePdf($orders): ?string
    {
        $mpdf = new \Mpdf\Mpdf(
            ['tempDir' => storage_path('tempdir'),
                'mode' => 'utf-8',
                'format' => 'A3',
            ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $language_code = request()->header('language');
        $html = view('pdf.orders-report')->with([
            'orders' => $orders,
            'lang' => $language_code,
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('orders-report.pdf', 'D');
    }

    /**
     * @throws MpdfException
     * @throws IPinfoException
     * @throws Exception
     * @throws GuzzleException
     */
    public function generateInvoice(Order $order)
    {
        $settings = Setting::whereCountryId($order->country_id)?->first() ?? Setting::where(['country_id' => null])->first();
        $invoice = Invoice::whereOrderId($order->id)->first();
        if ($invoice == null) {
            $invoice = new Invoice();
            $invoice->order_id = $order->id;
            $invoice->save();
        }

        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => storage_path('tempdir'),
            'mode' => 'utf-8',
            'format' => 'A3',
        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $currency_en = $settings->currency_en;
        $currency_ar = $settings->currency_ar;
        if ($order->type == OrderType::RECYCLING)
            $html = view('pdf.orders-invoice-recycling')->with([
                'order' => $order,
                'address' => $settings->location,
                'currency_en' => $currency_en,
                'currency_ar' => $currency_ar,
                'invoice' => $invoice,
            ]);

        else
            $html = view('pdf.orders-invoice-donation')->with([
                'order' => $order,
                'address' => $settings->location,
                'invoice' => $invoice,
            ]);

        $mpdf->WriteHTML($html);
        $fileName = 'order' . $order->id . '-invoice' . $invoice->id . Str::uuid()->toString() . '.pdf';
        Invoice::getDisk()->put($fileName, $mpdf->output($fileName, 'S'));
        $invoice->url = $fileName;
        $invoice->save();
        $invoice->refresh();
        $message = AppHelper::getMessage($invoice, MessageType::INVOICE_MESSAGE, null, $order->country_id);
        if ($settings->send_link)
            SmsService::sendSMS($order->customer->phone, null, $message . ' ' . $invoice->pdfUrl(), null, $order->country_id);
        else
            SmsService::sendSMS($order->customer->phone, null, $message, null, $order->country_id);
    }

    public function putOrderPoints($order, Setting $setting)
    {
        $calculatePoints = $setting->calculate_points;
        if ($calculatePoints) {
            $orderPoints = $setting->points_per_order;
        } else {
            $pointCount = $setting->point_count;
            $orderPoints = $pointCount * $order->weight;
        }
        if ($orderPoints != null && $orderPoints > 0) {
            Point::create([
                'user_id' => $order->customer_id,
                'country_id' => $order->country_id,
                'order_id' => $order->id,
                'count' => $orderPoints,
                'ends_at' => Carbon::now('UTC')->addDays($setting->point_expire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }
    }

    /**
     * @throws IPinfoException
     */
    public function storeOrderEasyWay($data): JsonResponse
    {
        $data = collect($data);

        $user = User::where('phone', '=', $data->get('phone'))?->first();
        if ($user != null)
            if ($user->type != UserType::CLIENT)
                return $this->response('Your account is not valid', null, null, 403);

        $country_id = $data->get('country_id');
        $userDeleted = User::onlyTrashed()->where('phone', '=', $data->get('phone'))?->first();

        if ($userDeleted != null) {
            $user = $userDeleted;
            $user->restore();
            $user->name = $data->get('name');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
        }

        if ($user == null && $userDeleted == null) {
            $user = new User();
            $user->name = $data->get('name');
            $user->phone = $data->get('phone');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
            //Add points
            $points = Setting::where(['country_id' => $country_id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $country_id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $country_id,
                'count' => $points,
                'ends_at' => Carbon::now('UTC')->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }

        if ($this->checkActiveOrders($user, $data))
            return $this->responseMessage('You already have an active order', 403);

        if (($data->get('lat') == null && $data->get('lng') == null)) {
            $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), Province::whereId($data->get('province_id'))->first(), $data->get('title'));
            $point = new GeometryPoint($latLng['lat'], $latLng['lng']);
        } else
            $point = new GeometryPoint($data->get('lat'), $data->get('lng'));

        $order = new Order();
        $order->country_id = $country_id;
        $order->customer_id = $user->id;
        $order->location = $point;
        $order->type = $data->get('type');
        if ($data->get('type') == OrderType::DONATION)
            $order->association_id = $data->get('association_id');
        $order->status = OrderStatus::CREATED;
        $order->platform = 'Application Without login';

        $autoAssign = Setting::where(['country_id' => $order->country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($autoAssign->auto_assign == 1) {
            $this->orderAutoAssign($order);
        }

        $address = new Address();
        $address->province_id = $data->get('province_id');
        $address->user_id = $user->id;
        $address->country_id = $country_id;
        $address->location_title = $data->get('title');
        $address->location = $point;
        if ($data->has('building'))
            $address->building = $data->get('building');

        if ($data->has('floor_number'))
            $address->floor_number = $data->get('floor_number');

        if ($data->has('apartment_number'))
            $address->apartment_number = $data->get('apartment_number');

        $address->save();
        $address->refresh();

        $order->address_id = $address->id;
        $order->province_id = $address->province_id;
        $order->save();
        $order->refresh();
        if ($data->has('items') && $data->get('items') != null)
            $order->items()->attach($data->get('items'));

        return $this->showOne($order, SimpleOrderResource::class, __('The order added successfully'));
    }

    public static function orderAutoAssign(Order $order)
    {
        // if (self::checkIsDefaultPoints($order->location->getLat())) {
        //     return;
        // }

        $locations = Location::contains('area', new GeometryPoint($order->location->getLat(), $order->location->getLng()))->get();
        $eligibleAgents = new Collection();

        if ($locations->count() > 0) {
            foreach ($locations as $location) {
                foreach ($location->agents as $agent) {
                    if (self::isAgentEligibleAnyDay($agent)) {
                        $eligibleAgents->push($agent);
                    }
                }
            }
        }

        $agentAssign = null;
        $start_task = request()->filled('start_task') ? Carbon::make(request('start_task')) : Carbon::now('UTC');

        $sortedAgents = $eligibleAgents->sortBy(function ($agent) {
            return $agent->agentOrdersCount(Carbon::now('UTC'));
        });

        foreach ($sortedAgents as $agent) {
            if (self::isAgentEligible($agent, Carbon::now('UTC'))) {
                $agentAssign = $agent;
                break;
            }
        }

        if (!$agentAssign) {
            $foundAgent = false;
            for ($daysAhead = 1; $daysAhead <= 6 && !$foundAgent; $daysAhead++) {
                $nextDay = $start_task->copy()->addDays($daysAhead)->startOfDay()->timezone('UTC');
                $sortedAgents = $eligibleAgents->sortBy(function ($agent) use ($nextDay) {
                    return $agent->agentOrdersCount($nextDay);
                });
                foreach ($sortedAgents as $agent) {
                    if (self::isAgentEligibleWithoutTime($agent, $nextDay)) {
                        $agentAssign = $agent;
                        $foundAgent = true;
                        $start_task = $nextDay;
                        break;
                    }
                }
            }
        }

        if ($agentAssign) {
            $order->agent_id = $agentAssign->id;
            $order->start_task = $start_task;
            $order->status = OrderStatus::ASSIGNED;
            $order->save();
            $order->refresh();
        }
    }

    protected static function isAgentEligibleAnyDay($agent): bool
    {
        $agentSettings = $agent->agentSettings;
        if ($agentSettings) {
            return true;
        }

        return false;
    }

    protected static function isAgentEligible($agent, Carbon $date): bool
    {
        $agentSettings = $agent->agentSettings;
        if ($agentSettings) {
            $start_work = Carbon::createFromTimeString($agentSettings->start_work, 'UTC');
            $finish_work = Carbon::createFromTimeString($agentSettings->finish_work, 'UTC');
            $tasks_per_day = $agentSettings->tasks_per_day;
            $holiday = DaysEnum::getKey($agentSettings->holiday);

            return $date->between($start_work, $finish_work)
                && $agent->agentOrdersCount($date) < $tasks_per_day
                && strtoupper($date->dayName) != $holiday;
        }

        return false;
    }

    protected static function isAgentEligibleWithoutTime($agent, Carbon $date): bool
    {
        $agentSettings = $agent->agentSettings;
        if ($agentSettings) {
            $tasks_per_day = $agentSettings->tasks_per_day;
            $holiday = DaysEnum::getKey($agentSettings->holiday);

            return $agent->agentOrdersCount($date) < $tasks_per_day
                && strtoupper($date->dayName) != $holiday;
        }

        return false;
    }

    /**
     * @throws IPinfoException
     */
    public function makeOrderAsThirdParty(Request $request)
    {
        $typeRules = ['required', 'numeric', Rule::in(OrderType::getValues())];

        $associationIdRules = [Rule::exists(Association::class, 'id')];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['association_id'])) {
                $typeRules[] = 'in:' . OrderType::DONATION;
                $associationIdRules[] = 'required';
            }
            if (isset($request['type'])) {
                if ($request['type'] == OrderType::DONATION) {
                    $associationIdRules[] = 'required';
                }
            }
        }
        $validator = Validator::make($request, [
            'name' => ['required', 'max:255'],
            'api_key' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'platform' => ['required', 'max:255'],
            'title' => ['max:255'],
            'items' => [''],
            'items.*' => [Rule::exists(Item::class, 'id')],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'lng' => ['nullable', 'numeric', 'between:-180,180'],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
        ]);
        if ($validator->fails()) {
            return $this->responseForThirdParty('The given data was invalid.', true, $validator->errors(), 422);
        }
        if (!AppHelper::checkIP()) {
            return $this->responseForThirdParty('Your IP invalid.', true, null, 401);
        }
        $data = collect($request);
        $country_id = $data->get('country_id');
        $settings = Setting::where(['country_id' => $country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($settings->secret_key != $data->get('api_key')) {
            return $this->responseForThirdParty('Unauthenticated', true, [
                'api_key' => 'invalid credential',
            ], 401);

        }

        $user = User::where('phone', '=', $data->get('phone'))?->first();
        if ($user != null)
            if ($user->type != UserType::CLIENT)
                return $this->responseForThirdParty('Your account is not valid', true, null, 401);

        $userDeleted = User::onlyTrashed()->where('phone', '=', $data->get('phone'))?->first();

        if ($userDeleted != null) {
            $user = $userDeleted;
            $user->restore();
            $user->name = $data->get('name');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
        }

        if ($user == null && $userDeleted == null) {
            $user = new User();
            $user->name = $data->get('name');
            $user->phone = $data->get('phone');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
            //Add points
            $points = Setting::where(['country_id' => $country_id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $country_id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $country_id,
                'count' => $points,
                'ends_at' => Carbon::now('UTC')->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }
        $activeOrder = $this->checkActiveOrders($user, $data);
        if ($activeOrder) {
            return response()->json([
                'date' => [
                    'start_task_date' => $activeOrder->start_task ? Carbon::createFromDate($activeOrder->start_task)->format('Y-m-d') : null,
                ],
                'message' => 'Your order is already in progress',
                'status_code' => 201,
                'error' => true,
            ]);

        }

        if (($data->get('lat') == null && $data->get('lng') == null)) {
            $province_id = null;
            $title = null;
            $building = null;
            if ($data->has('province_id') && $data->get('province_id') != null)
                $province_id = $data->get('province_id');

            if ($data->has('title') && $data->get('title') != null)
                $title = $data->get('title');

            if ($data->has('building') && $data->get('building') != null)
                $building = $data->get('building');

            if ($province_id != null)
                $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), Province::whereId($province_id)->first(), $title, null, $building);

            else
                $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), null, $title, null, $building);

            $point = new GeometryPoint($latLng['lat'], $latLng['lng']);
        } else
            $point = new GeometryPoint($data->get('lat'), $data->get('lng'));

        $order = new Order();
        $order->country_id = $country_id;
        $order->customer_id = $user->id;
        $order->location = $point;
        $order->type = $data->get('type');
        if ($data->get('type') == OrderType::DONATION)
            $order->association_id = $data->get('association_id');
        $order->status = OrderStatus::CREATED;
        $order->platform = $data->get('platform');

        if ($settings->auto_assign == 1) {
            $this->orderAutoAssign($order);
        }

        $address = new Address();
        $address->user_id = $user->id;
        $address->country_id = $country_id;
        $address->location = $point;
        if ($data->has('building'))
            $address->building = $data->get('building');

        if ($data->has('floor_number'))
            $address->floor_number = $data->get('floor_number');

        if ($data->has('apartment_number'))
            $address->apartment_number = $data->get('apartment_number');

        if ($data->has('province_id') && $data->get('province_id') != null)
            $address->province_id = $data->get('province_id');

        if ($data->has('title') && $data->get('title') != null)
            $address->location_title = $data->get('title');

        $address->save();
        $address->refresh();

        $order->address_id = $address->id;
        if ($address->province_id)
            $order->province_id = $address->province_id;
        $order->save();
        $order->refresh();
        if ($data->has('items') && $data->get('items') != null)
            $order->items()->attach($data->get('items'));

        return $this->responseForThirdParty('The order added successfully', false, [
            'start_task_date' => $order->start_task ? Carbon::createFromDate($order->start_task)->format('Y-m-d') : null,
        ], 200);

    }

    public function makeOrderWhatsapp($data)
    {
        $data = collect($data);
        $country_id = $data->get('country_id');
        $settings = Setting::where(['country_id' => $country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($settings->secret_key != $data->get('api_key')) {
            return $this->response('Unauthenticated', [
                'api_key' => 'invalid credential',
            ], null, '401');
        }

        $user = User::where('phone', '=', $data->get('phone'))?->first();
        if ($user != null)
            if ($user->type != UserType::CLIENT)
                return $this->response('Your account is not valid', null, null, 422);

        $userDeleted = User::onlyTrashed()->where('phone', '=', $data->get('phone'))?->first();

        if ($userDeleted != null) {
            $user = $userDeleted;
            $user->restore();
            $user->name = $data->get('name');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
        }

        if ($user == null && $userDeleted == null) {
            $user = new User();
            $user->name = $data->get('name');
            $user->phone = $data->get('phone');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
            //Add points
            $points = Setting::where(['country_id' => $country_id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $country_id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $country_id,
                'count' => $points,
                'ends_at' => Carbon::now('UTC')->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }
        $activeOrder = $this->checkActiveOrders($user, $data);
        if ($activeOrder) {
            return response()->json([
                'date' => [
                    'start_task_date' => $activeOrder->start_task ? Carbon::createFromDate($activeOrder->start_task)->format('Y-m-d') : null,
                ],
                'message' => 'Your order is already in progress',
                'status_code' => 201,
            ]);

        }

        if (($data->get('lat') == null && $data->get('lng') == null)) {
            $province_id = null;
            $title = null;
            $building = null;
            if ($data->has('province_id') && $data->get('province_id') != null)
                $province_id = $data->get('province_id');

            if ($data->has('title') && $data->get('title') != null)
                $title = $data->get('title');

            if ($data->has('building') && $data->get('building') != null)
                $building = $data->get('building');

            if ($province_id != null)
                $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), Province::whereId($province_id)->first(), $title, null, $building);

            else
                $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), null, $title, null, $building);

            $point = new GeometryPoint($latLng['lat'], $latLng['lng']);
        } else
            $point = new GeometryPoint($data->get('lat'), $data->get('lng'));

        $order = new Order();
        $order->country_id = $country_id;
        $order->customer_id = $user->id;
        $order->location = $point;
        $order->type = $data->get('type');
        if ($data->get('type') == OrderType::DONATION)
            $order->association_id = $data->get('association_id');
        $order->status = OrderStatus::CREATED;
        $order->platform = $data->get('platform');

        if ($settings->auto_assign == 1) {
            $this->orderAutoAssign($order);
        }

        $address = new Address();
        $address->user_id = $user->id;
        $address->country_id = $country_id;
        $address->location = $point;
        if ($data->has('building'))
            $address->building = $data->get('building');

        if ($data->has('floor_number'))
            $address->floor_number = $data->get('floor_number');

        if ($data->has('apartment_number'))
            $address->apartment_number = $data->get('apartment_number');

        if ($data->has('province_id') && $data->get('province_id') != null)
            $address->province_id = $data->get('province_id');

        if ($data->has('title') && $data->get('title') != null)
            $address->location_title = $data->get('title');

        $address->save();
        $address->refresh();

        $order->address_id = $address->id;
        if ($address->province_id)
            $order->province_id = $address->province_id;
        $order->save();
        $order->refresh();
        if ($data->has('items') && $data->get('items') != null)
            $order->items()->attach($data->get('items'));


        return $this->response('The order added successfully', [
            'start_task_date' => $order->start_task ? Carbon::createFromDate($order->start_task)->format('Y-m-d') : null,
        ]);

    }

    public function makeOrderPOS($data)
    {
        $data = collect($data);
        $country_id = $data->get('country_id');
        $settings = Setting::where(['country_id' => $country_id])->first() ??
            Setting::where(['country_id' => null])->first();

        if ($settings->secret_key != $data->get('api_key')) {
            return $this->response('Unauthenticated', [
                'api_key' => 'invalid credential',
            ], null, '401');
        }

        $user = User::where('phone', '=', $data->get('phone'))?->first();
        if ($user != null)
            if ($user->type != UserType::CLIENT)
                return $this->response('Your account is not valid', null, null, 422);

        $userDeleted = User::onlyTrashed()->where('phone', '=', $data->get('phone'))?->first();

        if ($userDeleted != null) {
            $user = $userDeleted;
            $user->restore();
            $user->name = $data->get('name');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
        }

        if ($user == null && $userDeleted == null) {
            $user = new User();
            $user->name = $data->get('name');
            $user->phone = $data->get('phone');
            $user->type = UserType::CLIENT;
            $user->country_id = $country_id;
            $user->save();
            $user->refresh();
            //Add points
            $points = Setting::where(['country_id' => $country_id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $country_id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $country_id,
                'count' => $points,
                'ends_at' => Carbon::now('UTC')->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }

        if (($data->get('lat') == null && $data->get('lng') == null)) {
            $province_id = null;
            $title = null;
            $building = null;
            if ($data->has('province_id') && $data->get('province_id') != null)
                $province_id = $data->get('province_id');

            if ($data->has('title') && $data->get('title') != null)
                $title = $data->get('title');

            if ($data->has('building') && $data->get('building') != null)
                $building = $data->get('building');

            if ($province_id != null)
                $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), Province::whereId($province_id)->first(), $title, null, $building);

            else
                $latLng = AppHelper::getLatLang(Country::whereId($data->get('country_id'))->first(), null, $title, null, $building);

            $point = new GeometryPoint($latLng['lat'], $latLng['lng']);
        } else
            $point = new GeometryPoint($data->get('lat'), $data->get('lng'));

        $order = new Order();
        $order->country_id = $country_id;
        $order->customer_id = $user->id;
        $order->location = $point;
        $order->type = $data->get('type');
        if ($data->get('type') == OrderType::DONATION)
            $order->association_id = $data->get('association_id');
        $order->status = OrderStatus::SUCCESSFUL;
        $order->platform = $data->get('platform');
        $order->agent_id = $data->get('agent_id');
        $order->start_task = Carbon::now('UTC');

        if (isset($data['weight'])) {
            $weight = $data['weight'];
            $order->weight = $weight;
            $order->value = Item::where(["country_id" => $country_id])->first()->price_per_kg * $weight;
            
        }

        $address = new Address();
        $address->user_id = $user->id;
        $address->country_id = $country_id;
        $address->location = $point;
        if ($data->has('building'))
            $address->building = $data->get('building');

        if ($data->has('floor_number'))
            $address->floor_number = $data->get('floor_number');

        if ($data->has('apartment_number'))
            $address->apartment_number = $data->get('apartment_number');

        if ($data->has('province_id') && $data->get('province_id') != null)
            $address->province_id = $data->get('province_id');

        if ($data->has('title') && $data->get('title') != null)
            $address->location_title = $data->get('title');

        $address->save();
        $address->refresh();

        $order->address_id = $address->id;
        if ($address->province_id)
            $order->province_id = $address->province_id;
        $order->save();
        $order->refresh();



        return $this->response('The order added successfully', [
            'start_task_date' => $order->start_task ? Carbon::createFromDate($order->start_task)->format('Y-m-d') : null,
        ]);

    }


    public static function checkActiveOrders(User $user, $data = null)
    {
        if ($user->orders) {
            if($data != null){

                $association_id = null;
                if ($data->get('type') == OrderType::DONATION)
                    $association_id = $data->get('association_id');


                if ($user->orders()->whereNotIn('status',
                    [OrderStatus::SUCCESSFUL, OrderStatus::POSTPONED, OrderStatus::FAILED, OrderStatus::CANCEL, OrderStatus::DECLINE])
                    ->Where('association_id', '=', $association_id)
                    ->count() > 0)
                    return $user->lastActiveOrder();
                else
                    return null;


            }else{

                if ($user->orders()->whereNotIn('status',
                    [OrderStatus::SUCCESSFUL, OrderStatus::POSTPONED, OrderStatus::FAILED, OrderStatus::CANCEL, OrderStatus::DECLINE])
                    ->count() > 0)
                    return $user->lastActiveOrder();
                else
                    return null;

            }
            
        } else
            return null;
    }


    private static function checkIsDefaultPoints($lat) : bool{
        $defaultPoints = ["23.885942","23.6539906","28.3835079","23.511126","26.0667","24.4139634","17.0193843","21.4240968","23.6283501","26.2534919","21.4735329","23.6837432","22.9171031","23.5651914","25.4052165","21.5291545","23.424076","26.2235305","24.2231534","29.3377518","24.453884","21.4947228","21.7507131","23.5451648","24.7135517","23.5690894","22.9510175","26.1163407","29.3481663","29.3407455","23.2968896","16.8893586","29.2815238","21.2840782","24.4672132","23.4963712","21.3865511","25.3561698","29.336821","23.8262343","23.6472396","24.3500672","26.4206828","24.1539162","25.1874594","24.0895265","23.2359238","23.6837375","29.31166","23.6501768","26.1882301","26.2721664","29.083461","23.6042885","25.309694","25.3762145","29.2964866","22.5731722","21.441058","29.1886698","23.5880307","25.2048493","28.7864783","26.3511901","26.2533564","21.5823382","21.6215773","23.6118221","18.3014944","26.1333035","25.3018475","25.1108025","26.4135893","24.8142533","29.3198245","21.7504577","21.3659588","23.4425277","26.9597709","21.5869905","24.8343347","20.012303","25.0390117","21.2169439","26.0303854","26.1262367","23.6487474","24.8245095","25.2888084","23.9628375","25.2892112","29.3138682","25.2048625","23.0026623","24.8935315","21.4872534","29.3360061","21.5399472","29.3457574","22.0177073","17.5656036","25.2919567","24.6915715","25.1815668","21.6207811","25.8006926","29.1081627","24.5673452","26.1679752","21.3512561","21.3091419","21.5680105","29.3042048","25.2004324","21.5202768","21.3968237","26.2340617","26.413333","25.2489204","29.1976045","22.5652759","29.24287","29.3155591","29.2834971","29.1965714","22.9397781","29.2565637","29.2194484","23.5867529","23.9052203","26.4044007","25.1648925","29.2467529","18.2464685","17.374003","24.7426943","23.705627","21.4971886","26.2703091","29.2888091","21.4068296","21.552743","29.3780268","24.56325","24.5903985","23.5972433","21.6247371","25.277877","23.6335368","25.0667134","23.4069561","24.5862113","29.375859","21.3999349","26.1900349","24.795665","23.6540125","16.9692482","21.7010917","25.3254176","22.7244454","22.9329006","24.7235642","24.5793447","24.632546","29.3360948","17.1547981","24.4110398","29.1073197","21.5030122","25.3460323","24.1565732","29.3161237","21.5419918","23.6337057","29.3213802","23.7474253","25.0608609","24.7242467","29.2979895","23.5961146","24.8078798","26.1590446","21.6486364","21.590638","26.212971","21.559386","21.3558709","29.3270885","29.2765468","16.601837","25.2769983","25.21937","25.3063711","29.2160974","29.2706918","22.8453095","21.5994271","29.2457648","29.3278632","25.1124317","25.1250606","23.6297461","25.0423411","29.2707391","29.2839419","21.4469618","21.5917935","29.23358","29.1504085","21.3066826","21.5878556","24.4007296","21.3781329","27.5114102","21.485811","25.5507975","24.8316931","23.5111375","24.80406","29.2966294","24.695087","25.2665492","24.6420998","21.5452335","23.1712774","25.1220701","17.0088708","29.1691087","25.3722137","26.2728212","29.3331469","21.6175234","28.9570473","29.3445143","24.8212117","21.796385","17.0520917","21.5970222","21.6027305","29.3505743","29.1496559","22.7926568","29.201281","26.962111","21.3051336","21.6201722","21.6034959","23.617276","29.3123481","24.6624446","24.9879316","26.1978657","21.7476211","29.1650224","23.6327245","24.7740729","26.1162634","29.3002821","29.2719273","25.377539","26.1427398","21.5628016","29.1686861","24.791759","24.4161075","29.1704692","25.3356646","24.3477563","21.6934988","24.4654555","25.168395","24.3906643","23.7450911","26.182208","23.4987839","24.7994926","21.5297115","24.4775667","25.116073","29.2872877","21.5989009","22.2096469","25.2459667","25.1514047","24.6500984","24.7655999","29.083128","21.6134607","24.778346","25.3025735","25.2493372","21.4038749","23.601299","23.6901106","24.654317","29.2921777","16.8601757","25.3228333","23.4077003","25.1885455","29.2329733","23.6148423","29.1281522","23.5912214","25.083827","21.752522","26.1319222","29.2958138","24.3894512","28.4331058","26.2377981","23.566485","25.0764291","25.3384351","25.0251668","24.828044","22.4428429","25.3843518","23.1025508","29.3408578","29.2842433","25.3770491","24.7315464","25.1810588","25.2749316","25.0605347","25.3915286","21.4022801","25.2793338","21.4108136","25.3283286","29.3302817","29.3155169","25.1859199","21.6176908","29.2728333","29.1830778","26.4036546","23.5748403","29.3061333","29.2725521","23.5981845","21.5384365","24.6091659","25.0518688","21.7528342","26.393687","26.2073004","23.6020489","25.0303125","23.9845482","28.3834978","24.7479649","24.6167455","22.9172674","26.1239003","24.7328046","26.1502768","29.2820387","22.0890702","21.4718277","23.4693144","25.380026","24.466192","22.0158249","26.3689323","22.8075921","25.2244647","24.5115823","24.7599683","25.1633458","22.916342","26.1508132","25.0921185","29.2852067","22.7993261","26.3546512","29.3191122","29.3290126","29.3137752","23.615875","25.347186","25.3491337","23.4617043","21.3390255","25.2791759","26.5764917","23.5844464","26.2171906","23.463285","22.6036569","24.3903088","23.4761556","21.3593569","24.3102986","24.824878","29.1277082","24.5904227","25.3991525","26.2980066","17.1090117","21.6502037","21.5","24.6007001","26.4073754","26.3569437","21.4525508","24.233638","23.6402347","23.4425375","23.2651575","24.5064185","29.2896729","24.5584212","23.3226881","26.3592309","26.090731","29.3366277","21.5211159","21.2014952","25.3112762","25.3641269","29.3544316","31.3296352","29.274976","22.5081615","25.2764596","29.2440334","21.521459","29.1914528","24.4591821","26.1682171","29.2354685","26.0991791","26.1880463","28.4498143","23.5076936","21.403428","23.6310378","17.0322121","29.3493033","26.1955056","21.4573233","21.5046742","21.6129236","24.8165838","26.311422","25.4051051","26.2261928","28.4197362","23.7474375","24.6943752","24.7733469","29.2207571","22.8999771","24.712085","23.6464823","24.23135","24.7581502","26.2113207","23.5267824","24.8620928","23.4984681","21.7972341","25.1790956","24.9837051","29.1946604","25.3885784","24.3333018","25.2491514","29.300635","29.2966301","29.2691488","25.2421813","23.6518693","25.3186829","26.3611705","21.4635131","23.6158231","24.7409561","21.2604574","24.1116423","29.2840205","26.12266","21.4919867","26.3739211","27.0113866","25.288871","21.4901767","16.7111579"];
        
        return in_array($lat, $defaultPoints);
    }
}
