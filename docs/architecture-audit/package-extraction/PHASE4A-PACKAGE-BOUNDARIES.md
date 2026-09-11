# PHASE 4A — PACKAGE BOUNDARIES

## Classification Review

### Inconsistency Found

**ListingRestaurantMenu** appears in both SHARED and VERTICAL categories.

**Resolution**: Move to VERTICAL only, as RestaurantMenu is a vertical-specific feature (restaurant POS/menu management).

---

## Final Classification

### CORE_REQUIRED (2)

| Module | Package |
|--------|---------|
| Listings | miniwebs/core |
| ListingModules | miniwebs/core |

### BASE (12)

| Module | Package | Group |
|--------|---------|-------|
| Locations | miniwebs/locations | minisite |
| ListingAbout | miniwebs/minisite | minisite |
| ListingBranding | miniwebs/minisite | minisite |
| ListingContactForm | miniwebs/minisite | minisite |
| ListingFaqs | miniwebs/minisite | minisite |
| ListingGallery | miniwebs/media | media |
| ListingHero | miniwebs/minisite | minisite |
| ListingLeads | miniwebs/crm | crm |
| ListingLocations | miniwebs/locations | locations |
| ListingMinisite | miniwebs/core | core |
| ListingSeo | miniwebs/minisite | minisite |
| ListingSocialMedia | miniwebs/minisite | minisite |

### SHARED (10, removed RestaurantMenu)

| Module | Package | Group |
|--------|---------|-------|
| ListingAppointments | miniwebs/appointments | appointments |
| ListingClients | miniwebs/crm | crm |
| ListingGuests | miniwebs/guests | guests |
| ListingOfficeHours | miniwebs/shared | shared |
| ListingPackages | miniwebs/packages | packages |
| ListingProducts | miniwebs/catalog | catalog |
| ListingPromotions | miniwebs/marketing | marketing |
| ListingReviews | miniwebs/reviews | reviews |
| ListingServices | miniwebs/catalog | catalog |
| ListingTeamMembers | miniwebs/team | team |

### VERTICAL (7, added RestaurantMenu)

| Module | Package | Group |
|--------|---------|-------|
| ClientFidelity | miniwebs/fidelity | fidelity |
| ListingProjects | miniwebs/projects | projects |
| ListingRestaurantMenu | miniwebs/restaurant | restaurant |
| Orders | miniwebs/orders | orders |
| Properties | miniwebs/properties | properties |
| VCards | miniwebs/vcards | vcards |

### OPTIONAL (5)

| Module | Package | Group |
|--------|---------|-------|
| Analytics | miniwebs/analytics | analytics |
| ListingAiChatbot | miniwebs/ai-chatbot | ai-chatbot |
| ListingCheckin | miniwebs/checkin | checkin |
| ListingFeatures | miniwebs/features | features |
| ListingTasks | miniwebs/tasks | tasks |

---

## Proposed Package Groups

### miniwebs/core
- Listings
- ListingModules
- ListingMinisite (base minisite composition)

### miniwebs/minisite
- ListingAbout
- ListingBranding
- ListingContactForm
- ListingFaqs
- ListingHero
- ListingSeo
- ListingSocialMedia

### miniwebs/media
- ListingGallery

### miniwebs/locations
- Locations (countries/states/municipalities)
- ListingLocations (listing location management)

### miniwebs/crm
- ListingLeads
- ListingClients

### miniwebs/catalog
- ListingProducts
- ListingServices

### miniwebs/appointments
- ListingAppointments

### miniwebs/guests
- ListingGuests

### miniwebs/packages
- ListingPackages

### miniwebs/marketing
- ListingPromotions

### miniwebs/reviews
- ListingReviews

### miniwebs/team
- ListingTeamMembers

### miniwebs/orders
- Orders

### miniwebs/properties
- Properties

### miniwebs/vcards
- VCards

### miniwebs/restaurant
- ListingRestaurantMenu

### miniwebs/fidelity
- ClientFidelity

### miniwebs/projects
- ListingProjects

### miniwebs/shared
- ListingOfficeHours

### miniwebs/analytics
- Analytics

### miniwebs/ai-chatbot
- ListingAiChatbot

### miniwebs/checkin
- ListingCheckin

### miniwebs/features
- ListingFeatures

### miniwebs/tasks
- ListingTasks

---

## Package Count Summary

| Strategy | Count |
|----------|-------|
| 1-per-module | 35 packages |
| Grouped (recommended) | 20 packages |
| Full consolidation | 5 packages |

**Recommendation**: 20 packages (grouped by domain cohesion)

---

## Modules that could be consolidated further

### Option A: miniwebs/minisite-all
Merge minisite + locations + media into single package for products that want all-in-one minisite features.

### Option B: Keep separated
Maintain separation for products that want granular control.

**Recommendation**: Keep separated but provide meta-package `miniwebs/minisite-bundle` that requires all minisite packages.
