# PHASE 4B — PACKAGE STRUCTURE

## Package Location

```
packages/miniwebs/shared/
├── composer.json
├── README.md
├── .gitignore
└── Modules/
    └── ListingOfficeHours/
        ├── module.json
        ├── composer.json
        ├── app/
        │   ├── Http/
        │   │   └── Controllers/
        │   │       ├── Member/
        │   │       │   └── ScheduleController.php
        │   │       └── Admin/
        │   │           └── Api/
        │   │               └── OfficeHoursApiController.php
        │   ├── Models/
        │   │   └── ListingSchedule.php
        │   ├── Policies/
        │   │   └── ListingSchedulePolicy.php
        │   └── Providers/
        │       ├── ListingOfficeHoursServiceProvider.php
        │       └── RouteServiceProvider.php
        ├── routes/
        │   ├── web.php
        │   └── admin_api.php
        └── database/
            └── migrations/  (empty)
```

## Composer.json

```json
{
    "name": "miniwebs/shared",
    "description": "Shared utilities for MiniWebs - Office Hours module",
    "type": "library",
    "license": "proprietary",
    "require": {
        "php": "^8.2"
    },
    "autoload": {
        "psr-4": {
            "Modules\\ListingOfficeHours\\": "Modules/ListingOfficeHours/app/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\ListingOfficeHours\\Providers\\ListingOfficeHoursServiceProvider"
            ]
        }
    }
}
```

## Key Design Decisions

1. **Type: library** - Not metapackage, allows proper symlinking
2. **Namespace preserved** - `Modules\ListingOfficeHours\` kept as-is
3. **No external dependencies** - Package doesn't require miniwebs/core explicitly (resolved by product)
4. **Nwidart structure maintained** - module.json, providers, routes unchanged

## NWIDART Discovery

The module is discovered via nwidart's scan feature:

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

Module discovered at: `packages/miniwebs/shared/Modules/ListingOfficeHours`
