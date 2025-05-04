<?php

namespace App\Http\API\V1\Repositories\Event;

use App\Filters\CustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Event;
use App\Models\MediaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class EventRepository extends BaseRepository
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description'], ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('title'),
            AllowedSort::field('description'),
            AllowedSort::field('date'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Event::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexClientEvents(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $events = Event::where('country_id', '=', $country->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description'], ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('title'),
            AllowedSort::field('description'),
            AllowedSort::field('date'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($events, $filters, $sorts);
    }

    public function storeEvent(Collection $data): Event
    {
        $event = new Event();
        $event->fill($data->all());
        $event->save();
        $event->refresh();
        $media = MediaModel::whereId($data->get('thumbnail'))->first();
        $event->images()->attach($media->id, ['model_type' => 'event']);
        $event->thumbnail = $media->mediaUrl();
        $event->alt = $media->tag;
        $event->slug = strtolower(explode(' ', trim($event->meta['translate']['title_en']))[0] . $event->id);

        $event->save();
        $event->refresh();

        return $event;
    }

    public function updateEvent(Event $event, array $data): Model
    {
        $event = $this->updateWithMeta($event, $data);
        if (array_key_exists('meta', $data)) {
            $event->slug = strtolower(explode(' ', trim($event->meta['translate']['title_en']))[0] . $event->id);
        }
        if (array_key_exists('thumbnail', $data)) {
            $media = MediaModel::whereId($data['thumbnail'])->first();
            $event->thumbnail = $media->mediaUrl();
            $event->alt = $media->tag;
        }
        $event->save();
        $event->refresh();

        return $event;
    }

    public function uploadImages(Collection $data, Event $event): Event
    {
        $event->images()->syncWithPivotValues($data->get('images_ids'), ['model_type' => 'event'], false);
        $event->refresh();

        return $event;
    }

    public function deleteImages(Collection $data, Event $event): Event
    {
        foreach ($data->get('images_ids') as $image) {
            $media = MediaModel::whereId($image)->first()->mediaUrl();
            if ($media == $event->thumbnail)
                $event->thumbnail = null;
        }
        $event->images()->detach($data->get('images_ids'));
        $event->save();
        $event->refresh();

        return $event;
    }

    /**
     * @throws IPinfoException
     */
    public function showClientEvent(Event $event): ?Model
    {
        if(!$event->country_id == AppHelper::getCurrentCountry()->id)
            return null;

        return parent::show($event);
    }
}
