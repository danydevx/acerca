# PHASE 3 — CORE BOOT TEST

**Date:** 2026-09-10
**Goal:** Validate Core can boot with optional modules disabled

---

## TEST METHODOLOGY

We simulate disabling optional modules by checking:
1. Which models/services are truly required at boot
2. Which module registrations can be deferred
3. FK cascade coverage for data cleanup

---

## MINIMUM MODULES FOR BOOT

### Required for Laravel to boot:
```
app/
├── Models/User.php
├── Models/Role.php (Spatie)
├── Models/Permission.php (Spatie)
├── Http/Controllers/Auth/*
├── Providers/AppServiceProvider.php (Core only)
├── Providers/RouteServiceProvider.php
└── Providers/AuthServiceProvider.php

Modules/
├── Listings/ (Core listing system)
└── ListingModules/ (Module registry)
```

### Implicit requirements (handled by Laravel):
- Database connection
- Cache driver
- Session driver
- Queue driver (optional)

---

## WHAT APP SERVICE PROVIDER SHOULD CONTAIN

### CORE (keep):
```php
Gate::policy(User::class, UserPolicy::class);
Gate::policy(ApiKey::class, ApiKeyPolicy::class);
Gate::policy(WebhookEndpoint::class, WebhookEndpointPolicy::class);
Gate::policy(SupportTicket::class, SupportTicketPolicy::class);
Gate::policy(MediaFile::class, MediaFilePolicy::class);
Gate::policy(Payment::class, PaymentPolicy::class);
Gate::policy(Subscription::class, SubscriptionPolicy::class);
Gate::policy(Listing::class, BusinessPolicy::class); // Core listing model
Gate::policy(ListingModule::class, ListingModulePolicy::class);
```

### MODULE (remove - should be in module ServiceProviders):
```php
// These should NOT be in AppServiceProvider:
Gate::policy(ListingGallery::class, ...);      // → ListingGallery module
Gate::policy(ListingHero::class, ...);          // → ListingHero module
Gate::policy(ListingAbout::class, ...);         // → ListingAbout module
Gate::policy(ListingProduct::class, ...);        // → ListingProducts module
Gate::policy(ListingService::class, ...);       // → ListingServices module
Gate::policy(ListingAppointment::class, ...);    // → ListingAppointments module
// ... all other module policies
```

---

## FK CASCADE COVERAGE

### Currently using FK CASCADE:
Most module tables have `listing_id` with cascade delete.

### Need to verify:
```sql
-- Should have ON DELETE CASCADE:
listing_gallery_images.listing_id → CASCADE
listing_heroes.listing_id → CASCADE
listing_abouts.listing_id → CASCADE
listing_products.listing_id → CASCADE
listing_services.listing_id → CASCADE
listing_appointments.listing_id → CASCADE
listing_leads.listing_id → CASCADE
listing_locations.listing_id → CASCADE
listing_faqs.listing_id → CASCADE
listing_features.listing_id → CASCADE
listing_seo_settings.listing_id → CASCADE
listing_contact_forms.listing_id → CASCADE
-- etc.
```

### Currently using forceDeleteWithRelations (NOT ideal):
`Listing::forceDeleteWithRelations()` manually deletes 15+ tables.
This should be replaced with CASCADE + events.

---

## LISTING LIFECYCLE EVENTS

### Current (problematic):
```php
// Listing.php boot()
static::created(function ($listing) {
    $listing->syncAllModules();           // Creates ListingModule records
    $listing->assignMinisiteTheme();     // Removed in Phase 2 ✓
});

static::updated(function ($listing) {
    if ($listing->wasChanged('listing_type')) {
        $listing->assignMinisiteTheme(); // Removed in Phase 2 ✓
    }
});
```

### Target (clean):
```php
// Listing.php boot()
static::created(function ($listing) {
    $listing->syncAllModules();  // Only Core concern - creates module registry entries
});
```

### For module cleanup (add):
```php
// Core emits event
event(new ListingDeleted($listing));

// Modules listen and clean up
// ListingGallery: delete images
// ListingProducts: delete products
// etc.
```

---

## COMPOSITION TESTS

### Test 1: MiniWebs Core Only
```
Enable: Listings, ListingModules, User, Auth
Disable: All other modules
Expected: User can register, login, create listing, manage listing basics
```

### Test 2: MiniWebs + Base Content
```
Enable: Above + Gallery, Hero, About, Seo, ContactForm, SocialMedia, Locations
Expected: User can manage all base content modules
```

### Test 3: MiniWebs + Appointments
```
Enable: Above + Appointments + Services
Expected: User can set up services and appointments
```

### Test 4: Invitations-saas Simulation
```
Enable: Listings + ListingGuests + Gallery + ContactForm + Leads
Disable: Properties, RestaurantMenu, Appointments, Products
Expected: Event planning workflow works
```

### Test 5: RealEstate-saas Simulation
```
Enable: Listings + Properties + Services + Leads + Appointments
Disable: RestaurantMenu, VCards, ListingGuests
Expected: Property listings and viewing appointments work
```

### Test 6: Restaurant-saas Simulation
```
Enable: Listings + RestaurantMenu + Products + Orders + Reviews
Disable: Properties, VCards, ListingGuests
Expected: Menu management and order flow works
```

---

## VALIDATION CHECKLIST

- [ ] AppServiceProvider has only Core policies
- [ ] All module policies registered in module ServiceProviders
- [ ] FK ON DELETE CASCADE on all listing_id foreign keys
- [ ] forceDeleteWithRelations() removed from Listing
- [ ] ListingDeleted event created and modules listen
- [ ] syncAllModules() only creates ListingModule records
- [ ] No module code in AppServiceProvider boot()

---

## MANUAL VALIDATION STEPS

1. **Clear all module policies from AppServiceProvider**
2. **Run:** `php artisan about` - should still boot
3. **Run:** `php artisan route:list --columns=method,uri,name` - should show routes
4. **Run:** `php artisan test` - should pass
5. **Visit:** `/member/dashboard` - should load (may show module errors if disabled)

---

## EXPECTED FAILURES IF MODULES MISSING

If a module is disabled and code tries to use it:
- Missing class: `ClassNotFoundException`
- Missing table: `QueryException` (table doesn't exist)

**This is acceptable** - modules are optional.
**Core should never crash** if a module is disabled.
