<?php

namespace Modules\Analytics\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Response;
use Modules\Analytics\Http\Requests\AnalyticsCollectRequest;
use Modules\Analytics\Services\AnalyticsCookieService;
use Modules\Analytics\Services\AnalyticsTrackingService;
use Modules\Listings\Models\Listing;

class AnalyticsCollectController extends Controller
{
    public function __construct(
        private AnalyticsTrackingService $trackingService,
        private AnalyticsCookieService $cookieService,
    ) {}

    public function collect(AnalyticsCollectRequest $request): JsonResponse
    {
        $ip = $request->ip();
        $key = 'analytics:' . $ip;

        if (RateLimiter::tooManyAttempts($key, 60)) {
            return Response::json(['success' => false, 'message' => 'Rate limited'], 429);
        }

        RateLimiter::hit($key, 60);

        $listing = $this->trackingService->resolveListingFromRequest($request);

        if (!$listing) {
            return Response::json(['success' => false, 'message' => 'Invalid listing'], 400);
        }

        $type = $request->input('type');

        if ($type === 'pageview') {
            $this->trackingService->trackPageview($request, $listing);
        } elseif ($type === 'event') {
            $eventName = $request->input('event_name');
            if ($eventName) {
                $metadata = $request->input('metadata', []);
                $this->trackingService->trackEvent($request, $listing, $eventName, $metadata);
            }
        }

        $visitorId = $this->cookieService->getVisitorId($request);
        $sessionId = $this->cookieService->getSessionId($request) ?? $this->cookieService->createSessionId();

        $cookies = [];
        if (!$request->cookie('av_visitor_id')) {
            $cookies[] = cookie(...$this->cookieService->setVisitorCookie($visitorId));
        }
        if (!$request->cookie('av_session_id')) {
            $cookies[] = cookie(...$this->cookieService->setSessionCookie($sessionId));
        }

        return Response::json(['success' => true])
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ])
            ->withCookies($cookies);
    }
}
