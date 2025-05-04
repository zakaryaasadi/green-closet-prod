<?php

namespace App\Http\API\V1\Repositories\Message;

use App\Enums\MessageType;
use App\Filters\CountryCustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\Message\FailedMessageResource;
use App\Http\Resources\Message\MessageResource;
use App\Models\Language;
use App\Models\Message;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class MessageRepository extends BaseRepository
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('language_id'),
            AllowedFilter::exact('type'),
            AllowedFilter::partial('content'),
            AllowedFilter::custom('search', new CountryCustomFilter(['content'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('content'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Message::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function getThanksMessage(): string
    {
        $ThanksMessage = new MessageResource(Message::where([
            'country_id' => AppHelper::getCoutnryForMobile()->id,
            'language_id' => Language::whereCode(AppHelper::getLanguageForMobile())->first()->id,
            'type' => MessageType::THANKS_MESSAGE,
        ])->first());

        return $ThanksMessage?->content;
    }

    /**
     * @throws IPinfoException
     */
    public function getFailedMessages(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $messages = Message::where([
            'country_id' => AppHelper::getCoutnryForMobile()->id,
            'type' => MessageType::FAILED_MESSAGE])->get();

        return FailedMessageResource::collection($messages);

    }

    /**
     * @throws IPinfoException
     */
    public function getCancelMessages(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $messages = Message::where([
            'country_id' => AppHelper::getCoutnryForMobile()->id,
            'type' => MessageType::FAILED_MESSAGE])->get();

        return FailedMessageResource::collection($messages);

    }
}
