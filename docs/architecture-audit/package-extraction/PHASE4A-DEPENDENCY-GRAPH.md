# PHASE 4A — DEPENDENCY GRAPH

## Critical Finding: Massive Coupling Through Listings

**40 circular dependencies detected, all flowing through Listings module.**

The `Listings` module is a **god object** that imports 15 other modules.

---

## Dependency Matrix

### Module → Dependencies (implicit PHP imports)

| Module | Depends On |
|--------|-----------|
| Listings | ListingAbout, ListingAppointments, ListingContactForm, ListingFaqs, ListingFeatures, ListingGallery, ListingHero, ListingLeads, ListingLocations, ListingModules, ListingProducts, ListingPromotions, ListingReviews, ListingSeo, ListingServices |
| ListingMinisite | ListingContactForm, ListingGallery, ListingPackages, Listings, Properties |
| ListingAppointments | ListingLocations, ListingPackages, ListingServices, Listings |
| ListingContactForm | ListingLeads, Listings |
| ListingFeatures | ListingLocations, Listings |
| ListingGallery | ListingLocations, Listings |
| ListingLeads | ListingLocations, Listings |
| ListingLocations | Listings |
| ListingOfficeHours | ListingLocations, Listings |
| ListingProducts | ListingLocations, Listings |
| ListingPromotions | ListingLocations, Listings |
| ListingServices | ListingLocations, Listings |
| ListingGuests | (none) |
| ListingModules | (none) |
| Locations | (none) |
| Properties | Listings |
| VCards | ListingAiChatbot, Listings |
| Analytics | ListingAiChatbot, Listings |
| ListingCheckin | ListingGuests |
| ClientFidelity | Listings |
| ListingAbout | Listings |
| ListingAiChatbot | Listings |
| ListingBranding | Listings |
| ListingClients | Listings |
| ListingFaqs | Listings |
| ListingHero | Listings |
| ListingPackages | Listings |
| ListingProjects | Listings |
| ListingPromotions | Listings |
| ListingRestaurantMenu | Listings |
| ListingReviews | Listings |
| ListingSeo | Listings |
| ListingServices | Listings |
| ListingSocialMedia | Listings |
| ListingTasks | Listings |
| ListingTeamMembers | Listings |
| Orders | Listings |

---

## Circular Dependencies (40 total)

### Length-2 Cycles (26)

```
Listings <-> ListingServices
Listings <-> ListingFaqs
Listings <-> ListingContactForm
Listings <-> ListingPromotions
Listings <-> ListingFeatures
Listings <-> ListingHero
Listings <-> ListingLeads
Listings <-> ListingGallery
Listings <-> ListingProducts
Listings <-> ListingReviews
Listings <-> ListingSeo
Listings <-> ListingAbout
Listings <-> ListingAppointments
Listings <-> ListingLocations
Listings <-> ListingPackages
Listings <-> ListingClients
Listings <-> ListingTeamMembers
Listings <-> ListingSocialMedia
Listings <-> ListingTasks
Listings <-> ClientFidelity
Listings <-> Properties
Listings <-> ListingRestaurantMenu
Listings <-> ListingProjects
Listings <-> Orders
Listings <-> ListingBranding
Listings <-> ListingAiChatbot
```

### Length-3 Cycles (14)

```
ListingLocations -> Listings -> ListingFeatures -> ListingLocations
ListingLocations -> Listings -> ListingLeads -> ListingLocations
ListingLocations -> Listings -> ListingGallery -> ListingLocations
ListingLeads -> Listings -> ListingContactForm -> ListingLeads
Listings -> ListingProducts -> ListingLocations -> Listings
Listings -> ListingServices -> ListingLocations -> Listings
Listings -> ListingPromotions -> ListingLocations -> Listings
Listings -> ListingOfficeHours -> ListingLocations -> Listings
ListingContactForm -> Listings -> ListingLeads -> ListingContactForm
ListingGallery -> Listings -> ListingLeads -> ListingGallery
ListingAppointments -> ListingServices -> Listings -> ListingAppointments
ListingAppointments -> ListingLocations -> Listings -> ListingAppointments
ListingAppointments -> ListingPackages -> Listings -> ListingAppointments
ListingMinisite -> ListingGallery -> Listings -> ListingMinisite
```

---

## Proposed Package Dependency Graph

```
miniwebs/core
  └── (no module dependencies - base)

miniwebs/minisite
  └── miniwebs/core

miniwebs/media
  └── miniwebs/core
  └── miniwebs/locations (for location associations)

miniwebs/locations
  └── miniwebs/core

miniwebs/crm
  └── miniwebs/core
  └── miniwebs/locations

miniwebs/catalog
  └── miniwebs/core
  └── miniwebs/locations

miniwebs/appointments
  └── miniwebs/core
  └── miniwebs/locations
  └── miniwebs/packages

miniwebs/guests
  └── miniwebs/core

miniwebs/packages
  └── miniwebs/core

miniwebs/marketing
  └── miniwebs/core
  └── miniwebs/locations

miniwebs/reviews
  └── miniwebs/core

miniwebs/team
  └── miniwebs/core

miniwebs/orders
  └── miniwebs/core

miniwebs/properties
  └── miniwebs/core

miniwebs/vcards
  └── miniwebs/core
  └── miniwebs/ai-chatbot

miniwebs/restaurant
  └── miniwebs/core

miniwebs/fidelity
  └── miniwebs/core

miniwebs/projects
  └── miniwebs/core

miniwebs/shared
  └── miniwebs/core

miniwebs/analytics
  └── miniwebs/core
  └── miniwebs/ai-chatbot

miniwebs/ai-chatbot
  └── miniwebs/core

miniwebs/checkin
  └── miniwebs/core
  └── miniwebs/guests

miniwebs/features
  └── miniwebs/core
  └── miniwebs/locations

miniwebs/tasks
  └── miniwebs/core
```

---

## Circular Dependencies in Packages: 0

By grouping at package level, we break the circular dependencies because:
- Individual module circular deps become package-internal
- Packages only depend on miniwebs/core (base)
- No package-to-package circular deps

---

## Key Insight: Break the God Object

The current `Listings` model imports from 15 modules. This is the root cause.

**Solution Options**:

### Option A: Interfaces/Traits
Use Laravel's polymorphic relationships to avoid direct imports.

### Option B: Event-Driven Architecture
Modules communicate via events, not direct model imports.

### Option C: Accept Package Boundary
When extracted as packages, the circular deps become internal to the `miniwebs/core` meta-package. Individual packages depend only on core.

**Recommendation**: Option C - The package boundary naturally encapsulates the circular deps within core, while individual domain packages remain clean.
