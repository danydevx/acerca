# PHASE 3 — MODULE DEPENDENCIES

**Date:** 2026-09-10

---

## MODULE CLASSIFICATION

### CORE (Infrastructure)
```
Modules/Listings
├── Models/Listing (THINNED - should have 3 relationships max)
├── Enums/ListingType (needs refactor - currently has verticals)
└── Models/ListingModule
```

### BASE MODULES (Used by most/all products)
```
ListingGallery      - Image galleries
ListingHero         - Hero sections
ListingAbout        - About sections
ListingSeo          - SEO settings
ListingContactForm  - Contact forms
ListingFaqs         - FAQ management
ListingFeatures     - Feature lists
ListingSocialMedia  - Social network links
ListingLocations    - Business locations
ListingLeads        - Lead capture
ListingMinisite     - Minisite page builder
ListingModules      - Module enablement system
ListingOfficeHours  - Business hours
```

### SHARED MODULES (Used by multiple verticals)
```
ListingProducts      - Product catalog
ListingServices      - Service listings
ListingAppointments  - Appointment booking
ListingReviews       - Reviews/ratings
ListingPromotions    - Promotions/coupons
ListingPackages      - Package/bundle offerings
```

### VERTICAL MODULES (Single product line)
```
Properties          - Real estate listings (ListingProjects)
VCards             - Digital business cards
RestaurantMenu     - Restaurant menu management
ListingGuests      - Event guest list management
ClientFidelity     - Loyalty/check-in programs
ListingBranding     - Brand customization
ListingCheckin     - Check-in/loyalty
```

### INFRASTRUCTURE MODULES
```
Locations          - Geographic data (countries, states, municipalities)
Analytics          - Analytics settings
ListingAiChatbot   - AI chatbot
```

---

## DEPENDENCY GRAPH

```
Core (Listings)
├── [CORE] ListingModule
├── [BASE] ListingLocations ──────────────
├── [BASE] ListingLeads ◄────────────────┼──┐
├── [BASE] ListingGallery ◄──────────────┼──┼──┐
├── [BASE] ListingHero ◄─────────────────┼──┼──┼──┐
├── [BASE] ListingAbout ◄────────────────┼──┼──┼──┼──┐
├── [BASE] ListingSeo ◄──────────────────┼──┼──┼──┼──┼──┐
├── [BASE] ListingContactForm ◄──────────┼──┼──┼──┼──┼──┼──┐
├── [BASE] ListingFaqs ◄─────────────────┼──┼──┼──┼──┼──┼──┼──┐
├── [BASE] ListingFeatures ◄─────────────┼──┼──┼──┼──┼──┼──┼──┼──┐
├── [BASE] ListingSocialMedia ◄──────────┼──┼──┼──┼──┼──┼──┼──┼──┼──┐
├── [BASE] ListingMinisite ◄─────────────┼──┼──┼──┼──┼──┼──┼──┼──┼──┼──┐
├── [BASE] ListingOfficeHours ◄───────────┼──┼──┼──┼──┼──┼──┼──┼──┼──┼──┐
│                                      │  │  │  │  │  │  │  │  │  │
├── [SHARED] ListingProducts ◄──────────┘  │  │  │  │  │  │  │  │  │  │
├── [SHARED] ListingServices ◄────────────┘  │  │  │  │  │  │  │  │  │
├── [SHARED] ListingAppointments ◄──────────┘  │  │  │  │  │  │  │  │
│    └── depends on: ListingServices ◄────────┘  │  │  │  │  │  │  │
├── [SHARED] ListingReviews ◄──────────────────┘  │  │  │  │  │  │
├── [SHARED] ListingPromotions ◄─────────────────┘  │  │  │  │  │
├── [SHARED] ListingPackages ◄─────────────────────┘  │  │  │  │
│                                                    │  │  │  │
├── [VERTICAL] Properties ◄──────────────────────────┘  │  │  │
│    └── uses: ListingProjects ─────────────────────────┘  │  │
├── [VERTICAL] VCards ◄──────────────────────────────────┘  │
├── [VERTICAL] RestaurantMenu ◄─────────────────────────────┘
│    └── optional deps: ListingProducts, Orders
├── [VERTICAL] ListingGuests ◄──────────────────────────────┘
├── [VERTICAL] ClientFidelity ◄─────────────────────────────┘
├── [VERTICAL] ListingBranding ◄─────────────────────────────┘
└── [VERTICAL] ListingCheckin ◄─────────────────────────────┘
```

