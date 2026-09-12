<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsEvent extends Model
{
    protected $table = 'analytics_events';

    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'session_id',
        'listing_id',
        'event_name',
        'event_category',
        'url',
        'path',
        'metadata',
        'is_bot',
        'created_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_bot' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(AnalyticsVisitor::class, 'visitor_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(AnalyticsSession::class, 'session_id');
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(\Modules\Listings\Models\Listing::class);
    }
}
