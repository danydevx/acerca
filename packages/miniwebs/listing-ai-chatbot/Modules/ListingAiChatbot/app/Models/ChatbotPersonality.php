<?php

namespace Modules\ListingAiChatbot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Listings\Models\Listing;

class ChatbotPersonality extends Model
{
    protected $table = 'chatbot_personalities';

    protected $fillable = [
        'listing_id',
        'key',
        'display_name',
        'description',
        'system_prompt_hint',
        'default_temperature',
        'default_response_length',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'default_temperature' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('display_name');
    }

    public function scopeGlobal(Builder $query): Builder
    {
        return $query->whereNull('listing_id');
    }

    public function scopeForListing(Builder $query, int $listingId): Builder
    {
        return $query->where('listing_id', $listingId);
    }

    public static function getActiveForSelect(?int $listingId = null)
    {
        return self::active()
            ->where(function ($q) use ($listingId) {
                $q->whereNull('listing_id');
                if ($listingId) {
                    $q->orWhere('listing_id', $listingId);
                }
            })
            ->sorted()
            ->get();
    }

    public static function keyExists(string $key, ?int $exceptId = null, ?int $listingId = null): bool
    {
        $query = self::where('key', $key)->where('listing_id', $listingId);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }
        return $query->exists();
    }
}
