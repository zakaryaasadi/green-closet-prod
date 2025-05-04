<?php

namespace App\Http\API\V1\Controllers\Activity;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Activity\ActivityRepository;
use App\Http\Resources\Activity\ActivityResource;
use App\Http\Resources\Activity\ContainerLogActivityResource;
use App\Http\Resources\Activity\OrderLogActivityResource;
use App\Models\Activity;
use App\Models\Container;
use App\Models\Order;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

/**
 * @group Activity
 * APIs for activity settings
 */
class ActivityController extends Controller
{
    protected ActivityRepository $activityRepository;

    public function __construct(ActivityRepository $activityRepository)
    {
        $this->middleware('auth:sanctum');
        $this->activityRepository = $activityRepository;
        $this->authorizeResource(Activity::class);
    }

    /**
     * Show All Activities
     *
     * This endpoint lets you show all Activities
     *
     * @responseFile storage/responses/admin/activities/index.json
     *
     * @queryParam filter[causer_id] string Field to filter items by all causer id.
     * @queryParam filter[description] string Field to filter items by all description.
     * @queryParam filter[subject_type] string Field to filter items by all subject type.
     * @queryParam sort string Field to sort items by id,causer_id,description.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->activityRepository->index();

        return $this->showAll($paginatedData->getData(), ActivityResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific activity
     *
     * This endpoint lets you show specific activity
     *
     * @responseFile storage/responses/admin/activities/show.json
     *
     * @param Activity $activity
     * @return JsonResponse
     */
    public function show(Activity $activity): JsonResponse
    {
        return $this->showOne($this->activityRepository->show($activity), ActivityResource::class);
    }

    /**
     * Get Order log
     *
     * This endpoint lets you show Order log
     *
     * @param Order $order
     * @return JsonResponse
     *
     * @responseFile storage/responses/admin/activities/order.json
     *
     * @throws AuthorizationException
     */
    public function getOrderLog(Order $order): JsonResponse
    {
        $this->authorize('getOrderLog', Activity::class);

        $paginatedData = $this->activityRepository->getOrderLog($order);

        return $this->showAll($paginatedData->getData(), OrderLogActivityResource::class, $paginatedData->getPagination());
    }

    /**
     * Get Container log
     *
     * This endpoint lets you show Container log
     *
     * @param Container $container
     * @return JsonResponse
     *
     * @responseFile storage/responses/admin/activities/container.json
     *
     * @throws AuthorizationException
     */
    public function getContainerLog(Container $container): JsonResponse
    {
        $this->authorize('getContainerLog', Activity::class);

        $paginatedData = $this->activityRepository->getContainerLog($container);

        return $this->showAll($paginatedData->getData(), ContainerLogActivityResource::class, $paginatedData->getPagination());
    }
}
