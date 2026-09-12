<?php

namespace Modules\VCards\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class VCardVisit extends Model
{
    protected $table = 'vcard_visits';

    protected $fillable = [
        'vcard_id',
        'ip_hash',
        'country_code',
        'country',
        'city',
        'browser',
        'browser_version',
        'os',
        'device_type',
        'language',
        'screen_width',
        'screen_height',
        'user_agent',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'screen_width' => 'integer',
        'screen_height' => 'integer',
    ];

    public function vcard(): BelongsTo
    {
        return $this->belongsTo(VCard::class);
    }

    public function scopeForVcard($query, int $vcardId)
    {
        return $query->where('vcard_id', $vcardId);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays($days));
    }

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', Carbon::today());
    }

    public function scopeLast7Days($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays(7));
    }

    public function scopeLast30Days($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays(30));
    }

    public function scopeLast90Days($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays(90));
    }

    public function scopeOlderThan($query, int $days)
    {
        return $query->where('visited_at', '<', Carbon::now()->subDays($days));
    }
}
