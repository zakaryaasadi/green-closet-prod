<?php

namespace App\Models;

use App\Traits\Language\TranslateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperOffer
 */
class Offer extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, TranslateHelper, LogsActivity;

    protected $fillable = [
        'name',
        'value',
        'alt',
        'image_path',
        'type',
        'country_id',
        'partner_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function toComponent(): array
    {
        $locale = app()->getLocale();

        return [
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'value' => $this->value,
            'image' => $this->image_path,
            'type' => $this->type,
            'alt' => $this->alt,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