---

## CROSS-MODULE DEPENDENCIES

### ListingProducts → (none)
Products are standalone. Can exist without Appointments, Services, etc.

### ListingServices → (none)
Services are standalone. Can exist without Products.

### ListingAppointments → ListingServices
Appointments often reference Services.
**Direction:** Appointments depends on Services
**Is cycle?** No

### ListingRestaurantMenu → ListingProducts, Orders
Restaurant menu products may be linked to Products module.
**Direction:** Restaurant depends on Products
**Is cycle?** No

### Properties → ListingProjects
Properties module uses ListingProjects model.
**Direction:** Properties depends on Listings (Core)
**Is cycle?** No

### VCards → (none)
VCards is standalone vertical.
**Direction:** VCards depends on Core
**Is cycle?** No

### ClientFidelity → ListingClients
Loyalty program tracks clients.
**Direction:** ClientFidelity depends on ListingClients
**Is cycle?** No

### ListingMinisite → (none - but uses many modules)
Minisite is a page builder that references many modules.
**This is acceptable** - it aggregates, doesn't create coupling.

---

## POTENTIAL CYCLES (NONE DETECTED)

No bidirectional dependencies found:
- No Products ↔ Orders cycle
- No Services ↔ Appointments cycle (单向依赖)

---

## MODULE SERVICE PROVIDER STATUS

| Module | Registers Policies | Has own routes | Status |
|--------|-------------------|----------------|--------|
| ListingGallery | ✗ | ✗ | Needs update |
| ListingHero | ✗ | ✗ | Needs update |
| ListingAbout | ✗ | ✗ | Needs update |
| ListingSeo | ✗ | ✗ | Needs update |
| ListingContactForm | ✗ | ✗ | Needs update |
| ListingFaqs | ✗ | ✗ | Needs update |
| ListingFeatures | ✗ | ✗ | Needs update |
| ListingSocialMedia | ✗ | ✗ | Needs update |
| ListingLocations | ✗ | ✗ | Needs update |
| ListingLeads | ✗ | ✗ | Needs update |
| ListingMinisite | ✗ | ✗ | Needs update |
| ListingOfficeHours | ✗ | ✗ | Needs update |
| ListingProducts | ✓ (moved in FASE1) | ✗ | OK |
| ListingServices | ✓ (moved in FASE1) | ✗ | OK |
| ListingAppointments | ✓ (moved in FASE1) | ✗ | OK |
| ListingPromotions | ✗ | ✗ | Needs update |
| ListingReviews | ✗ | ✗ | Needs update |
| ListingPackages | ✗ | ✗ | Needs update |
| Properties | ✓ (moved in FASE1) | ✗ | OK |
| VCards | ✓ (moved in FASE1) | ✗ | OK |
| Analytics | ✓ (moved in FASE1) | ✗ | OK |
| RestaurantMenu | ✗ | ✓ (has own routes) | Partial |
| ListingAiChatbot | ✗ | ✓ (ai_chatbot.php) | Partial |

---

## MINIMAL CORE BOOT REQUIREMENTS

To boot with ONLY Core (no optional modules):

**Required modules:**
- Modules/Listings (the Core listing system)
- Modules/ListingModules (module enablement)

**Implicit dependencies:**
- User, Role, Permission (handled by Laravel/Spatie)
- Auth (Laravel Fortify/SPatie permission)

**Can be disabled:**
- All other modules are truly optional

---

## RECOMMENDATIONS

1. **Each module should be self-contained:**
   - Register its own policies in ServiceProvider
   - Have its own routes file
   - Not rely on AppServiceProvider for registrations

2. **Use Events for cross-module communication:**
   - ListingDeleted → modules clean up
   - ListingModuleEnabled → module initializes

3. **Avoid bidirectional dependencies:**
   - If A→B and B→A, refactor to use events

4. **Consider module groups:**
   - Content modules (Gallery, Hero, About, Seo, Faqs, Features, Social)
   - Commerce modules (Products, Services, Appointments, Packages, Promotions)
   - Vertical modules (Properties, VCards, RestaurantMenu, Guests)
