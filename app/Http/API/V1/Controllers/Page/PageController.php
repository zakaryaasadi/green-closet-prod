<?php

namespace App\Http\API\V1\Controllers\Page;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Page\PageRepository;
use App\Http\API\V1\Requests\Page\GetHomePageRequest;
use App\Http\API\V1\Requests\Page\SendMailRequest;
use App\Http\API\V1\Requests\Page\StorePageRequest;
use App\Http\API\V1\Requests\Page\UpdatePageRequest;
use App\Http\Resources\Page\PageResource;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Pages
 * APIs for page settings
 */
class PageController extends Controller
{
    protected PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->middleware(['auth:sanctum'])->except([
            'homePage',
            'sendMail',
            'contactUs',
            'howWeWork',
        ]);
        $this->pageRepository = $pageRepository;
        $this->authorizeResource(Page::class);
    }

    /**
     * Show all pages
     *
     * This endpoint lets you show all pages
     *
     * @responseFile storage/responses/pages/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[language_id] string Field to filter items by language_id.
     * @queryParam filter[search] string Field to filter items by all fields, title, default_page_title,slug,meta_tags.
     * @queryParam sort string Field to sort items by id,country_id,language_id ,title.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->pageRepository->index();

        return $this->showAll($paginatedData->getData(), PageResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific page
     *
     * This endpoint lets you show specific page
     *
     * @responseFile storage/responses/pages/show.json
     *
     * @param Page $page
     * @return JsonResponse
     */
    public function show(Page $page): JsonResponse
    {
        return $this->showOne($this->pageRepository->show($page), PageResource::class);
    }

    /**
     * Add page
     *
     * This endpoint lets you add page
     *
     * @responseFile storage/responses/pages/store.json
     *
     * @param StorePageRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function store(StorePageRequest $request): JsonResponse
    {
        $page = $this->pageRepository->store($request->validated());

        return $this->showOne($page, PageResource::class, __('The page added successfully'));
    }

    /**
     * Update specific page
     *
     * This endpoint lets you update specific page
     *
     * @responseFile storage/responses/pages/update.json
     *
     * @param UpdatePageRequest $request
     * @param Page $page
     * @return JsonResponse
     */
    public function update(UpdatePageRequest $request, Page $page): JsonResponse
    {
        $updatedPage = $this->pageRepository->update($page, $request->validated());

        return $this->showOne($updatedPage, PageResource::class, __("Page's information updated successfully"));
    }

    /**
     * Delete specific page
     *
     * This endpoint lets you delete specific page
     *
     * @responseFile storage/responses/pages/delete.json
     *
     * @param Page $page
     * @return JsonResponse
     */
    public function destroy(Page $page): JsonResponse
    {
        $this->pageRepository->delete($page);

        return $this->responseMessage(__('Page deleted successfully'));
    }

    /**
     * Home Page Api
     *
     * This API fetch data for client homePage
     *
     * @responseFile storage/responses/client/home.json
     *
     * @param GetHomePageRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function homePage(GetHomePageRequest $request): JsonResponse
    {
        $dataRequest = $request->validated();
        $data = $this->pageRepository->homePage($dataRequest);

        return $this->response('success', $data);
    }

    /**
     * Send mail api
     *
     * This API to send mail
     *
     * @responseFile storage/responses/client/send-mail.json
     *
     * @param SendMailRequest $request
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function sendMail(SendMailRequest $request): JsonResponse
    {
        return $this->pageRepository->sendMail($request->validated());
    }

    /**
     * Contact Page Api
     *
     * This API fetch data for client Contact
     *
     * @responseFile storage/responses/client/contact.json
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function contactUs(): JsonResponse
    {
        $data = $this->pageRepository->contactUs();

        return $this->response('success', $data);
    }

    /**
     * How we work mobile page Api
     *
     * This API fetch data for how we work page
     *
     * @responseFile storage/responses/client/how-we-work.json
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function howWeWork(): JsonResponse
    {
        $data = $this->pageRepository->howWeWorkPage();

        return $this->response('success', $data);
    }
}
