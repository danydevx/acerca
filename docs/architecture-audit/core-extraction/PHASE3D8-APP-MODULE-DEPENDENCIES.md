# PHASE3D8-APP-MODULE-DEPENDENCIES

## App -> Module Dependencies

### Product Composition Dependencies

These are INTENTIONAL dependencies from product composition controllers to module models:

| File | Module | Model | Classification |
|------|--------|-------|---------------|
| Public\BusinessController | Listings | Listing | PRODUCT_COMPOSITION |
| Public\BusinessController | ListingGallery | ListingGallery | PRODUCT_COMPOSITION |
| Public\BusinessController | ListingLeads | ListingLead | PRODUCT_COMPOSITION |
| Public\BusinessController | ListingLocations | ListingLocation | PRODUCT_COMPOSITION |
| Public\BusinessController | ListingPackages | ListingPackage | PRODUCT_COMPOSITION |
| Public\BusinessController | ListingServices | ListingService | PRODUCT_COMPOSITION |
| Public\BusinessController | ListingAppointments | ListingAppointment | PRODUCT_COMPOSITION |
| Public\DirectoryController | Listings | Listing | PRODUCT_COMPOSITION |
| Public\DirectoryController | ListingLeads | ListingLead | PRODUCT_COMPOSITION |
| Public\DirectoryController | ListingLocations | ListingLocation | PRODUCT_COMPOSITION |
| Public\DirectoryController | ListingServices | ListingService | PRODUCT_COMPOSITION |
| Public\DirectoryController | ListingAppointments | ListingAppointment | PRODUCT_COMPOSITION |
| Public\BookingWidgetController | ListingAppointments | ListingAppointment | PRODUCT_COMPOSITION |
| Public\BookingWidgetController | ListingLocations | ListingLocation | PRODUCT_COMPOSITION |
| Public\BookingWidgetController | ListingPackages | ListingPackage | PRODUCT_COMPOSITION |
| Public\BookingWidgetController | ListingServices | ListingService | PRODUCT_COMPOSITION |
| Public\BookingWidgetController | Listings | Listing | PRODUCT_COMPOSITION |
| Public\PromotionVerificationController | ListingPromotions | ListingPromotion | PRODUCT_COMPOSITION |

### Legacy Aggregator Dependencies

These are dependencies from the LEGACY_AGGREGATOR ListingContentController to module models:

| File | Module | Model | Classification |
|------|--------|-------|---------------|
| Admin\ListingContentController | ListingAppointments | ListingAppointment | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingFaqs | ListingFaq | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingFaqs | ListingFaqCategory | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingGallery | ListingGallery | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingGallery | ListingGalleryImage | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingLocations | ListingLocation | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingProducts | ListingProduct | LEGACY_AGGREGATOR |
| Admin\ListingContentController | ListingServices | ListingService | LEGACY_AGGREGATOR |

### Module Admin Controller Dependencies

| File | Module | Model | Classification |
|------|--------|-------|---------------|
| Admin\ListingAiChatbotController | Listings | Listing | MODULE_OWNED |

## Classification Summary

```
PRODUCT_COMPOSITION: 19 imports (intentional)
LEGACY_AGGREGATOR: 8 imports (expected)
MODULE_OWNED: 1 import (should migrate)

Total: 28 imports
```

## INVALID_DEPENDENCIES = 0

All dependencies are classified correctly. No invalid core dependencies found.
