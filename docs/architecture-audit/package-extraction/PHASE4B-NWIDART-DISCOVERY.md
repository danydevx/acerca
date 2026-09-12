# PHASE 4B — NWIDART DISCOVERY

## Configuration Used

```php
// config/modules.php
'scan' => [
    'enabled' => true,
    'paths' => [
        base_path('vendor/*/*'),
        base_path('packages/*/*/Modules/*'),
    ],
],
```

## Discovery Flow

1. **Module scan paths configured**
   - vendor/*/* (packages)
   - packages/*/*/Modules/* (local development)

2. **Path repository creates symlink**
   - vendor/miniwebs/shared -> packages/miniwebs/shared

3. **Nwidart finds module at**
   - packages/miniwebs/shared/Modules/ListingOfficeHours/module.json

4. **Provider registered**
   - From composer.json extra.laravel.providers

## No Duplicate Registration

```
# Before extraction
Modules/ListingOfficeHours (local) + miniwebs/shared (package) = CONFLICT

# After extraction
Modules/ListingOfficeHours (REMOVED)
miniwebs/shared/Modules/ListingOfficeHours (PACKAGE ONLY) = SINGLETON
```

## Verification

```bash
php artisan module:list | grep office
# [Enabled] ListingOfficeHours  packages/miniwebs/shared/Modules/ListingOfficeHours [0]
```

Only ONE entry. No duplicates.

## Runtime Module Path

```
vendor/miniwebs/shared/Modules/ListingOfficeHours
    ↓ symlink
packages/miniwebs/shared/Modules/ListingOfficeHours
```

The module code lives in packages/ during development, symlinked via vendor/ for runtime.
