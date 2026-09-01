<?php

namespace Modules\ListingAiChatbot\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\ListingAiChatbot\Models\ChatbotPersonality;
use Inertia\Inertia;

class ChatbotPersonalityController extends Controller
{
    public function index(Request $request, \Modules\Listings\Models\Listing $business)
    {
        abort_unless($business->user_id === Auth::id() || Auth::user()->hasRole('superadmin'), 403);

        $personalities = ChatbotPersonality::forListing($business->id)
            ->orWhereNull('listing_id')
            ->sorted()
            ->get();

        $businessPersonalities = $personalities->where('listing_id', $business->id);
        $globalPersonalities = $personalities->whereNull('listing_id');

        return Inertia::render('Member/AiChatbot/Personalities/Index', [
            'listing' => $business,
            'businessPersonalities' => $businessPersonalities->values(),
            'globalPersonalities' => $globalPersonalities->values(),
        ]);
    }

    public function create(Request $request, \Modules\Listings\Models\Listing $business)
    {
        abort_unless($business->user_id === Auth::id() || Auth::user()->hasRole('superadmin'), 403);

        return Inertia::render('Member/AiChatbot/Personalities/Create', [
            'listing' => $business,
        ]);
    }

    public function store(Request $request, \Modules\Listings\Models\Listing $business)
    {
        abort_unless($business->user_id === Auth::id() || Auth::user()->hasRole('superadmin'), 403);

        $validated = $request->validate([
            'key' => 'required|string|max:50',
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'system_prompt_hint' => 'nullable|string',
            'default_temperature' => 'nullable|numeric|min:0|max:1',
            'default_response_length' => 'nullable|in:short,medium,long',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (ChatbotPersonality::keyExists($validated['key'], null, $business->id)) {
            return redirect()->back()->withErrors(['key' => 'Esta key ya existe para tu negocio.']);
        }

        ChatbotPersonality::create(array_merge($validated, [
            'listing_id' => $business->id,
            'is_active' => $validated['is_active'] ?? true,
        ]));

        return redirect()->route('member.listings.listing-aichatbot.personalities.index', [$business])
            ->with('success', 'Personalidad creada exitosamente.');
    }

    public function edit(Request $request, \Modules\Listings\Models\Listing $business, ChatbotPersonality $personality)
    {
        abort_unless($business->user_id === Auth::id() || Auth::user()->hasRole('superadmin'), 403);
        abort_unless($personality->listing_id === $business->id, 403, 'No tienes acceso a esta personalidad.');

        return Inertia::render('Member/AiChatbot/Personalities/Edit', [
            'listing' => $business,
            'personality' => $personality,
        ]);
    }

    public function update(Request $request, \Modules\Listings\Models\Listing $business, ChatbotPersonality $personality)
    {
        abort_unless($business->user_id === Auth::id() || Auth::user()->hasRole('superadmin'), 403);
        abort_unless($personality->listing_id === $business->id, 403, 'No tienes acceso a esta personalidad.');

        $validated = $request->validate([
            'key' => 'required|string|max:50',
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'system_prompt_hint' => 'nullable|string',
            'default_temperature' => 'nullable|numeric|min:0|max:1',
            'default_response_length' => 'nullable|in:short,medium,long',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (ChatbotPersonality::keyExists($validated['key'], $personality->id, $business->id)) {
            return redirect()->back()->withErrors(['key' => 'Esta key ya existe para tu negocio.']);
        }

        $personality->update($validated);

        return redirect()->back()->with('success', 'Personalidad actualizada.');
    }

    public function destroy(Request $request, \Modules\Listings\Models\Listing $business, ChatbotPersonality $personality)
    {
        abort_unless($business->user_id === Auth::id() || Auth::user()->hasRole('superadmin'), 403);
        abort_unless($personality->listing_id === $business->id, 403, 'No tienes acceso a esta personalidad.');

        $personality->delete();

        return redirect()->route('member.listings.listing-aichatbot.personalities.index', [$business])
            ->with('success', 'Personalidad eliminada.');
    }
}
