# PHASE 4A — FINAL ARCHITECTURE

---

## CURRENT MODULES

| Metric | Count |
|--------|-------|
| Total | 35 |
| CORE_REQUIRED | 2 |
| BASE | 12 |
| SHARED | 10 |
| VERTICAL | 7 |
| OPTIONAL | 5 |

---

## PROPOSED PACKAGES

| Metric | Count |
|--------|-------|
| Total | 20 packages |
| Core | 1 |
| Base/Minisite | 1 |
| Domain | 6 |
| Shared | 8 |
| Optional | 5 |

### Package List

| Package | Modules | Type |
|---------|---------|------|
| miniwebs/core | Listings, ListingModules, ListingMinisite | CORE |
| miniwebs/minisite | About, Branding, ContactForm, Faqs, Hero, Seo, SocialMedia | BASE |
| miniwebs/media | Gallery | BASE |
| miniwebs/locations | Locations, ListingLocations | BASE |
| miniwebs/crm | Leads, Clients | SHARED |
| miniwebs/catalog | Products, Services | SHARED |
| miniwebs/appointments | Appointments | SHARED |
| miniwebs/guests | Guests | SHARED |
| miniwebs/packages | Packages | SHARED |
| miniwebs/marketing | Promotions | SHARED |
| miniwebs/reviews | Reviews | SHARED |
| miniwebs/team | TeamMembers | SHARED |
| miniwebs/shared | OfficeHours | SHARED |
| miniwebs/orders | Orders | VERTICAL |
| miniwebs/properties | Properties | VERTICAL |
| miniwebs/vcards | VCards | VERTICAL |
| miniwebs/restaurant | RestaurantMenu | VERTICAL |
| miniwebs/fidelity | ClientFidelity | VERTICAL |
| miniwebs/projects | Projects | VERTICAL |
| miniwebs/analytics | Analytics | OPTIONAL |
| miniwebs/ai-chatbot | AiChatbot | OPTIONAL |
| miniwebs/checkin | Checkin | OPTIONAL |
| miniwebs/features | Features | OPTIONAL |
| miniwebs/tasks | Tasks | OPTIONAL |

**Note**: 5 optional packages could also be grouped into `miniwebs/extras` meta-package.

---

## CORE PACKAGE

### Contains
- Listings (business listing core model)
- ListingModules (module enable/disable management)
- ListingMinisite (base minisite composition)

### Dependencies
- None (base layer)

### Key Files
- `Modules/Listings/app/Models/Listing.php`
- `Modules/ListingModules/app/Services/ModuleService.php`
- All core migrations in `database/migrations/`

### Architectural Note
The current `Listings` model imports 15 other modules, creating 40 circular dependencies. After extraction, these circular deps become package-internal and are resolved via event-driven architecture or interfaces.

---

## BASE PACKAGES

### miniwebs/minisite
Minisite rendering components (about, hero, contact form, FAQs, social media, branding, SEO).

### miniwebs/media
Image gallery for listings.

### miniwebs/locations
Geographic data (countries, states, municipalities) and listing location management.

---

## SHARED PACKAGES

Packages that multiple product types can use:

| Package | Used By |
|---------|---------|
| miniwebs/catalog | miniwebs-saas, realestate-saas |
| miniwebs/crm | miniwebs-saas, realestate-saas |
| miniwebs/appointments | miniwebs-saas, invitations-saas |
| miniwebs/guests | invitations-saas |
| miniwebs/reviews | miniwebs-saas |
| miniwebs/team | miniwebs-saas |
| miniwebs/packages | miniwebs-saas |
| miniwebs/marketing | miniwebs-saas |

---

## VERTICAL PACKAGES

Product-specific packages:

| Package | Product |
|---------|---------|
| miniwebs/properties | realestate-saas |
| miniwebs/vcards | miniwebs-saas |
| miniwebs/restaurant | miniwebs-saas (restaurant type) |
| miniwebs/orders | miniwebs-saas |
| miniwebs/fidelity | miniwebs-saas |
| miniwebs/projects | miniwebs-saas |

---

## PRODUCT REPOSITORIES

