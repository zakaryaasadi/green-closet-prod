<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\FileSystem;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperMediaModel
 */
class MediaModel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'media',
        'tag',
        'country_id',
        'type',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function newsMedia(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'model_images', 'media_id', 'model_id')
            ->withPivot('model_type')->where('model_type', '=', 'news');
    }

    public function eventsMedia(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'model_images', 'media_id', 'model_id')
            ->withPivot('model_type')->where('model_type', '=', 'event');
    }

    public function associationsMedia(): BelongsToMany
    {
        return $this->belongsToMany(Association::class, 'model_images', 'media_id', 'model_id')
            ->withPivot('model_type')->where('model_type', '=', 'association');
    }

    public function mediaUrl(): ?string
    {
        return $this->media ? self::getDisk()->url($this->media) : null;
    }

    public static function getDisk(): Filesystem|FilesystemAdapter
    {
        return Storage::disk('all_media');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
