<?php

namespace Modules\Analytics\Services;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class AnalyticsDeviceService
{
    private const DEVICE_DESKTOP = 'desktop';
    private const DEVICE_MOBILE = 'mobile';
    private const DEVICE_TABLET = 'tablet';
    private const DEVICE_OTHER = 'other';

    public function parseUserAgent(string $userAgent): array
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);
        $platform = $agent->platform();
        $deviceType = $this->determineDeviceType($agent);

        return [
            'browser' => $browser ?: 'Unknown',
            'browser_version' => $browserVersion ?: null,
            'os' => $platform ?: 'Unknown',
            'device_type' => $deviceType,
        ];
    }

    public function parseFromRequest(Request $request): array
    {
        $userAgent = $request->userAgent() ?? '';
        return $this->parseUserAgent($userAgent);
    }

    public function determineDeviceType(Agent $agent): string
    {
        if ($agent->isDesktop()) {
            return self::DEVICE_DESKTOP;
        }

        if ($agent->isTablet()) {
            return self::DEVICE_TABLET;
        }

        if ($agent->isMobile()) {
            return self::DEVICE_MOBILE;
        }

        return self::DEVICE_OTHER;
    }

    public function isBot(string $userAgent): bool
    {
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        if ($agent->isRobot()) {
            return true;
        }

        $botPatterns = [
            'bot', 'crawl', 'spider', 'slurp', 'search', 'fetch',
            'facebookexternalhit', 'twitterbot', 'linkedinbot',
            'whatsapp', 'telegram', 'discord', 'skype',
            'google', 'bing', 'yandex', 'duckduckbot',
        ];

        $ua = strtolower($userAgent);
        foreach ($botPatterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public function isBotFromRequest(Request $request): bool
    {
        return $this->isBot($request->userAgent() ?? '');
    }

    public function getLanguage(Request $request): ?string
    {
        $lang = $request->header('Accept-Language');
        if (!$lang) {
            return null;
        }

        $parts = explode(',', $lang);
        return $parts[0] ?? null;
    }
}
