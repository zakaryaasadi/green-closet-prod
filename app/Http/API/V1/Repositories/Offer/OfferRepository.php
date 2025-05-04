<?php

namespace App\Http\API\V1\Repositories\Offer;

use App\Filters\CountryCustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\MediaModel;
use App\Models\Offer;
use App\Traits\ApiResponse;
use App\Traits\FileManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class OfferRepository extends BaseRepository
{
    use  FileManagement, ApiResponse;

    public function __construct(Offer $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('partner_id'),
            AllowedFilter::callback('partner_name', function (Builder $query, $value) {
                $query->whereHas('partner', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('type'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name', 'value'], ['name'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('type'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Offer::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexOfferForClient(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $offers = Offer::where('country_id', '=', $country->id);
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('partner_id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('type'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name', 'value'], ['name'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('type'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($offers, $filters, $sorts);
    }

    public function storeOffer(Collection $data): Offer
    {
        $offer = new Offer();
        $offer->fill($data->all());
        $offer->save();
        $media = MediaModel::whereId($data->get('image'))->first();
        $offer->image_path = $media->mediaUrl();
        $offer->alt = $media->tag;
        $offer->save();
        $offer->refresh();

        return $offer;
    }

    public function updateOffer(array $data, Offer $offer): Model
    {
        $offer = $this->updateWithMeta($offer, $data);
        if (array_key_exists('image', $data)) {
            $media = MediaModel::whereId($data['image'])->first();
            $offer->image_path = $media->mediaUrl();
            $offer->alt = $media->tag;
        }

        $offer->save();
        $offer->refresh();

        return $offer;
    }
}
