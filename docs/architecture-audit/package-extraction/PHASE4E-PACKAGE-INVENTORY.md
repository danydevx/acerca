# FASE 4E — PACKAGE INVENTORY

## Current State

### Extracted Packages (8)

| Package | Modules | Phase | Routes | Status |
|---------|---------|-------|--------|--------|
| miniwebs/shared | ListingOfficeHours | 4B | ? | EXTRACTED |
| miniwebs/reviews | ListingReviews | 4C | ? | EXTRACTED |
| miniwebs/team | ListingTeamMembers | 4C | ? | EXTRACTED |
| miniwebs/packages | ListingPackages | 4C | ? | EXTRACTED |
| miniwebs/marketing | ListingPromotions | 4C | ? | EXTRACTED |
| miniwebs/guests | ListingGuests | 4D | 5 | EXTRACTED |
| miniwebs/crm | ListingLeads, ListingClients | 4D | 27 | EXTRACTED |
| miniwebs/catalog | ListingProducts, ListingServices | 4D | 111 | EXTRACTED |

### Remaining Local Modules (25)

| Module | Category | Proposed Package | Blocked By |
|--------|----------|-----------------|------------|
| Analytics | OPTIONAL | miniwebs/optional | ListingAiChatbot |
| ClientFidelity | VERTICAL | miniwebs/verticals | - |
| ListingAbout | MINISITE | miniwebs/minisite | - |
| ListingAiChatbot | OPTIONAL | miniwebs/optional | - |
| ListingAppointments | SHARED | miniwebs/appointments | ListingServices, ListingPackages |
| ListingBranding | MINISITE | miniwebs/minisite | - |
| ListingCheckin | OPTIONAL | miniwebs/optional | ListingGuests |
| ListingContactForm | MINISITE | miniwebs/crm | ListingLeads |
| ListingFaqs | MINISITE | miniwebs/minisite | - |
| ListingFeatures | MINISITE | miniwebs/minisite | ListingLocations |
| ListingGallery | SHARED | miniwebs/media | ListingLocations |
| ListingHero | MINISITE | miniwebs/minisite | - |
| ListingLocations | SHARED | miniwebs/locations | Locations |
| ListingMinisite | MINISITE | miniwebs/minisite | Properties, ListingContactForm |
| ListingModules | BASE | miniwebs/core | - |
| ListingProjects | VERTICAL | miniwebs/verticals | - |
| ListingRestaurantMenu | VERTICAL | miniwebs/verticals | - |
| ListingSeo | MINISITE | miniwebs/minisite | - |
| ListingSocialMedia | MINISITE | miniwebs/minisite | - |
| ListingTasks | OPTIONAL | miniwebs/optional | - |
| Locations | BASE | miniwebs/locations | - |
| Listings | CORE | miniwebs/core | (all modules) |
| MinisiteThemes | MINISITE | miniwebs/minisite | - |
| Orders | VERTICAL | miniwebs/verticals | - |
| Properties | VERTICAL | miniwebs/verticals | - |
| VCards | VERTICAL | miniwebs/verticals | ListingAiChatbot |

## Package Count Reconciliation

### Proposed Final Packages

```
Already Extracted: 8
├── miniwebs/shared
├── miniwebs/reviews
├── miniwebs/team
├── miniwebs/packages
├── miniwebs/marketing
├── miniwebs/guests
├── miniwebs/crm
└── miniwebs/catalog

Planned: 6
├── miniwebs/locations
├── miniwebs/media
├── miniwebs/minisite
├── miniwebs/minisite-ext
├── miniwebs/verticals
└── miniwebs/optional

Will Remain Local: 3
├── Listings (CORE)
├── ListingModules (BASE - ties to CORE)
└── ListingCheckin (BLOCKED)

TOTAL: 8 + 6 = 14 packages
```

## Do Not Over-Fragment Rule

The original FASE 4A had a goal of 20-25 packages which led to over-fragmentation concerns. The current plan uses **14 packages** which is more reasonable.

### Cohesive Groupings Applied

| Group | Modules | Rationale |
|-------|---------|-----------|
| miniwebs/crm | Leads + Clients | Both CRM concepts |
| miniwebs/catalog | Products + Services | Both catalog concepts |
| miniwebs/minisite | About, Branding, Hero, Seo, Social, Faqs, Themes | Minisite section modules |
| miniwebs/verticals | Properties, Restaurant, Orders, Projects, ClientFidelity, VCards | Vertical-specific modules |
| miniwebs/optional | AiChatbot, Tasks, Analytics | Optional features |

## Product Repository Split (Future)

### invitations-saas
```json
{
    "require": {
        "miniwebs/core": "*",
        "miniwebs/locations": "*",
        "miniwebs/minisite": "*",
        "miniwebs/guests": "*",
        "miniwebs/optional": "*",
        "miniwebs/appointments": "*",
        "miniwebs/media": "*",
        "miniwebs/team": "*",
        "miniwebs/reviews": "*"
    }
}
```

### realestate-saas
```json
{
    "require": {
        "miniwebs/core": "*",
        "miniwebs/locations": "*",
        "miniwebs/minisite": "*",
        "miniwebs/verticals": "*",
        "miniwebs/media": "*",
        "miniwebs/optional": "*",
        "miniwebs/crm": "*"
    }
}
```

### Missing from All Products

- **miniwebs/packages**: Used by Appointments (blocked)
- **miniwebs/marketing**: Promotions (may not be needed by all)

## Portability Debt

### Confirmed Debts

1. `App\Http\Controllers\Controller` - used everywhere
2. `App\Services\ActivityService` - used in 36 controllers
3. `App\Models\User` - used in 34 modules

### New Debts Identified

| Debt | Location | Impact |
|------|----------|--------|
| GalleryBulkUploadTest | Tests | References non-existent `App\Http\Controllers\Member\GalleryController` |
| Minisite route helper | Routes | Some routes may use app-specific helpers |

### Target

```
new undocumented portability debt = 0 (same as before)
```

## Architectural Debt: The Listing Hub

### Problem

Listings model has 28 Eloquent relationships to other modules' models.

### Impact

- Listings cannot be extracted (circular dependency)
- All feature modules are tightly coupled to Listings
- Refactoring would require breaking these relationships

### Current Resolution

Keep Listings LOCAL forever. Accept that miniwebs/* packages are subsystems that extend the Listings aggregate.

### Future Improvement (Not in Scope)

Use Laravel's lazy loading, events, or domain events to decouple:
```php
// Instead of direct relationship
$listing->products;

// Use event
event(new ListingProductsRequested($listing));
```
