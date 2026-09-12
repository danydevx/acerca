<?php

namespace Modules\ListingProducts\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingProducts\Models\ListingProductCategory;

class ProductCategoryController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $categories = ListingProductCategory::where('listing_id', $business->id)
            ->with('products')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Admin/BusinessContent/ProductCategoriesIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'categories' => $categories,
        ]);
    }

    public function store(Request $request, Listing $business)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['listing_id'] = $business->id;
        $data['slug'] = ListingProductCategory::generateUniqueSlug($business->id, $data['name']);

        ListingProductCategory::create($data);

        return redirect()->back()
            ->with('success', 'Categoria creada correctamente.');
    }

    public function update(Request $request, Listing $business, ListingProductCategory $category)
    {
        abort_unless($category->listing_id === $business->id, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $category->update($data);

        return redirect()->back()
            ->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingProductCategory $category)
    {
        abort_unless($category->listing_id === $business->id, 404);

        $category->products()->update(['category_id' => null]);

        $category->delete();

        return redirect()->back()
            ->with('success', 'Categoria eliminada. Los productos fueron desvinculados.');
    }
}
