<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperItem
 */
class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'country_id',
        'image_path',
        'price_per_kg',
        'title',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function toComponent($language): array
    {
        if ($language == 'ar')
            $title = $this->meta['translate']['title_ar'];
        else
            $title = $this->meta['translate']['title_en'];

        return [
            'id' => $this->id,
                'title' => $title,
            'image_path' => $this->image_path,
        ];
    }
}
