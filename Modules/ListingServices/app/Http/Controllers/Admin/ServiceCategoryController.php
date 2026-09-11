<?php

namespace Modules\ListingServices\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingServices\Models\ListingServiceCategory;

class ServiceCategoryController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $categories = ListingServiceCategory::where('listing_id', $business->id)
            ->with('services')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Admin/BusinessContent/ServiceCategoriesIndex', [
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
        $data['slug'] = ListingServiceCategory::generateUniqueSlug($business->id, $data['name']);

        ListingServiceCategory::create($data);

        return redirect()->back()
            ->with('success', 'Categoria creada correctamente.');
    }

    public function update(Request $request, Listing $business, ListingServiceCategory $category)
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

    public function destroy(Request $request, Listing $business, ListingServiceCategory $category)
    {
        abort_unless($category->listing_id === $business->id, 404);

        $category->services()->update(['category_id' => null]);

        $category->delete();

        return redirect()->back()
            ->with('success', 'Categoria eliminada. Los servicios fueron desvinculados.');
    }
}
