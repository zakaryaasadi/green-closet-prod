<?php

namespace App\Http\API\V1\Controllers\Order;

use App\Exports\OrdersExport;
use App\Helpers\AppHelper;
use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Order\OrderRepository;
use App\Http\API\V1\Requests\Order\AgentOrderCountRequest;
use App\Http\API\V1\Requests\Order\DeleteManyOrderRequest;
use App\Http\API\V1\Requests\Order\MakeOrderAsPOS;
use App\Http\API\V1\Requests\Order\MakeOrderAsThirdPartyRequest;
use App\Http\API\V1\Requests\Order\NearOrderRequest;
use App\Http\API\V1\Requests\Order\Status\MakeOrderAssignedRequest;
use App\Http\API\V1\Requests\Order\Status\MakeOrderCanceledRequest;
use App\Http\API\V1\Requests\Order\Status\MakeOrderSuccessfulRequest;
use App\Http\API\V1\Requests\Order\StoreCustomerHomeOrderRequest;
use App\Http\API\V1\Requests\Order\StoreCustomerOrderRequest;
use App\Http\API\V1\Requests\Order\StoreOrderRequest;
use App\Http\API\V1\Requests\Order\UpdateManyOrderRequest;
use App\Http\API\V1\Requests\Order\UpdateOrderItemsRequest;
use App\Http\API\V1\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\AdminOrderResource;
use App\Http\Resources\Order\AgentOrderResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\SimpleOrderResource;
use App\Models\Order;
use App\Models\Setting;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ipinfo\ipinfo\IPinfoException;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @group Orders
 * APIs for Order settings
 */
