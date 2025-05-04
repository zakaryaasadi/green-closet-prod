<?php

namespace App\Http\API\V1\Repositories\News;

use App\Filters\CustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\MediaModel;
use App\Models\News;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class NewsRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(News $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description', 'link'],
                ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('title'),
            AllowedSort::field('display_order'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(News::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function indexCustomerNews(): PaginatedData
    {
        $country = AppHelper::getCoutnryForMobile();
        $news = News::where('country_id', '=', $country->id)->latest();

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description', 'link'],
                ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('title'),
            AllowedSort::field('display_order'),
            AllowedSort::field('created_at'),

        ];

        return parent::filter($news, $filters, $sorts);
    }

    public function storeNews(Collection $data): News
    {
        $news = new News();
        $news->fill($data->all());
        $news->save();
        $news->refresh();
        $media = MediaModel::whereId($data->get('thumbnail'))->first();
        $news->images()->attach($media->id, ['model_type' => 'news']);
        $news->thumbnail = $media->mediaUrl();
        $news->alt = $media->tag;
        $slug = strtolower(str_replace(' ', '-', $news->meta['translate']['title_en']));
        if(News::whereSlug($slug)->first())
            $news->slug = $slug . '-' . $news->id;
        else
            $news->slug = $slug;
        $news->save();
        $news->refresh();

        return $news;
    }

    public function updateNews(News $news, array $data): Model
    {
        $news = $this->updateWithMeta($news, $data);
        if (array_key_exists('meta', $data)) {
            $slug = strtolower(str_replace(' ', '-', $news->meta['translate']['title_en']));
            if(News::whereSlug($slug)->first())
                $news->slug = $slug . '-' . $news->id;
            else
                $news->slug = $slug;
        }

        if (array_key_exists('thumbnail', $data)) {
            $media = MediaModel::whereId($data['thumbnail'])->first();
            $news->thumbnail = $media->mediaUrl();
            $news->alt = $media->tag;
        }

        $news->save();
        $news->refresh();

        return $news;
    }

    public function uploadImages(Collection $data, News $news): News
    {
        $news->images()->syncWithPivotValues($data->get('images_ids'), ['model_type' => 'news'], false);
        $news->refresh();

        return $news;
    }

    public function deleteImages(Collection $data, News $news): News
    {
        foreach ($data->get('images_ids') as $image) {
            $media = MediaModel::whereId($image)->first()->mediaUrl();
            if ($media == $news->thumbnail)
                $news->thumbnail = null;
        }
        $news->images()->detach($data->get('images_ids'));
        $news->save();
        $news->refresh();

        return $news;
    }
}
