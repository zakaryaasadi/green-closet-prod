<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PointStatus;
use App\Enums\UserType;
use App\Traits\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable, HasApiTokens, SoftDeletes, LogsActivity;

    protected string $guard_name = 'api';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'country_id',
        'location_id',
        'last_login_at',
        'team_id',
        'status',
        'type',
        'image',
    ];

    protected $guarded = [
        'image',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    protected $dates = [
        'last_login_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function markPhoneAsUnverified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => null,
        ])->save();
    }

    public function markEmailAsUnverified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => null,
        ])->save();
    }

    public function setPassword($password)
    {
        $this->setPasswordAttribute($password);
        $this->save();
    }

    public function setType($type)
    {
        $this->type = $type;
        if ($this->type == UserType::ADMIN) {
            $this->country_id = null;
        }
        $this->save();
    }

    public function setTeam($team)
    {
        $this->team_id = $team;
        $this->save();
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function imageUrl(): ?string
    {
        return $this->image ? self::getDisk()->url($this->image) : null;
    }

    public static function getDisk(): Filesystem|FilesystemAdapter
    {
        return Storage::disk('users');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Specifies the user's FCM tokens
     *
     * @return array
     */
    public function routeNotificationForFcm(): array
    {
        return $this->fcmTokens();
    }

    public function fcmTokens(): array
    {
        return $this->devices()->pluck('fcm_token')->toArray();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function agentOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'agent_id');
    }

    public function agentOrdersCount($date): int
    {
        return $this->agentOrders()->whereDate('start_task', '=', $date)->count();
    }

    public function associations(): HasMany
    {
        return $this->hasMany(Association::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }

    public function activePoints($country_id)
    {
        return $this->points
            ->where('country_id', '=', $country_id)
            ->where('ends_at', '>=', Carbon::now('UTC'))
            ->where('status', '=', PointStatus::ACTIVE)
            ->sum('count');
    }

    public function agentSettings(): HasOne
    {
        return $this->hasOne(AgentSettings::class, 'agent_id');
    }

    public function containerDetails(): HasMany
    {
        return $this->hasMany(ContainerDetails::class, 'agent_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function userAccess(): HasMany
    {
        return $this->hasMany(UserAccess::class, 'user_id');
    }

    public function lastActiveOrder()
    {
        return $this->orders()->whereIn('status', [
            OrderStatus::CREATED,
            OrderStatus::ASSIGNED,
            OrderStatus::ACCEPTED,
            OrderStatus::DELIVERING,
        ])->latest()->first();
    }
}
