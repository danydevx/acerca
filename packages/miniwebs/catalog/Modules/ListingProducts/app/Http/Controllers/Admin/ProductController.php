<?php

namespace Modules\ListingProducts\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingProducts\Models\ListingProduct;
use Modules\ListingProducts\Models\ListingProductCategory;

class ProductController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $products = $business->products()
            ->with('location')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return Inertia::render('Admin/BusinessContent/ProductsIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'products' => $products,
        ]);
    }

    public function create(Request $request, Listing $business)
    {
        $locations = $business->locations()->where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $categories = ListingProductCategory::where('listing_id', $business->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/BusinessContent/ProductsCreate', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'locations' => $locations,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'show_price' => ['boolean'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'barcode' => ['nullable', 'string', 'max:100'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'whatsapp_contact' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'business_location_id' => ['nullable', 'exists:listing_locations,id'],
            'category_id' => ['nullable', 'exists:listing_product_categories,id'],
        ]);

        $data['listing_id'] = $business->id;
        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        if (isset($data['business_location_id']) && $data['business_location_id'] === '') {
            $data['business_location_id'] = null;
        }
        if (isset($data['category_id']) && $data['category_id'] === '') {
            $data['category_id'] = null;
        }

        $product = $business->products()->create($data);

        $activity->log('admin_product_created', [
            'actor' => $request->user(),
            'subject' => $product,
            'description' => 'Admin: Producto creado',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.products.index', $business->id)
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Request $request, Listing $business, ListingProduct $product)
    {
        $locations = $business->locations()->where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $categories = ListingProductCategory::where('listing_id', $business->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/BusinessContent/ProductsEdit', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'show_price' => $product->show_price,
                'compare_at_price' => $product->compare_at_price,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'quantity' => $product->quantity,
                'is_active' => $product->is_active,
                'is_featured' => $product->is_featured,
                'whatsapp_contact' => $product->whatsapp_contact,
                'sort_order' => $product->sort_order,
                'business_location_id' => $product->business_location_id,
                'category_id' => $product->category_id,
            ],
            'locations' => $locations,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Listing $business, ListingProduct $product, ActivityService $activity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'show_price' => ['boolean'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'barcode' => ['nullable', 'string', 'max:100'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'whatsapp_contact' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'business_location_id' => ['nullable', 'exists:listing_locations,id'],
            'category_id' => ['nullable', 'exists:listing_product_categories,id'],
        ]);

        if (isset($data['business_location_id']) && $data['business_location_id'] === '') {
            $data['business_location_id'] = null;
        }
        if (isset($data['category_id']) && $data['category_id'] === '') {
            $data['category_id'] = null;
        }

        $product->update($data);

        $activity->log('admin_product_updated', [
            'actor' => $request->user(),
            'subject' => $product,
            'description' => 'Admin: Producto actualizado',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.products.index', $business->id)
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingProduct $product, ActivityService $activity)
    {
        $activity->log('admin_product_deleted', [
            'actor' => $request->user(),
            'subject' => $product,
            'description' => 'Admin: Producto eliminado',
        ]);

        $product->delete();

        return redirect()->route('admin.business.products.index', $business->id)
            ->with('success', 'Producto eliminado correctamente.');
    }
}
