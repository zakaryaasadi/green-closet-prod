<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperTarget
 */
class Target extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'orders_count',
        'country_id',
        'weight_target',
        'month',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
