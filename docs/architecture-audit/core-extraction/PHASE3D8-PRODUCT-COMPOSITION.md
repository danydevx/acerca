# PHASE3D8-PRODUCT-COMPOSITION

## Controllers that Compose Multiple Modules/Domains

These controllers combine multiple domains/modules to create product experiences.

### Public\BusinessController (13 routes)

Serves public pages for individual businesses.

**Dependencies:**
- Uses modules: Products, Services, Reviews, Gallery, Locations, Appointments, etc.
- Public minisite rendering

**Classification: PRODUCT_COMPOSITION**

### Public\DirectoryController (5 routes)

Serves the business directory/public listing browser.

**Dependencies:**
- Business listings
- Search/browse functionality

**Classification: PRODUCT_COMPOSITION**

### Public\BookingWidgetController (5 routes)

Embedded booking widget for external sites.

**Dependencies:**
- Services
- Appointments
- Availability
- Listings

**Classification: PRODUCT_COMPOSITION**

### Member\BusinessController (4 routes)

Member-facing listing management.

**Dependencies:**
- Core listing CRUD
- Module enablement/disablement

**Classification: PRODUCT_COMPOSITION**

### Api\V1\Admin\BusinessController (27 routes)

API composition for business management.

**Dependencies:**
- All listing sub-resources
- Team management
- Module configuration

**Classification: PRODUCT_COMPOSITION**

### Api\V1\Admin\UserController (3 routes)

API user composition.

**Classification: PRODUCT_COMPOSITION**

### Wizard\BusinessController (2 routes)

Onboarding wizard for new businesses.

**Dependencies:**
- Business creation flow
- Initial module selection

**Classification: PRODUCT_COMPOSITION**

### Public\PromotionVerificationController (1 route)

Coupon/promotion verification.

**Dependencies:**
- ListingPromotions module

**Classification: PRODUCT_COMPOSITION**

## Summary

These controllers intentionally depend on multiple modules because they compose product experiences. They should remain in `app/` and not be converted to modules.
