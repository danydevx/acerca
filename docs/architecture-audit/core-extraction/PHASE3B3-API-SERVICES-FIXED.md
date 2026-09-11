# PHASE 3B.3 — API + SERVICES INVALID CONSUMERS (FIXED)

## Overview
Fixed all invalid Listing relationship consumers found in Phase 3B.3 audit.

## Files Modified

### API Controllers (2 files)

#### app/Http/Controllers/Api/V1/Admin/BusinessController.php
- **Method:** `stats()`
- **Fix:** Replaced `$business->relationship()` calls with direct model queries using `forListing()` scope

```php
// AFTER (Line 79-84)
'locations' => ListingLocation::where('listing_id', $business->id)->count(),
'gallery' => ListingGalleryImage::where('listing_id', $business->id)->count(),
'faqs' => ListingFaq::forListing($business->id)->count(),
'services' => ListingService::forListing($business->id)->count(),
'products' => ListingProduct::forListing($business->id)->count(),
'reviews' => ListingReview::forListing($business->id)->count(),
'leads' => ListingLead::forListing($business->id)->count(),
```

#### app/Http/Controllers/Admin/ApiExplorerController.php
- **Method:** `executeEndpoint()` - /stats endpoint
- **Fix:** Replaced `$business->relationship()` calls with direct model queries

```php
// AFTER (Line 162-169)
'locations' => ListingLocation::where('listing_id', $business->id)->count(),
'gallery' => ListingGalleryImage::where('listing_id', $business->id)->count(),
'faqs' => ListingFaq::forListing($business->id)->count(),
'services' => ListingService::forListing($business->id)->count(),
'products' => ListingProduct::forListing($business->id)->count(),
'reviews' => ListingReview::forListing($business->id)->count(),
'leads' => ListingLead::forListing($business->id)->count(),
'properties' => Property::where('listing_id', $business->id)->count(),
'clients' => ListingClient::where('listing_id', $business->id)->count(),
```

### Services (1 file)

#### app/Services/AvailabilityService.php
- **Methods Fixed:** `isDateAvailable()`, `getTimeRange()`, `isSlotAvailable()`, `getAvailableSlotsForDate()`, `getOccupancyForDate()`
- **Fix:** Replaced `$business->availability()`, `$business->availabilityExceptions()`, and `$business->appointments()` with proper model queries using `forListing()` scope

**Import changes:**
```php
// Already had these imports:
use Modules\ListingAppointments\Models\ListingAvailability;
use Modules\ListingAppointments\Models\ListingAvailabilityException;
use Modules\ListingAppointments\Models\ListingAppointment;
```

**isDateAvailable() - Line 17, 26:**
```php
// BEFORE
$exception = $business->availabilityExceptions()->where('exception_date', $date)->first();
$schedule = $business->availability()->where('day_of_week', $dayOfWeek)->first();

// AFTER
$exception = ListingAvailabilityException::forListing($business->id)->where('exception_date', $date)->first();
$schedule = ListingAvailability::forListing($business->id)->where('day_of_week', $dayOfWeek)->first();
```

**getTimeRange() - Line 41, 56:**
```php
// BEFORE
$exception = $business->availabilityExceptions()->where('exception_date', $date)->first();
$schedule = $business->availability()->where('day_of_week', $dayOfWeek)->first();

// AFTER
$exception = ListingAvailabilityException::forListing($business->id)->where('exception_date', $date)->first();
$schedule = ListingAvailability::forListing($business->id)->where('day_of_week', $dayOfWeek)->first();
```

**isSlotAvailable() - Line 100, 108, 116:**
```php
// BEFORE
$exception = $business->availabilityExceptions()->where('exception_date', $date)->first();
$schedule = $business->availability()->where('day_of_week', $dayOfWeek)->first();
$overlappingCount = $business->appointments()->where(...)->count();

// AFTER
$exception = ListingAvailabilityException::forListing($business->id)->where('exception_date', $date)->first();
$schedule = ListingAvailability::forListing($business->id)->where('day_of_week', $dayOfWeek)->first();
$overlappingCount = ListingAppointment::forListing($business->id)->where(...)->count();
```

**getAvailableSlotsForDate() - Line 152, 162, 178:**
```php
// BEFORE
$exception = $business->availabilityExceptions()->where('exception_date', $date)->first();
$schedule = $business->availability()->where('day_of_week', $dayOfWeek)->first();
$existingAppointments = $business->appointments()->where(...)->get();

// AFTER
$exception = ListingAvailabilityException::forListing($business->id)->where('exception_date', $date)->first();
$schedule = ListingAvailability::forListing($business->id)->where('day_of_week', $dayOfWeek)->first();
$existingAppointments = ListingAppointment::forListing($business->id)->where(...)->get();
```

**getOccupancyForDate() - Line 211:**
```php
// BEFORE
return $business->appointments()->where(...)->count();

// AFTER
return ListingAppointment::forListing($business->id)->where(...)->count();
```

## Summary

### Fixes Applied

| File | Invalid Calls Fixed |
|------|-------------------|
| BusinessController.php | 6 |
| ApiExplorerController.php | 7 |
| AvailabilityService.php | 11 |
| **TOTAL** | **24** |

### Fix Types

| Pattern | Replacement |
|---------|-------------|
| `$business->appointments()` | `ListingAppointment::forListing($business->id)` |
| `$business->availability()` | `ListingAvailability::forListing($business->id)` |
| `$business->availabilityExceptions()` | `ListingAvailabilityException::forListing($business->id)` |
| `$business->faqs()` | `ListingFaq::forListing($business->id)` |
| `$business->reviews()` | `ListingReview::forListing($business->id)` |
| `$business->products()` | `ListingProduct::forListing($business->id)` |
| `$business->services()` | `ListingService::forListing($business->id)` |
| `$business->leads()` | `ListingLead::forListing($business->id)` |
| `$business->galleryImages()` | `ListingGalleryImage::where('listing_id', $business->id)` |
| `$business->properties()` | `Property::where('listing_id', $business->id)` |
| `$business->clients()` | `ListingClient::where('listing_id', $business->id)` |

### Preserved Functionality
- All existing filters preserved
- All existing ordering preserved
- All existing pagination preserved
- All existing eager loading (via `with()`) preserved
- Module status checks preserved
