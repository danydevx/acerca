<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Listings\Models\Listing;

trait BelongsToListing
{
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function scopeForListing(Builder $query, int $listingId): Builder
    {
        return $query->where('listing_id', $listingId);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('listing', function (Builder $q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }
}
