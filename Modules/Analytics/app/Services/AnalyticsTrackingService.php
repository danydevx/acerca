<?php

namespace Modules\Analytics\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Analytics\Models\AnalyticsEvent;
use Modules\Analytics\Models\AnalyticsPageview;
use Modules\Analytics\Models\AnalyticsSession;
use Modules\Analytics\Models\AnalyticsSetting;
use Modules\Analytics\Models\AnalyticsVisitor;
use Modules\Listings\Models\Listing;
use Modules\ListingAiChatbot\Services\GeoLocationService;

class AnalyticsTrackingService
{
    private const IP_SALT = 'analytics_ip_hash_salt_v1';

    public function __construct(
        private AnalyticsCookieService $cookieService,
        private AnalyticsDeviceService $deviceService,
    ) {}

    public function trackPageview(Request $request, Listing $listing): void
    {
        try {
            $setting = AnalyticsSetting::getForListing($listing->id);

            if (!$setting->shouldTrackPageviews()) {
                return;
            }

            $isBot = $this->deviceService->isBotFromRequest($request);
            if ($isBot && $setting->shouldExcludeBots()) {
                return;
            }

            $visitorId = $this->cookieService->getVisitorId($request);
            $sessionId = $this->cookieService->getSessionId($request) ?? $this->cookieService->createSessionId();

            $visitor = AnalyticsVisitor::findOrCreateByCookie(
                $visitorId,
                $listing->id,
                $request->userAgent() ?? '',
                $isBot
            );

            $sessionData = $this->buildSessionData($request, $setting);
            $session = AnalyticsSession::findValidOrCreate($sessionId, $visitor, $listing->id, $sessionData);

            $geoData = [];
            if ($setting->track_location) {
                $geoData = $this->resolveGeoData($request);
            }

            $ipData = $this->resolveIpData($request, $setting);

            AnalyticsPageview::create([
                'visitor_id' => $visitor->id,
                'session_id' => $session->id,
                'listing_id' => $listing->id,
                'url' => $this->truncate($request->input('url'), 2000),
                'path' => $this->truncate($request->input('path', '/'), 500),
                'query_string' => $request->input('query_string') ? $this->truncate($request->input('query_string'), 1000) : null,
                'page_title' => $request->input('page_title') ? $this->truncate($request->input('page_title'), 500) : null,
                'referrer' => $request->input('referrer') ? $this->truncate($request->input('referrer'), 2000) : null,
                'ip_address' => $setting->shouldStoreFullIp() ? $request->ip() : null,
                'ip_hash' => $this->hashIp($request->ip() ?? ''),
                'country' => $geoData['country'] ?? null,
                'country_code' => $geoData['country_code'] ?? null,
                'region' => $geoData['region'] ?? null,
                'city' => $geoData['city'] ?? null,
                'timezone' => $geoData['timezone'] ?? null,
                'latitude' => $geoData['latitude'] ?? null,
                'longitude' => $geoData['longitude'] ?? null,
                'user_agent' => $this->truncate($request->userAgent(), 500),
                'browser' => $sessionData['browser'] ?? null,
                'browser_version' => null,
                'os' => $sessionData['os'] ?? null,
                'device_type' => $sessionData['device_type'] ?? null,
                'language' => $this->deviceService->getLanguage($request),
                'screen_width' => $request->input('screen_width') ? (int) $request->input('screen_width') : null,
                'screen_height' => $request->input('screen_height') ? (int) $request->input('screen_height') : null,
                'utm_source' => $setting->track_utm ? $request->input('utm_source') : null,
                'utm_medium' => $setting->track_utm ? $request->input('utm_medium') : null,
                'utm_campaign' => $setting->track_utm ? $request->input('utm_campaign') : null,
                'utm_term' => $setting->track_utm ? $request->input('utm_term') : null,
                'utm_content' => $setting->track_utm ? $request->input('utm_content') : null,
                'is_bot' => $isBot,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Analytics tracking error: ' . $e->getMessage());
        }
    }

    public function trackEvent(Request $request, Listing $listing, string $eventName, array $metadata = []): void
    {
        try {
            $setting = AnalyticsSetting::getForListing($listing->id);

            if (!$setting->shouldTrackEvents()) {
                return;
            }

            $isBot = $this->deviceService->isBotFromRequest($request);
            if ($isBot && $setting->shouldExcludeBots()) {
                return;
            }

            $visitorId = $this->cookieService->getVisitorId($request);
            $sessionId = $this->cookieService->getSessionId($request) ?? $this->cookieService->createSessionId();

            $visitor = AnalyticsVisitor::findOrCreateByCookie(
                $visitorId,
                $listing->id,
                $request->userAgent() ?? '',
                $isBot
            );

            $sessionData = $this->buildSessionData($request, $setting);
            $session = AnalyticsSession::findValidOrCreate($sessionId, $visitor, $listing->id, $sessionData);

            AnalyticsEvent::create([
                'visitor_id' => $visitor->id,
                'session_id' => $session->id,
                'listing_id' => $listing->id,
                'event_name' => $this->truncate($eventName, 100),
                'event_category' => $this->extractEventCategory($eventName),
                'url' => $request->input('url') ? $this->truncate($request->input('url'), 2000) : null,
                'path' => $request->input('path') ? $this->truncate($request->input('path'), 500) : null,
                'metadata' => $this->sanitizeMetadata($metadata),
                'is_bot' => $isBot,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Analytics event tracking error: ' . $e->getMessage());
        }
    }

    public function resolveListingFromRequest(Request $request): ?Listing
    {
        $path = $request->input('path', '/');

        $patterns = [
            '/^\/b\/([a-z0-9-]+)/i',
            '/^\/v\/([a-z0-9-]+)/i',
            '/^\/m\/([a-z0-9-]+)/i',
            '/^\/p\/([a-z0-9-]+)/i',
            '/^\/listing\/([a-z0-9-]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $path, $matches)) {
                $slug = $matches[1];
                $listing = Listing::where('slug', $slug)->first();
                if ($listing) {
                    return $listing;
                }
            }
        }

        return null;
    }

    private function buildSessionData(Request $request, AnalyticsSetting $setting): array
    {
        $data = [];

        if ($setting->track_device) {
            $deviceInfo = $this->deviceService->parseFromRequest($request);
            $data['device_type'] = $deviceInfo['device_type'];
            $data['browser'] = $deviceInfo['browser'];
            $data['os'] = $deviceInfo['os'];
        }

        if ($setting->track_location) {
            $geoData = $this->resolveGeoData($request);
            $data['country_code'] = $geoData['country_code'] ?? null;
        }

        if ($setting->track_referrers) {
            $data['referrer'] = $request->input('referrer');
        }

        if ($setting->track_utm) {
            $data['utm_source'] = $request->input('utm_source');
            $data['utm_medium'] = $request->input('utm_medium');
            $data['utm_campaign'] = $request->input('utm_campaign');
        }

        return $data;
    }

    private function resolveGeoData(Request $request): array
    {
        try {
            $geoService = new GeoLocationService();
            $ip = $request->ip();
            if (!$ip || $this->isLocalIp($ip)) {
                return [];
            }
            return $geoService->resolve($ip);
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function resolveIpData(Request $request, AnalyticsSetting $setting): array
    {
        $ip = $request->ip();
        return [
            'ip_address' => $setting->shouldStoreFullIp() ? $ip : null,
            'ip_hash' => $this->hashIp($ip ?? ''),
        ];
    }

    public function hashIp(?string $ip): string
    {
        if (!$ip) {
            return '';
        }
        return hash('sha256', self::IP_SALT . $ip);
    }

    private function extractEventCategory(string $eventName): ?string
    {
        $categories = [
            'whatsapp_click' => 'contact',
            'phone_click' => 'contact',
            'email_click' => 'contact',
            'contact_form_submit' => 'contact',
            'appointment_click' => 'conversion',
            'product_click' => 'engagement',
            'service_click' => 'engagement',
            'property_click' => 'engagement',
            'map_click' => 'engagement',
            'social_click' => 'social',
            'download_vcard' => 'download',
            'download_file' => 'download',
            'gallery_open' => 'engagement',
            'video_play' => 'engagement',
            'cta_click' => 'conversion',
        ];

        return $categories[$eventName] ?? null;
    }

    private function sanitizeMetadata(array $metadata): ?array
    {
        $maxSize = 5000;
        $json = json_encode($metadata);
        if (strlen($json) > $maxSize) {
            return ['_truncated' => true];
        }
        return $metadata;
    }

    private function truncate(string $value, int $length): string
    {
        return mb_substr($value, 0, $length);
    }

    private function isLocalIp(string $ip): bool
    {
        return in_array($ip, ['127.0.0.1', '::1', 'localhost']) ||
               str_starts_with($ip, '192.168.') ||
               str_starts_with($ip, '10.') ||
               str_starts_with($ip, '172.16.');
    }
}
