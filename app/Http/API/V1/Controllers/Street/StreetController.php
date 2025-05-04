<?php

namespace App\Http\API\V1\Controllers\Street;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Street\StreetRepository;
use App\Http\API\V1\Requests\Street\StoreStreetRequest;
use App\Http\API\V1\Requests\Street\UpdateStreetRequest;
use App\Http\Resources\Street\SimpleStreetResource;
use App\Http\Resources\Street\StreetResource;
use App\Models\Street;
use Illuminate\Http\JsonResponse;

/**
 * @group Street
 * APIs for Street settings
 */
class StreetController extends Controller
{
    protected StreetRepository $streetRepository;

    public function __construct(StreetRepository $streetRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->streetRepository = $streetRepository;
        $this->authorizeResource(Street::class);
    }

    /**
     * Show all streets
     *
     * This endpoint lets you show all streets
     *
     * @responseFile storage/responses/streets/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[neighborhood_id] string Field to filter items by neighborhood_id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , neighborhood_id , name.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->streetRepository->index();

        return $this->showAll($paginatedData->getData(), SimpleStreetResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific street
     *
     * This endpoint lets you show specific street
     *
     * @responseFile storage/responses/streets/show.json
     *
     * @param Street $street
     * @return JsonResponse
     */
    public function show(Street $street): JsonResponse
    {
        return $this->showOne($this->streetRepository->show($street), StreetResource::class);
    }

    /**
     * Add street
     *
     * This endpoint lets you add street
     *
     * @responseFile storage/responses/streets/store.json
     *
     * @param StoreStreetRequest $request
     * @return JsonResponse
     */
    public function store(StoreStreetRequest $request): JsonResponse
    {
        $street = $this->streetRepository->store($request->validated());

        return $this->showOne($street, StreetResource::class, __('The Street added successfully'));
    }

    /**
     * Update specific street
     *
     * This endpoint lets you update specific street
     *
     * @responseFile storage/responses/streets/update.json
     *
     * @param UpdateStreetRequest $request
     * @param Street $street
     * @return JsonResponse
     */
    public function update(UpdateStreetRequest $request, Street $street): JsonResponse
    {
        $updatedStreet = $this->streetRepository->updateWithMeta($street, $request->validated());

        return $this->showOne($updatedStreet, StreetResource::class, __("Street's information updated successfully"));
    }

    /**
     * Delete specific street
     *
     * This endpoint lets you delete specific street
     *
     * @responseFile storage/responses/streets/delete.json
     *
     * @param Street $street
     * @return JsonResponse
     */
    public function destroy(Street $street): JsonResponse
    {
        $this->streetRepository->delete($street);

        return $this->responseMessage(__('Street deleted successfully'));
    }
}
