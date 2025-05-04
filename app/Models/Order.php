<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\FileSystem;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperOrder
 */
class Order extends Model
{
    use HasFactory, SoftDeletes, SpatialTrait, LogsActivity;

    protected $dateFormat = 'c';

    protected $fillable = [
        'country_id',
        'customer_id',
        'agent_id',
        'address_id',
        'province_id',
        'association_id',
        'message_id',
        'payment_status',
        'value',
        'image',
        'agent_payment',
        'failed_message',
        'payment_remaining',
        'status',
        'type',
        'weight',
        'platform',
        'total_time',
        'start_at',
        'ends_at',
        'start_task',
    ];

    protected $guarded = [
        'location',
    ];

    protected array $spatialFields = [
        'location',
    ];

    protected $dates = [
        'start_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'ends_at',
        'start_task',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class, 'association_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function point(): HasOne
    {
        return $this->hasOne(Point::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_orders')->withPivot('weight');
    }

    public function imageUrl(): ?string
    {
        return $this->image ? self::getDisk()->url($this->image) : null;
    }

    public static function getDisk(): Filesystem|FilesystemAdapter
    {
        return Storage::disk('orders');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()->logOnlyDirty();
    }
}
