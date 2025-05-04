<?php

namespace App\Http\API\V1\Repositories\Blog;

use App\Filters\CustomFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Blog;
use App\Models\MediaModel;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class BlogRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::custom('search', new CustomFilter(['title', 'description', 'slug'],
                ['title', 'description'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('title'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Blog::class, $filters, $sorts);
    }

    public function storeBlog(Collection $data): Blog
    {
        $blog = new Blog();
        $blog->fill($data->all());
        $blog->save();
        $blog->refresh();
        $media = MediaModel::whereId($data->get('image'))->first();
        $blog->image = $media->mediaUrl();
        $blog->alt = $media->tag;
        $slug = strtolower(str_replace(' ', '-', $blog->meta['translate']['title_en']));
        if(Blog::whereSlug($slug)->first())
            $blog->slug = $slug . '-' . $blog->id;
        else
            $blog->slug = $slug;
        $blog->save();
        $blog->refresh();

        return $blog;
    }

    public function updateBlog(Blog $blog, array $data): Model
    {
        $blog = $this->updateWithMeta($blog, $data);
        if (array_key_exists('meta', $data)) {
            $slug = strtolower(str_replace(' ', '-', $blog->meta['translate']['title_en']));
            if(Blog::whereSlug($slug)->first())
                $blog->slug = $slug . '-' . $blog->id;
            else
                $blog->slug = $slug;
        }

        if (array_key_exists('image', $data)) {
            $media = MediaModel::whereId($data['image'])->first();
            $blog->image = $media->mediaUrl();
            $blog->alt = $media->tag;
        }

        $blog->save();
        $blog->refresh();

        return $blog;
    }
}
