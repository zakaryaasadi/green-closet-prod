<?php

namespace App\Http\API\V1\Controllers\Province;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Province\ProvinceRepository;
use App\Http\API\V1\Requests\Province\StoreProvinceRequest;
use App\Http\API\V1\Requests\Province\UpdateProvinceRequest;
use App\Http\Resources\Province\ProvinceResource;
use App\Http\Resources\Province\SimpleProvinceResource;
use App\Models\Province;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Province
 * APIs for Province settings
 */
class ProvinceController extends Controller
{
    protected ProvinceRepository $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->middleware(['auth:sanctum'])->except([
            'getProvincesForClient',
        ]);
        $this->provinceRepository = $provinceRepository;
        $this->authorizeResource(Province::class);
    }

    /**
     * Show all provinces
     *
     * This endpoint lets you show all provinces
     *
     * @responseFile storage/responses/provinces/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , country_id , name.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->provinceRepository->index();

        return $this->showAll($paginatedData->getData(), SimpleProvinceResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all provinces for client
     *
     * This endpoint lets you show all provinces for client
     *
     * @responseFile storage/responses/provinces/index-client.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , country_id , name.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function getProvincesForClient(): JsonResponse
    {
        $paginatedData = $this->provinceRepository->indexProvincesForClient();

        return $this->showAll($paginatedData->getData(), SimpleProvinceResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific province
     *
     * This endpoint lets you show specific province
     *
     * @responseFile storage/responses/provinces/show.json
     *
     * @param Province $province
     * @return JsonResponse
     */
    public function show(Province $province): JsonResponse
    {
        return $this->showOne($this->provinceRepository->show($province), ProvinceResource::class);
    }

    /**
     * Add province
     *
     * This endpoint lets you add province
     *
     * @responseFile storage/responses/provinces/store.json
     *
     * @param StoreProvinceRequest $request
     * @return JsonResponse
     */
    public function store(StoreProvinceRequest $request): JsonResponse
    {
        $province = $this->provinceRepository->store($request->validated());

        return $this->showOne($province, ProvinceResource::class, __('The Province added successfully'));
    }

    /**
     * Update specific province
     *
     * This endpoint lets you update specific province
     *
     * @responseFile storage/responses/provinces/update.json
     *
     * @param UpdateProvinceRequest $request
     * @param Province $province
     * @return JsonResponse
     */
    public function update(UpdateProvinceRequest $request, Province $province): JsonResponse
    {
        $updatedProvince = $this->provinceRepository->updateWithMeta($province, $request->validated());

        return $this->showOne($updatedProvince, ProvinceResource::class, __("Province's information updated successfully"));
    }

    /**
     * Delete specific province
     *
     * This endpoint lets you delete specific province
     *
     * @responseFile storage/responses/provinces/delete.json
     *
     * @param Province $province
     * @return JsonResponse
     */
    public function destroy(Province $province): JsonResponse
    {
        $this->provinceRepository->delete($province);

        return $this->responseMessage(__('Province deleted successfully'));
    }
}
