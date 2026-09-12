<?php

namespace Modules\ListingMinisite\Helpers;

use Modules\ListingMinisite\Services\MinisiteExtensionRegistry;

if (!function_exists('register_minisite_extension')) {
    function register_minisite_extension($provider): void
    {
        $registry = app(MinisiteExtensionRegistry::class);
        $registry->register($provider);
    }
}
