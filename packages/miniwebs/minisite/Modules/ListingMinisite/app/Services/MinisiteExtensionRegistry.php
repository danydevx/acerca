<?php

namespace Modules\ListingMinisite\Services;

use Illuminate\Support\Collection;
use Modules\ListingMinisite\Contracts\MinisiteSectionProvider;

class MinisiteExtensionRegistry
{
    protected array $providers = [];

    public function register(MinisiteSectionProvider $provider): void
    {
        $this->providers[$provider->getSectionKey()] = $provider;
    }

    public function getProvider(string $key): ?MinisiteSectionProvider
    {
        return $this->providers[$key] ?? null;
    }

    public function getAllProviders(): array
    {
        return $this->providers;
    }

    public function getSupportedSections(Listing $listing): Collection
    {
        return collect($this->providers)->filter(
            fn ($provider) => $provider->supports($listing)
        );
    }
}
