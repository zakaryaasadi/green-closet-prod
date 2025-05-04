<?php

namespace App\Http\API\V1\Controllers\Offer;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Offer\OfferRepository;
use App\Http\API\V1\Requests\Offer\StoreOfferRequest;
use App\Http\API\V1\Requests\Offer\UpdateOfferRequest;
use App\Http\Resources\Offer\OfferResource;
use App\Http\Resources\Offer\SimpleOfferResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Offers
 * APIs for offer settings
 */
class OfferController extends Controller
{
    protected OfferRepository $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->middleware(['auth:sanctum'])->except(['indexOfferForClient']);
        $this->offerRepository = $offerRepository;
        $this->authorizeResource(Offer::class);
    }

    /**
     * Show all offers
     *
     * This endpoint lets you show all offers
     *
     * @responseFile storage/responses/offers/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[partner_id] string Field to filter items by partner_id.
     * @queryParam filter[partner_name] string Field to filter items by partner_name.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[search] string Field to filter items by all fields, title, value.
     * @queryParam sort string Field to sort items by id,title,status,type.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->offerRepository->index();

        return $this->showAll($paginatedData->getData(), OfferResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all offers for client
     *
     * This endpoint lets you show all offers for client
     *
     * @responseFile storage/responses/offers/client-index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[partner_id] string Field to filter items by partner_id.
     * @queryParam filter[status] string Field to filter items by status.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[search] string Field to filter items by all fields, title, value.
     * @queryParam sort string Field to sort items by id,title,status,type.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexOfferForClient(): JsonResponse
    {
        $paginatedData = $this->offerRepository->indexOfferForClient();

        return $this->showAll($paginatedData->getData(), SimpleOfferResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific offer
     *
     * This endpoint lets you show specific offer
     *
     * @responseFile storage/responses/offers/show.json
     *
     * @param Offer $offer
     * @return JsonResponse
     */
    public function show(Offer $offer): JsonResponse
    {
        return $this->showOne($this->offerRepository->show($offer), OfferResource::class);
    }

    /**
     * Add offer
     *
     * This endpoint lets you add offer
     *
     * @responseFile storage/responses/offers/store.json
     *
     * @param StoreOfferRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function store(StoreOfferRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $offer = $this->offerRepository->storeOffer($data);

        return $this->showOne($offer, OfferResource::class, __('The offer added successfully'));
    }

    /**
     * Update specific offer
     *
     * This endpoint lets you update specific offer
     *
     * @responseFile storage/responses/offers/update.json
     *
     * @param UpdateOfferRequest $request
     * @param Offer $offer
     * @return JsonResponse
     */
    public function update(UpdateOfferRequest $request, Offer $offer): JsonResponse
    {
        $offerUpdated = $this->offerRepository->updateOffer($request->validated(), $offer);

        return $this->showOne($offerUpdated, OfferResource::class, __("Offer's information updated successfully"));
    }

    /**
     * Delete specific offer
     *
     * This endpoint lets you delete specific offer
     *
     * @responseFile storage/responses/offers/delete.json
     *
     * @param Offer $offer
     * @return JsonResponse
     */
    public function destroy(Offer $offer): JsonResponse
    {
        $this->offerRepository->delete($offer);

        return $this->responseMessage(__('Offer deleted successfully'));
    }
}
