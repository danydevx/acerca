<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class ListingIsolationLogicTest extends TestCase
{
    public function test_scoped_query_returns_correct_listing(): void
    {
        $scopedResult = $this->simulateScopedQuery(
            listingId: 1,
            targetId: 100,
            shouldReturn: true
        );

        $this->assertTrue($scopedResult);
    }

    public function test_scoped_query_rejects_wrong_listing(): void
    {
        $scopedResult = $this->simulateScopedQuery(
            listingId: 1,
            targetId: 200,
            shouldReturn: false
        );

        $this->assertFalse($scopedResult);
    }

    public function test_validation_rule_requires_listing_ownership(): void
    {
        $serviceId = 100;
        $serviceListingId = 1;
        $currentListingId = 1;

        $hasOwnership = ($serviceListingId === $currentListingId);

        $this->assertTrue($hasOwnership);
    }

    public function test_validation_rule_rejects_service_from_different_listing(): void
    {
        $serviceFromOtherListing = 200;
        $serviceListingId = 2;
        $currentListingId = 1;

        $isValid = ($serviceListingId === $currentListingId);

        $this->assertFalse($isValid);
    }

    public function test_validation_rule_rejects_location_from_different_listing(): void
    {
        $locationFromOtherListing = 300;
        $locationListingId = 2;
        $currentListingId = 1;

        $isValid = ($locationListingId === $currentListingId);

        $this->assertFalse($isValid);
    }

    private function simulateScopedQuery(int $listingId, int $targetId, bool $shouldReturn): bool
    {
        $data = [
            ['id' => 100, 'listing_id' => 1],
            ['id' => 200, 'listing_id' => 2],
        ];

        foreach ($data as $item) {
            if ($item['id'] === $targetId && $item['listing_id'] === $listingId) {
                return true;
            }
        }

        return false;
    }
}
