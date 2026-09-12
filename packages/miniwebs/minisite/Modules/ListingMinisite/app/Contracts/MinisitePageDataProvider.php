<?php

namespace Modules\ListingMinisite\Contracts;

use Modules\Listings\Models\Listing;

interface MinisitePageDataProvider
{
    public function supports(Listing $listing): bool;

    public function getDataKey(): string;

    public function getPageData(Listing $listing): array;
}
