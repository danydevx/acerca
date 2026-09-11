<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Listings\Models\Listing;

class MinisiteTheme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'preview_image',
        'css_variables',
        'layout_config',
        'section_config',
        'is_active',
    ];

    protected $casts = [
        'css_variables' => 'array',
        'layout_config' => 'array',
        'section_config' => 'array',
        'is_active' => 'boolean',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
