# FASE 4P — Cross-Package Audit

## Classification Summary

| Type | Count | Priority |
|------|-------|---------|
| VALID_DIRECT_DEPENDENCY | ~180 | P4 |
| EXTENSION_POINT | 3 | P4 |
| BASE_DEPENDENCY | 31 modules → Listings | P4 |
| SUSPICIOUS_COUPLING | 1 | P2 |
| OPTIONAL_UNSAFE | 1 | P2 |
| CYCLIC_DEPENDENCY | 0 | — |
| INTERNAL_IMPLEMENTATION_DEPENDENCY | 1 | P2 |

## Dependency Classifications

### VALID_DIRECT_DEPENDENCY (Domain)

These cross-package references represent genuine domain relationships:

**Appointments → Locations/Services/Packages**
- `ListingAppointments → ListingLocations`: Appointments happen at physical locations
- `ListingAppointments → ListingServices`: Appointments book services
- `ListingAppointments → ListingPackages`: Booking widget references packages

**All modules → Listings (BASE)**
- Every module manages content for a business listing
- The `Listing` model is the central entity (CORE/Base module)
- This is the expected and correct architecture
- Count: 31 modules × Listings

**Location-aware modules**
- `ListingFeatures → ListingLocations`: Features attached to locations
- `ListingProducts → ListingLocations`: Products at locations
- `ListingServices → ListingLocations`: Services at locations
- `ListingPromotions → ListingLocations`: Promotions at locations
- `ListingLeads → ListingLocations`: Leads source from locations
- `ListingOfficeHours → ListingLocations`: Schedules per location
- `ListingGallery → ListingLocations`: Gallery associated with location

**CRM relationship**
- `ListingContactForm → ListingLeads`: Contact forms capture leads (same parent package `crm/`)
- `ListingCheckin → ListingGuests`: Check-in tracks guests

### EXTENSION_POINT

Three modules extend ListingMinisite via the `MinisiteExtensionRegistry`:

1. **Properties → ListingMinisite** (PropertyMinisiteProvider implements MinisiteSectionProvider)
2. **RestaurantMenu → ListingMinisite** (RestaurantMinisiteProvider implements MinisiteSectionProvider)
3. **Orders → ListingMinisite** (OrderMinisitePageProvider implements MinisitePageDataProvider)

Pattern: Module registers itself with the registry. Registry is owned by ListingMinisite. This is a **correct extension point pattern**.

### SUSPICIOUS_COUPLING (P2)

**VCards → ListingAiChatbot** (1 import)

File: `vcards/Modules/VCards/app/Services/VCardVisitService.php`

```php
use Modules\ListingAiChatbot\Services\GeoLocationService;
...
$this->geoService = new GeoLocationService();
```

VCards directly instantiates `GeoLocationService` from the AI chatbot package. This is an internal implementation dependency — VCards should not know about AI chatbot's internal service class.

**Recommended**: Extract `GeoLocationService` into a shared location service or create a `GeoLocationServiceContract` interface.

### OPTIONAL_UNSAFE (P2)

**Orders composer.json missing minisite declaration**

File: `packages/miniwebs/orders/composer.json`

```json
"require": {
    "php": "^8.2"
}
```

Orders registers `OrderMinisitePageProvider` with `MinisiteExtensionRegistry` (owned by ListingMinisite) but does not declare the dependency in composer.json. Properties and RestaurantMenu correctly declare `"miniwebs/minisite": "*"`.

**Note**: The code uses `if ($this->app->bound(...))` so it won't crash if minisite is absent, but it's an incomplete declaration.

### CROSS-PACKAGE WITHIN SAME PARENT (acceptable)

**ListingContactForm → ListingLeads** (both under `crm/` package)

Both modules are in `packages/miniwebs/crm/`. Cross-module within the same parent package. The relationship (form captures leads) is logical. No action needed.

## Extension Point Analysis: MinisiteExtensionRegistry

### Architecture

```
ListingMinisite
  owns:
    - MinisiteExtensionRegistry (singleton)
    - MinisiteSectionProvider (contract)
    - MinisitePageDataProvider (contract)

Properties        → registers PropertyMinisiteProvider     (EXTENSION_POINT ✓)
RestaurantMenu    → registers RestaurantMinisiteProvider  (EXTENSION_POINT ✓)
Orders            → registers OrderMinisitePageProvider    (EXTENSION_POINT ✓, but missing composer dep)
```

### Is it a valid extension point?

**YES.** The pattern is correct:

1. ListingMinisite defines contracts (`MinisiteSectionProvider`, `MinisitePageDataProvider`)
2. ListingMinisite owns the registry
3. Other modules implement the contracts and register themselves
4. ListingMinisite does NOT import module-specific classes
5. New modules CAN extend the minisite without modifying ListingMinisite code

**Composer declarations**: Properties and RestaurantMenu correctly declare `miniwebs/minisite`. Orders should add it.

## Internal Implementation Dependencies

**Count: 1**

- `VCards → ListingAiChatbot/Services/GeoLocationService`: Direct instantiation of an internal service class. Not through a contract.

No other packages consume internal implementation details of other packages. The Listing model relationships use fully-qualified class names through Eloquent, which is the standard Laravel pattern.

## Optional Dependencies

**OPTIONAL_SAFE (class_exists pattern)**

ListingAiChatbot uses `class_exists()` checks before attaching observers:

```php
if (class_exists('\Modules\ListingProducts\Models\ListingProduct')) {
    \Modules\ListingProducts\Models\ListingProduct::observe(ProductObserver::class);
}
```

This means if a domain module is disabled, the AI chatbot boots without attaching that observer. Safe optional dependency.

## Vue/JS Cross-Package Imports

**Total: 0**

No Vue or JavaScript files in any package import resources from other packages. All `@` alias imports resolve to platform-level layouts and components (CORE). This is clean.
