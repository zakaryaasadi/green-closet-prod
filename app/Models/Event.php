<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Traits\Language\TranslateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    use HasFactory, SoftDeletes, TranslateHelper, LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'date',
        'alt',
        'slug',
        'thumbnail',
        'country_id',
        'meta',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(MediaModel::class, 'model_images', 'model_id', 'media_id')
            ->withPivot('model_type')->where('model_type', '=', 'event');
    }

    public function toComponent(): array
    {
        $locale = app()->getLocale();
        $images = [];
        $alts = [];

        foreach ($this->images as $image){
            $images[] = $image->mediaUrl();
            $alts[] = $image->tag;
        }

        return [
            'id' => $this->id,
            'date' => AppHelper::getDateFormat($this->date),
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'slug' => $this->slug,
            'image' => $this->thumbnail,
            'alt' => $this->alt,
            'images' => $images,
            'alts' => $alts,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
