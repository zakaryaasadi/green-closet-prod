<?php

namespace App\Http\API\V1\Controllers\Container;

use App\Exports\ContainersExport;
use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Container\ContainerRepository;
use App\Http\API\V1\Requests\Container\StoreContainerRequest;
use App\Http\API\V1\Requests\Container\UpdateContainerRequest;
use App\Http\API\V1\Requests\ContainerDetails\GetContainerDetailsRequest;
use App\Http\API\V1\Requests\ContainerDetails\StoreAdminContainerDetailsRequest;
use App\Http\API\V1\Requests\ContainerDetails\StoreAgentContainerDetailsRequest;
use App\Http\API\V1\Requests\ContainerDetails\UpdateContainerDetailsRequest;
use App\Http\API\V1\Requests\Order\NearOrderRequest;
use App\Http\Resources\Container\ContainerResource;
use App\Http\Resources\Container\SimpleContainerResource;
use App\Http\Resources\ContainerDetails\ContainerDetailsResource;
use App\Models\Container;
use App\Models\ContainerDetails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\MpdfException;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @group Container
 * APIs for container settings
 */
class ContainerController extends Controller
{
    protected ContainerRepository $containerRepository;

    public function __construct(ContainerRepository $containerRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->containerRepository = $containerRepository;
        $this->authorizeResource(Container::class);
    }

