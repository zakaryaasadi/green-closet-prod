<?php

namespace App\Models;

use App\Traits\Language\TranslateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperNews
 */
class News extends Model
{
    use HasFactory, SoftDeletes, TranslateHelper, LogsActivity;

    protected $fillable = [
        'title',
        'link',
        'slug',
        'alt',
        'thumbnail',
        'description',
        'meta_tags',
        'meta_tags_arabic',
        'meta',
        'display_order',
        'country_id',
        'scripts',
        'scripts_arabic',
    ];

    protected $casts = [
        'meta' => 'array',
        'scripts' => 'array',
        'scripts_arabic' => 'array',
        'meta_tags' => 'array',
        'meta_tags_arabic' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(MediaModel::class, 'model_images', 'model_id', 'media_id')
            ->withPivot('model_type')->where('model_type', '=', 'news');
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
            'link' => $this->link,
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'slug' => $this->slug,
            'alt' => $this->alt,
            'display_order' => $this->display_order,
            'image' => $this->thumbnail,
            'images' => $images,
            'alts' => $alts,
            'scripts' => $this->scripts,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
