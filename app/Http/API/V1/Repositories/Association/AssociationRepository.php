<?php

namespace App\Http\API\V1\Repositories\Association;

use App\Enums\UserType;
use App\Filters\CustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Association;
use App\Models\MediaModel;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class AssociationRepository extends BaseRepository
{
    use  ApiResponse;

    public function __construct(Association $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('priority'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description', 'url'], ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('status'),
            AllowedSort::field('priority'),
            AllowedSort::field('title'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Association::class, $filters, $sorts);

    }

    /**
     * @throws IPinfoException
     */
    public function indexCustomerAssociation(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $associations = Association::where('country_id', '=', $country->id);

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('priority'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description', 'url'], ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('status'),
            AllowedSort::field('priority'),
            AllowedSort::field('title'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter($associations, $filters, $sorts);

    }

    public function storeAssociation(Collection $data): Association
    {
        $association = new Association();
        $association->fill($data->all());
        if ($data->has('user_id')) {
            $user = User::whereId($data->get('user_id'))->first();
            $user->type = UserType::ASSOCIATION;
            $user->save();
        }
        $association->save();
        $media = MediaModel::whereId($data->get('thumbnail'))->first();
        $association->images()->attach($media->id, ['model_type' => 'association']);
        $association->thumbnail = $media->mediaUrl();
        $association->save();
        $association->refresh();

        return $association;
    }

    public function updateAssociation($data, Association $association): Model
    {
        if (array_key_exists('user_id', $data)) {
            $user = User::whereId($data['user_id'])->first();
            $user->type = UserType::ASSOCIATION;
            $user->save();
        }
        $association = $this->updateWithMeta($association, $data);

        if (array_key_exists('thumbnail', $data)) {
            $association->thumbnail = MediaModel::whereId($data['thumbnail'])->first()->mediaUrl();
        }

        $association->save();
        $association->refresh();

        return $association;
    }

    public function uploadImages(Collection $data, Association $association): Association
    {
        $association->images()->syncWithPivotValues($data->get('images_ids'), ['model_type' => 'association'], false);
        $association->refresh();

        return $association;
    }

    public function deleteImages(Collection $data, Association $association): Association
    {
        foreach ($data->get('images_ids') as $image) {
            $media = MediaModel::whereId($image)->first()->mediaUrl();
            if ($media == $association->thumbnail)
                $association->thumbnail = null;
        }
        $association->images()->detach($data->get('images_ids'));
        $association->save();
        $association->refresh();

        return $association;
    }
}