    /**
     * Show all container
     *
     * This endpoint lets you show all container
     *
     * @responseFile storage/responses/containers/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[association_id] string Field to filter items by association_id.
     * @queryParam filter[association_name] string Field to filter items by association_name.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[province_id] string Field to filter items by province_id.
     * @queryParam filter[province_name] string Field to filter items by province_name.
     * @queryParam filter[district_id] string Field to filter items by district_id.
     * @queryParam filter[district_name] string Field to filter items by district_name.
     * @queryParam filter[neighborhood_id] string Field to filter items by neighborhood_id.
     * @queryParam filter[neighborhood_name] string Field to filter items by neighborhood_name.
     * @queryParam filter[street_id] string Field to filter items by street_id.
     * @queryParam filter[street_name] string Field to filter items by street_name.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[team_id] string Field to filter items by team_id.
     * @queryParam filter[team_name] string Field to filter items by team_name.
     * @queryParam filter[code] string Field to filter items by code.
     * @queryParam filter[search] string Field to filter items by association title ,team name ,province name ,district name ,neighborhood name ,street name.
     * @queryParam sort string Field to sort items by id, code.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->containerRepository->index();

        return $this->showAll($paginatedData->getData(), ContainerResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all agent container
     *
     * This endpoint lets you show all agent container
     *
     * @responseFile storage/responses/containers/agent/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[association_id] string Field to filter items by association_id.
     * @queryParam filter[code] string Field to filter items by code.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam sort string Field to sort items by id, association_id, code.
     *
     * @param NearOrderRequest $request
     * @return JsonResponse
     */
    public function indexAgentContainers(NearOrderRequest $request): JsonResponse
    {
        $paginatedData = $this->containerRepository->indexAgentContainers($request->validated());

        return $this->showAll($paginatedData->getData(), SimpleContainerResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all nearby containers for agent
     *
     * This endpoint lets you show all nearby containers for agent
     *
     * @responseFile storage/responses/containers/agent/nearby.json
     *
     * @param NearOrderRequest $request
     * @return JsonResponse
     */
    public function indexNearbyContainers(NearOrderRequest $request): JsonResponse
    {
        return $this->response('success', $this->containerRepository->indexNearbyContainers($request->validated()));
    }

    /**
     * Show specific container
     *
     * This endpoint lets you show specific container
     *
     *
     * @responseFile storage/responses/containers/show.json
     *
     * @param Container $container
     * @return JsonResponse
     */
    public function show(Container $container): JsonResponse
    {
        return $this->showOne($this->containerRepository->show($container), ContainerResource::class);
    }

    /**
     * Show specific container for agent
     *
     * This endpoint lets you show specific container for agent
     *
     * @responseFile storage/responses/containers/agent/show.json
     *
     * @param Container $container
     * @return JsonResponse
     */
    public function showAgentContainer(Container $container): JsonResponse
    {
        return $this->showOne($this->containerRepository->show($container), SimpleContainerResource::class);
    }

    /**
     * Add container
     *
     * This endpoint lets you add container
     *
     * @responseFile storage/responses/containers/store.json
     *
     * @param StoreContainerRequest $request
     * @return JsonResponse
     */
    public function store(StoreContainerRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $container = $this->containerRepository->storeContainer($data);

        return $this->showOne($container, ContainerResource::class, __('The container added successfully'));
    }

    /**
     * Update specific container
     *
     * This endpoint lets you update specific container
     *
     * @responseFile storage/responses/containers/update.json
     *
     * @param UpdateContainerRequest $request
     * @param Container $container
     * @return JsonResponse
     */
    public function update(UpdateContainerRequest $request, Container $container): JsonResponse
    {
        $data = collect($request->validated());
        $containerUpdate = $this->containerRepository->updateContainer($container, $data);

        return $this->showOne($containerUpdate, ContainerResource::class, __("Container's information updated successfully"));
    }

    /**
     * Delete specific container
     *
     * This endpoint lets you delete specific container
     *
     * @responseFile storage/responses/containers/delete.json
     *
     * @param Container $container
     * @return JsonResponse
     */
    public function destroy(Container $container): JsonResponse
    {
        $this->containerRepository->delete($container);

        return $this->responseMessage(__('Container deleted successfully'));
    }

    /**
     * Add container details by agent
     *
     * This endpoint lets you add container details by agent
     *
     * @responseFile storage/responses/containers/agent/details.json
     *
     * @param StoreAgentContainerDetailsRequest $request
     * @return JsonResponse
     */
    public function storeContainerDetails(StoreAgentContainerDetailsRequest $request): JsonResponse
    {
        $containerDetails = $this->containerRepository->storeContainerDetails($request->validated());

        return $this->showOne($containerDetails, ContainerDetailsResource::class, __("Container's Details added successfully"));
    }

        /**
     * Add container details by admin
     *
     * This endpoint lets you add container details by admin
     *
     * @responseFile storage/responses/containers/admin/details.json
     *
     * @param StoreAdminContainerDetailsRequest $request
     * @return JsonResponse
     */
    public function storeContainerDetailsByAdmin(StoreAdminContainerDetailsRequest $request): JsonResponse
    {
        $containerDetails = $this->containerRepository->storeContainerDetails($request->validated(), false);

        return $this->showOne($containerDetails, ContainerDetailsResource::class, __("Container's Details added successfully"));
    }

    /**
     * Get Pdf Report For Containers
     *
     * This endpoint lets you show pdf report for Containers
     *
     * @queryParam filter[association_id] string Field to filter items by association_id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[province_id] string Field to filter items by province_id.
     * @queryParam filter[district_id] string Field to filter items by district_id.
     * @queryParam filter[neighborhood_id] string Field to filter items by neighborhood_id.
     * @queryParam filter[street_id] string Field to filter items by street_id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[discharge_shift] string Field to filter items by discharge_shift.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[team_id] string Field to filter items by team_id.
     *
     * @throws AuthorizationException
     * @throws MpdfException
     */
    public function getPdfReport(): ?string
    {
        $this->authorize('getContainersReport', Container::class);
        $data = $this->containerRepository->getPdfReport();

        return $this->containerRepository->generatePdf($data);
    }

    /**
     * Get Excel Report For Containers
     *
     * This endpoint lets you show excel report for Containers
     *
     * @queryParam filter[association_id] string Field to filter items by association_id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[province_id] string Field to filter items by province_id.
     * @queryParam filter[district_id] string Field to filter items by district_id.
     * @queryParam filter[neighborhood_id] string Field to filter items by neighborhood_id.
     * @queryParam filter[street_id] string Field to filter items by street_id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[discharge_shift] string Field to filter items by discharge_shift.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[team_id] string Field to filter items by team_id.
     *
     * @return BinaryFileResponse
     *
     * @throws AuthorizationException
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcel(): BinaryFileResponse
    {
        $this->authorize('getContainersReport', Container::class);

        return Excel::download(new ContainersExport($this->containerRepository),
            'containers.xlsx');

    }

    /**
     * Show details for container
     *
     * This endpoint lets you show details for container
     *
     *
     * @responseFile storage/responses/containers/show-details.json
     *
     * @param GetContainerDetailsRequest $request
     * @param Container $container
     * @return JsonResponse
     */
    public function getContainerDetails(GetContainerDetailsRequest $request, Container $container): JsonResponse
    {
        return $this->showAllWithoutPagination(
            $this->containerRepository->getContainerDetails($request->validated(), $container), ContainerDetailsResource::class);
    }

    /**
     * update container detail
     *
     * This endpoint lets you update container details
     *
     * @responseFile storage/responses/containers/update-details.json
     *
     * @param UpdateContainerDetailsRequest $request
     * @param ContainerDetails $containerDetails
     * @return JsonResponse
     */
    public function updateContainerDetails(UpdateContainerDetailsRequest $request, ContainerDetails $containerDetails): JsonResponse
    {
        $containerDetails = $this->containerRepository->updateContainerDetails($request->validated(), $containerDetails);

        return $this->showOne($containerDetails, ContainerDetailsResource::class, __("Container's Details update successfully"));
    }
}
