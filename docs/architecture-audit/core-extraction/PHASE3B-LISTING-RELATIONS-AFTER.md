# PHASE3B - LISTING RELATIONS AFTER

## Summary
- **Relationships BEFORE**: 33
- **Relationships AFTER**: 4
- **Relationships removed**: 29

---

## Relationships Status

### CORE Relationships (4) - REMAIN
| Relationship | Model | Module | Classification |
|--------------|-------|--------|----------------|
| user() | User | Core | CORE |
| modules() | ListingModule | ListingModules | CORE |
| minisiteTheme() | MinisiteTheme | Core | CORE |
| locations() | ListingLocation | ListingLocations | BASE (discussed) |

### VERTICAL Relationships - REMOVED
| Relationship | Model | Module | Removed |
|--------------|-------|--------|---------|
| products() | ListingProduct | ListingProducts | YES |
| productCategories() | ListingProductCategory | ListingProducts | YES |
| projects() | ListingProject | ListingProjects | YES |
| projectCategories() | ListingProjectCategory | ListingProjects | YES |
| services() | ListingService | ListingServices | YES |
| leads() | ListingLead | ListingLeads | YES |
| appointments() | ListingAppointment | ListingAppointments | YES |
| appointmentSlots() | ListingAppointmentSlot | ListingAppointments | YES |
| availability() | ListingAvailability | ListingAppointments | YES |
| availabilityExceptions() | ListingAvailabilityException | ListingAppointments | YES |
| galleryImages() | ListingGalleryImage | ListingGallery | YES |
| galleries() | ListingGallery | ListingGallery | YES |
| reviews() | ListingReview | ListingReviews | YES |
| promotions() | ListingPromotion | ListingPromotions | YES |
| hero() | ListingHero | ListingHero | YES |
| about() | ListingAbout | ListingAbout | YES |
| socialNetworks() | ListingSocialNetwork | ListingSocialMedia | YES |
| features() | Feature | ListingFeatures | YES |
| listingFeatures() | ListingFeature | ListingFeatures | YES |
| faqs() | ListingFaq | ListingFaqs | YES |
| faqCategories() | ListingFaqCategory | ListingFaqs | YES |
| seoSetting() | ListingSeoSetting | ListingSeo | YES |
| contactForms() | ListingContactForm | ListingContactForm | YES |
| contactFormFields() | ListingContactFormField | ListingContactForm | YES |
| tasks() | ListingTask | ListingTasks | YES |
| clients() | ListingClient | ListingClients | YES |
| teamMembers() | ListingTeamMember | ListingTeamMembers | YES |
| teamMemberPositions() | TeamMemberPosition | ListingTeamMembers | YES |
| packages() | ListingPackage | ListingPackages | YES |

---

## Module Imports in Listing.php AFTER

```php
use App\Models\ModuleDefinition;
use App\Models\MinisiteTheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Listings\Enums\ListingType;
use Modules\ListingModules\Models\ListingModule;
use Modules\ListingLocations\Models\ListingLocation;
```

**Total imports from modules: 1** (ListingLocation - BASE)

---

## Scopes Added to Module Models

### ListingProjects
- `ListingProject::scopeForListing($query, int $listingId)`
- `ListingProjectCategory::scopeForListing($query, int $listingId)`

### ListingGallery
- `ListingGallery::scopeForListing($query, int $listingId)`
- `ListingGalleryImage::scopeForListing($query, int $listingId)`

### ListingProducts
- `ListingProduct::scopeForListing($query, int $listingId)`
- `ListingProductCategory::scopeForListing($query, int $listingId)`

### ListingServices
- `ListingService::scopeForListing($query, int $listingId)`
- `ListingServiceCategory::scopeForListing($query, int $listingId)`

### ListingLeads
- `ListingLead::scopeForListing($query, int $listingId)`

### ListingAppointments
- `ListingAppointment::scopeForListing($query, int $listingId)`
- `ListingAppointmentSlot::scopeForListing($query, int $listingId)`
- `ListingAvailability::scopeForListing($query, int $listingId)`
- `ListingAvailabilityException::scopeForListing($query, int $listingId)`

---

## Controllers Modified

### Member Controllers
1. **ProjectController.php**
   - Changed `$business->projects()` → `ListingProject::forListing($business->id)`
   - Changed `$business->projectCategories()` → `ListingProjectCategory::forListing($business->id)`
   - Changed `$business->projects()->create()` → `ListingProject::create()`

2. **GalleryController.php**
   - Changed `$business->galleryImages()` → `ListingGalleryImage::forListing($business->id)`
   - Changed `$business->galleryImages()->create()` → `ListingGalleryImage::create()`
   - Changed `$business->galleries()` → `ListingGallery::forListing($business->id)`
   - Changed `$business->galleries()->create()` → `ListingGallery::create()`
   - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

