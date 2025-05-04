<?php

namespace App\Models;

use App\Traits\Language\TranslateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperAssociation
 */
class Association extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, TranslateHelper, LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'url',
        'meta',
        'thumbnail',
        'country_id',
        'user_id',
        'IBAN',
        'swift_code',
        'account_number',
        'status',
        'priority',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function containers(): HasMany
    {
        return $this->hasMany(Container::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function expense(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(MediaModel::class, 'model_images', 'model_id', 'media_id')
            ->withPivot('model_type')->where('model_type', '=', 'association');
    }

    public function toComponent($locale): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
