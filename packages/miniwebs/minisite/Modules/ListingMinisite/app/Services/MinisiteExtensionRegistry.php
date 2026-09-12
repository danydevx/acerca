<?php

namespace Modules\ListingMinisite\Services;

use Illuminate\Support\Collection;
use Modules\ListingMinisite\Contracts\MinisitePageDataProvider;
use Modules\ListingMinisite\Contracts\MinisiteSectionProvider;
use Modules\Listings\Models\Listing;

class MinisiteExtensionRegistry
{
    protected array $sectionProviders = [];
    protected array $pageDataProviders = [];

    public function registerSectionProvider(MinisiteSectionProvider $provider): void
    {
        $this->sectionProviders[$provider->getSectionKey()] = $provider;
    }

    public function registerPageDataProvider(MinisitePageDataProvider $provider): void
    {
        $this->pageDataProviders[$provider->getDataKey()] = $provider;
    }

    public function getSectionProvider(string $key): ?MinisiteSectionProvider
    {
        return $this->sectionProviders[$key] ?? null;
    }

    public function getPageDataProvider(string $key): ?MinisitePageDataProvider
    {
        return $this->pageDataProviders[$key] ?? null;
    }

    public function getAllSectionProviders(): array
    {
        return $this->sectionProviders;
    }

    public function getAllPageDataProviders(): array
    {
        return $this->pageDataProviders;
    }

    public function getSupportedSections(Listing $listing): Collection
    {
        return collect($this->sectionProviders)->filter(
            fn ($provider) => $provider->supports($listing)
        );
    }

    public function getPageData(Listing $listing): array
    {
        $data = [];
        foreach ($this->pageDataProviders as $key => $provider) {
            if ($provider->supports($listing)) {
                $data[$key] = $provider->getPageData($listing);
            }
        }
        return $data;
    }
}
