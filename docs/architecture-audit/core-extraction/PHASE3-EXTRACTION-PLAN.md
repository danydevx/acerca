# PHASE 3 — EXTRACTION PLAN

**Date:** 2026-09-10
**Goal:** Plan for physically extracting modules as separate packages (Phase 4+)

---

## EXTRACTION PRINCIPLES

1. **Extract incrementally** - one module at a time
2. **Maintain compatibility** - existing product must work
3. **Use Composer** - packages on Packagist or private repo
4. **Follow Laravel conventions** - service providers, config, migrations
5. **Version carefully** - semver for all packages

---

## PRE-REQUISITES (Before any extraction)

### 1. Clean Core boundaries
- [ ] Remove all module policies from AppServiceProvider
- [ ] Remove all module relationships from Listing
- [ ] Remove forceDeleteWithRelations() from Listing
- [ ] Move module controllers to module folders

### 2. Each module self-contained
- [ ] Module registers own policies in ServiceProvider
- [ ] Module has own routes file
- [ ] Module has composer.json with proper autoload

### 3. Dependency resolution
- [ ] Each module declares dependencies in composer.json
- [ ] No hardcoded class references across package boundaries

---

## EXTRACTION ORDER

### Phase 4a: Infrastructure First
```
1. miniwebs/core
   - Extract: Modules/Listings (Core Listing, ListingModule)
   - Dependencies: None
   - Priority: HIGHEST

2. miniwebs/locations
   - Extract: Modules/Locations (geo data)
   - Dependencies: miniwebs/core
   - Priority: HIGH (used everywhere)
```

### Phase 4b: Base Modules
```
3. miniwebs/media
   - Extract: ListingGallery + MediaFile handling
   - Dependencies: miniwebs/core
   - Priority: HIGH

4. miniwebs/content
   - Extract: ListingHero, ListingAbout, ListingFeatures, ListingFaqs
   - Dependencies: miniwebs/core, miniwebs/media
   - Priority: MEDIUM

5. miniwebs/seo
   - Extract: ListingSeo
   - Dependencies: miniwebs/core
   - Priority: MEDIUM
```

### Phase 4c: Commerce Modules
```
6. miniwebs/catalog
   - Extract: ListingProducts, ListingServices
   - Dependencies: miniwebs/core, miniwebs/media
   - Priority: MEDIUM

7. miniwebs/booking
   - Extract: ListingAppointments, ListingOfficeHours
   - Dependencies: miniwebs/core, miniwebs/catalog
   - Priority: MEDIUM
```

### Phase 4d: Shared Features
```
8. miniwebs/leads
   - Extract: ListingLeads, ListingContactForm
   - Dependencies: miniwebs/core
   - Priority: MEDIUM

9. miniwebs/reviews
   - Extract: ListingReviews
   - Dependencies: miniwebs/core
   - Priority: LOW-MEDIUM

10. miniwebs/promotions
    - Extract: ListingPromotions, ListingPackages
    - Dependencies: miniwebs/core
    - Priority: LOW-MEDIUM
```

### Phase 4e: Vertical Modules
```
11. miniwebs/realestate
    - Extract: Properties (ListingProjects)
    - Dependencies: miniwebs/core, miniwebs/media
    - Priority: LOW (product-specific)

12. miniwebs/restaurant
    - Extract: RestaurantMenu
    - Dependencies: miniwebs/core, miniwebs/catalog
    - Priority: LOW (product-specific)

13. miniwebs/vcards
    - Extract: VCards
    - Dependencies: miniwebs/core, miniwebs/media
    - Priority: LOW (product-specific)
```

---

## PACKAGE STRUCTURE TEMPLATE

```
miniwebs/[module-name]/
├── composer.json
├── src/
│   ├── Providers/
│   │   └── [Module]ServiceProvider.php
│   ├── Models/
│   │   └── [Module]Model.php
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Policies/
│   ├── Services/
│   └── database/
│       ├── migrations/
│       └── seeders/
├── routes/
│   └── web.php
├── resources/
│   └── js/
├── config/
│   └── config.php
└── module.json
```

---

## COMPOSER.JSON TEMPLATE

```json
{
    "name": "miniwebs/gallery",
    "description": "Gallery module for MiniWebs",
    "type": "laravel-module",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "miniwebs/core": "^1.0"
    },
    "autoload": {
        "psr-4": {
            "Modules\\ListingGallery\\": ""
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\ListingGallery\\Providers\\ListingGalleryServiceProvider"
            ]
        }
    }
}
```

---

## MIGRATION STRATEGY

