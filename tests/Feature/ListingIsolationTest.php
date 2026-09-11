<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Listings\Models\Listing;
use Modules\ListingLocations\Models\ListingLocation;
use Modules\ListingServices\Models\ListingService;
use Tests\TestCase;

class ListingIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Listing $listingA;
    protected Listing $listingB;
    protected ListingService $serviceA;
    protected ListingService $serviceB;
    protected ListingLocation $locationA;
    protected ListingLocation $locationB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->listingA = Listing::create([
            'user_id' => $this->user->id,
            'name' => 'Listing A',
            'slug' => 'listing-a',
            'listing_type' => 'generic',
            'is_active' => true,
            'is_published' => true,
        ]);

        $this->listingB = Listing::create([
            'user_id' => $this->user->id,
            'name' => 'Listing B',
            'slug' => 'listing-b',
            'listing_type' => 'generic',
            'is_active' => true,
            'is_published' => true,
        ]);

        $this->serviceA = ListingService::create([
            'listing_id' => $this->listingA->id,
            'name' => 'Service A',
            'slug' => 'service-a',
            'price' => 100,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);

        $this->serviceB = ListingService::create([
            'listing_id' => $this->listingB->id,
            'name' => 'Service B',
            'slug' => 'service-b',
            'price' => 200,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $this->locationA = ListingLocation::create([
            'listing_id' => $this->listingA->id,
            'name' => 'Location A',
            'is_active' => true,
        ]);

        $this->locationB = ListingLocation::create([
            'listing_id' => $this->listingB->id,
            'name' => 'Location B',
            'is_active' => true,
        ]);
    }

    public function test_user_cannot_access_service_from_different_listing_via_appointment_store(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson("/member/listings/{$this->listingA->id}/appointments", [
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'business_service_id' => $this->serviceB->id,
            'business_location_id' => $this->locationA->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'start_time' => '10:00',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_cannot_access_location_from_different_listing_via_appointment_store(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson("/member/listings/{$this->listingA->id}/appointments", [
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'business_service_id' => $this->serviceA->id,
            'business_location_id' => $this->locationB->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'start_time' => '10:00',
        ]);

        $response->assertStatus(422);
    }

    public function test_service_query_is_scoped_to_listing(): void
    {
        $service = ListingService::where('id', $this->serviceA->id)
            ->where('listing_id', $this->listingA->id)
            ->first();

        $this->assertNotNull($service);
        $this->assertEquals($this->serviceA->id, $service->id);
        $this->assertEquals($this->listingA->id, $service->listing_id);
    }

    public function test_service_query_returns_null_for_wrong_listing(): void
    {
        $service = ListingService::where('id', $this->serviceB->id)
            ->where('listing_id', $this->listingA->id)
            ->first();

        $this->assertNull($service);
    }

    public function test_location_query_is_scoped_to_listing(): void
    {
        $location = ListingLocation::where('id', $this->locationA->id)
            ->where('listing_id', $this->listingA->id)
            ->first();

        $this->assertNotNull($location);
        $this->assertEquals($this->locationA->id, $location->id);
        $this->assertEquals($this->listingA->id, $location->listing_id);
    }

    public function test_location_query_returns_null_for_wrong_listing(): void
    {
        $location = ListingLocation::where('id', $this->locationB->id)
            ->where('listing_id', $this->listingA->id)
            ->first();

        $this->assertNull($location);
    }
}
