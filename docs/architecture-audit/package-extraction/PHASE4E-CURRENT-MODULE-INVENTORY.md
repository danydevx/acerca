# FASE 4E — CURRENT MODULE INVENTORY

## Module Count Summary

| Category | Count |
|----------|-------|
| Total runtime modules | 35 |
| Composer-owned modules | 10 |
| Local modules remaining | 25 |

## Composer Packages (8)

| Package | Modules | Status |
|---------|---------|--------|
| miniwebs/shared | ListingOfficeHours | EXTRACTED |
| miniwebs/reviews | ListingReviews | EXTRACTED |
| miniwebs/team | ListingTeamMembers | EXTRACTED |
| miniwebs/packages | ListingPackages | EXTRACTED |
| miniwebs/marketing | ListingPromotions | EXTRACTED |
| miniwebs/guests | ListingGuests | EXTRACTED |
| miniwebs/crm | ListingLeads, ListingClients | EXTRACTED |
| miniwebs/catalog | ListingProducts, ListingServices | EXTRACTED |

## Local Modules (25)

| Module | Source | Routes | Migrations | Cross-Dependencies |
|--------|--------|--------|------------|-------------------|
| Analytics | LOCAL | 1 | 0 | ListingAiChatbot, Listings |
| ClientFidelity | LOCAL | 0 | 4 | Listings |
| ListingAbout | LOCAL | 2 | 1 | Listings |
| ListingAiChatbot | LOCAL | 5 | 4 | Listings |
| ListingAppointments | LOCAL | 5 | 1 | ListingLocations, ListingPackages, ListingServices, Listings |
| ListingBranding | LOCAL | 2 | 1 | Listings |
| ListingCheckin | LOCAL | 1 | 2 | ListingGuests |
| ListingContactForm | LOCAL | 4 | 1 | ListingLeads, Listings |
| ListingFaqs | LOCAL | 3 | 1 | Listings |
| ListingFeatures | LOCAL | 4 | 2 | ListingLocations, Listings |
| ListingGallery | LOCAL | 5 | 4 | ListingLocations, Listings |
| ListingHero | LOCAL | 3 | 4 | Listings |
| ListingLocations | LOCAL | 5 | 5 | Listings |
| ListingMinisite | LOCAL | 2 | 1 | ListingContactForm, ListingGallery, ListingPackages, Listings, Properties |
| ListingModules | LOCAL | 2 | 1 | (none) |
| ListingProjects | LOCAL | 1 | 0 | Listings |
| ListingRestaurantMenu | LOCAL | 2 | 7 | Listings |
| ListingSeo | LOCAL | 2 | 1 | Listings |
| ListingSocialMedia | LOCAL | 2 | 1 | Listings |
| ListingTasks | LOCAL | 0 | 1 | Listings |
| Locations | LOCAL | 1 | 2 | (none) |
| MinisiteThemes | LOCAL | 0 | 0 | Listings |
| Orders | LOCAL | 2 | 5 | Listings |
| Properties | LOCAL | 5 | 22 | Listings |
| VCards | LOCAL | 4 | 26 | ListingAiChatbot, Listings |
| Listings | LOCAL | 3 | 0 | 15 modules |

## Module Inventory Table

```
MODULE                    SOURCE  PACKAGE                     CATEGORY
Analytics                 LOCAL   -                           OPTIONAL
ClientFidelity            LOCAL   -                           VERTICAL
ListingAbout              LOCAL   -                           MINISITE
ListingAiChatbot          LOCAL   -                           OPTIONAL
ListingAppointments       LOCAL   -                           SHARED
ListingBranding           LOCAL   -                           MINISITE
ListingCheckin            LOCAL   -                           OPTIONAL
ListingContactForm        LOCAL   -                           MINISITE
ListingFaqs               LOCAL   -                           MINISITE
ListingFeatures           LOCAL   -                           MINISITE
ListingGallery            LOCAL   -                           SHARED
ListingHero               LOCAL   -                           MINISITE
ListingLocations          LOCAL   -                           SHARED
ListingMinisite           LOCAL   -                           MINISITE
ListingModules            LOCAL   -                           BASE
ListingProjects           LOCAL   -                           VERTICAL
ListingRestaurantMenu     LOCAL   -                           VERTICAL
ListingSeo                LOCAL   -                           MINISITE
ListingSocialMedia        LOCAL   -                           MINISITE
ListingTasks              LOCAL   -                           OPTIONAL
Locations                 LOCAL   -                           BASE
MinisiteThemes            LOCAL   -                           MINISITE
Orders                    LOCAL   -                           VERTICAL
Properties                LOCAL   -                           VERTICAL
VCards                    LOCAL   -                           VERTICAL
Listings                  LOCAL   -                           CORE
ListingOfficeHours        COMPOSER  miniwebs/shared            SHARED
ListingReviews            COMPOSER  miniwebs/reviews          SHARED
ListingTeamMembers        COMPOSER  miniwebs/team             SHARED
ListingPackages           COMPOSER  miniwebs/packages         SHARED
ListingPromotions        COMPOSER  miniwebs/marketing         SHARED
ListingGuests            COMPOSER  miniwebs/guests            SHARED
ListingLeads             COMPOSER  miniwebs/crm               SHARED
ListingClients           COMPOSER  miniwebs/crm               SHARED
ListingProducts          COMPOSER  miniwebs/catalog           SHARED
ListingServices          COMPOSER  miniwebs/catalog           SHARED
```

## Verification

```bash
# No duplicate physical ownership
duplicate physical ownership = 0

# Composer packages
composer show miniwebs/* 2>/dev/null | grep -E "^miniwebs" | wc -l
# Result: 8
```
