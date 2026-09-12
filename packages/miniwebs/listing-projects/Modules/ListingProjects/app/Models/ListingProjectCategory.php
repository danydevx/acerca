<?php

namespace Modules\ListingProjects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ListingProjectCategory extends Model
{
    protected $table = 'listing_project_categories';

    protected $fillable = [
        'listing_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name, $category->listing_id);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = static::generateUniqueSlug($category->name, $category->listing_id, $category->id);
            }
        });
    }

    public static function generateUniqueSlug(string $name, int $listingId, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        $query = static::where('listing_id', $listingId)->where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $query = static::where('listing_id', $listingId)->where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(\Modules\Listings\Models\Listing::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ListingProjectCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ListingProjectCategory::class, 'parent_id')->orderBy('sort_order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(ListingProject::class, 'category_id');
    }
}
