<?php

namespace Modules\ListingProjects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ListingProject extends Model
{
    protected $table = 'listing_projects';

    protected $fillable = [
        'listing_id',
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'tags',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = static::generateUniqueSlug($project->title, $project->listing_id);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && !$project->isDirty('slug')) {
                $project->slug = static::generateUniqueSlug($project->title, $project->listing_id, $project->id);
            }
        });
    }

    public static function generateUniqueSlug(string $title, int $listingId, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ListingProjectCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingProjectImage::class, 'listing_project_id')->orderBy('sort_order');
    }
}
