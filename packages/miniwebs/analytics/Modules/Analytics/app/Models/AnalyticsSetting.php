<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsSetting extends Model
{
    protected $table = 'analytics_settings';

    protected $fillable = [
        'listing_id',
        'is_enabled',
        'track_pageviews',
        'track_events',
        'track_referrers',
        'track_utm',
        'track_device',
        'track_location',
        'store_full_ip',
        'exclude_bots',
        'session_timeout_minutes',
        'data_retention_months',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'track_pageviews' => 'boolean',
        'track_events' => 'boolean',
        'track_referrers' => 'boolean',
        'track_utm' => 'boolean',
        'track_device' => 'boolean',
        'track_location' => 'boolean',
        'store_full_ip' => 'boolean',
        'exclude_bots' => 'boolean',
        'session_timeout_minutes' => 'integer',
        'data_retention_months' => 'integer',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(\Modules\Listings\Models\Listing::class);
    }

    public static function getForListing(int $listingId): self
    {
        $setting = static::where('listing_id', $listingId)->first();

        if (!$setting) {
            $setting = static::create([
                'listing_id' => $listingId,
            ]);
        }

        return $setting;
    }

    public function shouldTrackPageviews(): bool
    {
        return $this->is_enabled && $this->track_pageviews;
    }

    public function shouldTrackEvents(): bool
    {
        return $this->is_enabled && $this->track_events;
    }

    public function shouldStoreFullIp(): bool
    {
        return $this->store_full_ip;
    }

    public function shouldExcludeBots(): bool
    {
        return $this->exclude_bots;
    }

    public function getSessionTimeoutMinutes(): int
    {
        return $this->session_timeout_minutes ?? 30;
    }

    public function getDataRetentionMonths(): int
    {
        return $this->data_retention_months ?? 12;
    }
}
