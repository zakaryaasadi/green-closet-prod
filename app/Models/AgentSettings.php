<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperAgentSettings
 */
class AgentSettings extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agent_id',
        'tasks_per_day',
        'budget',
        'holiday',
        'start_work',
        'finish_work',
        'work_shift',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
