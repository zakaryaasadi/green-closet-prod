<?php

namespace App\Http\API\V1\Controllers\Partner;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Partner\PartnerRepository;
use App\Http\API\V1\Requests\Partner\StorePartnerRequest;
use App\Http\API\V1\Requests\Partner\UpdatePartnerRequest;
use App\Http\Resources\Partner\PartnerResource;
use App\Http\Resources\Partner\SimplePartnerResource;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Partners
 * APIs for partner settings
 */
class PartnerController extends Controller
{
    protected PartnerRepository $partnerRepository;

    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->middleware(['auth:sanctum'])->except([
            'indexClientPartners',
            'showClientPartners',
        ]);
        $this->partnerRepository = $partnerRepository;
        $this->authorizeResource(Partner::class);
    }

    /**
     * Show all partners
     *
     * This endpoint lets you show all partners
     *
     * @responseFile storage/responses/partners/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[search] string Field to filter items by all fields, name, description.
     * @queryParam sort string Field to sort items by id,name.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->partnerRepository->index();

        return $this->showAll($paginatedData->getData(), PartnerResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all partners for client
     *
     * This endpoint lets you show all partners for client
     *
     * @responseFile storage/responses/partners/customer/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[search] string Field to filter items by all fields, name, description.
     * @queryParam sort string Field to sort items by id,name.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexClientPartners(): JsonResponse
    {
        $paginatedData = $this->partnerRepository->indexClientPartners();

        return $this->showAll($paginatedData->getData(), SimplePartnerResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific partner
     *
     * This endpoint lets you show specific partner
     *
     * @responseFile storage/responses/partners/show.json
     *
     * @param Partner $partner
     * @return JsonResponse
     */
    public function show(Partner $partner): JsonResponse
    {
        return $this->showOne($this->partnerRepository->show($partner), PartnerResource::class);
    }

    /**
     * Show specific partner for client
     *
     * This endpoint lets you show specific partner for client
     *
     * @responseFile storage/responses/partners/customer/show.json
     *
     * @param Partner $partner
     * @return JsonResponse
     */
    public function showClientPartners(Partner $partner): JsonResponse
    {
        return $this->showOne($this->partnerRepository->show($partner), SimplePartnerResource::class);
    }

    /**
     * Add partner
     *
     * This endpoint lets you add partner
     *
     * @responseFile storage/responses/partners/store.json
     *
     * @param StorePartnerRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function store(StorePartnerRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $partner = $this->partnerRepository->storePartner($data);

        return $this->showOne($partner, PartnerResource::class, __('The partner added successfully'));
    }

    /**
     * Update specific partner
     *
     * This endpoint lets you update specific partner
     *
     * @responseFile storage/responses/partners/update.json
     *
     * @param UpdatePartnerRequest $request
     * @param Partner $partner
     * @return JsonResponse
     */
    public function update(UpdatePartnerRequest $request, Partner $partner): JsonResponse
    {
        $partnerUpdate = $this->partnerRepository->updatePartner($request->validated(), $partner);

        return $this->showOne($partnerUpdate, PartnerResource::class, __("Partner's information updated successfully"));
    }

    /**
     * Delete specific partner
     *
     * This endpoint lets you delete specific partner
     *
     * @responseFile storage/responses/partners/delete.json
     *
     * @param Partner $partner
     * @return JsonResponse
     */
    public function destroy(Partner $partner): JsonResponse
    {
        $this->partnerRepository->delete($partner);

        return $this->responseMessage(__('Partner deleted successfully'));
    }
}
