<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Orders\Enums\ProductType;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_type',
        'product_id',
        'variant_id',
        'title',
        'quantity',
        'unit_price',
        'options',
        'subtotal',
    ];

    protected $casts = [
        'product_type' => ProductType::class,
        'options' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getProduct()
    {
        $listingId = $this->order?->listing_id;
        if (!$listingId) {
            return null;
        }

        if ($this->product_type === ProductType::MENU_PRODUCT) {
            if (!class_exists(\Modules\ListingRestaurantMenu\Entities\MenuProduct::class)) {
                return null;
            }
            return \Modules\ListingRestaurantMenu\Entities\MenuProduct::where('id', $this->product_id)
                ->where('listing_id', $listingId)
                ->first();
        }
        if (!class_exists(\Modules\ListingProducts\Models\ListingProduct::class)) {
            return null;
        }
        return \Modules\ListingProducts\Models\ListingProduct::where('id', $this->product_id)
            ->where('listing_id', $listingId)
            ->first();
    }

    public function getVariant()
    {
        if (!$this->variant_id) {
            return null;
        }

        $listingId = $this->order?->listing_id;
        if (!$listingId) {
            return null;
        }

        if ($this->product_type === ProductType::MENU_PRODUCT) {
            if (!class_exists(\Modules\ListingRestaurantMenu\Entities\MenuProductVariant::class)) {
                return null;
            }
            return \Modules\ListingRestaurantMenu\Entities\MenuProductVariant::where('id', $this->variant_id)
                ->where('listing_id', $listingId)
                ->first();
        }
        return null;
    }

    protected static function booted(): void
    {
        static::saving(function ($item) {
            $item->subtotal = $item->quantity * $item->unit_price;
        });
    }
}
