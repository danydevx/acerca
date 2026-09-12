<?php

namespace Modules\ListingMinisite\Contracts;

use Modules\Listings\Models\Listing;

interface MinisiteSectionProvider
{
    public function supports(Listing $listing): bool;

    public function getSectionKey(): string;

    public function getSectionData(Listing $listing, array $config): array;
}
