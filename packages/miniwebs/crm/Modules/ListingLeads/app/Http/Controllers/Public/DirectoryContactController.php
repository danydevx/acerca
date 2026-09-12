<?php

namespace Modules\ListingLeads\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Listings\Models\Listing;
use Modules\ListingLeads\Models\ListingLead;

class DirectoryContactController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $lead = ListingLead::create([
            'listing_id' => $business->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'notes' => $data['message'],
            'source' => 'directory',
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }
}