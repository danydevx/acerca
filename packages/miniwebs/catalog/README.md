# miniwebs/catalog

Catalog module for MiniWebs - Products and Services management.

## Modules

- **ListingProducts** - Product catalog management
- **ListingServices** - Service catalog management

## Version

0.1.0

## Installation

```json
{
    "repositories": [
        {"type": "path", "url": "packages/miniwebs/catalog", "options": {"symlink": true}}
    ],
    "require": {
        "miniwebs/catalog": "@dev"
    }
}
```

## Dependencies

- `miniwebs/core` (Listings) - future
- `miniwebs/locations` (ListingLocations) - future

## Routes

- Products: Admin, Member, API routes
- Services: Admin, Member, API routes

## Migrations

- Products: creates `listing_products`, `listing_product_categories`, `listing_product_images` tables
- Services: creates `listing_services`, `listing_service_categories`, `listing_service_images` tables

## Git Commands (when ready)

```bash
cd packages/miniwebs/catalog
git init && git add . && git commit -m "Initial extraction"
git remote add origin git@github.com:danydevx/miniwebs-catalog.git
git push -u origin main && git tag v0.1.0 && git push --tags
```
