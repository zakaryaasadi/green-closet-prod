<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\FileSystem;

/**
 * @mixin IdeHelperInvoice
 */
class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'url',
    ];

    public function pdfUrl(): ?string
    {
        return $this->url ? self::getDisk()->url($this->url) : null;
    }

    public static function getDisk(): Filesystem|FilesystemAdapter
    {
        return Storage::disk('invoices');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
