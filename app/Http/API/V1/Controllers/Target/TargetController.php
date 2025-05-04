<?php

namespace App\Http\API\V1\Controllers\Target;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Target\TargetRepository;
use App\Http\API\V1\Requests\Target\StoreTargetRequest;
use App\Http\API\V1\Requests\Target\UpdateTargetRequest;
use App\Http\Resources\Target\TargetResource;
use App\Models\Target;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Targets
 * APIs for targets
 */
class TargetController extends Controller
{
    protected TargetRepository $targetRepository;

    public function __construct(TargetRepository $targetRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->targetRepository = $targetRepository;
        $this->authorizeResource(Target::class);
    }

    /**
     * Show all targets
     *
     * This endpoint lets you show all targets
     *
     * @responseFile storage/responses/targets/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam sort string Field to sort items by id, created_at.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->targetRepository->index();

        return $this->showAll($paginatedData->getData(), TargetResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific target
     *
     * This endpoint lets you show specific target
     *
     * @responseFile storage/responses/targets/show.json
     *
     * @param Target $target
     * @return JsonResponse
     */
    public function show(Target $target): JsonResponse
    {
        return $this->showOne($this->targetRepository->show($target), TargetResource::class);
    }

    /**
     * Add target
     *
     * This endpoint lets you add target
     *
     * @responseFile storage/responses/targets/store.json
     *
     * @param StoreTargetRequest $request
     * @return JsonResponse
     */
    public function store(StoreTargetRequest $request): JsonResponse
    {
        $setting = $this->targetRepository->store($request->validated());

        return $this->showOne($setting, TargetResource::class, __('The target added successfully'));
    }

    /**
     * Update specific target
     *
     * This endpoint lets you update specific target
     *
     * @responseFile storage/responses/targets/update.json
     *
     * @param UpdateTargetRequest $request
     * @param Target $target
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function update(UpdateTargetRequest $request, Target $target): JsonResponse
    {
        $updatedTarget = $this->targetRepository->update($target, $request->validated());

        return $this->showOne($updatedTarget, TargetResource::class, __("Target's information updated successfully"));
    }

    /**
     * Delete specific target
     *
     * This endpoint lets you delete specific target
     *
     * @responseFile storage/responses/targets/delete.json
     *
     * @param Target $target
     * @return JsonResponse
     */
    public function destroy(Target $target): JsonResponse
    {
        $this->targetRepository->delete($target);

        return $this->responseMessage(__('Target deleted successfully'));
    }
}
