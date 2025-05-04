<?php

namespace App\Http\API\V1\Controllers\Section;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Section\SectionRepository;
use App\Http\API\V1\Requests\Section\StoreSectionRequest;
use App\Http\API\V1\Requests\Section\UpdateSectionRequest;
use App\Http\Resources\Section\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;

/**
 * @group Sections
 * APIs for section settings
 */
class SectionController extends Controller
{
    protected SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->sectionRepository = $sectionRepository;
        $this->authorizeResource(Section::class);
    }

    /**
     * Show all sections
     *
     * This endpoint lets you show all section
     *
     * @responseFile storage/responses/sections/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[sort] string Field to filter items by sort.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[active] string Field to filter items by active.
     * @queryParam filter[page_id] string Field to filter items by page_id.
     * @queryParam sort string Field to sort items by id,sort,active ,type ,page_id.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->sectionRepository->index();

        return $this->showAll($paginatedData->getData(), SectionResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific section
     *
     * This endpoint lets you show specific section
     *
     * @responseFile storage/responses/sections/show.json
     *
     * @param Section $section
     * @return JsonResponse
     */
    public function show(Section $section): JsonResponse
    {
        return $this->showOne($this->sectionRepository->show($section), SectionResource::class);
    }

    /**
     * Add section
     *
     * This endpoint lets you add section
     *
     * @responseFile storage/responses/sections/store.json
     *
     * @param StoreSectionRequest $request
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function store(StoreSectionRequest $request): JsonResponse
    {
        $page = $this->sectionRepository->store($request->validated());

        return $this->showOne($page, SectionResource::class, __('The section added successfully'));
    }

    /**
     * Update specific section
     *
     * This endpoint lets you update specific section
     *
     * @responseFile storage/responses/sections/update.json
     *
     * @param UpdateSectionRequest $request
     * @param Section $section
     * @return JsonResponse
     */
    public function update(UpdateSectionRequest $request, Section $section): JsonResponse
    {
        $updatedSection = $this->sectionRepository->update($section, $request->validated());

        return $this->showOne($updatedSection, SectionResource::class, __("Section's information updated successfully"));
    }

    /**
     * Delete specific section
     *
     * This endpoint lets you delete specific section
     *
     * @responseFile storage/responses/sections/delete.json
     *
     * @param Section $section
     * @return JsonResponse
     */
    public function destroy(Section $section): JsonResponse
    {
        $this->sectionRepository->delete($section);

        return $this->responseMessage(__('Section deleted successfully'));
    }
}
