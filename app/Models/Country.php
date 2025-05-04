<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'meta',
        'code',
        'ico',
        'flag',
        'code_number',
        'status',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    public function mediaModels(): HasMany
    {
        return $this->hasMany(MediaModel::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function associations(): HasMany
    {
        return $this->hasMany(Association::class);
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function userAccess(): HasMany
    {
        return $this->hasMany(UserAccess::class);
    }

    public function locationSettings(): HasMany
    {
        return $this->hasMany(LocationSettings::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