### miniwebs-saas
```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/minisite": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/locations": "^1.0",
        "miniwebs/crm": "^1.0",
        "miniwebs/catalog": "^1.0",
        "miniwebs/appointments": "^1.0",
        "miniwebs/guests": "^1.0",
        "miniwebs/packages": "^1.0",
        "miniwebs/marketing": "^1.0",
        "miniwebs/reviews": "^1.0",
        "miniwebs/team": "^1.0",
        "miniwebs/orders": "^1.0",
        "miniwebs/properties": "^1.0",
        "miniwebs/vcards": "^1.0",
        "miniwebs/restaurant": "^1.0",
        "miniwebs/fidelity": "^1.0",
        "miniwebs/analytics": "^1.0",
        "miniwebs/ai-chatbot": "^1.0"
    }
}
```
**Routes**: ~963

### invitations-saas
```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/minisite": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/locations": "^1.0",
        "miniwebs/guests": "^1.0",
        "miniwebs/ai-chatbot": "^1.0"
    }
}
```
**Routes**: ~400

### realestate-saas
```json
{
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/minisite": "^1.0",
        "miniwebs/media": "^1.0",
        "miniwebs/locations": "^1.0",
        "miniwebs/crm": "^1.0",
        "miniwebs/properties": "^2.0",
        "miniwebs/ai-chatbot": "^1.0"
    }
}
```
**Routes**: ~500

---

## DEPENDENCY GRAPH

```
miniwebs/core (NO dependencies)
    ↑
    │
miniwebs/minisite ────┬──→ miniwebs/core
miniwebs/media ───────┼──→ miniwebs/core, miniwebs/locations
miniwebs/locations ───┘
    │
    ↓
miniwebs/crm ─────────→ miniwebs/core, miniwebs/locations
miniwebs/catalog ──────→ miniwebs/core, miniwebs/locations
miniwebs/appointments → miniwebs/core, miniwebs/locations, miniwebs/packages
miniwebs/guests ───────→ miniwebs/core
miniwebs/packages ─────→ miniwebs/core
miniwebs/marketing ─────→ miniwebs/core, miniwebs/locations
miniwebs/reviews ──────→ miniwebs/core
miniwebs/team ─────────→ miniwebs/core
miniwebs/shared ───────→ miniwebs/core
    │
    ↓
miniwebs/orders ───────→ miniwebs/core
miniwebs/properties ───→ miniwebs/core
miniwebs/vcards ───────→ miniwebs/core, miniwebs/ai-chatbot
miniwebs/restaurant ───→ miniwebs/core
miniwebs/fidelity ─────→ miniwebs/core
miniwebs/projects ─────→ miniwebs/core
    │
    ↓
miniwebs/analytics ────→ miniwebs/core, miniwebs/ai-chatbot
miniwebs/ai-chatbot ───→ miniwebs/core
miniwebs/checkin ──────→ miniwebs/core, miniwebs/guests
miniwebs/features ──────→ miniwebs/core, miniwebs/locations
miniwebs/tasks ─────────→ miniwebs/core
```

---

## CIRCULAR DEPENDENCIES

### In Current Codebase: 40

All through Listings module (god object).

### In Proposed Architecture: 0

Package boundaries break all cycles.

---

## NWIDART STRATEGY

**KEEP NWIDART INSIDE PACKAGES**

Reason:
- Migration cost to standard Laravel packages is too high (35 modules)
- Module enable/disable is valuable functionality already working
- nwidart is stable (v13+ supports Laravel 12)
- Each `miniwebs/*` package contains its own nwidart modules

---

## GIT REPOSITORIES

### Package Repositories (25)

```
github.com/danydevx/miniwebs-core
github.com/danydevx/miniwebs-minisite
github.com/danydevx/miniwebs-media
github.com/danydevx/miniwebs-locations
github.com/danydevx/miniwebs-crm
github.com/danydevx/miniwebs-catalog
github.com/danydevx/miniwebs-appointments
github.com/danydevx/miniwebs-guests
github.com/danydevx/miniwebs-packages
github.com/danydevx/miniwebs-marketing
github.com/danydevx/miniwebs-reviews
github.com/danydevx/miniwebs-team
github.com/danydevx/miniwebs-shared
github.com/danydevx/miniwebs-orders
github.com/danydevx/miniwebs-properties
github.com/danydevx/miniwebs-vcards
github.com/danydevx/miniwebs-restaurant
github.com/danydevx/miniwebs-fidelity
github.com/danydevx/miniwebs-projects
github.com/danydevx/miniwebs-analytics
github.com/danydevx/miniwebs-ai-chatbot
github.com/danydevx/miniwebs-checkin
github.com/danydevx/miniwebs-features
github.com/danydevx/miniwebs-tasks
github.com/danydevx/miniwebs-shared-extras (optional bundling)
```

