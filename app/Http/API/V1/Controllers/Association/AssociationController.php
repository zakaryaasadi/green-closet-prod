<?php

namespace App\Http\API\V1\Controllers\Association;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Association\AssociationRepository;
use App\Http\API\V1\Requests\Association\StoreAssociationRequest;
use App\Http\API\V1\Requests\Association\UpdateAssociationRequest;
use App\Http\API\V1\Requests\MediaModel\UploadManyMediaRequest;
use App\Http\Resources\Association\AssociationResource;
use App\Http\Resources\Association\SimpleAssociationResource;
use App\Models\Association;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Association
 * APIs for association settings
 */
class AssociationController extends Controller
{
    protected AssociationRepository $associationRepository;

    public function __construct(AssociationRepository $associationRepository)
    {
        $this->middleware('auth:sanctum')->except([
            'indexCustomerAssociation',
            'showCustomerAssociation',
        ]);
        $this->associationRepository = $associationRepository;
        $this->authorizeResource(Association::class);
    }

    /**
     * Show all associations
     *
     * This endpoint lets you show all associations
     *
     * @responseFile storage/responses/association/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[search] string Field to filter items by all fields title, description.
     * @queryParam sort string Field to sort items by id, title.
     *
     * @responseFile storage/responses/association/index.json
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->associationRepository->index();

        return $this->showAll($paginatedData->getData(), AssociationResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all associations for customer
     *
     * This endpoint lets you show all associations for customer
     *
     * @responseFile storage/responses/association/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[search] string Field to filter items by all fields title, description.
     * @queryParam sort string Field to sort items by id, title.
     *
     * @responseFile storage/responses/association/client/index.json
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexCustomerAssociation(): JsonResponse
    {
        $paginatedData = $this->associationRepository->indexCustomerAssociation();

        return $this->showAll($paginatedData->getData(), SimpleAssociationResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific association
     *
     * This endpoint lets you show specific association
     *
     * @responseFile storage/responses/association/show.json
     *
     * @param Association $association
     * @return JsonResponse
     */
    public function show(Association $association): JsonResponse
    {
        return $this->showOne($this->associationRepository->show($association), AssociationResource::class);
    }

    /**
     * Show specific association for customer
     *
     * This endpoint lets you show specific association for customer
     *
     * @responseFile storage/responses/association/client/show.json
     *
     * @param Association $association
     * @return JsonResponse
     */
    public function showCustomerAssociation(Association $association): JsonResponse
    {
        return $this->showOne($this->associationRepository->show($association), SimpleAssociationResource::class);
    }

    /**
     * Add association
     *
     * This endpoint lets you add association
     *
     * @responseFile storage/responses/association/store.json
     *
     * @param StoreAssociationRequest $request
     * @return JsonResponse
     */
    public function store(StoreAssociationRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $association = $this->associationRepository->storeAssociation($data);

        return $this->showOne($association, AssociationResource::class, __('The association added successfully'));
    }

    /**
     * Update specific association
     *
     * This endpoint lets you update specific association
     *
     * @responseFile storage/responses/association/update.json
     *
     * @param UpdateAssociationRequest $request
     * @param Association $association
     * @return JsonResponse
     */
    public function update(UpdateAssociationRequest $request, Association $association): JsonResponse
    {
        $associationUpdate = $this->associationRepository->updateAssociation($request->validated(), $association);

        return $this->showOne($associationUpdate, AssociationResource::class, __("Association's information updated successfully"));
    }

    /**
     * Delete specific association
     *
     * This endpoint lets you delete specific association
     *
     * @responseFile storage/responses/association/delete.json
     *
     * @param Association $association
     * @return JsonResponse
     */
    public function destroy(Association $association): JsonResponse
    {
        $this->associationRepository->delete($association);

        return $this->responseMessage(__('Association deleted successfully'));
    }

    /**
     * Upload Image for association
     *
     * This endpoint lets you upload  association image
     *
     * @responseFile storage/responses/association/upload-images.json
     *
     * @param UploadManyMediaRequest $request
     * @param Association $association
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function uploadImages(UploadManyMediaRequest $request, Association $association): JsonResponse
    {
        $this->authorize('uploadAssociationImage', $association);
        $data = collect($request->validated());
        $associationUpdated = $this->associationRepository->uploadImages($data, $association);

        return $this->showOne($associationUpdated, AssociationResource::class, __('Images added to association'));
    }

    /**
     * Delete Images from association
     *
     * This endpoint lets you Delete Images from association
     *
     * @responseFile storage/responses/association/delete-images.json
     *
     * @param UploadManyMediaRequest $request
     * @param Association $association
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function deleteImages(UploadManyMediaRequest $request, Association $association): JsonResponse
    {
        $this->authorize('deleteAssociationImages', $association);
        $data = collect($request->validated());
        $associationUpdated = $this->associationRepository->deleteImages($data, $association);

        return $this->showOne($associationUpdated, AssociationResource::class, __('Images deleted from association'));
    }
}
