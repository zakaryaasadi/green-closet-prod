<?php

namespace App\Http\API\V1\Controllers\LocationSettings;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\LocationSettings\LocationSettingsRepository;
use App\Http\API\V1\Requests\LocationSettings\StoreLocationSettingsRequest;
use App\Http\API\V1\Requests\LocationSettings\UpdateLocationSettingsRequest;
use App\Http\Resources\LocationSettings\LocationSettingsResource;
use App\Models\LocationSettings;
use Illuminate\Http\JsonResponse;

/**
 * @group Location Setting
 * APIs for Location Setting
 */
class LocationSettingsController extends Controller
{
    public function __construct(private LocationSettingsRepository $locationSettingsRepository)
    {
        $this->middleware(['auth:sanctum']);

        $this->authorizeResource(LocationSettings::class, 'location_setting');
    }

    /**
     * Show all Location Setting
     *
     * This endpoint lets you show all Location Setting
     *
     * @responseFile storage/responses/location-settings/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[language_id] string Field to filter items by language_id.
     * @queryParam sort string Field to sort items by id.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->locationSettingsRepository->index();

        return $this->showAll($paginatedData->getData(), LocationSettingsResource::class, $paginatedData->getPagination());
    }

    /**
     * Add Location Setting
     *
     * This endpoint lets you add Location Settings
     *
     * @responseFile storage/responses/location-settings/store.json
     *
     * @param StoreLocationSettingsRequest $request
     * @return JsonResponse
     */
    public function store(StoreLocationSettingsRequest $request): JsonResponse
    {
        $locationSetting = $this->locationSettingsRepository->store($request->validated());

        return $this->showOne($locationSetting, LocationSettingsResource::class, __('The location settings added successfully'));

    }

    /**
     * Show specific Location Settings
     *
     * This endpoint lets you show specific Location Settings
     *
     * @responseFile storage/responses/location-settings/show.json
     *
     * @param LocationSettings $locationSetting
     * @return JsonResponse
     */
    public function show(LocationSettings $locationSetting): JsonResponse
    {
        return $this->showOne($this->locationSettingsRepository->show($locationSetting), LocationSettingsResource::class);
    }

    /**
     * Update specific Location Settings
     *
     * This endpoint lets you update specific Location Settings
     *
     * @responseFile storage/responses/location-settings/update.json
     *
     * @param UpdateLocationSettingsRequest $request
     * @param LocationSettings $locationSetting
     * @return JsonResponse
     */
    public function update(UpdateLocationSettingsRequest $request, LocationSettings $locationSetting): JsonResponse
    {
        $locationSettingUpdated = $this->locationSettingsRepository->update($locationSetting, $request->validated());

        return $this->showOne($locationSettingUpdated, LocationSettingsResource::class, __("Location Setting's information updated successfully"));
    }

    /**
     * Delete specific Location Setting
     *
     * This endpoint lets you delete specific Location Setting
     *
     * @responseFile storage/responses/location-settings/delete.json
     *
     * @param LocationSettings $locationSettings
     * @return JsonResponse
     */
    public function destroy(LocationSettings $locationSetting): JsonResponse
    {
        $this->locationSettingsRepository->delete($locationSetting);

        return $this->responseMessage(__('Location settings deleted successfully'));
    }
}
