# FASE 4E — MINISITE BOUNDARY

## Minisite Stack Modules

```
ListingMinisite       — Minisite configuration and sections
ListingAbout          — About section content
ListingBranding       — Branding settings (colors, fonts, logo)
ListingContactForm    — Contact form configuration
ListingFaqs           — FAQ content and categories
ListingFeatures       — Feature listings
ListingGallery        — Image gallery
ListingHero           — Hero section
ListingSeo            — SEO settings
ListingSocialMedia     — Social media links/feeds
MinisiteThemes        — Theme management (only 1 model)
```

## Updated Dependency Analysis

### Dead Code Discovery

**ListingMinisite has an UNUSED import:**
```php
use Modules\ListingPackages\Models\ListingPackage; // IMPORTED BUT NEVER USED
```

This means the supposed blocking dependency on `miniwebs/packages` is **NOT REAL**.

### Actual Dependencies

| Module | External Dependencies | Blocking? |
|--------|----------------------|-----------|
| ListingMinisite | Properties (local), ListingContactForm (local) | PARTIAL |
| ListingAbout | Listings only | NO |
| ListingBranding | Listings only | NO |
| ListingContactForm | Listings, **ListingLeads** (PACKAGE) | YES |
| ListingFaqs | Listings only | NO |
| ListingFeatures | Listings, ListingLocations (local) | PARTIAL |
| ListingGallery | Listings, ListingLocations (local) | PARTIAL |
| ListingHero | Listings only | NO |
| ListingSeo | Listings only | NO |
| ListingSocialMedia | Listings only | NO |
| MinisiteThemes | Listings only | NO |

### Real Blocking Dependencies

```
ListingContactForm → miniwebs/crm (ListingLeads)
```

If we extract ListingContactForm alone, it would depend on ListingLeads which is in a package.

**Option:** Extract both `ListingContactForm` AND `ListingLeads` together.

## Proposed: miniwebs/minisite

### Package Contents

```
miniwebs/minisite
├── ListingMinisite
├── ListingAbout
├── ListingBranding
├── ListingHero
├── ListingSeo
├── ListingSocialMedia
├── ListingFaqs
├── MinisiteThemes
└── ListingFeatures
```

**Excluded for now:**
- ListingContactForm → depends on ListingLeads (must go with CRM)
- ListingGallery → depends on ListingLocations (should go with media/locations)
- ListingLocations → BASE, not minisite-specific

### miniwebs/minisite Composition

| Module | Routes | Migrations | Self-Contained |
|--------|--------|------------|----------------|
| ListingMinisite | 2 | 1 | NO (uses Properties) |
| ListingAbout | 2 | 1 | YES |
| ListingBranding | 2 | 1 | YES |
| ListingHero | 3 | 4 | YES |
| ListingSeo | 2 | 1 | YES |
| ListingSocialMedia | 2 | 1 | YES |
| ListingFaqs | 3 | 1 | YES |
| ListingFeatures | 4 | 2 | NO (uses ListingLocations) |
| MinisiteThemes | 0 | 0 | YES |

### Blocking Dependencies for miniwebs/minisite

1. **ListingMinisite → Properties**: This is a vertical dependency
   - Properties is vertical-specific
   - Could be extracted first OR minisite could be extracted without Properties support

2. **ListingFeatures → ListingLocations**: SHARED dependency
   - ListingLocations is BASE, not minisite
   - Could extract ListingLocations first

## Recommended Extraction Order for Minisite Stack

```
1. Extract Locations → miniwebs/locations (BASE)
2. Extract ListingGallery → miniwebs/media (SHARED)
3. Extract ListingContactForm + ListingLeads together → miniwebs/crm (already done)
4. Extract remaining minisite stack → miniwebs/minisite
```

## Alternative: Full Minisite Package

If we want ONE minisite package with all modules, we need to resolve:

1. Properties extraction first (vertical)
2. ListingLocations extraction first (base)
3. ListingContactForm must be with CRM or separated

This is complex. Better to split.

## Summary

```
miniwebs/minisite: 9 modules
├── Ready: ListingAbout, ListingBranding, ListingHero, ListingSeo, ListingSocialMedia, ListingFaqs, MinisiteThemes
├── Needs Locations first: ListingFeatures
└── Needs Properties + Locations + CRM first: ListingMinisite
```

**Decision:** Split into:
- `miniwebs/minisite` (core minisite without gallery/contact)
- `miniwebs/media` (gallery + locations)
- Keep contact form with CRM
