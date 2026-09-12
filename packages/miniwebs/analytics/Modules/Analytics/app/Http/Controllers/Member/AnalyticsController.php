<?php

namespace Modules\Analytics\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Analytics\Models\AnalyticsSetting;
use Modules\Analytics\Services\AnalyticsQueryService;
use Modules\Listings\Models\Listing;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsQueryService $queryService,
    ) {}

    public function index(Request $request, Listing $listing)
    {
        $this->authorize('viewAny', [AnalyticsSetting::class, $listing]);

        $range = $request->get('range', 'last_7_days');
        $from = $this->getFromDate($range);
        $to = now();

        $kpis = $this->queryService->getKpis($listing, $from, $to);
        $kpiChanges = $this->queryService->getKpisComparison($listing, $from, $to);

        $granularity = $this->getGranularity($range);
        $timeSeries = $this->queryService->getTimeSeries($listing, $from, $to, $granularity);
        $topPages = $this->queryService->getTopPages($listing, $from, $to, 10);
        $trafficSources = $this->queryService->getTrafficSources($listing, $from, $to);
        $topCountries = $this->queryService->getTopCountries($listing, $from, $to, 10);
        $devices = $this->queryService->getDevices($listing, $from, $to);
        $browsers = $this->queryService->getBrowsers($listing, $from, $to, 8);
        $operatingSystems = $this->queryService->getOperatingSystems($listing, $from, $to, 8);
        $topEvents = $this->queryService->getTopEvents($listing, $from, $to, 10);

        return Inertia::render('Member/Analytics/Index', [
            'listing' => $listing,
            'range' => $range,
            'kpis' => $kpis,
            'kpiChanges' => $kpiChanges,
            'timeSeries' => $timeSeries,
            'topPages' => $topPages,
            'trafficSources' => $trafficSources,
            'topCountries' => $topCountries,
            'devices' => $devices,
            'browsers' => $browsers,
            'operatingSystems' => $operatingSystems,
            'topEvents' => $topEvents,
        ]);
    }

    public function data(Request $request, Listing $listing): JsonResponse
    {
        $this->authorize('viewAny', [AnalyticsSetting::class, $listing]);

        $range = $request->get('range', 'last_7_days');
        $from = $this->getFromDate($range);
        $to = now();

        return response()->json([
            'kpis' => $this->queryService->getKpis($listing, $from, $to),
            'kpiChanges' => $this->queryService->getKpisComparison($listing, $from, $to),
            'timeSeries' => $this->queryService->getTimeSeries($listing, $from, $to, $this->getGranularity($range)),
            'topPages' => $this->queryService->getTopPages($listing, $from, $to, 10),
            'trafficSources' => $this->queryService->getTrafficSources($listing, $from, $to),
            'topCountries' => $this->queryService->getTopCountries($listing, $from, $to, 10),
            'devices' => $this->queryService->getDevices($listing, $from, $to),
            'browsers' => $this->queryService->getBrowsers($listing, $from, $to, 8),
            'operatingSystems' => $this->queryService->getOperatingSystems($listing, $from, $to, 8),
            'topEvents' => $this->queryService->getTopEvents($listing, $from, $to, 10),
        ]);
    }

    public function settings(Request $request, Listing $listing)
    {
        $this->authorize('update', [AnalyticsSetting::class, $listing]);

        $setting = AnalyticsSetting::getForListing($listing->id);

        return Inertia::render('Member/Analytics/Settings', [
            'listing' => $listing,
            'setting' => $setting,
        ]);
    }

    public function saveSettings(Request $request, Listing $listing)
    {
        $this->authorize('update', [AnalyticsSetting::class, $listing]);

        $validated = $request->validate([
            'is_enabled' => 'boolean',
            'track_pageviews' => 'boolean',
            'track_events' => 'boolean',
            'track_referrers' => 'boolean',
            'track_utm' => 'boolean',
            'track_device' => 'boolean',
            'track_location' => 'boolean',
            'store_full_ip' => 'boolean',
            'exclude_bots' => 'boolean',
            'session_timeout_minutes' => 'integer|min:5|max:1440',
            'data_retention_months' => 'integer|min:1|max:60',
        ]);

        $setting = AnalyticsSetting::getForListing($listing->id);
        $setting->update($validated);

        return redirect()->back()->with('success', 'Configuración guardada');
    }

    private function getFromDate(string $range): Carbon
    {
        return match ($range) {
            'today' => now()->startOfDay(),
            'yesterday' => now()->subDay()->startOfDay(),
            'last_7_days' => now()->subDays(7)->startOfDay(),
            'last_30_days' => now()->subDays(30)->startOfDay(),
            'this_month' => now()->startOfMonth(),
            'previous_month' => now()->subMonth()->startOfMonth(),
            default => now()->subDays(7)->startOfDay(),
        };
    }

    private function getGranularity(string $range): string
    {
        return match ($range) {
            'today', 'yesterday' => 'hour',
            'last_7_days' => 'day',
            'last_30_days' => 'day',
            'this_month', 'previous_month' => 'week',
            default => 'day',
        };
    }
}
