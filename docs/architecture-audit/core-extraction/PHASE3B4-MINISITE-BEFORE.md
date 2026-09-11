# PHASE 3B.4 — MINISITE INVALID CONSUMERS (BEFORE)

## Overview
Phase 3B.4 audits and fixes invalid Listing relationship consumers in Minisite controllers and Public/Directory controllers.

## Files Audited
- `Modules/ListingMinisite/app/Http/Controllers/Public/ListingMinisiteController.php`
- `Modules/ListingMinisite/app/Http/Controllers/Member/ListingMinisiteSectionController.php`
- `app/Http/Controllers/Public/DirectoryController.php`

## Invalid Consumers Inventory

### ListingMinisiteController.php (Public)

| Line | Relationship | Section/Method |
|------|-------------|---------------|
| 104 | `socialNetworks()` | show() |
| 167 | `productCategories()` | products() |
| 176 | `socialNetworks()` | products() |
| 256 | `socialNetworks()` | menu() |
| 331 | `products()` | productDetail() |
| 365 | `products()` | productDetail() |
| 386 | `socialNetworks()` | productDetail() |
| 458 | `services()` | serviceDetail() |
| 492 | `socialNetworks()` | serviceDetail() |
| 568 | `promotions()` | promotionDetail() |
| 588 | `promotions()` | promotionDetail() |
| 614 | `socialNetworks()` | promotionDetail() |
| 849 | `socialNetworks()` | propertyDetail() |
| 927 | `socialNetworks()` | renderPage() |
| 974 | `services()` | getExistingSections() |
| 977 | `products()` | getExistingSections() |
| 980 | `galleryImages()` | getExistingSections() |
| 983 | `appointments()` | getExistingSections() |
| 986 | `availability()` | getExistingSections() |
| 989 | `promotions()` | getExistingSections() |
| 995 | `reviews()` | getExistingSections() |
| 998 | `faqs()` | getExistingSections() |
| 1001 | `contactForms()` | getExistingSections() |
| 1016 | `services()` | getServicesData() |
| 1079 | `galleryImages()` | getGalleryData() |
| 1106 | `promotions()` | getPromotionsData() |
| 1139 | `contactForms()` | getContactFormData() |
| 1158 | `services()` | getAppointmentsData() |
| 1186 | `availability()` | getAppointmentsData() |
| 1200 | `availability()` | getAvailabilityData() |
| 1215 | `availabilityExceptions()` | getAvailabilityData() |
| 1369 | `features()` | getFeaturesData() |
| 1391 | `faqs()` | getFaqsData() |
| 1417 | `products()` | getProductsData() |
| 1476 | `reviews()` | getReviewsData() |
| 1613 | `packages()` | getPackagesData() |

**Subtotal: 36 invalid consumers**

### ListingMinisiteSectionController.php (Member)

| Line | Relationship | Method |
|------|-------------|--------|
| 320 | `services()` | getServicesData() |
| 351 | `galleryImages()` | getGalleryData() |
| 378 | `promotions()` | getPromotionsData() |
| 411 | `contactForms()` | getContactFormData() |
| 472 | `features()` | getFeaturesData() |
| 494 | `faqs()` | getFaqsData() |
| 521 | `products()` | getProductsData() |
| 554 | `packages()` | getPackagesData() |

**Subtotal: 8 invalid consumers**

### DirectoryController.php (Public)

| Line | Relationship | Issue |
|------|-------------|-------|
| 38-44 | `withCount(['reviews'])` | Reviews aggregation on Listing - REMOVED |
| 54-60 | `withCount(['reviews'])` | Reviews aggregation on Listing - REMOVED |
| 79-84 | `withCount(['reviews'])` | Reviews aggregation on Listing - REMOVED |
| 169 | `services()` | serviceDetail() |
| 175 | `galleryImages()` | serviceDetail() |
| 184 | `reviews()` | serviceDetail() |
| 190 | `reviews()` | avg rating |

**Subtotal: 7 invalid consumers**

## Total Summary

| Controller | Invalid Consumers |
|-----------|-----------------|
| ListingMinisiteController.php | 36 |
| ListingMinisiteSectionController.php | 8 |
| DirectoryController.php | 7 |
| **TOTAL** | **51** |

## Relationships Removed from Listing.php
These relationships NO LONGER exist on Listing model and must be replaced with direct model queries:

- `socialNetworks()` → `ListingSocialNetwork::forListing($id)`
- `productCategories()` → `ListingProductCategory::forListing($id)`
- `products()` → `ListingProduct::forListing($id)`
- `services()` → `ListingService::forListing($id)`
- `promotions()` → `ListingPromotion::forListing($id)`
- `galleryImages()` → `ListingGalleryImage::forListing($id)`
- `reviews()` → `ListingReview::forListing($id)`
- `faqs()` → `ListingFaq::forListing($id)`
- `features()` → `ListingFeature::forListing($id)`
- `contactForms()` → `ListingContactForm::forListing($id)`
- `appointments()` → `ListingAppointment::forListing($id)`
- `availability()` → `ListingAvailability::forListing($id)`
- `availabilityExceptions()` → `ListingAvailabilityException::forListing($id)`
- `packages()` → `ListingPackage::forListing($id)`

## Valid Relationships (Still on Listing)
- `locations()` - VALID (kept as BASE module)
- `modules()` - VALID
- `user()` - VALID
- `minisiteTheme()` - VALID
