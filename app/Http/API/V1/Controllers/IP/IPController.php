<?php

namespace App\Http\API\V1\Controllers\IP;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\IP\IPRepository;
use App\Http\API\V1\Requests\IP\StoreIpRequest;
use App\Http\API\V1\Requests\IP\UpdateIpRequest;
use App\Http\Resources\IP\SimpleIPResource;
use App\Models\IP;
use Illuminate\Http\JsonResponse;

/**
 * @group IPs
 * APIs for ips
 */
class IPController extends Controller
{
    protected IPRepository $IPRepository;

    public function __construct(IPRepository $IPRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->IPRepository = $IPRepository;
        $this->authorizeResource(IP::class, 'ip');
    }

    /**
     * Show all Ips
     *
     * This endpoint lets you show all Ips
     *
     * @responseFile storage/responses/ips/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam sort string Field to sort items by id, created_at.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->IPRepository->index();

        return $this->showAll($paginatedData->getData(), SimpleIPResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific ip
     *
     * This endpoint lets you show specific ip
     *
     * @responseFile storage/responses/ips/show.json
     *
     * @param IP $ip
     * @return JsonResponse
     */
    public function show(IP $ip): JsonResponse
    {
        return $this->showOne($this->IPRepository->show($ip), SimpleIPResource::class);
    }

    /**
     * Add Ip
     *
     * This endpoint lets you add Ip
     *
     * @responseFile storage/responses/ips/store.json
     *
     * @param StoreIpRequest $request
     * @return JsonResponse
     */
    public function store(StoreIpRequest $request): JsonResponse
    {
        $ip = $this->IPRepository->store($request->validated());

        return $this->showOne($ip, SimpleIPResource::class, __('The ip added successfully'));
    }

    /**
     * Update specific ip
     *
     * This endpoint lets you update specific ip
     *
     * @responseFile storage/responses/ips/update.json
     *
     * @param UpdateIpRequest $request
     * @param IP $ip
     * @return JsonResponse
     */
    public function update(UpdateIpRequest $request, IP $ip): JsonResponse
    {
        $updatedSetting = $this->IPRepository->update($ip, $request->validated());

        return $this->showOne($updatedSetting, SimpleIPResource::class, __('Ip information updated successfully'));
    }

    /**
     * Delete specific ip
     *
     * This endpoint lets you delete specific ip
     *
     * @responseFile storage/responses/ips/delete.json
     *
     * @param IP $ip
     * @return JsonResponse
     */
    public function destroy(IP $ip): JsonResponse
    {
        $this->IPRepository->delete($ip);

        return $this->responseMessage(__('Ip deleted successfully'));
    }
}