### Product Repositories (3)

```
github.com/danydevx/miniwebs-saas
github.com/danydevx/invitations-saas
github.com/danydevx/realestate-saas
```

**Total: 28 repositories**

---

## PRIVATE PACKAGES

### Recommended: GitHub Private + VCS

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:danydevx/miniwebs-core.git"
        }
    ]
}
```

### Future: Private Packagist when team grows.

---

## VERSIONING STRATEGY

**Semantic Versioning (SemVer)**

| Change Type | Version |
|-------------|---------|
| Breaking API | MAJOR |
| New feature | MINOR |
| Bug fix | PATCH |

### Products use `^MAJOR.MINOR`

```json
"miniwebs/core": "^1.0",
"miniwebs/catalog": "^1.2"
```

### Products can pin older versions

```json
"miniwebs/catalog": "^1.2"  // Won't auto-update to 2.0
```

---

## LOCAL DEVELOPMENT

**Composer Path Repositories**

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../packages/*",
            "options": { "symlink": true }
        }
    ]
}
```

### Workflow

```bash
mkdir workspace && cd workspace
git clone packages/*/
git clone products/miniwebs-saas/
cd products/miniwebs-saas
composer config repo.path "../packages"
composer require miniwebs/catalog:*
# Changes in packages/miniwebs-catalog/* immediately reflected
```

---

## FRONTEND STRATEGY

### Current: NOT module-aware

- vite-module-loader.js is dead code
- Hardcoded entry points
- Single bundle for all

### Target: Module-aware builds

1. Integrate vite-module-loader.js into main vite.config.js
2. Enhance to discover assets from vendor/ packages
3. Product defines which packages to include
4. Per-product bundles

### Implementation

```javascript
// vite.config.js - enhanced
import { discoverModuleAssets } from './vite-module-loader.js'

const moduleAssets = discoverModuleAssets([
    'miniwebs/core',
    'miniwebs/catalog',
    'miniwebs/appointments'
])

export default defineConfig({
    build: {
        input: {
            app: './resources/js/app.js',
            ...moduleAssets.inputs
        }
    }
})
```

---

## DATABASE STRATEGY

| Aspect | Approach |
|--------|----------|
| Migrations | Package-owned, nwidart auto-discovers |
| FK between packages | Via shared core tables (listings) |
| Seeders | Package-owned, manually called |
| ModuleDefinition | Each package seeds its own modules |
| Config | Published or merged manually |
| Table naming | Keep current (backward compatible) |

---

## CI/CD

### Per Package
1. Push to `develop` branch
2. Run tests
3. Run static analysis
4. Create release tag

### Per Product
1. Update package dependency
2. Run tests
3. Build frontend
4. Deploy

---

## EXTRACTION ORDER

| Phase | Packages | Rationale |
|-------|----------|-----------|
| 4B | miniwebs/shared | Pilot - lowest risk |
| 4C | reviews, team, packages, marketing, shared | Simple shared |
| 4D | guests, crm, catalog | Complex shared |
| 4E | appointments | Calendar logic |
| 4F | locations | Geographic data |
| 4G | media | Gallery |
| 4H | minisite | Minisite components |
| 4I | orders, properties, vcards, restaurant, fidelity, projects | Vertical |
| 4J | analytics, ai-chatbot, checkin, features, tasks | Optional |
| 4K | core | Base layer |

---

## PILOT PACKAGE

**miniwebs/shared** (ListingOfficeHours)

### Why ListingOfficeHours?

| Criteria | Score |
|----------|-------|
| Dependencies | 0 |
| Complexity | Lowest |
| Migrations | 0 |
| Frontend | None |
| Circular deps | 0 |
| Tests | Easiest |

### Why NOT a more complex module first?

Starting with a complex module increases risk of failure and delays learning.

---

## RISKS

| Risk | Mitigation |
|------|------------|
| Circular deps in core | Break via event-driven architecture or interfaces |
| vite-module-loader integration | Non-breaking - keep current bundle |
| nwidart in packages | Already working, just relocate |
| Version conflicts between products | Pin versions, test before upgrade |
| Module enable/disable across packages | Requires ModuleDefinition in core |

---

## RECOMMENDED NEXT PHASE

**FASE 4B — PILOT PACKAGE EXTRACTION**

Extract `miniwebs/shared` (ListingOfficeHours) as the first real package.

---

## STATUS

```
PACKAGE EXTRACTION ARCHITECTURE DEFINED
```
