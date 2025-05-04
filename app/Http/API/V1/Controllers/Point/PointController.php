<?php

namespace App\Http\API\V1\Controllers\Point;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Point\PointRepository;
use App\Http\API\V1\Requests\Point\StorePointRequest;
use App\Http\API\V1\Requests\Point\UpdatePointRequest;
use App\Http\Resources\Point\PointResource;
use App\Http\Resources\Point\SimplePointResource;
use App\Models\Point;
use Illuminate\Http\JsonResponse;

/**
 * @group Points
 * APIs for Point settings
 */
class PointController extends Controller
{
    protected PointRepository $pointRepository;

    public function __construct(PointRepository $pointRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->pointRepository = $pointRepository;
        $this->authorizeResource(Point::class);
    }

    /**
     * Show all users points
     *
     * This endpoint lets you show all points
     *
     * @responseFile storage/responses/points/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[user_id] string Field to filter items by user_id.
     * @queryParam filter[order_id] string Field to filter items by order_id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam sort string Field to sort items by id , count , ends_at.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->pointRepository->index();

        return $this->showAll($paginatedData->getData(), PointResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all customer points
     *
     * This endpoint lets you show all customer points
     *
     * @responseFile storage/responses/points/customer/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[order_id] string Field to filter items by order_id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[used] string Field to filter items by status.
     * @queryParam filter[ends_at] string Field to filter items by ends at.
     * @queryParam sort string Field to sort items by id , count , ends_at.
     *
     * @return JsonResponse
     */
    public function indexCustomerPoints(): JsonResponse
    {
        $paginatedData = $this->pointRepository->indexCustomerPoints();

        return $this->showAll($paginatedData->getData(), SimplePointResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific point
     *
     * This endpoint lets you show specific point
     *
     * @responseFile storage/responses/points/show.json
     *
     * @param Point $point
     * @return JsonResponse
     */
    public function show(Point $point): JsonResponse
    {
        return $this->showOne($this->pointRepository->show($point), PointResource::class);
    }

    /**
     * Add point
     *
     * This endpoint lets you add point
     *
     * @responseFile storage/responses/points/store.json
     *
     * @param StorePointRequest $request
     * @return JsonResponse
     */
    public function store(StorePointRequest $request): JsonResponse
    {
        $point = $this->pointRepository->storePoint($request->validated());

        return $this->showOne($point, PointResource::class, __('The Point added successfully'));
    }

    /**
     * Update specific point
     *
     * This endpoint lets you update specific point
     *
     * @responseFile storage/responses/points/update.json
     *
     * @param UpdatePointRequest $request
     * @param Point $point
     * @return JsonResponse
     */
    public function update(UpdatePointRequest $request, Point $point): JsonResponse
    {
        $updatedPoint = $this->pointRepository->update($point, $request->validated());

        return $this->showOne($updatedPoint, PointResource::class, __("Point's information updated successfully"));
    }

    /**
     * Delete specific point
     *
     * This endpoint lets you delete specific order
     *
     * @responseFile storage/responses/points/delete.json
     *
     * @param Point $point
     * @return JsonResponse
     */
    public function destroy(Point $point): JsonResponse
    {
        $this->pointRepository->delete($point);

        return $this->responseMessage(__('Point deleted successfully'));
    }

    /**
     * Get last Active point for client
     *
     * This endpoint lets you Get last Active point for client
     *
     * @responseFile storage/responses/points/customer/last.json
     *
     * @return JsonResponse
     */
    public function getLastActivePoint(): JsonResponse
    {
        $lastPoint = $this->pointRepository->getLastActivePoint();

        return $this->response('success', $lastPoint);
    }
}
