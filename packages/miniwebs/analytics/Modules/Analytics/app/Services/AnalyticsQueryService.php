<?php

namespace Modules\Analytics\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Analytics\Models\AnalyticsEvent;
use Modules\Analytics\Models\AnalyticsPageview;
use Modules\Analytics\Models\AnalyticsSession;
use Modules\Listings\Models\Listing;

class AnalyticsQueryService
{
    public function getKpis(Listing $listing, Carbon $from, Carbon $to): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        $pageviews = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->count();

        $uniqueVisitors = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->distinct('visitor_id')
            ->count('visitor_id');

        $sessions = AnalyticsSession::where('listing_id', $listing->id)
            ->whereBetween('started_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->count();

        $events = AnalyticsEvent::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->count();

        $conversions = AnalyticsEvent::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereIn('event_name', ['contact_form_submit', 'whatsapp_click', 'phone_click', 'appointment_created'])
            ->count();

        $avgPagesPerSession = $sessions > 0 ? round($pageviews / $sessions, 2) : 0;

        return [
            'pageviews' => $pageviews,
            'unique_visitors' => $uniqueVisitors,
            'sessions' => $sessions,
            'events' => $events,
            'conversions' => $conversions,
            'avg_pages_per_session' => $avgPagesPerSession,
        ];
    }

    public function getKpisComparison(Listing $listing, Carbon $from, Carbon $to): array
    {
        $periodDays = $from->diffInDays($to);
        $prevFrom = $from->copy()->subDays($periodDays);
        $prevTo = $from->copy()->subSecond();

        $current = $this->getKpis($listing, $from, $to);
        $previous = $this->getKpis($listing, $prevFrom, $prevTo);

        return [
            'pageviews' => $this->calculateChange($current['pageviews'], $previous['pageviews']),
            'unique_visitors' => $this->calculateChange($current['unique_visitors'], $previous['unique_visitors']),
            'sessions' => $this->calculateChange($current['sessions'], $previous['sessions']),
            'events' => $this->calculateChange($current['events'], $previous['events']),
            'conversions' => $this->calculateChange($current['conversions'], $previous['conversions']),
        ];
    }

    public function getTimeSeries(Listing $listing, Carbon $from, Carbon $to, string $granularity = 'day'): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        $dateFormat = match ($granularity) {
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            default => '%Y-%m-%d',
        };

        $pageviews = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as date"),
                DB::raw('COUNT(*) as pageviews'),
                DB::raw('COUNT(DISTINCT visitor_id) as visitors')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $pageviews->toArray();
    }

    public function getTopPages(Listing $listing, Carbon $from, Carbon $to, int $limit = 10): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->select(
                'path',
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT visitor_id) as visitors')
            )
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTopReferrers(Listing $listing, Carbon $from, Carbon $to, int $limit = 10): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereNotNull('referrer')
            ->select(
                'referrer',
                DB::raw('COUNT(*) as visits'),
                DB::raw('COUNT(DISTINCT visitor_id) as visitors')
            )
            ->groupBy('referrer')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTrafficSources(Listing $listing, Carbon $from, Carbon $to): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        $direct = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->where(fn($q) => $q->whereNull('referrer')->orWhere('referrer', '=', ''))
            ->count();

        $organic = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->where('referrer', 'like', '%google%')
            ->count();

        $social = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->where(function ($q) {
                $q->where('referrer', 'like', '%facebook%')
                    ->orWhere('referrer', 'like', '%instagram%')
                    ->orWhere('referrer', 'like', '%twitter%')
                    ->orWhere('referrer', 'like', '%linkedin%')
                    ->orWhere('referrer', 'like', '%tiktok%');
            })
            ->count();

        $referrals = AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereNotNull('referrer')
            ->where('referrer', 'not like', '%google%')
            ->where(function ($q) {
                $q->where('referrer', 'not like', '%facebook%')
                    ->where('referrer', 'not like', '%instagram%')
                    ->where('referrer', 'not like', '%twitter%')
                    ->where('referrer', 'not like', '%linkedin%')
                    ->where('referrer', 'not like', '%tiktok%');
            })
            ->count();

        return [
            ['source' => 'Direct', 'visits' => $direct],
            ['source' => 'Organic Search', 'visits' => $organic],
            ['source' => 'Social', 'visits' => $social],
            ['source' => 'Referrals', 'visits' => $referrals],
        ];
    }

    public function getTopCountries(Listing $listing, Carbon $from, Carbon $to, int $limit = 10): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereNotNull('country_code')
            ->select(
                'country',
                'country_code',
                DB::raw('COUNT(*) as visitors'),
                DB::raw('COUNT(DISTINCT visitor_id) as unique_visitors')
            )
            ->groupBy('country', 'country_code')
            ->orderByDesc('visitors')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getDevices(Listing $listing, Carbon $from, Carbon $to): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereNotNull('device_type')
            ->select('device_type', DB::raw('COUNT(*) as visits'))
            ->groupBy('device_type')
            ->get()
            ->toArray();
    }

    public function getBrowsers(Listing $listing, Carbon $from, Carbon $to): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereNotNull('browser')
            ->select('browser', DB::raw('COUNT(*) as visits'))
            ->groupBy('browser')
            ->orderByDesc('visits')
            ->limit(8)
            ->get()
            ->toArray();
    }

    public function getOperatingSystems(Listing $listing, Carbon $from, Carbon $to): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsPageview::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->whereNotNull('os')
            ->select('os', DB::raw('COUNT(*) as visits'))
            ->groupBy('os')
            ->orderByDesc('visits')
            ->limit(8)
            ->get()
            ->toArray();
    }

    public function getTopEvents(Listing $listing, Carbon $from, Carbon $to, int $limit = 10): array
    {
        $excludeBots = $this->getExcludeBotsCondition($listing);

        return AnalyticsEvent::where('listing_id', $listing->id)
            ->whereBetween('created_at', [$from, $to])
            ->when($excludeBots, fn($q) => $q->where('is_bot', false))
            ->select(
                'event_name',
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT visitor_id) as unique_visitors')
            )
            ->groupBy('event_name')
            ->orderByDesc('total')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    private function calculateChange(int $current, int $previous): array
    {
        if ($previous == 0) {
            return [
                'value' => $current,
                'change' => $current > 0 ? 100 : 0,
                'direction' => $current > 0 ? 'up' : 'neutral',
            ];
        }

        $change = round((($current - $previous) / $previous) * 100, 1);
        return [
            'value' => $current,
            'change' => abs($change),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'neutral'),
        ];
    }

    private function getExcludeBotsCondition(Listing $listing): bool
    {
        $setting = $listing->analyticsSetting ?? null;
        return $setting ? $setting->shouldExcludeBots() : true;
    }
}
