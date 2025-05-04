<?php

namespace App\Http\API\V1\Controllers\District;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\District\DistrictRepository;
use App\Http\API\V1\Requests\District\StoreDistrictRequest;
use App\Http\API\V1\Requests\District\UpdateDistrictRequest;
use App\Http\Resources\District\DistrictResource;
use App\Http\Resources\District\SimpleDistrictResource;
use App\Models\District;
use Illuminate\Http\JsonResponse;

/**
 * @group District
 * APIs for District settings
 */
class DistrictController extends Controller
{
    protected DistrictRepository $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->districtRepository = $districtRepository;
        $this->authorizeResource(District::class);
    }

    /**
     * Show all districts
     *
     * This endpoint lets you show all districts
     *
     * @responseFile storage/responses/districts/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[province_id] string Field to filter items by province_id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[name] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , province_id , name.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->districtRepository->index();

        return $this->showAll($paginatedData->getData(), SimpleDistrictResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific district
     *
     * This endpoint lets you show specific district
     *
     * @responseFile storage/responses/districts/show.json
     *
     * @param District $district
     * @return JsonResponse
     */
    public function show(District $district): JsonResponse
    {
        return $this->showOne($this->districtRepository->show($district), DistrictResource::class);
    }

    /**
     * Add district
     *
     * This endpoint lets you add district
     *
     * @responseFile storage/responses/districts/store.json
     *
     * @param StoreDistrictRequest $request
     * @return JsonResponse
     */
    public function store(StoreDistrictRequest $request): JsonResponse
    {
        $district = $this->districtRepository->store($request->validated());

        return $this->showOne($district, DistrictResource::class, __('The District added successfully'));
    }

    /**
     * Update specific district
     *
     * This endpoint lets you update specific district
     *
     * @responseFile storage/responses/districts/update.json
     *
     * @param UpdateDistrictRequest $request
     * @param District $district
     * @return JsonResponse
     */
    public function update(UpdateDistrictRequest $request, District $district): JsonResponse
    {
        $updatedDistrict = $this->districtRepository->updateWithMeta($district, $request->validated());

        return $this->showOne($updatedDistrict, DistrictResource::class, __("District's information updated successfully"));
    }

    /**
     * Delete specific district
     *
     * This endpoint lets you delete specific district
     *
     * @responseFile storage/responses/districts/delete.json
     *
     * @param District $district
     * @return JsonResponse
     */
    public function destroy(District $district): JsonResponse
    {
        $this->districtRepository->delete($district);

        return $this->responseMessage(__('District deleted successfully'));
    }
}
