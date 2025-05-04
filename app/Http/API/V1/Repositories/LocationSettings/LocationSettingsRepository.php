<?php

namespace App\Http\API\V1\Repositories\LocationSettings;

use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\LocationSettings;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class LocationSettingsRepository extends BaseRepository
{
    public function __construct(LocationSettings $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('language_id'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(LocationSettings::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function update(Model $model, $attributes): Model
    {
        if (array_key_exists('slug', $attributes))
        {
            $newSlug = $attributes['slug'];
            $defaultSetting = Setting::where(['country_id' => null])->first();
            if ($defaultSetting->slug == $model->slug)
                $defaultSetting->update(['slug' => $newSlug]);

            $countrySetting = Setting::whereCountryId(AppHelper::getCoutnryForMobile()->id)->first();
            if ($countrySetting->slug == $model->slug)
                $countrySetting->update(['slug' => $newSlug]);

        }

        return parent::update($model, $attributes);
    }
}
