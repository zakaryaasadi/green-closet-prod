<?php

namespace App\Http\API\V1\Controllers\Event;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Event\EventRepository;
use App\Http\API\V1\Requests\Event\StoreEventRequest;
use App\Http\API\V1\Requests\Event\UpdateEventRequest;
use App\Http\API\V1\Requests\MediaModel\UploadManyMediaRequest;
use App\Http\Resources\Event\EventResource;
use App\Http\Resources\Event\SimpleEventResource;
use App\Models\Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Events
 * APIs for event settings
 */
class EventController extends Controller
{
    protected EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->middleware(['auth:sanctum'])->except([
            'indexCustomerEvent',
            'showCustomerEvent',
        ]);
        $this->eventRepository = $eventRepository;
        $this->authorizeResource(Event::class);
    }

    /**
     * Show all events
     *
     * This endpoint lets you show all events
     *
     * @responseFile storage/responses/events/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country id.
     * @queryParam filter[title] string Field to filter items by title.
     * @queryParam filter[description] string Field to filter items by description.
     * @queryParam sort string Field to sort items by id,title,description,date.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->eventRepository->index();

        return $this->showAll($paginatedData->getData(), EventResource::class, $paginatedData->getPagination());
    }

    /**
     * Show all events for client
     *
     * This endpoint lets you show all events for client
     *
     * @responseFile storage/responses/events/client/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[country_id] string Field to filter items by country id.
     * @queryParam filter[title] string Field to filter items by title.
     * @queryParam filter[description] string Field to filter items by description.
     * @queryParam sort string Field to sort items by id,title,description,date.
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function indexCustomerEvent(): JsonResponse
    {
        $paginatedData = $this->eventRepository->indexClientEvents();

        return $this->showAll($paginatedData->getData(), EventResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific event
     *
     * This endpoint lets you show specific event
     *
     * @responseFile storage/responses/events/show.json
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function show(Event $event): JsonResponse
    {
        return $this->showOne($this->eventRepository->show($event), EventResource::class);
    }

    /**
     * Show specific event for client
     *
     * This endpoint lets you show specific event for client
     *
     * @responseFile storage/responses/events/client/show.json
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function showCustomerEvent(Event $event): JsonResponse
    {
        return $this->showOne($this->eventRepository->show($event), SimpleEventResource::class);
    }

    /**
     * Add event
     *
     * This endpoint lets you add event
     *
     * @responseFile storage/responses/events/store.json
     *
     * @param StoreEventRequest $request
     * @return JsonResponse
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $data = collect($request->validated());
        $event = $this->eventRepository->storeEvent($data);

        return $this->showOne($event, EventResource::class, __('The event added successfully'));
    }

    /**
     * Update specific event
     *
     * This endpoint lets you update specific event
     *
     * @responseFile storage/responses/events/update.json
     *
     * @param UpdateEventRequest $request
     * @param Event $event
     * @return JsonResponse
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $eventUpdated = $this->eventRepository->updateEvent($event, $request->validated());

        return $this->showOne($eventUpdated, EventResource::class, __("Event's information updated successfully"));
    }

    /**
     * Delete specific event
     *
     * This endpoint lets you delete specific event
     *
     * @responseFile storage/responses/events/delete.json
     *
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event): JsonResponse
    {
        $this->eventRepository->delete($event);

        return $this->responseMessage(__('Event deleted successfully'));
    }

    /**
     * Upload Images to event
     *
     * This endpoint lets you upload images to event
     *
     * @responseFile storage/responses/events/upload-images.json
     *
     * @param UploadManyMediaRequest $request
     * @param Event $event
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function uploadImages(UploadManyMediaRequest $request, Event $event): JsonResponse
    {
        $this->authorize('uploadEventImage', $event);
        $data = collect($request->validated());
        $eventUpdated = $this->eventRepository->uploadImages($data, $event);

        return $this->showOne($eventUpdated, EventResource::class, __('Images added to news'));
    }

    /**
     * Delete Images from events
     *
     * This endpoint lets you Delete Images from event
     *
     * @responseFile storage/responses/events/delete-images.json
     *
     * @param UploadManyMediaRequest $request
     * @param Event $event
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function deleteImages(UploadManyMediaRequest $request, Event $event): JsonResponse
    {
        $this->authorize('deleteEventsImages', $event);
        $data = collect($request->validated());
        $eventUpdated = $this->eventRepository->deleteImages($data, $event);

        return $this->showOne($eventUpdated, EventResource::class, __('Images deleted from event'));
    }
}
