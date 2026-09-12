<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsPageview extends Model
{
    protected $table = 'analytics_pageviews';

    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'session_id',
        'listing_id',
        'url',
        'path',
        'query_string',
        'page_title',
        'referrer',
        'ip_address',
        'ip_hash',
        'country',
        'country_code',
        'region',
        'city',
        'timezone',
        'latitude',
        'longitude',
        'user_agent',
        'browser',
        'browser_version',
        'os',
        'device_type',
        'language',
        'screen_width',
        'screen_height',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'is_bot',
        'created_at',
    ];

    protected $casts = [
        'screen_width' => 'integer',
        'screen_height' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
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
