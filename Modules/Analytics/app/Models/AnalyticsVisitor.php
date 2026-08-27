<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AnalyticsVisitor extends Model
{
    protected $table = 'analytics_visitors';

    protected $fillable = [
        'listing_id',
        'visitor_id',
        'first_seen_at',
        'last_seen_at',
        'user_agent',
        'is_bot',
        'country_code',
        'city',
        'region',
    ];

    protected $casts = [
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'is_bot' => 'boolean',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(\Modules\Listings\Models\Listing::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(AnalyticsSession::class, 'visitor_id');
    }

    public function pageviews(): HasMany
    {
        return $this->hasMany(AnalyticsPageview::class, 'visitor_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(AnalyticsEvent::class, 'visitor_id');
    }

    public static function findOrCreateByCookie(string $visitorId, int $listingId, string $userAgent, bool $isBot): self
    {
        $visitor = static::where('visitor_id', $visitorId)
            ->where('listing_id', $listingId)
            ->first();

        if ($visitor) {
            $visitor->update(['last_seen_at' => now()]);
            return $visitor;
        }

        return static::create([
            'visitor_id' => $visitorId,
            'listing_id' => $listingId,
            'first_seen_at' => now(),
            'last_seen_at' => now(),
            'user_agent' => $userAgent,
            'is_bot' => $isBot,
        ]);
    }
}
