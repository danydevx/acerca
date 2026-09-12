# FASE 4E — EXTRACTION ORDER

## Updated Dependency Graph

```
CORE (CANNOT EXTRACT YET - circular with everything)
└── Listings

BASE
├── ListingModules ← CAN EXTRACT (no dependencies)
└── Locations ← CAN EXTRACT (no dependencies)

SHARED (blocked by packages)
├── ListingLocations ← BLOCKED (depends on Locations)
├── ListingGallery ← BLOCKED (depends on ListingLocations)
├── ListingAppointments ← BLOCKED (depends on ListingServices + ListingPackages)
└── ListingContactForm ← BLOCKED (depends on ListingLeads)

PACKAGES (already extracted)
├── miniwebs/shared (ListingOfficeHours)
├── miniwebs/reviews (ListingReviews)
├── miniwebs/team (ListingTeamMembers)
├── miniwebs/packages (ListingPackages)
├── miniwebs/marketing (ListingPromotions)
├── miniwebs/guests (ListingGuests)
├── miniwebs/crm (ListingLeads, ListingClients)
└── miniwebs/catalog (ListingProducts, ListingServices)

MINISITE (blocked)
├── ListingAbout ← CAN EXTRACT
├── ListingBranding ← CAN EXTRACT
├── ListingFaqs ← CAN EXTRACT
├── ListingHero ← CAN EXTRACT
├── ListingSeo ← CAN EXTRACT
├── ListingSocialMedia ← CAN EXTRACT
├── ListingFeatures ← BLOCKED (depends on ListingLocations)
├── ListingMinisite ← BLOCKED (depends on Properties, ListingContactForm)
└── MinisiteThemes ← CAN EXTRACT

VERTICAL (blocked by verticals)
├── Properties ← CAN EXTRACT (but VERTICAL)
├── ListingRestaurantMenu ← CAN EXTRACT (VERTICAL)
├── Orders ← CAN EXTRACT (VERTICAL)
├── ListingProjects ← CAN EXTRACT (VERTICAL)
├── ClientFidelity ← CAN EXTRACT (VERTICAL)
└── VCards ← BLOCKED (depends on ListingAiChatbot)

OPTIONAL (blocked by other modules)
├── Analytics ← BLOCKED (depends on ListingAiChatbot)
├── ListingAiChatbot ← CAN EXTRACT
└── ListingCheckin ← BLOCKED (depends on ListingGuests which is PACKAGE)
└── ListingTasks ← CAN EXTRACT
```

## Realization: CORE Cannot Be Extracted

The Listings module (CORE) has bidirectional dependencies with ALL other modules:

```
Listings → [Every other module] → Listings
```

This creates an extraction impasse. **Listings can only be extracted LAST**, after all other modules are extracted.

But other modules depend on Listings, so Listings must be extracted FIRST.

### Resolution

**Listings will remain LOCAL forever** (or until a major refactor breaks the circular dependency using DDD aggregates with events/interfaces).

**This is acceptable** because:
1. Listings is the CORE domain - it makes sense for it to stay in the main platform
2. The extracted packages are SUBSYSTEMS that attach to Listings
3. The architecture becomes: Core Platform + Extracted Feature Packages

## Recommended Extraction Order

Given the dependency analysis, here's the actual order:

### Phase 4F: Locations + Media

```
FASE 4F.1: Locations
├── Locations (BASE - no deps)
└── ListingLocations (SHARED - depends on Locations)

FASE 4F.2: Media
└── ListingGallery (SHARED - depends on ListingLocations)
```

**Why:** Removes blocking dependencies for Features and Minisite

---

### Phase 4G: Minisite Core

Extract minisite modules that have NO blocking dependencies:

```
miniwebs/minisite (core)
├── ListingAbout
├── ListingBranding
├── ListingFaqs
├── ListingHero
├── ListingSeo
├── ListingSocialMedia
└── MinisiteThemes
```

**Note:** ListingFeatures and ListingMinisite are blocked by ListingLocations (4F solves this)

---

### Phase 4H: Vertical Modules

```
miniwebs/verticals
├── Properties (VERTICAL)
├── ListingRestaurantMenu (VERTICAL)
├── Orders (VERTICAL)
├── ListingProjects (VERTICAL)
└── ClientFidelity (VERTICAL)
```

**Why:** These are independent verticals that can be extracted together

---

### Phase 4I: Optional Modules

```
miniwebs/optional
├── ListingAiChatbot (OPTIONAL)
├── ListingTasks (OPTIONAL)
└── Analytics (depends on ListingAiChatbot - extract together)
```

**Note:** ListingCheckin depends on ListingGuests (PACKAGE) - BLOCKED

---

### Phase 4J: Extended Minisite

After Locations is extracted (4F):

```
miniwebs/minisite-extended
├── ListingFeatures (now has no blocking deps)
└── ListingMinisite (now has no blocking deps)
```

---

### Phase 4K: CRM Extension

```
miniwebs/crm (already done)
├── ListingLeads ✓
├── ListingClients ✓
└── + ListingContactForm (when ready)
```

**Note:** ListingContactForm is minisite-related but depends on ListingLeads (CRM)

---

### Remaining Blockers

1. **ListingCheckin → ListingGuests (PACKAGE)**
   - Cannot extract ListingGuests (already package)
   - Cannot extract ListingCheckin (depends on package)
   - **Solution:** Keep ListingCheckin local forever OR refactor to not use ListingGuests model

2. **VCards → ListingAiChatbot (local, optional)**
   - VCards depends on GeoLocationService from ListingAiChatbot
   - **Solution:** Extract ListingAiChatbot first (4I)

---

## Final Package Inventory

| # | Package | Modules | Status | Phase |
|---|---------|---------|--------|-------|
| 1 | miniwebs/shared | ListingOfficeHours | EXTRACTED | 4B |
| 2 | miniwebs/reviews | ListingReviews | EXTRACTED | 4C |
| 3 | miniwebs/team | ListingTeamMembers | EXTRACTED | 4C |
| 4 | miniwebs/packages | ListingPackages | EXTRACTED | 4C |
| 5 | miniwebs/marketing | ListingPromotions | EXTRACTED | 4C |
| 6 | miniwebs/guests | ListingGuests | EXTRACTED | 4D |
| 7 | miniwebs/crm | ListingLeads, ListingClients | EXTRACTED | 4D |
| 8 | miniwebs/catalog | ListingProducts, ListingServices | EXTRACTED | 4D |
| 9 | miniwebs/locations | Locations, ListingLocations | PLANNED | 4F |
| 10 | miniwebs/media | ListingGallery | PLANNED | 4F |
| 11 | miniwebs/minisite | 7 modules | PLANNED | 4G |
| 12 | miniwebs/minisite-ext | ListingFeatures, ListingMinisite | PLANNED | 4J |
| 13 | miniwebs/verticals | 6 modules | PLANNED | 4H |
| 14 | miniwebs/optional | ListingAiChatbot, ListingTasks, Analytics | PLANNED | 4I |

**Total packages: 14 (8 extracted + 6 planned)**

---

## Modules That Will Remain LOCAL

| Module | Reason |
|--------|--------|
| Listings | CORE - circular dependency with all modules |
| ListingModules | BASE - should be with CORE |
| ListingCheckin | BLOCKED by ListingGuests (package) |

---

## Summary

- **8 packages already extracted** (FASE 4B-4D)
- **6 packages planned** (FASE 4F-4J)
- **3 modules will remain local** (CORE)
- **Extraction is now dependency-ordered** rather than arbitrary
