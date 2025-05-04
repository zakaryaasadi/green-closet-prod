<?php

namespace App\Http\API\V1\Controllers\Blog;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Blog\BlogRepository;
use App\Http\API\V1\Requests\Blog\StoreBlogRequest;
use App\Http\API\V1\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;

/**
 * @group Blogs
 * APIs for blogs settings
 */
class BlogController extends Controller
{
    protected BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->middleware('auth:sanctum');
        $this->blogRepository = $blogRepository;
        $this->authorizeResource(Blog::class);
    }

    /**
     * Show all blogs
     *
     * This endpoint lets you show all blogs
     *
     * @responseFile storage/responses/blogs/index.json
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
        $paginatedData = $this->blogRepository->index();

        return $this->showAll($paginatedData->getData(), BlogResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific blog
     *
     * This endpoint lets you show specific blog
     *
     * @responseFile storage/responses/blogs/show.json
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function show(Blog $blog): JsonResponse
    {
        return $this->showOne($this->blogRepository->show($blog), BlogResource::class);
    }

    /**
     * Add blog
     *
     * This endpoint lets you add blog
     *
     * @responseFile storage/responses/blogs/store.json
     *
     * @param StoreBlogRequest $request
     * @return JsonResponse
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $blog = $this->blogRepository->storeBlog($data);

        return $this->showOne($blog, BlogResource::class, __('The blog added successfully'));
    }

    /**
     * Update specific blog
     *
     * This endpoint lets you update specific blog
     *
     * @responseFile storage/responses/blogs/update.json
     *
     * @param UpdateBlogRequest $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(UpdateBlogRequest $request, Blog $blog): JsonResponse
    {
        $blogUpdated = $this->blogRepository->updateBlog($blog, $request->validated());

        return $this->showOne($blogUpdated, BlogResource::class, __("Blog's information updated successfully"));
    }

    /**
     * Delete specific blog
     *
     * This endpoint lets you delete specific blog
     *
     * @responseFile storage/responses/blogs/delete.json
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        $this->blogRepository->delete($blog);

        return $this->responseMessage(__('Blog deleted successfully'));
    }
}
