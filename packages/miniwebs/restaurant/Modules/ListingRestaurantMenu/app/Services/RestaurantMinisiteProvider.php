<?php

namespace Modules\ListingRestaurantMenu\Services;

use Modules\ListingMinisite\Contracts\MinisiteSectionProvider;
use Modules\Listings\Models\Listing;
use Modules\ListingRestaurantMenu\Entities\MenuCategory;

class RestaurantMinisiteProvider implements MinisiteSectionProvider
{
    public function supports(Listing $listing): bool
    {
        return class_exists(MenuCategory::class)
            && MenuCategory::where('listing_id', $listing->id)
                ->where('active', true)
                ->has('activeProducts')
                ->exists();
    }

    public function getSectionKey(): string
    {
        return 'restaurant_menu';
    }

    public function getSectionData(Listing $listing, array $config): array
    {
        if (!class_exists(MenuCategory::class)) {
            return [];
        }

        $query = MenuCategory::where('listing_id', $listing->id)
            ->where('active', true)
            ->whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->where('active', true)->orderBy('sort_order');
            }, 'activeProducts', 'children.activeProducts']);

        if (!empty($config['category_ids'])) {
            $query->whereIn('id', $config['category_ids']);
        }

        $categories = $query->orderBy('sort_order')->get();

        return $categories->map(function ($category) use ($config) {
            $products = $category->activeProducts->map(function ($product) use ($config) {
                $imagePath = $product->image;
                if (!$imagePath && $product->images && $product->images->isNotEmpty()) {
                    $imagePath = $product->images->first()->path;
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

                $galleryImages = $product->images->map(function ($img) {
                    $path = str_starts_with($img->path, 'http') ? $img->path : "/storage/{$img->path}";
                    return [
                        'id' => $img->id,
                        'path' => $path,
                        'title' => $img->title ?? '',
                    ];
                })->toArray();

                $variants = $product->activeVariants->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'title' => $variant->title,
                        'description' => $variant->description,
                        'price' => $variant->display_price,
                    ];
                })->toArray();

                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'description' => $product->description,
                    'price' => $product->display_price,
                    'image' => $finalPath,
                    'gallery' => $galleryImages,
                    'variants' => $variants,
                    'image' => $product->image,
                    'gallery' => $product->images->map(fn($img) => ['id' => $img->id, 'path' => $img->path, 'title' => $img->title])->toArray(),
                ];
            })->toArray();

            $childProducts = $category->children->flatMap(function ($child) {
                return $child->activeProducts->map(function ($product) {
                    $imagePath = $product->image;
                    if (!$imagePath && $product->images && $product->images->isNotEmpty()) {
                        $imagePath = $product->images->first()->path;
                    }
                    $finalPath = $imagePath
                        ? (str_starts_with($imagePath, 'http') ? $imagePath : "/storage/{$imagePath}")
                        : null;
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'description' => $product->description,
                        'price' => $product->display_price,
                        'image' => $finalPath,
                    ];
                });
            })->toArray();

            $children = $category->children->map(function ($child) use ($childProducts) {
                $childProducts = $child->activeProducts->map(function ($product) {
                    $imagePath = $product->image;
                    if (!$imagePath && $product->images && $product->images->isNotEmpty()) {
                        $imagePath = $product->images->first()->path;
                    }
                    $finalPath = $imagePath
                        ? (str_starts_with($imagePath, 'http') ? $imagePath : "/storage/{$imagePath}")
                        : null;
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'description' => $product->description,
                        'price' => $product->display_price,
                        'image' => $finalPath,
                    ];
                })->toArray();

                return [
                    'id' => $child->id,
                    'title' => $child->title,
                    'products' => $childProducts,
                ];
            })->toArray();

            return [
                'id' => $category->id,
                'title' => $category->title,
                'description' => $category->description,
                'products' => $products,
                'children' => $children,
            ];
        })->toArray();
    }
}
