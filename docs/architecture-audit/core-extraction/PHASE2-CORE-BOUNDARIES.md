# PHASE 2 — CORE BOUNDARIES

**Date:** 2026-09-10
**Goal:** Define what belongs to Core vs Modules, thin Listing, decouple MinisiteTheme from ListingType

---

## CLASSIFICATION SYSTEM

```
CORE           — Concepts universal to ALL products (User, Auth, Billing basics)
BASE MODULE    — Optional module that ANY product may enable (Gallery, SEO, ContactForms)
SHARED MODULE  — Used by multiple products but NOT by all (Properties, VCards, Restaurant)
VERTICAL MODULE— Specific to ONE product line (Restaurant-specific, RealEstate-specific)
PRODUCT-SPECIFIC — Lives only in one product repository
```

---

## CONCEPT CLASSIFICATION

### USER / AUTH / PERMISSIONS

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| User | CORE | Universal - every product needs users |
| Role | CORE | Universal - RBAC needed everywhere |
| Permission | CORE | Universal |
| Team/Organization | BASE MODULE | Multi-tenant SaaS foundation |

### LISTING / BUSINESS

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| Listing | CORE | The central entity ALL products share |
| ListingModule | CORE | Modules enabled per listing - universal |
| ListingType | MOVE_TO_SHARED | Contains vertical knowledge (see PHASE2-LISTING-TYPE-AUDIT.md) |
| ListingLocation | BASE MODULE | Used by many products but not all |
| MinisiteTheme | MOVE_TO_SHARED | Knows about verticals - must be decoupled |

### CONTENT / MEDIA

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| ListingHero | BASE MODULE | Many products use hero sections |
| ListingAbout | BASE MODULE | Many products use about sections |
| ListingGallery | BASE MODULE | Almost universal |
| ListingSocialNetwork | BASE MODULE | Most products need social links |
| Media/FileUploads | BASE MODULE | Universal file handling |

### ENGAGEMENT

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| ListingContactForm | BASE MODULE | Nearly universal |
| ListingFaq | BASE MODULE | Common across products |
| ListingReview | SHARED MODULE | Used by some verticals, not all |
| ListingFeature | BASE MODULE | Listing features/specs common |
| ListingPromotion | SHARED MODULE | Used by restaurants, retail |

### COMMERCE

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| ListingProduct | SHARED MODULE | Retail/restaurant realestate |
| ListingService | SHARED MODULE | Beauty/medical/professional services |
| ListingPackage | SHARED MODULE | Bundled offerings |
| ListingAppointment | SHARED MODULE | Booking businesses |
| ListingLead | BASE MODULE | Lead capture almost universal |

### VERTICAL-SPECIFIC

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| Property (ListingProject) | VERTICAL_MODULE | Real estate specific |
| VCard | VERTICAL_MODULE | Digital business cards |
| RestaurantMenu | VERTICAL_MODULE | Restaurant specific |
| ListingGuests | VERTICAL_MODULE | Events/guest lists |
| ListingCheckin | VERTICAL_MODULE | Loyalty/check-in |
| ClientFidelity | VERTICAL_MODULE | Loyalty programs |
| ListingBranding | VERTICAL_MODULE | Brand management |

### ANALYTICS / SEO

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| ListingSeoSetting | BASE MODULE | SEO is nearly universal |
| AnalyticsSetting | SHARED_MODULE | Some products need analytics |

### AI / CHATBOT

| Concept | Classification | Rationale |
|---------|---------------|-----------|
| AiContext | SHARED_MODULE | AI context for chatbot |
| ChatbotPreset | SHARED_MODULE | Presets per listing type |
| AiEmbedding | SHARED_MODULE | Vector embeddings |

---

## MINISITE THEME COUPLING ISSUE

**Current Problem:**
`MinisiteTheme::getByListingType()` contains hardcoded mapping:
```php
$mapping = [
    'barber_shop' => 'modern',
    'beauty_salon' => 'elegant',
    'wedding' => 'elegant',
    // ... 15+ vertical types
];
```

**Why this is wrong:**
- Theme should NOT know about verticals
- ListingType should NOT determine theme automatically
- Theme assignment should be explicit or product-specific

**Proposed Solution:**
Remove `getByListingType()` from MinisiteTheme.
Move theme-selection logic to product-specific configuration or the module that needs it.

---

## LISTING MODEL ISSUES

**Problem 1:** 30+ relationships that make Listing a "god model"
**Problem 2:** `forceDeleteWithRelations()` hardcodes all module tables
**Problem 3:** `syncAllModules()` uses ModuleDefinition from app/Models
**Problem 4:** `assignMinisiteTheme()` couples Listing to MinisiteTheme

**Thinning Plan:**
1. Keep: user, locations, modules, settings, is_active, is_published
2. Remove from Core: All HasMany to specific modules (products, services, etc.)
3. Move to modules: Each module adds its own relationship via its own model

---

## MODULE DEPENDENCY GRAPH (CURRENT)

```
Listings (Core)
├── Properties
├── VCards
├── Analytics
├── ListingRestaurantMenu
├── ListingProducts
├── ListingServices
├── ListingAppointments
├── ListingGallery
├── ListingHero
├── ListingAbout
├── ListingSeo
├── ListingContactForm
├── ListingFaqs
├── ListingFeatures
├── ListingPromotions
├── ListingReviews
├── ListingLeads
├── ListingLocations
├── ListingSocialMedia
├── ListingTasks
├── ListingClients
├── ListingTeamMembers
├── ListingPackages
├── ListingAiChatbot
├── ListingMinisite
├── ListingModules
├── ListingOfficeHours
├── ListingGuests
├── ListingCheckin
├── ClientFidelity
├── ListingBranding
└── Locations
```

---

## TARGET ARCHITECTURE

```
miniwebs-core
├── User, Role, Permission
├── Listing (THINNED)
├── ListingModule
├── ModuleDefinition
└── Basic Settings

BASE MODULES (any product may use)
├── ListingGallery
├── ListingHero
├── ListingAbout
├── ListingSeo
├── ListingContactForm
├── ListingFaqs
├── ListingFeatures
├── ListingSocialMedia
├── ListingLocation
├── ListingLead

SHARED MODULES (used by multiple verticals)
├── ListingProducts
├── ListingServices
├── ListingAppointments
├── ListingReviews
├── ListingPromotions
├── ListingPackages

VERTICAL MODULES
├── Properties (realestate)
├── VCards (digital cards)
├── RestaurantMenu (restaurant)
├── ListingGuests (events)
├── ClientFidelity (loyalty)
└── ListingBranding (branding)

PRODUCTS
├── miniwebs-saas (generic + base modules)
├── realestate-saas (miniwebs-core + Properties + ...)
├── restaurant-saas (miniwebs-core + RestaurantMenu + ...)
├── invitations-saas (miniwebs-core + ListingGuests + ...)
```

---

## NEXT STEPS

1. [ ] Remove vertical types from ListingType enum OR move to product-specific enum
2. [ ] Remove `assignMinisiteTheme()` from Listing boot
3. [ ] Remove `getByListingType()` from MinisiteTheme
4. [ ] Remove HasMany relationships from Listing to specific modules
5. [ ] Remove `forceDeleteWithRelations()` from Listing
6. [ ] Create product-specific theme mapping configs
7. [ ] Document the thin Listing contract
