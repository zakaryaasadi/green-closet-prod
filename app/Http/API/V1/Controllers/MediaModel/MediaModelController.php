<?php

namespace App\Http\API\V1\Controllers\MediaModel;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\MediaModel\MediaModelRepository;
use App\Http\API\V1\Requests\MediaModel\StoreMediaModelRequest;
use App\Http\API\V1\Requests\MediaModel\UpdateMediaModelRequest;
use App\Http\Resources\MediaModel\MediaModelResource;
use App\Models\MediaModel;
use Illuminate\Http\JsonResponse;

/**
 * @group  Media Gallery
 * APIs for Media Gallery settings
 */
class MediaModelController extends Controller
{
    protected MediaModelRepository $mediaModelRepository;

    public function __construct(MediaModelRepository $mediaModelRepository)
    {
        $this->middleware('auth:sanctum');
        $this->mediaModelRepository = $mediaModelRepository;
        $this->authorizeResource(MediaModel::class);
    }

    /**
     * Show all Media
     *
     * This endpoint lets you show all media
     *
     * @responseFile storage/responses/media-model/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[tag] string Field to filter items by tag.
     * @queryParam filter[search] string Field to filter items by tag.
     * @queryParam sort string Field to sort items by id, tag.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $paginatedData = $this->mediaModelRepository->index();

        return $this->showAll($paginatedData->getData(), MediaModelResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific media
     *
     * This endpoint lets you show specific media
     *
     * @responseFile storage/responses/media-model/show.json
     *
     * @param MediaModel $mediaModel
     * @return JsonResponse
     */
    public function show(MediaModel $mediaModel): JsonResponse
    {
        return $this->showOne($this->mediaModelRepository->show($mediaModel), MediaModelResource::class);
    }

    /**
     * Add Media
     *
     * This endpoint lets you add media
     *
     * @responseFile storage/responses/media-model/store.json
     *
     * @param StoreMediaModelRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function store(StoreMediaModelRequest $request): JsonResponse
    {
        $media = $this->mediaModelRepository->storeMedia($request->validated());

        return $this->showOne($media, MediaModelResource::class, __('The media added successfully'));

    }

    /**
     * Update specific media
     *
     * This endpoint lets you update specific media
     *
     * @responseFile storage/responses/media-model/update.json
     *
     * @param UpdateMediaModelRequest $request
     * @param MediaModel $mediaModel
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function update(UpdateMediaModelRequest $request, MediaModel $mediaModel): JsonResponse
    {
        $imageUpdated = $this->mediaModelRepository->updateMedia($mediaModel, $request->validated());

        return $this->showOne($imageUpdated, MediaModelResource::class, __("Media's information updated successfully"));
    }

    /**
     * Delete specific media
     *
     * This endpoint lets you delete specific media
     *
     * @responseFile storage/responses/media-model/delete.json
     *
     * @param MediaModel $mediaModel
     * @return JsonResponse
     */
    public function destroy(MediaModel $mediaModel): JsonResponse
    {
        $this->mediaModelRepository->delete($mediaModel);

        return $this->responseMessage(__('Media deleted successfully'));
    }
}
