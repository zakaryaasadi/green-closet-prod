<?php

namespace App\Http\API\V1\Controllers\Location;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Location\LocationRepository;
use App\Http\API\V1\Requests\Location\StoreLocationRequest;
use App\Http\API\V1\Requests\Location\UpdateLocationRequest;
use App\Http\Resources\Location\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Location
 * APIs for Location settings
 */
class LocationController extends Controller
{
    protected LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->locationRepository = $locationRepository;
        $this->authorizeResource(Location::class);
    }

    /**
     * Show all locations
     *
     * This endpoint lets you show all locations
     *
     * @responseFile storage/responses/location/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam filter[color] string Field to filter items by color.
     * @queryParam filter[search] string Field to filter items by name.
     * @queryParam filter[team_name] string Field to filter items by team name.
     * @queryParam sort string Field to sort items by id,name,color.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $paginatedData = $this->locationRepository->index();

        return $this->showAll($paginatedData->getData(), LocationResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific location
     *
     * This endpoint lets you show specific location
     *
     * @responseFile storage/responses/location/show.json
     *
     * @param Location $location
     * @return JsonResponse
     */
    public function show(Location $location): JsonResponse
    {
        return $this->showOne($this->locationRepository->show($location), LocationResource::class);
    }

    /**
     * Add location
     *
     * This endpoint lets you add location
     *
     * @responseFile storage/responses/location/store.json
     *
     * @param StoreLocationRequest $request
     * @return JsonResponse
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $location = $this->locationRepository->storeLocation($data);

        return $this->showOne($location, LocationResource::class, __('The location added successfully'));
    }

    /**
     * Update specific location
     *
     * This endpoint lets you update specific location
     *
     * @responseFile storage/responses/location/update.json
     *
     * @param UpdateLocationRequest $request
     * @param Location $location
     * @return JsonResponse
     */
    public function update(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $data = collect($request->validated());
        $locationUpdated = $this->locationRepository->updateLocation($location, $data);

        if ($data->has('province_id')) {
            $locationUpdated->province_id = $data->get('province_id');
            $locationUpdated->save();
            $locationUpdated->fresh();
        }

        return $this->showOne($locationUpdated, LocationResource::class, __("Location's information updated successfully"));
    }

    /**
     * Delete specific location
     *
     * This endpoint lets you delete specific location
     *
     * @responseFile storage/responses/location/delete.json
     *
     * @param Location $location
     * @return JsonResponse
     */
    public function destroy(Location $location): JsonResponse
    {
        $location->agents()->update(['location_id' => null]);
        $this->locationRepository->delete($location);

        return $this->responseMessage(__('Location deleted successfully'));
    }
}
