<?php

namespace App\Http\API\V1\Controllers\News;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\News\NewsRepository;
use App\Http\API\V1\Requests\MediaModel\UploadManyMediaRequest;
use App\Http\API\V1\Requests\News\StoreNewsRequest;
use App\Http\API\V1\Requests\News\UpdateNewsRequest;
use App\Http\Resources\News\NewsResource;
use App\Http\Resources\News\SimpleNewsResource;
use App\Models\News;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group News
 * APIs for news settings
 */
class NewsController extends Controller
{
    protected NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->middleware('auth:sanctum')->except([
            'indexCustomerNews',
            'showCustomerNews',
        ]);
        $this->newsRepository = $newsRepository;
        $this->authorizeResource(News::class);
    }

    /**
     * Show all news
     *
     * This endpoint lets you show all news
     *
     * @responseFile storage/responses/news/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[search] string Field to filter items by all fields title, description, url.
     * @queryParam sort string Field to sort items by id, title , display order.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->newsRepository->index();

        return $this->showAll($paginatedData->getData(), NewsResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all customer news
     *
     * This endpoint lets you show all customer news
     *
     * @responseFile storage/responses/news/customer/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[search] string Field to filter items by all fields title, description, url.
     * @queryParam sort string Field to sort items by id, title , display order.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexCustomerNews(): JsonResponse
    {
        $paginatedData = $this->newsRepository->indexCustomerNews();

        return $this->showAll($paginatedData->getData(), SimpleNewsResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific news
     *
     * This endpoint lets you show specific news
     *
     * @responseFile storage/responses/news/show.json
     *
     * @param News $news
     * @return JsonResponse
     */
    public function show(News $news): JsonResponse
    {
        return $this->showOne($this->newsRepository->show($news), NewsResource::class);
    }

    /**
     * Show specific customer news
     *
     * This endpoint lets you show specific customer news
     *
     * @responseFile storage/responses/news/customer/show.json
     *
     * @param News $news
     * @return JsonResponse
     */
    public function showCustomerNews(News $news): JsonResponse
    {
        return $this->showOne($this->newsRepository->show($news), SimpleNewsResource::class);
    }

    /**
     * Add news
     *
     * This endpoint lets you add news
     *
     * @responseFile storage/responses/news/store.json
     *
     * @param StoreNewsRequest $request
     * @return JsonResponse
     */
    public function store(StoreNewsRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $news = $this->newsRepository->storeNews($data);

        return $this->showOne($news, NewsResource::class, __('The news added successfully'));
    }

    /**
     * Update specific news
     *
     * This endpoint lets you update specific news
     *
     * @responseFile storage/responses/news/update.json
     *
     * @param UpdateNewsRequest $request
     * @param News $news
     * @return JsonResponse
     */
    public function update(UpdateNewsRequest $request, News $news): JsonResponse
    {
        $newsUpdated = $this->newsRepository->updateNews($news, $request->validated());

        return $this->showOne($newsUpdated, NewsResource::class, __("News's information updated successfully"));
    }

    /**
     * Delete specific news
     *
     * This endpoint lets you delete specific news
     *
     * @responseFile storage/responses/news/delete.json
     *
     * @param News $news
     * @return JsonResponse
     */
    public function destroy(News $news): JsonResponse
    {
        $this->newsRepository->delete($news);

        return $this->responseMessage(__('News deleted successfully'));
    }

    /**
     * Upload Images for news
     *
     * This endpoint lets you upload image for news
     *
     * @responseFile storage/responses/news/upload-images.json
     *
     * @param UploadManyMediaRequest $request
     * @param News $news
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function uploadImages(UploadManyMediaRequest $request, News $news): JsonResponse
    {
        $this->authorize('uploadNewsImage', $news);
        $data = collect($request->validated());
        $newsUpdated = $this->newsRepository->uploadImages($data, $news);

        return $this->showOne($newsUpdated, NewsResource::class, __('Images added to news'));
    }

    /**
     * Delete Images from news
     *
     * This endpoint lets you Delete Images from news
     *
     * @responseFile storage/responses/news/delete-images.json
     *
     * @param UploadManyMediaRequest $request
     * @param News $news
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function deleteImages(UploadManyMediaRequest $request, News $news): JsonResponse
    {
        $this->authorize('deleteNewsImages', $news);
        $data = collect($request->validated());
        $newsUpdated = $this->newsRepository->deleteImages($data, $news);

        return $this->showOne($newsUpdated, NewsResource::class, __('Images deleted from news'));
    }
}
