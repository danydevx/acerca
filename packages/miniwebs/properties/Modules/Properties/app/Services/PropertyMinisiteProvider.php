<?php

namespace Modules\Properties\Services;

use Modules\ListingMinisite\Contracts\MinisiteSectionProvider;
use Modules\Listings\Models\Listing;
use Modules\Properties\Models\Property;
use Modules\Properties\Models\PropertyType;

class PropertyMinisiteProvider implements MinisiteSectionProvider
{
    public function supports(Listing $listing): bool
    {
        return class_exists(Property::class)
            && Property::where('listing_id', $listing->id)->exists();
    }

    public function getSectionKey(): string
    {
        return 'properties';
    }

    public function getSectionData(Listing $listing, array $config): array
    {
        if (!class_exists(Property::class)) {
            return [];
        }

        $query = Property::where('listing_id', $listing->id)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');

        if (!empty($config['property_ids'])) {
            $query->whereIn('id', $config['property_ids']);
        }

        $maxItems = $config['max_items'] ?? 12;
        $query->limit($maxItems);

        return $query
            ->with('images', 'propertyType')
            ->get()
            ->map(function ($property) {
                $imagePath = $property->main_image;
                if (!$imagePath && $property->images && $property->images->isNotEmpty()) {
                    $firstImage = $property->images->first();
                    $imagePath = $firstImage->path ?? null;
                }

                if ($imagePath) {
                    if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
                        $finalPath = $imagePath;
                    } else {
                        $finalPath = "/storage/{$imagePath}";
                    }
                } else {
                    $finalPath = null;
                }

                $galleryImages = $property->images->map(function ($img) {
                    $path = str_starts_with($img->path, 'http') ? $img->path : "/storage/{$img->path}";
                    return [
                        'id' => $img->id,
                        'path' => $path,
                        'title' => $img->title ?? '',
                    ];
                })->toArray();

                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'slug' => $property->slug,
                    'description' => $property->description,
                    'operation_type' => $property->operation_type,
                    'operation_label' => $property->getOperationLabel(),
                    'price' => $property->price,
                    'formatted_price' => $property->getFormattedPrice(),
                    'currency' => $property->currency,
                    'price_period' => $property->price_period,
                    'main_image' => $finalPath,
                    'gallery' => $galleryImages,
                    'property_type' => $property->propertyType?->name,
                    'property_type_key' => $property->propertyType?->key,
                    'city' => $property->city,
                    'state' => $property->state ?: $property->state_code,
                    'country' => $property->country,
                    'full_address' => trim("{$property->street}, {$property->city}, {$property->state}"),
                    'latitude' => $property->latitude,
                    'longitude' => $property->longitude,
                ];
            })->toArray();
    }

    public function getPropertyTypes(Listing $listing): array
    {
        if (!class_exists(PropertyType::class)) {
            return [];
        }

        return PropertyType::where('listing_id', $listing->id)
            ->orWhereNull('listing_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'key', 'name'])
            ->map(fn($type) => [
                'id' => $type->id,
                'key' => $type->key,
                'name' => $type->name,
            ])
            ->toArray();
    }
}
