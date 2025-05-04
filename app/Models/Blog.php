<?php

namespace App\Models;

use App\Traits\Language\TranslateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperBlog
 */
class Blog extends Model
{
    use HasFactory, SoftDeletes, TranslateHelper, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'alt',
        'image',
        'description',
        'meta_tags',
        'meta_tags_arabic',
        'meta',
        'country_id',
    ];

    protected $casts = [
        'meta' => 'array',
        'meta_tags' => 'array',
        'meta_tags_arabic' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function toComponent(): array
    {
        $locale = app()->getLocale();

        $images = [];

        return [
            'id' => $this->id,
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'slug' => $this->slug,
            'image' => $this->image,
            'alt' => $this->alt,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
