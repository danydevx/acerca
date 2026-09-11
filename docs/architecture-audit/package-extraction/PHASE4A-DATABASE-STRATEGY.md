# PHASE 4A — DATABASE STRATEGY

## Current Migration Architecture

### Key Findings

1. **Flat migration naming**: No module prefix in table names
   - `2026_06_22_000009_create_listing_appointments_table.php`
   - Tables prefixed by convention, not enforcement

2. **Auto-discovery by nwidart**: Enabled in `config/modules.php`
   ```php
   'auto-discover' => [
       'migrations' => true,
   ]
   ```

3. **Product-specific migrations**: In `database/migrations/` (not in modules)
   - Core listings table
   - Users, roles, permissions
   - Billing, subscription tables

4. **Module migrations**: In `Modules/*/database/migrations/`
   - ~110+ migrations across 35 modules
   - Ranges from 0 (Analytics, ListingOfficeHours) to 26 (VCards)

5. **Seeders NOT auto-loaded**: Module seeders must be manually called

---

## Multi-Product Database Strategy

### Principle: Each Package Owns Its Schema

```
miniwebs/catalog package owns:
├── Modules/ListingProducts/database/migrations/
│   └── create_listing_products_table.php
│   └── create_listing_product_images_table.php
├── Modules/ListingServices/database/migrations/
│   └── create_listing_services_table.php

miniwebs/appointments package owns:
├── Modules/ListingAppointments/database/migrations/
│   └── create_listing_appointments_table.php
│   └── create_appointment_slots_table.php
```

When `composer install miniwebs/catalog`:
1. Package files installed to `vendor/miniwebs/catalog/`
2. `php artisan migrate` runs nwidart auto-discovery
3. Only migrations in `Modules/*/database/migrations/` are loaded
4. Product's own migrations also run

---

## Migration Execution Order

### Problem: Cross-package FK dependencies

```
ListingAppointments depends on ListingLocations
ListingProducts depends on ListingLocations
```

Both packages depend on `locations` but:
- They just use `listing_locations` table
- They don't depend on `ListingLocations` module code
- FK is to table, not to module

### Solution: Define schema dependencies

In package's composer.json:

```json
{
    "name": "miniwebs/appointments",
    "type": "metapackage",
    "require": {
        "miniwebs/core": "^1.0",
        "miniwebs/locations": "^1.0"
    },
    "extra": {
        "laravel": {
            "migrations": "database/migrations",
            "migration-dependencies": [
                "miniwebs/locations"
            ]
        }
    }
}
```

Laravel's migration runner handles this via timestamp ordering.

---

## Table Naming Convention

### Current (implicit)

Tables are prefixed by convention:
- `listing_appointments`
- `listing_gallery_images`
- `listing_products`
- `listing_services`

### Problem for extraction

Some tables have NO prefix:
- `properties` (Properties module)
- `vcards` (VCards module)
- `orders` (Orders module)

### Recommended: Explicit prefix policy

For new packages, enforce:
- All tables MUST use `listing_` prefix OR
- Module-specific prefix (`vcards_`, `properties_`)

This helps identify ownership without reading migration files.

**Note**: Changing existing tables is out of scope for extraction - maintain backward compatibility.

---

## Seeder Strategy

### Current State

- `ModuleDefinitionSeeder` seeds module metadata (which modules exist)
- `SystemModuleSeeder` seeds system modules
- Product seeders call module seeders manually

### Package delivers seeders

```bash
# miniwebs/catalog/composer.json
"autoload": {
    "classmap": [
        "database/seeders/"
    ]
}
```

### Seeder execution

```php
// Product's DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // Product-specific first
            ProductSetupSeeder::class,

            // Then packages in dependency order
            Miniwebs\CoreSeeder::class,
            Miniwebs\LocationsSeeder::class,
            Miniwebs\CatalogSeeder::class,
        ]);
    }
}
```

### Package seeders should be self-contained

```php
// miniwebs/catalog/database/seeders/CatalogSeeder.php
class CatalogSeeder extends Seeder
{
    public function run()
    {
        // Seed listing_products categories
        // Seed listing_services types
        // No external dependencies
    }
}
```

---

## ModuleDefinitionSeeder Handling

This seeder is CRITICAL - it tells the system which modules exist.

**Option A: Keep in miniwebs/core**

```php
// miniwebs/core/database/seeders/ModuleDefinitionSeeder.php
class ModuleDefinitionSeeder extends Seeder
{
    public function run()
    {
        // List all modules that exist in ANY package
        $modules = [
            ['name' => 'ListingProducts', 'package' => 'miniwebs/catalog'],
            ['name' => 'ListingServices', 'package' => 'miniwebs/catalog'],
            ['name' => 'ListingAppointments', 'package' => 'miniwebs/appointments'],
            // ... all 35 modules
        ];

        foreach ($modules as $module) {
            ModuleDefinition::updateOrCreate(
                ['name' => $module['name']],
                $module
            );
        }
    }
}
```

**Option B: Each package seeds its own modules**

```php
// miniwebs/catalog/database/seeders/CatalogModuleSeeder.php
class CatalogModuleSeeder extends Seeder
{
    public function run()
    {
        ModuleDefinition::updateOrCreate(
            ['name' => 'ListingProducts'],
            ['package' => 'miniwebs/catalog']
        );
        ModuleDefinition::updateOrCreate(
            ['name' => 'ListingServices'],
            ['package' => 'miniwebs/catalog']
        );
    }
}
```

**Recommendation**: Option B - packages own their module definitions.

---

## Config Strategy

### Per-package config

Packages can deliver config:

```
miniwebs/appointments/
├── config/
│   └── appointments.php
└── composer.json
```

Config auto-discovery not automatic - must be published or merged.

### Manual config merge

```php
// Product's AppServiceProvider
public function boot()
{
    // Merge package config
    $this->mergeConfigFrom(
        'vendor/miniwebs/appointments/config/appointments.php',
        'appointments'
    );
}
```

### Or publish on install

```json
// composer.json
"scripts": {
    "post-install-cmd": [
        "php artisan vendor:publish --tag=appointments-config --force"
    ]
}
```

---

## Summary

| Aspect | Strategy |
|--------|----------|
| Migrations | Package-owned, nwidart auto-discovers |
| FK between packages | Via shared core tables (listings) |
| Seeders | Package-owned, manually called |
| ModuleDefinition | Each package seeds its own modules |
| Config | Published or merged manually |
| Table naming | Keep current (backward compatible) |
