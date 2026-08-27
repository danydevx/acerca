<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AnalyticsSession extends Model
{
    protected $table = 'analytics_sessions';

    protected $fillable = [
        'visitor_id',
        'listing_id',
        'session_id',
        'started_at',
        'last_activity_at',
        'expires_at',
        'is_bot',
        'device_type',
        'browser',
        'os',
        'country_code',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_bot' => 'boolean',
    ];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(AnalyticsVisitor::class, 'visitor_id');
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(\Modules\Listings\Models\Listing::class);
    }

    public function pageviews(): HasMany
    {
        return $this->hasMany(AnalyticsPageview::class, 'session_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(AnalyticsEvent::class, 'session_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function touchActivity(): void
    {
        $this->update([
            'last_activity_at' => now(),
            'expires_at' => now()->addMinutes(30),
        ]);
    }

    public static function findValidOrCreate(
        string $sessionId,
        AnalyticsVisitor $visitor,
        int $listingId,
        array $sessionData
    ): self {
        $session = static::where('session_id', $sessionId)
            ->where('listing_id', $listingId)
            ->first();

        if ($session && !$session->isExpired()) {
            $session->touchActivity();
            return $session;
        }

        return static::create([
            'session_id' => $sessionId,
            'visitor_id' => $visitor->id,
            'listing_id' => $listingId,
            'started_at' => now(),
            'last_activity_at' => now(),
            'expires_at' => now()->addMinutes(30),
            'is_bot' => $visitor->is_bot,
            'device_type' => $sessionData['device_type'] ?? null,
            'browser' => $sessionData['browser'] ?? null,
            'os' => $sessionData['os'] ?? null,
            'country_code' => $sessionData['country_code'] ?? null,
            'referrer' => $sessionData['referrer'] ?? null,
            'utm_source' => $sessionData['utm_source'] ?? null,
            'utm_medium' => $sessionData['utm_medium'] ?? null,
            'utm_campaign' => $sessionData['utm_campaign'] ?? null,
        ]);
    }
}
