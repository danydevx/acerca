# FASE 4P — Package Dependency Map

## Packages Analyzed

**Total packages**: 22 (top-level under `packages/miniwebs/`)
**Total modules**: 33
**Cross-package dependencies found**: 230 PHP import statements across 31 module pairs

## Module Inventory

| Package | Module(s) |
|---------|-----------|
| analytics | Analytics |
| catalog | ListingProducts, ListingServices |
| client-fidelity | ClientFidelity |
| crm | ListingClients, ListingContactForm, ListingLeads |
| guests | ListingGuests |
| listing-ai-chatbot | ListingAiChatbot |
| listing-appointments | ListingAppointments |
| listing-checkin | ListingCheckin |
| listing-projects | ListingProjects |
| listing-tasks | ListingTasks |
| locations | ListingLocations, Locations |
| marketing | ListingPromotions |
| media | ListingGallery |
| minisite | ListingAbout, ListingBranding, ListingFaqs, ListingFeatures, ListingHero, ListingMinisite, ListingSeo, ListingSocialMedia |
| orders | Orders |
| packages | ListingPackages |
| properties | Properties |
| restaurant | ListingRestaurantMenu |
| reviews | ListingReviews |
| shared | ListingOfficeHours |
| team | ListingTeamMembers |
| vcards | VCards |

## Complete Dependency Graph

```
Analytics
  → Listings (5 files)

ClientFidelity
  → Listings (6 files)

ListingRestaurantMenu
  → ListingMinisite (1 file: RestaurantMinisiteProvider)
  → Listings (13 files)

ListingAbout
  → Listings (4 files)

ListingAiChatbot
  → Listings (3 files)

ListingAppointments
  → ListingLocations (6 files)
  → ListingPackages (1 file)
  → ListingServices (7 files)
  → Listings (14 files)

ListingBranding
  → Listings (3 files)

ListingCheckin
  → ListingGuests (1 file)

ListingClients
  → Listings (3 files)

ListingContactForm
  → ListingLeads (3 files)
  → Listings (4 files)

ListingFaqs
  → Listings (7 files)

ListingFeatures
  → ListingLocations (2 files)
  → Listings (5 files)

ListingGallery
  → ListingLocations (1 file)
  → Listings (7 files)

ListingHero
  → Listings (6 files)

ListingLeads
  → ListingLocations (2 files)
  → Listings (6 files)

ListingLocations
  → Listings (4 files)

ListingMinisite
  → ListingContactForm (1 file)
  → ListingGallery (1 file)
  → ListingPackages (1 file)
  → Listings (7 files)

ListingOfficeHours
  → ListingLocations (1 file)
  → Listings (4 files)

ListingPackages
  → Listings (3 files)

ListingProducts
  → ListingLocations (1 file)
  → Listings (8 files)

ListingProjects
  → Listings (5 files)

ListingPromotions
  → ListingLocations (2 files)
  → Listings (4 files)

ListingReviews
  → Listings (4 files)

ListingSeo
  → Listings (3 files)

ListingServices
  → ListingLocations (1 file)
  → Listings (7 files)

ListingSocialMedia
  → Listings (3 files)

ListingTasks
  → Listings (2 files)

ListingTeamMembers
  → Listings (5 files)

Orders
  → ListingMinisite (1 file: OrderMinisitePageProvider)
  → Listings (5 files)

Properties
  → ListingMinisite (1 file: PropertyMinisiteProvider)
  → Listings (6 files)

VCards
  → ListingAiChatbot (1 file: VCardVisitService → GeoLocationService)
  → Listings (9 files)
```

## Cycles

**Total cycles detected: 0**

No cyclic dependencies found in the cross-package import graph.

## Dependency Counts by Target

| Target Module | Incoming Dependencies |
|--------------|----------------------|
| Listings (CORE) | 31 modules |
| ListingMinisite | 3 modules (Properties, RestaurantMenu, Orders) |
| ListingLocations | 9 modules |
| ListingServices | 1 module (ListingAppointments) |
| ListingLeads | 1 module (ListingContactForm) |
| ListingGuests | 1 module (ListingCheckin) |
| ListingPackages | 1 module (ListingAppointments) |
| ListingAiChatbot | 1 module (VCards) |
| ListingContactForm | 1 module (ListingMinisite) |
| ListingGallery | 1 module (ListingMinisite) |
