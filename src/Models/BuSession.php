<?php

namespace BrowserUseLaravel\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuSession extends Model
{
    use HasUuids;

    protected $table = 'bu_sessions';

    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'stale_after_at' => 'datetime',
        'last_health_checked_at' => 'datetime',
        'stopped_at' => 'datetime',
        'restart_eligible_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(BuTask::class, 'bu_session_id');
    }
}
