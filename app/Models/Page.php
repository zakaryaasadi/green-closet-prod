<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperPage
 */
class Page extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'default_page_title',
        'is_home',
        'slug',
        'meta_tags',
        'meta_tags_arabic',
        'custom_styles',
        'custom_scripts',
        'custom_scripts_arabic',
        'country_id',
        'language_id',
    ];

    protected $casts = [
        'meta_tags' => 'array',
        'meta_tags_arabic' => 'array',
        'custom_styles' => 'array',
        'custom_scripts' => 'array',
        'custom_scripts_arabic' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort');
    }

    public function activeSortedSections(): HasMany
    {
        return $this->hasMany(Section::class)
            ->where('active', true)
            ->orderBy('sort');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
