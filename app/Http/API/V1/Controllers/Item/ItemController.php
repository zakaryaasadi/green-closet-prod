<?php

namespace App\Http\API\V1\Controllers\Item;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Item\ItemRepository;
use App\Http\API\V1\Requests\Item\StoreItemRequest;
use App\Http\API\V1\Requests\Item\UpdateItemRequest;
use App\Http\Resources\Item\FullItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Items
 * APIs for Items
 */
class ItemController extends Controller
{
    protected ItemRepository $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->middleware(['auth:sanctum'])->except([
            'indexClientItem',
        ]);
        $this->itemRepository = $itemRepository;
        $this->authorizeResource(Item::class);
    }

    /**
     * Show all items
     *
     * This endpoint lets you show all items
     *
     * @responseFile storage/responses/items/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[title] string Field to filter items by name.
     * @queryParam filter[price_per_kg] string Field to filter items by price_per_kg.
     * @queryParam filter[search] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , country_id , title ,price_per_kg.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->itemRepository->index();

        return $this->showAll($paginatedData->getData(), FullItemResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all items for client
     *
     * This endpoint lets you show all items for client
     *
     * @responseFile storage/responses/items/index-client.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[title] string Field to filter items by name.
     * @queryParam filter[price_per_kg] string Field to filter items by price_per_kg.
     * @queryParam filter[search] string Field to filter items by name.
     * @queryParam sort string Field to sort items by id , country_id , title ,price_per_kg.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexClientItem(): JsonResponse
    {
        $paginatedData = $this->itemRepository->indexClientItem();

        return $this->showAll($paginatedData->getData(), FullItemResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific item
     *
     * This endpoint lets you show specific item
     *
     * @responseFile storage/responses/items/show.json
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function show(Item $item): JsonResponse
    {
        return $this->showOne($this->itemRepository->show($item), FullItemResource::class);
    }

    /**
     * Add item
     *
     * This endpoint lets you add item
     *
     * @responseFile storage/responses/items/store.json
     *
     * @param StoreItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $item = $this->itemRepository->storeItem($data);

        return $this->showOne($item, FullItemResource::class, __('The Item added successfully'));
    }

    /**
     * Update specific item
     *
     * This endpoint lets you update specific item
     *
     * @responseFile storage/responses/items/update.json
     *
     * @param UpdateItemRequest $request
     * @param Item $item
     * @return JsonResponse
     */
    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $updatedItem = $this->itemRepository->updateItem($request->validated(), $item);

        return $this->showOne($updatedItem, FullItemResource::class, __("Item's information updated successfully"));
    }

    /**
     * Delete specific item
     *
     * This endpoint lets you delete specific item
     *
     * @responseFile storage/responses/items/delete.json
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function destroy(Item $item): JsonResponse
    {
        $this->itemRepository->delete($item);

        return $this->responseMessage(__('Item deleted successfully'));
    }
}
