<?php

namespace Modules\VCards\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\VCards\Models\VCard;
use Modules\VCards\Models\VCardVisit;
use Modules\VCards\Services\VCardVisitService;

class VCardVisitController extends Controller
{
    private VCardVisitService $visitService;

    public function __construct()
    {
        $this->visitService = new VCardVisitService();
    }

    public function index(Request $request, Listing $listing, VCard $vcard)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($vcard->listing_id === $listing->id, 403);

        $range = $request->get('range', '7d');
        [$from, $to] = $this->getDateRange($range);

        $stats = $this->visitService->getStats($vcard, $from, $to);
        $timeSeries = $this->visitService->getTimeSeries($vcard, $from, $to);
        $topCountries = $this->visitService->getTopCountries($vcard, $from, $to);
        $topDevices = $this->visitService->getTopDevices($vcard, $from, $to);
        $topBrowsers = $this->visitService->getTopBrowsers($vcard, $from, $to);
        $topOs = $this->visitService->getTopOperatingSystems($vcard, $from, $to);
        $recentVisits = $this->visitService->getRecent($vcard, 20);

        $totalVisits = $stats['total'];
        $uniqueVisitors = $stats['unique_visitors'];
        $countriesCount = $stats['countries'];

        $deviceTypes = [];
        foreach ($stats['devices'] as $type => $count) {
            $deviceTypes[] = [
                'device_type' => $type,
                'visits' => $count,
                'percentage' => $totalVisits > 0 ? round(($count / $totalVisits) * 100) : 0,
            ];
        }

        return Inertia::render('Member/VCards/VisitsDashboard', [
            'listing' => [
                'id' => $listing->id,
                'name' => $listing->name,
            ],
            'vcard' => [
                'id' => $vcard->id,
                'name' => $vcard->name,
                'slug' => $vcard->slug,
                'track_visits' => $vcard->track_visits,
                'store_ip_hash' => $vcard->store_ip_hash,
            ],
            'range' => $range,
            'stats' => [
                'total' => $totalVisits,
                'unique' => $uniqueVisitors,
                'countries' => $countriesCount,
                'devices' => $deviceTypes,
            ],
            'timeSeries' => $timeSeries,
            'topCountries' => $topCountries,
            'topDevices' => $topDevices,
            'topBrowsers' => $topBrowsers,
            'topOs' => $topOs,
            'recentVisits' => $recentVisits,
        ]);
    }

    public function data(Request $request, Listing $listing, VCard $vcard)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($vcard->listing_id === $listing->id, 403);

        $range = $request->get('range', '7d');
        [$from, $to] = $this->getDateRange($range);

        $stats = $this->visitService->getStats($vcard, $from, $to);
        $timeSeries = $this->visitService->getTimeSeries($vcard, $from, $to);
        $topCountries = $this->visitService->getTopCountries($vcard, $from, $to);
        $topDevices = $this->visitService->getTopDevices($vcard, $from, $to);
        $topBrowsers = $this->visitService->getTopBrowsers($vcard, $from, $to);
        $topOs = $this->visitService->getTopOperatingSystems($vcard, $from, $to);
        $recentVisits = $this->visitService->getRecent($vcard, 20);

        $totalVisits = $stats['total'];
        $deviceTypes = [];
        foreach ($stats['devices'] as $type => $count) {
            $deviceTypes[] = [
                'device_type' => $type,
                'visits' => $count,
                'percentage' => $totalVisits > 0 ? round(($count / $totalVisits) * 100) : 0,
            ];
        }

        return response()->json([
            'stats' => [
                'total' => $totalVisits,
                'unique' => $stats['unique_visitors'],
                'countries' => $stats['countries'],
                'devices' => $deviceTypes,
            ],
            'timeSeries' => $timeSeries,
            'topCountries' => $topCountries,
            'topDevices' => $topDevices,
            'topBrowsers' => $topBrowsers,
            'topOs' => $topOs,
            'recentVisits' => $recentVisits,
        ]);
    }

    public function destroy(Request $request, Listing $listing, VCard $vcard, VCardVisit $visit)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($vcard->listing_id === $listing->id, 403);
        abort_unless($visit->vcard_id === $vcard->id, 403);

        $visit->delete();

        return redirect()->back()->with('success', 'Visita eliminada.');
    }

    public function clear(Request $request, Listing $listing, VCard $vcard)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($vcard->listing_id === $listing->id, 403);

        $count = $this->visitService->clearAll($vcard);

        return redirect()->back()->with('success', "{$count} visitas eliminadas.");
    }

    public function updateSettings(Request $request, Listing $listing, VCard $vcard)
    {
        abort_unless($listing->user_id === Auth::id(), 403);
        abort_unless($vcard->listing_id === $listing->id, 403);

        $validated = $request->validate([
            'track_visits' => ['boolean'],
            'store_ip_hash' => ['boolean'],
            'retention_days' => ['integer', 'min:1', 'max:3650'],
        ]);

        $vcard->update($validated);

        return redirect()->back()->with('success', 'Configuración actualizada.');
    }

    private function getDateRange(string $range): array
    {
        $to = Carbon::now()->endOfDay();

        switch ($range) {
            case 'today':
                $from = Carbon::today();
                break;
            case '7d':
                $from = Carbon::now()->subDays(7);
                break;
            case '30d':
                $from = Carbon::now()->subDays(30);
                break;
            case '90d':
                $from = Carbon::now()->subDays(90);
                break;
            case 'all':
                $from = Carbon::createFromDate(2020, 1, 1);
                break;
            default:
                $from = Carbon::now()->subDays(7);
        }

        return [$from, $to];
    }
}
