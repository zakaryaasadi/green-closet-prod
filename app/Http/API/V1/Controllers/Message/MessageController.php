<?php

namespace App\Http\API\V1\Controllers\Message;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\Message\MessageRepository;
use App\Http\API\V1\Requests\Message\StoreMessageRequest;
use App\Http\API\V1\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use ipinfo\ipinfo\IPinfoException;

/**
 * @group Message
 * APIs for Message settings
 */
class MessageController extends Controller
{
    protected MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->messageRepository = $messageRepository;
        $this->authorizeResource(Message::class);
    }

    /**
     * Show all Messages
     *
     * This endpoint lets you show all Messages
     *
     * @responseFile storage/responses/messages/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[search] string Field to filter items by content.
     * @queryParam sort string Field to sort items by id,title.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->messageRepository->index();

        return $this->showAll($paginatedData->getData(), MessageResource::class, $paginatedData->getPagination());
    }

    /**
     * Add message
     *
     * This endpoint lets you add message
     *
     * @responseFile storage/responses/messages/store.json
     *
     * @param StoreMessageRequest $request
     * @return JsonResponse
     */
    public function store(StoreMessageRequest $request): JsonResponse
    {
        $message = $this->messageRepository->store($request->validated());

        return $this->showOne($message, MessageResource::class, __('The message added successfully'));

    }

    /**
     * Show specific message
     *
     * This endpoint lets you show specific message
     *
     * @responseFile storage/responses/messages/show.json
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function show(Message $message): JsonResponse
    {
        return $this->showOne($this->messageRepository->show($message), MessageResource::class);
    }

    /**
     * Update specific message
     *
     * This endpoint lets you update specific message
     *
     * @responseFile storage/responses/messages/update.json
     *
     * @param UpdateMessageRequest $request
     * @param Message $message
     * @return JsonResponse
     */
    public function update(UpdateMessageRequest $request, Message $message): JsonResponse
    {
        $messageUpdated = $this->messageRepository->updateWithMeta($message, $request->validated());

        return $this->showOne($messageUpdated, MessageResource::class, __("Message's information updated successfully"));
    }

    /**
     * Delete specific message
     *
     * This endpoint lets you delete specific message
     *
     * @responseFile storage/responses/messages/delete.json
     *
     * @param Message $message
     * @return JsonResponse
     */
    public function destroy(Message $message): JsonResponse
    {
        $this->messageRepository->delete($message);

        return $this->responseMessage(__('Message deleted successfully'));
    }

    /**
     * Get Thanks message
     *
     * This endpoint lets you Get Thanks message
     *
     * @responseFile storage/responses/messages/thanks.json
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function getThanksMessage(): JsonResponse
    {
        return $this->response('success', $this->messageRepository->getThanksMessage());
    }

    /**
     * Get Failed Messages
     *
     * This endpoint lets you Get Failed Messages
     *
     * @responseFile storage/responses/messages/failed-messages.json
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function getFailedMessages(): JsonResponse
    {
        return $this->response('success', $this->messageRepository->getFailedMessages());
    }

    /**
     * Get Cancel Messages
     *
     * This endpoint lets you Get Cancel Messages
     *
     * @responseFile storage/responses/messages/cancel-messages.json
     *
     * @return JsonResponse
     *
     * @throws IPinfoException
     */
    public function getCancelMessages(): JsonResponse
    {
        return $this->response('success', $this->messageRepository->getCancelMessages());
    }
}
