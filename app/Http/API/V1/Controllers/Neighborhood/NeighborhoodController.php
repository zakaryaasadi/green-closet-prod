<?php

namespace App\Http\API\V1\Controllers\Neighborhood;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Neighborhood\NeighborhoodRepository;
use App\Http\API\V1\Requests\Neighborhood\StoreNeighborhoodRequest;
use App\Http\API\V1\Requests\Neighborhood\UpdateNeighborhoodRequest;
use App\Http\Resources\Neighborhood\NeighborhoodResource;
use App\Http\Resources\Neighborhood\SimpleNeighborhoodResource;
use App\Models\Neighborhood;
use Illuminate\Http\JsonResponse;

/**
 * @group Neighborhood
 * APIs for Neighborhood settings
 */
class NeighborhoodController extends Controller
{
    protected NeighborhoodRepository $neighborhoodRepository;

    public function __construct(NeighborhoodRepository $neighborhoodRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->neighborhoodRepository = $neighborhoodRepository;
        $this->authorizeResource(Neighborhood::class);
    }

    /**
     * Show all neighborhoods
     *
     * This endpoint lets you show all neighborhoods
     *
     * @responseFile storage/responses/neighborhoods/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[district_id] string Field to filter items by district_id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , district_id , name.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->neighborhoodRepository->index();

        return $this->showAll($paginatedData->getData(), SimpleNeighborhoodResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific neighborhood
     *
     * This endpoint lets you show specific neighborhood
     *
     * @responseFile storage/responses/neighborhoods/show.json
     *
     * @param Neighborhood $neighborhood
     * @return JsonResponse
     */
    public function show(Neighborhood $neighborhood): JsonResponse
    {
        return $this->showOne($this->neighborhoodRepository->show($neighborhood), NeighborhoodResource::class);
    }

    /**
     * Add neighborhood
     *
     * This endpoint lets you add neighborhoods
     *
     * @responseFile storage/responses/neighborhoods/store.json
     *
     * @param StoreNeighborhoodRequest $request
     * @return JsonResponse
     */
    public function store(StoreNeighborhoodRequest $request): JsonResponse
    {
        $neighborhood = $this->neighborhoodRepository->store($request->validated());

        return $this->showOne($neighborhood, NeighborhoodResource::class, __('The Neighborhood added successfully'));
    }

    /**
     * Update specific neighborhood
     *
     * This endpoint lets you update specific neighborhood
     *
     * @responseFile storage/responses/neighborhoods/update.json
     *
     * @param UpdateNeighborhoodRequest $request
     * @param Neighborhood $neighborhood
     * @return JsonResponse
     */
    public function update(UpdateNeighborhoodRequest $request, Neighborhood $neighborhood): JsonResponse
    {
        $updatedNeighborhood = $this->neighborhoodRepository->updateWithMeta($neighborhood, $request->validated());

        return $this->showOne($updatedNeighborhood, NeighborhoodResource::class, __("Neighborhood's information updated successfully"));
    }

    /**
     * Delete specific neighborhood
     *
     * This endpoint lets you delete specific neighborhood
     *
     * @responseFile storage/responses/neighborhoods/delete.json
     *
     * @param Neighborhood $neighborhood
     * @return JsonResponse
     */
    public function destroy(Neighborhood $neighborhood): JsonResponse
    {
        $this->neighborhoodRepository->delete($neighborhood);

        return $this->responseMessage(__('Neighborhood deleted successfully'));
    }
}
