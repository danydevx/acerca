<?php

namespace Modules\VCards\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\ListingAiChatbot\Services\GeoLocationService;
use Modules\VCards\Models\VCard;
use Modules\VCards\Models\VCardVisit;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class VCardVisitService
{
    private GeoLocationService $geoService;

    public function __construct()
    {
        $this->geoService = new GeoLocationService();
    }

    public function record(VCard $vcard, Request $request): void
    {
        if (!$vcard->track_visits) {
            return;
        }

        $ip = $request->ip();
        $userAgent = $request->userAgent() ?? '';
        $deviceInfo = $this->parseDeviceInfo($userAgent);
        $geoInfo = $this->getGeoInfo($ip);

        $data = [
            'vcard_id' => $vcard->id,
            'country_code' => $geoInfo['country_code'],
            'country' => $geoInfo['country'],
            'city' => $geoInfo['city'],
            'browser' => $deviceInfo['browser'],
            'browser_version' => $deviceInfo['browser_version'],
            'os' => $deviceInfo['os'],
            'device_type' => $deviceInfo['device_type'],
            'language' => $this->getLanguage($request),
            'screen_width' => $request->integer('screen_width'),
            'screen_height' => $request->integer('screen_height'),
            'user_agent' => substr($userAgent, 0, 500),
            'visited_at' => now(),
        ];

        if ($vcard->store_ip_hash && $ip) {
            $data['ip_hash'] = $this->hashIp($ip);
        } elseif ($ip) {
            $data['ip_hash'] = $this->hashIp($ip);
        }

        VCardVisit::create($data);
    }

    public function getStats(VCard $vcard, Carbon $from, Carbon $to): array
    {
        $query = VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to]);

        $total = $query->count();
        $uniqueIps = $query->distinct('ip_hash')->count('ip_hash');
        $uniqueCountries = $query->distinct('country_code')->whereNotNull('country_code')->count('country_code');

        $devices = VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to])
            ->selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->toArray();

        return [
            'total' => $total,
            'unique_visitors' => $uniqueIps,
            'countries' => $uniqueCountries,
            'devices' => $devices,
        ];
    }

    public function getTimeSeries(VCard $vcard, Carbon $from, Carbon $to): array
    {
        $visits = VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to])
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as visits, COUNT(DISTINCT ip_hash) as visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return $visits->map(fn($v) => [
            'date' => $v->date,
            'visits' => $v->visits,
            'visitors' => $v->visitors,
        ])->toArray();
    }

    public function getTopCountries(VCard $vcard, Carbon $from, Carbon $to, int $limit = 10): array
    {
        return VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to])
            ->whereNotNull('country_code')
            ->selectRaw('country_code, country, COUNT(*) as visitors')
            ->groupBy('country_code', 'country')
            ->orderByDesc('visitors')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTopDevices(VCard $vcard, Carbon $from, Carbon $to): array
    {
        return VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to])
            ->whereNotNull('device_type')
            ->selectRaw('device_type, COUNT(*) as visits')
            ->groupBy('device_type')
            ->orderByDesc('visits')
            ->get()
            ->toArray();
    }

    public function getTopBrowsers(VCard $vcard, Carbon $from, Carbon $to, int $limit = 6): array
    {
        return VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to])
            ->whereNotNull('browser')
            ->selectRaw('browser, COUNT(*) as visits')
            ->groupBy('browser')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getTopOperatingSystems(VCard $vcard, Carbon $from, Carbon $to, int $limit = 6): array
    {
        return VCardVisit::forVcard($vcard->id)
            ->whereBetween('visited_at', [$from, $to])
            ->whereNotNull('os')
            ->selectRaw('os, COUNT(*) as visits')
            ->groupBy('os')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function getRecent(VCard $vcard, int $limit = 20): array
    {
        return VCardVisit::forVcard($vcard->id)
            ->orderByDesc('visited_at')
            ->limit($limit)
            ->get()
            ->map(fn($v) => [
                'id' => $v->id,
                'country' => $v->country,
                'country_code' => $v->country_code,
                'browser' => $v->browser,
                'device_type' => $v->device_type,
                'visited_at' => $v->visited_at->toIso8601String(),
            ])
            ->toArray();
    }

    public function clearAll(VCard $vcard): int
    {
        return VCardVisit::forVcard($vcard->id)->delete();
    }

    public function cleanupOldVisits(int $olderThanDays): int
    {
        return VCardVisit::olderThan($olderThanDays)->delete();
    }

    private function parseDeviceInfo(string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'browser' => 'Unknown',
                'browser_version' => null,
                'os' => 'Unknown',
                'device_type' => 'other',
            ];
        }

        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);
        $platform = $agent->platform();

        $deviceType = 'other';
        if ($agent->isDesktop()) {
            $deviceType = 'desktop';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        } elseif ($agent->isMobile()) {
            $deviceType = 'mobile';
        }

        return [
            'browser' => $browser ?: 'Unknown',
            'browser_version' => $browserVersion ?: null,
            'os' => $platform ?: 'Unknown',
            'device_type' => $deviceType,
        ];
    }

    private function getGeoInfo(?string $ip): array
    {
        if (!$ip || $this->isLocalIp($ip)) {
            return [
                'country_code' => null,
                'country' => null,
                'city' => null,
            ];
        }

        $cacheKey = "vcard_geo:{$ip}";
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        $result = $this->geoService->resolve($ip);

        Cache::put($cacheKey, $result, 60 * 60 * 24 * 30);

        return $result;
    }

    private function isLocalIp(string $ip): bool
    {
        return in_array($ip, ['127.0.0.1', '::1', 'localhost']) ||
               str_starts_with($ip, '192.168.') ||
               str_starts_with($ip, '10.') ||
               str_starts_with($ip, '172.16.');
    }

    private function hashIp(string $ip): string
    {
        $salt = config('app.key', 'default-salt');
        return hash('sha256', $ip . $salt);
    }

    private function getLanguage(Request $request): ?string
    {
        $lang = $request->header('Accept-Language');
        if (!$lang) {
            return null;
        }
        $parts = explode(',', $lang);
        return $parts[0] ?? null;
    }
}
