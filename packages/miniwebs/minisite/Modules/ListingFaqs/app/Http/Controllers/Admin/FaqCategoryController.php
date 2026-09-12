<?php

namespace Modules\ListingFaqs\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingFaqs\Models\ListingFaqCategory;

class FaqCategoryController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $categories = ListingFaqCategory::where('listing_id', $business->id)
            ->with('faqs')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Admin/BusinessContent/FaqCategoriesIndex', [
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
        $data['slug'] = ListingFaqCategory::generateUniqueSlug($business->id, $data['name']);

        ListingFaqCategory::create($data);

        return redirect()->back()
            ->with('success', 'Categoria creada correctamente.');
    }

    public function update(Request $request, Listing $business, ListingFaqCategory $category)
    {
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

    public function destroy(Request $request, Listing $business, ListingFaqCategory $category)
    {
        $category->faqs()->update(['category_id' => null]);

        $category->delete();

        return redirect()->back()
            ->with('success', 'Categoria eliminada. Las preguntas fueron desvinculadas.');
    }
}
