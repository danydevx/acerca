<?php

namespace Modules\Analytics\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalyticsCookieService
{
    private const VISITOR_COOKIE_NAME = 'av_visitor_id';
    private const SESSION_COOKIE_NAME = 'av_session_id';
    private const VISITOR_COOKIE_TTL = 365 * 24 * 60; // 1 year in minutes
    private const SESSION_COOKIE_TTL = 30; // 30 minutes

    public function getVisitorId(Request $request): string
    {
        $cookie = $request->cookie(self::VISITOR_COOKIE_NAME);
        if ($cookie && $this->isValidUuid($cookie)) {
            return $cookie;
        }
        return (string) Str::uuid();
    }

    public function getSessionId(Request $request): ?string
    {
        $cookie = $request->cookie(self::SESSION_COOKIE_NAME);
        if ($cookie && $this->isValidUuid($cookie)) {
            return $cookie;
        }
        return null;
    }

    public function setVisitorCookie(string $visitorId): array
    {
        return [
            self::VISITOR_COOKIE_NAME,
            $visitorId,
            self::VISITOR_COOKIE_TTL,
        ];
    }

    public function setSessionCookie(string $sessionId): array
    {
        return [
            self::SESSION_COOKIE_NAME,
            $sessionId,
            self::SESSION_COOKIE_TTL,
        ];
    }

    public function createVisitorId(): string
    {
        return (string) Str::uuid();
    }

    public function createSessionId(): string
    {
        return (string) Str::uuid();
    }

    private function isValidUuid(string $value): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value) === 1;
    }
}
