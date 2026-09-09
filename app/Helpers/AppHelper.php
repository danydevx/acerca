<?php

use App\Services\SettingService;

if (!function_exists('app_name')) {
    function app_name(): string
    {
        static $name = null;

        if ($name === null) {
            $name = app(SettingService::class)->get('app.name', config('app.name', 'SaaS'));
        }

        return $name;
    }
}

if (!function_exists('manifest')) {
    function manifest(string $resource, string $type = 'js'): ?string
    {
        $manifestPath = public_path('build/manifest.json');

        if (!file_exists($manifestPath)) {
            return null;
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        if (!isset($manifest[$resource])) {
            return null;
        }

        $asset = $manifest[$resource];

        if ($type === 'css' && isset($asset['css'][0])) {
            return asset('build/' . $asset['css'][0]);
        }

        if ($type === 'js' && isset($asset['file'])) {
            return asset('build/' . $asset['file']);
        }

        return null;
    }
}
