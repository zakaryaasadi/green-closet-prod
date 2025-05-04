<?php

namespace App\Http\API\V1\Controllers\Setting;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Setting\SettingRepository;
use App\Http\API\V1\Requests\Setting\StoreSettingRequest;
use App\Http\API\V1\Requests\Setting\UpdateSettingRequest;
use App\Http\Resources\Setting\SettingResource;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Settings
 * APIs for settings
 */
class SettingController extends Controller
{
    protected SettingRepository $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->settingRepository = $settingRepository;
        $this->authorizeResource(Setting::class);
    }

    /**
     * Show all settings
     *
     * This endpoint lets you show all settings
     *
     * @responseFile storage/responses/settings/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[language_id] string Field to filter items by language_id.
     * @queryParam sort string Field to sort items by id, created_at.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->settingRepository->index();

        return $this->showAll($paginatedData->getData(), SettingResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific setting
     *
     * This endpoint lets you show specific setting
     *
     * @responseFile storage/responses/settings/show.json
     *
     * @param Setting $setting
     * @return JsonResponse
     */
    public function show(Setting $setting): JsonResponse
    {
        return $this->showOne($this->settingRepository->show($setting), SettingResource::class);
    }

    /**
     * Add setting
     *
     * This endpoint lets you add setting
     *
     * @responseFile storage/responses/settings/store.json
     *
     * @param StoreSettingRequest $request
     * @return JsonResponse
     */
    public function store(StoreSettingRequest $request): JsonResponse
    {
        $setting = $this->settingRepository->store($request->validated());

        return $this->showOne($setting, SettingResource::class, __('The setting added successfully'));
    }

    /**
     * Update specific setting
     *
     * This endpoint lets you update specific setting
     *
     * @responseFile storage/responses/settings/update.json
     *
     * @param UpdateSettingRequest $request
     * @param Setting $setting
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function update(UpdateSettingRequest $request, Setting $setting): JsonResponse
    {
        $updatedSetting = $this->settingRepository->updateSettings($setting, $request->validated());

        return $this->showOne($updatedSetting, SettingResource::class, __("Setting's information updated successfully"));
    }

    /**
     * Delete specific setting
     *
     * This endpoint lets you delete specific setting
     *
     * @responseFile storage/responses/settings/delete.json
     *
     * @param Setting $setting
     * @return JsonResponse
     */
    public function destroy(Setting $setting): JsonResponse
    {
        $this->settingRepository->delete($setting);

        return $this->responseMessage(__('Setting deleted successfully'));
    }
}