### Step 1: Prepare module (while in monorepo)
- Ensure module has complete composer.json
- Test module can be loaded independently

### Step 2: Extract to private Git repo
```bash
mkdir miniwebs-gallery
git init
cp -r Modules/ListingGallery/* miniwebs-gallery/
git add .
git commit -m "Initial extraction"
git tag v1.0.0
```

### Step 3: Update main project
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/miniwebs/gallery"
        }
    ],
    "require": {
        "miniwebs/gallery": "^1.0"
    }
}
```

### Step 4: Remove from monorepo
```bash
rm -rf Modules/ListingGallery
composer remove miniwebs/gallery --working-dir=.
# Then add back via composer
composer require miniwebs/gallery:^1.0
```

---

## VERSIONING STRATEGY

| Package | Major | Minor | Patch | Notes |
|---------|-------|-------|-------|-------|
| miniwebs/core | 1.x | Active development | - | Stable once Listing is thin |
| miniwebs/media | 1.x | Active development | - | Gallery + Media |
| miniwebs/content | 1.x | Active development | - | Hero, About, Features, Faqs |
| miniwebs/seo | 1.x | Active development | - | SEO settings |
| miniwebs/catalog | 1.x | Active development | - | Products, Services |
| miniwebs/booking | 1.x | Active development | - | Appointments, OfficeHours |
| miniwebs/leads | 1.x | Active development | - | Leads, ContactForms |
| miniwebs/reviews | 1.x | Active development | - | Reviews |
| miniwebs/promotions | 1.x | Active development | - | Promotions, Packages |
| miniwebs/realestate | 1.x | Active development | - | Properties |
| miniwebs/restaurant | 1.x | Active development | - | RestaurantMenu |
| miniwebs/vcards | 1.x | Active development | - | VCards |

---

## RISKS AND MITIGATIONS

### Risk 1: Breaking changes during extraction
**Mitigation:** Extract one module at a time, maintain backward compatibility

### Risk 2: Circular dependencies
**Mitigation:** Audit dependencies before extraction; use events to break cycles

### Risk 3: Database migrations across packages
**Mitigation:** Each module ships its own migrations; main project runs all

### Risk 4: Version conflicts
**Mitigation:** Use strict semver; test all product compositions

### Risk 5: Losing shared code
**Mitigation:** Identify shared code before extraction; create miniwebs/shared package if needed

---

## PRODUCTS AND THEIR COMPOSITIONS

### Product: Generic MiniWebs (this repo)
```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/content": "^1.0",
        "miniwebs/seo": "^1.0",
        "miniwebs/catalog": "^1.0",
        "miniwebs/booking": "^1.0",
        "miniwebs/leads": "^1.0"
    }
}
```

### Product: RealEstate-saas
```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/seo": "^1.0",
        "miniwebs/leads": "^1.0",
        "miniwebs/booking": "^1.0",
        "miniwebs/realestate": "^1.0"
    }
}
```

### Product: Restaurant-saas
```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/content": "^1.0",
        "miniwebs/seo": "^1.0",
        "miniwebs/catalog": "^1.0",
        "miniwebs/booking": "^1.0",
        "miniwebs/reviews": "^1.0",
        "miniwebs/promotions": "^1.0",
        "miniwebs/restaurant": "^1.0"
    }
}
```

---

## NOT USING GIT SUBMODULES

Git submodules are NOT recommended because:
- They couple repo lifecycle
- Hard to version independently
- Complicate CI/CD
- Poor Composer integration

Use Composer packages instead:
- Private Packagist for private packages
- Packagist for public packages
- Clear version constraints

---

## NEXT STEPS AFTER PHASE 3

1. **Phase 3 cleanup** (current) - Clean boundaries, remove hardcoded deps
2. **Phase 4 extraction** - Extract packages one by one
3. **Phase 5 productization** - Create product repos with specific module sets

---

## ESTIMATED WORK

| Phase | Task | Effort |
|-------|------|--------|
| Phase 3 | AppServiceProvider cleanup | 1-2 hours |
| Phase 3 | Listing thinning (remove 29 relations) | 4-6 hours |
| Phase 3 | forceDeleteWithRelations → events | 2-3 hours |
| Phase 3 | Module ServiceProvider updates | 3-4 hours |
| Phase 4a | Extract miniwebs/core | 2-3 hours |
| Phase 4b | Extract base modules (3 packages) | 4-5 hours |
| Phase 4c | Extract commerce modules | 4-5 hours |
| Phase 4d | Extract shared modules | 3-4 hours |
| Phase 4e | Extract vertical modules | 3-4 hours |
