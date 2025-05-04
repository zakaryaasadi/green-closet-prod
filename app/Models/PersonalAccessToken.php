<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * @mixin IdeHelperPersonalAccessToken
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expired_at',
    ];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expired_at' => 'datetime',
    ];
}
