# PHASE 4A — COMPOSER STRATEGY

## Decision: KEEP NWIDART INSIDE PACKAGES

**Recommendation**: Modules should continue using nwidart/laravel-modules internally.

---

## Comparison

### Option A: Keep nwidart inside packages

| Aspect | Impact |
|--------|--------|
| Migration cost | Low - modules already use nwidart |
| Developer experience | Familiar - same module structure |
| Autoload | Composer's PSR-4 + nwidart namespaces |
| Providers | Nwidart auto-discovers providers |
| Routes | Nwidart auto-discovers routes |
| Assets | Nwidart publishes to public/ |
| Module enable/disable | Already implemented in ListingModules |
| CI/CD | Standard composer install |
| Future maintenance | nwidart is maintained, stable |

### Option B: Migrate to standard Laravel packages

| Aspect | Impact |
|--------|--------|
| Migration cost | HIGH - rewrite all module bootstrapping |
| Developer experience | Learning curve for package structure |
| Autoload | Only Composer's PSR-4 |
| Providers | Manual registration in app.php |
| Routes | Manual Route::group() for each package |
| Assets | Manual publish command needed |
| Module enable/disable | Must build custom solution |
| CI/CD | Standard composer install |
| Future maintenance | Simpler but lose module isolation |

---

## Rationale

1. **Migration cost is too high**: 35 modules would all need rewriting
2. **Module enable/disable is valuable**: Already working, would need custom impl
3. **nwidart is stable**: v13+ supports Laravel 12, well maintained
4. **Package-internal nwidart**: Each package can have its own modules folder

### How it works:

```
packages/miniwebs/catalog/
├── composer.json
├── src/
│   ├── Providers/
│   ├── Models/
│   └── Services/
├── Modules/
│   ├── ListingProducts/
│   └── ListingServices/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── assets/
└── routes/
    ├── admin.php
    ├── member.php
    ├── api.php
    └── web.php
```

Each `miniwebs/*` package contains its own nwidart modules.

The main product repository would install multiple `miniwebs/*` packages.

---

## Composer.json Structure for Packages

### Example: miniwebs/catalog

```json
{
    "name": "miniwebs/catalog",
    "description": "Products and Services for MiniWebs",
    "type": "metapackage",
    "license": "proprietary",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^13.0",
        "miniwebs/core": "^1.0"
    },
    "autoload": {
        "psr-4": {
            "Modules\\ListingProducts\\": "Modules/ListingProducts/",
            "Modules\\ListingServices\\": "Modules/ListingServices/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\ListingProducts\\Providers\\ListingProductsServiceProvider",
                "Modules\\ListingServices\\Providers\\ListingServicesServiceProvider"
            ]
        }
    }
}
```

---

## Module Enable/Disable in Composer World

When a package is installed via Composer:

1. Module files are in `vendor/miniwebs/catalog/Modules/`
2. Nwidart's auto-discovery finds them
3. `listing_modules` table controls per-listing enablement
4. Module is "installed" when composer package is present
5. Module is "enabled" when listing has it in `listing_modules`

**Separation maintained**:
- Package installed = feature available on platform
- Module enabled = specific listing can use feature

---

## Dependency Resolution

```
Product (miniwebs-saas)
├── requires miniwebs/core
├── requires miniwebs/minisite
├── requires miniwebs/catalog
└── requires miniwebs/appointments

Each miniwebs/* package declares its own dependencies
```

Composer handles dependency resolution automatically.

---

## Version Pinning Per Product

Products can pin different versions:

```json
// miniwebs-saas composer.json
"miniwebs/core": "^1.0",
"miniwebs/catalog": "^1.2",  // stays on 1.2

// realestate-saas composer.json
"miniwebs/core": "^1.0",
"miniwebs/catalog": "^1.3",  // uses newer version
"miniwebs/properties": "^2.0"  // realestate-specific
```

This satisfies the requirement: "remaincer en una versión anterior de un paquete cuando sea necesario"
