<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperIP
 */
class IP extends Model
{
    protected $table = 'ips';
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'ip_address',
        'status',
    ];
}