3. **GalleryGroupController.php**
   - Changed `$business->galleries()` → `ListingGallery::forListing($business->id)`
   - Changed `$business->galleries()->create()` → `ListingGallery::create()`

4. **ProductController.php**
   - Changed `$business->products()` → `ListingProduct::forListing($business->id)`
   - Changed `$business->productCategories()` → `ListingProductCategory::forListing($business->id)`
   - Changed `$business->products()->create()` → `ListingProduct::create()`
   - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

5. **ServiceController.php**
   - Changed `$business->services()` → `ListingService::forListing($business->id)`
   - Changed `$business->services()->create()` → `ListingService::create()`
   - Changed `$business->services()->max()` → `ListingService::forListing($business->id)->max()`
   - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

6. **ServicesController.php**
   - Changed `$business->services()` → `ListingService::forListing($business->id)`

7. **SlotController.php**
   - Changed `$business->appointmentSlots()` → `ListingAppointmentSlot::forListing($business->id)`
   - Changed `$business->appointmentSlots()->create()` → `ListingAppointmentSlot::create()`
   - Changed `$business->services()` → `ListingService::forListing($business->id)`
   - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

8. **AppointmentController.php**
   - Changed `$business->appointments()` → `ListingAppointment::forListing($business->id)`
   - Changed `$business->appointments()->create()` → `ListingAppointment::create()`
   - Changed `$business->services()` → `ListingService::forListing($business->id)`
   - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

9. **LeadController.php**
   - Changed `$business->leads()` → `ListingLead::forListing($business->id)`
   - Changed `$business->leads()->create()` → `ListingLead::create()`
   - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

### Admin Controllers
10. **ListingContentController.php**
    - Changed `$business->galleryImages()` → `ListingGalleryImage::forListing($business->id)`
    - Changed `$business->galleries()` → `ListingGallery::forListing($business->id)`
    - Changed `$business->galleries()->create()` → `ListingGallery::create()`
    - Changed `$business->products()` → `ListingProduct::forListing($business->id)`
    - Changed `$business->products()->create()` → `ListingProduct::create()`
    - Changed `$business->services()` → `ListingService::forListing($business->id)`
    - Changed `$business->services()->create()` → `ListingService::create()`
    - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

11. **ListingLeadsController.php**
    - Changed `$business->leads()` → `ListingLead::forListing($business->id)`
    - Changed `$business->leads()->create()` → `ListingLead::create()`
    - Changed `$business->locations()` → `ListingLocation::where('listing_id', $business->id)`

---

## Pending Consumers

The following locations still use `$business->relation()` syntax and need to be migrated:

### Public Controllers
- `BusinessController.php` - products, services, locations, galleryImages
- `DirectoryController.php` - galleryImages, locations
- `BookingWidgetController.php` - services

### API Controllers
- `Api/V1/Admin/BusinessController.php` - counts
- `ApiExplorerController.php` - counts

### Seeders
- `LavanderiaManolosSeeder.php` - products, services, galleryImages, locations
- `BusinessTestSeeder.php` - products, services, leads, locations, appointments, slots

### Modules
- `ListingMinisite/*` - various relations
- `ListingRestaurantMenu/*` - products (via MenuCategory)

---

## Known Issues

### forceDeleteWithRelations()
The method `forceDeleteWithRelations()` in Listing.php still references module models that are no longer imported. Per FASE 3B instruction #22, this should not be resolved in this phase.

### Pre-existing Test Failures
Per FASE 3B instruction #27, there are tests that call Controllers directly without properly setting the user in `Gate::authorize()`. These tests were failing before and continue to fail for the same reason.

---

## Locations BASE Classification

The relationship `locations()` is classified as BASE, not VERTICAL. This means it remains in Listing for now because:

1. Multiple vertical modules (RealEstate, Restaurant, etc.) may need locations
2. It was historically core to Listing
3. The question "Can a generic Listing exist without Location?" suggests it should remain

**However**, if modules properly define their own location relationships, this could be moved to ListingLocations module in a future phase.

---

## Metrics

| Metric | Value |
|--------|-------|
| Relationships BEFORE | 33 |
| Relationships AFTER | 4 |
| Non-core relationships removed | 29 |
| Module imports in Listing BEFORE | 22 |
| Module imports in Listing AFTER | 1 (ListingLocation - BASE) |
| Scopes forListing added | 12 |

---

## Validation

- Laravel boot: PASS
- `php artisan about`: PASS
- Pre-existing test failures: 7 tests (not related to relation changes)