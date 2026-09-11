<?php

namespace Modules\ListingFaqs\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingFaqs\Models\ListingFaq;

class FaqController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $faqs = $business->faqs()
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('question')
            ->paginate(20);

        return Inertia::render('Admin/BusinessContent/FaqsIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'faqs' => $faqs,
        ]);
    }

    public function create(Request $request, Listing $business)
    {
        $categories = \Modules\ListingFaqs\Models\ListingFaqCategory::where('listing_id', $business->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/BusinessContent/FaqsCreate', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'categories' => $categories,
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:listing_faq_categories,id'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['listing_id'] = $business->id;

        $faq = ListingFaq::create($data);

        $activity->log('admin_faq_created', [
            'actor' => $request->user(),
            'subject' => $faq,
            'description' => 'Admin: Pregunta frecuente creada',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.faqs.index', $business->id)
            ->with('success', 'Pregunta frecuente creada correctamente.');
    }

    public function edit(Request $request, Listing $business, ListingFaq $faq)
    {
        $categories = \Modules\ListingFaqs\Models\ListingFaqCategory::where('listing_id', $business->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/BusinessContent/FaqsEdit', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'faq' => [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
                'category_id' => $faq->category_id,
                'is_active' => $faq->is_active,
                'sort_order' => $faq->sort_order,
            ],
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Listing $business, ListingFaq $faq, ActivityService $activity)
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'category_id' => ['nullable', 'exists:listing_faq_categories,id'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $faq->update($data);

        $activity->log('admin_faq_updated', [
            'actor' => $request->user(),
            'subject' => $faq,
            'description' => 'Admin: Pregunta frecuente actualizada',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.faqs.index', $business->id)
            ->with('success', 'Pregunta frecuente actualizada correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingFaq $faq, ActivityService $activity)
    {
        $activity->log('admin_faq_deleted', [
            'actor' => $request->user(),
            'subject' => $faq,
            'description' => 'Admin: Pregunta frecuente eliminada',
        ]);

        $faq->delete();

        return redirect()->route('admin.business.faqs.index', $business->id)
            ->with('success', 'Pregunta frecuente eliminada correctamente.');
    }
}
