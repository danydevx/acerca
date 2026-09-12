<?php

namespace Modules\Orders\Services;

use Modules\ListingMinisite\Contracts\MinisitePageDataProvider;
use Modules\Listings\Models\Listing;
use Modules\Orders\Models\OrderSetting;

class OrderMinisitePageProvider implements MinisitePageDataProvider
{
    public function supports(Listing $listing): bool
    {
        return class_exists(OrderSetting::class)
            && OrderSetting::where('listing_id', $listing->id)->exists();
    }

    public function getDataKey(): string
    {
        return 'orderSettings';
    }

    public function getPageData(Listing $listing): array
    {
        if (!class_exists(OrderSetting::class)) {
            return null;
        }

        $setting = OrderSetting::where('listing_id', $listing->id)->first();

        if (!$setting) {
            return null;
        }

        return [
            'id' => $setting->id,
            'order_type' => $setting->order_type,
            'delivery_radius_km' => $setting->delivery_radius_km,
            'delivery_fee_base' => $setting->delivery_fee_base,
            'delivery_fee_per_km' => $setting->delivery_fee_per_km,
            'free_delivery_threshold' => $setting->free_delivery_threshold,
            'min_order_amount' => $setting->min_order_amount,
            'whatsapp_number' => $setting->whatsapp_number,
            'is_active' => $setting->is_active,
        ];
    }
}
