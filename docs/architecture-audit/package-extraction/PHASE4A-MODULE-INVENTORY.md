# PHASE 4A — MODULE INVENTORY

## Summary

| Metric | Count |
|--------|-------|
| Total Modules | 35 |
| CORE_REQUIRED | 2 |
| BASE | 12 |
| SHARED | 11 |
| VERTICAL | 6 |
| OPTIONAL | 5 |

---

## Complete Module Inventory

| # | Module | Category | Has PHP | Has Routes | Has Migrations | Has Config | Has Frontend | Has Vite | Has Assets | Package Candidate |
|---|--------|----------|---------|-----------|----------------|-----------|------------|---------|------------|------------------|
| 1 | Listings | CORE_REQUIRED | Yes | Yes | Yes (ext) | Yes | Yes | Yes | Yes | `miniwebs/core` |
| 2 | ListingModules | CORE_REQUIRED | Yes | Yes | Yes | Yes | Yes | Yes | Yes | `miniwebs/core` |
| 3 | Locations | BASE | Yes | Yes | Yes | No | Yes | No | No | `miniwebs/locations` |
| 4 | ListingAbout | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/minisite` |
| 5 | ListingBranding | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/minisite` |
| 6 | ListingContactForm | BASE | Yes | Yes | Yes | Yes | Yes | Yes | Yes | `miniwebs/minisite` |
| 7 | ListingFaqs | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/minisite` |
| 8 | ListingGallery | BASE | Yes | Yes | Yes | Yes | Yes | No | No | `miniwebs/media` |
| 9 | ListingHero | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/minisite` |
| 10 | ListingLeads | BASE | Yes | Yes | Yes | Yes | Yes | Yes | Yes | `miniwebs/crm` |
| 11 | ListingLocations | BASE | Yes | Yes | Yes | Yes | Yes | Yes | Yes | `miniwebs/locations` |
| 12 | ListingMinisite | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/core` |
| 13 | ListingSeo | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/minisite` |
| 14 | ListingSocialMedia | BASE | Yes | Yes | Yes | No | No | No | No | `miniwebs/minisite` |
| 15 | ListingAppointments | SHARED | Yes | Yes | Yes | Yes | No | No | No | `miniwebs/appointments` |
| 16 | ListingClients | SHARED | Yes | Yes | Yes | No | No | No | No | `miniwebs/crm` |
| 17 | ListingGuests | SHARED | Yes | Yes | Yes | Yes | No | No | No | `miniwebs/guests` |
| 18 | ListingOfficeHours | SHARED | Yes | Yes | No | No | No | No | No | `miniwebs/shared` |
| 19 | ListingPackages | SHARED | Yes | Yes | Yes | No | No | No | No | `miniwebs/packages` |
| 20 | ListingProducts | SHARED | Yes | Yes | Yes | Yes | Yes | No | No | `miniwebs/catalog` |
| 21 | ListingPromotions | SHARED | Yes | Yes | Yes | No | No | No | No | `miniwebs/marketing` |
| 22 | ListingRestaurantMenu | VERTICAL | Yes | Yes | Yes | No | No | No | No | `miniwebs/restaurant` |
| 23 | ListingReviews | SHARED | Yes | Yes | Yes | No | No | No | No | `miniwebs/reviews` |
| 24 | ListingServices | SHARED | Yes | Yes | Yes | Yes | Yes | Yes | Yes | `miniwebs/catalog` |
| 25 | ListingTeamMembers | SHARED | Yes | Yes | Yes | No | No | No | No | `miniwebs/team` |
| 26 | ClientFidelity | VERTICAL | Yes | Yes | Yes | No | No | No | No | `miniwebs/fidelity` |
| 27 | ListingProjects | VERTICAL | Yes | Yes | No | No | No | No | No | `miniwebs/projects` |
| 28 | Orders | VERTICAL | Yes | Yes | Yes | Yes | Yes | No | No | `miniwebs/orders` |
| 29 | Properties | VERTICAL | Yes | Yes | Yes | Yes | Yes | No | No | `miniwebs/properties` |
| 30 | VCards | VERTICAL | Yes | Yes | Yes | Yes | Yes | Yes | Yes | `miniwebs/vcards` |
| 31 | Analytics | OPTIONAL | Yes | Yes | No | No | Yes | No | Yes | `miniwebs/analytics` |
| 32 | ListingAiChatbot | OPTIONAL | Yes | Yes | Yes | Yes | Yes | No | No | `miniwebs/ai-chatbot` |
| 33 | ListingCheckin | OPTIONAL | Yes | Yes | Yes | Yes | No | No | No | `miniwebs/checkin` |
| 34 | ListingFeatures | OPTIONAL | Yes | Yes | Yes | No | No | No | No | `miniwebs/features` |
| 35 | ListingTasks | OPTIONAL | Yes | Yes | Yes | No | No | No | No | `miniwebs/tasks` |

---

## Key Findings

1. **No explicit dependencies**: None of the 35 modules declare dependencies in `module.json` `requires` field
2. **Routing patterns**: Most modules use 4-route pattern (admin, member, api, public/web)
3. **Frontend assets**: Only 8 modules have frontend assets (js/sass/less)
4. **Vite-enabled**: 7 modules have `vite.config.js`
5. **Migration distribution**: Ranges from 0 (Analytics, ListingOfficeHours) to 26 (VCards)
6. **Circular dependencies**: 40 circular dependencies all flowing through `Listings` module

---

## Modules with Zero Migrations

- Analytics
- ListingOfficeHours
- Listings (main table in `database/migrations/`)
- MinisiteThemes
- ListingProjects

---

## Modules with Most Migrations

| Module | Count |
|--------|-------|
| VCards | 26 |
| Properties | 22 |
| ListingRestaurantMenu | 7 |
| ListingLocations | 5 |
| ClientFidelity | 4 |
| ListingAiChatbot | 4 |
| ListingGallery | 4 |
| ListingHero | 4 |
| Orders | 5 |
