# FASE 4E — NEXT PACKAGES

## Appointments Readiness

### Analysis

**Module:** ListingAppointments
**Routes:** 5 (admin, admin_api, api, member, public)
**Migrations:** 1
**Frontend:** Complex (calendar, slots, availability)

### Dependencies

```
ListingAppointments
├── ListingServices (PACKAGE - miniwebs/catalog) ← BLOCKING
├── ListingPackages (PACKAGE - miniwebs/packages) ← BLOCKING
├── ListingLocations (LOCAL) ← Can extract first
└── Listings (LOCAL - CORE)
```

### Blocker Resolution

1. **ListingServices**: Already extracted to `miniwebs/catalog`. ListingAppointments uses `ListingService` model.

   **Options:**
   - Extract Appointments together with Catalog (already done, but catalog is already extracted)
   - Make Appointments depend on local Services stub
   - Don't extract Appointments yet

2. **ListingPackages**: ListingAppointments uses `ListingPackage` model.

   **Options:**
   - Extract ListingsPackages first (already done as miniwebs/packages)
   - Create interface/abstraction

### Availability Logic

ListingAppointments has complex availability logic:
- `ListingAvailability`
- `ListingAvailabilityException`
- `ListingAppointmentSlot`

This is its own domain - appointments scheduling.

### Recommendation

**Status: BLOCKED**

**Reason:** Depends on two packages that are already extracted:
- ListingServices (miniwebs/catalog)
- ListingPackages (miniwebs/packages)

**Resolution Path:**
1. Accept that ListingAppointments has cross-package dependencies
2. Extract ListingAppointments AFTER ListingServices and ListingPackages are confirmed local OR
3. Use dependency injection/interfaces to decouple

---

## Locations Readiness

### Analysis

**Modules:** Locations, ListingLocations

**Routes:**
- Locations: 1
- ListingLocations: 5

**Migrations:**
- Locations: 2
- ListingLocations: 5

### Dependencies

```
Locations (BASE)
└── No external dependencies

ListingLocations (SHARED)
├── Listings (LOCAL - CORE)
└── Locations (BASE - local)
```

### Package Proposal

```
miniwebs/locations
├── Locations (BASE)
└── ListingLocations (SHARED)
```

**Why together?**
- ListingLocations depends on Locations
- Both are geographic/address related
- Low coupling, high cohesion

### Recommendation

**Status: READY**

**Risk:** LOW
**Dependencies:** Only CORE (Listings) and itself

---

## Media Readiness

### Analysis

**Module:** ListingGallery
**Routes:** 5
**Migrations:** 4

### Dependencies

```
ListingGallery
├── Listings (LOCAL - CORE)
└── ListingLocations (LOCAL - will be in miniwebs/locations)
```

### Package Proposal

```
miniwebs/media
├── ListingGallery
└── (future: other media modules)
```

### Concerns

1. **GalleryBulkUploadTest failures**: Tests reference `App\Http\Controllers\Member\GalleryController` which doesn't exist - this is a pre-existing portability debt issue
2. **Storage**: Uses Laravel storage for uploads
3. **Image processing**: May need intervention/image package

### Recommendation

**Status: READY (after Locations)**

**Risk:** MEDIUM (due to test failures and upload complexity)

---

## Minisite Readiness

### Analysis

**Module:** ListingMinisite + related
**Routes:** 2 route files for core minisite
**Migrations:** 1 (plus many for related modules)

### Dependencies (Updated)

After dead code analysis, actual dependencies:
```
ListingMinisite
├── Properties (VERTICAL - BLOCKS extraction)
├── ListingContactForm (MINISITE - but depends on ListingLeads)
└── Listings (CORE)
```

### Package Proposal

```
miniwebs/minisite
├── ListingMinisite (depends on Properties)
├── ListingAbout
├── ListingBranding
├── ListingHero
├── ListingSeo
├── ListingSocialMedia
├── ListingFaqs
└── ListingFeatures (depends on ListingLocations)
```

### Recommendation

**Status: BLOCKED (by Properties and Dependencies)**

**First extract:**
1. `miniwebs/locations` (Locations + ListingLocations)
2. `miniwebs/media` (ListingGallery)
3. Vertical modules that block minisite

---

## Vertical Modules

### Properties

**Status:** VERTICAL
**Routes:** 5
**Migrations:** 22
**Dependencies:** Listings only
**Package:** `miniwebs/verticals` (with other verticals)

### VCards

**Status:** VERTICAL
**Routes:** 4
**Migrations:** 26
**Dependencies:** Listings, ListingAiChatbot (local)
**Package:** `miniwebs/verticals` (with other verticals)

### ListingRestaurantMenu

**Status:** VERTICAL
**Routes:** 2
**Migrations:** 7
**Dependencies:** Listings only
**Package:** `miniwebs/verticals` (with other verticals)

### Orders

**Status:** VERTICAL
**Routes:** 2
**Migrations:** 5
**Dependencies:** Listings only
**Package:** `miniwebs/verticals` (with other verticals)

### ClientFidelity

**Status:** VERTICAL
**Routes:** 0
**Migrations:** 4
**Dependencies:** Listings only
**Package:** `miniwebs/optional` or `miniwebs/verticals`

### ListingProjects

**Status:** VERTICAL
**Routes:** 1
**Migrations:** 0
**Dependencies:** Listings only
**Package:** `miniwebs/verticals` (with other verticals)

---

## Optional Modules

### Analytics

**Status:** OPTIONAL
**Routes:** 1
**Migrations:** 0
**Dependencies:** ListingAiChatbot, Listings
**Package:** `miniwebs/optional`

### ListingAiChatbot

**Status:** OPTIONAL
**Routes:** 5
**Migrations:** 4
**Dependencies:** Listings
**Note:** Used by VCards
**Package:** `miniwebs/optional` (but may need special handling due to VCards)

### ListingCheckin

**Status:** OPTIONAL
**Routes:** 1
**Migrations:** 2
**Dependencies:** ListingGuests (PACKAGE - miniwebs/guests)
**Blocker:** Depends on extracted package

### ListingTasks

**Status:** OPTIONAL
**Routes:** 0
**Migrations:** 1
**Dependencies:** Listings
**Package:** `miniwebs/optional`
