<?php

namespace App\Http\API\V1\Repositories\Section;

use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Section;
use App\Traits\FileManagement;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class SectionRepository extends BaseRepository
{
    use FileManagement;

    public function __construct(Section $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('sort'),
            AllowedFilter::exact('type'),
            AllowedFilter::exact('active'),
            AllowedFilter::exact('page_id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('language_id'),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('sort'),
            AllowedSort::field('active'),
            AllowedSort::field('type'),
            AllowedSort::field('page_id'),
        ];

        return parent::filter(Section::class, $filters, $sorts);
    }
}
