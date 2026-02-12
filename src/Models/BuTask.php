<?php

namespace BrowserUseLaravel\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuTask extends Model
{
    use HasUuids;

    protected $table = 'bu_tasks';

    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'timeout_at' => 'datetime',
        'last_polled_at' => 'datetime',
        'result_summary' => 'array',
        'metadata' => 'array',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(BuSession::class, 'bu_session_id');
    }
}
