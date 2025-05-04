<?php

namespace App\Http\API\V1\Repositories\MediaModel;

use App\Filters\CountryCustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\MediaModel;
use App\Traits\ApiResponse;
use App\Traits\FileManagement;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class MediaModelRepository extends BaseRepository
{
    use ApiResponse, FileManagement;

    public function __construct(MediaModel $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::partial('tag'),
            AllowedFilter::partial('type'),
            AllowedFilter::custom('search', new CountryCustomFilter(['tag'])),

        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('tag'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(MediaModel::class, $filters, $sorts);

    }

    /**
     * @throws \Exception
     */
    public function storeMedia($data): MediaModel|JsonResponse
    {
        $media = MediaModel::create($data);
        $media->type = $data['type'];
        $media->media = $this->getMedia();
        $media->save();
        $media->refresh();

        return $media;

    }

    /**
     * @throws \Exception
     */
    public function updateMedia(MediaModel $mediaModel, $data): MediaModel
    {
        $mediaModel->fill($data);
        $media = $this->getMedia();
        if (!is_null($media)) {
            $mediaModel::getDisk()->delete($mediaModel->media);
            $mediaModel->media = $media;
        }
        $mediaModel->save();
        $mediaModel->refresh();

        return $mediaModel;
    }

    /**
     * @throws \Exception
     */
    protected function getMedia()
    {
        if (request()->has('media')) {
            $file = request()->file('media');

            return $this->createFile($file, null, null, MediaModel::getDisk());
        }

        return null;
    }
}
