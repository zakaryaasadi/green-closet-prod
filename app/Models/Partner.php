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
 * @mixin IdeHelperPartner
 */
class Partner extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'alt',
        'description',
        'image_path',
        'country_id',
        'meta',
        'url',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function toComponent(): array
    {
        return [
            'link' => $this->url,
            'alt' => $this->alt,
            'image' => $this->image_path,
        ];
    }

    public function toComponentWithOffer(): array
    {
        $allOffers = [];

        foreach ($this->offers as $item) {
            $allOffers[] = $item->toComponent();
        }

        return [
            'link' => $this->url,
            'name' => $this->name,
            'image' => $this->image_path,
            'offers' => $allOffers,
            'alt' => $this->alt,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
