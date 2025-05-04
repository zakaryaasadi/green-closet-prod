<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOneOrMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperSection
 */
class Section extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity;

    public static string $IMAGES_MEDIA_COLLECTION = 'images';

    protected $fillable = [
        'structure',
        'page_id',
        'sort',
        'type',
        'active',
        'language_id',
        'country_id',
    ];

    protected $casts = [
        'structure' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function images(): MorphOneOrMany
    {
        return $this->morphMany(Media::class, 'images');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::$IMAGES_MEDIA_COLLECTION);
    }

    public function getImages(): array
    {
        $array = [];
        $images = $this->getMedia(self::$IMAGES_MEDIA_COLLECTION);
        foreach ($images as $image) {
            $array[] = $image->getUrl();
        }

        return $array;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
