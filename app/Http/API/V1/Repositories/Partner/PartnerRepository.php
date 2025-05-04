<?php

namespace App\Http\API\V1\Repositories\Partner;

use App\Filters\CustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\MediaModel;
use App\Models\Partner;
use App\Traits\ApiResponse;
use App\Traits\FileManagement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class PartnerRepository extends BaseRepository
{
    use FileManagement, ApiResponse;

    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'url', 'description'], ['name', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Partner::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexClientPartners(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $partners = Partner::where('country_id', '=', $country->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('search', new CustomFilter(['name', 'url', 'description'], ['name', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($partners, $filters, $sorts);
    }

    public function storePartner(Collection $data): Partner
    {
        $partner = new Partner();
        $partner->fill($data->all());
        $partner->save();
        $media = MediaModel::whereId($data->get('image'))->first();
        $partner->image_path = $media->mediaUrl();
        $partner->alt = $media->tag;
        $partner->save();
        $partner->refresh();

        return $partner;
    }

    public function updatePartner(array $data, Partner $partner): Model
    {
        $partner = $this->updateWithMeta($partner, $data);
        if (array_key_exists('image', $data)) {
            $media = MediaModel::whereId($data['image'])->first();
            $partner->image_path = $media->mediaUrl();
            $partner->alt = $media->tag;
        }

        $partner->save();
        $partner->refresh();

        return $partner;
    }
}
