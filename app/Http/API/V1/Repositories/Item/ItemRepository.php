<?php

namespace App\Http\API\V1\Repositories\Item;

use App\Filters\CustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Item;
use App\Models\MediaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class ItemRepository extends BaseRepository
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country', 'country_id'),
            AllowedFilter::partial('price_per_kg'),
            AllowedFilter::partial('title'),
            AllowedFilter::custom('search', new CustomFilter(['title'], ['title'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('title'),
            AllowedSort::field('price_per_kg'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Item::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexClientItem(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $items = Item::where('country_id', '=', $country->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country', 'country_id'),
            AllowedFilter::partial('price_per_kg'),
            AllowedFilter::partial('title'),
            AllowedFilter::custom('search', new CustomFilter(['title'], ['title'])),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('title'),
            AllowedSort::field('price_per_kg'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($items, $filters, $sorts);
    }

    public function storeItem(Collection $data): Item
    {
        $item = new Item();
        $item->fill($data->all());
        $item->save();
        $item->image_path = MediaModel::whereId($data->get('image'))->first()->mediaUrl();
        $item->save();
        $item->refresh();

        return $item;
    }

    public function updateItem(array $data, Item $item): Model
    {
        $item = $this->updateWithMeta($item, $data);
        if (array_key_exists('image', $data))
            $item->image_path = MediaModel::whereId($data['image'])->first()->mediaUrl();
        $item->save();
        $item->refresh();

        return $item;
    }
}
