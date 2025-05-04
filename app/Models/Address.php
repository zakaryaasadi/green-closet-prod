<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperAddress
 */
class Address extends Model
{
    use HasFactory, SpatialTrait, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'country_id',
        'location_title',
        'location_province',
        'type',
        'default',
        'province_id',
        'apartment_number',
        'floor_number',
        'building',
    ];

    protected $guarded = [
        'location',
    ];

    protected array $spatialFields = [
        'location',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function toComponent(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->location_title,
            'province' => $this->location_province,
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