class OrderController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('arabicNumbersMiddleware');
        $this->middleware('auth:sanctum')
            ->except([
                'storeOrderEasyWay',
                'makeOrderAsThirdParty',
                'makeOrderWhatsapp',
                'makeOrderPOS',
            ]);
        $this->orderRepository = $orderRepository;
        $this->authorizeResource(Order::class);
    }

    /**
     * Show all orders
     *
     * This endpoint lets you show all orders
     *
     * @responseFile storage/responses/orders/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country id.
     * @queryParam filter[message_id] string Field to filter items by message id.
     * @queryParam filter[association_id] string Field to filter items by association id.
     * @queryParam filter[association_name] string Field to filter items by association name.
     * @queryParam filter[customer_id] string Field to filter items by customer id.
     * @queryParam filter[created_at] string Field to filter items by  created_at.
     * @queryParam filter[start_task] string Field to filter items by  start_task.
     * @queryParam filter[platform] string Field to filter items by  platform.
     * @queryParam filter[customer_name] string Field to filter items by customer name.
     * @queryParam filter[agent_id] string Field to filter items by agent id.
     * @queryParam filter[agent_name] string Field to filter items by agent name.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[date_range] string Field to filter mail messages by date range (format :'Y-m-d ,Y-m-d').
     *
     * @queryParamus filter[search] string Field to filter items by agent name ,customer name ,association name  .
     *
     * @queryParam sort string Field to sort items by id,weight, start_at, created_at ,customer_id ,start_task,agent_id,association_id,platform,preferred_pickup_date,actual_pickup_date.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function index(): JsonResponse
    {

        $paginatedData = $this->orderRepository->index();
        $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();
        $language = AppHelper::getLanguageForMobile();

        AdminOrderResource::setAdditionalData($settings, $language);

        return $this->showAll($paginatedData->getData(), AdminOrderResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all customer order
     *
     * This endpoint lets you show all orders for customer
     *
     * @responseFile storage/responses/orders/customer/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     *
     * @queryParamus filter[search] string Field to filter items by weight ,status ,pickup_date  .
     *
     * @queryParam sort string Field to sort items by id,weight, start_at, created_at.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexCustomerOrder(): JsonResponse
    {
        $paginatedData = $this->orderRepository->indexCustomerOrder();

        return $this->showAll($paginatedData->getData(), SimpleOrderResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all agent order
     *
     * This endpoint lets you show all orders for agent
     *
     * @responseFile storage/responses/orders/agent/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[start_task] string Field to filter items by start_task.
     *
     * @queryParamus filter[search] string Field to filter items by weight ,status ,pickup_date  .
     *
     * @queryParam sort string Field to sort items by id,weight, start_at, created_at,start_task.
     *
     * @param NearOrderRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexAgentOrder(NearOrderRequest $request): JsonResponse
    {
        $paginatedData = $this->orderRepository->indexAgentOrder($request->validated());
        $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();
        $language = AppHelper::getLanguageForMobile();

        AdminOrderResource::setAdditionalData($settings, $language);

        return $this->showAll($paginatedData->getData(), AdminOrderResource::class, $paginatedData->getPagination());
    }

    /**
     * Get agent order count
     *
     * This endpoint lets you Get agent order count
     *
     * @responseFile storage/responses/orders/agent/count.json
     *
     * @param AgentOrderCountRequest $request
     * @return JsonResponse
     */
    public function getAgentOrderCount(AgentOrderCountRequest $request): JsonResponse
    {
        return $this->response('success', $this->orderRepository->getAgentOrderCount($request->validated()));
    }

    /**
     * Show all nearby order for agent
     *
     * This endpoint lets you show all nearby order for agent
     *
     * @responseFile storage/responses/orders/agent/nearby.json
     *
     * @param NearOrderRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexNearbyOrders(NearOrderRequest $request): JsonResponse
    {
        $paginatedData = $this->orderRepository->indexNearbyOrders($request->validated());
        $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();
        $language = AppHelper::getLanguageForMobile();
        AdminOrderResource::setAdditionalData($settings, $language);

        return $this->showAll($paginatedData->getData(), AdminOrderResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific order
     *
     * This endpoint lets you show specific order
     *
     * @responseFile storage/responses/orders/show.json
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return $this->showOne($this->orderRepository->show($order), OrderResource::class);
    }

    /**
     * Show specific order for agent
     *
     * This endpoint lets you show specific order for agent
     *
     * @responseFile storage/responses/orders/agent/show-details.json
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function showAgentOrder(Order $order): JsonResponse
    {
        $this->authorize('showOrderDetailsByDriver', $order);

        return $this->showOne($this->orderRepository->show($order), AgentOrderResource::class);
    }

    /**
     * Show specific customer order
     *
     * This endpoint lets you show customer specific order
     *
     * @responseFile storage/responses/orders/customer/show.json
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function showCustomerOrder(Order $order): JsonResponse
    {
        $this->authorize('showCustomerOrder', $order);

        return $this->showOne($this->orderRepository->show($order), SimpleOrderResource::class);
    }

    /**
     * Show specific agent order
     *
     * This endpoint lets you show customer specific order
     *
     * @responseFile storage/responses/orders/customer/show.json
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function showOrderDetails(Order $order): JsonResponse
    {
        $this->authorize('showOrderDetailsByDriver', $order);

        return $this->showOne($this->orderRepository->show($order), OrderResource::class);
    }

    /**
     * Add order
     *
     * This endpoint lets you add order
     *
     * @responseFile storage/responses/orders/store.json
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $data = collect($request->validated());

        return $this->orderRepository->storeOrder($data);
    }

    /**
     * Add customer order
     *
     * This endpoint lets you add customer order
     *
     * @responseFile storage/responses/orders/storeCustomerOrder.json
     *
     * @param StoreCustomerOrderRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     * @throws AuthorizationException
     */
    public function storeCustomerOrder(StoreCustomerOrderRequest $request): JsonResponse
    {
        $this->authorize('storeCustomerOrder', Order::class);
        if ($this->orderRepository->checkActiveOrders(\Auth::user()))
            return $this->responseMessage('You already have an active order', 403);

        $order = $this->orderRepository->storeCustomerOrder($request->validated());

        return $this->showOne($order, SimpleOrderResource::class, __('The order added successfully'));
    }

    /**
     * Update specific order
     *
     * This endpoint lets you update specific order
     *
     * @responseFile storage/responses/orders/update.json
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $updatedOrder = $this->orderRepository->updateOrder($request->validated(), $order);

        return $this->showOne($updatedOrder, OrderResource::class, __("Order's information updated successfully"));
    }

    /**
     * Update many orders by id's
     *
     * This endpoint lets you update many orders
     *
     * @responseFile storage/responses/orders/many/update.json
     *
     * @param UpdateManyOrderRequest $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws GuzzleException
     */
    public function updateManyOrders(UpdateManyOrderRequest $request): JsonResponse
    {
        $this->authorize('updateManyOrders', Order::class);
        $data = collect($request->validated());
        $this->orderRepository->updateManyOrders($data);

        return $this->responseMessage(__('Orders updated successfully'));
    }

    /**
     * Delete specific order
     *
     * This endpoint lets you delete specific order
     *
     * @responseFile storage/responses/orders/delete.json
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        $this->orderRepository->delete($order);

        return $this->responseMessage(__('Order deleted successfully'));
    }

    /**
     * Delete many orders by id's
     *
     * This endpoint lets you delete many orders by id's
     *
     * @responseFile storage/responses/orders/many/delete.json
     *
     * @param DeleteManyOrderRequest $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function deleteManyOrders(DeleteManyOrderRequest $request): JsonResponse
    {
        $this->authorize('deleteManyOrders', Order::class);
        $data = collect($request->validated());
        $this->orderRepository->deleteManyOrders($data);

        return $this->responseMessage(__('Orders deleted successfully'));
    }

    /**
     * Assigned specific order
     *
     * This endpoint lets you assigned specific order
     *
     * @responseFile storage/responses/orders/status/assigned.json
     *
     * @param MakeOrderAssignedRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function makeOrderAssigned(MakeOrderAssignedRequest $request, Order $order): JsonResponse
    {
        $this->authorize('makeOrderAssigned', $order);
        $deliveringOrder = $this->orderRepository->makeOrderAssigned($order);

        return $this->showOne($deliveringOrder, OrderResource::class, __('Order Assigned to the agent'));
    }

    /**
     * Accept specific order
     *
     * This endpoint lets you Accept specific order
     *
     * @responseFile storage/responses/orders/status/accept.json
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function makeOrderAccepted(Order $order): JsonResponse
    {
        $this->authorize('makeOrderAccepted', $order);
        $acceptOrder = $this->orderRepository->makeOrderAccepted($order);

        return $this->showOne($acceptOrder, OrderResource::class, __('Order accepted'));
    }

    /**
     * Postponed specific order
     *
     * This endpoint lets you Accept specific order
     *
     * @responseFile storage/responses/orders/status/postponed.json
     *
     * @param MakeOrderCanceledRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function makeOrderPostponed(MakeOrderCanceledRequest $request, Order $order): JsonResponse
    {
        $this->authorize('makeOrderPostponed', $order);
        $acceptOrder = $this->orderRepository->makeOrderPostponed($order);

        return $this->showOne($acceptOrder, OrderResource::class, __('Order postponed'));
    }

    /**
     * Declined specific order
     *
     * This endpoint lets you declined specific order
     *
     * @responseFile storage/responses/orders/status/declined.json
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function makeOrderDeclined(Order $order): JsonResponse
    {
        $this->authorize('makeOrderDeclined', $order);
        $declinedOrder = $this->orderRepository->makeOrderDeclined($order);

        return $this->showOne($declinedOrder, OrderResource::class, __('Order declined'));
    }

    /**
     * Cancel specific order
     *
     * This endpoint lets you Cancel specific order
     *
     * @responseFile storage/responses/orders/status/cancel.json
     *
     * @param MakeOrderCanceledRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws GuzzleException
     */
    public function makeOrderCanceled(MakeOrderCanceledRequest $request, Order $order): JsonResponse
    {
        $this->authorize('makeOrderCanceled', $order);
        $declinedOrder = $this->orderRepository->makeOrderCanceled($order);

        return $this->showOne($declinedOrder, OrderResource::class, __('Order Canceled'));
    }

    /**
     * Delivering specific order
     *
     * This endpoint lets you Delivering specific order
     *
     * @responseFile storage/responses/orders/status/delivering.json
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws GuzzleException
     */
    public function makeOrderDelivering(Order $order): JsonResponse
    {
        $this->authorize('makeOrderDelivering', $order);
        $deliveringOrder = $this->orderRepository->makeOrderDelivering($order);

        return $this->showOne($deliveringOrder, OrderResource::class, __('Order delivering'));
    }

    /**
     * Failed specific order
     *
     * This endpoint lets you failed specific order
     *
     * @responseFile storage/responses/orders/status/failed.json
     *
     * @param MakeOrderCanceledRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws GuzzleException
     */
    public function makeOrderFailed(MakeOrderCanceledRequest $request, Order $order): JsonResponse
    {
        $this->authorize('makeOrderFailed', $order);
        $deliveringOrder = $this->orderRepository->makeOrderFailed($order);

        return $this->showOne($deliveringOrder, OrderResource::class, __('Order failed'));
    }

    /**
     * Successful specific order
     *
     * This endpoint lets you failed specific order
     *
     * @responseFile storage/responses/orders/status/successful.json
     *
     * @param MakeOrderSuccessfulRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function makeOrderSuccessful(MakeOrderSuccessfulRequest $request, Order $order): JsonResponse
    {
        $this->authorize('makeOrderSuccessful', $order);
        $deliveringOrder = $this->orderRepository->makeOrderSuccessful($order);

        return $this->showOne($deliveringOrder, OrderResource::class, __('Order Successful'));
    }

    /**
     * Get Pdf Report For Orders
     *
     * This endpoint lets you show pdf report for orders
     *
     * @queryParam filter[country_id] string Field to filter items by country id.
     * @queryParam filter[association_id] string Field to filter items by association id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[agent_name] string Field to filter items by agent name.
     * @queryParam filter[agent_id] string Field to filter items by agent id.
     * @queryParam filter[customer_id] string Field to filter items by customer id.
     * @queryParam filter[customer_name] string Field to filter items by customer name.
     * @queryParam filter[date_range] string Field to filter mail messages by date range (format :'Y-m-d ,Y-m-d').
     *
     * @throws AuthorizationException|\Mpdf\MpdfException
     */
    public function getPdfReport(): ?string
    {
        $this->authorize('getOrdersReport', Order::class);
        $data = $this->orderRepository->getPdfReport();

        return $this->orderRepository->generatePdf($data);
    }

    /**
     * Get Excel Report For Orders
     *
     * This endpoint lets you show excel report for orders
     *
     * @queryParam filter[country_id] string Field to filter items by country id.
     * @queryParam filter[association_id] string Field to filter items by association id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[agent_name] string Field to filter items by agent name.
     * @queryParam filter[agent_id] string Field to filter items by agent id.
     * @queryParam filter[customer_id] string Field to filter items by customer id.
     * @queryParam filter[customer_name] string Field to filter items by customer name.
     * @queryParam filter[date_range] string Field to filter mail messages by date range (format :'Y-m-d ,Y-m-d').
     *
     * @return BinaryFileResponse
     *
     * @throws AuthorizationException
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcel(): BinaryFileResponse
    {
        $this->authorize('getOrdersReport', Order::class);

        return Excel::download(new OrdersExport($this->orderRepository),
            'orders.xlsx');

    }

    /**
     * @throws \Exception
     */
    public function generateInvoice(Order $order)
    {
        $this->orderRepository->generateInvoice($order);
    }

    /**
     * update order items
     *
     * This endpoint lets you update order items
     *
     * @responseFile storage/responses/orders/update-items.json
     *
     * @param UpdateOrderItemsRequest $request
     * @param Order $order
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function updateOrderItems(UpdateOrderItemsRequest $request, Order $order): JsonResponse
    {
        $this->authorize('updateOrderItems', $order);

        return $this->orderRepository->updateOrderItems($order, $request->validated());
    }

    /**
     * Store customer order easy
     *
     * This endpoint lets you store customer order easy
     *
     * @responseFile storage/responses/orders/client-easy.json
     *
     * @param StoreCustomerHomeOrderRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function storeOrderEasyWay(StoreCustomerHomeOrderRequest $request): JsonResponse
    {
        return $this->orderRepository->storeOrderEasyWay($request->validated());
    }

    /**
     * make Order as third party
     *
     * This endpoint lets you make Order as third party
     *
     * @responseFile storage/responses/orders/third-party.json
     *
     * @param MakeOrderAsThirdPartyRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function makeOrderAsThirdParty(Request $request): JsonResponse
    {
        return $this->orderRepository->makeOrderAsThirdParty($request);
    }

    /**
     * make Order as third party form whatsapp
     *
     * This endpoint lets you make Order as third party form whatsapp
     *
     * @responseFile storage/responses/orders/third-party-whatsapp.json
     *
     * @param MakeOrderAsThirdPartyRequest $request
     * @return JsonResponse
     */
    public function makeOrderWhatsapp(MakeOrderAsThirdPartyRequest $request): JsonResponse
    {
        return $this->orderRepository->makeOrderWhatsapp($request->validated());
    }

        /**
     * make Order as third party form POS
     *
     * This endpoint lets you make Order as third party form POS
     *
     * @responseFile storage/responses/orders/third-party-pos.json
     *
     * @param MakeOrderAsPOS $request
     * @return JsonResponse
     */
    public function makeOrderPOS(MakeOrderAsPOS $request): JsonResponse
    {
        return $this->orderRepository->makeOrderPOS($request->validated());
    }
}
