<?php

namespace Modules\ListingProjects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingProjectImage extends Model
{
    protected $table = 'listing_project_images';

    protected $fillable = [
        'listing_project_id',
        'path',
        'filename',
        'original_name',
        'extension',
        'mime_type',
        'size',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'size' => 'integer',
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(ListingProject::class, 'listing_project_id');
    }

    public function getUrlAttribute(): string
    {
        return "/storage/{$this->path}";
    }
}
