# PHASE 3 — PRODUCT MATRIX

**Date:** 2026-09-10
**Goal:** Document which modules are required/optional for each product

---

## PRODUCT DEFINITIONS

### MiniWebs (Generic SaaS)
Any business type - the base product with common features enabled by default.

### Invitations-saas
Event planning businesses - weddings, birthdays, baby showers, corporate events.

### RealEstate-saas
Real estate agencies, brokers, property developers.

### Restaurant-saas
Restaurants, bars, cafes, food service businesses.

---

## MODULE USAGE MATRIX

| Module | MiniWebs | Invitations | RealEstate | Restaurant | Classification |
|--------|----------|-------------|------------|------------|----------------|
| **CORE** |
| Listings | ✓ | ✓ | ✓ | ✓ | CORE |
| ListingModule | ✓ | ✓ | ✓ | ✓ | CORE |
| User/Auth | ✓ | ✓ | ✓ | ✓ | CORE |
| Roles/Permissions | ✓ | ✓ | ✓ | ✓ | CORE |
| **INFRASTRUCTURE** |
| Locations (geo data) | ✓ | ✓ | ✓ | ✓ | BASE |
| Analytics | O | O | O | O | SHARED |
| ListingAiChatbot | O | O | O | O | SHARED |
| **BASE CONTENT** |
| ListingGallery | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingHero | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingAbout | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingSeo | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingContactForm | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingFaqs | O | O | O | O | BASE |
| ListingFeatures | O | O | O | O | BASE |
| ListingSocialMedia | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingLocations | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingLeads | ✓ | ✓ | ✓ | ✓ | BASE |
| ListingMinisite | ✓ | O | O | O | BASE |
| ListingOfficeHours | ✓ | O | O | ✓ | BASE |
| ListingBranding | O | O | O | O | VERTICAL |
| **SHARED COMMERCE** |
| ListingProducts | O | O | O | ✓ | SHARED |
| ListingServices | O | O | ✓ | ✓ | SHARED |
| ListingAppointments | O | O | O | ✓ | SHARED |
| ListingPackages | O | O | O | ✓ | SHARED |
| ListingPromotions | O | O | O | ✓ | SHARED |
| ListingReviews | O | O | O | ✓ | SHARED |
| **VERTICAL** |
| Properties (ListingProjects) | O | ✗ | ✓ | ✗ | VERTICAL |
| VCards | O | ✗ | ✗ | ✗ | VERTICAL |
| RestaurantMenu | O | ✗ | ✗ | ✓ | VERTICAL |
| ListingGuests | O | ✓ | ✗ | ✗ | VERTICAL |
| ClientFidelity | O | O | O | O | VERTICAL |
| ListingCheckin | O | O | O | O | VERTICAL |
| ListingTasks | O | O | O | O | SHARED |

---

## SYMBOLS

- **✓** = Required/Enabled by default
- **O** = Optional (can be enabled)
- **✗** = Not applicable (product doesn't need it)

---

## COMPOSITION DETAILS

### MiniWebs (Generic)
```
Base: Listings + Base Content modules
Defaults: Gallery, Hero, About, Seo, ContactForm, SocialMedia, Locations, Leads
Optional: Faqs, Features, Appointments, Products, Services, etc.
Theme: Generic or vertical-specific
```

### Invitations-saas
```
Base: Listings + Events verticals
Required: ListingGuests (guest list management)
Optional: ListingGallery (event photos), ContactForm (RSVP), Leads
Default theme: Elegant/Festive
Excludes: Properties, RestaurantMenu, Appointments (unless workshop)
```

### RealEstate-saas
```
Base: Listings + Real Estate verticals
Required: Properties (ListingProjects), Services (property types)
Optional: Gallery, Leads, Appointments (property viewings), Reviews
Default theme: Professional/Modern
Excludes: RestaurantMenu, VCards, ListingGuests
```

### Restaurant-saas
```
Base: Listings + Food service
Required: RestaurantMenu, Products (menu items), Orders
Optional: Appointments (reservations), Reviews, Promotions, Packages
Default theme: Modern/Friendly
Excludes: Properties, VCards, ListingGuests
```

---

## MODULE COUNT BY PRODUCT

| Product | Required | Optional | Excluded |
|---------|----------|----------|----------|
| MiniWebs | 12 | 15 | 4 |
| Invitations | 11 | 6 | 14 |
| RealEstate | 13 | 8 | 10 |
| Restaurant | 15 | 8 | 8 |

---

## THEME REQUIREMENTS BY PRODUCT

| Product | Theme Approach |
|---------|---------------|
| MiniWebs | Generic modern theme, user can select |
| Invitations | Event-specific themes (wedding, birthday, corporate) |
| RealEstate | Property-focused themes (grid, map views) |
| Restaurant | Food-centric themes (menu-first, reservation-focused) |

**Current Problem:** MinisiteTheme::getByListingType() hardcodes these mappings.
**Solution:** Move theme mapping to product-specific configuration.

---

## CROSS-PRODUCT SHARED MODULES

These modules can be extracted as shared packages:

1. **miniwebs/media** - ListingGallery + MediaFile handling
2. **miniwebs/content** - Hero, About, Features, Faqs
3. **miniwebs/seo** - SEO settings + social meta
4. **miniwebs/booking** - Appointments + availability
5. **miniwebs/ecommerce** - Products + Orders + Cart
6. **miniwebs/reviews** - Review system

---

## EXTRACTION PRIORITY

### Priority 1 (Core separation)
1. Extract Listings as miniwebs/core
2. Extract ListingModules as miniwebs/module-system

### Priority 2 (Base modules)
3. Extract ListingGallery as miniwebs/gallery
4. Extract ListingHero/About as miniwebs/content
5. Extract ListingSeo as miniwebs/seo

### Priority 3 (Shared modules)
6. Extract ListingProducts/Services as miniwebs/catalog
7. Extract ListingAppointments as miniwebs/booking

### Priority 4 (Vertical modules)
8. Extract Properties as miniwebs/realestate
9. Extract RestaurantMenu as miniwebs/restaurant
10. Extract VCards as miniwebs/vcards
