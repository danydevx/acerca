# FASE 4E — CORE BOUNDARY

## Core Rule

> **CORE** = Infrastructure/domain base necessary for ALL products
> **BASE** = Common utilities that many modules need but aren't product-specific

## CORE Candidates

### Listings — **CONFIRMED CORE**

**Evidence:**
- Every module depends on Listings
- Listing model is the aggregate root for all business data
- Contains core business logic: `ListingStatus`, `ListingType`, `ListingVisibility`
- SaaS without listings doesn't make sense

**Decision: CORE**

### ListingModules — **CONFIRMED BASE**

**Evidence:**
- Manages which modules are enabled per listing
- No external dependencies
- Required by all SaaS products that use the module system

**Decision: BASE**

### Locations — **CONFIRMED BASE**

**Evidence:**
- Geographic data (Countries, States, Municipalities)
- No external dependencies
- Common utility used by many verticals
- Real Estate SaaS needs it, Restaurant SaaS might not, but it's still "base infrastructure"

**Decision: BASE**

## Rejected from Core

| Module | Reason | Proposed Category |
|--------|--------|------------------|
| ListingMinisite | Product-specific (minisite is a product feature) | MINISITE |
| ListingGallery | Could be used outside minisites | SHARED |
| ListingLocations | Could be shared but depends on Locations | SHARED |
| ListingAppointments | Not all products need appointments | SHARED |
| Properties | Vertical-specific (real estate) | VERTICAL |
| VCards | Vertical-specific | VERTICAL |
| ListingRestaurantMenu | Vertical-specific (restaurant) | VERTICAL |
| Orders | Vertical-specific | VERTICAL |
| ClientFidelity | Vertical-specific | VERTICAL |
| ListingProjects | Vertical-specific | VERTICAL |

## Core Package: miniwebs/core

### Proposed Contents

```text
miniwebs/core
├── Listings (CORE - aggregate root)
├── ListingModules (BASE - module management)
└── Locations (BASE - geographic utilities)
```

### What DOES NOT belong in miniwebs/core

- Any module with **vertical-specific** data (Properties, VCards, Restaurant, Orders)
- Any module that is **product-specific** (Minisite stack)
- Any module that is **optional** (Analytics, AiChatbot, Checkin, Tasks)

## CORE TEST Applied

| Module | Invitations SaaS | Real Estate SaaS | Restaurant SaaS | No-minisite product | Is Core? |
|--------|-----------------|------------------|-----------------|---------------------|----------|
| Listings | YES | YES | YES | YES | **CORE** |
| ListingModules | YES | YES | YES | YES | **BASE** |
| Locations | YES | YES | YES | Maybe | **BASE** |

### Answer to "Would a product without minisite need this?"

- **Listings**: YES - core business entity
- **ListingModules**: YES - module system exists independently
- **Locations**: YES - geographic data is universal

## miniwebs/core vs Product Meta-packages

### Core Package
Infrastructure that ALL products need to function.

### Product Meta-package (NOT core)
A bundle of packages for a specific product type.

**Example:**
```json
// NOT miniwebs/core
// This should be miniwebs/invitations or miniwebs/platform
{
    "require": {
        "miniwebs/core": "*",
        "miniwebs/minisite": "*",
        "miniwebs/media": "*",
        "miniwebs/locations": "*",
        "miniwebs/guests": "*",
        "miniwebs/ai-chatbot": "*"
    }
}
```

## Decision: miniwebs/core should NOT aggregate all packages

The `miniwebs/core` package should ONLY contain:
1. Listings
2. ListingModules
3. Locations (or keep as BASE local)

It should NOT be a meta-package that requires all other miniwebs packages.

## Summary

```
CORE:
- Listings
- ListingModules

BASE:
- Locations

NOT CORE (will be extracted to other packages):
- ListingAppointments → miniwebs/appointments (SHARED)
- ListingLocations → miniwebs/locations (SHARED with Locations dependency)
- ListingGallery → miniwebs/media (SHARED)
- ListingMinisite stack → miniwebs/minisite (PRODUCT)
- Vertical modules → miniwebs/verticals (VERTICAL)
- Optional modules → miniwebs/optional (OPTIONAL)
```
