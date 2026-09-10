<?php

namespace Modules\ClientFidelity\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ClientFidelity\Models\FidelityReward;

class FidelityRewardController extends Controller
{
    public function index(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === Auth::id(), 403);

        $perPage = min((int) $request->get('per_page', 10), 100);
        $search = $request->get('search', '');

        $query = FidelityReward::where('listing_id', $listing->id)
            ->withCount('cards')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->sorted();

        $rewards = $query->paginate($perPage);

        $dataTable = [
            'data' => collect($rewards->items())->map(fn ($r) => [
                'id' => $r->id,
                'title' => $r->title,
                'description' => $r->description,
                'image' => $r->image,
                'max_visits' => $r->max_visits,
                'is_active' => $r->is_active,
                'cards_count' => $r->cards_count,
                'created_at' => $r->created_at->toDateTimeString(),
            ])->toArray(),
            'current_page' => $rewards->currentPage(),
            'last_page' => $rewards->lastPage(),
            'per_page' => $rewards->perPage(),
            'total' => $rewards->total(),
            'from' => $rewards->firstItem(),
            'to' => $rewards->lastItem(),
        ];

        return Inertia::render('Member/ClientFidelity/Rewards/Index', [
            'listing' => [
                'id' => $listing->id,
                'name' => $listing->name,
            ],
            'dataTable' => $dataTable,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function apiIndex(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === Auth::id(), 403);

        $perPage = min((int) $request->get('per_page', 10), 100);
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $query = FidelityReward::where('listing_id', $listing->id)
            ->withCount('cards')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->sorted();

        $rewards = $query->paginate($perPage);

        return response()->json([
            'data' => collect($rewards->items())->map(fn ($r) => [
                'id' => $r->id,
                'title' => $r->title,
                'description' => $r->description,
                'image' => $r->image,
                'max_visits' => $r->max_visits,
                'is_active' => $r->is_active,
                'cards_count' => $r->cards_count,
                'created_at' => $r->created_at->toDateTimeString(),
            ]),
            'current_page' => $rewards->currentPage(),
            'last_page' => $rewards->lastPage(),
            'per_page' => $rewards->perPage(),
            'total' => $rewards->total(),
            'from' => $rewards->firstItem(),
            'to' => $rewards->lastItem(),
        ]);
    }

    public function create(Listing $listing)
    {
        abort_unless($listing->user_id === Auth::id(), 403);

        return Inertia::render('Member/ClientFidelity/Rewards/Create', [
            'listing' => $listing,
        ]);
    }

    public function store(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === Auth::id(), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'max_visits' => ['required', 'integer', 'min:2', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if (isset($data['image'])) {
            $path = $data['image']->store('fidelity-rewards', 'public');
            $data['image'] = $path;
        }

        $data['listing_id'] = $listing->id;

        if (!isset($data['sort_order'])) {
            $data['sort_order'] = FidelityReward::where('listing_id', $listing->id)->max('sort_order') + 1;
        }

        $reward = FidelityReward::create($data);

        return redirect()->route('member.listings.fidelity-rewards.index', $listing->id)
            ->with('success', 'Recompensa creada correctamente.');
    }

    public function edit(Listing $listing, FidelityReward $reward)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($reward->listing_id === $listing->id, 403);

        return Inertia::render('Member/ClientFidelity/Rewards/Edit', [
            'listing' => $listing,
            'reward' => $reward,
        ]);
    }

    public function update(Request $request, Listing $listing, FidelityReward $reward)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($reward->listing_id === $listing->id, 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'max_visits' => ['required', 'integer', 'min:2', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
            'remove_image' => ['boolean'],
        ]);

        if (isset($data['remove_image']) && $data['remove_image']) {
            if ($reward->image) {
                Storage::disk('public')->delete($reward->image);
            }
            $data['image'] = null;
            unset($data['remove_image']);
        }

        if (isset($data['image'])) {
            if ($reward->image) {
                Storage::disk('public')->delete($reward->image);
            }
            $path = $data['image']->store('fidelity-rewards', 'public');
            $data['image'] = $path;
        }

        $reward->update($data);

        return redirect()->back()->with('success', 'Recompensa actualizada correctamente.');
    }

    public function bulkDelete(Request $request, Listing $listing)
    {
        abort_unless($listing->user_id === Auth::id(), 403);

        $ids = $request->input('ids', []);
        $rewards = FidelityReward::where('listing_id', $listing->id)
            ->whereIn('id', $ids)
            ->get();

        foreach ($rewards as $reward) {
            if (!$reward->cards()->exists()) {
                if ($reward->image) {
                    Storage::disk('public')->delete($reward->image);
                }
                $reward->delete();
            }
        }

        return redirect()->back()->with('success', 'Recompensas eliminadas.');
    }

    public function destroy(Listing $listing, FidelityReward $reward)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($reward->listing_id === $listing->id, 403);

        if ($reward->cards()->exists()) {
            return redirect()->back()->with('error', 'No se puede eliminar una recompensa que tiene tarjetas asociadas.');
        }

        if ($reward->image) {
            Storage::disk('public')->delete($reward->image);
        }

        $reward->delete();

        return redirect()->route('member.listings.fidelity-rewards.index', $listing->id)
            ->with('success', 'Recompensa eliminada correctamente.');
    }
}
